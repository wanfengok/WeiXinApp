<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-4-25
 * Time: 下午5:55
 */

/*             行业代码

    主行业	副行业	代码
    IT科技	互联网/电子商务	1
    IT科技	IT软件与服务	    2
    IT科技	IT硬件与设备	    3
    IT科技	电子技术	       4
    IT科技	通信与运营商	   5
    IT科技	网络游戏	       6
    金融业	银行	7
    金融业	基金|理财|信托	8
    金融业	保险	9
    餐饮	餐饮	10
    酒店旅游	酒店	11
    酒店旅游	旅游	12
    运输与仓储	快递	13
    运输与仓储	物流	14
    运输与仓储	仓储	15
    教育	培训	16
    教育	院校	17
    政府与公共事业	学术科研	18
    政府与公共事业	交警	19
    政府与公共事业	博物馆	20
    政府与公共事业	公共事业|非盈利机构	21
    医药护理	医药医疗	22
    医药护理	护理美容	23
    医药护理	保健与卫生	24
    交通工具	汽车相关	25
    交通工具	摩托车相关	26
    交通工具	火车相关	27
    交通工具	飞机相关	28
    房地产	建筑	29
    房地产	物业	30
    消费品	消费品	31
    商业服务	法律	32
    商业服务	会展	33
    商业服务	中介服务	34
    商业服务	认证	35
    商业服务	审计	36
    文体娱乐	传媒	37
    文体娱乐	体育	38
    文体娱乐	娱乐休闲	39
    印刷	印刷	40
    其它	其它	41
*/

require_once('constaints.php');
require_once('check_fns.php');
require_once('httputils.php');

//每月可修改行业1次
function setIndustry($industry_id1,$industry_id2){
    $url = sprintf(SET_INDUSTRY_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $httpComp -> setContentType("application/json");
    $data = array('industry_id1'=>$industry_id1,'industry_id2'=>$industry_id2);
    $httpComp -> setPost(json_encode($data));
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

function getTmeplateId($temlate_id_short){
    $url = sprintf(GET_TEMPLATE_ID,get_access_token());
    $httpComp = new HttpComponent($url);
    $httpComp -> setContentType("application/json");
    $data = array('template_id_short'=>$temlate_id_short);
    $httpComp -> setPost(json_encode($data));
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

function sendTemplateMessage($touser,$templateid,$url){
    $url = sprintf(SEND_TEMPLATE_URL,get_access_token());
    $httpComp = new HttpComponent($url);
    $httpComp -> setContentType("application/json;charset:utf-8");
    $data = array(
        'touser'=>$touser,
        'template_id'=>$templateid,
        'url'=>$url,
        'topcolor'=>'#FF0000',
        'data'=>array(
            'first'=>array(
                'value'=>'恭喜购买成功!',
                'color'=>'#173177'
            ),
            'keynote1'=>array(
                'value'=>'巧克力',
                'color'=>'#173177'
            ),
            'keynote2'=>array(
                'value'=>'39.8元',
                'color'=>'#173177'
            ),
            'keynote3'=>array(
                'value'=>'2014年9月16日',
                'color'=>'#173177'
            ),
            'remark'=>array(
                'value'=>'欢迎再次购买',
                'color'=>'173177'
            )
        )
    );
    $httpComp -> setPost(json_encode($data));
    $httpComp->send_request();
    return $httpComp->getHttpResult();
}

$openid = 'oBdXVswJMWX_S5tMPJ-V_IxJ9p50';
$templateid = "TM00015";
$industry_id1=1;
$industry_id2=3;
$downurl = "http://weixin.qq.com/download";

if(isset($_GET["debug"])){
    echo 'test';
    setIndustry($industry_id1,$industry_id2);
    $result = getTmeplateId($templateid);
    echo $result;
    $convert_template_id = json_decode($result)->template_id;
    echo sendTemplateMessage($openid,$convert_template_id,$downurl);
}
