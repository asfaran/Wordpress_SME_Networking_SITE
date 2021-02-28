<?php

class BP_RoleManager
{
    private $db;
    private $prefix;
    private $tbl_name_roles;
    
    public function __construct(wpdb $dbObject, $table_prefix)
    {
        if (!is_object($dbObject))
        {
            throw new Exception("DB Object not found. Class BP_RoleManager.");
        }
        $this->db = $dbObject;
        $this->prefix = $table_prefix;
    }
}

