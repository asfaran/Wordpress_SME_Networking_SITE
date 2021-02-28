<?php
/**
 * Page action_template
 * @date :2014/10/06
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

$temp_id = filter_input(INPUT_GET, 'temp_id', FILTER_SANITIZE_STRING);


$sql_query = " FROM  "._biz_portal_get_table_name('email_templates');
$sql = "SELECT * " . $sql_query;
$sql .=" where id='" .$temp_id."'";
$template = $wpdb->get_row($sql);

switch ($temp_id) {
    case 'NODE_ACTIVATED':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@CONTACTNAME  *@CONTENTTITLE  *@CONTENTURL";
        break;
    case 'NODE_CREATED':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@FROMCOMPANY  *@CONTENTTITLE  *@CONTENTURL";
        break;
    case 'PRIVATE_MESSAGE_NEW':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@CONTACTNAME  *@FROMCOMPANY  *@MESSAGE  *@LINKURL";
        break;
    case 'PRIVATE_MESSAGE_REP':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@CONTACTNAME";
        break;
    case 'WELCOME':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@CONTACTNAME  *@LOGINURL  *@CONTACTEMAIL  *@PASSWORD";
        break;
    case 'REG_REJECTED':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@FROMCOMPANY  *@CONTENTTITLE  *@CONTENTURL";
        break;
    case 'RESRC_APPROVED':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@FROMCOMPANY  *@CONTENTTITLE  *@CONTENTURL";
        break;
    case 'SIGNUP':
        $variable_list = "These Variable's Can use for this Template:<br/>";
        $variable_list .= "*@CONTACTNAME  *@SITENAME ";
        break;
}

?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Email Template</h2>
<!--    <p>&nbsp;</p>-->
    
    <form action='?page=portal-email-template' method='post' enctype='multipart/form-data'>
        <table class="wp-list-table widefat">
            <tr>
                <td>Template Name</td>
                <td><input type='hidden' name='temp_id' id='temp_id' value='<?php echo $temp_id ?>' />
                    <input type='text' readonly='readonly' size='<?php echo strlen($template->id); ?>' value='<?php echo $template->id;?>'></td>
            </tr>
            <tr>
                <td>Title</td>
                <td><input type='text' name='txt_title' id='txt_title' value='<?php echo $template->title;?>'></td>
            </tr>
            <tr>
                <td>Text</td>
                <td><textarea rows='7' cols='100' name='editorContent' ><?php echo $template->email_text;  ?></textarea></td>
            </tr>
            <tr>
                <td colspan='2'><center><strong><?php echo $variable_list; ?></strong></center></td>
            </tr>
            <tr>
                <td colspan='2' align='right'>
                    <input type='submit' name='btn_cancel' id='btn_cancel' value='cancel'  class='button button-primary'>
                    <input type='submit' name='btn_update' id='btn_update' value='Update Template'  class='button button-primary'>
                </td>
            </tr>
        </table>
   
</form>
</div>