<?php
require_once('constaints.php');
require_once('check_fns.php');
require_once('httputils.php');

/*
 * ������ת����
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
 * ��ȡ΢�ŷ�����IP��ַ�б�
 * */
function GetServerIpList(){
    $url = sprintf(IP_LIST_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 *  �ϴ��ļ�����
 * */
class UploadFileTypeEnum {
    const IMAGE = 'image';  //ͼƬ
    const VOICE = 'voice';  //��Ƶ
    const VIDEO = 'video';  //��Ƶ
    const THUMB = 'thumb';  //��Ҫ������Ƶ�����ָ�ʽ��������
}

/**
 *  �ϴ�����ʱ�ļ�����������Զ�ɾ��,ͼƬ��С����ޙM��֧��bmp/png/jpeg/jpg/gif��ʽ��
 *  ������С����ޙM�����Ȳ�����60�룬֧��mp3/wma/wav/amr��ʽ
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
 *  ��ȡ��ʱ�ϴ����ذ�
 */
function getUploadMedia($media_id){
    $url = sprintf(GET_UPLOAD_MEDIA_URL,get_access_token(),$media_id);
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    file_put_contents("1.jpg",$httpComp->getHttpResult());
}

/*
 *  ���������ز�
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
 *  ��������ͼ���ز�
 * */
function addLongNews(){

}

/*
 * ��ȡ�ز�����
 */
function getUploadCount(){
    $url = sprintf(GET_UPLOAD_MEDIA_COUNT,get_access_token());
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

/*
 * ��ȡ�ز��б�
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
 *  ��������
 * */
function Search(){
    $url = sprintf(SEARCH_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $data = array(
        'query'=>'��һ������ӱ������Ϻ����Ϻ���Ʊ',
        'city'=>'����',
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
 * ������ʱ��ά��
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
 * �������ö�ά��
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
 *  ��ȡ��ά��ͼƬ
 * */
function showQRCode($ticket){
    $url = sprintf(SHOW_QRCODE_URL,$ticket);
    $httpComp = new HttpComponent($url);
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}


//*********************  ����  ***************************************************************************
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