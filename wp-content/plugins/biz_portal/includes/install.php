<?php

function biz_portal_rewrite_flush()
{
    flush_rewrite_rules();
}

function biz_portal_uninstall()
{
    global $wpdb;
    
    if (BIZ_PORTAL_WIPEALL_ON_UNINSTALL)
    {
        // The table order matters because of realational data
        $tables_to_delete  = array(
        	'addresses', 					'contacts',
        	'ads_clicks', 					'node_attachment',
            'nodes_categories',             'nodes',
            'node_category',
			'biz_need_partner_biz_types', 	'biz_need_partner_industries',
			'biz_need_services',	 		'biz_give_services',
        	'advertisements', 				'investments_industries',			
        	'company_biz_types', 			'company_industry',        	
        	'biz_need_details', 			'biz_need_types',
        	'biz_types',
        	'company_profile', 				'favourites',            
        	'scores',         	            'email_templates',				
            'countries',			        'industries',	 				
            'member_type',
			'private_messages',             'biz_need_ngo_services',
            'files_t',                      'biz_need_investments',
            'biz_need_ngo_supp_serv',       'companies', 
            'biz_services',
        );
        
        foreach ($tables_to_delete as $tbl) {
        	$wpdb->query("DROP TABLE IF EXISTS " . _biz_portal_get_table_name($tbl));
        }     
    }
    
    delete_option('biz_portal_db_version');
    delete_option('biz_portal_save_new_industry');
}

function biz_portal_install()
{
    biz_portal_create_tables();
    add_option("biz_portal_db_version", "1.0");
    add_option("biz_portal_save_new_industry", "true");
    biz_portal_insert_initial_data();
}

function biz_portal_insert_initial_data()
{
    global $wpdb;
    $table_member_type = _biz_portal_get_table_name('member_type');    
    $tbl_name_biz_need_types = _biz_portal_get_table_name('biz_need_types');
    
    $wpdb->insert($table_member_type, array(
    	'id'   => BIZ_PORTAL_MEMBER_TYPE_INTL,
        'type_name' => 'International'
    ));
    $wpdb->insert($table_member_type, array(
    	'id'   => BIZ_PORTAL_MEMBER_TYPE_LOCAL,
        'type_name' => 'Local'
    ));

    $wpdb->insert($tbl_name_biz_need_types, array(
        'type_id' => BP_BizNeedType::PARTNER,
        'type_text' => 'Partner(s)'
    ));
    $wpdb->insert($tbl_name_biz_need_types, array(
        'type_id' => BP_BizNeedType::PROVIDE_SERVICE,
        'type_text' => 'Provide Service'
    ));
    $wpdb->insert($tbl_name_biz_need_types, array(
        'type_id' => BP_BizNeedType::NEED_SERVICE,
        'type_text' => 'Need Service'
    ));
    $wpdb->insert($tbl_name_biz_need_types, array(
        'type_id' => BP_BizNeedType::PROVIDE_INVEST,
        'type_text' => 'Provide Invest'
    ));
    $wpdb->insert($tbl_name_biz_need_types, array(
        'type_id' => BP_BizNeedType::NEED_INVEST,
        'type_text' => 'Need Invest'
    ));
    $wpdb->insert($tbl_name_biz_need_types, array(
        'type_id' => BP_BizNeedType::NGO_SUPPORT_SERVICE,
        'type_text' => 'Provide service/support as Nonprofit Organization'
    ));
    
    
    $wpdb->insert(_biz_portal_get_table_name('email_templates'), array(
    	'id' => BIZ_PORTAL_EMAIL_WELCOME,
    	'title' => 'Welcome Email',
        'email_text' => file_get_contents(__DIR__ . '/email_template/email_template_welcome.inc'),
    ));
    $wpdb->insert(_biz_portal_get_table_name('email_templates'), array(
    		'id' => BIZ_PORTAL_EMAIL_REG_REJECTED,
    		'title' => 'Registration Rejected',
            'email_text' => '',
    ));
    $wpdb->insert(_biz_portal_get_table_name('email_templates'), array(
    		'id' => BIZ_PORTAL_EMAIL_RESRC_APPROVED,
    		'title' => 'Resource Approved',
            'email_text' => '',
    ));    
    $wpdb->insert(_biz_portal_get_table_name('email_templates'), array(
            'id' => BIZ_PORTAL_EMAIL_PRIVATE_MESSAGE_NEW,
            'title' => 'New private message',
            'email_text' => file_get_contents(__DIR__ . '/email_template/email_template_pm_new.inc'),
    ));
    $wpdb->insert(_biz_portal_get_table_name('email_templates'), array(
            'id' => BIZ_PORTAL_EMAIL_PRIVATE_MESSAGE_REP,
            'title' => 'Reply to private message',
            'email_text' => file_get_contents(__DIR__ . '/email_template/email_template_pm_rep.inc'),
    ));

    $industries = array(
        array('id' => 1, 'ind_name' => 'Oil & Gas'),
        array('id' => 2, 'ind_name' => 'Telecommunications'),
        array('id' => 3, 'ind_name' => 'Basic Material'),
        array('id' => 4, 'ind_name' => 'Utilities'),
        array('id' => 5, 'ind_name' => 'Industrials'),
        array('id' => 6, 'ind_name' => 'Financials'),
        array('id' => 7, 'ind_name' => 'Consumer Goods'),
        array('id' => 8, 'ind_name' => 'Technology'),
        array('id' => 9, 'ind_name' => 'Health & Care'),
        array('id' => 10, 'ind_name' => 'Hotel & Tourism'),
        array('id' => 11, 'ind_name' => 'Consumer Services'),
        array('id' => 12, 'ind_name' => 'Business & Professional Services'),
    );

    foreach ($industries as $ind)
    {
        $wpdb->insert(_biz_portal_get_table_name('industries'), $ind);
    }

    $type_of_businesses = array(
        array('id' => 1, 'type_text' => 'Service'),
        array('id' => 2, 'type_text' => 'Manufacturing'),
        array('id' => 3, 'type_text' => 'Trading'),
        array('id' => 4, 'type_text' => 'Distribution'),
        array('id' => 5, 'type_text' => 'Engineering & Construction'),
    );

    foreach ($type_of_businesses as $biz_type)
    {
        $wpdb->insert(_biz_portal_get_table_name('biz_types'), $biz_type);
    }

    $services = array(
        array('id' => 1, 'service_name' => 'Accounting'),
        array('id' => 2, 'service_name' => 'Legal'),
        array('id' => 3, 'service_name' => 'Logistics'),
        array('id' => 4, 'service_name' => 'ICT'),
        array('id' => 5, 'service_name' => 'Training'),
        array('id' => 6, 'service_name' => 'Consultancy'),
    );

    foreach ($services as $service)
    {
        $wpdb->insert(_biz_portal_get_table_name('biz_services'), $service);
    }

    foreach (__biz_portal_install_get_country_sql() as $sql) {
        $sql = "INSERT INTO " . _biz_portal_get_table_name('countries') . "(id, country_code, country_name) VALUES " . $sql;
        $wpdb->query($sql);
    }
    
    $node_categories = array(
            array('category_name' => 'Business'),
            array('category_name' => 'Government'),
            array('category_name' => 'Economy'),
            array('category_name' => 'Finance'),
            array('category_name' => 'Management'),
            array('category_name' => 'Asean'),            
    );
    
    foreach ($node_categories as $category)
    {
        $wpdb->insert(_biz_portal_get_table_name('node_category'), $category, array('%s'));
    }
}

/**
 * Create tables on setup
 */
function biz_portal_create_tables()
{
    global $wpdb;
    
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_addresses (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    company_id bigint(19) unsigned NOT NULL,
    company_number varchar(100) DEFAULT NULL,
    city varchar(45) DEFAULT NULL,
    region varchar(45) DEFAULT NULL,
    street varchar(100) DEFAULT NULL,
    postal_code int(10) unsigned DEFAULT NULL,
    country_id int(5) DEFAULT NULL,
    PRIMARY KEY (id),
    KEY fk_company_address_idx (company_id),
    KEY fk_addresses_country_id_idx (country_id)
    ) ENGINE=InnoDB ;";
    
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_ads_clicks (
    		ads_id int(10) unsigned NOT NULL,
    		clicks_count int(11) DEFAULT NULL,
    		views_count int(11) DEFAULT NULL,
    		PRIMARY KEY (ads_id)
    ) ENGINE=InnoDB;";

    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_advertisements (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		ads_type varchar(45) NOT NULL COMMENT 'type of ads\n',
    		image_id int(10) unsigned NOT NULL,
    		link_url varchar(255) DEFAULT NULL,
    		company_id bigint(19) unsigned DEFAULT NULL,
    		PRIMARY KEY (id),
    		KEY fk_advertisements_image_id_idx (image_id),
    		KEY idx_adtype (ads_type)
    ) ENGINE=InnoDB;";
    
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_give_services (
    		company_id bigint(19) unsigned NOT NULL,
    		service_id int(10) unsigned NOT NULL,
    		KEY fk_biz_give_services_company_id_idx (company_id),
    		KEY fk_biz_give_services_service_id_idx (service_id)
    ) ENGINE=InnoDB;";
    
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_details (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		company_id bigint(19) unsigned NOT NULL,
    		biz_need_type_id varchar(45) NOT NULL,
    		detail text,
    		PRIMARY KEY (id),
    		KEY fk_bnd_companie_idx (company_id),
    		KEY fk_biz_need_detail_type_id_idx (biz_need_type_id)
    ) ENGINE=InnoDB;";
    
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_investments (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		invest_type varchar(25) NOT NULL,
    		min bigint(20) DEFAULT NULL,
    		max bigint(20) DEFAULT NULL,
    		sme_employee_min int(11) DEFAULT NULL,
    		sme_employee_max int(11) DEFAULT NULL,
    		turnover_max bigint(20) DEFAULT NULL,
    		turnover_min bigint(20) DEFAULT NULL,
    		turnover_other bigint(20) DEFAULT NULL,
    		years_in_biz_min int(11) DEFAULT NULL,
    		years_in_biz_max int(11) DEFAULT NULL,
    		years_in_biz_other int(11) DEFAULT NULL,
    		company_id bigint(19) unsigned NOT NULL,
    		PRIMARY KEY (id),
    		KEY bp_fk_investments_company_id_idx (company_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_ngo_services (
    		biz_need_ngo_id int(10) unsigned NOT NULL,
    		service_id int(10) unsigned DEFAULT NULL,
    		KEY fk_biz_need_ngo_services_ngo_id_idx (biz_need_ngo_id),
    		KEY fk_biz_need_ngo_services_service_id_idx (service_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_ngo_supp_serv (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		org_type_development_agency tinyint(1) unsigned DEFAULT '0',
    		org_type_chamber_of_commerce tinyint(1) unsigned DEFAULT '0',
    		fund_min bigint(19) unsigned DEFAULT NULL,
    		fund_max bigint(19) unsigned DEFAULT NULL,
    		company_id bigint(19) unsigned NOT NULL,
    		PRIMARY KEY (id),
    		KEY fk_provide_service_support_company_id_idx (company_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_partner_biz_types (
    		company_id bigint(19) unsigned NOT NULL,
    		biz_type_id int(10) unsigned NOT NULL,
    		KEY fk_biz_types_need_types_biz_type_id_idx (biz_type_id),
    		KEY fk_biz_types_need_needs_id_idx (company_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_partner_industries (
    		company_id bigint(19) unsigned NOT NULL,
    		industry_id int(10) unsigned NOT NULL,
    		KEY fk_biz_need_partner_industries_company_id_idx (company_id),
    		KEY fk_biz_need_partner_industries_industry_id_idx (industry_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_services (
    		company_id bigint(19) unsigned NOT NULL,
    		service_id int(10) unsigned NOT NULL,
    		KEY fk_biz_services_need_types_service_id_idx (service_id),
    		KEY fk_biz_services_company_id_idx (company_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_need_types (
    		type_id varchar(45) NOT NULL,
    		type_text varchar(45) DEFAULT NULL,
    		PRIMARY KEY (type_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_services (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		service_name varchar(45) NOT NULL,
    		is_user_value tinyint(1) DEFAULT '0',
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_biz_types (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		type_text varchar(45) NOT NULL,
    		is_user_value tinyint(1) DEFAULT '0',
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_companies (
    		id bigint(19) unsigned NOT NULL AUTO_INCREMENT,
    		user_id bigint(19) unsigned NOT NULL,
    		company_name varchar(60) NOT NULL,
    		country_of_incorporate int(5) NOT NULL,
    		reg_number varchar(100) NOT NULL,
    		year_of_incorporate smallint(5) unsigned DEFAULT NULL,
    		location_head_office varchar(150) DEFAULT NULL,
    		ceo_md varchar(45) DEFAULT NULL,
    		other_branch varchar(150) DEFAULT NULL,
    		turnover_min bigint(19) unsigned NOT NULL DEFAULT '0',
    		turnover_max bigint(19) unsigned NOT NULL DEFAULT '0',
    		num_employee_min int(10) unsigned NOT NULL DEFAULT '0',
    		num_employee_max int(10) unsigned NOT NULL DEFAULT '0',
    		member_type_id varchar(10) NOT NULL,
    		active tinyint(1) unsigned NOT NULL DEFAULT '0',
    		created datetime DEFAULT NULL,
    		last_update timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    		summary text,
    		terms_accepted tinyint( 1 ) unsigned NOT NULL DEFAULT  '0',
    		bool_biz_need_partner_in tinyint(1) NOT NULL DEFAULT '0',
    		bool_biz_need_service tinyint(1) NOT NULL DEFAULT '0',
    		bool_biz_need_invest tinyint(1) NOT NULL DEFAULT '0',
    		bool_biz_need_ngo_supp_serv tinyint(1) NOT NULL DEFAULT '0',
    		bool_biz_give_service tinyint(1) NOT NULL DEFAULT '0' COMMENT '	',
    		bool_biz_give_invest tinyint(1) NOT NULL DEFAULT '0',
    		PRIMARY KEY (id),
    		UNIQUE KEY unq_key_reg_number_country (country_of_incorporate,reg_number),
    		KEY idx_turnover (turnover_min,turnover_max),
    		KEY idx_num_employee (num_employee_min,num_employee_max),
    		KEY idx_country (country_of_incorporate)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_company_biz_types (
    		company_id bigint(19) unsigned NOT NULL,
    		biz_type_id int(10) unsigned NOT NULL,
    		KEY fk_cbt_company_id_idx (company_id),
    		KEY fk_cbt_buss_type_id_idx (biz_type_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_company_industry (
    		company_id bigint(19) unsigned NOT NULL,
    		industry_id int(10) unsigned NOT NULL,
    		KEY fk_ci_industry_idx (industry_id),
    		KEY fk_ci_company_idx (company_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_company_profile (
    		company_id bigint(19) unsigned NOT NULL,
    		logo_id int(11) DEFAULT NULL,
    		header_image_id int(11) DEFAULT NULL,
    		squre_image_id int(11) DEFAULT NULL,
    		lightbox_image_id int(11) DEFAULT NULL,
    		body text,
    		body_looking_for text,
    		PRIMARY KEY (company_id)
    ) ENGINE=InnoDB;";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_contacts (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		company_id bigint(19) unsigned NOT NULL,
    		contact_person varchar(45) NOT NULL,
    		position varchar(45) DEFAULT NULL,
    		telephone varchar(20) DEFAULT NULL,
    		fax varchar(20) DEFAULT NULL,
    		web varchar(100) DEFAULT NULL,
    		mobile varchar(20) DEFAULT NULL,
    		email varchar(60) DEFAULT NULL,
    		PRIMARY KEY (id),
    		KEY fk_company_contact_idx (company_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_countries (
    		id int(5) NOT NULL AUTO_INCREMENT,
    		country_code varchar(3) NOT NULL DEFAULT '',
    		country_name varchar(100) NOT NULL DEFAULT '',
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_email_templates (
    		id varchar(45) NOT NULL,
    		title varchar(60) DEFAULT NULL,
    		email_text text,
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_favourites (
    		company_id bigint(19) unsigned NOT NULL,
    		target_company_id bigint(19) unsigned NOT NULL,
    		created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    		PRIMARY KEY (company_id,target_company_id),
    		KEY fk_favourites_by_company_id_idx (target_company_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_files_t (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		path varchar(255) DEFAULT NULL,
    		mime_type varchar(60) DEFAULT NULL,
    		size_bytes int(11) DEFAULT '0',
    		extension varchar(10) DEFAULT NULL,
    		is_image tinyint(1) NOT NULL DEFAULT '0',
    		file_usage tinyint(1) DEFAULT '0',
    		uid int(11) DEFAULT '0',
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_industries (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		ind_name varchar(45) NOT NULL,
    		is_user_value tinyint(1) DEFAULT '0',
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_member_type (
    		id varchar(10) NOT NULL,
    		type_name varchar(45) NOT NULL,
    		PRIMARY KEY (id),
    		UNIQUE KEY name_UNIQUE (type_name)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_nodes (
    		id bigint(19) unsigned NOT NULL AUTO_INCREMENT,
    		title varchar(255) DEFAULT NULL,
    		company_id bigint(19) unsigned NOT NULL,
    		created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    		active tinyint(1) unsigned NOT NULL DEFAULT '0',
    		body text,
    		node_type varchar(45) DEFAULT 'POST',
    		PRIMARY KEY (id),
    		KEY fk_node_company_id_idx (company_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_nodes_categories (
    		category_id int(10) unsigned NOT NULL,
    		node_id bigint(19) unsigned NOT NULL,
    		KEY fk_nodes_categories_category_id_idx (category_id),
    		KEY fk_nodes_categories_node_id_idx (node_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_node_attachment (
    		node_id bigint(19) unsigned NOT NULL,
    		file_id int(10) unsigned NOT NULL,
    		KEY fk_node_attachment_node_id_idx (node_id),
    		KEY fk_node_attachment_file_id_idx (file_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_node_category (
    		id int(10) unsigned NOT NULL AUTO_INCREMENT,
    		category_name varchar(60) NOT NULL,
    		is_user_value tinyint(1) unsigned NOT NULL DEFAULT '0',
    		PRIMARY KEY (id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_private_messages (
    		id bigint(19) unsigned NOT NULL AUTO_INCREMENT,
    		owner_id BIGINT UNSIGNED NOT NULL DEFAULT  '0',
    		from_company_id bigint(19) unsigned NOT NULL,
    		to_company_id bigint(19) unsigned NOT NULL,
    		message text,
    		created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    		is_read tinyint(1) unsigned NOT NULL DEFAULT '0',
    		reply_to_msg_id bigint(19) unsigned DEFAULT NULL,
    		PRIMARY KEY (id),
    		KEY index2 (from_company_id),
    		KEY index3 (to_company_id),
    		KEY index4 (is_read)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_scores (
    		company_id bigint(19) unsigned NOT NULL,
    		scores int(11) NOT NULL DEFAULT '0',
    		PRIMARY KEY (company_id),
    		KEY fk_scores_company_id_idx (company_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_investments_industries (
    		investment_id int(10) unsigned NOT NULL,
    		industry_id int(10) unsigned NOT NULL,
    		KEY fk_inv_ind_inv_id_idx (investment_id),
    		KEY fk_inv_ind_ind_id_idx (industry_id)
    ) ENGINE=InnoDB";
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_visits (
          id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          page_type_id int(10) unsigned NOT NULL DEFAULT '0',
          page_value bigint(20) unsigned NOT NULL DEFAULT '0',
          created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          user_ip int(11) NOT NULL DEFAULT '0',
          PRIMARY KEY (id),
          KEY wp_portal_visits_index5 (page_type_id),
          KEY wp_portal_visits_index6 (page_value),
          KEY index4 (created),
          KEY index5 (user_ip)
        ) ENGINE=InnoDB";
    
    $sql[] = "ALTER TABLE wp_portal_addresses
    ADD CONSTRAINT fk_company_address FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_addresses_country_id FOREIGN KEY (country_id) REFERENCES wp_portal_countries (id) ON DELETE SET NULL ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_ads_clicks
    ADD CONSTRAINT fk_ads_clicks_ads_id FOREIGN KEY (ads_id) REFERENCES wp_portal_advertisements (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_advertisements
    ADD CONSTRAINT fk_advertisements_image_id FOREIGN KEY (image_id) REFERENCES wp_portal_files_t (id) ON DELETE NO ACTION ON UPDATE NO ACTION;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_give_services
    ADD CONSTRAINT fk_biz_give_services_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_give_services_service_id FOREIGN KEY (service_id) REFERENCES wp_portal_biz_services (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_details
    ADD CONSTRAINT fk_bnd_companie FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_need_detail_type_id FOREIGN KEY (biz_need_type_id) REFERENCES wp_portal_biz_need_types (type_id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_investments
    ADD CONSTRAINT bp_fk_investments_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_ngo_services
    ADD CONSTRAINT fk_biz_need_ngo_services_ngo_id FOREIGN KEY (biz_need_ngo_id) REFERENCES wp_portal_biz_need_ngo_supp_serv (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_need_ngo_services_service_id FOREIGN KEY (service_id) REFERENCES wp_portal_biz_services (id) ON DELETE SET NULL ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_ngo_supp_serv
    ADD CONSTRAINT fk_provide_service_support_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_partner_biz_types
    ADD CONSTRAINT fk_biz_types_need_needs_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_types_need_types_biz_type_id FOREIGN KEY (biz_type_id) REFERENCES wp_portal_biz_types (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_partner_industries
    ADD CONSTRAINT fk_biz_need_partner_industries_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_need_partner_industries_industry_id FOREIGN KEY (industry_id) REFERENCES wp_portal_industries (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_services
    ADD CONSTRAINT fk_biz_services_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_services_need_types_service_id FOREIGN KEY (service_id) REFERENCES wp_portal_biz_services (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_company_biz_types
    ADD CONSTRAINT fk_cbt_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_cbt_buss_type_id FOREIGN KEY (biz_type_id) REFERENCES wp_portal_biz_types (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_company_industry
    ADD CONSTRAINT fk_ci_industry FOREIGN KEY (industry_id) REFERENCES wp_portal_industries (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_ci_company FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_company_profile
    ADD CONSTRAINT fk_company_profile_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE NO ACTION ON UPDATE NO ACTION;";
    
    $sql[] = "ALTER TABLE wp_portal_contacts
    ADD CONSTRAINT fk_company_contact FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_favourites
    ADD CONSTRAINT fk_favourites_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_favourites_by_company_id FOREIGN KEY (target_company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_nodes
    ADD CONSTRAINT fk_node_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_nodes_categories
    ADD CONSTRAINT fk_nodes_categories_category_id FOREIGN KEY (category_id) REFERENCES wp_portal_node_category (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_nodes_categories_node_id FOREIGN KEY (node_id) REFERENCES wp_portal_nodes (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_node_attachment
    ADD CONSTRAINT fk_node_attachment_node_id FOREIGN KEY (node_id) REFERENCES wp_portal_nodes (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_node_attachment_file_id FOREIGN KEY (file_id) REFERENCES wp_portal_files_t (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    $sql[] = "ALTER TABLE wp_portal_scores
    ADD CONSTRAINT fk_scores_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE NO ACTION ON UPDATE NO ACTION;";
    
    $sql[] = "ALTER TABLE wp_portal_investments_industries
    ADD CONSTRAINT fk_inv_ind_inv_id FOREIGN KEY (investment_id) REFERENCES wp_portal_biz_need_investments (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_inv_ind_ind_id FOREIGN KEY (industry_id) REFERENCES wp_portal_industries (id) ON DELETE CASCADE ON UPDATE CASCADE;";   
    
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
    foreach ($sql as $query) {
    	dbDelta($query);
    }
}

function __biz_portal_install_get_country_sql()
{
    return $biz_portal_country_list_sql = array(
    "(1, 'US', 'United States')",
    "(2, 'CA', 'Canada')",
    "(3, 'AF', 'Afghanistan')",
    "(4, 'AL', 'Albania')",
    "(5, 'DZ', 'Algeria')",
    "(6, 'DS', 'American Samoa')",
    "(7, 'AD', 'Andorra')",
    "(8, 'AO', 'Angola')",
    "(9, 'AI', 'Anguilla')",
    "(10, 'AQ', 'Antarctica')",
    "(11, 'AG', 'Antigua and/or Barbuda')",
    "(12, 'AR', 'Argentina')",
    "(13, 'AM', 'Armenia')",
    "(14, 'AW', 'Aruba')",
    "(15, 'AU', 'Australia')",
    "(16, 'AT', 'Austria')",
    "(17, 'AZ', 'Azerbaijan')",
    "(18, 'BS', 'Bahamas')",
    "(19, 'BH', 'Bahrain')",
    "(20, 'BD', 'Bangladesh')",
    "(21, 'BB', 'Barbados')",
    "(22, 'BY', 'Belarus')",
    "(23, 'BE', 'Belgium')",
    "(24, 'BZ', 'Belize')",
    "(25, 'BJ', 'Benin')",
    "(26, 'BM', 'Bermuda')",
    "(27, 'BT', 'Bhutan')",
    "(28, 'BO', 'Bolivia')",
    "(29, 'BA', 'Bosnia and Herzegovina')",
    "(30, 'BW', 'Botswana')",
    "(31, 'BV', 'Bouvet Island')",
    "(32, 'BR', 'Brazil')",
    "(33, 'IO', 'British lndian Ocean Territory')",
    "(34, 'BN', 'Brunei Darussalam')",
    "(35, 'BG', 'Bulgaria')",
    "(36, 'BF', 'Burkina Faso')",
    "(37, 'BI', 'Burundi')",
    "(38, 'KH', 'Cambodia')",
    "(39, 'CM', 'Cameroon')",
    "(40, 'CV', 'Cape Verde')",
    "(41, 'KY', 'Cayman Islands')",
    "(42, 'CF', 'Central African Republic')",
    "(43, 'TD', 'Chad')",
    "(44, 'CL', 'Chile')",
    "(45, 'CN', 'China')",
    "(46, 'CX', 'Christmas Island')",
    "(47, 'CC', 'Cocos (Keeling) Islands')",
    "(48, 'CO', 'Colombia')",
    "(49, 'KM', 'Comoros')",
    "(50, 'CG', 'Congo')",
    "(51, 'CK', 'Cook Islands')",
    "(52, 'CR', 'Costa Rica')",
    "(53, 'HR', 'Croatia (Hrvatska)')",
    "(54, 'CU', 'Cuba')",
    "(55, 'CY', 'Cyprus')",
    "(56, 'CZ', 'Czech Republic')",
    "(57, 'DK', 'Denmark')",
    "(58, 'DJ', 'Djibouti')",
    "(59, 'DM', 'Dominica')",
    "(60, 'DO', 'Dominican Republic')",
    "(61, 'TP', 'East Timor')",
    "(62, 'EC', 'Ecuador')",
    "(63, 'EG', 'Egypt')",
    "(64, 'SV', 'El Salvador')",
    "(65, 'GQ', 'Equatorial Guinea')",
    "(66, 'ER', 'Eritrea')",
    "(67, 'EE', 'Estonia')",
    "(68, 'ET', 'Ethiopia')",
    "(69, 'FK', 'Falkland Islands (Malvinas)')",
    "(70, 'FO', 'Faroe Islands')",
    "(71, 'FJ', 'Fiji')",
    "(72, 'FI', 'Finland')",
    "(73, 'FR', 'France')",
    "(74, 'FX', 'France, Metropolitan')",
    "(75, 'GF', 'French Guiana')",
    "(76, 'PF', 'French Polynesia')",
    "(77, 'TF', 'French Southern Territories')",
    "(78, 'GA', 'Gabon')",
    "(79, 'GM', 'Gambia')",
    "(80, 'GE', 'Georgia')",
    "(81, 'DE', 'Germany')",
    "(82, 'GH', 'Ghana')",
    "(83, 'GI', 'Gibraltar')",
    "(84, 'GR', 'Greece')",
    "(85, 'GL', 'Greenland')",
    "(86, 'GD', 'Grenada')",
    "(87, 'GP', 'Guadeloupe')",
    "(88, 'GU', 'Guam')",
    "(89, 'GT', 'Guatemala')",
    "(90, 'GN', 'Guinea')",
    "(91, 'GW', 'Guinea-Bissau')",
    "(92, 'GY', 'Guyana')",
    "(93, 'HT', 'Haiti')",
    "(94, 'HM', 'Heard and Mc Donald Islands')",
    "(95, 'HN', 'Honduras')",
    "(96, 'HK', 'Hong Kong')",
    "(97, 'HU', 'Hungary')",
    "(98, 'IS', 'Iceland')",
    "(99, 'IN', 'India')",
    "(100, 'ID', 'Indonesia')",
    "(101, 'IR', 'Iran (Islamic Republic of)')",
    "(102, 'IQ', 'Iraq')",
    "(103, 'IE', 'Ireland')",
    "(104, 'IL', 'Israel')",
    "(105, 'IT', 'Italy')",
    "(106, 'CI', 'Ivory Coast')",
    "(107, 'JM', 'Jamaica')",
    "(108, 'JP', 'Japan')",
    "(109, 'JO', 'Jordan')",
    "(110, 'KZ', 'Kazakhstan')",
    "(111, 'KE', 'Kenya')",
    "(112, 'KI', 'Kiribati')",
    "(113, 'KP', 'Korea, Democratic People''s Republic of')",
    "(114, 'KR', 'Korea, Republic of')",
    "(115, 'XK', 'Kosovo')",
    "(116, 'KW', 'Kuwait')",
    "(117, 'KG', 'Kyrgyzstan')",
    "(118, 'LA', 'Lao People''s Democratic Republic')",
    "(119, 'LV', 'Latvia')",
    "(120, 'LB', 'Lebanon')",
    "(121, 'LS', 'Lesotho')",
    "(122, 'LR', 'Liberia')",
    "(123, 'LY', 'Libyan Arab Jamahiriya')",
    "(124, 'LI', 'Liechtenstein')",
    "(125, 'LT', 'Lithuania')",
    "(126, 'LU', 'Luxembourg')",
    "(127, 'MO', 'Macau')",
    "(128, 'MK', 'Macedonia')",
    "(129, 'MG', 'Madagascar')",
    "(130, 'MW', 'Malawi')",
    "(131, 'MY', 'Malaysia')",
    "(132, 'MV', 'Maldives')",
    "(133, 'ML', 'Mali')",
    "(134, 'MT', 'Malta')",
    "(135, 'MH', 'Marshall Islands')",
    "(136, 'MQ', 'Martinique')",
    "(137, 'MR', 'Mauritania')",
    "(138, 'MU', 'Mauritius')",
    "(139, 'TY', 'Mayotte')",
    "(140, 'MX', 'Mexico')",
    "(141, 'FM', 'Micronesia, Federated States of')",
    "(142, 'MD', 'Moldova, Republic of')",
    "(143, 'MC', 'Monaco')",
    "(144, 'MN', 'Mongolia')",
    "(145, 'ME', 'Montenegro')",
    "(146, 'MS', 'Montserrat')",
    "(147, 'MA', 'Morocco')",
    "(148, 'MZ', 'Mozambique')",
    "(149, 'MM', 'Myanmar')",
    "(150, 'NA', 'Namibia')",
    "(151, 'NR', 'Nauru')",
    "(152, 'NP', 'Nepal')",
    "(153, 'NL', 'Netherlands')",
    "(154, 'AN', 'Netherlands Antilles')",
    "(155, 'NC', 'New Caledonia')",
    "(156, 'NZ', 'New Zealand')",
    "(157, 'NI', 'Nicaragua')",
    "(158, 'NE', 'Niger')",
    "(159, 'NG', 'Nigeria')",
    "(160, 'NU', 'Niue')",
    "(161, 'NF', 'Norfork Island')",
    "(162, 'MP', 'Northern Mariana Islands')",
    "(163, 'NO', 'Norway')",
    "(164, 'OM', 'Oman')",
    "(165, 'PK', 'Pakistan')",
    "(166, 'PW', 'Palau')",
    "(167, 'PA', 'Panama')",
    "(168, 'PG', 'Papua New Guinea')",
    "(169, 'PY', 'Paraguay')",
    "(170, 'PE', 'Peru')",
    "(171, 'PH', 'Philippines')",
    "(172, 'PN', 'Pitcairn')",
    "(173, 'PL', 'Poland')",
    "(174, 'PT', 'Portugal')",
    "(175, 'PR', 'Puerto Rico')",
    "(176, 'QA', 'Qatar')",
    "(177, 'RE', 'Reunion')",
    "(178, 'RO', 'Romania')",
    "(179, 'RU', 'Russian Federation')",
    "(180, 'RW', 'Rwanda')",
    "(181, 'KN', 'Saint Kitts and Nevis')",
    "(182, 'LC', 'Saint Lucia')",
    "(183, 'VC', 'Saint Vincent and the Grenadines')",
    "(184, 'WS', 'Samoa')",
    "(185, 'SM', 'San Marino')",
    "(186, 'ST', 'Sao Tome and Principe')",
    "(187, 'SA', 'Saudi Arabia')",
    "(188, 'SN', 'Senegal')",
    "(189, 'RS', 'Serbia')",
    "(190, 'SC', 'Seychelles')",
    "(191, 'SL', 'Sierra Leone')",
    "(192, 'SG', 'Singapore')",
    "(193, 'SK', 'Slovakia')",
    "(194, 'SI', 'Slovenia')",
    "(195, 'SB', 'Solomon Islands')",
    "(196, 'SO', 'Somalia')",
    "(197, 'ZA', 'South Africa')",
    "(198, 'GS', 'South Georgia South Sandwich Islands')",
    "(199, 'ES', 'Spain')",
    "(200, 'LK', 'Sri Lanka')",
    "(201, 'SH', 'St. Helena')",
    "(202, 'PM', 'St. Pierre and Miquelon')",
    "(203, 'SD', 'Sudan')",
    "(204, 'SR', 'Suriname')",
    "(205, 'SJ', 'Svalbarn and Jan Mayen Islands')",
    "(206, 'SZ', 'Swaziland')",
    "(207, 'SE', 'Sweden')",
    "(208, 'CH', 'Switzerland')",
    "(209, 'SY', 'Syrian Arab Republic')",
    "(210, 'TW', 'Taiwan')",
    "(211, 'TJ', 'Tajikistan')",
    "(212, 'TZ', 'Tanzania, United Republic of')",
    "(213, 'TH', 'Thailand')",
    "(214, 'TG', 'Togo')",
    "(215, 'TK', 'Tokelau')",
    "(216, 'TO', 'Tonga')",
    "(217, 'TT', 'Trinidad and Tobago')",
    "(218, 'TN', 'Tunisia')",
    "(219, 'TR', 'Turkey')",
    "(220, 'TM', 'Turkmenistan')",
    "(221, 'TC', 'Turks and Caicos Islands')",
    "(222, 'TV', 'Tuvalu')",
    "(223, 'UG', 'Uganda')",
    "(224, 'UA', 'Ukraine')",
    "(225, 'AE', 'United Arab Emirates')",
    "(226, 'GB', 'United Kingdom')",
    "(227, 'UM', 'United States minor outlying islands')",
    "(228, 'UY', 'Uruguay')",
    "(229, 'UZ', 'Uzbekistan')",
    "(230, 'VU', 'Vanuatu')",
    "(231, 'VA', 'Vatican City State')",
    "(232, 'VE', 'Venezuela')",
    "(233, 'VN', 'Vietnam')",
    "(234, 'VG', 'Virigan Islands (British)')",
    "(235, 'VI', 'Virgin Islands (U.S.)')",
    "(236, 'WF', 'Wallis and Futuna Islands')",
    "(237, 'EH', 'Western Sahara')",
    "(238, 'YE', 'Yemen')",
    "(239, 'YU', 'Yugoslavia')",
    "(240, 'ZR', 'Zaire')",
    "(241, 'ZM', 'Zambia')",
    "(242, 'ZW', 'Zimbabwe')",
    );
}