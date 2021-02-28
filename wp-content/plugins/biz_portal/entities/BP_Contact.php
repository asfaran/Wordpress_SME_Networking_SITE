<?php
/**
 * Class BP_Contact
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Contact
{
	/** @var int Identifier */
    public $id;
    /** @var string Contact person name */
    public $contact_person;
    /** @var string Position */
    public $position;
    /** @var string Telephone number */
    public $telephone;
    /** @var string Fax number */
    public $fax;
    /** @var string Website URL */
    public $web;
    /** @var string Mobile number */
    public $mobile;
    /** @var string Email address */
    public $email;
    /** @var int Company ID this belongs to */
    public $company_id;
    
    /**
     * @var BP_Company Company 
     */
    public $company;
    
    /** @var string Table name */
    public static $table_name = 'contacts';
    
    /**
     * Class contructgor
     * 
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->id = $id;
    }
    
    /**
     * Convert the class into array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
    		'id' => $this->id,
    		'contact_person' => $this->contact_person,
    		'position' => $this->position,
    		'telephone' => $this->telephone,
    		'fax' => $this->fax,
    		'web' => $this->web,
    		'mobile' => $this->mobile,
    		'email' => $this->email,
    		'company_id' => $this->company_id,
    	);
    }
}
