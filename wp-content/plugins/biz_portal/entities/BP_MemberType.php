<?php
/**
 * Class BP_MemberType
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_MemberType
{
    public $id;
    public $type_name;

    const TYPE_SME = 'TYPE_SME';
    const TYPE_INTL = 'TYPE_INTL';
    const TYPE_NGO = 'TYPE_NGO';
	    
    public static $table_name = 'member_type';
    
    public function __construct($id = self::TYPE_SME) {
        $this->id = $id;
    }
}
