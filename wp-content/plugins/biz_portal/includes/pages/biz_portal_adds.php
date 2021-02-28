<?php
/**
 * Page biz_portal_adds
 * @date :2014/10/07
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

$msg='';


////common function for file upload ....pass file input name only...
function file_upload($file_input_name){
    global $wpdb;
    function upload_dir(){

                /* Customize this to fit your needs */
                $dir = '../upload/php/files/';
                $url = get_site_url()."/upload/php/files/";

                $bdir = $dir;
                $burl = $url;

               // $subdir = false;

                /* Set the $uploads array with our new paths */
                $upload['path'] = $dir;
                $upload['url'] = $url;
                //$upload['subdir'] = $subdir;
                $upload['basedir'] = $bdir;
                $upload['baseurl'] = $burl;
                $upload['error'] = false;

                return $upload;
        }
            function custom_upload_name($filename){
                $ext = strtolower(substr(strrchr($filename, '.'), 1));
                //$info = pathinfo($filename);    
                $filename  =  time()."_adds_".uniqid().".".$ext;
                return $filename;
                
        }
    
    add_filter( 'upload_dir', 'upload_dir' );
    add_filter('sanitize_file_name', 'custom_upload_name', 10);

        
    $file=$_FILES[$file_input_name];
    $ext = strtolower(substr(strrchr($file['name'], '.'), 1));
    
    
    
    if($ext=='jpeg' ||$ext=='jpg'||$ext=='png'||$ext=='gif'){
        if ( ! function_exists('wp_handle_upload') ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload($file, $upload_overrides );
        if ( $movefile ) {
        $BP_File = new BP_File();
        $BP_File->path = '/upload/php/files/'.basename($movefile['file']);
        $BP_File->mime_type = $file['type'];
        $BP_File->size_bytes = $file['size'];
        $BP_File->extension = $ext;
        $BP_File->is_image = 1;
        $BP_File->file_usage = 1;
        $BP_File->uid = get_current_user_id();
        
       $BP_Repo_Files = new BP_Repo_Files($wpdb, biz_portal_get_table_prefix());
       $res=$BP_Repo_Files->save_file($BP_File);
        }
    }
    return $res;
}
////common upload function finished ...

////for insert  button Action /////
if(isset($_POST['btn_submit'])){
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_STRING);
    $txt_url = filter_input(INPUT_POST, 'txt_url', FILTER_SANITIZE_STRING);
    
    
            if($type_id):
            $result_insert=$wpdb->insert(_biz_portal_get_table_name('advertisements'), 
                    array('ads_type' => $type_id,'link_url' => $txt_url,'image_id'=>file_upload('file_img')));
                    if($result_insert>0){
                        $msg .='<span style="color:#009900"> New Advertisement saved Successfully</span>';
                    }else{
                        $msg .='<span style="color:#FF0000">Please,Add valid Advertisement Details</span>';
                    }         
            endif;
}
 ////insert button Action  finished/////

    ////for delete button Action /////
    if(isset($_POST['btn_delete'])){
        $add_id = filter_input(INPUT_POST, 'add_id', FILTER_SANITIZE_NUMBER_INT);
        $image_id = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
        
       $result=$wpdb->delete(_biz_portal_get_table_name('advertisements'), array( 'id' => $add_id ),array('%d') );
       if($result >0){
        biz_portal_remove_file_usage($image_id);
        $msg .='<span style="color:#009900">Selected Advertisment Deleted successfully</span>';
       }
    }
    ////Delete button Action  finished/////
    
    ////for update button Action /////
    if(isset($_POST['btn_update'])){
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_STRING);
    $txt_url = filter_input(INPUT_POST, 'txt_url', FILTER_SANITIZE_STRING);
    $add_id = filter_input(INPUT_POST, 'add_id', FILTER_SANITIZE_NUMBER_INT);
    
    if($type_id):        
        $update_result=$wpdb->update(_biz_portal_get_table_name('advertisements'),
                array('link_url' => $txt_url,'image_id'=>file_upload('file_img'),'ads_type'=>$type_id),
                array('id' => $add_id),array('%s','%d','%s'));
    if($update_result>0){
        $msg .='<span style="color:#009900">Selected Advertisment updated successfully</span>';
    }else{
        $msg .='<span style="color:#FF0000">Please,Update advertisment through valid Data</span>';
    }
    endif;
}
////update button Action  finished/////

$sql = "SELECT adds.*,file.path as path FROM " . _biz_portal_get_table_name('advertisements')." as adds
            INNER JOIN " . _biz_portal_get_table_name('files_t')." as file
            ON adds.image_id = file.id ";
$advertisement = $wpdb->get_results($sql);

$sql_count = $wpdb->get_var("SELECT COUNT(*) FROM " ._biz_portal_get_table_name('advertisements'));


$adds_type=array(
    ADS_TYPE_NEWSROOM =>"News Room",
    ADS_TYPE_RESOURCE =>"Resource",
    ADS_TYPE_LOGIN =>"Login",
    ADS_TYPE_SIDEBAR =>"Side Bar",
    ADS_TYPE_DIRECTORY =>"Directory",
    ADS_TYPE_ABOUT =>"About Us"
    );



?>
<div class="wrap">
<!--    <div id="icon-tools" ></div>-->
    <h2>Manage Advertisement's</h2>
            <ul class="subsubsub">
                <li class="all"><a href="?page=biz-portal-advertisement&action=view" >All Adds</a>|</li>
                <li class="partner"><a href="?page=biz-portal-advertisement&action=add" >Add New</a>|</li>
            </ul>
    
<table class="wp-list-table widefat">
    <thead>
        <?php
        if($msg){ ?>
        <tr>
            <th colspan="4"><strong><?php echo $msg;?></strong></th>
        </tr>
        <?php }?>
        <tr>
            <th><strong>Add Type</strong></th>
            <th><strong>Image</strong></th>
            <th><strong>Url</strong></th>
            <th ><strong>Actions</strong></th>
        </tr>
    </thead>
    <tbody>
        <?php 
                    $i = 0;
                    if($sql_count>0):
                    foreach ($advertisement as $adds) :
                        $delete_link = '?page=biz-portal-advertisement&action=delete&add_id='.$adds->id;
                        $update_link = '?page=biz-portal-advertisement&action=edit&add_id='.$adds->id;
                    ?>
        <tr>
            <td><?php echo $adds_type[$adds->ads_type]; ?></td>
            <td><img src="<?php echo get_site_url().$adds->path; ?>" width="80" height="80"></td>
            <td><a href="<?php echo $adds->link_url; ?>" target="_blank">Click</a></td>
            <td><a class="editraw" href="<?php echo $update_link;?>" >Edit</a>|
                <a class="submitdelete" href="<?php echo $delete_link;?>" >Delete</a></td>
        </tr>
        <?php $i++; endforeach;
                    else: ?>
                    <tr>
                        <td colspan="5">There is no records related to Advertisement</td>
                    </tr>
                    <?php 
                    endif;
                    ?>
    </tbody>