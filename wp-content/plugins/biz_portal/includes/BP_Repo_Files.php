<?php

/**
 * Class BizPortalRepo
 * 
 * @package BizPortal_WP_Module
 * @subpackage Repository_Files
 * @author SWISS BUREAU
 */

class BP_Repo_Files extends BP_BaseRepository
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
	 * Save file object
	 * 
	 * @param BP_File $file
	 * @return int|bool
	 */
	public function save_file(BP_File $file)
	{
	    $BP_File_array = $file->to_array();
	    
	    $res = $this->db->insert($this->get_table_name(BP_File::$table_name), 
	            $BP_File_array,  $this->table_def->table_def_files_t);
	    
	    if ($res)
	        return $this->db->insert_id;
	    else
	        return $res;
	}
	
	
	/**
	 * Add usage remarks for file
	 * 
	 * @param int $file_id
	 */
	public function add_file_usage($file_id)
	{
	   $res = $this->db->update($this->get_table_name(BP_File::$table_name), 
	           array('file_usage' => 1), array('id' => $file_id), array(), array('%d'));

	   return $res;
	}
	
	/**
	 * Remove file usage. It sets the status to be deleted.
	 * 
	 * @param int $file_id
	 */
	public function remove_file_usage($file_id)
	{
		$res = $this->db->update($this->get_table_name(BP_File::$table_name),
				array('file_usage' => 0), array('id' => $file_id), array(), array('%d'));
	}
	
	public function load_file($file_id)
	{
	    $sql = "SELECT * FROM " . $this->get_table_name(BP_File::$table_name) . " WHERE id = %d";
	    $sql = sprintf($sql, $file_id);
	    $results = $this->db->get_results($sql, ARRAY_A);
	    if ($results) {
    	    $files = $this->map_result('\BP_File', $results);
    	    return $files[$file_id];
	    }
	    return false;
	}
}