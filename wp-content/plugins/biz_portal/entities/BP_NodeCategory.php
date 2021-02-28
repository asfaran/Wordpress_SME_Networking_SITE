<?php
/**
 * classs BP_Node
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_NodeCategory
{
    /**
     * 
     * @var int $id
     */
    public $id;
    
    /**
     * 
     * @var string $category_name
     */
    public $category_name;
    
    /**
     * 
     * @var int $is_user_value
     */
    public $is_user_value;
    
    /**
	 * @var string $table_name
	 */
	public static $table_name = 'node_category';
	
	
	/**
	 * Class construct
	 *
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
	    $this->id = $id;
	    $this->is_user_value = 0;
	}
	
	/**
	 * Return array of class
	 */
	public function to_array()
	{
	    return array(
	        'id' => $this->id,
	        'category_name' => $this->category_name,
	        'is_user_value' => $this->is_user_value,
	    );
	}
}