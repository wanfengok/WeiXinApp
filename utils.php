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
        $httpComp->setContentType("application/json");
		$httpComp->send_request();
		return $httpComp->getHttpResult();
	}

	function GetServerIpList(){
		$url = sprintf(IP_LIST_URL,get_access_token());
		$httpComp = new HttpComponent($url);
		$httpComp->send_request();
		return $httpComp->getHttpResult();
	}

    function UploadMedia(){
        $url = sprintf(UPLOAD_MEDIA_URL,get_access_token());
    }

	echo 'access_token:';
	echo get_access_token()."<br/><hr><br/>";
	
	$result = GetServerIpList();
	echo 'iplist:<br/>';
	echo $result;
	echo "<br/><hr><br/>";
	file_put_contents('log.txt',$result,FILE_APPEND);

	if(isset($_GET['long_url'])){
		$result = Long2ShortUrl($_GET['long_url']);
		file_put_contents('log.txt',$result,FILE_APPEND);
		echo $result;
	}
?>