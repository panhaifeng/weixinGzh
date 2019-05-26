<?php
FLEA::loadClass('TMIS_ControllerApp');
class Controller_App_Weixin extends TMIS_ControllerApp {

    // /构造函数
    function __construct() {
        //微信配置
        include "Config/config.wx.php";
        $wxconfig = $_WXConfig['Basics'];
        $this->appID= $wxconfig['appID'];
        $this->appsecret= $wxconfig['appsecret'];
        $this->token= $wxconfig['token'];

        //插件实例化
        FLEA::org('Weixin/Base.php');
        $this->baseWx = new Weixin_Base($this->token);
    }

    //验证token
    function actionValid(){
        $this->baseWx->valid();
    }

    //html weixin js 相关配置
    function getSignPackage(){
        FLEA::org('Weixin/JSSDK.php');
        $jssdk = new Weixin_JSSDK($this->appID,$this->appsecret);
        $signPackage = $jssdk->getSignPackage();
        return $signPackage;
    }

    //获取授权code
    function initCode($url = ''){
        //判断是否为微信打开
        $fromWechat = $this->from_weixin();
        if($fromWechat == false){
            $this->printHtml();
            die();
        }else{
            if($url){
                //获取授权地址并跳转获取code
                $this->baseWx->get_code($this->appID,$url);
            }
        }
    }

    //打印微信打开链接提示
    function printHtml(){
        echo '
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    </head>
    <body>
        <script type="text/javascript">
            document.head.innerHTML = \'<title>抱歉，出错了</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"><link rel="stylesheet" type="text/css" href="https://res.wx.qq.com/open/libs/weui/0.4.1/weui.css">\';
                document.body.innerHTML = \'<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_info weui_icon_msg"></i></div><div class="weui_text_area"><h4 class="weui_msg_title">请在微信客户端打开链接</h4></div></div>\';
        </script>
    </body>
</html>
';
    }

    //引导关注服务号
    function subscribeByCode($code ,$redirect = ''){
        //获取当前的openid
        $openid = $this->getOpenidByCode($code);

        return $this->subscribeByOpenid($openid ,$redirect);
    }

    //引导关注服务号
    function subscribeByOpenid($openid ,$redirect = ''){
        //获取token
        $access_token = $this->baseWx->get_access_token($this->appID,$this->appsecret);

        //获取对应的个人信息
        $api_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $userInfo = $this->baseWx->http_request($api_url);
        // $userInfo = json_decode($response ,true);

        //返回还是跳转新地址
        if($redirect && $userInfo['subscribe']!='1'){
            mui_alert('',"mui.alert('为了更好的体验，请先关注服务号');",$redirect,3000);
        }

        return $userInfo['subscribe'];
    }

    //通过code获取openid
    function getOpenidByCode($code){
        $openid = $this->baseWx->code2openid($this->appID ,$this->appsecret ,$code);
        $_SESSION['openid'] = $openid;
        return $openid;
    }

}

?>