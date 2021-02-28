<?php 

/**
 * Class for filtering among business directory
 * 
 * @author muneer
 *
 */
class BP_Directory_Filter
{
    /**
     * @var string $alphabet Alphabatical search term
     */
    public $alphabet = null;
    
    /**
     * @var string $search_term Search term
     */
    public $search_term = null;
    
    /**
     * @var array|int $categories selected categories
     */
    public $industries = array();

    /**
     * @var int $active
     */
    public $active = 1;    
    
    /**
     * @var string $city
     */
    public $city = '';
    
    public $bool_biz_need_partner_in = false;
    public $bool_biz_give_service = false;
    public $bool_biz_give_invest = false;
    public $bool_biz_need_ngo_supp_serv = false;
    
    public $member_type_id = null;
}