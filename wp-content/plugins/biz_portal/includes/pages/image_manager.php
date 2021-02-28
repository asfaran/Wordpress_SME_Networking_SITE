<?php
/**
 * Page manage Image's
 * @date :2014/11/19
 * @author SWISS BUREAU
 * @developer asfaran
 */


$tab_name = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);
if(!$tab_name){
$tab_name = "logo";
}


///////////////////////////////////////////////////
function fileupload_process($img_id ,$tab) {
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
      
  }elseif($tab == 'logo'){
      $view_result = get_option('dashboard_general_image'); 
       return $view_result[$img_id];
  }elseif($tab == 'footer'){
      $view_result = get_option('web_front_footer_image'); 
      return $view_result[$img_id];
      
  }
}


if(isset($_POST['btn_update'])){
$logo_title = filter_input(INPUT_POST, 'logo_title', FILTER_SANITIZE_STRING);

///////////////////////////////////////////////
$array = array (
    'logo_title' => $logo_title,
    'img_logo' => fileupload_process('img_logo' ,'logo'),
    'img_favicon' => fileupload_process('img_favicon' ,'logo') 
    );

update_option('dashboard_general_image', $array);
}


if(isset($_POST['btn_submit'])){
    $result=$_POST['web_front_footer_image'];
     for ($k = 1; $k <= 10; $k++){
         $result[$k]['img_logo']=fileupload_process('img_logo_'.$k);
     }
//    $k =1;
//    foreach ($_FILES["img_logo"] as $key){
//        $result[$k]['img_logo']=fileupload_process('img_logo_'.$k ,'footer');
//    $k ++;   
//  }

//$array = array (
//    'logo_title' => $logo_title,
//    'img_logo' => fileupload_process('img_logo'),
//    'img_favicon' => fileupload_process('img_favicon') 
//    );

update_option('web_front_footer_image', $result);
}

$result =get_option('dashboard_general_image');
$footer_result = get_option('web_front_footer_image');
?>
<div class="wrap">
<!--    <div id="icon-tools" ></div>-->
    <h2>Manage General Image's in Portal</h2>
            <ul class="subsubsub">
                <li class="sme"><a href="?page=biz-portal-image&tab=logo" >Logo & Favicon</a>|</li>
                <li class="partner"><a href="?page=biz-portal-image&tab=footer" >Footer</a>|</li>
            </ul>
           <!-- <p>&nbsp;</p>-->
    <form method="post" action="?page=biz-portal-image<?php echo($tab_name)? "&tab=".$tab_name : "" ; ?>"  enctype="multipart/form-data">
        <input type="hidden" name="tab" id="tab" value="<?php echo $tab_name; ?>" />
        <table class="wp-list-table widefat">
            
               <?php if($tab_name == "logo"){ ?>
                <thead>
                    <tr>
                        <th colspan="2"><h4><?php echo "Manage Site Logo & Favicon"; ?></h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan='2' class="plugin-title"><strong>Logo Image</strong></td>
                        <td>Logo Title:<input type="text" size="75" name="logo_title" id="logo_title" value="<?php echo $result['logo_title']; ?>" ></td>
                    </tr>
                    <tr>
                        <td><input type="file" name="img_logo[]" id="img_logo" />
                            <?php if($result['img_logo']){ ?>
                            <img src="<?php echo $result['img_logo']; ?>" >
                            <?php }else { echo "<span style='color:red;'>Still there no logo for this Site</span>"; } ?>
                        </td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Favicon Image</strong></td>
                        <td><input type="file" name="img_favicon[]" id="img_favicon" />
                            <?php if($result['img_favicon']){ ?>
                            <img src="<?php echo $result['img_favicon']; ?>">
                            <?php }else { echo "<span style='color:red;'>Still there no favicon for this site</span>"; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  >
                            <input type="submit" name="btn_update" id="btn_update" class="button button-primary" value="Update">
                        </td>
                    </tr>
                </tbody>
                
                
                
                
                <?php  }  elseif($tab_name == "footer") { ?>
                <thead>
                    <tr>
                        <th colspan="3"><h4><?php echo $msg."Manage Footer Advertisements"; ?></h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan='2' class="plugin-title"><h3>1st Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[1][title]" id="title" value="<?php  echo  $footer_result[1]['title']; ?>" ></td>
                        <td>URL:&nbsp;<input type="text" size="40" name="web_front_footer_image[1][url]" id="url" value="<?php  echo  $footer_result[1]['url']; ?>" ></td>
                    </tr>
                    <tr><td>Logo:<input type="file" name="img_logo_1[]" id="img_logo" />
                            <?php if($footer_result[1]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[1]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[1][style]" id="style" value="<?php  echo  $footer_result[1]['style']; ?>" ></td>
                    </tr>
<!-- first finished -->
                   <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>2nd Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[2][title]" id="title" value="<?php  echo  $footer_result[2]['title']; ?>" ></td>
                        <td>URL:&nbsp;<input type="text" size="40" name="web_front_footer_image[2][url]" id="url" value="<?php  echo  $footer_result[2]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_2[]" id="img_logo" />
                            <?php if($footer_result[2]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[2]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[2][style]" id="style" value="<?php  echo  $footer_result[2]['style']; ?>" ></td>
                    </tr>
<!-- Second finished -->
                    <tr>
                        <td rowspan='2' class="plugin-title"><h3>3rd Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[3][title]" id="title" value="<?php  echo  $footer_result[3]['title']; ?>" ></td>
                        <td>URL:&nbsp;<input type="text" size="40" name="web_front_footer_image[3][url]" id="url" value="<?php  echo  $footer_result[3]['url']; ?>" ></td>
                    </tr>
                    <tr><td>Logo:<input type="file" name="img_logo_3[]" id="img_logo" />
                            <?php if($footer_result[3]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[3]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[3][style]" id="style" value="<?php  echo  $footer_result[3]['style']; ?>" ></td>
                    </tr>
<!-- third finished -->
                    <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>4th Add</h3></td>
                        <td>Title:<input Placeholder="Type the Title here" type="text" size="30" name="web_front_footer_image[4][title]" id="title" value="<?php  echo  $footer_result[4]['title']; ?>" ></td>
                        <td>URL:&nbsp;<input type="text" size="40" name="web_front_footer_image[4][url]" id="url" value="<?php  echo $footer_result[4]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_4[]" id="img_logo" />
                            <?php if($footer_result[4]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[4]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[4][style]" id="style" value="<?php  echo  $footer_result[4]['style']; ?>" ></td>
                    </tr>
<!-- fourth finished -->
                    <tr>
                        <td rowspan='2' class="plugin-title"><h3>5th Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[5][title]" id="title" value="<?php  echo  $footer_result[5]['title']; ?>" ></td>
                        <td>URL:&nbsp;<input type="text" size="40" name="web_front_footer_image[5][url]" id="url" value="<?php  echo  $footer_result[5]['url']; ?>" ></td>
                    </tr>
                    <tr><td>Logo:<input type="file" name="img_logo_5[]" id="img_logo" />
                            <?php if($footer_result[5]['img_logo']){ ?>
                             <img src="<?php echo  $footer_result[5]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[5][style]" id="style" value="<?php  echo  $footer_result[5]['style']; ?>" ></td>
                    </tr>
<!-- fifth finished -->
                    <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>6th Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[6][title]" id="title" value="<?php  echo  $footer_result[6]['title']; ?>" ></td>
                        <td>URL:<input type="text" size="40" name="web_front_footer_image[6][url]" id="url" value="<?php  echo  $footer_result[6]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_6[]" id="img_logo" />
                            <?php if($footer_result[6]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[6]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[6][style]" id="style" value="<?php echo   $footer_result[6]['style']; ?>" ></td>
                    </tr>
<!-- sixth finished -->
                    <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>7th Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[7][title]" id="title" value="<?php  echo  $footer_result[7]['title']; ?>" ></td>
                        <td>URL:<input type="text" size="40" name="web_front_footer_image[7][url]" id="url" value="<?php  echo  $footer_result[7]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_7[]" id="img_logo" />
                            <?php if($footer_result[7]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[7]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[7][style]" id="style" value="<?php echo   $footer_result[7]['style']; ?>" ></td>
                    </tr>
<!-- seven finished -->
                    <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>8th Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[8][title]" id="title" value="<?php  echo  $footer_result[8]['title']; ?>" ></td>
                        <td>URL:<input type="text" size="40" name="web_front_footer_image[8][url]" id="url" value="<?php  echo  $footer_result[8]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_8[]" id="img_logo" />
                            <?php if($footer_result[8]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[8]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[8][style]" id="style" value="<?php echo   $footer_result[8]['style']; ?>" ></td>
                    </tr>
<!-- eighth finished -->
                    <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>9th Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[9][title]" id="title" value="<?php  echo  $footer_result[9]['title']; ?>" ></td>
                        <td>URL:<input type="text" size="40" name="web_front_footer_image[9][url]" id="url" value="<?php  echo  $footer_result[9]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_9[]" id="img_logo" />
                            <?php if($footer_result[9]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[9]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[9][style]" id="style" value="<?php echo   $footer_result[9]['style']; ?>" ></td>
                    </tr>
                    
<!-- ninth finished -->
                    <tr style="background-color:  #ccc">
                        <td rowspan='2' class="plugin-title"><h3>10th Add</h3></td>
                        <td>Title:<input type="text" size="30" name="web_front_footer_image[10][title]" id="title" value="<?php  echo  $footer_result[10]['title']; ?>" ></td>
                        <td>URL:<input type="text" size="40" name="web_front_footer_image[10][url]" id="url" value="<?php  echo  $footer_result[10]['url']; ?>" ></td>
                    </tr>
                    <tr style="background-color:  #ccc"><td>Logo:<input type="file" name="img_logo_10[]" id="img_logo" />
                            <?php if($footer_result[10]['img_logo']){ ?>
                             <img src="<?php  echo  $footer_result[10]['img_logo']; ?>" >
                            <?php  }  ?>
                        </td>
                        <td>Style:<input type="text" size="40" name="web_front_footer_image[10][style]" id="style" value="<?php echo   $footer_result[10]['style']; ?>" ></td>
                    </tr>
                    
<!-- ninth finished -->
                    <tr>
                        <td colspan="2"  >
                            <input type="submit" name="btn_submit" id="btn_submit" class="button button-primary" value="Update">
                        </td>
                    </tr>
                </tbody>
                

                    <?php } ?>
        </table>
    </form>
    </div>