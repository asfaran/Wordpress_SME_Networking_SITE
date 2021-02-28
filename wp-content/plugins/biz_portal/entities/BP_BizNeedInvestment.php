<?php
/**
 * class BP_BizNeedDetail
 * 
 * Require investments from foreign companies or willing to invest
 * on local companies
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_BizNeedInvestment
{
	/**
	 * @var int Identifier
	 */
    public $id;
    
    /**
     * @var string $invest_type
     */
    public $invest_type;
    
    /**
     * @var int Invest amount min value
     */
    public $min;
    
    /**
     * @var int Invest amount max value
     */
    public $max;
    
    /**
     * @var int SME Employee size min value
     */
    public $sme_employee_min;
    
    /**
     * @var int SME Employee size max value
     */
    public $sme_employee_max;
    
    /**
     * @var int Turn over max value
     */
    public $turnover_max;
    
    /**
     * @var int Turn over min value
     */
    public $turnover_min;
    
    /**
     * @var int Turn over other values if necessary
     */
    public $turnover_other;
    
    /**
     * @var int Years in business min value
     */
    public $years_in_biz_min;
    
    /**
     * @var int Years in business max value
     */
    public $years_in_biz_max;
    
    /**
     * @var int Years in business other value if necessary
     */
    public $years_in_biz_other;
    
    /**
     * @var int Company ID which this investment record related to
     */
    public $company_id;
    
    
    const TYPE_PROVIDE = 'TYPE_PROVIDE';
    const TYPE_NEED = 'TYPE_NEED';
    
    
    // ==========================
    // ==========================
    
    /**
     * @var array BP_Industry
     */
    public $industries;

    /**
     * @var BP_Company
     */
    public $company;
    
    /**
     * @var string Table name
     */
    public static $table_name = 'biz_need_investments';


    /**
     * Class constructor
     */
    public function __construct($id = 0) 
    {
        $this->id = $id;
        $this->industries = array();
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
            'invest_type' => $this->invest_type,
            'min' => $this->min,
            'max' => $this->max,
            'sme_employee_min' => $this->sme_employee_min,
            'sme_employee_max' => $this->sme_employee_max,
            'turnover_max' => $this->turnover_max,
            'turnover_min' => $this->turnover_min,
            'turnover_other' => $this->turnover_other,
            'years_in_biz_min' => $this->years_in_biz_min,
            'years_in_biz_max' => $this->years_in_biz_max,
            'years_in_biz_other' => $this->years_in_biz_other,
            'company_id' => $this->company_id,

        );
    }
    
    /**
     * Add industry
     * 
     * @param BP_Industry $industry
     */
    public function add_industry(BP_Industry $industry)
    {
    	$this->industries[] = $industry;
    }
}
