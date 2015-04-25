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


    class TypeEnum {
        const IMAGE = 'image';  //图片
        const VOICE = 'voice';  //音频
        const VIDEO = 'video';  //视频
        const THUMB = 'thumb';  //主要用于视频与音乐格式的缩略图
    }

    /**
     *  上传的临时文件，服务器3天后自动删除,图片大小不超过2M，支持bmp/png/jpeg/jpg/gif格式，
     *  语音大小不超过5M，长度不超过60秒，支持mp3/wma/wav/amr格式
     */
    function UploadMedia($filepath,$type){
        $url = sprintf(UPLOAD_MEDIA_URL,get_access_token(),$type);
        echo $url."<br />";
        $httpComp = new HttpComponent($url);
        $httpComp->setContentType('multipart/form-data');
        if (class_exists('\CURLFile')) {
            $data = array('media' => new \CURLFile(realpath($filepath)));
        } else {
            $data = array('media' => '@' . realpath($filepath));
        }
        $httpComp->setPost($data);
        $httpComp->send_request();
        return $httpComp->getHttpResult();
    }

    /**
     *  获取临时上传的素材
     */
    function getUploadMedia($media_id){
        $url = sprintf(GET_UPLOAD_MEDIA_URL,get_access_token(),$media_id);
        $httpComp = new HttpComponent($url);
        $httpComp->send_request();
        file_put_contents("1.jpg",$httpComp->getHttpResult());
    }

    function addMaterial(){

    }

    /*
     * 获取素材总数
     */
    function getUpalodCount(){
        $url = sprintf(GET_UPLOAD_MEDIA_COUNT,get_access_token());
        $httpComp = new HttpComponent($url);
        $httpComp->send_request();
        return $httpComp->getHttpResult();
    }

    /*
     * 获取素材列表
    */
    function getUploadList(){
        $url = sprintf(GET_UPLOAD_MEDIA_LIST,get_access_token());
        $httpComp = new HttpComponent($url);
        $params = array('type'=>TypeEnum::IMAGE,'offset'=>0,'count'=>20);
        $httpComp->setPost(json_encode($params));
        $httpComp->setContentType("application/json");
        $httpComp->send_request();
        return $httpComp->getHttpResult();
    }

    /*
     *
     * */
    function Search(){

    }

    if(isset($_GET['debug'])){
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

        $result = UploadMedia("pic.jpg",TypeEnum::IMAGE);
        echo "<br/>$result<br/>";
        $xml_result = json_decode($result);
        getUploadMedia($xml_result->media_id);
        echo "<br/><hr><br/>";
        $xml_count = getUpalodCount();
        echo $xml_count;
        echo "<br/><hr><br/>";
        $xml_count = getUploadList();
        echo $xml_count;
    }
?>