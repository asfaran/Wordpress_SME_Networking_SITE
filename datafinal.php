$sql[] = "ALTER TABLE wp_portal_biz_give_services
    ADD CONSTRAINT fk_biz_give_services_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_give_services_service_id FOREIGN KEY (service_id) REFERENCES wp_portal_biz_services (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    
    327
    
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_ngo_services
    ADD CONSTRAINT fk_biz_need_ngo_services_ngo_id FOREIGN KEY (biz_need_ngo_id) REFERENCES wp_portal_biz_need_ngo_supp_serv (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_need_ngo_services_service_id FOREIGN KEY (service_id) REFERENCES wp_portal_biz_services (id) ON DELETE SET NULL ON UPDATE CASCADE;";
    338
    
    $sql[] = "ALTER TABLE wp_portal_biz_need_services
    ADD CONSTRAINT fk_biz_services_company_id FOREIGN KEY (company_id) REFERENCES wp_portal_companies (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_biz_services_need_types_service_id FOREIGN KEY (service_id) REFERENCES wp_portal_biz_services (id) ON DELETE CASCADE ON UPDATE CASCADE;";
    355