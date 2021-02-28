<?php

/**
 * Class BP_BizNeedTypes
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_BizNeedType
{
	/** 
	 * Identifier  
	 * @var string $type_id 
	 */
    public $type_id;
    /**
     * description
     * @var string $type_text
     */
    public $type_text;

    /** 
     * Constant INVEST_INT
     * @var string INVEST_INT 
     */
    const NEED_INVEST 	= "NEED_INVEST";
    /** 
     * Constant INVEST_LOCAL
     * @var string INVEST_LOCAL 
     */
    const PROVIDE_INVEST 	= "PROVIDE_INVEST";
    /** 
     * Constant PARTNER
     * @var string PARTNER 
     */
    const PARTNER 		= "PARTNER";
    /** 
     * Constant PROVIDE_SERVICE
     * @var string PROVIDE_SERVICE 
     */
    const PROVIDE_SERVICE = "PROVIDE_SERVICE";
    /** 
     * Constant SERVICE
     * @var string SERVICE 
     */
    const NEED_SERVICE 		= "NEED_SERVICE";

    /**
     * Constant NGO_SUPPORT_SERVICE 
     * @var string NGO_SUPPORT_SERVICE
     */
    const NGO_SUPPORT_SERVICE = "NGO_SUPPORT_SERVICE";
    
    /** 
     * Table name
     * @var string $table_name 
     */
    public static $table_name = 'biz_need_types';
    
    /**
     * Class construct 
     * 
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->id = $id;
    }

    /**
     * Check if the type parsed is valid
     * 
     * @param string $type
     * @return bool
     */
    public static function isValid($type) 
    {
    	if ($type === BP_BizNeedType::PARTNER) return TRUE;
    	if ($type === BP_BizNeedType::INVEST_LOCAL) return TRUE;
    	if ($type === BP_BizNeedType::INVEST_INT) return TRUE;
    	if ($type === BP_BizNeedType::PROVIDE_SERVICE) return TRUE;
    	if ($type === BP_BizNeedType::SERVICE) return TRUE;
    }

    /**
     * Convert to array
     * 
     * @return array
     */
    public function to_array()
    {
        return array(
            'type_id' => $this->type_id,
            'type_text' => $this->type_text,
        );
    }
}
