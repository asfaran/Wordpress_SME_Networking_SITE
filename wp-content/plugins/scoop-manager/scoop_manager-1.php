<?php
/**
 * Plugin Name: Scoop Manager
 * Plugin URI: http://www.emirateswifi.net/
 * Description: Manage scoop based contents
 * Version: 1.0
 * Author: Swiss Bureau Project Supply
 * Author URI: http://www.emirateswifi.net
 * License: Proprietory
 */
require_once(__DIR__ . "/includes/admin_pages.php");

add_action('admin_menu', 'scoop_manager_create_admin_menu');
add_action('init', 'scoop_manager_init');

function scoop_manager_init()
{
	add_action('admin_menu', 'scoop_manager_admin_submenu_page');
}


/**
 * Gets the list of all topics in wordpress db object format
 *
 * @return object array
 */
function scoop_it_get_topics()
{
	global $wpdb;
	$scoop_categories = $wpdb->get_results("SELECT * FROM " . $wpdb->base_prefix . "scoop_categories ORDER BY sorting ");
	return $scoop_categories;
}

/**
 * Gets the list of nodes specified by the topic id
 * If both topic_id and $count are 0, the default count of 30 will be applied.
 * @param int $topic_id
 * @param int $count
 * @return object array
 */
function scoop_it_get_nodes($topic_id = 0, $count = 0)
{
	if ($topic_id == 0 && $count == 0)
		$count = 30;

	global $wpdb;
	$cols_nodes = _scoop_get_prefixed_table_columns($wpdb->base_prefix . "scoop_nodes", 'n', 'node_');
	$cols_authors = _scoop_get_prefixed_table_columns($wpdb->base_prefix . "scoop_authors", 'a', 'author_');
	$cols_cats = _scoop_get_prefixed_table_columns($wpdb->base_prefix . "scoop_categories", 'c', 'topic_');

	$sql = "SELECT $cols_nodes, $cols_authors, $cols_cats 
		FROM " . $wpdb->base_prefix . "scoop_nodes AS n
		LEFT JOIN " . $wpdb->base_prefix . "scoop_categories AS c ON n.category_id = c.id
		LEFT JOIN " . $wpdb->base_prefix . "scoop_authors AS a ON n.author_id = a.id";

	if ($topic_id > 0) {
		$sql .= " WHERE n.category_id = " . $topic_id;
	}

	$sql .= " ORDER BY publicationDate DESC";

	if ($count > 0) {
		$sql .= " LIMIT 0, " . $count;
	}

	$scoop_nodes = $wpdb->get_results($sql);

	return $scoop_nodes;
}

function scoop_it_get_nodes_random($topic_id = 0)
{
	 scoop_it_get_nodes($topic_id = 0, 4);
}


function scoop_it_get_summary($text, $length = 100)
{
	if (strlen($text) <= $length) return $text;
	$truncated = substr($text, 0, $length);
	$last_space = strrpos($truncated, ' ');
	/*$truncated = substr($truncated, 0, $last_space);*/
	
	$first_dot = strpos($text, '.');
	if (!$first_dot > 1)
	    $first_dot = $last_space;
	else
	    $first_dot++;
	
	$truncated = substr($text, 0, $first_dot);

	return $truncated;
}

function _scoop_get_prefixed_table_columns($table_name, $alias, $prefix) 
{
	global $wpdb;
    $columns = $wpdb->get_results("SHOW COLUMNS FROM " . $table_name, ARRAY_A);
    $columns_str = "";
    foreach ($columns as $column) {
    	$columns_str .= $alias . '.' . $column['Field'] . ' AS ' . $prefix . $column['Field'] . ', ';
    }
    $columns_str = substr($columns_str, 0, -2);
    return $columns_str;
}