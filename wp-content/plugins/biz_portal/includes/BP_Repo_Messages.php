<?php

class BP_Repo_Messages extends BP_BaseRepository
{
    
    /**
     * Add new private message
     * 
     * @param BP_PrivateMessage $Message
     * @return bool
     */
	public function send_message(BP_PrivateMessage $Message)
	{
	    $errors = 0;
	    $this->db->query('START TRANSACTION');
	    
	    $Message->owner_id = $Message->to_company_id;
	    $message_array = $Message->to_array();
	    $res = $this->db->insert($this->get_table_name(BP_PrivateMessage::$table_name), 
	            $message_array, $this->table_def->table_def_private_message);
	    
	    if (!$res) $errors++;
	    
	    $Message->id = 0;
	    $Message->owner_id = $Message->from_company_id;
	    $message_array = $Message->to_array();
	    $res = $this->db->insert($this->get_table_name(BP_PrivateMessage::$table_name),
	            $message_array, $this->table_def->table_def_private_message);
	    
	    if (!$res) $errors++;
	    
	    error_log('ERRORS : ' . $errors);
	    
	    if ($errors == 0) {
	        $this->db->query('COMMIT');
	        return true;
	    }
	    else {
	        $this->db->query('ROLLBACK');
	        return false;
	    }
	}
	
	/**
	 * Mark the private message as read
	 * 
	 * @param int $message_id
	 * @return bool
	 */
	public function mark_as_read($message_id, $owner_id)
	{
	    $data = array(
	        'is_read' => 1
	    );
	    
	    $res = $this->db->update($this->get_table_name(BP_PrivateMessage::$table_name), 
	            $data, array('id' => $message_id, 'owner_id' => $owner_id), array('%d'), array('%d', '%d'));
	    
	    return $res;
	}
	
	
	/**
	 * Get the number of new messages | unread
	 * 
	 * @param int $company_id
	 * @return int
	 */
	public function count_new_messages($company_id)
	{
	    $sql = "SELECT COUNT(*) FROM " . 
	        $this->get_table_name(BP_PrivateMessage::$table_name) .
	        " WHERE to_company_id = %d && owner_id = '%d' AND is_read = 0";
	    $sql = sprintf($sql, $company_id, $company_id);
	    $count = $this->db->get_var($sql);
	    return $count;
	}
	
	/**
	 * Search messsages
	 * 
	 * @param array $where
	 * @param array $format
	 * @param int $count
	 * @param int $offset
	 * @return ViewModel_Messages
	 */
	public function search_message(array $where = array(), array $format = array(), $count = 0, $offset = 0)
	{
	    $ViewModel_Messages = new ViewModel_Messages();
	    $ViewModel_Messages->count = $count;
	    $ViewModel_Messages->offset = $offset;
	    
	    $sql_count = parent::create_sql_select_count(BP_PrivateMessage::$table_name, $where, $format);
	    $ViewModel_Messages->total = $this->db->get_var($sql_count);
	    
	    $sql = parent::create_sql_select_all(BP_PrivateMessage::$table_name, $where, $format, $count, $offset);
	    $results = $this->db->get_results($sql, ARRAY_A);
	    
	    $messages = array();
	    if ($results && is_array($results)) {
	        $messages = $this->map_result('BP_PrivateMessage', $results);
	    }
	    $ViewModel_Messages->messages = $messages;
	    
	    return $ViewModel_Messages;
	}
	
	/**
	 * Delete array of messages by id
	 * 
	 * @param array int $ids
	 */
	public function delete_messages(array $ids)
	{
	    $ids_c = array();
	    foreach ($ids as $id)
	    {
	        if (is_numeric($id))
	            $ids_c[] = $id;
	    }
	    if (count($ids_c) == 0) return 0;
	    $delete_ids = implode(',', $ids_c);
	    $sql = "DELETE FROM " . $this->get_table_name(BP_PrivateMessage::$table_name) . " WHERE id in (" . $delete_ids . ")";
	    
	    $count = $this->db->query($sql);
	    return $count;	    
	}
}

























