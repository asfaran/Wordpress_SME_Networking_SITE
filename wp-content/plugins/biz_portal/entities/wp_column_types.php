<?php

/**
 * @package entites_column_types
 */

class BP_TableDefinitions
{
	/**
	 * @var array
	 */
	public $table_def_companies = array(
		'%d', //'id'-,
	    '%d', //'user_id-',
	    '%s', //'name-',
	    '%s', //'country_of_incorporate'-,
	    '%s', // registration number-
	    '%d', //'year_of_incorporate',-
	    '%s', //'location_head_office',-
	    '%s', //'ceo_md',-
	    '%s', //'ceo_md_designation',-
	    '%s', //'other_branch',-
	    '%d', //'turnover_min',-
	    '%d', //'turnover_max',-
	    '%d', //'num_employee_min',-
	    '%d', //'num_employee_max',-
	    '%s', //'member_type_id',
	    '%d', //'active',
	    '%s', //'created',
	    '%s', //'summary',
	    '%s', //terms_accepted
	    '%d', //bool_biz_need_partner_in'
	    '%d', //'bool_biz_need_service'
	    '%d', //'bool_biz_need_invest'
	    '%d', //'bool_biz_need_ngo_supp_serv'
        '%d', //bool_biz_give_service'
        '%d', //bool_biz_give_invest'
	);
	
	/**
	 * @var array
	 */
	public $table_def_biz_need_services = array(
		'%d', //company_id
		'%d', //service_id
	);

	/**
	 * @var array
	 */
	public $table_def_biz_give_services = array(
		'%d', //company_id
		'%d', //service_id
	);

	/**
	 * @var array
	 */
	public $table_def_biz_services = array(
		'%d', //$id;
		'%s', //$service_name;
		'%d', //$is_user_value;
	);

	/**
	 * @var array
	 */
	public $table_def_biz_type = array(
		'%d', //$id;
		'%s', //$type_text;
		'%d', //$is_user_value;
	);

	/**
	 * @var array
	 */
	public $table_def_biz_need_partner_biz_types = array(
		'%d', //company_id
		'%d', //biz_type_id
	);

	/**
	 * @var array
	 */
	public $table_def_industry = array(
		'%d', //id,
		'%s', //ind_name,
		'%d', //is_user_value,
	);

	/**
	 * @var array
	 */
	public $table_def_biz_need_partner_industries = array(
		'%d', //company_id,
		'%d', //industry_id
	);

	/**
	 * @var array
	 */
	public $table_def_biz_need_ngo_support = array(
		'%d', //id
		'%d', //org_type_development_agency
		'%d', //org_type_chamber_of_commerce
		'%d', //serv_pro_capacity_building
		'%d', //serv_pro_funding
		'%s', //serv_pro_other
		'%d', //fund_min
		'%d', //fund_max
		'%d', //company_id
	);

	/**
	 * @var array
	 */
	public $table_def_biz_need_investments = array(
		'%d', //id
		'%s', //invest_type
		'%d', //min
		'%d', //max
		'%d', //sme_employee_min
		'%d', //sme_employee_max
		'%d', //turnover_max
		'%d', //turnover_min
		'%d', //turnover_other
		'%d', //years_in_biz_min
		'%d', //years_in_biz_max
		'%d', //years_in_biz_other
		'%d', //company_id
	);

	/**
	 * @var array
	 */
	public $table_def_addresses = array(
		'%d', //$this->id,
	    '%s', //$this->number address line 1,
	    '%s', //$this->city,
	    '%s', //$this->region,
	    '%s', //$this->street,
	    '%s', //$this->postal_code,
	    '%d', //$this->country, 
	    '%d', //$this->company_id,
	);

	/**
	 * @var array
	 */
	public $table_def_contact = array(
		'%d', // id,
		'%s', // 'contact_person',
		'%s', // 'position',
		'%s', // 'telephone'
		'%s', // 'fax'
		'%s', // 'web'
		'%s', // 'mobile'
		'%s', // 'email'
		'%d', // 'company_id'
	);

	/**
	 * @var array
	 */
	public $table_def_company_biz_types = array(
		'%d', // company_id
		'%d', // biz_type_id
	);

	/**
	 * @var array
	 */
	public $table_def_company_industry = array(
		'%d', // company_id
		'%d', // industry_id
	);

	/**
	 * @var array
	 */
	public $table_def_biz_need_details = array(
		'%d', //id'
	    '%d', //'company_id'
	    '%s', //'biz_need_id'
	    '%s', //'detail'
	);

	/**
	 * @var array
	 */
	public $table_def_nodes = array(
		'%d', //id
		'%s', //title
		'%d', //company_id
		'%s', //created
		'%d', //active
		'%s', //body
		'%s', //node_type
	);

	/**
	 * @var array
	 */
	public $table_def_files_t = array(
		'%d', //id
		'%s', //path
		'%s', //mime_type
		'%d', //size_bytes
		'%s', //extension
		'%d', //is_image
		'%d', //uid
	);

	/**
	 * @var array
	 */
	public $table_def_node_attachment = array(
		'%d', //node_id
		'%d', //file_id
	);

	/**
	 * @var array
	 */
	public $table_def_scores = array(
		'%d', //company_id
		'%d', //scores
	);

	public $table_def_investments_industries = array(
		'%d', // investment_id
		'%d', // industry_id
	);
	
	public $table_def_private_message = array(
	    '%d', //    'id' => $this->id,
	    '%d', //    owner_id
	    '%d', //    'from_company_id' => $this->from_company_id,
	    '%d', //    'to_company_id' => $this->to_company_id,
	    '%s', //    'message' => $this->message,
	    '%s', //    'created' => $this->created,
	    '%d', //    'is_read' => $this->is_read,
	    '%d', //    'reply_to_message' => $this->reply_to_message,
	);
	
	public $table_def_company_profile = array(
		'%d', // 'company_id' => $this->company_id,
		'%d', // 'logo_id' => $this->logo_id,
		'%d', // 'header_image_id' => $this->header_image_id,
		'%d', // 'squre_image_id' => $this->squre_image_id,
		'%d', // 'lightbox_image_id' => $this->lightbox_image_id,
		'%s', // 'body'	=> $this->body,
		'%s', // 'body_looking_for' => $this->body_looking_for,
	);
}