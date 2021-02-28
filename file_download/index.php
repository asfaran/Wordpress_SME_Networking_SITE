<?php
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
//require( dirname( __FILE__ ) . '/../wp-blog-header.php' );

//require_once( ABSPATH . WPINC . '/../template-loader.php' );
if ( !isset($wp_did_header) ) {

    $wp_did_header = true;

    require_once( dirname(__FILE__) . '/../wp-load.php' );

    //wp();

    //require_once( ABSPATH . WPINC . '/template-loader.php' );

}

$file_id = filter_input(INPUT_GET, 'file_id', FILTER_SANITIZE_STRING);
$download = filter_input(INPUT_GET, 'download', FILTER_VALIDATE_INT);
$thumbnail = filter_input(INPUT_GET, 'thumb', FILTER_VALIDATE_INT);
$default = filter_input(INPUT_GET, 'default', FILTER_VALIDATE_INT);
$width = filter_input(INPUT_GET, 'w', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
$height = filter_input(INPUT_GET, 'h', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
if (is_null($download)) $download = 0;
if (is_null($thumbnail)) $thumbnail = 0;
if (is_null($default)) $default = 0;

$root = substr(ABSPATH, 0, -1);


if (!is_null($file_id) || $default == 1) {   
    $file_obj = new BP_File();
    $use_default == false;
    if ($file_id > 0) {
        $file_obj = biz_portal_load_file($file_id);    
        if (!$file_obj->path || !file_exists( $root . $file_obj->path)) {
            //file_not_found();
            if ($default == 1) $use_default = 1;
            else file_not_found();
        }
    }
    else {
        $use_default = 1;
    }
    
    if($use_default) {   
        $file_obj = new BP_File();
        $file_obj->path = '/upload/php/files/default.jpeg';
        $file_obj->mime_type = 'image/jpg';
        $file_obj->extension = '.jpg';
        $file_obj->is_image = 1;
        $file_obj->size_bytes = '50000';
    }
        
    $file = $file_obj->to_array();
       
    if (isset($file['path'])) {
        $file['path'] = $root . $file['path'];
    }    
    
    if ($thumbnail == 1)
    {
        $thumb_path = substr($file_obj->path, 0, strrpos($file_obj->path, '/')) . '/thumbnail/' . basename($file_obj->path);
        $file['path'] = $root . $thumb_path;
    }
    
    if ($file_obj->is_image == 1 && $width > 0 && $height > 0) 
    {
        $base_name = basename($file['path']);
        $resized_name = $width . 'x' . $height . '_' . $base_name;
        $resized_path = substr($file['path'], 0, -(strlen($base_name))) . $resized_name;
        
        if (!file_exists($resized_path))
        {            
            list($w, $h) = GetimageSize($file['path']);
            $new_width = $width; $new_height = $height;
            // Choose the min percentage
            $perc_width = (($new_width/$w)*100);
            $perc_height = (($new_height/$h)*100);            
            $perc_resize = min(array($perc_height, $perc_width));
            // set the new size
            $new_width = ceil(($w/100)*$perc_resize);
            $new_height = ceil(($h/100)*$perc_resize);
            
            $images_orig = NULL;
            $Imagefunction = '';
            switch ($file['mime_type']) {
                case 'image/jpeg':
                case 'image/jpg':
                    $images_orig = imagecreatefromjpeg($file['path']);
                    $Imagefunction = 'imagejpeg'; 
                    break;
                case 'image/png':
                    $images_orig = imagecreatefrompng($file['path']);
                    $Imagefunction = 'imagepng';
                    break;
                case 'image/gif':
                    $images_orig = imagecreatefromgif($file['path']);
                    $Imagefunction = 'imagegif';
                    break;
            }
            
            if ($images_orig != NULL && !empty($Imagefunction)) {
                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);
                $images_fin = ImageCreateTrueColor($new_width, $new_height);
                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $new_width+1, $new_height+1, $photoX, $photoY);
                call_user_func($Imagefunction, $images_fin, $resized_path);
                $file['path'] = $resized_path;
                ImageDestroy($images_orig);
                ImageDestroy($images_fin);
            }           
        }
        else {
            $file['path'] = $resized_path;
        }
    }
    

    if (isset($file['path'])) {
        if ($download == 1) {
            header('Content-Description: File Transfer');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
        }
        
        header("Content-Type: " . $file['mime_type']);
        header('Content-Length: ' . filesize($file['path']));
        if ($download == 1)
            header('Content-Disposition: attachment; filename='. basename($file['path']));
        ob_clean();
        flush();
        readfile($file['path']);
        exit;
    }
    else {
        file_not_found();
    }
}
else {
    file_not_found();
}

function file_not_found() {
    header('Content-Type: image/jpg');
    header("HTTP/1.0 404 Not Found", true, 404);    
    die();
}