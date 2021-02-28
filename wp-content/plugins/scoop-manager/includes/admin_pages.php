<?php

function scoop_manager_create_admin_menu()
{
    //create new top-level menu
    add_menu_page('Scoop Manager', 'Scoop Manager', 'administrator', 'scoop-manager', 'scoop_settings_page', 'dashicons-share-alt');
}

function scoop_manager_admin_submenu_page()
{
    add_submenu_page(
            'scoop-manager', 'Scoop Manager', 'Scoop Manager', 'administrator', 'scoop-manager', 'scoop_settings_page');
}

function scoop_settings_page()
{
    $scope = 'category';
    $scope = filter_input(INPUT_GET, 'scope', FILTER_SANITIZE_STRING);
    ?>
    <div class="wrap">
        <h2>Scoop Manager</h2>
    <?php

    switch ($scope) {
        case 'node' :
            $cat_id = filter_input(INPUT_GET, 'cat_id', FILTER_SANITIZE_NUMBER_INT);
            _scoop_manager_print_node_page($cat_id);
            break;
        default:
            _scoop_manager_print_categories_page();
    }  
    ?>
    </div>
    <?php  
}

function _scoop_manager_print_categories_page()
{
    global $wpdb;
    $scoop_categories = scoop_it_get_topics();
    ?>
        <h3>Categories</h3>
        <table class="wp-list-table widefat fixed pages">
        <thead>
        <tr>
            <th width="10%">Topic ID</th>
            <th width="30%">Topic Name</th>
            <th width="15%">Last Access</th>
            <th width="15%">Updated</th>
            <th width="20%">Creator Name</th>
            <th width="10%">Followers</th>            
        </tr>
        </thead>
        <tbody>
        <?php $i=0; ?>
        <?php foreach ($scoop_categories as $cat) : ?>
            <?php $alternate = $i%2==0? 'alternate' : ''; $i++; ?>
            <tr class="<?php echo $alternate; ?>">
                <td><a href="?page=scoop-manager&scope=node&cat_id=<?php echo $cat->id; ?>"><?php echo $cat->id; ?></a></td>
                <td>
                    <?php if (!empty($cat->mediumImageUrl)) : ?>
                        <img src="<?php echo $cat->mediumImageUrl; ?>" style="float:left;margin-right:3px;">
                    <?php endif; ?>
                    <?php echo $cat->cat_name; ?></td>
                <td><?php echo $cat->last_access; ?></td>
                <td><?php echo $cat->updated; ?></td>
                <td>
                    <?php if (!empty($cat->creator_mediumAvatarUrl)) : ?>
                        <img src="<?php echo $cat->creator_mediumAvatarUrl ?>" style="float:left;margin-right:3px;" />
                    <?php endif; ?>
                    <?php echo $cat->creatorName; ?></td>
                <td><?php echo $cat->followers; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php
}

function _scoop_manager_print_node_page($cat_id)
{
    if (!$cat_id)
    {
        echo 'Wrong topic selected.';
        return;
    }
    global $wpdb;
    $scoop_nodes = $wpdb->get_results("SELECT n.*, a.name AS author, a.url AS author_url FROM  " . $wpdb->base_prefix . "scoop_nodes n LEFT JOIN " . $wpdb->base_prefix . "scoop_authors a ON n.author_id = a.id WHERE n.category_id = " . $cat_id);
    //echo "SELECT n.*, a.name AS author FROM  " . $wpdb->base_prefix . "scoop_nodes n LEFT JOIN " . $wpdb->base_prefix . "scoop_authors a ON n.author_id = a.id";
    //print_r($scoop_nodes);
    ?>

    <h3>Nodes</h3>
    <table class="wp-list-table widefat fixed pages">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="10%">ID</th>
                <th width="22%">Title</th>
                <th width="15%">Scoop Short Url</th>
                <th width="8%">Clicks</th>
                <th width="8%">Views</th>
                <th width="20%">Author</th>
                <th width="7%">Thx</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
            <?php foreach ($scoop_nodes as $node) : ?>
                <?php $alternate = $i%2==0? 'alternate' : ''; $i++; ?>
                <tr class="<?php echo $alternate; ?>">
                    <td>
                        <?php if (!empty($node->smallImageUrl)) : ?>
                            <img src="<?php echo $node->smallImageUrl ?>" />
                        <?php endif;?>
                    </td>
                    <td><?php echo $node->id; ?></td>
                    <td><a href="<?php echo $node->scoopUrl ?>" target="_blank"><?php echo $node->title; ?></a></td>
                    <td><a href="<?php echo $node->scoopShortUrl; ?>" target="_blank"><?php echo $node->scoopShortUrl; ?></a></td>
                    <td><?php echo $node->pageClicks; ?></td>
                    <td><?php echo $node->pageViews; ?></td>
                    <td><a href="<?php echo $node->author_url; ?>" target="_blank"><?php echo $node->author; ?></a></td>
                    <td><?php echo $node->thanksCount; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
}