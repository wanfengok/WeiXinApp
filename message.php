<?php
	class BaseMessage{
		/*回复消息*/

		private $_toUserName;
		private $_fromUserName;
		private $_createTime;
		private $_msgType;
		private $_msgId;
		
		public function setToUserName($toUserName){
			$this->_toUserName = $toUserName;
		}

		public function getToUserName(){
			return $this->_toUserName;
		}

		public function setFromUserName($fromUserName){
			$this->_fromUserName = $fromUserName;
		}
		public function getFromUserName(){
			return $this->_fromUserName;
		}

		public function setCreateTime($createTime){
			$this->_createTime = $createTime;
		}
		public function getCreateTime(){
			return $this->_createTime;
		}

		public function setMsgType($msgType){
			$this->_msgType = $msgType;
		}
		public function getMsgType(){
			return $this->_msgType;
		}

		public function setMsgId($msgId){
			$this->_msgId = $msgId;
		}
		public function getMsgId(){
			return $this->_msgId;
		}

        public function __get($name){
            return $this->$name;
        }

        public function __set($name,$value){
            $this->$name = $value;
        }

		public function __tostring(){
			return 'from:'.$this->_fromUserName.' to:'.$this->_toUserName.',send msg type:'.$this->_msgType.'(msgid:'.$this->_msgId.') at :'.$this->_createTime;
		}

		public function toXml(){

		}
	}

	/**
	 *  文本消息
	 */
	class TextMessage extends BaseMessage{
		private $_content;

		public function __construct(){
			$this->setMsgType('text');
		}

		public function setContent($content){
			$this->_content = $content;
		}

		public function getContent(){
			return $this->_content;
		}

		public function __tostring(){
			return 'from:'.$this->getFromUserName().' to:'.$this->getToUserName().',send msg type:'.$this->getMsgType().'(msgid:'.$this->getMsgId().') at :'.$this->getCreateTime().',msg content:'.$this->getContent();
		}

		public function toXml(){
			$xml = '<xml><ToUserName><![CDATA['.$this->getToUserName().']]></ToUserName>';
			$xml.= '<FromUserName><![CDATA['.$this->getFromUserName().']]></FromUserName>';
			$xml.= '<CreateTime>'.$this->getCreateTime().'</CreateTime>';
			$xml.= '<MsgType><![CDATA['.$this->getMsgType().']]></MsgType>';
			$xml.= '<Content><![CDATA['.$this->getContent().']]></Content></xml>';
			return $xml;
		}
	}

	/**
	 * 图片消息
	 */
	class ImageMessage extends BaseMessage{
		private $_mediaId;

		public function __construct(){
			$this->setMsgType('image');
		}

		public function setMediaId($mediaId){
			$this->_mediaId = $mediaId;
		}
		public function getMediaId(){
			return $this->_mediaId;
		}

		public function __tostring(){
			return 'from:'.$this->getFromUserName().' to:'.$this->getToUserName().',send msg type:'.$this->getMsgType().'(msgid:'.$this->getMsgId().') at :'.$this->getCreateTime().',image media id:'.$this->getMediaId();
		}

		public function toXml(){
			$xml = '<xml><ToUserName><![CDATA['.$this->getToUserName().']]></ToUserName>';
			$xml.= '<FromUserName><![CDATA['.$this->getFromUserName().']]></FromUserName>';
			$xml.= '<CreateTime>'.$this->getCreateTime().'</CreateTime>';
			$xml.= '<MsgType><![CDATA['.$this->getMsgType().']]></MsgType>';
			$xml.= '<Image><MediaId><![CDATA['.$this->getMediaId().']]></MediaId></Image></xml>';
			return $xml;
		}
	} 

	/**
	 * 声音消息 
	 */
	class VoiceMessage extends BaseMessage{
		private $_voiceMediaId;

        public function __construct(){
            $this->setMsgType('voice');
        }

		public function setVoiceMediaId($voiceMediaId){
			$this->_voiceMediaId = $voiceMediaId;
		}

		public function getVoiceMediaId(){
			return $this->_voiceMediaId;
		}

		public function __tostring(){
			return 'from:'.$this->getFromUserName().' to:'.$this->getToUserName().',send msg type:'.$this->getMsgType().'(msgid:'.$this->getMsgId().') at :'.$this->getCreateTime().',voice media id:'.$this->getVoiceMediaId();
		}

		public function toXml(){
			$xml = '<xml><ToUserName><![CDATA['.$this->getToUserName().']]></ToUserName>';
			$xml.= '<FromUserName><![CDATA['.$this->getFromUserName().']]></FromUserName>';
			$xml.= '<CreateTime>'.$this->getCreateTime().'</CreateTime>';
			$xml.= '<MsgType><![CDATA['.$this->getMsgType().']]></MsgType>';
			$xml.= '<Voice><MediaId><![CDATA['.$this->getMediaId().']]></MediaId></Voice></xml>';
			return $xml;
		}
	}

	/**
	 * 视频消息
	 */
	class VideoMessage extends BaseMessage{
		private $_videoMediaId;
		private $_videoTitle;
		private $_videoDesc;

        public function __construct(){
            $this->setMsgType('video');
        }

		public function setVideoMediaId($videoMediaId){
			$this->_videoMediaId = $videoMediaId;
		}

		public function getVideoMediaId(){
			return $this->_videoMediaId;
		}

		public function setVideoMediaTitle($videoMediaTitle){
			$this->_videoTitle = $videoMediaTitle;
		}
		public function getVideoMediaTitle(){
			return $this->_videoTitle;
		}

		public function setVideoDesc($videoMediaDesc){
			$this->_videoDesc = $videoMediaDesc;
		}

		public function getVideoDesc(){
			return $this->_videoDesc;
		}
	}

	/**
	 * 音乐消息
	 */
	class MusicMessage extends BaseMessage{
		private $_musicTitle;
		private $_musicDesc;
		private $_musicUrl;
		private $_musicHQMusicUrl;
		private $_musicThumbMediaId;

        public function __construct(){
            $this->setMsgType('music');
        }

		public function setMusicTitle($musicTitle){
			$this->musicTitle = $musicTitle;
		}
		public function getMusicTitle(){
			return $this->_musicTitle;
		}

        public function setMusicDesc($value){
            $this->_musicDesc = $value;
        }

        public function getMusicDesc(){
            return $this->_musicDesc;
        }

        public function setMusicUrl($value){
            $this->_musicUrl = $value;
        }

        public function getMusicUrl(){
            return $this->_musicUrl;
        }

        public function setMusicHQMusicUrl($value){
            $this->_musicHQMusicUrl = $value;
        }

        public function getMusicHQMusicUrl(){
            return $this->_musicHQMusicUrl;
        }

        public function setMusicThumbMediaId($value){
            $this->_musicThumbMediaId = $value;
        }

        public function getMusicThumbMediaId(){
            return $this->_musicThumbMediaId;
        }

        public function toXml(){
            $xml = '<xml><ToUserName><![CDATA['.$this->getToUserName().']]></ToUserName>';
            $xml.= '<FromUserName><![CDATA['.$this->getFromUserName().']]></FromUserName>';
            $xml.= '<CreateTime>'.$this->getCreateTime().'</CreateTime>';
            $xml.= '<MsgType><![CDATA['.$this->getMsgType().']]></MsgType>';
            $xml.= '<Music><Title><![CDATA['.$this->getMusicTitle().']]></Title>';
            $xml.= '<Description><![CDATA['.$this->getMusicDesc().']]></Description>';
            $xml.= '<MusicUrl><![CDATA['.$this->getMusicUrl().']]></MusicUrl>';
            $xml.= '<HQMusicUrl><![CDATA['.$this->getMusicHQMusicUrl().']]></HQMusicUrl>';
            $xml.= '<ThumbMediaId><![CDATA['.$this->getMusicThumbMediaId().']]></ThumbMediaId>';
            $xml.= '</Music></xml>';
            return $xml;
        }

	}

	/**
	 * 图文消息
	 */
	class item{
		private $_title;
		private $_desc;
		private $_picUrl;
		private $_Url;

		public function setTitle($item_title){
			$this->_title = $item_title;
		}
		public function getTitle(){
			return $this->_title;
		}

        public function setDesc($item_desc){
            $this->_desc = $item_desc;
        }

        public function  getDesc(){
            return $this->_desc;
        }

        public function setPicUrl($item_pic_url){
            $this->_picUrl = $item_pic_url;
        }

        public function getPicUrl(){
            return $this->_picUrl;
        }

        public function setUrl($item_url){
            $this->_Url = $item_url;
        }

        public function getUrl(){
            return $this->_Url;
        }
	}

	class ArticleMessage extends BaseMessage{
		private $_articleCount;
		private $_articles = array();

        public function getArticlesCount(){
            return $this->_articleCount;
        }

        public function getArticles(){
            return $this->_articles;
        }

        public  function __constructor($articles){
            $this->setMsgType("news");
            if(is_array($articles) && count($articles)>0){
                foreach($articles as $item){
                    $this->_articles = $articles;
                }
                $this->_articleCount = count($this->_articles);
            }
        }

        public  function toXml(){
            $xml = '<xml><ToUserName><![CDATA['.$this->getToUserName().']]></ToUserName>';
            $xml.= '<FromUserName><![CDATA['.$this->getFromUserName().']]></FromUserName>';
            $xml.= '<CreateTime>'.$this->getCreateTime().'</CreateTime>';
            $xml.= '<MsgType><![CDATA['.$this->getMsgType().']]></MsgType>';
            $xml.= '<ArticleCount><![CDATA['.$this->getArticlesCount().']]></ArticleCount>';
            $xml.= '<Articles>';
            foreach($this->getArticles() as $item){
                $xml.= '<item><Title><![CDATA['.$item->getTitle().']]></Title>';
                $xml.= '<Description><![CDATA['.$item->getDesc().']]></Description>';
                $xml.= '<PicUrl><![CDATA['.$item->getPicUrl().']]></PicUrl>';
                $xml.= '<Url><![CDATA['.$item->getUrl().']]></Url>';
                $xml.= '</item>';
            }
            $xml.='</Articles></xml>';
            return $xml;
        }
	}
?>