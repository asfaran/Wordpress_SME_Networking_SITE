<?php
/**
 * Page dashboard_stats
 * @date :2014/10/07
 * @author SWISS BUREAU
 * @developer asfaran
 */



if(isset($_POST['btn_update'])){
$txt_type = filter_input(INPUT_POST, 'txt_type', FILTER_SANITIZE_STRING);
$txt_title = filter_input(INPUT_POST, 'txt_title', FILTER_SANITIZE_STRING);
$txt_summary = filter_input(INPUT_POST, 'txt_summary', FILTER_SANITIZE_STRING);

///////////////////////////////////////////////////
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
  
  return $filedest_url;
}



///////////////////////////////////////////////
$array = array (
		'title' => $txt_title,
		'summary' => $txt_summary,
		'img_stats' => fileupload_process('img_stat'),
		'img_map' => fileupload_process('img_map') 
    );

update_option('dashboard_stats_option_'.$txt_type, $array);
}

$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
if($type){
$result = get_option('dashboard_stats_option_'.$type);
}else{ $type='sme'; $result = get_option('dashboard_stats_option_'.$type);}

?>
<div class="wrap">
<!--    <div id="icon-tools" ></div>-->
    <h2>Dashboard Stat Options</h2>
            <ul class="subsubsub">
            <li class="sme"><a href="?page=portal-dashboard-stats&type=sme" >SME</a>|</li>
            <li class="partner"><a href="?page=portal-dashboard-stats&type=partner" >Partners</a>|</li>
            <li class="provider"><a href="?page=portal-dashboard-stats&type=provider" >Service Providers</a>|</li>
            <li class="investor"><a href="?page=portal-dashboard-stats&type=investor" >Investors</a>|</li>
            <li class="nonprofit"><a href="?page=portal-dashboard-stats&type=nonprofit" >Non-Profit</a>|</li>
            </ul>
           <!-- <p>&nbsp;</p>-->
    <form method="post" action="?page=portal-dashboard-stats"  enctype="multipart/form-data">
        <input type="hidden" name="txt_type" id="txt_type" value="<?php echo $type; ?>" />
        <table class="wp-list-table widefat">
            <thead>
                    <tr>
                        <th colspan="2"><strong>Manage <?php echo $type; ?> dashboard options</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="plugin-title"><strong>Title</strong></td>
                        <td><input type="text" size="75" name="txt_title" id="txt_title" value="<?php echo $result['title'];?>" ></td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Summary</strong></td>
                        <td><textarea rows='7' cols='50' name="txt_summary" id="txt_summary"  ><?php echo $result['summary'];?></textarea></td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>Stats Image</strong></td>
                        <td><input type="file" name="img_stat[]" id="img_stat" />
                        <img src="<?php echo $result['img_stats']; ?>" width="80" height="80"></td>
                    </tr>
                    <tr bgcolor="#EDEDED">
                        <td class="plugin-title"><strong>Map Image</strong></td>
                        <td><input type="file" name="img_map[]" id="img_map" />
                            <img src="<?php echo $result['img_map']; ?>" width="80" height="80"></td>
                    </tr>
                    <tr>
                        <td colspan="2"  >
                            <input type="submit" name="btn_update" id="btn_update" class="button button-primary" value="Update">
                        </td>
                    </tr>
                </tbody>
        </table>
    </form>
    </div>