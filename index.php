<?php
	require_once('check_fns.php');
	require_once('header.php');
	require_once('message.php');

	function doGet(){
		if(!valid_req($_GET)||count($_GET)==0){
			echo '请输入校验参数';
			exit;
		}else{
			if(check_signature($_GET['signature'],$_GET['timestamp'],$_GET['nonce'])){
				echo $_GET['echostr'];
				exit;
			}else{
				exit;
			}
		}
	}

	function doPost(){
		$xml_str= file_get_contents("php://input"); 
		$xml_doc = simplexml_load_string($xml_str);
		switch ($xml_doc->MsgType) {
			case 'event':
				switch (strtolower($xml_doc->Event)) {
					case 'subscribe':	//订阅消息
					    $textMessage = new TextMessage();
					    $textMessage->setToUserName($xml_doc->FromUserName);
					    $textMessage->setFromUserName($xml_doc->ToUserName);
					    $textMessage->setCreateTime($xml_doc->CreateTime);
					    $textMessage->setMsgType('text');
					    $textMessage->setContent('你好，欢迎订阅');
						file_put_contents('log.txt',$textMessage->toXml(),FILE_APPEND);
						file_put_contents('php://output',$textMessage->toXml());
                        break;
					case 'unsubscribe':	//取消关注
						file_put_contents('log.txt',"unsubscribe\n",FILE_APPEND);
						break;
					case 'scan':	//扫一扫
						
						break;
					case 'location':	//上报地理位置推送功能
						break;
					case 'click':	//菜单点击事件
						file_put_contents('log.txt',"click view\n",FILE_APPEND);
						break;
					case 'view':
						file_put_contents('log.txt',"menu view\n",FILE_APPEND);
						break;
					default:
						# code...
						break;
				}	
				break;
			case 'text':	//文本消息
				file_put_contents('log.txt',"text message\n",FILE_APPEND);
                $content = $xml_doc->Content;
                if(isset($content)){
                    if(strstr($content,'音乐')){
                        $musicMessage = new MusicMessage();
                        $musicMessage->setToUserName($xml_doc->FromUserName);
                        $musicMessage->setFromUserName($xml_doc->ToUserName);
                        $musicMessage->setCreateTime($xml_doc->CreateTime);
                        $musicMessage->setMusicTitle("测试");
                        $musicMessage->setMusicDesc("一段测试的音乐");
                        $musicMessage->setMusicUrl("http://weixin.filmtin.com/Trouble.mp3");
                        $musicMessage->setMusicHQMusicUrl("http://weixin.filmtin.com/Trouble.mp3");
                        $musicMessage->setMusicThumbMediaId("dSiIq1Bq6m0hCWj4Qvr93v2FuKDS-QbNlYx4EataxEsLBK7O967vFQF1LtLcYOnq");
                        file_put_contents('php://output',$musicMessage->toXml());
                    }elseif(strstr($content,'图片')){
                        $imageMessage = new ImageMessage();
                        $imageMessage->setToUserName($xml_doc->FromUserName);
                        $imageMessage->setFromUserName($xml_doc->ToUserName);
                        $imageMessage->setCreateTime($xml_doc->CreateTime);
                        //media_id=>"3pg55ETC9uJmXYnCetpIJJ6s0dyAhyUQzNmqbPFxd_LOLlQcRATidOUYzVIHKL3Z"
                        $imageMessage->setMediaId("3pg55ETC9uJmXYnCetpIJJ6s0dyAhyUQzNmqbPFxd_LOLlQcRATidOUYzVIHKL3Z");
                        file_put_contents('php://output',$imageMessage->toXml());
                        file_put_contents('log.txt',$imageMessage->toXml(),FILE_APPEND);
                    }elseif(strstr($content,"图文")){

                    }
                }
				break;
			case 'image':	//图片消息
                $imageMessage = new ImageMessage();
                $imageMessage->setToUserName($xml_doc->FromUserName);
                $imageMessage->setFromUserName($xml_doc->ToUserName);
                $imageMessage->setCreateTime($xml_doc->CreateTime);
                //media_id=>"3pg55ETC9uJmXYnCetpIJJ6s0dyAhyUQzNmqbPFxd_LOLlQcRATidOUYzVIHKL3Z"
                $imageMessage->setMediaId($xml_doc->MediaId);
                file_put_contents('php://output',$imageMessage->toXml());
                file_put_contents('log.txt',$imageMessage->toXml(),FILE_APPEND);
				break;
			case 'voice':	//语音消息
                $voiceMessage = new VoiceMessage();
                $voiceMessage->setToUserName($xml_doc->FromUserName);
                $voiceMessage->setFromUserName($xml_doc->ToUserName);
                $voiceMessage->setCreateTime($xml_doc->CreateTime);
                //media_id=>"3pg55ETC9uJmXYnCetpIJJ6s0dyAhyUQzNmqbPFxd_LOLlQcRATidOUYzVIHKL3Z"
                $voiceMessage->setMediaId($xml_doc->MediaId);
                file_put_contents('php://output',$voiceMessage->toXml());
                file_put_contents('log.txt',$voiceMessage->toXml(),FILE_APPEND);
				break;
			case 'video':	//视频
				file_put_contents('log.txt',"video message\n",FILE_APPEND);
				break;
			case 'shortvideo':	//小视频
				file_put_contents('log.txt',"shortvideo message\n",FILE_APPEND);
				break;
			case 'location':	//地理位置消息
				file_put_contents('log.txt',"location message\n",FILE_APPEND);
				break;
			case 'link':	//链接消息
				file_put_contents('log.txt',"link message\n",FILE_APPEND);
				break;
			default:
				break;
		}
	}

	switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
		case 'POST':
			doPost();
			break;
		case 'GET':
			doGet();
			break;
		default:
			break;
	}

?>