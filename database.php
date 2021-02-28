function biz_portal_create_tables()
{
    global $wpdb;
    
    
    $sql[] = "CREATE TABLE IF NOT EXISTS wp_portal_addresses (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    company_id bigint(19) unsigned NOT NULL,
    company_number varchar(45) DEFAULT NULL,
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
    		id int(10) unsigned NOT NULL,
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
    		email varchar(20) DEFAULT NULL,
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
    