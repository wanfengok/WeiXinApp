<?php
	class  HttpComponent{
		protected $_useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36';
		
		protected $_url; 
		//超时设置
		protected $_timeout;
		//cookie文件地址
		protected $_cookieFileLocation = './cookie.txt'; 

		//是否为post请求
		protected $_post;
		//post请求的字段 
 		protected $_postFields; 

 		//是否返回header
		protected $_includeHeader; 
		//是否返回body
		protected $_noBody; 
		//返回状态码
		protected $_header; 
 		//返回页面内容
 		protected $_webpage; 
 		//是否发送的是json数据
 		protected $_json;
 		//是否以二进制进行传输
     		protected $_binaryTransfer; 
     		public    $authentication = 0; 
		public    $auth_name      = ''; 
		public    $auth_pass      = ''; 

		public function __construct($url,$timeOut = 30,$binaryTransfer = false,$includeHeader = false,$noBody = false){
			$this->_url = $url;
			$this->_timeout = $timeOut;
			$this->_binaryTransfer = $binaryTransfer;
			$this->_includeHeader = $includeHeader;
			$this->_noBody = $noBody;
		}

		public function useAuth($use){ 
		       	$this->authentication = 0; 
		       	if($use == true) $this->authentication = 1; 
		} 

		public function setName($name){ 
		       	$this->auth_name = $name; 
		} 

		public function setPass($pass){ 
		       	$this->auth_pass = $pass; 
		} 

		public function setCookiFileLocation($path) 
		{ 
		         	$this->_cookieFileLocation = $path; 
		} 

		public function setPost ($postFields,$json=false) 
		{ 
			$this->_post = true; 
			$this->_postFields = $postFields; 
			$this->_json = $json;
		} 

		public function setUserAgent($userAgent) 
		{ 
		         	$this->_useragent = $userAgent; 
		} 

		public function createCurl($url = 'nul') 
		{ 
			if($url != 'nul'){ 
          				$this->_url = $url; 
		        	} 

		         	$s = curl_init(); 

		         	curl_setopt($s,CURLOPT_URL,$this->_url); 
		         	curl_setopt($s,CURLOPT_HTTPHEADER,array('Expect:')); 
		         	curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout); 
		         	curl_setopt($s,CURLOPT_RETURNTRANSFER,true); 
		         	curl_setopt($s,CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($s,CURLOPT_SSL_VERIFYHOST, FALSE);
		         	curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation); 
		         	curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation); 

		         	if($this->authentication == 1){ 
		         		echo 'auth<br/>';
		           		curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass); 
		         	}

		         	file_put_contents("log.txt",$this->_post,FILE_APPEND);
		         	if($this->_post) 
		         	{ 
		         		echo '<br/>post<br/>';
		             	curl_setopt($s,CURLOPT_POST,true); 
		             	curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields); 
		             	if($this->_json){
		         			curl_setopt($s,CURLOPT_HTTPHEADER,array('Content-Type:application/json;encoding=utf-8','Content-Length: ' . strlen($this->_postFields)));
		         			//echo $this->_postFields;
		         		}
		         	} 

		         	if($this->_includeHeader) 
		         	{ 
		         		echo 'header<br/>';
		         		curl_setopt($s,CURLOPT_HEADER,true);
		         		echo $this->_json;
		         	} 

		         	if($this->_noBody) 
		         	{ 
		         		echo 'body<br/>';
		             	curl_setopt($s,CURLOPT_NOBODY,true); 
		         	} 

		         	if($this->_binaryTransfer) 
		         	{ 
		         		echo 'binary<br/>';
		             	curl_setopt($s,CURLOPT_BINARYTRANSFER,true); 
		         	} 

		         	curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent); 

		         	$this->_webpage = curl_exec($s); 
		         	$this->_header = curl_getinfo($s); 
		         	curl_close($s); 
		} 

		public function getHttpHeader() 
		{ 
			return $this->_header; 
		} 

		public function __tostring(){ 
			return $this->_webpage; 
		} 
	}

	/**
	 * @param  [string] $url  http请求地址,不能为https请求
	 * @return [string] 返回文本
	 */
	function http_get_req($url){
		$html = file_get_contents($url);
		return $html;
	}

	/**
	 * @param  [string] $url http请求地址，不能为https请求
	 * @param  [array] $post_data 请求的参数数组
	 * @return [string]
	 */
	function http_post_req($url,$post_data){
		$post_data = http_build_query($post_data);
		$options = array(
			'http'=> array(
				'method'=>'POST',
				'header' =>'Content-type:application/x-www-form-urlencode',
				'content'=>$post_data,
				'timeout'=>15*60
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url,false,$context);
		return $result;
	}

	function https_post_req($url){
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36');
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
		curl_close($curl);
		return $data;
	}


	function test(){
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx911a7106428aedd1&secret=3ab0dee3c87c2368ad89c57abdcac04d';
		$url1 = "http://www.baidu.com";
		/*
		$content = http_post_req($url1,array('test'=>1));
		echo $content;
		$result = json_decode($content);
		echo $result->access_token;
		*/
		$httpobj = new HttpComponent($url);
		echo 'test<br/>';
		echo $httpobj->createCurl();

		echo https_post_req($url);
	}

	//test();
	
?>