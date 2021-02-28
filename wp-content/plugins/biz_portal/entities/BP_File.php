<?php
/**
 * classs BP_File
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_File
{
	/**
	 * @var int $id
	 */
	public $id;

	/**
	 * @var int $path
	 */
	public $path;

	/**
	 * @var string $mime_type
	 */
	public $mime_type;

	/**
	 * @var int $size;
	 */
	public $size_bytes;

	/**
	 * @var string $extension
	 */
	public $extension;

	/**
	 * @var int $is_image
	 */
	public $is_image;
	
	/**
	 * 
	 * @var int $usage
	 */
	public $file_usage;
	
	/**
	 * @var int $uid User who upload the image
	 */
	public $uid;


	/**
	 * @var string $table_name
	 */
	public static $table_name = 'files_t';

	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
		$this->id = $id;		
		$this->size_bytes = 0;
		$this->is_image = 0;
		$this->file_usage = 0;
		$this->uid = 0;
	}

	/**
	 * Return as array
	 * @return array
	 */
	public function to_array()
	{
		return array(
			'id' => $this->id,
			'path' => $this->path,
			'mime_type' => $this->mime_type,
			'size_bytes' => $this->size_bytes,
			'extension' => $this->extension,
			'is_image' => $this->is_image,
		    'file_usage'    => $this->file_usage,
		    'uid'        => $this->uid,
		);
	}
}