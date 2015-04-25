<?php
require_once('constaints.php');
require_once('check_fns.php');
require_once('httputils.php');

/*
 * 长链接转断链
 * */
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

/*
 * 获取微信服务器IP地址列表
 * */
function GetServerIpList(){
    $url = sprintf(IP_LIST_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 *  上传文件类型
 * */
class UploadFileTypeEnum {
    const IMAGE = 'image';  //图片
    const VOICE = 'voice';  //音频
    const VIDEO = 'video';  //视频
    const THUMB = 'thumb';  //主要用于视频与音乐格式的缩略囿
}

/**
 *  上传的临时文件，服务噿天后自动删除,图片大小不超迿M，支持bmp/png/jpeg/jpg/gif格式＿
 *  语音大小不超迿M，长度不超过60秒，支持mp3/wma/wav/amr格式
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
 *  获取临时上传的素板
 */
function getUploadMedia($media_id){
    $url = sprintf(GET_UPLOAD_MEDIA_URL,get_access_token(),$media_id);
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    file_put_contents("1.jpg",$httpComp->getHttpResult());
}

/*
 *  新增永久素材
 * */
function addMaterial($filepath,$type){
    $url = sprintf(ADD_MATERIAL_URL,get_access_token());
    $httpComp = new HttpComponent($url,120);
    $httpComp->setContentType('multipart/form-data');
    echo realpath($filepath);
    if (class_exists('\CURLFile')) {
        $data = array('media' => new \CURLFile(realpath($filepath)),'type'=>$type);
    } else {
        $data = array('media' => '@' . realpath($filepath),'type'=>$type);
    }
    $httpComp->setPost($data);
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 *  新增永久图文素材
 * */
function addLongNews(){

}

/*
 * 获取素材总数
 */
function getUploadCount(){
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
    $params = array('type'=>UploadFileTypeEnum::IMAGE,'offset'=>0,'count'=>20);
    $httpComp->setPost(json_encode($params));
    $httpComp->setContentType("application/json");
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 *  智能语义
 * */
function Search(){
    $url = sprintf(SEARCH_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $data = array(
        'query'=>'查一下明天从北京到上海的南航机票',
        'city'=>'北京',
        'category'=>'flight,hotel',
        'appid'=>TEST_APPID,
        'uid'=>'oBdXVswJMWX_S5tMPJ-V_IxJ9p50'
    );
    $httpComp->setPost(json_encode($data));
    $httpComp->setContentType("application/json");
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 * 产生临时二维码
 * */
function CreateTempQRCode(){
    $url = sprintf(QRCODE_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $params = array(
        'expire_seconds'=>604800,
        'action_name'=>'QR_SCENE',
        'action_info'=>array(
            'scene'=>array('scene_id'=>123)
        )
    );
    $httpComp->setPost(json_encode($params));
    $httpComp->setContentType("application/json");
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 * 产生永久二维码
 * */
function CreateLongQRCode(){
    $url = sprintf(QRCODE_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $params = array(
        'action_name'=>'QR_LIMIT_SCENE',
        'action_info'=>array(
            'scene'=>array('scene_id'=>123)
        )
    );
    $httpComp->setPost(json_encode($params));
    $httpComp->setContentType("application/json");
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 *  获取二维码图片
 * */
function showQRCode($ticket){
    $url = sprintf(SHOW_QRCODE_URL,$ticket);
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}


//*********************  测试  ***************************************************************************
if(isset($_GET['search'])){
    echo Search();
}

if(isset($_GET['code'])){
    $ticket = json_decode(CreateLongQRCode())->ticket;
    Header('Content-type:image/jpg');
    $im = imagecreatefromstring(showQRCode($ticket));
    imagejpeg($im);
    imagedestroy($im);
}

if(isset($_GET['long_url'])){
    $result = Long2ShortUrl($_GET['long_url']);
    file_put_contents('log.txt',$result,FILE_APPEND);
    echo $result;
}

if(isset($_GET['ip'])){
    $result = GetServerIpList();
    echo 'iplist:<br/>';
    echo $result;
    echo "<br/><hr><br/>";
    file_put_contents('log.txt',$result,FILE_APPEND);
}

if(isset($_GET['upload'])){
    $result = UploadMedia("33.png",UploadFileTypeEnum::THUMB);
    echo "<br/>$result<br/>";
    if(isset($result)){
        $xml_result = json_decode($result);
        if(isset($xml_result->media_id)){
            getUploadMedia($xml_result->media_id);
            echo "<br/><hr><br/>";
        }
        if(isset($xml_result->thumb_media_id)){
            getUploadMedia($xml_result->thumb_media_id);
            echo "<br/><hr><br/>";
        }

    }


    //$xml_count = getUploadCount();
    //echo $xml_count;
    //echo "<br/><hr><br/>";
    //$xml_count = getUploadList();
    //echo $xml_count;
}

if(isset($_GET['longupload'])){
    addMaterial('pic.jpg',UploadFileTypeEnum::THUMB);
}

if(isset($_GET['debug'])){
    echo 'access_token:';
    echo get_access_token()."<br/><hr><br/>";
}
?>