<?php
/**
 * Page biztype_resource
 * @date :2014/10/1
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

if(isset($_POST['btn_publish'])){
    $node_id = filter_input(INPUT_POST, 'node_id', FILTER_VALIDATE_INT);
     biz_portal_node_change_state($node_id,1);
    
}

if(isset($_POST['btn_delete'])){
    $node_id = filter_input(INPUT_POST, 'node_id', FILTER_VALIDATE_INT);
    
    $wpdb->delete(_biz_portal_get_table_name('nodes'), array( 'id' => $node_id ) );
    $message_up ='<span style="color:#009900">Selected Resource Deleted successfully</span>';
}


$CUR_PAGE = filter_input(INPUT_GET, 'cp', FILTER_VALIDATE_INT);

$type = strtoupper(urldecode(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING)));

if (!$type)
{
    $type_name = BP_Node::NODE_TYPE_RESOURCE;
}

switch ($type) {
    case BP_Node::NODE_TYPE_RESOURCE:
        $type_name = BP_Node::NODE_TYPE_RESOURCE;
        break;
    case BP_Node::NODE_TYPE_DOWNLOAD:
        $type_name = BP_Node::NODE_TYPE_DOWNLOAD;
        break;
    case BP_Node::NODE_TYPE_POST:
        $type_name = BP_Node::NODE_TYPE_POST;
}
//$node_total_list
$total_list = biz_portal_node_get_list($type_name ,0 , '' , '');
$COUNT =$total_list->total;
$PER_PAGE = 20;
$TOTAL_PAGES = ceil($COUNT/$PER_PAGE);

if ($CUR_PAGE > $TOTAL_PAGES):
    $CUR_PAGE = $TOTAL_PAGES;
endif;
if ($CUR_PAGE < 1 ):
    $CUR_PAGE = 1;
endif;
$START = (($CUR_PAGE * $PER_PAGE ) - $PER_PAGE);

$node_total_list = biz_portal_node_get_list($type_name, 0, '', 'FULL' , 0, $PER_PAGE, $START);

//biz_portal_node_get_list($type, 0, '', '', $current_company_id, $pager_per_page, $pager_offset);


function nodeselect($action ,$value){
global $wpdb;
        if($action==='company_name'){

            $sql = "SELECT company_name FROM "._biz_portal_get_table_name('companies')." Where id=".$value;
            $com_name = $wpdb->get_var($sql);
            echo $com_name;

        }elseif($action==='category_list'){
           if(is_array($value) && count($value)){
                $content="<ol type='1'>";
                foreach ($value as $cat) {
                        if($cat->category_name):
                             $content .="<li>".$cat->category_name."</li>";
                        endif;
                }
                $content .="</ol>";
                echo $content;
            }else{
                return false;
        }
        }elseif($action==='attachments'){
            if(is_array($value) && count($value)){
                $content="";
                foreach ($value as $file) {
                        if($file->id):
                            $image = biz_portal_get_file_url($file->id, 1, 0, 1);
                             $content .="<div style='float:left'><image src='$image' /></div>";
                        endif;
                }
                echo $content;
            }else{
                return false;
        }
            
        }
};
?>
<style>
.label {padding:1px 4px;border-radius: 5px}
.label-warning {background-color:#FAAC58;}
.label-success {background-color:#9FF781;}
.pagination li {
    list-style: none;
    float: left;
}
.pagination li a {
    display: block;
    display: block;
    padding: 5px;
    border: 1px #ccc solid;
    margin-right: 10px;
    background: #ddd;
    text-decoration:none;
}
.pagination li a:hover {
    background: #cccccc;
}
</style>
<div class="wrap">
<!--    <div id="icon-tools" ></div>-->
    <h2>Business Resources</h2>
            <ul class="subsubsub">
            <li class="Resource"><a href="?page=business-portal-resource&type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_RESOURCE)) ?>" >Resources</a>|</li>
            <li class="Post"><a href="?page=business-portal-resource&type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_POST)) ?>" >Post</a>|</li>
            <li class="Download"><a href="?page=business-portal-resource&type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_DOWNLOAD)) ?>" >Downloads</a>|</li>
            </ul>
<!--           <p>&nbsp;</p>-->
        <table class="wp-list-table widefat">
                <thead>
                    <tr>
                        <th width="25%"><strong>Title</strong></th>
                        <th width="15%"><strong>Company Name</strong></th>
                        <th width="10%"><strong>Status</strong></th>
                        <th width="40%"><strong>Body</strong></th>
<!--                        <th width="15"><strong>Related Attachments</strong></th>
                        <th width="10%"><strong>Related Categories</strong></th>-->
                        <th width="10%"><strong>Action</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5"><?php echo $message_up; ?></td>
                    </tr>
                   
                    <?php 
                    
                    foreach ($node_total_list as $node_list) :
                      $i=1;
                    if(is_array($node_list)){
                       foreach ($node_list as $nodes) :
                            if($nodes->title){
                            $delete_link = '?page=business-portal-resource&action=view&rcs_id='.$nodes->id;
                      ?>
                    
                    <tr>
                        <td><?php echo $nodes->title; ?></td>
                        <td><?php nodeselect('company_name',$nodes->company_id); ?></td>
                        <td><?php  
                        if($nodes->active==='1'):
                            echo "<img src='../wp-content/plugins/biz_portal/assets/img/ok.png' /><span style='color:green'>Published</span>";
                        else: 
                            echo "<img src='../wp-content/plugins/biz_portal/assets/img/deny.png' /><span style='color:orange'>Pending</span>";
                        endif; ?>
                        </td>
                        <td><?php echo substr($nodes->body,0 ,100); ?></td>
<!--                        <td><?php //nodeselect('attachments',$nodes->attachments); ?></td>-->
<!--                        <td><?php  //nodeselect('category_list',$nodes->categories); ?></td>-->
                        <td><a href="<?php echo $delete_link; ?>">view</a></td>
                    </tr>
                    <?php 
                            
                        }
                        $i++;
                        endforeach;
                    }
                        
                        
                    endforeach;?>
                    
                </tbody>
        </table>
</div>
<div>
    Pages: <ul class="pagination">
        <?php for ($i=0; $i<$TOTAL_PAGES;$i++) : ?>
            <?php 
            $type = strtoupper(urldecode(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING)));
            if ($type)
                $url = "?page=business-portal-resource&cp=" . ($i+1) . "&type=" . $type;
            else
                $url = "?page=business-portal-resource&cp=" . ($i+1);
            ?>
            <li><a href="<?php echo $url; ?>"><?php echo ($i+1); ?></a></li>
        <?php endfor ?>
    </ul>
</div>
<script>
$(document).ready( function() {
    BizPortal_Admin.init({rootUrl:'<?php echo site_url(); ?>'});
});
</script>

