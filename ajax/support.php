<?php

function profile_additional_validate($posts) {
    $validators = array(
            'logo_id' => FILTER_VALIDATE_INT,
            'squre_image_id' => FILTER_VALIDATE_INT,
            'profile_about' => FILTER_SANITIZE_STRING,
            'attachment' => FILTER_VALIDATE_INT,
            'attachment_text' => FILTER_SANITIZE_STRING,
    );
    
    return filter_var_array($posts, $validators);
}

function profile_save(wpdb $db, $company_id, $values) {
    $BP_TableDefinitions = new BP_TableDefinitions();
    
    $profile = biz_portal_get_company_profile($company_id);
    $profile_found = false;
    if ($profile && $profile instanceof BP_CompanyProfile) {
        $profile_found = true;
    }
    else {
        $profile = new BP_CompanyProfile();
    }
    
    if (isset($values['profile_about']))
        $profile->body = $values['profile_about'];
    
    if (isset($values['logo_id']))
        $profile->logo_id = $values['logo_id'];
    
    if (isset($values['squre_image_id']))
        $profile->squre_image_id = $values['squre_image_id'];
    
    $profile->company_id = $company_id;
    
    /*$sql = "SELECT count(*) FROM " . _biz_portal_get_table_name(BP_CompanyProfile::$table_name) . " WHERE company_id = %d";
    $sql = sprintf($sql, $company_id);
    $found = $db->get_var($sql);*/
    
    if ($profile_found) {
        $res = $db->update(_biz_portal_get_table_name(BP_CompanyProfile::$table_name), 
                $profile->to_array(), 
                array('company_id' => $company_id));
        
        if ($res > 0)
            return true;
        
        return $res;
    }
    else {
        $res = $db->insert(_biz_portal_get_table_name(BP_CompanyProfile::$table_name), 
                $profile->to_array(), $BP_TableDefinitions->table_def_company_profile);
        
        return $res;
    }
}

function attachment_save(wpdb $db, $company_id, $values) {
    
    if (!isset($values['attachment']) || empty($values['attachment']))
        return;
    
    if (empty($values['attachment_text']))
        $values['attachment_text'] = 'Signup attachment';
    
    $BP_TableDefinitions = new BP_TableDefinitions();
    $repo = new BP_Repo_Nodes($db, biz_portal_get_table_prefix());
    
    $node = new BP_Node();
    $node->company_id = $company_id;
    $node->node_type = BP_Node::NODE_TYPE_DOWNLOAD;
    $node->title = $values['attachment_text'];
    $node->body = $values['attachment_text'];
    $node->active = 1;
    $node->add_attachment(new BP_File($values['attachment']));
    
    // save node
    return $repo->update_node($node);
}