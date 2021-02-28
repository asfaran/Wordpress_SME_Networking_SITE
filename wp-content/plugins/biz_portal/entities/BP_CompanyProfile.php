<?php
/**
 * classs BP_CompanyProfile
 *
 * @package entites
 * @author SWISS BUREAU
 */
 class BP_CompanyProfile
 {
 	/**
 	 * @var int $company_id
 	 */
 	public $company_id;

 	/**
 	 * @var int $logo_id
 	 */
 	public $logo_id;

 	/**
 	 * @var int $header_image_id
 	 */
 	public $header_image_id;

 	/**
 	 * @var int $squre_image_id
 	 */
 	public $squre_image_id;

 	/**
 	 * @var $lightbox_image_id
 	 */ 
 	public $lightbox_image_id;
 	
 	/**
 	 * @var string $body
 	 */
 	public $body;
 	
 	/**
 	 * @var string $body_looking_for
 	 */
 	public $body_looking_for;

 	/**
	 * @var string $table_name
	 */
	public static $table_name = 'company_profile';

	// ===================================

	/**
	 * @var BP_File $logo
	 */
	public $logo;

	/**
	 * @var BP_File $header_image
	 */
	public $header_image;

	/**
	 * @var BP_File $squre_image
	 */
	public $squre_image;

	/**
	 * @var BP_File $lightbox_image
	 */
	public $lightbox_image;


	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
		$this->company_id = $id;		
	}

	/**
	 * Return array
	 * @return array
	 */
	public function to_array()
	{
		return array(
			'company_id' => $this->company_id,
			'logo_id' => $this->logo_id,
			'header_image_id' => $this->header_image_id,
			'squre_image_id' => $this->squre_image_id,
			'lightbox_image_id' => $this->lightbox_image_id,			
			'body'	=> $this->body,
			'body_looking_for' => $this->body_looking_for,
		);
	}
 }