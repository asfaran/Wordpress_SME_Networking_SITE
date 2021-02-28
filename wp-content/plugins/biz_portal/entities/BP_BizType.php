<?php
/**
 * Class BP_BizType
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_BizType
{
	/**
	 * @var int Identifier
	 */
    public $id;
    
    /**
     * @var string Type name
     */
    public $type_text;
    
    /**
     * @var int Is this user created type
     */
    public $is_user_value;
        
    /**
     * @var string Table name
     */
    public static $table_name = 'biz_types';

    /**
     * Class constructor
     * 
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->id = $id;
        $this->is_user_value = 0;
    }
    
    /**
     * convert property into array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
    		'id' => $this->id,
    		'type_text' => $this->type_text,
    		'is_user_value' => $this->is_user_value,
    	);
    }
}
