<?php
FLEA::loadClass('TMIS_ControllerApp');
class Controller_App_Compnay extends TMIS_ControllerApp {

    // /构造函数
    function __construct() {
        $this->_modelExample = FLEA::getSingleton('Model_Jichu_Client');
    }


    /**
     * 按照管理员用户信息展示，统计公司所有新增客户数量
     * Time：2018/07/24 13:35:58
     * @author li
    */
    function actionListUser(){
        $this->authCheck(0);
        //获取对应的数据
        $data = $this->_getListData();

        $smarty = & $this->_getView();
        $smarty->assign('title','展会总览');
        $smarty->assign('Data',$data);
        $smarty->display('h5/Compnay/Index.tpl');
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
        // $condition[] = array('userName','admin','<>');
        $condition[] = array('isdelete','0','=');
        $listUser = $mdlUser->findAll($condition,null,null,'id,userName,realName,phone');
        // dump($listUser);

        $company = array();
        //获取这些员工的本次展会的发展客户情况
        foreach ($listUser as $key => & $v) {
            //查询客户数量
            $sql = "SELECT id FROM jichu_client WHERE userId='{$v['id']}' and exid = '{$exhibition['id']}' and isStop=0";
            $rowsTmp = $this->_modelExample->findBySql($sql);
            $clientId = array_col_values($rowsTmp ,'id');
            $clientId_str = join(',' ,$clientId);
            $v['clientCount'] = count($rowsTmp)+0;
            $v['clientId'] = $clientId_str;
            unset($rowsTmp);

            //查询对应的样品数量
            $v['proCount'] = 0;
            if($clientId_str){
                $sql = "SELECT count(id) as cnt FROM product_to_client WHERE userId='{$v['id']}' and exid = '{$exhibition['id']}' and clientId in ({$clientId_str})";
                $rowsTmp = $this->_modelExample->findBySql($sql);
                $v['proCount'] = $rowsTmp[0]['cnt'];

            }else{
                unset($listUser[$key]);
            }

            //统计公司的
            $company['proCount']+=$v['proCount'];
            $company['clientCount']+=$v['clientCount'];
        }

        return array('company'=>$company ,'user'=>$listUser,'exhibition'=>$exhibition,'count'=>($company['proCount']+$company['clientCount']+0));
    }


    /**
     * ajax获取html更新页面
     * Time：2018/07/26 13:06:45
     * @author li
    */
    function actionMsgCountHtmlAjax(){
        //参数：判断是否有变动
        $count = intval($_POST['count']);
        $data = $this->_getListData();

        //表示需要更新html
        if($data['count'] != $count){
            $smarty = & $this->_getView();
            $smarty->assign('Data',$data);
            $html = $smarty->fetch('h5/Compnay/ListView.tpl');
            $data['htmlView'] = $html;
        }

        echo json_encode($data);
    }
}

?>