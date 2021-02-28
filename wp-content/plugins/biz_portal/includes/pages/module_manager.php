<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function fileupload_process($img_id) {
$uploadfiles = $_FILES[$img_id];

  if (is_array($uploadfiles)) {

    foreach ($uploadfiles['name'] as $key => $value) {

      // look only for uploded files
      if ($uploadfiles['error'][$key] == 0) {

        $filetmp = $uploadfiles['tmp_name'][$key];

        //clean filename and extract extension
        $filename = $uploadfiles['name'][$key];

        // get file info
        // @fixme: wp checks the file extension....
        $filetype = wp_check_filetype( basename( $filename ), null );
        $filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
        $filename = $filetitle . '.' . $filetype['ext'];
        $upload_dir = wp_upload_dir();

        /**
         * Check if the filename already exist in the directory and rename the
         * file if necessary
         */
        $i = 0;
        while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
          $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
          $i++;
        }
        $filedest = $upload_dir['path'] . '/' . $filename;
        $filedest_url = $upload_dir['url'] . '/' . $filename;

        if ( !@move_uploaded_file($filetmp, $filedest) ){
          //$this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
          continue;
        }

        $attachment = array(
          'post_mime_type' => $filetype['type'],
          'post_title' => $filetitle,
          'post_content' => '',
          'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $filedest );
        require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filedest );
        wp_update_attachment_metadata( $attach_id,  $attach_data );

      }
    }
    // $filedest;
  }
  if($filedest_url){
      return $filedest_url;
      
  }else{
      $view_result = get_option('about_module_content'); 
       return $view_result[$img_id];
  }
}

$current=filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);
            if (!$current){
            $current = 'about'; }
            
if(isset($_POST['btn_submit'])){
    $data = $_POST['about_module_content'];
    if($data['mode']=='upload'){
        
        $data['abt_image'] = fileupload_process('abt_image');
    }elseif($data['mode']=='one'){
         $data['abt_image'] = wp_get_attachment_url( get_post_thumbnail_id(get_option( 'about_page_row_'.$data['uimage'] )) );
    }
    update_option('about_module_content', $data);
    update_option('video_module_content', $_POST['video_module_content']);
    
  
}

$types= array(
    'playlist' => 'YouTube Playlist',
    'channel' => 'YouTube Channel'
);
        $post_args = array(
	'posts_per_page'   => 100,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'post_title',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => array( 'post', 'page' ),
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish,private',
	'suppress_filters' => true );
        $posts = get_posts($post_args);
        
        $abt_result=get_option('about_module_content'); 
        $video_result=get_option('video_module_content');
?>
<style>
    .form-table td {
        padding :9px 10px;
    }
</style>
<script>
jQuery(document).ready(function($){

$('input[class="uimage_select"]:checked').each(function() {
   $('.'+$(this).attr('id')).css('display', '');
});

$('.wrap').on('click', '.uimage_select', function() {
    

    $('.one_image').css('display', 'none');
    $('.upload_image').css('display', 'none');
    
    $('.'+$(this).attr('id')).css('display', '');
    });
    
 });   
</script>

<div class="wrap">
        <h2>Manage Page's</h2>
        Manage Front Page content        
        <form action="admin.php?page=biz-portal-modules&tab=<?php echo $current; ?>" method="post"  enctype="multipart/form-data">
           

            <h2 class="nav-tab-wrapper">
            <?php $class = ( $current === "about") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-modules&tab=about">About Module</a>
            <?php  $class = ( $current === "video") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-modules&tab=video">Video</a>
            
            
           
            
            <!-- ========================================== About start ================================--->
            <?php $class_v = ( "about" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Manage About Module</h2>
                <table class="form-table">
                <tr valign="top">
                    <td scope="row">About Module Content</td>
                    <td><select name="about_module_content[about_data]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $page) : ?>
                                    <?php if ($page->ID == $abt_result['about_data']) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Module Title</td>
                    <td>
                        <input type="text" size="50" name="about_module_content[title]" id="title" value="<?php if($abt_result['title']): echo $abt_result['title']; endif; ?>" >
                    </td>
                </tr>
                <tr>
                    <td scope="row">Linking Content</td>
                    <td>
                        <input type="text" size="50" name="about_module_content[footer]" id="footer" value="<?php if($abt_result['footer']): echo $abt_result['footer']; endif; ?>" >
                    </td>
                </tr>
                <tr>
                    <td scope="row">Link</td>
                    <td>
                        <input type="text" size="50" name="about_module_content[link]" id="link" value="<?php if($abt_result['link']): echo $abt_result['link']; endif; ?>" >
                    </td>
                </tr>
                <tr>
                    <td scope="row">Image Display Mode</td>
                    <td>
                        <input class="uimage_select" type="radio" id="one_image"  name="about_module_content[mode]" value="one" <?php if($abt_result['mode']=='one'){ echo 'checked="checked"'; }?> >One Image</input><br>
                        <input class="uimage_select"  type="radio" id="all_image" name="about_module_content[mode]" value="all" <?php if($abt_result['mode']=='all'){ echo 'checked="checked"'; }?>  >All Images</input><br>
                        <input class="uimage_select" type="radio" id="upload_image" name="about_module_content[mode]" value="upload" <?php if($abt_result['mode']=='upload'){ echo 'checked="checked"'; }?>  >Upload a Image</input>
                    </td>
                </tr>
                <tr class="one_image" style=" display: none">
                    <td scope="row">Select a Image</td>
                    <td>
                        <input  type="radio" id="one_image"  name="about_module_content[uimage]" value="one" <?php if($abt_result['uimage']=='one'){ echo 'checked="checked"'; }?> >
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_option( 'about_page_row_one' )) ); ?>"   width="100" class="img-responsive" /></input><br>
                        <input type="radio" id="all_image" name="about_module_content[uimage]" value="two" <?php if($abt_result['uimage']=='two'){ echo 'checked="checked"'; }?>  >
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_option( 'about_page_row_two' )) ); ?>"   width="100" class="img-responsive"  /></input><br>
                        <input  type="radio" id="all_image" name="about_module_content[uimage]" value="three" <?php if($abt_result['uimage']=='three'){ echo 'checked="checked"'; }?>  >
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_option( 'about_page_row_three' )) ); ?>"   width="100"  class="img-responsive"  /></input>
                    </td>
                </tr>
                <tr class="upload_image" style=" display: none">
                    <td class="plugin-title">Upload Image</td>
                    <td><input type="file" name="abt_image[]" id="abt_image" />
                            <?php if($abt_result['abt_image']){ ?>
                            <img src="<?php echo $abt_result['abt_image']; ?>"   width="100" class="img-responsive" >
                            <?php }else { echo "<span style='color:red;'>Still there no favicon for this site</span>"; } ?>
                    </td>
                </tr>
                </table>
            </div> 
            </h2>
            <!-- ========================================== about end ================================--->
            
            <!-- ========================================== Video start ================================--->
            <?php $class_v = ( "video" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Manage Footer Video Module</h2>
                <table class="form-table">
                    <tr valign="top">
                        <td class="plugin-title">Video Album Type</td>
                        <td>
                            <select name="video_module_content[type]">
                                <option value="">[SELECT ONE]</option>
                                <?php
                                foreach($types as $key=>$value) {
                                    if($key == $video_result['type']){ 
                                         echo '<option selected="selected" value="' . $key . '" >' .$value . '</option>';
                                    }else{
                                         echo '<option  value="' . $key . '" >' .$value . '</option>';
                                    }
                                   
                                 }
                                 ?>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td class="plugin-title">Module Title</td>
                        <td>
                             <input type="text" size="50" name="video_module_content[title]" id="title" value="<?php if($video_result['title']): echo $video_result['title']; endif; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td class="plugin-title">Number of Video's to Display</td>
                        <td>
                            <input type="text" size="50" name="video_module_content[count]" id="title" readonly="readonly" value="<?php if($video_result['count']): echo $video_result['count']; endif; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td class="plugin-title">YouTube Channel|Playlist ID</td>
                        <td>
                            <input type="text" size="50" name="video_module_content[link]" id="footer" value="<?php if($video_result['link']): echo $video_result['link']; endif; ?>" >
                        </td>
                    </tr>
              </table>
            </div> 
            </h2>
            <!-- ========================================== Video end ================================--->
            
           
            
           
            
    
        <p class="submit">
        <input id="btn_submit" class="button button-primary" type="submit" value="Save Changes" name="btn_submit">
        </p>
        </form>
    </div>