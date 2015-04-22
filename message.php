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

		public function setMusicTitle($musicTitle){
			$this->_musicTitle = $musicTitle;
		}
		public function getMusicTitle(){
			return $this->_musicTitle;
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
	}

	class ArticleMessage extends BaseMessage{
		private $_articleCount;
		private $_articles = array();
	}
?>