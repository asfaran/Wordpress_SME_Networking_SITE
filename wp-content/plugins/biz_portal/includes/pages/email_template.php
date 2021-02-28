<?php
/**
 * Page email_template
 * @date :2014/10/06
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

if(isset($_POST['btn_update'])){
        $temp_id = filter_input(INPUT_POST, 'temp_id', FILTER_SANITIZE_STRING);
        $txt_title = filter_input(INPUT_POST, 'txt_title', FILTER_SANITIZE_STRING);
        $content = filter_input(INPUT_POST, 'editorContent', FILTER_SANITIZE_STRING);

       $result=$wpdb->update(_biz_portal_get_table_name('email_templates'),
               array('email_text' => $content,'title' => $txt_title),
               array('id' => $temp_id),
               array('%s','%s'), array('%s'));

     if($result > 0){
     $msg= "<span style='color:green'>Successfully Updated</span>";
     }else{
     $msg= "<span style='color:red'>Please Try again</span>";
     }
}



$sql_table =_biz_portal_get_table_name('email_templates');
$sql = "SELECT * FROM ".$sql_table;
$templates = $wpdb->get_results($sql);

$sql_count = "SELECT COUNT(*) " . $sql_table;
?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Email Template's</h2>
    <?php if($msg){echo "<br/><p><strong>".$msg."</strong></p>";}?> 
    
    <table class="wp-list-table widefat">
                <thead>
                    <tr>
                        <th width="15%"><strong>Template Name</strong></th>
                        <th width="25%"><strong>Title</strong></th>
                        <th width="50%" style='background-color: #ccc'><strong>Text</strong></th>
                        <th width="10%"><strong>Action</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    if($sql_count):
                        foreach ($templates as $template) : 
                        $edit_link = '?page=portal-email-template&action=edit&temp_id=' . $template->id;
                    ?>
                    <tr>
                        <td><?php echo $template->id;  ?></td>
                        <td><?php echo $template->title;  ?></td>
                        <td style='background-color: #ccc'><pre><?php echo $template->email_text;  ?></pre></td>
                        <td><a href='<?php echo $edit_link;  ?>'>Edit</a></td>
                    </tr>
                    <tr><td colspan="4"><?php ?></td></tr>

                    <?php 
                    endforeach;
                    endif;
                    ?>
                </tbody>
</div>