<?php

class Instagram{

	var $userInfo;
	function __construct($username, $max_id=''){
		$this->userInfo  = $this->getUserPhotos($username, $max_id);
	}

	function getUserPhotos($username, $max_id=""){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$url = "https://www.instagram.com/$username/media/";
		if($max_id){
			$url .= '?max_id='.$max_id;
		}
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = curl_exec($curl);
		curl_close($curl);
		//print_r($response); exit;
		return $response;
	}

}

?>