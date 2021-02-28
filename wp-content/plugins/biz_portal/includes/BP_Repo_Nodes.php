<?php
/**
 * Class BizPortalRepo
 * 
 * @package BizPortal_WP_Module
 * @subpackage Repository_Nodes
 * @author SWISS BUREAU
 */

class BP_Repo_Nodes extends BP_BaseRepository
{
    
    /**
     * Delete nodes
     * 
     * @param int $node_id
     */
    public function delete($node_id)
    {
        if (!$node_id > 0) return;
        
        $res = $this->db->delete($this->get_table_name(BP_Node::$table_name), 
                array('id' => $node_id), array('%d'));
        
        return $res;
    }
    
	/**
	 * Update node
	 * 
	 * @param BP_Node $node
	 * @return BP_Node
	 */
	public function update_node(BP_Node $node)
	{
		$errors = 0;
		$node_array = $node->to_array();

		// Start a transaction
		$this->db->query('START TRANSACTION');

		if ($node->id > 0)
		{
		    $update = $this->db->update($this->get_table_name(BP_Node::$table_name),
		            $node_array, array('id' => $node->id), $this->table_def->table_def_nodes, array('%d'));
           
			if (!is_int($update))
			    $errors++;
			
		}
		else {
			$insert = $this->db->insert($this->get_table_name(BP_Node::$table_name), 
				$node_array, $this->table_def->table_def_nodes);

			if ($insert)
				$node->id = $this->db->insert_id;
			else
				$errors++;
		}

		// Delete the current relations
		$this->db->delete($this->get_table_name('node_attachment'), 
			array('node_id' => $node->id), array('%d'));
		// Add relations if available
		if (is_array($node->attachments) && count($node->attachments) > 0) 
		{
			foreach ($node->attachments as $file) 
			{
				$file_array = $file->to_array();
				$attachment_array = array(
					'node_id' => $node->id,
					'file_id' => $file->id,
				);
				
				$insert = $this->db->insert($this->get_table_name('node_attachment'), $attachment_array, array('%d', '%d'));
				if (!$insert)
					$errors++;
			}
		}
				
		// Delete the current categories
		$this->db->delete($this->get_table_name('nodes_categories'),
		        array('node_id' => $node->id), array('%d'));
		
		if (is_array($node->categories) && count($node->categories))
		{
		    foreach ($node->categories as $category)
		    {
		        $categories_nodes_array = array(
		            'category_id' => $category->id,
		            'node_id' => $node->id,
		        );
		        $insert = $this->db->insert($this->get_table_name('nodes_categories'), $categories_nodes_array, array('%d', '%d'));
		        if (!$insert)
		            $errors++;
		    }
		}
		

		// Commit or rollback a transaction depending on the error state
		if ($errors == 0) {
    		$this->db->query('COMMIT');
    		return $node->id;
    	}
    	else {
    		$this->db->query('ROLLBACK');
    		return false;
    	}
	}
	
	/**
	 * Find all categories
	 * 
	 * @param bool $load_user_value
	 * @param string $type Type from BP_Node::NODE_TYPE_* if any
	 * @return array
	 */
	public function find_categories($load_user_value = false, $type = '')
	{
	    $sql = "SELECT cat.* FROM " . $this->get_table_name(BP_NodeCategory::$table_name) . " cat";
	    if (!empty($type)) {
	        if ($type === BP_Node::NODE_TYPE_DOWNLOAD 
	                || $type === BP_Node::NODE_TYPE_POST 
	                || $type === BP_Node::NODE_TYPE_RESOURCE) 
	        {
	            $sql .= " INNER JOIN " . $this->get_table_name('nodes_categories') . " ncat ON ncat.category_id = cat.id";
	            $sql .= " LEFT JOIN " . $this->get_table_name(BP_Node::$table_name) . " node ON node.id = ncat.node_id";
	        }	        
	    }
	    if (!$load_user_value) {
	        $sql .= " WHERE is_user_value = 0";
	        if (!empty($type)) {
	            if ($type === BP_Node::NODE_TYPE_DOWNLOAD
	                    || $type === BP_Node::NODE_TYPE_POST
	                    || $type === BP_Node::NODE_TYPE_RESOURCE)
	            {
	                $sql .= " AND node.node_type = '" . $type . "'";
	            }
	        }
	        $sql .= " GROUP BY cat.id";
	    }	    
	    //error_log($sql);
	    $results = $this->db->get_results($sql, ARRAY_A);
	    return $results;
	}
	
	/*public function find_nodes($node_type, array $where, $count = 0, $offset = 0)
	{
	    $sql = $this->create_sql_select_all(BP_Node::$table_name, $where, $count, $offset);
	    $results = $this->db->get_results($sql, ARRAY_A);
	}*/
	
	/**
	 * Find a single node by its ID
	 * 
	 * @param int $node_id
	 * @return bool|false
	 */
	public function find_node_by_id($node_id)
	{
	    $sql = "SELECT " . 
	    $this->get_prefixed_table_columns(BP_Node::$table_name, 'n') . "," .
	    $this->get_prefixed_table_columns(BP_File::$table_name, 'file', 'attachment_') . ",".
	    $this->get_prefixed_table_columns(BP_NodeCategory::$table_name, 'category', 'category_') . 
	    " FROM " . $this->get_table_name(BP_Node::$table_name) . " n" .
	    " LEFT JOIN " . $this->get_table_name('node_attachment') . " a ON a.node_id = n.id" .
	    " LEFT JOIN " . $this->get_table_name(BP_File::$table_name) . " file ON file.id = a.file_id" .
	    " LEFT JOIN " . $this->get_table_name('nodes_categories') . " nc ON nc.node_id = n.id" .
	    " LEFT JOIN " . $this->get_table_name(BP_NodeCategory::$table_name) . " category ON category.id = nc.category_id" .
	    " WHERE n.id = %d";
	    
	    $sql = sprintf($sql, $node_id);
	    
	    $result = $this->db->get_results($sql, ARRAY_A);	    
	    $return_result = $this->map_result_to_object_array($result);
	    if (count($return_result) > 0 && isset($return_result[$node_id])) {	        
	        return $return_result[$node_id];
	    }
	    return false;
	}
	
	/**
	 * Find the given number of nodes which includes specified ID in middle
	 * 
	 * @param string $node_type
	 * @param array $where
	 * @param int $option_id
	 * @param int $count
	 */
	public function find_nodes_included($node_type, array $where, $option_id = 0, $count = 0, $offset = 0)
	{
	    if ($option_id > 0) {
	        $sql = "SELECT created from ". $this->get_table_name(BP_Node::$table_name) . " WHERE id = " . $option_id;
	        $created = $this->db->get_var($sql);
	        if ($created) {

	            $w = " WHERE node_type='" . $node_type . "' && created >= '" . $created . "'";
	            if (isset($where['company_id'])) {
	                $w .= " AND company_id = " . $where['company_id'];
	            }
	            
	            $sql1 = "SELECT COUNT(id) FROM " . $this->get_table_name(BP_Node::$table_name) . $w;
	            $sql2 = "SELECT COUNT(id) FROM " . $this->get_table_name(BP_Node::$table_name) . $w;
	            $count_above = $this->db->get_var($sql1);
	            $count_below = $this->db->get_var($sql2);
	            $total = $count_above+$count_below;
	            
	            $offset = 0;
                $count = ($count == 0 ) ? 20 : $count;
                 
                if ($total < $count)
                    $offset = 0;
                else if ($count_below >= ($count/2) && $count_above >= ($count/2))
                    $offset = floor($count_below - ($count/2));
                else if ($count_above < (($count/2)) -1 )
                    $offset = (($total - $count_below) > 0) ? floor(($total - $count_below)) : 0;
                                
                return $this->find_nodes($node_type, $where, $count, $offset);
	                
	        }
	    }
	    else {
	        return $this->find_nodes($node_type, $where, $count, $offset);
	    }
	}

	/**
	 * Find the nodes
	 *
	 * @param int $offset
	 * @param int $count
	 * @return
	 */
	public function find_nodes($node_type, array $where, $count = 0, $offset = 0)
	{
		$sql = "
		SELECT " . $this->get_prefixed_table_columns(BP_Node::$table_name, 'n')  .
		", " . $this->get_prefixed_table_columns(BP_Company::$table_name, 'company', 'company_') .
		", " . $this->get_prefixed_table_columns(BP_File::$table_name, 'file', 'attachment_') . 
		", " . $this->get_prefixed_table_columns(BP_NodeCategory::$table_name, 'category', 'category_');
		
		$sql .= $this->build_sql_find_partial(false, $node_type, $where, $count, $offset);		
		
		//error_log($sql);
		//echo $sql;
		
		$result = $this->db->get_results($sql, ARRAY_A);

		$return_result = $this->map_result_to_object_array($result);
		
		return $return_result;
	}
	
	/**
	 * Get the total number of record for the given criteria
	 * 
	 * @param string $node_type
	 * @param array $where
	 * @return int
	 */
	public function count_nodes($node_type, array $where)
	{
	    $sql = "SELECT COUNT(DISTINCT n.id) ";
	    $sql .= $this->build_sql_find_partial(true, $node_type, $where);
	       	    
	    $res = $this->db->get_var($sql);
	    return $res;
	}
	
	/**
	 * Build partial SQL for the given criteria
	 * 
	 * @param string $node_type
	 * @param array $where
	 */
	private function build_sql_find_partial($count_query = false, $node_type, array $where, $count = 0, $offset = 0)
	{
	    $sql = " FROM " . $this->get_table_name(BP_Node::$table_name) . " n
	    INNER JOIN (SELECT DISTINCT n.* FROM " . $this->get_table_name(BP_Node::$table_name) . " n" .
	        " LEFT JOIN " . $this->get_table_name('nodes_categories') . " nc ON n.id = nc.node_id";

	    $values = array();
	    $sql .= " WHERE n.node_type = '%s' AND";
	    $values[] = $node_type;
	    
	    if (count($where) > 0)
	    {   	        
	        if (array_key_exists('title', $where) || array_key_exists('body', $where)) {
	            $sql .= ' (';
    	        if (array_key_exists('title', $where)) {	 
    	            if (!array_key_exists('body', $where)) {
    	                // Alphabet search
    	                $values[] = strtolower($where['title']) . '%';
    	            }
    	            else {
    	                // full search
    	                $values[] = '%' . strtolower($where['title']) . '%';
    	            }	            
    	            $sql .= " n.title LIKE LOWER('%s') OR";
    	        }
    	        if (array_key_exists('body', $where)) {
    	            $values[] = '%' . strtolower($where['body']) . '%';
    	            $sql .= " n.body LIKE LOWER('%s') OR";
    	        }
    	        $sql = substr($sql, 0, -2);
    	        $sql .= ' ) AND';
	        }
	        
	        if (array_key_exists('id', $where)) {
	            $values[] = $where['id'] . '%';
	            $sql .= " n.id = %d AND";
	        }
	        if (array_key_exists('company_id', $where)) {
	            $values[] = $where['company_id'] . '%';
	            $sql .= " n.company_id = %d AND";
	        }	 
	        if (array_key_exists('category_id', $where)) {
	            $values[] = $where['category_id'];
	            $sql .= " nc.category_id = %d AND";
	        } 
	        if (array_key_exists('active', $where)) {
	            $values[] = $where['active'];
	            $sql .= " n.active = %d AND";
	        }
	              
	    }
	    $sql = substr($sql, 0, -3);
	    $sql = vsprintf($sql, $values);
	    
	    $sql .= " ORDER BY created DESC";
	    
	    	    
	    if (!$count_query) {
    	    if ($offset > 0 && $count > 0)
    		{
    			$sql .= " LIMIT " . $offset . ", " . $count;
    		}
    		else if ($count > 0)
    		{
    			$sql .= " LIMIT " . $count;
    		}
	    }
	    
	    $sql .= " ) x ON x.id = n.id
	    LEFT JOIN " . $this->get_table_name('node_attachment') . " a ON n.id = a.node_id
	    LEFT JOIN " . $this->get_table_name(BP_File::$table_name) . " file ON file.id = a.file_id
	    LEFT JOIN " . $this->get_table_name('nodes_categories') . " nc ON n.id = nc.node_id
	    LEFT JOIN " . $this->get_table_name(BP_Company::$table_name) . " company on company.id = n.company_id
	    LEFT JOIN " . $this->get_table_name(BP_NodeCategory::$table_name) . " category ON category.id = nc.category_id";
	    
	    $where_added = false;
	    
	    if (count($where) > 0)
	    {
	        /*$sql .= " WHERE";
	        $where_added = true;
	        $values = array();*/
	        
	        /*$sql .= " n.node_type = '%s' AND";
	        $values[] = $node_type;*/
	    
	        /*if (array_key_exists('category_id', $where)) {
	            $values[] = $where['category_id'];
	            $sql .= " nc.category_id = %d AND";
	        }	*/        
	    
	        //$sql = substr($sql, 0, -3);
	        //$sql = vsprintf($sql, $values);
	    
	    }
	    return $sql;
	}

	/**
	 * Map the result array to object properties using the Hydrator class
	 *
	 * @param array $result
	 */
	public function map_result_to_object_array($result)	
	{
		$return_result = array();
		foreach ($result as $res)
		{
			if (array_key_exists($res['id'], $return_result))
				$node = $return_result[$res['id']];
			else {
				$node = new BP_Node();			
				BP_Hydrator::hydrate($node, $res);
			}

			$BP_File = new BP_File();
			BP_Hydrator::hydrate($BP_File, $res, 'attachment_');

			$node->attachments[$BP_File->id] = $BP_File;
			
			$BP_NodeCategory = new BP_NodeCategory();
			BP_Hydrator::hydrate($BP_NodeCategory, $res, 'category_');
			$node->categories[$BP_NodeCategory->id] = $BP_NodeCategory;
			
			$BP_Company = new BP_Company();
			BP_Hydrator::hydrate($BP_Company, $res, 'company_');
			$node->company = $BP_Company;
			
			$return_result[$res['id']] = $node;
		}

		return $return_result;
	}

}