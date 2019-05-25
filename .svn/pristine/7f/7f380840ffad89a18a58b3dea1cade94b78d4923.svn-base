<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Crm_Action extends Tmis_Controller {
	var $_modelExample;

	function Controller_Crm_Action() {
		$this->_modelExample = &FLEA::getSingleton('Model_Crm_Action');
		$this->fldMain = array(
			'id'=>array('title'=>'','type'=>'hidden','value'=>''),

			'cid' => array(
				'title' => '客户名称', 
				'type' => 'popup', 
				'value' => '',
				'name'=>'cid',
				'text'=>'选择客户',
				'url'=>url('Crm_Intention','Popup'),//弹出地址,回调函数在sonTpl中进行定义,主要是对缓存中的关联数组进行重写
				'textFld'=>'company',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
				'inTable'=>1,
			),

            'actionType'=>array('type'=>'select','title'=>'行动类别','name'=>'actionType','options'=>array(
				array('text'=>'意向跟进','value'=>'意向跟进'),
				array('text'=>'实施','value'=>'实施'),
				array('text'=>'售后维护','value'=>'售后维护'),
			)), 
            'contact_time' => array('title' => '行动时间', 'type' => 'calendar', 'value' => date('Y-m-d')),
            'contact_type'=>array('title'=>'行动方式','type'=>'select','value'=>'','model' => 'Model_Crm_ActionType'),
            'sid'=>array('title'=>'行动人','type'=>'select','model' => 'Model_Jichu_Employ','isSearch'=>true,'condition'=>'depId in(select id from jichu_department where depName like "%业务%")'),

            'memo'=>array('title'=>'行动内容','type'=>'textarea','value'=>''),

        );
        $this->sonTpl = 'Crm/actionSon.tpl';
	}

	function actionRight() {
		$this->authCheck('11-2');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
		 	'dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
            'dateTo' => date("Y-m-d"),
			'contact_type' => '',
			'actionType' => '',
			'clientName' => '',
		));
		$str = "SELECT x.*,y.employName,z.company as clientName,a.name as contact_type
                from action_contact x
              	left join jichu_employ y on x.sid=y.id
              	left join intention_client z on x.cid=z.id
              	left join jichu_actiontype a on a.id=x.contact_type
                where 1 ";
        if($arr['dateFrom'] != '') {
	        $str .= " and x.contact_time >= '$arr[dateFrom]' and x.contact_time<='$arr[dateTo]'";
        }
		if ($arr['actionType'] != '') $str .= " and x.actionType like '%{$arr['actionType']}%'";
		if ($arr['contact_type'] != '') $str .= " and x.contact_type like '%{$arr['contact_type']}%'";
		if ($arr['clientName'] != '') $str .= " and z.company like '%{$arr['clientName']}%'";
		if($_GET['id']!='') $str .="and z.id='{$_GET['id']}'";
		//该用户关联的业务员
        $mUser = & FLEA::getSingleton('Model_Acm_User');
        if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
            //得到当前用户匹配的员工id
            $traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
            if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
                $str .= " and 0";
            } else {
                $s = join(',',$traderIds);
                $str .= " and z.kefu_id in ({$s})";
            }
        }

		$str .= " order by id asc";
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']);
		}
		$smarty = &$this->_getView();
		$smarty->assign('title', '行动查询');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"clientName" => '客户名称',
            "employName" => '行动人',
            "contact_time" => '行动时间',
            "actionType" => '行动类别',
            "contact_type" => '行动方式',
			"memo" => '行动内容',
            "_edit" => array('text'=>'操作','width'=>'80'),
		);
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset); 
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	} 

	function actionAdd($Arr){

		$this->fldMain = $this->getValueFromRow($this->fldMain,$row);

		if($_GET['id']){
        	$this->_modelCrmClient = &FLEA::getSingleton('Model_Crm_Client');
        	$clients = $this->_modelCrmClient->find(array('id'=>$_GET['id']));
			$this->fldMain['cid']['value'] = $clients['id'];
			$this->fldMain['cid']['text'] = $clients['company'];
		}

		// dump($this->fldMain);die;

		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('title',$this->title);
	    $smarty->assign('rules',$this->rules);
		$smarty->assign('sonTpl',$this->sonTpl);
	    $smarty->display('Main/A1.tpl');
	}

	function actionEdit(){
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
	    $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
	    // dump($this->fldMain);exit;
	    $smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('rules',$this->rules);
	    $smarty->assign('title',$this->title);
	    $smarty->assign('aRow',$row);
	    $smarty->assign('form',array('up'=>true));
	    $smarty->display('Main/A1.tpl');
	}


	function actionSave() {
		// dump($_POST);exit;
		

		if($_POST['cid']){
			$id = $this->_modelExample->save($_POST);
		}
		if($_POST['tijiao']=='保 存')
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']==''?'Right':$_POST['fromAction']));
		else
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('add'));

	}

}

?>