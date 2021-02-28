<?php

require_once( __DIR__ . '/phpQuery/phpQuery.php' );
mb_internal_encoding('UTF-8');

class YouKu
{
	public $url;
	
	function __construct( $url ) {
		$this->url = $url;
	}


	function getEmbeddedFlash()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$html = curl_exec($ch);
		phpQuery::newDocument( $html );
		$elem = pq('#link3'); 
		$html = $elem->val();
		return $html;
	}
}



?>
