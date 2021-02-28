<?php
/**
 * Page action_node
 * @date :2014/10/2
 * @author SWISS BUREAU
 * @developer asfaran
 */
global $wpdb;
$rcs_id = filter_input(INPUT_GET, 'rcs_id', FILTER_SANITIZE_STRING);

$BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
$node = $BP_Repo_Nodes->find_node_by_id($rcs_id);

$attach_count=count($node->attachments);
$cat_count=count($node->categories);

?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Business Resources</h2>
    <p>&nbsp;</p>
<form action='?page=business-portal-resource' method='post'>
    <input type="hidden" value="<?php echo $node->id; ?>" name="node_id" id="node_id" >
            <table class="wp-list-table widefat fixed posts">
                <thead>
                <tr >
                    <th colspan="2" align="right" >
                        <?php  if((int)$node->active===0){?>
                            <input type="Submit" value="Publish" Name="btn_publish" class="button button-primary" />
                         <?php } ?>
                        <input type="Submit" value="Delete" Name="btn_delete" class="button button-primary" />
                        <input type="Submit" value="Cencel" name="btn_cencel"  class="button button-primary" />
                    </th>
                </tr>
                </thead>
                <tr>
                    <td >Resource Title</td>
                    <td><?php echo $node->title;?></td>
                </tr>
                <tr>
                    <td>Resource Body</td>
                    <td><?php echo $node->body;?></td>
                </tr>
                <?php if($attach_count > 0): ?>
                <tr>
                    <td colspan="<?php echo $attach_count; ?>">Attached File</td>
                    <?php
                    $k =1;
                    foreach ($node->attachments as $attach) {
                       $file_url= biz_portal_get_file_url($attach->id, 0, 1, 0); 
                    
                    ?>
                    <td><a href="<?php echo $file_url; ?>" ><?php echo "Attachment ".$k; ?></a></td>
                    <?php  
                    $k++;
                    } ?>
                </tr>
                <?php endif; ?>
                <?php if($cat_count > 0): ?>
                <tr>
                    <td colspan="<?php echo $cat_count ;?>">Categories</td>
                    <?php
                    foreach ($node->categories as $cats) {  
                    ?>
                    <td><?php echo $cats->category_name; ?></td>
                    <?php  
                    } ?>
                </tr>
                <?php endif; ?>

        </table>
</form>
</div>

