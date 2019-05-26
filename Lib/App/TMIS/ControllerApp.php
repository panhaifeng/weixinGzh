<?php
class TMIS_ControllerApp extends FLEA_Controller_Action {
    function __construct(){

    }

    function header_wap(){
        echo '<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">';
    }

    function authCheck($funcId = 0,$isReturn=false) {
        $warning = "<div align=center style='font-size:1.1em; color=#cc0000;margin-top:40%;'>
            <img src='Resource/Image/warning.gif' style='vertical-align:middle;'>您没有登录或无访问权限</img>
            </div>";

        if ($funcId === 0) {//检查是否登录
            if($_SESSION['USERID']>0) return true;
            if ($isReturn) return false;
            $_SESSION['TARGETURL'] = $_SERVER['REQUEST_URI'];
            if ($isReturn) return false;
            redirect(url('LoginApp','index'));
            exit;
        }

        //处理$funcId>0的情况
        if(empty($_SESSION['USERID'])) {//没有登录,显示登录界面
            //保存当前地址到session
            $_SESSION['TARGETURL'] = $_SERVER['REQUEST_URI'];
            if ($isReturn) return false;
            redirect(url('LoginApp','logout'));
            exit;
        }

        $mUser = FLEA::getSingleton('Model_Acm_User');
        $user = $mUser->find($_SESSION['USERID']);//dump($user);exit;
        if($user['userName']=='admin') {//管理员直接跳过
            return true;
        }


        $userRoles = $mUser->getRoles($_SESSION['USERID']);
        if(count($userRoles)==0) {
            if (!$isReturn)$this->header_wap();
            if (!$isReturn) die($warning);
            return false;
        }
        $roles = join(',',array_col_values($userRoles,'id'));
        //各个组是否享有对当前节点的访问权限
        $sql = "select count(*) cnt from acm_func2role where (menuId like '{$funcId}-%' or menuId='{$funcId}') and roleId in({$roles})";
        $_r = $mUser->findBySql($sql);
        if($_r[0]['cnt']==0) {
            if (!$isReturn)$this->header_wap();
            if (!$isReturn) die($warning);
            return false;
        }
        return true;
    }

    //取得系统配置数组
    function getSysSet() {
        FLEA::loadClass('TMIS_Common');
        return TMIS_Common::getSysSet();
    }

    //根据前缀，自动从表中产生$head.yymmddxxx的流水号
    function _getNewCode($head,$tblName,$fieldName) {
        $m = & FLEA::getSingleton('Model_Acm_User');
        $sql = "select {$fieldName} from {$tblName} where {$fieldName} like '{$head}_________' order by {$fieldName} desc limit 0,1";

        $_r = $m->findBySql($sql);
        $row = $_r[0];

        $init = $head .date('ymd').'001';
        if(empty($row[$fieldName])) return $init;
        if($init>$row[$fieldName]) return $init;

        //自增1
        $max = substr($row[$fieldName],-3);
        $pre = substr($row[$fieldName],0,-3);
        return $pre .substr(1001+$max,1);
    }

    function _autoCode($head,$next,$tblName,$fieldName){
        $m = & FLEA::getSingleton('Model_Acm_User');
        $sql = "select {$fieldName} from {$tblName} where {$fieldName} like '{$head}{$next}____' order by {$fieldName} desc limit 0,1";

        $_r = $m->findBySql($sql);
        $row = $_r[0];

        $init = $head.$next.'0001';
        if(empty($row[$fieldName])) return $init;
        if($init>$row[$fieldName]) return $init;
        // dump($init);exit;
        //自增1
        $max = substr($row[$fieldName],-4);
        $pre = substr($row[$fieldName],0,-4);
        return $pre .substr(10001+$max,1);
    }

    #根据主键删除,并返回到action=right
    function actionRemove() {
        $from = $_GET['fromAction']?$_GET['fromAction']:$_GET['from'];
        if ($this->_modelExample->removeByPkv($_GET['id'])) {
            if($from=='') redirect($this->_url("Index"));
            else mui_alert('成功删除',"",$this->_url($from));
        }
        else mui_alert('出错，不允许删除!',$this->_url($from));

    }

        /*
    ps:判断是否消息提醒，哪个模板
    $type 客户类型
    $level 客户等级
    $style 投资模式

    */
    function sendSkmail($client,$type,$level,$invest){

        $_modelXiaoxi = &FLEA::getSingleton('Model_Jichu_Xiaoxi');

        if($type && $level && $invest!==null){
            // $invest = $invest-1;
            // dump($invest);die;
            $sql = "SELECT * from jichu_xiaoxi where clientType='{$type}' and level='{$level}' and isDaik='{$invest}' ";
            // $mail = $_modelXiaoxi->find(array('clientType'=>$type,'level'=>$level,'isDaik'=>$invest));
            // dump($sql);die;
            $mail = $_modelXiaoxi->findBySql($sql);


            $isDaik = $mail[0]['isDaik']==0?'全款':'贷款';
            $message = '客户：'.$client.', 投资模式：'.$isDaik.', 此次应收总款的'.$mail[0]['percent'].'%';
            // dump($message);die;
            if(count($mail)>0) return $message;

        }else{
            return false;
        }

    }

    //发送邮件
    /*
    $mail 发送的消息模板
    $fuzerenId 客户的负责人
    */
    function sendMail($mail,$fuzerenId){
        // dump($mail);die;
        // dump($fuzerenId);die;
        $this->_modelUser = &FLEA::getSingleton('Model_Acm_User');
        $this->_modelMail = &FLEA::getSingleton('Model_Mail');
        $user = $this->_modelUser->find(array('userName'=>'admin'));
        // dump($user);die;
        $sender = $user['id'];
        // $sender=$_SESSION['USERID'];
        $dt=date("Y-m-d H-i-s");
        if(!$mail) $mail='';
        // $url=$_POST['fromAction']==''?'Add':'right';
        //用于标记同一次发送的邮件，2012-11-6 by li
        $code=$this->getNewCode();
        $rows=array(
            'id'=>'',
            'senderId'=>$sender,
            'accepterId'=>$fuzerenId,
            'title'=>'客户等级改变需支付金额通知',
            'content'=>$mail,
            'dt'=>$dt,
            'mailCode'=>$code,
        );
        // dump($rows);exit;
        $ids = $this->_modelMail->save($rows);
        return $ids;
        // dump($ids);die;

        // js_alert('','window.parent.showMsg("发送成功")',$this->_url($url));

    }

    function getNewCode(){
            $sql="select * from mail_db order by mailCode desc limit 0,1";
            $res=mysql_fetch_assoc(mysql_query($sql));
            return $res['mailCode']+1;
    }

     // 判断是否来自微信浏览器
    public function from_weixin() {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }



}
?>
