<?php
	define('TOKEN','carketest');
	define('MAIN_APPID','wx6ac360c863090a23');
	define('TEST_APPID','wx911a7106428aedd1');
	define('MAIN_APPSECRET','77abb8825f9ce11c6c96785ec6d706a5');
	define('TEST_APPSECRET','3ab0dee3c87c2368ad89c57abdcac04d');

	//获取access_token的方法
	define('ACCESS_TOKEN_URL','https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s');
	//获取服务器IP地址，可以用于验证
	define('IP_LIST_URL','https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=%s');
	//长连接转短链接
	define('LONG2SHORT','https://api.weixin.qq.com/cgi-bin/shorturl?access_token=%s');
    //上传临时素材文件
    define('UPLOAD_MEDIA_URL','https://api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s');
    //上传永久素材文件
    define('ADD_MATERIAL_URL','http://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s');
	
?>
