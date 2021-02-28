<?php

/**
 * Class BizPortalRepo
 * 
 * @package BizPortal_WP_Module
 * @subpackage Repository_Company
 * @author SWISS BUREAU
 */
class BP_Repo_Companies extends BP_BaseRepository
{
	const COMPANY_LOAD_SIMPLE = 1;
	const COMPANY_LOAD_RELATION_SIMPLE = 2;	
	const COMPANY_LOAD_RELATION_FULL = 5;

    protected $save_new_industry;
    
    /**
     * Class constructor
     * 
     * @param wpdb $dbObject
     * @param string $table_prefix
     * @param bool $save_new_industry
     */
    public function __construct(wpdb $dbObject, $table_prefix, $save_new_industry = 0)
    {
        parent::__construct($dbObject, $table_prefix);       

        $this->save_new_industry = $save_new_industry;
    }
    
    /**
     * Get company profile object
     * 
     * @param int $company_id
     * @return BP_CompanyProfile|null
     */
    public function get_company_profile($company_id)
    {
    	$sql = "SELECT * FROM " . $this->get_table_name(BP_CompanyProfile::$table_name) . " WHERE company_id = %d";
    	$sql = sprintf($sql, $company_id);
    	
    	$result = $this->db->get_row($sql, ARRAY_A);
    	
    	if ($result)
    	{
	    	$BP_CompanyProfile = new BP_CompanyProfile();
	    	$BP_Hydrator = new BP_Hydrator();
	    	
	    	$BP_CompanyProfile = $BP_Hydrator->hydrate($BP_CompanyProfile, $result);
	    	
	    	return $BP_CompanyProfile;
    	}
    	else {
    		return false;
    	}
    }
    
    
    public function save_company_profile(BP_CompanyProfile $BP_CompanyProfile)
    {
    	$old_profile = $this->get_company_profile($BP_CompanyProfile->company_id);
    	
    	$saved = false;
    	$res = false;
    	$BP_CompanyProfile_array = $BP_CompanyProfile->to_array();
    	
    	if (!$old_profile) {	    	
	    	$res = $this->db->insert($this->get_table_name(BP_CompanyProfile::$table_name), 
	    			$BP_CompanyProfile_array, $this->table_def->table_def_company_profile);
    	}
    	else {
    		$res = $this->db->update($this->get_table_name(BP_CompanyProfile::$table_name), 
    				$BP_CompanyProfile_array, array('company_id' => $BP_CompanyProfile->company_id),
    				$this->table_def->table_def_company_profile, array('%d'));
    	}
    	
    	if ($res && $old_profile)
    	{
	    	$BP_Repo_Files = new BP_Repo_Files($this->db, $this->table_prefix);
	    	if ($old_profile->logo_id > 0)
	    		$BP_Repo_Files->remove_file_usage($old_profile->logo_id);
	    	
	    	if ($old_profile->header_image_id > 0)
	    		$BP_Repo_Files->remove_file_usage($old_profile->header_image_id);
	    	
	    	if ($old_profile->lightbox_image_id > 0)
	    		$BP_Repo_Files->remove_file_usage($old_profile->lightbox_image_id);
	    	
	    	if ($old_profile->squre_image_id > 0)
	    		$BP_Repo_Files->remove_file_usage($old_profile->squre_image_id);
	    	
    	}
    	
    	return $res;
    }
    
    /**
     * Find one contact for the company
     * 
     * @param int $company_id
     * @return BP_Contact|null
     */
    public function find_first_contact($company_id)
    {
        $sql = "SELECT * FROM " . $this->get_table_name(BP_Contact::$table_name) .
        " WHERE company_id = %d LIMIT 1";
        $sql = sprintf($sql, $company_id);
                
        $results = $this->db->get_results($sql, ARRAY_A);
        
        //$BP_Contact = new BP_Contact();
        $BP_Contact_array = $this->map_result('BP_Contact', $results);
        
        if (isset($BP_Contact_array[$results[0]['id']]))
            return $BP_Contact_array[$results[0]['id']];
        else 
            return false;
        
    }


    /**
     * Count Companies based on filter
     *
     * @param array $where
     * @param array $format
     * @return null|int
     */
    public function count_companies(array $where = array(), array $format = array())
    {
        $sql = $this->create_sql_select_count(BP_Company::$table_name, $where, $format);

        $count = $this->db->get_var($sql);
        return $count;
    }

    /**
     * Find a company by contact email address
     *
     * @param string $email
     * @return BP_Company|null
     */
    public function find_company_by_user_email($email)
    {
        $sql = "SELECT c.* FROM " . $this->get_table_name(BP_Company::$table_name) . " c 
            LEFT JOIN " . $this->get_table_name(BP_Contact::$table_name) . " ct ON ct.company_id = c.id 
            WHERE ct.email = '%s'";

        $sql = sprintf($sql, $email);

        $result = $this->db->get_row($sql, ARRAY_A);

        if ($result && is_array($result)) {
            $BP_Hydrator = new BP_Hydrator();
            $BP_Company = new BP_Company();
            $BP_Hydrator->hydrate($BP_Company, $result);
            return $BP_Company;
        }

        return null;
    }

    /**
     * Delete a company by company id
     *
     * @param int $company_id
     * @return bool|int
     */
    public function delete($company_id)
    {
        $errors = 0;
        $this->db->query('START TRANSACTION');
        $res = $this->db->delete($this->get_table_name(BP_Score::$table_name),
                array('company_id' => $company_id), array('%d'));
    
        $res = $this->db->delete($this->get_table_name(BP_CompanyProfile::$table_name),
                array('company_id' => $company_id), array('%d'));
    
    	$res = $this->db->delete($this->get_table_name(BP_PrivateMessage::$table_name),
    			array('from_company_id' => $company_id), array('%d'));
    
    	$res = $this->db->delete($this->get_table_name(BP_PrivateMessage::$table_name),
    			array('to_company_id' => $company_id), array('%d'));
    
    	$res = $this->db->delete($this->get_table_name(BP_Company::$table_name),
    			array('id' => $company_id), array('%d'));
    	
    	if ($errors == 0) {
    	    $this->db->query('COMMIT');
    	    return $res;
    	}
    	else {
    	    $this->db->query('ROLLBACK');
    	    return false;
    	}
    }

    /**
     * Change the state of a company
     * 
     * @param int $company_id
     * @param int $active
     */
    public function change_state($company_id, $active)
    {
        $data = array('active' => $active);
        $res = $this->db->update($this->get_table_name(BP_Company::$table_name), $data, 
            array('id' => $company_id), array('%d'), array('%d'));

        return $res;
    }


   /**
    * Save or update the given company
    * 
    * The given company and all data associated with will be saved. 
    * 
    * @param BP_Company $company
    * @throws Exception
    * @return bool
    */
    public function company_update(BP_Company $company)
    {	
    	$errors = 0;
    	$this->db->query('START TRANSACTION');    
    	
    	// Insert or update company
    	$company_array = $company->to_array();   
    	if ($company->id > 0) {
    		$update = $this->db->update($this->get_table_name(BP_Company::$table_name), 
    				$company_array, array('id' => $company->id), $this->table_def->table_def_companies, array('%d'));
    		if ($update === false)
    			$errors++;
    	}
    	else {
            unset($company_array['id']);
            $table_def_companies = $this->table_def->table_def_companies;
            unset($table_def_companies[0]);
            
    		$insert = $this->db->insert($this->get_table_name(BP_Company::$table_name),    				 
    				$company_array, $table_def_companies);
    		
    		//print_r($company_array);
            
    		if ($insert)
    		    $company->id = $this->db->insert_id;
    		else
    			$errors++;
    	}
    	
    	// If no prev errors and company was inserted/updated.. 
    	if ($company->id > 0 && $errors == 0) {
    		//
    		// Update $company->biz_need_services
    		//
    		$this->db->delete($this->get_table_name('biz_need_services'), 
    				array('company_id' => $company->id), array('%d'));
    		if (is_array($company->biz_need_services)) {
        		foreach ($company->biz_need_services as $BP_BizService) 
        		{
        			$biz_service_array = $BP_BizService->to_array();
        			$biz_need_services_array = array(
        				'company_id' => $company->id,
        				'service_id' => $BP_BizService->id,
        			);
        			
        			// check if the service created by applicant
        			if ($BP_BizService->is_user_value == 1 && $BP_BizService->id == 0) 
        			{
        			    $sql = "SELECT id FROM " . $this->get_table_name(BP_BizService::$table_name) . " WHERE LOWER(service_name) = '%s'";
        			    $sql = sprintf($sql, strtolower($BP_BizService->service_name));
        			    $found_id = $this->db->get_var($sql);
        			    
        			    if ($found_id > 0)
        			        $biz_need_services_array['service_id'] = $found_id;
        			    else {
            				$insert = $this->db->insert($this->get_table_name(BP_BizService::$table_name), 
            						$biz_service_array, $this->table_def->table_def_biz_services);
            				if ($insert) 
            					$biz_need_services_array['service_id'] = $this->db->insert_id;
            				else {
            					$errors++;
            					continue;
            				}
        				}
        			}
        			$insert = $this->db->insert($this->get_table_name('biz_need_services'),
        					$biz_need_services_array, $this->table_def->table_def_biz_need_services);
        			if (!$insert)
        				$errors++;
        		}
    		}

            //
            // Update $company->biz_give_services
            //
            $this->db->delete($this->get_table_name('biz_give_services'), 
                    array('company_id' => $company->id), array('%d'));
            if (is_array($company->biz_give_services)) {
                foreach ($company->biz_give_services as $BP_BizService) 
                {
                    $biz_service_array = $BP_BizService->to_array();
                    $biz_give_services_array = array(
                        'company_id' => $company->id,
                        'service_id' => $BP_BizService->id,
                    );
                    
                    // check if the service created by applicant
                    if ($BP_BizService->is_user_value == 1 && $BP_BizService->id == 0) 
                    {
                        $sql = "SELECT id FROM " . $this->get_table_name(BP_BizService::$table_name) . " WHERE LOWER(service_name) = '%s'";
                        $sql = sprintf($sql, strtolower($BP_BizService->service_name));
                        $found_id = $this->db->get_var($sql);
                        
                        if ($found_id > 0)
                            $biz_give_services_array['service_id'] = $found_id;
                        else {
                            $insert = $this->db->insert($this->get_table_name(BP_BizService::$table_name), 
                                    $biz_service_array, $this->table_def->table_def_biz_services);
                            if ($insert) 
                                $biz_give_services_array['service_id'] = $this->db->insert_id;
                            else {
                                $errors++;
                                continue;
                            }
                        }
                    }
                    $insert = $this->db->insert($this->get_table_name('biz_give_services'),
                            $biz_give_services_array, $this->table_def->table_def_biz_give_services);
                    if (!$insert)
                        $errors++;
                }
            }
    		
    		//
    		// Update $company->biz_need_partner_biz_types
    		//
    		$this->db->delete($this->get_table_name('biz_need_partner_biz_types'),
    				array($company->id), array('%d'));
    		if (is_array($company->biz_need_partner_biz_types)) {
        		foreach ($company->biz_need_partner_biz_types as $BP_BizType)
        		{
        			$BP_BizType_array = $BP_BizType->to_array();
        			$biz_need_partner_biz_types = array(
        				'company_id' => $company->id,
        				'biz_type_id' => $BP_BizType->id,
        			);
        			// check if the biztype was created by applicant
        			if ($BP_BizType->id == 0 && $BP_BizType->is_user_value == 1)
        			{
        			    $sql = "SELECT id FROM " . $this->get_table_name(BP_BizType::$table_name) . " WHERE LOWER(type_text) = '%s'";
        			    $sql = sprintf($sql, strtolower($BP_BizType->type_text));
        			    $found_id = $this->db->get_var($sql);
        			    
        			    if ($found_id > 0)
        			        $biz_need_partner_biz_types['biz_type_id'] = $found_id;
        			    else {
            				$insert = $this->db->insert($this->get_table_name(BP_BizType::$table_name),
            						$BP_BizType_array, $this->table_def->table_def_biz_type);
            				if ($insert)
            					$biz_need_partner_biz_types['biz_type_id'] = $this->db->insert_id;
            				else {
            					$errors++;
            					continue;
            				}
        			    } 				
        			}
        			$insert = $this->db->insert($this->get_table_name('biz_need_partner_biz_types'), 
        					$biz_need_partner_biz_types, $this->table_def->table_def_biz_need_partner_biz_types);
        			if (!$insert)
        				$errors++;
        		}
    		}

    		
    		//
    		// Update $company->biz_need_partner_industries
    		//
    		$this->db->delete($this->get_table_name('biz_need_partner_industries'),
    				array('company_id' => $company->id), array('%d'));
    		if (is_array($company->biz_need_partner_industries)) {
        		foreach ($company->biz_need_partner_industries as $BP_Industry)
        		{
        			$BP_Industry_array = $BP_Industry->to_array();
        			$biz_need_partner_industries = array(
        				'company_id' => $company->id,
        				'industry_id' => $BP_Industry->id,
        			);
        			
        			// check if the industry was created by applicant
        			if ($BP_Industry->id == 0 && $BP_Industry->is_user_value == 1) 
        			{
        			    $sql = "SELECT id FROM " . $this->get_table_name(BP_Industry::$table_name) . " WHERE LOWER(ind_name) = '%s'";
        			    $sql = sprintf($sql, strtolower($BP_Industry->ind_name));
        			    $found_id = $this->db->get_var($sql);
        			    	
        			    if ($found_id > 0)
        			        $biz_need_partner_industries['industry_id'] = $found_id;
        			    else {
            				$insert = $this->db->insert($this->get_table_name(BP_Industry::$table_name),
            						$BP_Industry_array, $this->table_def->table_def_industry);
            				if ($insert)
            					$biz_need_partner_industries['industry_id'] = $this->db->insert_id;
            				else {
            					$errors++;
            					continue;
            				}
        			    }
        			}
        			$insert = $this->db->insert($this->get_table_name('biz_need_partner_industries'),
        					$biz_need_partner_industries, $this->table_def->table_def_biz_need_partner_industries);
        			if (!$insert)
        				$errors++;
        		}
    		}

    		//
    		// $company->biz_need_ngo_supp_serv
    		//
    		
    		// Delete current entry
    		$this->db->delete($this->get_table_name(BP_BizNeedNGOSuppServ::$table_name),
    				array('company_id' => $company->id), array('%d'));            
    		// Make to new entry if available
    		if ($company->biz_need_ngo_supp_serv instanceof BP_BizNeedNGOSuppServ 
    				&& $company->bool_biz_need_ngo_supp_serv) 
    		{   
	    		$biz_need_ngo_supp_serv = $company->biz_need_ngo_supp_serv->to_array();
	    		$biz_need_ngo_supp_serv['company_id'] = $company->id;
	    		$insert = $this->db->insert($this->get_table_name(BP_BizNeedNGOSuppServ::$table_name), 
	    				$biz_need_ngo_supp_serv, $this->table_def->table_def_biz_need_ngo_support);
	    		
	    		if (!$insert)
	    			$errors++;

                $parent_id = $this->db->insert_id;

                foreach ($company->biz_need_ngo_supp_serv->services_provided as $BP_Service) 
                {
                    $BP_Service_array = $BP_Service->to_array();
                    $services_provided = array(
                        'biz_need_ngo_id' => $parent_id,
                        'service_id' => $BP_Service->id,
                    );

                    if ($BP_Service->id == 0 && $BP_Service->is_user_value == 1) 
                    {
                        $sql = "SELECT id FROM " . $this->get_table_name(BP_BizService::$table_name) . " WHERE LOWER(service_name) = '%s'";
                        $sql = sprintf($sql, strtolower($BP_Service->service_name));
                        $found_id = $this->db->get_var($sql);
                        
                        if ($found_id > 0)
                            $services_provided['service_id'] = $found_id;
                        else {
                            $insert = $this->db->insert($this->get_table_name(BP_BizService::$table_name),
                                    $BP_Service_array, $this->table_def->table_def_biz_services);
                            if ($insert)
                                $services_provided['service_id'] = $this->db->insert_id;
                            else {
                                $errors++;
                                continue;
                            }
                        }
                    }

                    $insert = $this->db->insert($this->get_table_name('biz_need_ngo_services'),
                            $services_provided, $this->table_def->table_def_biz_need_ngo_services);
                    if (!$insert)
                        $errors++;
                }
    		}

    		//
    		// $company->biz_need_investment
    		//
                		
    		// Delete current entry
    		$this->db->delete($this->get_table_name(BP_BizNeedInvestment::$table_name),
    				array('company_id' => $company->id, 'invest_type' => BP_BizNeedInvestment::TYPE_NEED), array('%d', '%s'));
    		// Make new entry if available
    		if ($company->bool_biz_need_invest 
    				&& $company->biz_need_investment instanceof BP_BizNeedInvestment)
    		{	
    			$biz_need_investment = $company->biz_need_investment->to_array();
    			$biz_need_investment['company_id'] = $company->id;
    			$insert = $this->db->insert($this->get_table_name(BP_BizNeedInvestment::$table_name),
    					$biz_need_investment, $this->table_def->table_def_biz_need_investments);
    			if (!$insert) {
    				$errors++;                    
                }
                else
                {
                    $insert_id = $this->db->insert_id;
                    foreach ($company->biz_need_investment->industries as $BP_Industry)
                    {
                        $BP_Industry_array = $BP_Industry->to_array();
                        $investments_industries = array(
                            'investment_id' => $insert_id,
                            'industry_id' => $BP_Industry->id,
                        );
                        // check if the industry was created by applicant
                        if ($BP_Industry->id == 0 && $BP_Industry->is_user_value == 1) 
                        {
                            $sql = "SELECT id FROM " . $this->get_table_name(BP_Industry::$table_name) . " WHERE LOWER(ind_name) = '%s'";
                            $sql = sprintf($sql, strtolower($BP_Industry->ind_name));
                            $found_id = $this->db->get_var($sql);
                            
                            if ($found_id > 0)
                                $investments_industries['industry_id'] = $found_id;
                            else {
                                $insert = $this->db->insert($this->get_table_name(BP_Industry::$table_name),
                                        $BP_Industry_array, $this->table_def->table_def_industry);
                                if ($insert)
                                    $investments_industries['industry_id'] = $this->db->insert_id;
                                else {
                                    $errors++;
                                    continue;
                                }
                            }
                        }
                        $insert = $this->db->insert($this->get_table_name('investments_industries'),
                                $investments_industries, $this->table_def->table_def_investments_industries);
                        if (!$insert)
                            $errors++;
                    }
                }
    		}

            //
            // $company->biz_give_investment
            //
            
            // Delete current entry
            $this->db->delete($this->get_table_name(BP_BizNeedInvestment::$table_name),
                    array('company_id' => $company->id, 'invest_type' => BP_BizNeedInvestment::TYPE_PROVIDE), array('%d', '%s'));
            // Make new entry if available
            if ($company->bool_biz_give_invest 
                    && $company->biz_give_investment instanceof BP_BizNeedInvestment)
            {   
                $biz_give_investment = $company->biz_give_investment->to_array();
                $biz_give_investment['company_id'] = $company->id;
                $insert = $this->db->insert($this->get_table_name(BP_BizNeedInvestment::$table_name),
                        $biz_give_investment, $this->table_def->table_def_biz_need_investments);
                if (!$insert) {
                    $errors++;                    
                }
                else {
                    $insert_id = $this->db->insert_id;
                    foreach ($company->biz_give_investment->industries as $BP_Industry)
                    {
                        $BP_Industry_array = $BP_Industry->to_array();
                        $investments_industries = array(
                            'investment_id' => $insert_id,
                            'industry_id' => $BP_Industry->id,
                        );                        
                        // check if the industry was created by applicant
                        if ($BP_Industry->id == 0 && $BP_Industry->is_user_value == 1) 
                        {
                            $sql = "SELECT id FROM " . $this->get_table_name(BP_Industry::$table_name) . " WHERE LOWER(ind_name) = '%s'";
                            $sql = sprintf($sql, strtolower($BP_Industry->ind_name));
                            $found_id = $this->db->get_var($sql);
                            
                            if ($found_id > 0)
                                $investments_industries['industry_id'] = $found_id;
                            else {
                                $insert = $this->db->insert($this->get_table_name(BP_Industry::$table_name),
                                        $BP_Industry_array, $this->table_def->table_def_industry);
                                if ($insert)
                                    $investments_industries['industry_id'] = $this->db->insert_id;
                                else {
                                    $errors++;
                                    continue;
                                }
                            }
                        }
                        $insert = $this->db->insert($this->get_table_name('investments_industries'),
                                $investments_industries, $this->table_def->table_def_investments_industries);
                        if (!$insert)
                            $errors++;
                    }
                }
            }
    		
    		//
    		// Array BP_Contact
    		// $company->contacts
    		//

    		
    		// Delete current entries
    		$this->db->delete($this->get_table_name(BP_Contact::$table_name),
    				array('company_id' => $company->id), array('%d'));
    		// Make new entires if available
    		if (is_array($company->contacts)) {
        		foreach ($company->contacts as $BP_Contact)
        		{
        			$BP_Contact_array = $BP_Contact->to_array();
        			$BP_Contact_array['company_id'] = $company->id;
        			$insert = $this->db->insert($this->get_table_name(BP_Contact::$table_name), 
        					$BP_Contact_array, $this->table_def->table_def_contact);
        			
        			if (!$insert)
        				$errors++;
        		}
    		}
    		
    		//
    		// Array BP_Address
    		// $company->addresses
    		//
    		
    		// Delete current entries
    		$this->db->delete($this->get_table_name(BP_Address::$table_name), 
    				array('company_id' => $company->id), array('%d'));
    		// Make new entires if available
    		if (is_array($company->addresses)) {
        		foreach ($company->addresses as $BP_Address)
        		{
        			$address_array = $BP_Address->to_array();
        			$address_array['company_id'] = $company->id;
        			$insert = $this->db->insert($this->get_table_name(BP_Address::$table_name), 
        					$address_array, $this->table_def->table_def_addresses);
        			
        			if (!$insert)
        				$errors++;
        		}
    		}

    		
    		//
    		// Array BP_BizType
    		// $company->biz_types
    		//
    		
    		// Delete current entires
    		$this->db->delete($this->get_table_name('company_biz_types'), 
    				array('company_id' => $company->id), array('%d'));
    		// Make new entries if available
    		if (is_array($company->biz_types)) {
        		foreach ($company->biz_types as $BP_BizType)
        		{
        			$BP_BizType_array = $BP_BizType->to_array();
        			$biz_types = array(
        				'company_id' => $company->id,
        				'biz_type_id' => $BP_BizType->id,
        			);
        			if ($BP_BizType->id == 0 && $BP_BizType->is_user_value == 1)
        			{
        			    $sql = "SELECT id FROM " . $this->get_table_name(BP_BizType::$table_name) . " WHERE LOWER(type_text) = '%s'";
        			    $sql = sprintf($sql, strtolower($BP_BizType->type_text));
        			    $found_id = $this->db->get_var($sql);
        			    	
        			    if ($found_id > 0)
        			        $biz_types['biz_type_id'] = $found_id;
        			    else {
            				$insert = $this->db->insert($this->get_table_name(BP_BizType::$table_name), 
            						$BP_BizType_array, $this->table_def->table_def_biz_type);
            				if ($insert) {                        
            					$biz_types['biz_type_id'] = $this->db->insert_id;
                            }
            				else {
            					$errors++;
            					continue;
            				}
        			    }
        			}
    
                    //echo $biz_types['biz_type_id'] . "\n";
        			
        			$insert = $this->db->insert($this->get_table_name('company_biz_types'), 
        					$biz_types, $this->table_def->table_def_company_biz_types);
        			if (!$insert) {
        				$errors++;
        			}
        		}    
    		}        
    		
    		// 
    		// Array BP_Industry
    		// $company->industries
    		//
    		
    		// Delete current entries
    		$this->db->delete($this->get_table_name('company_industry'), 
    				array('company_id' => $company->id), array('%d'));
    		// Make new entries if available
    		if (is_array($company->industries)) {
        		foreach ($company->industries as $BP_Industry)
        		{
        			$BP_Industry_array = $BP_Industry->to_array();
        			$industries_array = array(
        				'company_id' => $company->id,
        				'industry_id' => $BP_Industry->id,
        			);
        			if ($BP_Industry->id == 0 && $BP_Industry->is_user_value > 0)
        			{
        			    $sql = "SELECT id FROM " . $this->get_table_name(BP_Industry::$table_name) . " WHERE is_user_value = %d AND LOWER(ind_name) = '%s'";
        			    $sql = sprintf($sql, $BP_Industry->is_user_value, strtolower($BP_Industry->ind_name));
        			    $found_id = $this->db->get_var($sql);
        			    
        			    if ($found_id > 0)
        			        $industries_array['industry_id'] = $found_id;
        			    else {
            				$insert = $this->db->insert($this->get_table_name(BP_Industry::$table_name),
            						$BP_Industry_array, $this->table_def->table_def_industry);
            				if ($insert)
            					$industries_array['industry_id'] = $this->db->insert_id;
            				else {
            					$errors++;
            					continue;
            				}
        			    }
        			}
        			$insert = $this->db->insert($this->get_table_name('company_industry'), 
        					$industries_array, $this->table_def->table_def_company_industry);
        			if (!$insert)
        				$errors++;    			
        		}
    		}
    		
    		//
    		// Array BP_BizNeedDetail
    		// $company->biz_need_details
    		//
    		
    		// Delete current entries
    		$this->db->delete($this->get_table_name(BP_BizNeedDetail::$table_name), 
    				array('company_id' => $company->id), array('%d'));
    		// Insert new entries
    		if (is_array($company->biz_need_details)) {
        		foreach ($company->biz_need_details as $BP_BizNeedDetail)
        		{
        			$BP_BizNeedDetail_array = $BP_BizNeedDetail->to_array();
        			$BP_BizNeedDetail_array['company_id'] = $company->id;
        			$insert = $this->db->insert($this->get_table_name(BP_BizNeedDetail::$table_name), 
        					$BP_BizNeedDetail_array, $this->table_def->table_def_biz_need_details);
        			
        			if (!$insert)
        				$errors++;
        		}
    		}
    		
    	}   

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
     * Search and returns companies as company object, the linked objects
     * will not be populated and those have to be fetched seperatedly one by one.
     * and the search is made only at main table level.
     *
     * @param array $where
     * @param array $format
     * @param int $count
     * @param int $offset
     * @return ViewModel_Companies 
     */
    public function search_companies(array $where = array(), array $format = array(), $count = 0, $offset = 0)
    {
        $ViewModel_Companies = new ViewModel_Companies();
        $ViewModel_Companies->count = $count;
        $ViewModel_Companies->offset = $offset;

        $sql_count = parent::create_sql_select_count(BP_Company::$table_name, $where, $format);
        $ViewModel_Companies->total = $this->db->get_var($sql_count);

        $sql = $this->create_sql_select_all_companies(BP_Company::$table_name, $where, $format, $count, $offset);
        $result = $this->db->get_results($sql, ARRAY_A);
        $companies = array();

        if ($result && is_array($result)) {
            $companies = $this->map_result('BP_Company', $result);
        }
        $ViewModel_Companies->companies = $companies;

        return $ViewModel_Companies;
    }  
    
    /**
     * Count companies by filter parameter
     * @param BP_Company_Filter $filter
     * @return int
     */
    public function filter_companies_count(BP_Company_Filter $filter)
    {
        $sql_count = $this->create_sql_for_filter_count($filter);
        //error_log($sql_count);
        $total = $this->db->get_var($sql_count);
        return $total;
    }

    /**
     * Filter company by filter parameters
     *
     * @var BP_Company_Filter $filter
     * @var int $count
     * @var int $offset
     * @return ViewModel_Companies
     */
    public function filter_companies(BP_Company_Filter $filter, $count = 10, $offset = 0)
    {   
        $ViewModel_Companies = new ViewModel_Companies();

        $sql_count = $this->create_sql_for_filter_count($filter);
        $ViewModel_Companies->total = $this->db->get_var($sql_count);

        $sql = $this->create_sql_for_filter($filter, $count, $offset);

        $companies_array = $this->db->get_results($sql, ARRAY_A);
        $companies_obj_array = array();
        $ViewModel_Companies->companies = parent::map_result('\BP_Company', $companies_array);
        $ViewModel_Companies->count = $count;
        $ViewModel_Companies->offset = $offset;
        
        foreach ($companies_array as $res)
        {
        	if ($res['profile_company_id'] && !isset($ViewModel_Companies->companies[$res['id']]->profile)) 
            {
            	$BP_CompanyProfile = new BP_CompanyProfile();
                BP_Hydrator::hydrate($BP_CompanyProfile, $res, 'profile_');
                $ViewModel_Companies->companies[$res['id']]->profile = $BP_CompanyProfile;
            }
        }
        
        /*foreach ($ViewModel_Companies->companies as $key => $company)
        {
        	$this->get_company_profile($company_id)
        }*/
        
        //error_log($sql);
        
        return $ViewModel_Companies;
    }

    /**
     * Create sql based on the filter parameters for count records
     *
     * @var BP_Company_Filter $filter
     * @return string
     */
    public function create_sql_for_filter_count(BP_Company_Filter $filter, $count = 0, $offset = 0)
    {
        $sql = "SELECT COUNT(DISTINCT c.id) FROM " . $this->get_table_name(BP_Company::$table_name) . " c";
        
        $sql .= $this->create_sql_for_filter_partial($filter, true, $count, $offset);
        //error_log($sql);
        return $sql;
    }

    /**
     * Create sql based on the filter parameters
     *
     * @var BP_Company_Filter $filter
     * @var int $count
     * @var int $offset
     * @return string
     */
    public function create_sql_for_filter(BP_Company_Filter $filter, $count = 0, $offset = 0)
    {
        $sql = "SELECT distinct " . $this->get_prefixed_table_columns(BP_Company::$table_name, "c") . "," .
        		$this->get_prefixed_table_columns(BP_CompanyProfile::$table_name, "profile", 'profile_') . "," .
        		"score.scores AS scores"
        		. " FROM " . $this->get_table_name(BP_Company::$table_name) . " c";

        $sql .= $this->create_sql_for_filter_partial($filter, false, $count, $offset);
        //$sql .= " ORDER BY scores DESC ";

        /*
        if ($count > 0 && $offset > 0)
            $sql .= " LIMIT " . $offset . ", " . $count;
        else
            $sql .= " LIMIT " . $count;*/
        //echo $sql, 0;
        return $sql;
    }

    /**
     * Load the company object with its relational objects
     *
     * @param BP_Company $company
     * @return BP_Company
     * @todo NOT Complete
     */
    public function load_company_relations(BP_Company $company)
    {
        $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Company::$table_name, 'c') . ", " .
        $this->get_prefixed_table_columns(BP_Country::$table_name, 'country', 'country_') . ", " .
        $this->get_prefixed_table_columns(BP_BizType::$table_name, 'biz_type1', 'biz_type1_') . ", " .    
        $this->get_prefixed_table_columns(BP_BizNeedNGOSuppServ::$table_name, 'ngo_ss', 'ngo_ss_') . ", " .
        $this->get_prefixed_table_columns(BP_BizNeedInvestment::$table_name, 'need_inv', 'need_inv_') . ", " .
        $this->get_prefixed_table_columns(BP_Contact::$table_name, 'contact', 'contact_') . ", " .
        $this->get_prefixed_table_columns(BP_Address::$table_name, 'address', 'address_') . ", " .
        $this->get_prefixed_table_columns(BP_BizType::$table_name, 'biz_type2', 'biz_type2_') . ", " .
        $this->get_prefixed_table_columns(BP_BizNeedDetail::$table_name, 'bndetail', 'bndetail_') . ", " .
        $this->get_prefixed_table_columns(BP_MemberType::$table_name, 'member_type', 'member_type_') . ", " .
        $this->get_prefixed_table_columns(BP_BizService::$table_name, 'biz_service3', 'biz_service3_') .
        " FROM " . $this->get_table_name(BP_Company::$table_name) . " c " .
        "LEFT JOIN " . $this->get_table_name(BP_Country::$table_name) . " country ON c.country_of_incorporate = country.id " .
        "LEFT JOIN " . $this->get_table_name('biz_need_partner_biz_types') . " bnp_biztype ON bnp_biztype.company_id = c.id " .
        "LEFT JOIN " . $this->get_table_name(BP_BizType::$table_name) . " biz_type1 ON biz_type1.id = bnp_biztype.biz_type_id " .
        "LEFT JOIN " . $this->get_table_name(BP_BizNeedNGOSuppServ::$table_name) . " ngo_ss ON ngo_ss.company_id = c.id " . 
        "LEFT JOIN " . $this->get_table_name('biz_need_ngo_services') . " ngo_ss_service ON ngo_ss_service.biz_need_ngo_id = ngo_ss.id " .       
        "LEFT JOIN " . $this->get_table_name(BP_BizService::$table_name) . " biz_service3 ON biz_service3.id = ngo_ss_service.service_id " . 
        "LEFT JOIN " . $this->get_table_name(BP_BizNeedInvestment::$table_name) . " need_inv ON need_inv.company_id = c.id " . 
        "LEFT JOIN " . $this->get_table_name(BP_Contact::$table_name) . " contact ON contact.company_id = c.id " .
        "LEFT JOIN " . $this->get_table_name(BP_Address::$table_name) . " address ON address.company_id = c.id " .
        "LEFT JOIN " . $this->get_table_name('company_biz_types') . " com_biz_type ON com_biz_type.company_id = c.id " . 
        "LEFT JOIN " . $this->get_table_name(BP_BizType::$table_name) . " biz_type2 ON biz_type2.id = com_biz_type.biz_type_id " .
        "LEFT JOIN " . $this->get_table_name(BP_BizNeedDetail::$table_name) . " bndetail ON bndetail.company_id = c.id " .
        "LEFT JOIN " . $this->get_table_name(BP_MemberType::$table_name) . " member_type ON member_type.id = c.member_type_id " .
        "WHERE c.id = " . $company->id;
        //echo $sql;
        $results = $this->db->get_results($sql, ARRAY_A);
//print_r($results);        
        if ($results) {
            $BP_Hydrator = new BP_Hydrator();
            foreach ($results as $res)
            {                
                // check if company already exists because this is going to be a loop
                // of multiple records as we are doing LEFT JOIN
                if (!$company->country) {
                    $BP_Country = new BP_Country();
                    BP_Hydrator::hydrate($BP_Country, $res, 'country_');
                    $company->country = $BP_Country;
                }

                if ($res['biz_type1_id'] && !isset($company->biz_need_partner_biz_types[$res['biz_type1_id']])) 
                {
                    $BP_BizType = new BP_BizType();
                    BP_Hydrator::hydrate($BP_BizType, $res, 'biz_type1_');
                    $company->biz_need_partner_biz_types[$res['biz_type1_id']] = $BP_BizType;
                }
                

                if ($res['ngo_ss_id'] && !$company->biz_need_ngo_supp_serv) 
                {
                    $BP_BizNeedNGOSuppServ = new BP_BizNeedNGOSuppServ();
                    BP_Hydrator::hydrate($BP_BizNeedNGOSuppServ, $res, 'ngo_ss_');
                    $company->biz_need_ngo_supp_serv = $BP_BizNeedNGOSuppServ;                                    
                }

                if ($res['ngo_ss_id'] && $res['biz_service3_id'] 
                    && !isset( $company->biz_need_ngo_supp_serv->services_provided[$res['biz_service3_id']])) 
                {                        
                    $BP_BizService = new BP_BizService();
                    BP_Hydrator::hydrate($BP_BizService, $res, 'biz_service3_');
                    $company->biz_need_ngo_supp_serv->services_provided[$res['biz_service3_id']] = $BP_BizService;
                }

                if (($res['need_inv_id'] && !$company->biz_need_investment) 
                    || ($res['need_inv_id'] && !$company->biz_give_investment))
                {
                    $BP_BizNeedInvestment = new BP_BizNeedInvestment();
                    BP_Hydrator::hydrate($BP_BizNeedInvestment, $res, 'need_inv_');
                    if ($BP_BizNeedInvestment->invest_type === BP_BizNeedInvestment::TYPE_PROVIDE && !$company->biz_give_investment)
                        $company->biz_give_investment = $BP_BizNeedInvestment;
                    else if ($BP_BizNeedInvestment->invest_type === BP_BizNeedInvestment::TYPE_NEED && !$company->biz_need_investment)
                        $company->biz_need_investment = $BP_BizNeedInvestment;
                }


                // inv_ind1
                if ($res['inv_ind1_id']) 
                {
                    $BP_Industry = new BP_Industry();
                    BP_Hydrator::hydrate($BP_Industry, $res, 'inv_ind1_');
                    if (isset($company->biz_need_investment))
                    {
                        $company->biz_need_investment->industries[$res['inv_ind1_id']] = $BP_Industry;
                    }
                    else 
                    {
                        $company->biz_give_investment->industries[$res['inv_ind1_id']] = $BP_Industry;
                    }
                }

                if ($res['contact_id'] && !$company->contacts[$res['contact_id']])
                {
                    $BP_Contact = new BP_Contact();
                    BP_Hydrator::hydrate($BP_Contact, $res, 'contact_');
                    $company->contacts[$res['contact_id']] = $BP_Contact;
                }

                if ($res['address_id'] && !$company->addresses[$res['contact_id']])
                {
                    $BP_Address = new BP_Address();
                    BP_Hydrator::hydrate($BP_Address, $res, 'address_');
                    $company->addresses[$res['address_id']] = $BP_Address;
                }

                if ($res['biz_type2_id'] && !isset($company->biz_types[$res['biz_type2_id']]))
                {
                    $BP_BizType = new BP_BizType();
                    BP_Hydrator::hydrate($BP_BizType, $res, 'biz_type2_');
                    $company->biz_types[$res['biz_type2_id']] = $BP_BizType;
                }

                if ($res['industry_id'] && !isset($company->industries[$res['industry_id']])) {
                    $BP_Industry = new BP_Industry();
                    BP_Hydrator::hydrate($BP_Industry, $res, 'industry_');
                    $company->industries[$res['industry_id']] = $BP_Industry;
                }

                if ($res['bndetail_id'] && !isset($company->biz_need_details[$res['bndetail_id']]))
                {
                    $BP_BizNeedDetail = new BP_BizNeedDetail();
                    BP_Hydrator::hydrate($BP_BizNeedDetail, $res, 'bndetail_');
                    $company->biz_need_details[$res['bndetail_id']] = $BP_BizNeedDetail;
                }

                if ($res['member_type_id'] && !$company->member_type) 
                {
                    $BP_MemberType = new BP_MemberType();
                    BP_Hydrator::hydrate($BP_MemberType, $res, 'member_type_');
                    $company->member_type = $BP_MemberType;
                }
            }            
            
            //$company->industries = $company_industries;
        }
        
        // Industries
        if ($company->id > 0) 
        {
            $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Industry::$table_name, 'ind', 'ind_') . 
                 " FROM " . $this->get_table_name(BP_Industry::$table_name) . " ind " .
                 "LEFT JOIN " . $this->get_table_name('company_industry') . " com_ind ON com_ind.industry_id = ind.id " .
                 "WHERE com_ind.company_id = " . $company->id;
            
            $results = $this->db->get_results($sql, ARRAY_A);
            if ($results && is_array($results))
            {
                $BP_Hydrator = new BP_Hydrator();
                foreach ($results as $res)
                {                
                    if ($res['ind_id']) {
                        $BP_Industry = new BP_Industry();
                        BP_Hydrator::hydrate($BP_Industry, $res, 'ind_');
                        $company->add_industry($BP_Industry);
                    }                
                }
            }
            
        }

        if ($company->id)
        {
            // $company->biz_need_partner_industries
            //            
            $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Industry::$table_name, 'ind', 'ind_') . 
                " FROM " . $this->get_table_name(BP_Industry::$table_name) . " ind " .
                "LEFT JOIN " . $this->get_table_name('biz_need_partner_industries') . " bnp_ind ON bnp_ind.industry_id = ind.id " .
                "WHERE bnp_ind.company_id = " . $company->id . " GROUP BY ind.id";

            $results = $this->db->get_results($sql, ARRAY_A);

            if ($results && is_array($results)) 
            {
                $BP_Hydrator = new BP_Hydrator();
                foreach ($results as $res)
                {
                    if ($res['ind_id']
                        && !isset($company->biz_need_partner_industries[$res['ind_id']])) 
                    {
                        $BP_Industry = new BP_Industry();
                        BP_Hydrator::hydrate($BP_Industry, $res, 'ind_');
                        $company->biz_need_partner_industries[$res['ind_id']] = $BP_Industry;
                    }
                }
            }

            //$company->biz_need_services
            //
            $sql = "SELECT " . $this->get_prefixed_table_columns(BP_BizService::$table_name, 'service', 'service_') .
                " FROM " . $this->get_table_name(BP_BizService::$table_name) . " service " .
                "LEFT JOIN " . $this->get_table_name('biz_need_services') . " bns ON bns.service_id = service.id " .
                "WHERE bns.company_id = " . $company->id;

            $results = $this->db->get_results($sql, ARRAY_A);

            if ($results && is_array($results)) 
            {
                $BP_Hydrator = new BP_Hydrator();
                foreach ($results as $res)
                {
                    if ($res['service_id']
                        && !isset($company->biz_need_services[$res['service_id']])) 
                    {
                        $BP_BizService = new BP_BizService();
                        BP_Hydrator::hydrate($BP_BizService, $res, 'service_');
                        $company->biz_need_services[$res['service_id']] = $BP_BizService;
                    }
                }
            }

            //$company->biz_give_services
            //
            $sql = "SELECT " . $this->get_prefixed_table_columns(BP_BizService::$table_name, 'service', 'service_') .
                " FROM " . $this->get_table_name(BP_BizService::$table_name) . " service " .
                "LEFT JOIN " . $this->get_table_name('biz_give_services') . " bgs ON bgs.service_id = service.id " .
                "WHERE bgs.company_id = " . $company->id;

            $results = $this->db->get_results($sql, ARRAY_A);

            if ($results && is_array($results)) 
            {
                $BP_Hydrator = new BP_Hydrator();
                foreach ($results as $res)
                {
                    if ($res['service_id']
                        && !isset($company->biz_give_services[$res['service_id']])) 
                    {
                        $BP_BizService = new BP_BizService();
                        BP_Hydrator::hydrate($BP_BizService, $res, 'service_');
                        $company->biz_give_services[$res['service_id']] = $BP_BizService;
                    }
                }
            }

            //
            // $company->biz_need_investment->industries[$res['inv_ind1_id']] 
            //
            if ($company->biz_need_investment->id > 0)
            {
                $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Industry::$table_name, 'industry', 'industry_')  .
                    " FROM " . $this->get_table_name(BP_Industry::$table_name) . " industry " .
                    " LEFT JOIN " . $this->get_table_name('investments_industries') . " inv_ind ON inv_ind.industry_id = industry.id " .
                    " WHERE inv_ind.investment_id = " . $company->biz_need_investment->id;

                $results = $this->db->get_results($sql, ARRAY_A);

                if ($results && is_array($results)) 
                {
                    $BP_Hydrator = new BP_Hydrator();
                    foreach ($results as $res)
                    {
                        if ($res['industry_id']
                            && !isset($company->biz_need_investment->industries[$res['industry_id']])) 
                        {
                            $BP_Industry = new BP_Industry();
                            BP_Hydrator::hydrate($BP_Industry, $res, 'industry_');
                            $company->biz_need_investment->industries[$res['industry_id']] = $BP_Industry;
                        }
                    }
                }
            }

            if ($company->biz_give_investment->id > 0)
            {
                $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Industry::$table_name, 'industry', 'industry_')  .
                    " FROM " . $this->get_table_name(BP_Industry::$table_name) . " industry " .
                    " LEFT JOIN " . $this->get_table_name('investments_industries') . " inv_ind ON inv_ind.industry_id = industry.id " .
                    " WHERE inv_ind.investment_id = " . $company->biz_give_investment->id;

                $results = $this->db->get_results($sql, ARRAY_A);

                if ($results && is_array($results)) 
                {
                    $BP_Hydrator = new BP_Hydrator();
                    foreach ($results as $res)
                    {
                        if ($res['industry_id']
                            && !isset($company->biz_give_investment->industries[$res['industry_id']])) 
                        {
                            $BP_Industry = new BP_Industry();
                            BP_Hydrator::hydrate($BP_Industry, $res, 'industry_');
                            $company->biz_give_investment->industries[$res['industry_id']] = $BP_Industry;
                        }
                    }
                }
            }

        }
        
        $company_profile = $this->get_company_profile($company->id);
        $company->profile = $company_profile;


        return $company;
    }
    
    private function create_sql_for_filter_partial(BP_Company_Filter $filter, $is_count = false, $count = 0, $offset = 0)
    {
        $sql = '';
        
        $sql .= " LEFT JOIN " . $this->get_table_name(BP_CompanyProfile::$table_name) . " profile on profile.company_id = c.id";
        $sql .= " LEFT JOIN " . $this->get_table_name(BP_Score::$table_name) . " score on score.company_id = c.id";
        if ($filter->has_sme_typeof_biz())
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('company_biz_types') . " com_biztype ON com_biztype.company_id = id";
        }
        if ($filter->has_sme_industries())
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('company_industry') . " com_ind ON com_ind.company_id = id";
        }
        // (biz_need_partner_industries)
        if (count($filter->partner_in_industries) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('biz_need_partner_industries') . " bnp_ind ON bnp_ind.company_id = c.id";
        }
        // (biz_need_partner_biz_types)
        if (count($filter->partner_in_typeof_businesses) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('biz_need_partner_biz_types') . " bnp_biztype ON bnp_biztype.company_id = c.id";
        }
        // (biz_need_investments)
        if ($filter->do_invest() || $filter->has_invest_req_turnover() || $filter->has_invest_req_years_in_biz() || count($filter->invest_in_industries) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('biz_need_investments') . " bninv ON bninv.company_id = c.id";
        }
        // (biz_give_services)
        if (count($filter->provided_services) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('biz_give_services') . " bgv_serv ON bgv_serv.company_id = c.id";
        }
        // (investments_industries)
        if (count($filter->invest_in_industries) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('investments_industries') . " inv_ind ON inv_ind.investment_id = bninv.id";
        }
        // (biz_need_ngo_supp_serv)
        if ($filter->has_ngo_organization_type() || count($filter->ngo_service_provided) > 0) {
            $sql .= " LEFT JOIN " . $this->get_table_name('biz_need_ngo_supp_serv') . " ngo ON ngo.company_id = c.id";
        }
        // (biz_need_ngo_services)
        if (count($filter->ngo_service_provided) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('biz_need_ngo_services') . " ngo_serv ON ngo_serv.biz_need_ngo_id = ngo.id";
        }
        
        
        // used to add the OR before begin
        $have_condition_group = false;
        $join_var = "";
        // where condition
        if ($filter->has_filter())
            $sql .= " WHERE";
        
        $sql .= " (c.bool_biz_need_partner_in = 1 OR c.bool_biz_need_service OR c.bool_biz_need_invest " .
                "OR c.bool_biz_need_ngo_supp_serv OR c.bool_biz_give_service OR c.bool_biz_give_invest) ";
        $have_condition_group = true;
        $join_var = 'AND';
        
        // Memeber type
        if ($filter->find_only_acive) {
            if ($have_condition_group) $sql .= $join_var;
            $have_condition_group = true;
            $sql .= " active = 1 ";
            $join_var = "AND";
        }
        if (!is_null($filter->member_type) && $filter->member_type == BP_MemberType::TYPE_INTL)
        {
            if ($have_condition_group) $sql .= $join_var;
            $have_condition_group = true;
            $sql .= " member_type_id = '" . BP_MemberType::TYPE_INTL . "' ";
            $join_var = "AND";
        }
        else if (!is_null($filter->member_type) && $filter->member_type == BP_MemberType::TYPE_SME)
        {
            if ($have_condition_group) $sql .= $join_var;
            $have_condition_group = true;
            $sql .= " member_type_id = '" . BP_MemberType::TYPE_SME . "' ";
            $join_var = "AND";
        }
        else if (!is_null($filter->member_type) && $filter->member_type == BP_MemberType::TYPE_NGO)
        {
            if ($have_condition_group) $sql .= $join_var;
            $have_condition_group = true;
            $sql .= " member_type_id = '" . BP_MemberType::TYPE_NGO . "' ";
            $join_var = "AND";
        }
        
        
        if ($filter->bool_biz_need_partner_in) {
            if ($have_condition_group) $sql .= $join_var;
            $sql .= " bool_biz_need_partner_in = 1 ";
            $have_condition_group = true;
            $join_var = "AND";
        }
        if ($filter->bool_biz_give_service) {
            if ($have_condition_group) $sql .= $join_var;
            $sql .= " bool_biz_give_service = 1 ";
            $have_condition_group = true;
            $join_var = "AND";
        }        
        if ($filter->bool_biz_give_invest) {
            if ($have_condition_group) $sql .= $join_var;
            $sql .= " bool_biz_give_invest = 1 ";
            $have_condition_group = true;
            $join_var = "AND";
        }  
        if ($filter->bool_biz_need_ngo_supp_serv) {
            if ($have_condition_group) $sql .= $join_var;
            $sql .= " bool_biz_need_ngo_supp_serv = 1 ";
            $have_condition_group = true;
            $join_var = "AND";
        }      
        
        $sql_main = $sql;
        $sql = '';
        $join_var_start = $join_var;
        
        // country_of_incorporate
        if (isset($filter->country_of_incorporate) && count($filter->country_of_incorporate)  > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} ";
        
            $sql_where = ' (';
            foreach ($filter->country_of_incorporate as $value) {
                $sql_where .= "c.country_of_incorporate = {$value} OR ";
            }
            $sql_where = substr($sql_where, 0, -3);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // partner_in_industries
        if (count($filter->partner_in_industries) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->partner_in_industries as $ind_id)
            {
                $sql_where .= " AND bnp_ind.industry_id = " . (int)$ind_id;
            }
            $sql_where = substr($sql_where, 5);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // partner_in_typeof_businesses
        if (count($filter->partner_in_typeof_businesses) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->partner_in_typeof_businesses as $biz_type_id)
            {
                $sql_where .= " AND bnp_biztype.biz_type_id = " . (int)$biz_type_id;
            }
            $sql_where = substr($sql_where, 5);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // SME turnover
        if ($filter->has_sme_turnover_value())
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
            $sql_where = '';
            foreach ($filter->sme_turnover as $value) {
                if ($value['min'] > 0 && $value['max'] > 0)
                    $sql_where .= "(turnover_min >= {$value['min']} AND turnover_max <= {$value['max']}) ";
                else if ($value['min'] > 0)
                    $sql_where .= "turnover_min >= {$value['min']} ";
                else if ($value['max'] > 0)
                    $sql_where .= "turnover_max <= {$value['max']} ";
        
                if ($value['min'] > 0 || $value['max'] > 0)
                    $sql_where .= "OR ";
            }
            $sql_where = substr($sql_where, 0, -3);
            $sql_where .= ') ';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR ";
        }
        
        // SME number of employee
        if ($filter->has_sme_numberof_employees())
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
            foreach ($filter->sme_employee as $value) {
                if ($value['min'] > 0 && $value['max'] > 0)
                    $sql_where .= "(num_employee_min >= {$value['min']} && num_employee_max <= {$value['max']}) ";
                else if ($value['min'] > 0)
                    $sql_where .= "num_employee_min >= {$value['min']} ";
                else if ($value['max'] > 0)
                    $sql_where .= "num_employee_max <= {$value['max']} ";
        
                if ($value['min'] > 0 || $value['max'])
                    $sql_where .= "OR ";
            }
            $sql_where = substr($sql_where, 0, -3);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // SME type of business
        if ($filter->has_sme_typeof_biz())
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->sme_typeof_biz as $type_id)
            {
                $sql_where .= " OR com_biztype.biz_type_id = " . (int)$type_id;
            }
            $sql_where = substr($sql_where, 3);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // SME industries
        if ($filter->has_sme_industries())
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->industries as $value)
            {
                $sql_where .= " OR com_ind.industry_id = " . (int)$value;
            }
            $sql_where = substr($sql_where, 3);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // partner_in_industries
        if (count($filter->partner_in_industries) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->partner_in_industries as $ind_id)
            {
                $sql_where .= " OR bnp_ind.industry_id = " . (int)$ind_id;
            }
            $sql_where = substr($sql_where, 4);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
         
        
        // partner_in_typeof_businesses
        if (count($filter->partner_in_typeof_businesses) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->partner_in_typeof_businesses as $biz_type_id)
            {
                $sql_where .= " OR bnp_biztype.biz_type_id = " . (int)$biz_type_id;
            }
            $sql_where = substr($sql_where, 4);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // do_invest
        if ($filter->do_invest())
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
            
            $sql_where = "bninv.invest_type='" . BP_BizNeedInvestment::TYPE_PROVIDE . "' AND (";
            foreach ($filter->do_invest as $value) {
                if ($value['min'] > 0 && $value['max'] > 0)
                    $sql_where .= "(bninv.min >= {$value['min']} AND bninv.max <= {$value['max']}) ";
                else if ($value['min'] > 0)
                    $sql_where .= "bninv.min >= {$value['min']} ";
                else if ($value['max'] > 0)
                    $sql_where .= "bninv.max <= {$value['max']} ";
            
                if ($value['min'] > 0 || $value['max'])
                    $sql_where .= "OR ";
            }
            $sql_where = substr($sql_where, 0, -3);
            $sql_where .= '))';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // provided_services
        if (count($filter->provided_services) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->provided_services as $service_id)
            {
                $sql_where .= " OR bgv_serv.service_id = " . $service_id;
            }
            $sql_where = substr($sql_where, 4);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // invest_in_industries
        if (count($filter->invest_in_industries) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->invest_in_industries as $industry_id)
            {
                $sql_where .= " OR inv_ind.industry_id = " . (int)$industry_id;
            }
            $sql_where = substr($sql_where, 4);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // has_invest_req_turnover
        if ($filter->has_invest_req_turnover())
        {   
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
            
            $sql_where = "bninv.invest_type='" . BP_BizNeedInvestment::TYPE_PROVIDE . "' AND (";
            foreach ($filter->invest_req_turnover as $value) {
                if ($value['min'] > 0 && $value['max'] > 0)
                    $sql_where .= "(bninv.turnover_min >= {$value['min']} AND bninv.turnover_max <= {$value['max']}) ";
                else if ($value['min'] > 0)
                    $sql_where .= "bninv.turnover_min >= {$value['min']} ";
                else if ($value['max'] > 0)
                    $sql_where .= "bninv.turnover_max <= {$value['max']} ";
            
                if ($value['min'] > 0 || $value['max'])
                    $sql_where .= "OR ";
            }
            $sql_where = substr($sql_where, 0, -3);
            $sql_where .= '))';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // has_invest_req_years_in_biz
        if ($filter->has_invest_req_years_in_biz())
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
            
            $sql_where = "bninv.invest_type='" . BP_BizNeedInvestment::TYPE_PROVIDE . "' AND (";
            foreach ($filter->invest_req_years_biz as $value) {
                if ($value['min'] > 0 && $value['max'] > 0)
                    $sql_where .= "(bninv.years_in_biz_min >= {$value['min']} AND bninv.years_in_biz_max <= {$value['max']}) ";
                else if ($value['min'] > 0)
                    $sql_where .= "bninv.years_in_biz_min >= {$value['min']} ";
                else if ($value['max'] > 0)
                    $sql_where .= "bninv.years_in_biz_max <= {$value['max']} ";
            
                if ($value['min'] > 0 || $value['max'])
                    $sql_where .= "OR ";
            }
            $sql_where = substr($sql_where, 0, -3);
            $sql_where .= '))';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // NGO Organization type
        if ($filter->has_ngo_organization_type()) {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
            if ($filter->ngo_org_type_development_agency == 1) {
                $sql_where .= " OR ngo.org_type_development_agency = " . (int)$filter->ngo_org_type_development_agency;
            }
            if (!is_null($filter->ngo_org_type_chamber_of_commerce)) {
                $sql_where .= " OR ngo.org_type_chamber_of_commerce = " . (int)$filter->ngo_org_type_chamber_of_commerce;
            }
            $sql_where = substr($sql_where, 4);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        // ngo_service_provided
        if (count($filter->ngo_service_provided) > 0)
        {
            if ($have_condition_group)
                $sql .= " {$join_var} (";
            else
                $sql .= " (";
        
            $sql_where = '';
        
            foreach ($filter->ngo_service_provided as $service_id)
            {
                $sql_where .= " OR ngo_serv.service_id = " . (int)$service_id;
            }
            $sql_where = substr($sql_where, 4);
            $sql_where .= ')';
            $sql .= $sql_where;
            $have_condition_group = true;
            $join_var = "OR";
        }
        
        if (strlen($sql) > 0) {
            $sql = $sql_main . ' AND (' . substr($sql, (strlen($join_var_start)+1)) . ')';
        }
        else {
            $sql = $sql_main;
        }        
        
        $sql .= " ORDER BY scores DESC ";
        
        if (!$is_count) {
            if ($count > 0 && $offset > 0)
                $sql .= " LIMIT " . $offset . ", " . $count;
            else
                $sql .= " LIMIT " . $count;
        }
        
        return $sql;
    }
    
    // ======================================================================================
    //
    // FILTER DIRECTORY
    //
    // ======================================================================================
    
    /**
     * Filter company directory
     * 
     * @param BP_Directory_Filter $filter
     * @param int $count
     * @param int $offset
     */
    public function filter_directory(BP_Directory_Filter $filter, $count = 10, $offset = 0)
    {   
        $ViewModel_Companies = new ViewModel_Companies();

        $sql_count = $this->create_sql_for_filter_dir_count($filter);
        $ViewModel_Companies->total = $this->db->get_var($sql_count);

        $sql = $this->create_sql_for_filter_dir($filter, $count, $offset);
        
        $companies_array = $this->db->get_results($sql, ARRAY_A);
        $companies_obj_array = array();
        $ViewModel_Companies->companies = parent::map_result('\BP_Company', $companies_array);
        $ViewModel_Companies->count = $count;
        $ViewModel_Companies->offset = $offset;
        
        //print_r($companies_array);
        
        foreach ($companies_array as $res)
        {
        	/*if ($res['profile_company_id'] && !isset($ViewModel_Companies->companies[$res['id']]->profile)) 
            {
            	$BP_CompanyProfile = new BP_CompanyProfile();
                BP_Hydrator::hydrate($BP_CompanyProfile, $res, 'profile_');
                $ViewModel_Companies->companies[$res['id']]->profile = $BP_CompanyProfile;
            }*/
            
            if ($res['ind_id']) {
                $BP_Industry = new BP_Industry();
                BP_Hydrator::hydrate($BP_Industry, $res, 'ind_');
                $ViewModel_Companies->companies[$res['id']]->industries[$BP_Industry->id] = $BP_Industry;
            }
            
            if ($res['contact_id']) {
                $BP_Contact = new BP_Contact();
                BP_Hydrator::hydrate($BP_Contact, $res, 'contact_');
                $ViewModel_Companies->companies[$res['id']]->contacts[$BP_Contact->id] = $BP_Contact;
            }        
            if ($res['address_id']) {
                $BP_Address = new BP_Address();
                BP_Hydrator::hydrate($BP_Address, $res, 'address_');
                $ViewModel_Companies->companies[$res['id']]->addresses[$BP_Address->id] = $BP_Address;
            }   
        }
        
        return $ViewModel_Companies;
    }
        
    /**
     * Create sql based on the filter parameters for count records in direcotry
     *
     * @var BP_Directory_Filter $filter
     * @return string
     */
    public function create_sql_for_filter_dir_count(BP_Directory_Filter $filter, $count = 0, $offset = 0)
    {
        $sql = "SELECT COUNT(DISTINCT c.id) FROM " . $this->get_table_name(BP_Company::$table_name) . " c";
    
        $sql .= $this->create_sql_for_filter_dir_partial($filter, true, $count, $offset);
        //error_log($sql);
        return $sql;
    }
    
    /**
     * Create sql based on the filter parameters for directory
     *
     * @var BP_Directory_Filter $filter
     * @var int $count
     * @var int $offset
     * @return string
     */
    public function create_sql_for_filter_dir(BP_Directory_Filter $filter, $count = 0, $offset = 0)
    {
        $sql = "SELECT " . $this->get_prefixed_table_columns(BP_Company::$table_name, "c") . "," .
                $this->get_prefixed_table_columns(BP_Contact::$table_name, 'contact', 'contact_') . "," .
                $this->get_prefixed_table_columns(BP_Address::$table_name, 'address', 'address_') . "," .
                $this->get_prefixed_table_columns(BP_Industry::$table_name, 'ind', 'ind_')
                //$this->get_prefixed_table_columns(BP_CompanyProfile::$table_name, "profile", 'profile_')                
                . " FROM " . $this->get_table_name(BP_Company::$table_name) . " c";
    
        $sql .= $this->create_sql_for_filter_dir_partial($filter, false, $count, $offset);
        //$sql .= " LEFT JOIN " . $this->get_table_name(BP_CompanyProfile::$table_name) . " profile ON profile.company_id = c.id";
        $sql .= " LEFT JOIN " . $this->get_table_name('company_industry') . " com_ind ON com_ind.company_id = c.id";        
        $sql .= " LEFT JOIN " . $this->get_table_name(BP_Industry::$table_name) . " ind ON ind.id = com_ind.industry_id";
        $sql .= " LEFT JOIN " . $this->get_table_name(BP_Contact::$table_name) . " contact ON contact.company_id = c.id";
        $sql .= " LEFT JOIN " . $this->get_table_name(BP_Address::$table_name) . " address ON address.company_id = c.id";
        
        return $sql;
    }
    
    private function create_sql_for_filter_dir_partial(BP_Directory_Filter $filter, $is_count = false, $count = 0, $offset = 0)
    {
        $sql = " INNER JOIN (SELECT DISTINCT id FROM " . $this->get_table_name(BP_Company::$table_name) . " c";
        
        // LEFT JOINS INSIDE INNER JOIN
        if (count($filter->industries) > 0)
        {
            $sql .= " LEFT JOIN " . $this->get_table_name('company_industry') . " com_ind ON com_ind.company_id = c.id";
        }        
        if (!empty($filter->city))
        {
            $sql .= " LEFT JOIN " . $this->get_table_name(BP_Address::$table_name) . " address ON address.company_id = c.id";
        }

        // INNER JOIN WHERE start
        $join_var = "";
        
        $sql .= " WHERE c.active = " . $filter->active;
        
        /*$sql .= " WHERE (c.bool_biz_need_partner_in = 0 AND c.bool_biz_need_service = 0 AND c.bool_biz_need_invest = 0" .
                " AND c.bool_biz_need_ngo_supp_serv = 0 AND c.bool_biz_give_service = 0 AND c.bool_biz_give_invest = 0)";*/
        if ($filter->member_type_id != null)
            $sql .= " AND c.member_type_id = '" . $filter->member_type_id . "'";
        
        if ($filter->bool_biz_give_invest)
        {
            $sql .= " AND c.bool_biz_give_invest = 1";
        }
        if ($filter->bool_biz_give_service)
        {
            $sql .= " AND c.bool_biz_give_service = 1";
        }
        if ($filter->bool_biz_need_ngo_supp_serv)
        {
            $sql .= " AND c.bool_biz_need_ngo_supp_serv = 1";
        }
        if ($filter->bool_biz_need_partner_in)
        {
            $sql .= " AND c.bool_biz_need_partner_in = 1";
        }
        
        $join_var = "AND";
        
        $params = array();
        
        if (!empty($filter->alphabet))
        {
            if (!empty($join_var)) $sql .= " {$join_var}";
            $sql .= " c.company_name LIKE '%s'";
            $params[] = $filter->alphabet . "%";
            $join_var = 'AND';
        }
        
        if (!empty($filter->search_term))
        {
            if (!empty($join_var)) $sql .= " {$join_var}";
            $sql .= " c.company_name LIKE '%s'";
            $params[] = "%" . $filter->search_term . "%";
            $join_var = 'AND';
        }
        
        if (!empty($filter->city))
        {
            if (!empty($join_var)) $sql .= " {$join_var}";
            $sql .= " address.city LIKE '%s'";
            $params[] = "%" . $filter->city . "%";
            $join_var = 'AND';
        }
        
        if (count($filter->industries) > 0)
        {
            if (!empty($join_var)) $sql .= " {$join_var}";
            $sql .= " (";
            $sql_extra = '';
            foreach ($filter->industries as $industry_id)
            {
                if (!empty($sql_extra)) $sql_extra .= " OR";
                $sql_extra .= " com_ind.industry_id = " . $industry_id;
            }
            $sql .= $sql_extra . ")";
            $join_var = "AND";
        }
        
        $sql = vsprintf($sql, $params);
        
        $sql .= " ORDER BY c.company_name";
        
        if (!$is_count) 
        {
            if ($count > 0 && $offset > 0)
                $sql .= " LIMIT {$offset}, {$count}";
            else if ($count > 0)
                $sql .= " LIMIT {$count}";
        }
        
        // INNER JOIN WHERE end
        
        $sql .= ") x ON x.id = c.id";
        
        // Mandatory condition for directory
        
        
        
        return $sql;
    }   
    
    
    
    // ======================================================================================
    //
    // FILTER DIRECTORY END
    //
    // ======================================================================================
    
    
    /**
     * Add industry
     * 
     * @param string $industry_name
     * @param int $value_type 1 mean user value and 2 means for direcotry listing
     */
    public function add_company_industry($industry_name, $value_type)
    {
        $sql = "SELECT id FROM " . $this->get_table_name(BP_Industry::$table_name) . " WHERE is_user_value = 2 AND LOWER(ind_name) = '" . strtolower($industry_name) . "'";
        $found_id = $this->db->get_var($sql);
        
        if ($found_id > 0)
            return $found_id;
        
        $data = array(
                'ind_name' => $industry_name,
                'is_user_value' => 2,
            );
        $this->db->insert($this->get_table_name(BP_Industry::$table_name), $data);
        if ($this->db->insert_id)
            return $this->db->insert_id;
    }
    
    
    
    

    public function create_sql_select_all_companies($table_name, array $where = array(), array $format = array(), $count = 0, $offset = 0)
    {
        $sql = "SELECT c.* FROM " . $this->get_table_name($table_name) . " c";
        $sql .= " LEFT JOIN " . $this->get_table_name(BP_Score::$table_name) . " sco ON sco.company_id = c.id";
        $sql .= $this->create_partial_sql($where, $format, $count, $offset);
        $sql .= " GROUP BY c.id ORDER BY sco.scores";

        $replace_values = array();
        if ($count > 0 && $offset > 0) {
            $sql .= " LIMIT %d, %d";
            $replace_values[] = $offset;
            $replace_values[] = $count;
        }
        elseif ($count > 0) {
            $sql .= " LIMIT %d";
            $replace_values[] = $count;
        }

        if (count($replace_values) > 0)
            $sql = vsprintf($sql, $replace_values);

        return $sql;
    }
    
}
