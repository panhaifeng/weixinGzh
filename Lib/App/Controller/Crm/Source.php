<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Crm_Source extends Tmis_Controller {
	var $_modelExample;
	var $title = "客户来源";

	function Controller_Crm_Source() {
		$this->_modelExample = &FLEA::getSingleton('Model_Crm_Source');

		$this->fldMain = array(
        	'id'=>array('title'=>'','type'=>'hidden','value'=>''),
        	'name'=>array('title'=>'名称','type'=>'text','value'=>''),
        );

        $this->rules = array(
			'name'=>'required',
		);
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
	    $smarty->display('Main/A.tpl');
	}

	function actionAdd($Arr){
		$this->fldMain = $this->getValueFromRow($this->fldMain,$row);

		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('title',$this->title);
	    $smarty->assign('rules',$this->rules);
	    $smarty->assign('form',array('up'=>true));
	    $smarty->display('Main/A.tpl');
	}

	function actionRight() {
	////////////////////////////////标题
		$title = '客户来源';
		///////////////////////////////模板文件
		$tpl = 'TableList.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			'_edit'=>'操作',
			"name" =>"名称",
		);

		///////////////////////////////模块定义
		$this->authCheck('11-4');

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'key'=>'',
		));
		//dump($arr);
		$condition=array();
		if($arr['key']!='') {
			$condition[] = array('name',"%{$arr['key']}%",'like');
		}
		
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id asc');
		$rowset =$pager->findAll();
		
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}

	function actionSave() {
		//dump($_POST);exit;
		//新增时判断公司名和代码是否重复
		$str1="SELECT count(*) as cnt FROM `jichu_source` where id<>'{$_POST['id']}' and name='{$_POST['name']}'";
		$ret=$this->_modelExample->findBySql($str1);
		if($ret[0]['cnt']>0) {
			js_alert('名称重复!','window.history.go(-1);');
		}

		if($_POST['name']){
			$id = $this->_modelExample->save($_POST);
		}
		if($_POST['Submit']=='保 存')
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));
		else
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('add'));

	}

	function actionRemove() {
		parent::actionRemove();
	}



	
}
?>