<?php

/**
 * Class BP_Repo_Favourites
 *
 * @package BizPortal_WP_Module
 * @subpackage Repository_Nodes
 * @author SWISS BUREAU
 */
class BP_Repo_Favourites extends BP_BaseRepository
{
    /**
     * Class constructor
     *
     * @param wpdb $dbObject
     * @param string $table_prefix
     */
    public function __construct(wpdb $dbObject, $table_prefix)
    {
        parent::__construct($dbObject, $table_prefix);
        $this->db = $dbObject;
        $this->table_prefix = $table_prefix;
    }
    
    /**
     * Check if is favourited
     * 
     * @param int $s_company_id
     * @param int $t_company_id
     */
    public function is_favourited($s_company_id, $t_company_id)
    {
        $sql = "SELECT COUNT(*) FROM " . $this->get_table_name(BP_Favourite::$table_name) . 
            " WHERE company_id = %d AND target_company_id = %d";
        $sql = sprintf($sql, $s_company_id, $t_company_id);
        
        $count = $this->db->get_var($sql);
        if ($count > 0)
            return true;
        else
            return false;
    }
    
    /**
     * Add favourite
     * 
     * @param int $s_company_id
     * @param int $t_company_id
     */
	public function add_favourite($s_company_id, $t_company_id)
	{
	    if ($this->is_favourited($s_company_id, $t_company_id))
	        return true;
	    
	    $data = array(
	            'company_id' => $s_company_id,
	            'target_company_id' => $t_company_id,
        );
	    
	    $res = $this->db->insert($this->get_table_name(BP_Favourite::$table_name), 
	            $data, array('%d', '%d'));
	    
	    if ($res > 0)
	        return true;
	    
	    return false;
	}
	
	/**
	 * Add favourite
	 *
	 * @param int $s_company_id
	 * @param int $t_company_id
	 */
	public function remove_favourite($s_company_id, $t_company_id)
	{
	    if (!$this->is_favourited($s_company_id, $t_company_id))
	        return true;
	     
	    $where = array(
	            'company_id' => $s_company_id,
	            'target_company_id' => $t_company_id,
	    );
	     
	    $res = $this->db->delete($this->get_table_name(BP_Favourite::$table_name), $where, array('%d', '%d'));
	     
	    if ($res >= 0)
	        return true;
	    
	    return $res;
	}
	
	/**
	 * 
	 * 
	 * @param int $company_id
	 * @return array BP_Favourite
	 */
	public function get_list($company_id)
	{
	    $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Favourite::$table_name, 'f') .
	        ", " . $this->get_prefixed_table_columns(BP_Company::$table_name, 'c', 'company_') .
	        " FROM " . $this->get_table_name(BP_Favourite::$table_name) . " f" .
	        " LEFT JOIN " . $this->get_table_name(BP_Company::$table_name) . " c ON c.id = f.target_company_id" . 
	        " WHERE f.company_id = " . $company_id . " ORDER BY created DESC";
	    
	    $results = $this->db->get_results($sql, ARRAY_A);
	    	    
	    $return_result = array();
	    	    
	    foreach ($results as $res)
	    {
	        if (array_key_exists($res['target_company_id'], $return_result))
	            $fav = $return_result[$res['target_company_id']];
	        else {
	            $fav = new BP_Favourite();
	            BP_Hydrator::hydrate($fav, $res);
	        }
	        
	        $BP_Company = new BP_Company();
	        BP_Hydrator::hydrate($BP_Company, $res, 'company_');
	        $fav->target_company = $BP_Company;
	        	
	        $return_result[$res['target_company_id']] = $fav;	        
	    }
	    
	    return $return_result;
	}
}