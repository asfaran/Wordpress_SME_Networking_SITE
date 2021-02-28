<?php
/**
 * classs BP_PrivateMessage
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_PrivateMessage
{
	/**
	 * @var int $id
	 */
	public $id;
	
	/**
	 * Owning cmopany id
	 * @var int $owner_id
	 */
	public $owner_id;

	/**
	 * $var int $from_company_id
	 */
	public $from_company_id;

	/**
	 * @var int $to_company_id
	 */
	public $to_company_id;

	/**
	 * @var string $message
	 */
	public $message;

	/**
	 * @var string $created
	 */
	public $created;

	/**
	 * @var bool $is_read;
	 */
	public $is_read;

	/**
	 * @var int $reply_to_message
	 */
	public $reply_to_message_id;
	
	//
	//===========================
	
	/**
	 * @var BP_Company $from_company
	 */
	public $from_company;
	/**
	 * @var BP_Company $to_company
	 */
	public $to_company;
	
	
	
	/**
	 * @var string $table_name
	 */
	public static $table_name = 'private_messages';
	
	/**
	 * Class construct
	 *
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
		$this->ads_id = $id;
		$this->created = date("Y-m-d H:i:s");
	}

	/**
	 * Return array of the class
	 */
	public function to_array()
	{
		return array(
			'id' => $this->id,
		    'owner_id' => $this->owner_id,
			'from_company_id' => $this->from_company_id,
			'to_company_id' => $this->to_company_id,
			'message' => $this->message,
			'created' => $this->created,
			'is_read' => $this->is_read,
			'reply_to_msg_id' => $this->reply_to_message_id,
		);
	}
}