<?php
	define('TOKEN','carketest');
	define('TEST_APPID','*****');
	define('TEST_APPSECRET','*******');

	//获取access_token的方法
	define('ACCESS_TOKEN_URL','https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s');
	//获取服务器IP地址，可以用于验证
	define('IP_LIST_URL','https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=%s');
	//长连接转短链接
	define('LONG2SHORT','https://api.weixin.qq.com/cgi-bin/shorturl?access_token=%s');
    //上传临时素材文件
    define('UPLOAD_MEDIA_URL','https://api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s');
    //获取临时素材
    define('GET_UPLOAD_MEDIA_URL','https://api.weixin.qq.com/cgi-bin/media/get?access_token=%s&media_id=%s');
    //上传永久素材文件
    define('ADD_MATERIAL_URL','http://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s');
    //获取永久素材文件
    define('GET_MATERIAL_URL','https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=%s');
    //删除永久素材
    define('DEL_MATERIAL_URL','https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=%s');
    //修改永久素材
    define('','https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=%s');
    //获取素材数量
    define('GET_UPLOAD_MEDIA_COUNT','https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=%s');
	//获取素材列表
    define('GET_UPLOAD_MEDIA_LIST','https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=%s');


    //修改公众号所属行业id
    define('SET_INDUSTRY_URL','https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=%s');
    //获取行业模板
    define('GET_TEMPLATE_ID','https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=%s');
    //发送模板消息
    define('SEND_TEMPLATE_URL','https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s');

    //生成二维码
    define('QRCODE_URL','https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s');
    //展示二维码图片
    define('SHOW_QRCODE_URL','https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=%s');

    //语义理解请求
    define('SEARCH_URL','https://api.weixin.qq.com/semantic/semproxy/search?access_token=%s');
?>
