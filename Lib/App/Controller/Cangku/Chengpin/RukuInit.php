<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :Ruku.php
*  Time   :2014/05/13 18:31:40
*  Remark :成品入库初始化
\*********************************************************************/
FLEA::loadClass('Controller_Cangku_Ruku');
class Controller_Cangku_Chengpin_RukuInit extends Controller_Cangku_Ruku {
	// var $fldMain;
	// var $headSon;
	// var $rules;//表单元素的验证规则
	// **************************************构造函数 begin********************************
	function __construct() {
		$this->_state = '成品';
		$this->_head = 'CCSHA';
		$this->_kind='成品初始化';
		$this->_modelDefault = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku');
		$this->_modelExample = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku'); 
		$this->_modelMain = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku');
		$this->_modelSon = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku2Product');
	
		//得到库位信息
		// 生成库位 名称信息
		$m = & FLEA::getSingleton('Model_Jichu_Client');
		$sql = "select * from jichu_kuwei where 1";
		$rowset = $m->findBySql($sql);
		foreach($rowset as &$v) {
			// *根据要求：options为数组,必须有text和value属性
			$rowsKuwei[] = array('text' => $v['kuweiName'], 'value' => $v['kuweiName']);
		} 
		//浏览界面的字段
		$this->fldRight = array(			
			"rukuDate" => "入库日期",
			"kind" => "类别",
			'kuwei' => '库位',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'cnt' => '公斤数', 
			'rukuCode' => array("text"=>'单号','width'=>150),
			'memo' => '备注'
		);

		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuDate' => array('title' => '入库日期', "type" => "calendar", 'value' => date('Y-m-d')), 
			'rukuCode' => array('title' => '入库单号', 'type' => 'text', 'readonly' => true, 'value' => ''), 
			// 'orderId' => array(
			// 	'title' => '相关订单', 
			// 	'type' => 'popup', 
			// 	'value' => '',
			// 	'name'=>'orderId',
			// 	'text'=>'',
			// 	'url'=>url('Trade_Order','Popup'),
			// 	'onSelFunc'=>'onSel',//选中后需要执行的回调函数名,需要在jsTpl中书写
			// 	'textFld'=>'orderCode',//显示在text中的字段
			// 	'hiddenFld'=>'orderId',//显示在hidden控件中的字段
			// ),

			'kind' => array('title' => '入库类别', 'type' => 'text', 'value' => $this->_kind, 'readonly' => true),
			// 'kuwei' => array('title' => '库位选择', 'type' => 'text', 'value' => '成品仓库','readonly' => true), 
			// by zcc 取消写死的 换成下来选择的 2016年10月24日 
			'kuwei' => array('title' => '库位选择', 'type' => 'select' ,'options'=>$rowsKuwei),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'rukuMemo'), 
			'id' => array('type'=>'hidden', 'value'=>$_GET['id'],'name'=>'rukuId'),
		); 
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			// 'proCode' => array('type' => 'bttext', "title" => '产品编码', 'name' => 'proCode[]','readonly'=>true),
			'productId' => array(
				'title' => '物料编码', 
				'type' => 'btPopup', 
				'value' => '',
				'name'=>'productId[]',
				'text'=>'选择入库',
				'url'=>url('jichu_product','popup'),//弹出地址,回调函数在sonTpl中进行定义,主要是对缓存中的关联数组进行重写
				'textFld'=>'proCode',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
				'inTable'=>1,
			),
			'proName' => array('type' => 'bttext', "title" => '品名', 'name' => 'proName[]', 'readonly' => true),
			'guige' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true), 
			'color' => array('type' => 'bttext', "title" => '颜色', 'name' => 'color[]', 'readonly' => true), 
			// 'dengji' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true), 
			// 'unit'=>array('type'=>'bttext',"title"=>'单位','name'=>'unit[]','readonly'=>true),
			// 'pihao' => array('type' => 'bttext', 'title' => '批号', 'name' => 'pihao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>array(
				array("text"=>'好布',"value"=>'好布',),
				array("text"=>'疵布',"value"=>'疵布',),
				array("text"=>'疵点多',"value"=>'疵点多',),				
			)),  
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'), 
			'cnt' => array('type' => 'bttext', "title" => '公斤数', 'name' => 'cnt[]'), 
			// 'cntM' => array('type' => 'bttext', "title" => '米数', 'name' => 'cntM[]'), 
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			//'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
			// 'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			); 
		// 表单元素的验证规则定义
		$this->rules = array('rukuDate' => 'required', 
			// 'orderDate'=>'required',
			'kuwei' => 'required', 
			// 'traderId'=>'required'
		);

	}

	//新增时调整子模板
	function _beforeDisplayAdd(&$smarty) {
		// $smarty->assign('sonTpl', 'Cangku/Chengpin/jsRuku.tpl');
	}

	//修改时要显示订单号
	function _beforeDisplayEdit(&$smarty) {
		// $rowsSon = $smarty->_tpl_vars['rowsSon'];
		// $areaMain = & $smarty->_tpl_vars['areaMain'];
		// // dump($smarty->_tpl_vars);dump($areaMain);exit;
		// $orderId= $areaMain['fld']['orderId']['value'];
		// $sql = "select orderCode from trade_order where id='{$orderId}'";
		// // dump($sql);
		// $_rows = $this->_modelExample->findBySql($sql);

		// $areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];
	}

	//去掉打印按钮
	function _beforeDisplayRight(&$smarty) {

	}

	function actionRight(){
		$this->authCheck('3-2-1');
        parent::actionRight(ture);
	}
}