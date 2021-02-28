<?php
/**
 * Class BP_Industry
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Industry
{
	/** @var int Identifier */
    public $id;
    
    /** @var string Industry name */
    public $ind_name;
    
    /** @var int Is this user created insustry */
    public $is_user_value;
    
    /** @var string Table name */
    public static $table_name = 'industries';

    /**
     * Class construct
     * 
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->id = $id;
        $this->is_user_value = 0;
    }
    
    /**
     * Convert this into array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
    		'id' => $this->id,
    		'ind_name' => $this->ind_name,
    		'is_user_value' => $this->is_user_value,
    	);
    }
}
