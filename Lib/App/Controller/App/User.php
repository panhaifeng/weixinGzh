<?php
FLEA::loadClass('TMIS_ControllerApp');
class Controller_App_User extends TMIS_ControllerApp {

    // /构造函数
    function __construct() {
        $this->_modelExample = FLEA::getSingleton('Model_Jichu_Client');
    }


    /**
     * 按照管理员用户信息展示，统计公司所有新增客户数量
     * Time：2018/07/24 13:35:58
     * @author li
    */
    function actionIndex(){
        $this->authCheck(0);
        //获取对应的数据
        $data = $this->_getListData();

        $smarty = & $this->_getView();
        $smarty->assign('title','个人中心');
        $smarty->assign('Data',$data);
        $smarty->display('h5/User/Index.tpl');
    }


    /**
     * 获取html
     * Time：2018/07/26 12:40:59
     * @author li
    */
    function _getListData(){
        //查找最后一次设置的展会档案
        $mdlUser = FLEA::getSingleton('Model_Acm_User');
        $mdlUser->clearLinks();
        $mdlEx = FLEA::getSingleton('Model_Jichu_Exhibition');
        $exhibition = $mdlEx->find(array(),'id desc');
        if(!$exhibition){
            $exhibition['name'] = '联系管理员设置展会信息';
        }

        //获取业务员信息
        $user = $mdlUser->find($_SESSION['USERID']);
        // dump($listUser);

        //查询客户数量
        $sql = "SELECT id,compName,contacts,mobile,isStop,imgCode,tip,cardPath,tip FROM jichu_client WHERE userId='{$user['id']}' and exid = '{$exhibition['id']}' and isStop=0 order by id desc";
        $clientArr = $this->_modelExample->findBySql($sql);
        $user['clientCount'] = count($clientArr)+0;
        $user['proCount'] = 0;

        foreach ($clientArr as $key => & $v) {
            $sql = "SELECT count(id) as cnt FROM product_to_client WHERE clientId = '{$v['id']}'";
            $rowsTmp = $this->_modelExample->findBySql($sql);
            $v['proCount'] = $rowsTmp[0]['cnt']+0;
            $user['proCount'] += $v['proCount'];

            //查找tip
            if($v['tip']){
                $sql = "SELECT * from jichu_tip where id in ({$v['tip']})";
                $tips = $this->_modelExample->findBySql($sql);
                $tmpTip = array();
                foreach ($tips as &$t) {
                    $tmpTip[] = "<font color='{$t['color']}'>{$t['tip']}</font>";
                }
                $v['tip'] = join(' ',$tmpTip);
            }
        }

        return array('user'=>$user,'exhibition'=>$exhibition,'client'=>$clientArr);
    }


}

?>