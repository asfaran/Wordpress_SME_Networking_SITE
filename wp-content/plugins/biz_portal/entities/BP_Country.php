<?php
/**
 * classs BP_Country
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Country
{
	public $id;
	public $country_code;
	public $country_name;    
    
    /**
     * @var string Table name
     */
    public static $table_name = 'countries';
    
    /**
     * Class constructor
     * 
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->id = $id;
    }
    
    /**
     * Convert to array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
            'id' => $this->id,
            'country_code' => $this->country_code,
            'country_name' => $this->country_name,
        );
    }
}
