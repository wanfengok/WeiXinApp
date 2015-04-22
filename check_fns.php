<?php
	require_once('constaints.php');
	require_once('httputils.php');
	require_once('constaints.php');

	/**
	 * [校验传入的参数]
	 * @param  [array] $params [参数数组]
	 * @return [boolean]         [description]
	 */
	function valid_req($params){
		foreach ($params as $key => $value) {
			if(!isset($key) || $value==''){
				return false;
			}
		}
		return true;
	}

	/**
	 * [计算参数的校验和]
	 * @param  [type] $signature [description]
	 * @param  [type] $timestamp [description]
	 * @param  [type] $nonce     [description]
	 * @return [type]            [description]
	 */
	function check_signature($signature, $timestamp, $nonce){
		if(isset($signature) && isset($timestamp) && isset($nonce)){
			$params = array(TOKEN,$timestamp,$nonce);
			sort($params,SORT_STRING);
			$result = implode($params);
			$enc_result = sha1($result);

			if($signature === $enc_result){
				return true;
			}else
			{
				return false;
			}
		}else{
			return false;
		}
	}

	define("ACCESS_TOKEN",'./accesstoken.txt');

	/**
	 * [获取access_token]
	 * @return [string] [access_token的字符串]
	 */
	function get_access_token(){
		if(file_exists(ACCESS_TOKEN)&&filesize(ACCESS_TOKEN)>0){
			$fp = fopen(ACCESS_TOKEN,'r');
			$access_token = fgets($fp,888);
			fclose($fp);
			return $access_token;
		}else{
			$url  = sprintf(ACCESS_TOKEN_URL, TEST_APPID,TEST_APPSECRET);
			file_put_contents('log.txt',$url,FILE_APPEND);
			$httputil = new HttpComponent($url);
			$httputil->createCurl();
			$content = $httputil;
			$result = json_decode($content);
			if(is_object($result)){
				$fp = fopen(ACCESS_TOKEN,'w');
				$access_token = $result->access_token;
				fwrite($fp, $access_token);
				fclose($fp);
				return $access_token;
			}
		}
		
	}

?>