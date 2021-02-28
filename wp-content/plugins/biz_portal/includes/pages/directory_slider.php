<?php
/**
 * Page directory slider
 * @date :2014/11/13
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;
$sql = "SELECT * FROM " . _biz_portal_get_table_name('node_category');
$node_categories = $wpdb->get_results($sql);
$categories =array();
foreach ($node_categories as $cat) :
    $categories[$cat->id]=$cat->category_name;
endforeach;


///////////////////////////////////////////////////
function fileupload_process($img_id ,$view_type) {
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
      $view_result = get_option('dashboard_directory_slider_'.$view_type); 
       return $view_result[$img_id];
  }
}


if(isset($_POST['btn_update'])){
    $txt_type = filter_input(INPUT_POST, 'txt_type', FILTER_SANITIZE_STRING);
    $txt_title = filter_input(INPUT_POST, 'txt_title', FILTER_SANITIZE_STRING);
    $txt_content = filter_input(INPUT_POST, 'txt_content', FILTER_SANITIZE_STRING);
    $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);

    ///////////////////////////////////////////////
    $array = array (
        'mode' => $mode,
        'title' => $txt_title,
        'content' => $txt_content,
        'img_big' => fileupload_process('img_big',$txt_type),
        'img_small' => fileupload_process('img_small',$txt_type) 
        );

    update_option('dashboard_directory_slider_'.$txt_type, $array);
}

if(isset($_POST['faq_submit'])){
    $txt_type = filter_input(INPUT_POST, 'txt_type', FILTER_SANITIZE_STRING);
    $txt_title = filter_input(INPUT_POST, 'faq_title', FILTER_SANITIZE_STRING);
    $txt_content = filter_input(INPUT_POST, 'faq_content', FILTER_SANITIZE_STRING);
    $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);

    ///////////////////////////////////////////////
    $array = array (
        'title' => $txt_title,
        'content' => $txt_content,
        'img_big' => fileupload_process('img_big',$txt_type),
        'img_small' => fileupload_process('img_small',$txt_type),
        'img_medium' => fileupload_process('img_medium',$txt_type) 
        );

    update_option('dashboard_directory_slider_'.$txt_type, $array);
}

if(isset($_POST['btn_submit'])){
    $txt_type = filter_input(INPUT_POST, 'txt_type', FILTER_SANITIZE_STRING);
    $rtitle = filter_input(INPUT_POST, 'rtitle', FILTER_SANITIZE_STRING);
    $rcontent = filter_input(INPUT_POST, 'rcontent', FILTER_SANITIZE_STRING);
    $rmode = filter_input(INPUT_POST, 'rmode', FILTER_SANITIZE_STRING);

    ///////////////////////////////////////////////
    $array = array (
        'rmode' => $rmode,
        'title' => $rtitle,
        'content' => $rcontent,
        'rimgbig' => fileupload_process('rimgbig',$txt_type),
        'rimgsmall' => fileupload_process('rimgsmall',$txt_type) 
        );
    update_option('dashboard_directory_slider_'.$txt_type, $array);
}

if(isset($_POST['front_submit'])){
    $txt_type = filter_input(INPUT_POST, 'txt_type', FILTER_SANITIZE_STRING);
    $result =array();

         for ($k = 1; $k <= 5; $k++){
             $img_url= fileupload_process('front_img_'.$k ,$txt_type);
             if($img_url){
             $result['front_img_'.$k]=$img_url;
             }
         }
    update_option('dashboard_directory_slider_'.$txt_type, $result);
}


$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
if($type){
$result = get_option('dashboard_directory_slider_'.$type);
}else{ $type='front'; $result = get_option('dashboard_directory_slider_'.$type); }


$mode_type=array(
    1 =>"Active",
    2 =>"Show Only Default Image"
    );
?>
<style>
    .resource-all{
          background-color: #EDEDED;
        
    }
</style>
<script>
jQuery(document).ready(function($){
    

$('#resource-directory').on('change', '.ru_tab_select', function() {
    
    $(this).parent('div').parent('td').children('.ru_right_div').children('.ru_subtable').css('display', '');
    });
    
$('#resource-directory').on('click', '.view_unique_detail', function() {
    
    $(this).parent('div').parent('td').children('.ru_right_div').children('.ru_subtable').css('display', '');
    });
    
$('#add_new_unique').click(function(){
    
        html = '<tr>';
        html += $('#ru_page_table').html();
        html += '</tr>';
    $('#ru_page_table').parent('tbody').append(html);
    });
    
    
$('#rmode_all').click(function(){
    $('.resource-all').show();
    $('.resource-unique').hide();
    
    });
$('#rmode_unique').click(function(){
    $('.resource-all').hide();
    $('.resource-unique').show();
    });
if($('#rmode_all').is(':checked')){
     $('.resource-unique').hide();
   }

    
});

</script>
<div class="wrap">
<!--    <div id="icon-tools" ></div>-->
    <h2>Manage Banner & Slider's </h2>
            <ul class="subsubsub">
                <li class="front"><a href="?page=biz-portal-sliders&type=front" >Front Page</a>|</li>
                <li class="faq"><a href="?page=biz-portal-sliders&type=faq" >FAQ Page</a>|</li>
                <li class="resource"><a href="?page=biz-portal-sliders&type=resource" >Resource</a>|</li>
                <li class="sme"><a href="?page=biz-portal-sliders&type=sme" >Directory-SME</a>|</li>
                <li class="partner"><a href="?page=biz-portal-sliders&type=partner" >Directory-Partners</a>|</li>
                <li class="provider"><a href="?page=biz-portal-sliders&type=provider" >Directory-Service Providers</a>|</li>
                <li class="investor"><a href="?page=biz-portal-sliders&type=investor" >Directory-Investors</a>|</li>
                <li class="nonprofit"><a href="?page=biz-portal-sliders&type=nonprofit" >Directory-Non-Profit</a>|</li>
            </ul>
           <!-- <p>&nbsp;</p>-->
    <form method="post" action="?page=biz-portal-sliders<?php echo($type)? "&type=".$type : "" ; ?>"  enctype="multipart/form-data">
        <input type="hidden" name="txt_type" id="txt_type" value="<?php echo $type; ?>" />
        <table class="wp-list-table widefat"  id="resource-directory">
            <?php if($type == 'front'){ ?>
            <thead>
                <tr><th colspan="2"><h4>Manage Front Page Slider|Banner Image</h4></th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><h3>1st Image</h3></td>
                    <td>
                        <input type="file" name="front_img_1[]" id="front_img" />
                            <?php if($result['front_img_1']){ ?>
                        <img src="<?php echo $result['front_img_1']; ?>"  clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>No image</span>"; } ?>
                    </td>
                </tr>
                <tr>
                    <td><h3>2nd Image</h3></td>
                    <td>
                        <input type="file" name="front_img_2[]" id="front_img" />
                            <?php if($result['front_img_2']){ ?>
                        <img src="<?php echo $result['front_img_2']; ?>"  clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>No image</span>"; } ?>
                    </td>
                </tr>
                <tr>
                    <td><h3>3rd Image</h3></td>
                    <td>
                        <input type="file" name="front_img_3[]" id="front_img" />
                            <?php if($result['front_img_3']){ ?>
                        <img src="<?php echo $result['front_img_3']; ?>"  clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>No image</span>"; } ?>
                    </td>
                </tr>
                <tr>
                    <td><h3>4th Image</h3></td>
                    <td>
                        <input type="file" name="front_img_4[]" id="front_img" />
                            <?php if($result['front_img_4']){ ?>
                        <img src="<?php echo $result['front_img_4']; ?>"  clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>No image</span>"; } ?>
                    </td>
                </tr>
                <tr>
                    <td><h3>5th Image</h3></td>
                    <td>
                        <input type="file" name="front_img_5[]" id="front_img" />
                            <?php if($result['front_img_5']){ ?>
                        <img src="<?php echo $result['front_img_5']; ?>"  clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>No image</span>"; } ?>
                    </td>
                </tr>
                <tr>
                        <td colspan="2"  >
                            <input type="submit" name="front_submit" id="front_submit" class="button button-primary" value="Update">
                        </td>
                    </tr>
            </tbody>
                
                
            <?php  }elseif($type == 'faq'){ ?>
            <thead>
                    <tr>
                        <th colspan="2"><h4>Manage FAQ Page Slider | Default Image</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="plugin-title"><strong>Slider Title</strong></td>
                        <td><input type="text" size="75" name="txt_title" id="txt_title" value="<?php if($result['title']): echo $result['title']; endif; ?>" ></td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Slider Text Content</strong></td>
                        <td><textarea rows='7' cols='50' name="txt_content" id="txt_content"  ><?php if($result['content']): echo $result['content']; endif;?></textarea></td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>High Resolution Image</strong></td>
                        <td><input type="file" name="img_big[]" id="img_big" />
                            <?php if($result['img_big']){ ?>
                            <img src="<?php echo $result['img_big']; ?>" clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
                     <tr>
                        <td class="plugin-title"><strong>Medium Resolution Image</strong></td>
                        <td><input type="file" name="img_medium[]" id="img_medium" />
                            <?php if($result['img_medium']){ ?>
                            <img src="<?php echo $result['img_medium']; ?>" clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Small Resolution Image</strong></td>
                        <td><input type="file" name="img_small[]" id="img_small" />
                            <?php if($result['img_small']){ ?>
                            <img src="<?php echo $result['img_small']; ?>" clas="img-responsive" width="150" >
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  >
                            <input type="submit" name="faq_submit" id="faq_submit" class="button button-primary" value="Update">
                        </td>
                    </tr>
                </tbody>
            
            <?php  }elseif($type == 'resource'){ ?>
            
                <thead>
                    <tr>
                        <th colspan="2"><h4>Manage Resource Page Slider|Banner Image</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="plugin-title" width="20%"><strong>Slider|Banner Mode</strong></td>
                        <td width="80%">
                            <input type="radio" id="rmode_all"  name="rmode" value="all" checked="checked" >One Common Banner Image For All Page's</input><br>
                           <?php /* <input type="radio" id="rmode_unique" name="rmode" value="unique" <?php if($result['rmode']=='unique'){ echo 'checked="checked"'; }?>  >Unique Banner For All Page's</input><br>
<!--                            <input type="radio" name="rmode" value="cslider">Common Slider For All Page's</input><br>
                            <input type="radio" name="rmode" value="uslider">Unique Slider For All Page's</input>--> */ ?>
                        </td>
                    </tr>
<!-- One image for all -->
                    <tr class='resource-all'>
                        <td class="plugin-title"><strong>Slider Title</strong></td>
                        <td><input type="text" size="75" name="rtitle" id="txt_title" value="<?php if($result['title']): echo $result['title']; endif; ?>" ></td>
                    </tr>
                    <tr class='resource-all'>
                        <td class="plugin-title"><strong>Slider Text Content</strong></td>
                        <td><textarea rows='7' cols='50' name="rcontent" id="txt_content"  ><?php if($result['content']): echo $result['content']; endif;?></textarea></td>
                    </tr>
                    <tr class='resource-all'>
                        <td class="plugin-title"><strong>High Resolution Image</strong></td>
                        <td><input type="file" name="rimgbig[]" id="rimgbig" />
                            <?php if($result['rimgbig']){ ?>
                            <img src="<?php echo $result['rimgbig']; ?>"  clas="img-responsive" width="200" >
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
                    <tr class='resource-all'>
                        <td class="plugin-title"><strong>Small Resolution Image</strong></td>
                        <td><input type="file" name="rimgsmall[]" id="img_small" />
                            <?php if($result['rimgsmall']){ ?>
                            <img src="<?php echo $result['rimgsmall']; ?>" width="100" clas="img-responsive">
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
<!-- One image for all -->
                    
    
    <?php /*<tr class='resource-unique' style="background-color: #EDEDED;">
                        <td colspan="2" align="right"><a id="add_new_unique" ><strong>Add To Another Page</strong></a></td>
                    </tr>
                    <tr class='resource-unique' id="ru_page_table">
                        <td class="plugin-title">Page|Tab</td>
                        <td><div style="float:left;width: 85%;"  class="ru_right_div">
                                <select name="ru_tab" id="ru_tab" class="ru_tab_select">
                                    <option value="" >Select a Type</option>
                                        <?php 
                                        //$mode_result = $result['mode'];
                                        //if(!$mode_result): $mode_result = 2; endif;
                                        foreach($categories as $key=>$value) {
                                           // if($key==$mode_result){ $select="selected='selected'";  }else{ $select = ""; }
                                            echo '<option value="' . $key . '" >' .$value . '</option>';

                                        }?>
                                </select>
                            <table class="ru_subtable" style="display:none">
                                <tr>
                                    <td>High Resolution Image</td>
                                    <td>
                                        <input type="file" name="ru_imgbig[]" id="ru_imgbig" />
                                        <?php if($result['ru_imgbig']){ ?>
                                        <img src="<?php echo $result['ru_imgbig']; ?>"  clas="img-responsive" width="200" >
                                        <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Small Resolution Image</strong></td>
                                    <td><input type="file" name="ru_imgsmall[]" id="ru_imgsmall" />
                                        <?php if($result['ru_imgsmall']){ ?>
                                        <img src="<?php echo $result['ru_imgsmall']; ?>" width="100" clas="img-responsive">
                                        <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Slider Title</strong></td>
                                    <td><input type="text" size="50" name="ru_title" id="ru_title" value="<?php if($result['ru_title']): echo $result['ru_title']; endif; ?>" ></td>
                                </tr>
                                <tr>
                                    <td><strong>Slider Text Content</strong></td>
                                    <td><textarea rows='7' cols='50' name="ru_content" id="ru_content"  ><?php if($result['ru_content']): echo $result['ru_content']; endif;?></textarea></td>
                                </tr>
                            </table>
                            </div>
                            <div align="right" style="float:left;width: 15%; padding-top:0px;"><a class="view_unique_detail" >View Other Details</a></div>
                            
                        </td>
                    </tr> */ ?>


                   </tbody> 
                    <tr>
                        <td colspan="2"  >
                            <input type="submit" name="btn_submit" id="btn_submit" class="button button-primary" value="Update">
                        </td>
                    </tr>
               
            <?php  }else{ ?>
                    
                <thead>
                    <tr>
                        <th colspan="2"><h4>Manage Directory-<?php echo $type; ?> Page Slider Default Image</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="plugin-title"><strong>Slider Mode</strong></td>
                        <td>
                            <select name="mode" id="mode">
                                <option value="" >Select a Type</option>
                                    <?php 
                                    $mode_result = $result['mode'];
                                    if(!$mode_result): $mode_result = 2; endif;
                                    foreach($mode_type as $key=>$value) {
                                        if($key==$mode_result){ $select="selected='selected'";  }else{ $select = ""; }
                                        echo '<option value="' . $key . '"  '.$select.' >' .$value . '</option>';

                                    }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>Slider Title</strong></td>
                        <td><input type="text" size="75" name="txt_title" id="txt_title" value="<?php if($result['title']): echo $result['title']; endif; ?>" ></td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Slider Text Content</strong></td>
                        <td><textarea rows='7' cols='50' name="txt_content" id="txt_content"  ><?php if($result['content']): echo $result['content']; endif;?></textarea></td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>High Resolution Image</strong></td>
                        <td><input type="file" name="img_big[]" id="img_big" />
                            <?php if($result['img_big']){ ?>
                            <img src="<?php echo $result['img_big']; ?>" width="200" height="80">
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Small Resolution Image</strong></td>
                        <td><input type="file" name="img_small[]" id="img_small" />
                            <?php if($result['img_small']){ ?>
                            <img src="<?php echo $result['img_small']; ?>" width="80" height="80">
                            <?php }else { echo "<span style='color:red;'>Still there no image for this</span>"; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  >
                            <input type="submit" name="btn_update" id="btn_update" class="button button-primary" value="Update">
                        </td>
                    </tr>
                </tbody>
                
                
            <?php } ?>
                
        </table>
    </form>
    </div>