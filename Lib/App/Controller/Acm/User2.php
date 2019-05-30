<?php
FLEA::loadClass('TMIS_ControllerApp');
class Controller_Acm_User2 extends TMIS_ControllerApp {
     //获取用户微信昵称和头像
     public function actionIndex(){
        FLEA::loadClass('TMIS_Pager');
        $appID="wx0b8dcc4597275531";
        $appsecret="2d82c01531b3263b585a1023b4d5c92b";
        $code = $_GET["code"];
        $appID=APPID;
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appID&secret=$appsecret&code=$code&grant_type=authorization_code";
        $token_info = http_request($token_url);

        //根据openid和access_token查询用户信息 
        $access_token = $token_info['access_token']; 
        $openid = $token_info['openid'];

        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN"; 
        $user_info = http_request($userinfo_url);
        //先获取openId
        //基础信息获取
        dump2file($openid);
        //获取微信用户的基础信息
        $info = $this->get_user_detail($openId);
        dump2file($info);
        $smarty = & $this->_getView();
        $smarty->assign('info', $info);
        $smarty->display('Acm/UserInfo.tpl');

     }


    /**
     * ps ：再使用全局ACCESS_TOKEN获取OpenID的详细信息
     * Time：2015/12/18 12:32:56
     * @author zhangyan
     * @param 参数类型
     * @return 返回值类型
    */
    function get_user_detail($openId){
        $access_token = $this->get_access_token();
        //获取access_token
        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openId.'&lang=zh_CN';
        // echo $url;exit;

        $userinfo = $this->http_request($url);

        return $userinfo;
    }

        /**
     * ps ：获取access_token
     * Time：2015/12/18 12:32:44
     * @author zhangyan
     * @param 参数类型
     * @return 返回值类型
    */
    function get_access_token(){
        $this->appID="wx0b8dcc4597275531";
        $this->appsecret="2d82c01531b3263b585a1023b4d5c92b";
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

}

?>
