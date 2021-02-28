<?php
if (!(php_sapi_name() === 'cli'))
	die("Not allowed");

define('WP_USE_THEMES', true);
/** Loads the WordPress Environment and Template */
if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	require_once( dirname(__FILE__) . '/../wp-load.php' );

	//wp();

}

$category_ids = get_option('scoop_topic_ids');
$category_ids_array = explode("\n", $category_ids);
$category_ids = array();
foreach($category_ids_array as $val) {
	 $val_tmp = trim($val);
	 if (preg_match("/^([0-9]+)$/", $val_tmp)) {
	 	$category_ids[] = $val_tmp;
	 }
}

$fetch_count = get_option('scoop_fetch_count');
if (empty($fetch_count) || !is_numeric($fetch_count) || $fetch_count < 3 || $fetch_count > 200)
{
	$fetch_count = 30;
}

// Start the session
//session_start();
//header("Content-Type:text/plain");

// Include needed files
include_once(__DIR__ . "/ScoopIt.php");
include_once(__DIR__ . "/config.php");
require_once __DIR__ . "/../wp-config.php";

if (!defined('DB_HOST'))
   die('Database not defined.');

$pdo_options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
$database = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $pdo_options);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$database->beginTransaction();
// Delete the categories that are removed fromt he system.
$sql = "DELETE FROM wp_scoop_categories WHERE id NOT IN (" . implode(',', $category_ids) . ")";
$stmt = $database->query($sql);
// Delete any not if the category has been removed.
$sql = "DELETE FROM wp_scoop_nodes WHERE category_id NOT IN (" . implode(',', $category_ids) . ")";
$database->query($sql);

$stmt = $database->prepare("SELECT * FROM wp_scoop_categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$current_ids = array();
foreach ($categories as $cat) {
	$current_ids[] = $cat['id'];
}

// Add categoris if added newly
foreach ($category_ids as $id) {
	if (!in_array($id, $current_ids)) {
		$sql = "INSERT INTO wp_scoop_categories (id) VALUES(" . $id . ")";
		$database->query($sql);
	}
}

$database->commit();

// Construct scoop var, which handle API communication
$scoop = new ScoopIt(new SessionTokenStore(), $localUrl, $consumerKey, $consumerSecret);

// Login in, if not previously logged in, it will issue a redirection
// to scoop.it servers to log the user in. 
// You can omit the call below if you want to use the api in "anonymous"
// mode.
//$scoop->logout();
//$scoop->login();

// Get the current user
//$currentUser = $scoop->profile(null)->user;
// Display the current user name
//echo "<h1>Hello ".$currentUser->name."</h1>";

//$topics = $scoop->get
$stmt = $database->prepare("SELECT * FROM wp_scoop_categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // called in anonymous mode).
foreach($categories as $cat) {
	if ($cat['id']) {
		$date = new DateTime();

		try {
			$topic = $scoop->topic($cat['id'], 30, 0, 1, (strtotime($cat['last_access']) * 1000));
		}
		catch(Exception $ex) {
			echo "ERROR : " . $ex->getMessage() . '<br />';
			continue;
		}

		if ($topic) {
			$pinnedPostId = $topic->pinnedPost->id;
			$params = array(
				'last_cursor' 		=> array(0, PDO::PARAM_INT),
				'scoopShortUrl' 	=> array($topic->scoopShortUrl, PDO::PARAM_STR),
				'followers'			=> array(!empty($topic->stats->followers) ? $topic->stats->followers : 0, PDO::PARAM_INT),
				'creatorName'		=> array($topic->stats->creatorName, PDO::PARAM_STR),
				'updated'			=> array($topic->stats->updated/1000, PDO::PARAM_INT, 'FROM_UNIXTIME'),
				'createdDate'  		=> array($topic->stats->createdDate/1000, PDO::PARAM_INT, 'FROM_UNIXTIME'),
				'score'  			=> array(!empty($topic->score) ? $topic->score : 0, PDO::PARAM_INT),
				'lang'  			=> array($topic->lang, PDO::PARAM_STR),
				'description'  		=> array($topic->description, PDO::PARAM_STR),
				'cat_name'  		=> array($topic->name, PDO::PARAM_STR),
				'mediumImageUrl'	=> array($topic->mediumImageUrl, PDO::PARAM_STR),
				'imageUrl'			=> array($topic->imageUrl, PDO::PARAM_STR),
				'largeImageUrl'		=> array($topic->largeImageUrl, PDO::PARAM_STR),
				'shortName'			=> array($topic->shortName, PDO::PARAM_STR),
				'shortName'			=> array($topic->shortName, PDO::PARAM_STR),
				'creator_smallAvatarUrl'	=> array($topic->creator->smallAvatarUrl, PDO::PARAM_STR),
				'creator_bio'				=> array($topic->creator->bio, PDO::PARAM_STR),
				'creator_largeAvatarUrl'	=> array($topic->creator->largeAvatarUrl, PDO::PARAM_STR),
				'creator_avatarUrl'			=> array($topic->creator->avatarUrl, PDO::PARAM_STR),
				'creator_mediumAvatarUrl'	=> array($topic->creator->mediumAvatarUrl, PDO::PARAM_STR),
				'creator_name'				=> array($topic->creator->name, PDO::PARAM_STR),
				'creator_shortName'			=> array($topic->creator->shortName, PDO::PARAM_STR),
				'creator_url'				=> array($topic->creator->url, PDO::PARAM_STR),
			);

			udpate_data($database, 'wp_scoop_categories', $params, 'id = ' . intval($topic->id));

			foreach ($topic->curatedPosts as $post) {
				$param_author = array(
					'id'			=> array($post->author->id, PDO::PARAM_INT),
					'bio' 			=> array($post->author->bi, PDO::PARAM_STR),
					'name' 			=> array($post->author->name, PDO::PARAM_STR),							
					'url'			=> array($post->author->url, PDO::PARAM_STR),
					'shortName'		=> array($post->author->shortName, PDO::PARAM_STR),
					'avatarUrl' 	=> array($post->author->avatarUrl, PDO::PARAM_STR),
					'smallAvatarUrl' 	=> array($post->author->smallAvatarUrl, PDO::PARAM_STR),
					'largeAvatarUrl' 	=> array($post->author->largeAvatarUrl, PDO::PARAM_STR),
					'mediumAvatarUrl'	=> array($post->author->mediumAvatarUrl, PDO::PARAM_STR),
				);

				$param_nodes = array(
					'id'			=> array($post->id, PDO::PARAM_INT),
					'category_id'	=> array($post->topicId, PDO::PARAM_INT),
					'scoopShortUrl'	=> array($post->scoopShortUrl, PDO::PARAM_STR),
					'imageUrl'		=> array($post->imageUrl, PDO::PARAM_STR),
					'pageClicks'	=> array(!empty($post->pageClicks) ? $post->pageClicks : 0, PDO::PARAM_INT),
					'commentsCount'	=> array(!empty($post->commentsCount) ? $post->commentsCount : 0, PDO::PARAM_INT),					
					'htmlContent'	=> array($post->htmlContent, PDO::PARAM_STR),
					'author_id'		=> array(!empty($post->author->id) ? $post->author->id : 0, PDO::PARAM_INT),
					'title'			=> array($post->title, PDO::PARAM_STR),
					'largeImageUrl'	=> array($post->largeImageUrl, PDO::PARAM_STR),
					'mediumImageUrl'=> array($post->mediumImageUrl, PDO::PARAM_STR),
					'imagePosition'	=> array($post->imagePosition, PDO::PARAM_STR),					
					'edited'		=> array(!empty($post->edited) ? $post->edited : 0, PDO::PARAM_INT),
					'imageHeight'	=> array(!empty($post->imageHeight) ? $post->imageHeight : 0, PDO::PARAM_INT),					
					'smallImageUrl'	=> array($post->smallImageUrl, PDO::PARAM_STR),
					'content'		=> array($post->content, PDO::PARAM_STR),
					'scoopUrl'		=> array($post->scoopUrl, PDO::PARAM_STR),
					'pageViews'		=> array(!empty($post->pageViews) ? $post->pageViews : 0, PDO::PARAM_INT),
					'thanksCount'	=> array(!empty($post->thanksCount) ? $post->thanksCount : 0, PDO::PARAM_INT),
					'insight'		=> array($post->insight, PDO::PARAM_STR),
					'tags'			=> array(implode(',', $post->tags), PDO::PARAM_STR),
					'curationDate'	=> array(ceil($post->curationDate/1000), PDO::PARAM_STR, 'FROM_UNIXTIME'),
					'reactionsCount'	=> array(!empty($post->reactionsCount) ? $post->reactionsCount : 0, PDO::PARAM_INT),
					'publicationDate'	=> array(ceil($post->publicationDate/1000), PDO::PARAM_STR, 'FROM_UNIXTIME'),
				);

				// Insert authors
				$stmt = $database->prepare("SELECT COUNT(*) FROM wp_scoop_authors WHERE id = :id");
				$stmt->bindParam(':id', $post->author->id, PDO::PARAM_INT);
				$stmt->execute();
				$author_count = $stmt->fetchColumn();
				$sql = "";
				if ($author_count > 0 && is_numeric($post->id)) {
					unset($param_author['id']);
					udpate_data($database, 'wp_scoop_authors', $param_author, 'id = ' . $post->author->id);
				}
				else {
					insert_data($database, 'wp_scoop_authors', $param_author);
				}

				// Insert nodes
				$stmt = $database->prepare("SELECT COUNT(*) FROM wp_scoop_nodes WHERE id = :id");
				$stmt->bindParam(':id', $post->id, PDO::PARAM_INT);
				$stmt->execute();
				$node_count = $stmt->fetchColumn();
				if ($node_count > 0 && is_numeric($post->id)) {
					unset($param_nodes['id']);
					udpate_data($database, 'wp_scoop_nodes', $param_nodes, 'id = ' . $post->id);
				}
				else {
					insert_data($database, 'wp_scoop_nodes', $param_nodes);
				}
			}

			$sql = "UPDATE wp_scoop_nodes SET is_pinned = 0 WHERE category_id = :category_id";
			$stmt = $database->prepare($sql);
			$stmt->bindParam(':category_id', $topic->id);
			$stmt->execute();
			if ($pinnedPostId) {
				$sql = "UPDATE wp_scoop_nodes SET is_pinned = 1 WHERE id = :id AND category_id = :category_id";
				$stmt = $database->Prepare($sql);
				$stmt->bindParam(':id', $pinnedPostId, PDO::PARAM_INT);
				$stmt->bindParam(':category_id', $topic->id, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
		$stmt = $database->prepare("SELECT COUNT(*) FROM wp_scoop_nodes");
		$stmt->execute();
		$count_nodes = $stmt->fetchColumn();
		if ($count_nodes > $fetch_count) {
			$sql = "DELETE FROM wp_scoop_nodes WHERE id IN (SELECT * FROM (SELECT id FROM wp_scoop_nodes WHERE category_id =  " . $cat['id'] . " ORDER BY publicationDate DESC LIMIT " . $fetch_count . ", " . ($count_nodes - $fetch_count) . ") AS del_t)";
			$stmt = $database->prepare($sql);
			$stmt->execute();
		}
	}
}


function insert_data($database, $table_name, $params) {
	if (!count($params) > 0)
		return false;

	$sql = "INSERT INTO %s (";		
	foreach ($params as $key => $param) {
		$sql .= $key . ",";
	}
	$sql = substr($sql, 0, -1) . ") VALUES(";
	foreach ($params as $key => $param) {
		if (isset($param[2])) {
			$sql .= $param[2] . "(:" . $key . "),";
		}
		else {
			$sql .= ":" . $key . ",";
		}
	}
	$sql = substr($sql, 0, -1) . ")";
	$sql = sprintf($sql, $table_name);
	
	$stmt = $database->prepare($sql);
	foreach ($params as $key => $param) {
		$stmt->bindParam(":" . $key, $param[0], $param['1']);
	}
	$stmt->execute();
	return $stmt->rowCount();
}

function udpate_data($database, $table_name, $params, $where) {
	if (!count($params) > 0)
		return false;

	$sql = "UPDATE %s SET ";
	foreach ($params as $key => $param) {
		if (isset($param[2])) {
			$sql .= $key . " = " . $param['2'] . "(:" . $key . "),";
		}
		else {
			$sql .= $key . " = :" . $key . ",";
		}
	}
	$sql = substr($sql, 0, -1);
	$sql .= " WHERE " . $where;
	$sql = sprintf($sql, $table_name);

	$stmt = $database->prepare($sql);
	foreach ($params as $key => $param) {
		$stmt->bindParam(":" . $key, $param[0], $param['1']);
	}
	$stmt->execute();
	return $stmt->rowCount();
}
