<?php
/**
 * Class BP_BizNeedDetail
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_BizNeedDetail
{
	/** @var int Identifier */
    public $id;
    
    /** @var int Company ID */
    public $company_id;
    
    /** @var string Business need text-ID */
    public $biz_need_type_id;
    
    /** @var string details text */
    public $detail;
    
    /** @var string Table name */
    public static $table_name = 'biz_need_details';

	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
    public function __construct($id = 0) {
        $this->id = $id;
    }
    
    /**
     * Convert this class to array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
    		'id' => $this->id,
    		'company_id' => $this->company_id,
    		'biz_need_type_id' => $this->biz_need_type_id,
    		'detail' => $this->detail,
    	);
    }
}
