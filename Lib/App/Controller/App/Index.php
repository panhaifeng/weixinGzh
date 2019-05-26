<?php
FLEA::loadClass('TMIS_ControllerApp');
class Controller_App_Index extends TMIS_ControllerApp {

    // /构造函数
    function __construct() {
        // $this->_modelExample = FLEA::getSingleton('Model_Jichu_Exhibition');
    }


    /**
     * 手机端首页
     * Time：2018/07/24 13:35:58
     * @author li
    */
    function actionIndex(){
        $this->authCheck(0);

        //判断是否为微信登录
        $fromWx = $this->from_weixin();
        /*if(!$fromWx){
            $weixin = FLEA::getSingleton('Controller_App_Weixin');
            $weixin->printHtml();
            die();
        }*/

        //把最新域名写入缓存
        $http = $_SERVER['REQUEST_SCHEME'] ? $_SERVER['REQUEST_SCHEME'] : 'http';
        $urlBase = $http.'://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/')+1);
        FLEA::writeCache('SERVER.DOMAIN.URL',$urlBase);

        // redirect(url('Chanliang_Weixin_InputRs','Index'));
        //跳转首页的内容
        $this->initHome();
    }

    /**
     * 首页的信息展示
     * Time：2018/07/24 15:11:43
     * @author li
    */
    function initHome(){
        //获取是什么平台
        FLEA::loadClass('TMIS_Common');
        $type = TMIS_Common::getMobileType();

        $menu = $this->getMenu();

        //微信的相关配置
        $weixin = FLEA::getSingleton('Controller_App_Weixin');
        $signPackage = $weixin->getSignPackage();

        $smarty = & $this->_getView();
        $smarty->assign('title','控制台');
        $smarty->assign('mobileType',$type);
        $smarty->assign('signPackage',$signPackage);
        $smarty->assign('menu',$menu);
        $smarty->display('h5/Index/Index.tpl');
    }

    /**
     * 识别关注服务号
     * Time：2018/07/24 15:11:43
     * @author li
    */
    function actionSubscribe(){
        $sys = $this->getSysSet();
        $qrcodePath = $sys['qrocde_mp_weixin'];

        $smarty = & $this->_getView();
        $smarty->assign('title','关注公众号');
        $smarty->assign('qrcodePath',$qrcodePath);
        $smarty->display('h5/Index/Subscribe.tpl');
    }

    /**
     * 上传名片
     * Time：2018/07/24 17:32:05
     * @author li
    */
    function actionUploadCard(){

    }

    function getMenu(){
        $f = &FLEA::getAppInf('menu_wxapp');
        include $f;

        $ret =  $_sysMenu;
        return $ret;
    }

}

?>