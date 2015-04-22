<?php
	require_once('constaints.php');
	require_once('check_fns.php');
	require_once('httputils.php');

	function Long2ShortUrl($req_url){
		$url = sprintf(LONG2SHORT,get_access_token());
		file_put_contents("log.txt",$url,FILE_APPEND);
		$httpComp = new HttpComponent($url);
		$postValue = json_encode(array('action'=>'long2short','long_url'=>$req_url));
		$httpComp->setPost($postValue,TRUE);
		$httpComp->createCurl();
		return $httpComp;
	}
	
	if($_GET['long_url']){
		$result = Long2ShortUrl($_GET['long_url']);
		file_put_contents('log.txt',$result,FILE_APPEND);
		echo $result;
	}
?>