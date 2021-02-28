<?php
/**
 * classs BP_Address
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Address
{
	/**
	 * @var int $id
	 */
    public $id;
    
    /**
     * building or place's number (address 1)
     *  
     * @var string $number (This property was changed to address 1 later depending on form rquirement)
     */
    public $company_number;
    
    /**
     * @var string $city
     */
    public $city;
    
    /**
     * @var string $region 
     */
    public $region;
    
    /**
     * @var string $street 
     */
    public $street;
    
    /**
     * @var int $postal_code 
     */
    public $postal_code;
    
    /**
     * @var string $country_id 
     */
    public $country_id;   
    
    /**
     * @var int $company_id 
     */
    public $company_id;
    
    
    //=================
    //=================
    
    /**
     * @var BP_Country $country
     */
    public $country;
    
    /**
     *
     * @var BP_Company company 
     */
    public $company;
       
    
    
    /**
     * @var string Table name
     */
    public static $table_name = 'addresses';
    
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
    		'company_number' => $this->company_number,
    		'city' => $this->city,
    		'region' => $this->region,
    		'street' => $this->street,
    		'postal_code' => $this->postal_code,
    		'country_id' => $this->country_id, 
    		'company_id' => $this->company_id,
    	);
    }
}
