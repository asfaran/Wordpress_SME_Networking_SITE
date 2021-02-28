<?php
/**
 * classs BP_Node
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Node
{
	/**
	 * @var int $id
	 */
	public $id;
	
	/**
	 * @var string $title
	 */
	public $title;
	
	/**
	 * @var int $company_id
	 */
	public $company_id;
	
	/**
	 * @var string $created
	 */
	public $created;
	
	/**
	 * @var bool $active
	 */
	public $active;	

	/**
	 * @var string $body
	 */
	public $body;

	/**
	 * @var string $node_type;
	 */
	public $node_type;


	/**
	 * @var string $table_name
	 */
	public static $table_name = 'nodes';

	const NODE_TYPE_POST = 'NODE_TYPE_POST';
	const NODE_TYPE_RESOURCE = 'NODE_TYPE_RESOURCE';
	const NODE_TYPE_DOWNLOAD = 'NODE_TYPE_DOWNLOAD';

	// ==============

	/**
	 * @var array BP_File $attachments
	 */
	public $attachments;
	
	/**
	 * @var array BP_NodeCategory $categories Categories
	 */
	public $categories;
	
	/**
	 * @var BP_Company $company
	 */
	public $company;
	
	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
		$this->id = $id;		
		$this->active = 0;
		$this->attachments = array();
		$this->created = date("Y-m-d H:i:s");
		$this->categories = array();
	}

	/**
	 * Return array of class
	 */
	public function to_array()
	{
		return array(
			'id' => $this->id,
			'title' => $this->title,
			'company_id' => $this->company_id,
			'created' => $this->created,
			'active' => $this->active,
			'body' => $this->body,
			'node_type' => $this->node_type,
		);
	}
	
	public function add_attachment(BP_File $file)
	{
	    $this->attachments[] = $file;
	}
	
	public function add_categories(BP_NodeCategory $category)
	{
	    $this->categories[]  = $category;
	}
}