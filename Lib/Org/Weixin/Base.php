<?php
class Weixin_Base {
    private $token;

    public function __construct($token) {
        $this->token = $token;
    }
            /**
     * weixin验证url
     * Time：2015/12/24 16:56:18
     * @author zhangyan
     * @param 参数类型
     * @return 返回值类型  http://lnx.eqinfo.com.cn/openWx.php/WXApp/valid
    */
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($echoStr){
            if($this->checkSignature()){ //调用验证字段
                echo $echoStr;
                exit;
            }
        }else{
                $this->responseMsgNew();
        }
        
    }

    private function checkSignature()
    {
        if (!$this->token) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $tmpArr = array($this->token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
        //回复消息

    public function responseMsgNew()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            //用户发送的消息类型判断
            switch ($RX_TYPE)
            {
                case "text":    //文本消息
                    $result = $this->receiveText($postObj);
                    break;
                case "image":   //图片消息
                    $result = $this->receiveImage($postObj);
                    break;

                case "voice":   //语音消息
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":   //视频消息
                    $result = $this->receiveVideo($postObj);
                    break;
                case "location"://位置消息
                    $result = $this->receiveLocation($postObj);
                    break;
                case "link":    //链接消息
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    /*
     * 接收文本消息
     */
    private function receiveText($object)
    {   if($object->Content=='我是陈斌'){
           $content = "陈老比你好";
        }elseif($object->Content=='海哥最帅'){
           $this->init();
	    }elseif($object->Content=='海哥再见'){
           $this->DelInit();
        }else{
           $content = "你发送的是文本，内容为：".$object->Content;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收图片消息
     */
    private function receiveImage($object)
    {
        $content = "你发送的是图片，地址为：".$object->PicUrl;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收语音消息
     */
    private function receiveVoice($object)
    {
        $content = "你发送的是语音，媒体ID为：".$object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收视频消息
     */
    private function receiveVideo($object)
    {
        $content = "你发送的是视频，媒体ID为：".$object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收位置消息
     */
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收链接消息
     */
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 回复文本消息
     */
    private function transmitText($object, $content)
    {
        $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content></xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    /**
     * weixin验证url
     * Time：2015/12/24 16:56:18
     *by  pan
     */
    public function init(){
        //判断操作
        // if($_GET['huanledui_wechat'] != 'huanledui_wechat'){
        //     echo "你好，你访问的地址无法正常运行！";exit;
        // }
        

        // 定义菜单信息
        $menu = [
            'button'=>[
               [
                    'type'=>'view',
                    'name'=>'海哥',
                    'url'=>"http://changzhouhaige.cn/haige.html",
                ],
           
                [
                     'type'=>'view',
                     'name'=>'百度',
                     'url'=>"http://www.baidu.com",
                ]
            ]
        ];

        $access_token = $this->get_access_token();

        $url_target = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        // echo json_encode($menu,JSON_UNESCAPED_UNICODE);exit;
        $result = $this->http_request($url_target ,json_encode($menu,JSON_UNESCAPED_UNICODE),10,false);

        echo $result;
    }

        /**
     * ps ：获取access_token
     * Time：2015/12/18 12:32:44
     * @author zhangyan
     * @param 参数类型
     * @return 返回值类型
    */
    function get_access_token(){
        $this->appID="wxf8218e9a6a3ad736";
        $this->appsecret="e3c87123fca2308939e0b76a83b7a3fc";
        // session_start();

        // $_file_session = 'weixin_eqinfo.txt';
        // $_txt_session = unserialize(file_get_contents($_file_session));

        // dump($_txt_session);exit;
        if($_SESSION['wxUser']['wx_access_token'] && time() <= $_SESSION['wxUser']['wx_access_token_time']) {
            return $_SESSION['wxUser']['wx_access_token'];
        } else {
            //获取access_token
            $url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appID.'&secret='.$this->appsecret;

            $access = $this->http_request($url_get);

            //放入session
            $_SESSION['wxUser']['wx_access_token'] = $access['access_token'];
            $_SESSION['wxUser']['wx_access_token_time'] = time() + $access['expires_in'];

            //放到缓存中
            // file_put_contents($_file_session, serialize(['wx_access_token'=>$_SESSION['wxUser']['wx_access_token'],'wx_access_token_time'=>$_SESSION['wxUser']['wx_access_token_time']]));

            // dump($access);exit;
            return $access['access_token'];
        }
    }

    
     
    /**
     * @Desc:
     * @author:guomin
     * @date:
     * @param $url
     * @param array $fields
     * @return string
     */
    private function curl($url,$fields=[]){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        if($fields){
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
        }
        if(curl_exec($ch)){
            $data=curl_multi_getcontent($ch);
        }
        curl_close($ch);
        return $data;
    } 
    /**
     * 访问
     * Time：2015/12/29 15:24:08
     * @author li
     * @param 参数类型
     * @return 返回值类型
    */
    public function http_request($url ,$data=null ,$timeout=5 ,$decode=true){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $output = curl_exec($ch);
        curl_close($ch);

        $decode && $output = json_decode( $output, true );

        return $output;
    }
         /**
     * @Desc:删除菜单
     * @author:guomin
     * @date:2017-11-01 23:17
     */
    public function DelInit(){
        $access=$this->get_access_token();
        $url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access;
        $result=$this->curl($url);
        //$result = $this->http_request($url,json_encode('',JSON_UNESCAPED_UNICODE),10,false);
        //print_r($result);
    }   
}
