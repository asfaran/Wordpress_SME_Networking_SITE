<?php
/**
 * classs BP_Score
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Score
{
	/**
	 * @var int $company_id
	 */
	public $company_id;
	/**
	 * @var int $score
	 */
	public $scores;	

	const SCORE_DIFFERENT_CATEGORY 	= 'score_different_category';
	const SCORE_POSTING_RESOURCE 	= 'score_posting_resource';
	const SCORE_CREATING_POST 		= 'score_creating_post';
	const SCORE_LOGIN 				= 'score_login';
	const SCORE_POSTING_DOWNLOADS 	= 'score_posting_downloads';
	
	//
	// ===============
	
	/**
	 * @var BP_Company $company
	 */
	public $company;
	
	
	/**
	 * @var string $table_name
	 */
	public static $table_name = 'scores';
	
	/**
	 * Class construct
	 *
	 * @param int $c_id
	 * @param int $scores
	 */
	public function __construct($c_id = 0, $scores = 0)
	{
		$this->company_id = $c_id;
		$this->scores = $scores;
	}

	public function to_array()
	{
		return array(
			'company_id' => $this->company_id,
			'scores' => $this->scores,
		);
	}

	/**
	 * Adds the score to the object
	 * @param int $score
	 */
	public function add_score($score)
	{
		$this->scores += (int)$score;
	}
}