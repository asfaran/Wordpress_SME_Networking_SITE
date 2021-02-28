<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$current=filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);
            if (!$current){
            $current = 'option'; }
    
   

            
            
if(isset($_POST['btn_submit'])){
    
    
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
              $view_result = get_option('contact_page_content'); 
               return $view_result[$img_id];
          }
}
    

    update_option('about_page_row_one', filter_input(INPUT_POST, 'about_page_row_one', FILTER_SANITIZE_STRING));
    update_option('about_page_row_two', filter_input(INPUT_POST, 'about_page_row_two', FILTER_SANITIZE_STRING));
    update_option('about_page_row_three', filter_input(INPUT_POST, 'about_page_row_three', FILTER_SANITIZE_STRING));
    
    
    update_option('ads_page_row_one', filter_input(INPUT_POST, 'ads_page_row_one', FILTER_SANITIZE_STRING));
    update_option('ads_page_row_two', filter_input(INPUT_POST, 'ads_page_row_two', FILTER_SANITIZE_STRING));
    update_option('ads_page_row_three', filter_input(INPUT_POST, 'ads_page_row_three', FILTER_SANITIZE_STRING));
    
    
    $filter = array(
        'post' => FILTER_VALIDATE_INT  ,
        'title' => FILTER_SANITIZE_STRING  ,
        'footer' => FILTER_SANITIZE_STRING  ,
        'url' => FILTER_SANITIZE_URL  
        );
  update_option('policy_page_main',$_POST['policy_page_main']);
  update_option('policy_page_side_one',$_POST['policy_page_side_one']);
  update_option('policy_page_side_two', $_POST['policy_page_side_two']);
  update_option('policy_page_side_three', $_POST['policy_page_side_three']);
  
  update_option('terms_page_main',$_POST['terms_page_main']);
  update_option('terms_page_side_one',$_POST['terms_page_side_one']);
  update_option('terms_page_side_two', $_POST['terms_page_side_two']);
  update_option('terms_page_side_three', $_POST['terms_page_side_three']);
  
  $contact_page_data =$_POST['contact_page_content'];
  $contact_page_data['map_pointer'] = fileupload_process('map_pointer');
  $contact_page_data['form_img'] = fileupload_process('form_img');
  
  update_option('contact_page_content', $contact_page_data);
  
}

        $page_args = array(
                    'sort_order' => 'ASC',
                    'sort_column' => 'post_title',
                    'hierarchical' => 0,
                    'exclude' => '',
                    'include' => '',
                    'meta_key' => '',
                    'meta_value' => '',
                    'authors' => '',
                    'child_of' => 0,
                    'parent' => -1,
                    'exclude_tree' => '',
                    'number' => '',
                    'offset' => 0,
                    'post_type' => 'page',
                    'post_status' => 'publish,private'
                    );
        $pages = get_pages($page_args);
        
        
        
       // $posts = new WP_Query ( $post_args );
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
        
        $contact_result=get_option('contact_page_content'); 
?>
<style>
    .form-table td {
        padding :9px 10px;
    }
</style>

<div class="wrap">
        <h2>Manage Page's</h2>
        Manage Front Page content        
        <form action="admin.php?page=biz-portal-pages&tab=<?php echo $current; ?>" method="post"  enctype="multipart/form-data">
           

            <h2 class="nav-tab-wrapper">
            <?php $class = ( $current === "option") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-pages&tab=option">About Content</a>
            <?php $class = ( $current === "ads") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-pages&tab=ads">Ads Content</a>
            <?php  $class = ( $current === "contact") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-pages&tab=contact">Manage Contact</a>
            <?php  $class = ( $current === "policy") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-pages&tab=policy">Privacy & Policy Content</a>
            <?php $class = ( $current === "terms") ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=biz-portal-pages&tab=terms">Terms Of Use Content</a>
            
            
           <?php $class_v = ( "option" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Page(About) Options</h2>
                <table class="form-table">
                <tr valign="top">
                    <td scope="row">About Page Row One</td>
                    <td><select name="about_page_row_one">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('about_page_row_one')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name: 'about_page_row_one'</p>
                    </td>
                </tr>
                <tr>
                    <td scope="row">About Page Row Two</td>
                    <td><select name="about_page_row_two">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('about_page_row_two')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name: 'about_page_row_two'</p>
                    </td>
                </tr>
                <tr>
                    <td scope="row">About Page Row Three</td>
                    <td><select name="about_page_row_three">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('about_page_row_three')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name:  'about_page_row_three'</p>
                    </td>     
                </tr>
                </table>
            </div> 
            </h2>
            <!-- ========================================== About End ================================--->
            
            <!-- ========================================== Ads start ================================--->
            <?php $class_v = ( "ads" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Page(Ads) Options</h2>
                <table class="form-table">
                <tr valign="top">
                    <td scope="row">Ads Page Row One</td>
                    <td><select name="ads_page_row_one">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('ads_page_row_one')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name: 'ads_page_row_one'</p>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Ads Page Row Two</td>
                    <td><select name="ads_page_row_two">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('ads_page_row_two')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name: 'ads_page_row_two'</p>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Ads Page Row Three</td>
                    <td><select name="ads_page_row_three">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('ads_page_row_three')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name:  'ads_page_row_three'</p>
                    </td>     
                </tr>
                </table>
            </div> 
            </h2>
            <!-- ========================================== Ads end ================================--->
            
            <!-- ========================================== Contact start ================================--->
            <?php  $class_v = ( "contact" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Manage Contact Page</h2>
                <table class="form-table">
                <tr valign="top">
                    <td scope="row">Map Location</td>
                    <td>Latitude:&nbsp;&nbsp;
                        <input type="text" name="contact_page_content[map_lat]" size="25" value="<?php echo $contact_result['map_lat']; ?>"><br>
                        Longitude:<input type="text" name="contact_page_content[map_lng]" size="25" value="<?php echo $contact_result['map_lng']; ?>">
                    </td>
                </tr>
                <tr>
                    <td scope="row">Map Pointer</td>
                    <td><input type="file" name="map_pointer[]" id="map_pointer" />
                            <?php if($contact_result['map_pointer']){ ?>
                            <img src="<?php echo $contact_result['map_pointer']; ?>" >
                            <?php }else { echo "<span style='color:red;'>Still there no map pointer image</span>"; } ?>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Contact Form Image</td>
                    <td><input type="file" name="form_img[]" id="form_img" />
                            <?php if($contact_result['form_img']){ ?>
                            <img src="<?php echo $contact_result['form_img']; ?>" >
                            <?php }else { echo "<span style='color:red;'>Still there no contact form image</span>"; } ?></td>     
                </tr>
                <tr>
                    <td scope="row">Pointer Image-PopUp Content</td>
                    <td><textarea  name="contact_page_content[place_text]" id=""  ><?php echo $contact_result['place_text']; ?></textarea>
                    </td>     
                </tr>
                <tr>
                    <td scope="row">Thanks Message</td>
                    <td><textarea  name="contact_page_content[thanks_text]" cols="70" rows="6"><?php echo $contact_result['thanks_text']; ?></textarea>
                    </td>     
                </tr>
                <tr>
                    <td scope="row">Support Mail</td>
                    <td><input type="text" name="contact_page_content[mail]" size="50" value="<?php echo $contact_result['mail']; ?>"></td>     
                </tr>
                <tr>
                    <td scope="row">Form Title</td>
                    <td><input type="text" name="contact_page_content[title]" size="50" value="<?php echo $contact_result['title']; ?>"></td>     
                </tr>
                </table>
            </div> 
            </h2>
            <!-- ========================================== Contact end ================================--->
            
            <!-- ========================================== policy start ================================--->
            
            <?php  $class_v = ( "policy" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Privacy&Policy Page Content</h2>
                <table class="form-table">
                <tr valign="top" >
                    <td scope="row">Main Content</td>
                    <td colspan='2'><select name="policy_page_main">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('policy_page_main')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name: 'policy_page_main'</p>
                    </td>
                </tr>
                
                <?php $first_side = get_option('policy_page_side_one'); ?>
                <tr  style=' background-color: seashell'>
                    <td scope="row" rowspan='4'>Side Bar Content-ONE</td>
                    <td width='15%'>[1] Related Post:</td>
                    <td><select name="policy_page_side_one[post]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <?php if ($post->ID ==$first_side['post'] ) : ?>
                                        <option selected="selected" value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                    </td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[2] SideBar Title:</td>
                    <td><textarea name="policy_page_side_one[title]"><?php echo $first_side['title']; ?></textarea></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td>[3] SideBar Footer:</td>
                    <td><input type="text" name="policy_page_side_one[footer]"  value="<?php echo $first_side['footer']; ?>"></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[4] SideBar Footer URL:</td>
                    <td><input type="text" name="policy_page_side_one[url]"  value="<?php echo $first_side['url']; ?>"></td>
                </tr>
                
                <?php $second_side = get_option('policy_page_side_two'); ?>
                <tr >
                    <td scope="row" rowspan='4'>Side Bar Content-TWO</td>
                    <td width='15%'>[1] Related Post:</td>
                    <td><select name="policy_page_side_two[post]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <?php if ($post->ID == $second_side['post']) : ?>
                                        <option selected="selected" value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                    </td>
                </tr>
                <tr>
                    <td >[2] SideBar Title:</td>
                    <td><textarea name="policy_page_side_two[title]" ><?php echo $second_side['title']; ?></textarea></td>
                </tr>
                <tr>
                    <td>[3] SideBar Footer:</td>
                    <td><input type="text" name="policy_page_side_two[footer]" value="<?php echo $second_side['footer']; ?>"></td>
                </tr>
                <tr>
                    <td >[4] SideBar Footer URL:</td>
                    <td><input type="text" name="policy_page_side_two[url]"  value="<?php  echo $second_side['url']; ?>"></td>
                </tr>
                <?php $third_side = get_option('policy_page_side_three'); ?>
                <tr  style=' background-color: seashell'>
                    <td scope="row" rowspan='4'>Side Bar Content-THREE</td>
                    <td width='15%'>[1] Related Post:</td>
                    <td><select name="policy_page_side_three[post]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <?php if ($post->ID ==$third_side['post'] ) : ?>
                                        <option selected="selected" value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                    </td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[2] SideBar Title:</td>
                    <td><textarea name="policy_page_side_three[title]" ><?php echo $third_side['title']; ?></textarea></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td>[3] SideBar Footer:</td>
                    <td><input type="text" name="policy_page_side_three[footer]" value="<?php echo $third_side['footer']; ?>"></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[4] SideBar Footer URL:</td>
                    <td><input type="text" name="policy_page_side_three[url]"  value="<?php  echo $third_side['url']; ?>"></td>
                </tr>
                
                </table>
            </div> 
            </h2>
            <!-- ========================================== policy end ================================--->
            
            
            <!-- ========================================== terms start ================================--->
            <?php $class_v = ( "terms" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>TermsOfUse Page Content</h2>
                <table class="form-table">
                <tr valign="top" >
                    <td scope="row">Main Content</td>
                    <td colspan='2'><select name="terms_page_main">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('terms_page_main')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                        <p>Option Name: 'terms_page_main'</p>
                    </td>
                </tr>
                
                <?php $t_first_side = get_option('terms_page_side_one'); ?>
                <tr  style=' background-color: seashell'>
                    <td scope="row" rowspan='4'>Side Bar Content-ONE</td>
                    <td width='15%'>[1] Related Post:</td>
                    <td><select name="terms_page_side_one[post]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <?php if ($post->ID ==$t_first_side['post'] ) : ?>
                                        <option selected="selected" value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                    </td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[2] SideBar Title:</td>
                    <td><textarea name="terms_page_side_one[title]"><?php echo $t_first_side['title']; ?></textarea></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td>[3] SideBar Footer:</td>
                    <td><input type="text" name="terms_page_side_one[footer]"  value="<?php echo $t_first_side['footer']; ?>"></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[4] SideBar Footer URL:</td>
                    <td><input type="text" name="terms_page_side_one[url]"  value="<?php echo $t_first_side['url']; ?>"></td>
                </tr>
                
                <?php $t_second_side = get_option('terms_page_side_two'); ?>
                <tr >
                    <td scope="row" rowspan='4'>Side Bar Content-TWO</td>
                    <td width='15%'>[1] Related Post:</td>
                    <td><select name="terms_page_side_two[post]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <?php if ($post->ID == $t_second_side['post']) : ?>
                                        <option selected="selected" value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                    </td>
                </tr>
                <tr>
                    <td >[2] SideBar Title:</td>
                    <td><textarea name="terms_page_side_two[title]" ><?php echo $t_second_side['title']; ?></textarea></td>
                </tr>
                <tr>
                    <td>[3] SideBar Footer:</td>
                    <td><input type="text" name="terms_page_side_two[footer]" value="<?php echo $t_second_side['footer']; ?>"></td>
                </tr>
                <tr>
                    <td >[4] SideBar Footer URL:</td>
                    <td><input type="text" name="terms_page_side_two[url]"  value="<?php  echo $t_second_side['url']; ?>"></td>
                </tr>
                <?php $t_third_side = get_option('terms_page_side_three'); ?>
                <tr  style=' background-color: seashell'>
                    <td scope="row" rowspan='4'>Side Bar Content-THREE</td>
                    <td width='15%'>[1] Related Post:</td>
                    <td><select name="terms_page_side_three[post]">
                            <option value="">[SELECT ONE]</option>
                            <?php if (is_array($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <?php if ($post->ID ==$t_third_side['post'] ) : ?>
                                        <option selected="selected" value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select><br/>
                    </td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[2] SideBar Title:</td>
                    <td><textarea name="terms_page_side_three[title]" ><?php echo $t_third_side['title']; ?></textarea></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td>[3] SideBar Footer:</td>
                    <td><input type="text" name="terms_page_side_three[footer]" value="<?php echo $t_third_side['footer']; ?>"></td>
                </tr>
                <tr style=' background-color: seashell'>
                    <td >[4] SideBar Footer URL:</td>
                    <td><input type="text" name="terms_page_side_three[url]"  value="<?php  echo $t_third_side['url']; ?>"></td>
                </tr>
                
                </table>
            </div> 
            </h2>
    
        <p class="submit">
        <input id="btn_submit" class="button button-primary" type="submit" value="Save Changes" name="btn_submit">
        </p>
        </form>
    </div>