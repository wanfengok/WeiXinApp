<?php
	require_once('header.php');
	require_once('check_fns.php');
	require_once('httputils.php');

	class MenuUtil{
		protected $_access_token;

		public function __construct($access_token='nul'){
			if($access_token == 'nul')
				$this->_access_token = get_access_token();
			else
				$this->_access_token = $access_token;
		}

		public function createMenu($menu_array){
			$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->_access_token;
			$httputil_create = new HttpComponent($url);
			if(is_string($menu_array)){
				$httputil_create->setPost($menu_array,true);
			}elseif(is_array($menu_array)){
				$httputil_create->setPost(json_encode($menu_array),true);
			}
			$httputil_create->createCurl();
			return $httputil_create;
		}

		public function getMenu(){
			$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$this->_access_token;
			$httputil_get = new HttpComponent($url);
			$httputil_get->createCurl();
			return $httputil_get;
		}
		
		public function deleteMenu(){
			$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->_access_token;
			$httputil = new HttpComponent($url);
			$httputil->createCurl();
			return $httputil;
		}
	}

	$menu_define = array(
		'button'=>array(
			array(
				'name'=>'自定义',
				'sub_button'=>array(
					array(
						'type'=>'view',
						'name'=>'自定义1',
						'url'=>'http://weixin.filmtin.com',
						'sub_button'=>array()
					),
					array(
						'type'=>'view',
						'name'=>'自定义12',
						'url'=>'http://weixin.filmtin.com',
						'sub_button'=>array()
					),
					array(
						'type'=>'view',
						'name'=>'自定义3',
						'url'=>'http://weixin.filmtin.com',
						'sub_button'=>array()
					),
					array(
						'type'=>'view',
						'name'=>'自定义4',
						'url'=>'http://weixin.filmtin.com',
						'sub_button'=>array()
					),
					array(
						'type'=>'view',
						'name'=>'自定义5',
						'url'=>'http://weixin.filmtin.com',
						'sub_button'=>array()
					),
				)
			),
			array(
				'name'=>'按钮类型',
				'sub_button'=>array(
					array(
						'type'=>'view',
						'name'=>'搜索',
						'url'=>'http://www.soso.com/',
						'sub_button'=>array()
					),
					array(
						'type'=>'click',
						'name'=>'点击事件',
						'key'=>'V1001_TODAY_MUSIC',
						'sub_button'=>array()
					),
					array(
						'type'=>'location_select',
						'name'=>'发送位置',
						'key'=>'rselfmenu_0_0',
						'sub_button'=>array()
					)
				)
			),
			array(
				'name'=>'按钮类型',
				'sub_button'=>array(
					array(
						'type'=>'scancode_waitmsg',
						'name'=>'扫码带提示',
						'key'=>'rselfmenu_1_0',
						'sub_button'=>array()
					),
					array(
						'type'=>'scancode_push',
						'name'=>'扫码推事件',
						'key'=>'rselfmenu_1_1',
						'sub_button'=>array()
					),
					array(
						'type'=>'pic_sysphoto',
						'name'=>'系统拍照发图',
						'key'=>'rselfmenu_1_2',
						'sub_button'=>array()
					),
					array(
						'type'=>'pic_weixin',
						'name'=>'拍照或者相册发图',
						'key'=>'rselfmenu_1_3',
						'sub_button'=>array()
					),
					array(
						'type'=>'pic_photo_or_album',
						'name'=>'微信相册发图',
						'key'=>'rselfmenu_1_4',
						'sub_button'=>array()
					)
				)
			)
		)
	);

	echo json_encode($menu_define).'<br/>';
	$menu_str = '{"button": [
			        {
			            "name": "自定义", 
			            "sub_button": [
			                {
			                    "type": "view", 
			                    "name": "自定义1", 
			                    "url": "http://weixin.filmtin.com", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "view", 
			                    "name": "自定义2", 
			                    "url": "http://weixin.filmtin.com", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "view", 
			                    "name": "自定义3", 
			                    "url": "http://weixin.filmtin.com", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "view", 
			                    "name": "自定义4", 
			                    "url": "http://weixin.filmtin.com", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "view", 
			                    "name": "自定义5", 
			                    "url": "http://weixin.filmtin.com", 
			                    "sub_button": [ ]
			                }
			            ]
			        }, 
			        {
			            "name": "按钮类型", 
			            "sub_button": [
			                {
			                    "type": "view", 
			                    "name": "搜索", 
			                    "url": "http://www.soso.com/", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "click", 
			                    "name": "点击事件", 
			                    "key": "V1001_TODAY_MUSIC", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "location_select", 
			                    "name": "发送位置", 
			                    "key": "rselfmenu_0_0", 
			                    "sub_button": [ ]
			                }
			            ]
			        }, 
			        {
			            "name": "按钮类型", 
			            "sub_button": [
			                {
			                    "type": "scancode_waitmsg", 
			                    "name": "扫码带提示", 
			                    "key": "rselfmenu_1_0", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "scancode_push", 
			                    "name": "扫码推事件", 
			                    "key": "rselfmenu_1_1", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "pic_sysphoto", 
			                    "name": "系统拍照发图", 
			                    "key": "rselfmenu_1_2", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "pic_weixin", 
			                    "name": "拍照或者相册发图", 
			                    "key": "rselfmenu_1_3", 
			                    "sub_button": [ ]
			                }, 
			                {
			                    "type": "pic_photo_or_album", 
			                    "name": "微信相册发图", 
			                    "key": "rselfmenu_1_4", 
			                    "sub_button": [ ]
			                }
			            ]
			        }
			    ]
			}';

	$menu = new MenuUtil();
	//echo '<br/>'.$menu->deleteMenu();
	echo '<br/>'.$menu->createMenu($menu_str);

?>