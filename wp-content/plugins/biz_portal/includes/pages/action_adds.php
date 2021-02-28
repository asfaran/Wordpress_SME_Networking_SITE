<?php
/**
 * Page action_adds
 * @date :2014/10/07
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

if($page_action==='add'){
    $tb_title="Add New Advertisment";
    $tb_cols=2;
    
}elseif($page_action==='edit'){
    $add_id = filter_input(INPUT_GET, 'add_id', FILTER_SANITIZE_NUMBER_INT);
    $tb_title="Edit Selected Advertisment";
    $tb_cols=2;
    $sql = "SELECT adds.*,file.path as path FROM " . _biz_portal_get_table_name('advertisements')." as adds
            INNER JOIN " . _biz_portal_get_table_name('files_t')." as file
            ON adds.image_id = file.id 
            WHERE adds.id=$add_id";
$advertisement = $wpdb->get_row($sql);
    
}elseif($page_action==='delete'){
    $add_id = filter_input(INPUT_GET, 'add_id', FILTER_SANITIZE_NUMBER_INT);
    $tb_title="Delete Selected Advertisment";
    $tb_cols=2;
    $sql = "SELECT adds.*,file.path as path FROM " . _biz_portal_get_table_name('advertisements')." as adds
            INNER JOIN " . _biz_portal_get_table_name('files_t')." as file
            ON adds.image_id = file.id 
            WHERE adds.id=$add_id";
    $advertisement = $wpdb->get_row($sql);
    
}



$adds_type=array(
    ADS_TYPE_NEWSROOM =>"News Room",
    ADS_TYPE_RESOURCE =>"Resource",
    ADS_TYPE_LOGIN =>"Login",
    ADS_TYPE_SIDEBAR =>"Side Bar",
    ADS_TYPE_DIRECTORY =>"Directory",
    ADS_TYPE_ABOUT =>"About Us"
    );
?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Advertisement's</h2>
            <ul class="subsubsub">
                <li class="all"><a href="?page=biz-portal-advertisement&action=view" >All Adds</a>|</li>
                <li class="partner"><a href="?page=biz-portal-advertisement&action=add" >Add New</a>|</li>
            </ul>
    <form action="?page=biz-portal-advertisement" name="adds-form" method="post" enctype="multipart/form-data">
    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th colspan="<?php echo $tb_cols ;?>">
                    <strong><?php echo $tb_title; ?></strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if($page_action==='add'): ?>
                    <tr>
                        <td class="plugin-title"><strong>Add Type</strong></td>
                        <td><select name="type_id" id="type_id">
                                <option value="" selected="selected">Select a Type</option>
                                    <?php foreach($adds_type as $key=>$value) {
                                        echo '<option value="' . $key . '">' .$value . '</option>';

                                    }?>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>Upload Image</strong></td>
                        <td><input Type='file' name='file_img' id='file_img' ></td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>URL Link</strong></td>
                        <td><input type='text' name='txt_url' id='txt_url'  size="75" value='' /></td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type='submit' value='submit' name='btn_submit' id='btn_submit' class="button button-primary" >
                            <input type='submit' value='Cancel' name='btn_cancel' id='btn_cancel' class="button button-primary" >
                        </td>
                    </tr>
            <?php elseif($page_action==='edit'): ?>
                    <tr>
                        <td class="plugin-title"><strong>Add Type</strong></td>
                        <td><select name="type_id" id="type_id">
                                    <?php
                                    echo "<option value='".$advertisement->ads_type."' selected='selected'>".$adds_type[$advertisement->ads_type]."</option>";
                                        foreach($adds_type as $key=>$value) {
                                        echo '<option value="' . $key . '">' .$value . '</option>';

                                    }?>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>Upload Image</strong></td>
                        <td>
                            <input Type='file' name='file_img' id='file_img' >
                            <img src="<?php echo $advertisement->path; ?>" width="80" height="80" />
                        </td>
                    </tr>
                    <tr>
                        <td class="plugin-title"><strong>URL Link</strong></td>
                        <td><input type='text' name='txt_url' id='txt_url'  size="75" value='<?php echo $advertisement->link_url; ?>' /></td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type="hidden" value="<?php echo $advertisement->id; ?>" id="add_id" name="add_id" >
                            <input type='submit' value='Update' name='btn_update' id='btn_update' class="button button-primary" >
                            <input type='submit' value='Cancel' name='btn_cancel' id='btn_cancel' class="button button-primary" >
                        </td>
                    </tr>
            <?php  elseif($page_action==='delete'): ?>
                    <tr>
                        <td class="plugin-title" colspan="2">Are You sure?,You want to delete Advertisement on <b><?php echo $adds_type[$advertisement->ads_type];?></b><br/></td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type="hidden" value="<?php echo $advertisement->id;?>" name="add_id" id="add_id" >
                            <input type="hidden" value="<?php echo $advertisement->image_id;?>" name="image_id" id="image_id" >
                            <input type='submit' value='Delete' name='btn_delete' id='btn_delete' class="button button-primary" >
                            <input type='submit' value='Cancel' name='btn_cancel' id='btn_cancel' class="button button-primary" >
                        </td>
                    </tr>
            <?php endif;?>
                   
        </tbody>
        
    </table>
    </form>
    
</div>