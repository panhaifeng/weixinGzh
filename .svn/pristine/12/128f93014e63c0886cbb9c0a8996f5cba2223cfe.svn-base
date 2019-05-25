<?php
FLEA::loadClass('Controller_Cangku_Chuku');
class Controller_Cangku_Yuanliao_Fwll extends Controller_Cangku_Chuku {
	function __construct() {
		// $this->_kuwei = '仓库';//库位
		$this->_head = 'FWLLA';//单据前缀
		$this->_kind='发外领料';
		// $this->_state = '切断后';
		
		parent::__construct();

		$oldHeadSon = $this->headSon;

		//浏览界面的字段
		$this->fldRight = array(			
			"chukuDate" => "出库日期",
			
			// "kind" => "类别",
			'kuwei' => '库位',
			'jiagonghuName' => '领用单位',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'cnt' => '领用数量', 
			'chukuCode' => array("text"=>'出库单号','width'=>150),
			'memo' => '备注'
		);

		unset($this->fldMain['depId']);
		$this->fldMain = $this->fldMain + array('jiagonghuId' => array('title' => '领料单位', 'type' => 'select', 'value' => '', 'model' => 'Model_Jichu_Jiagonghu'));
		// $this->fldMain = array(
		// 	'chukuCode' => array('title' => '出库单号', 'type' => 'text', 'readonly' => true, 'value' => $this->_getNewCode($this->_head, $this->_modelMain->qtableName, 'chukuCode')),
		// 	'chukuDate' => array('title' => '出库日期', "type" => "calendar", 'value' => date('Y-m-d')), 
		// 	'kind' => array('title' => '出库类别', 'type' => 'text', 'value' => $this->_kind, 'readonly' => true),
		// 	'jiagonghuId' => array('title' => '领料单位', 'type' => 'select', 'value' => '', 'model' => 'Model_Jichu_Jiagonghu'),
		// 	'lingliaoren' => array('title' => '领料人', 'type' => 'text', 'value' => ''),
		// 	'kuwei' => array('title' => '库位选择', 'type' => 'select', 'value' => '','options'=>$rowsKuwei), 
		// 	'memo' => array('title' => '出库备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'chukuMemo'), 
		// 	'id' => array('type' => 'hidden', 'value' => $_GET['id'],'name'=>'chukuId'), 
		// ); 
		
		// /从表表头信息
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'ord2proId' => array(
				'title' => '生产计划', //表头文字
				'type' => 'BtPopup', 
				'value' => '',
				'name'=>'ord2proId[]',
				'text'=>'',//现在在文本框中的文字
				'url'=>url('Shengchan_Plan','popup'),//弹出地址,回调函数在sonTpl中进行定义,主要是对缓存中的关联数组进行重写
				'textFld'=>'orderCode',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
				'inTable'=>1,
			),
			'productId' => array('type' => 'btProductpopup', "title" => '产品编码', 'name' => 'productId[]'),
			// 'dengji' => array('type' => 'btselect', 'title' => '等级', 'name' => 'dengji[]','options'=>$optionDengji),
			'proName' => array('type' => 'bttext', "title" => '品名', 'name' => 'proName[]', 'readonly' => true),
			'guige' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true),
			'color' => array('type' => 'bttext', "title" => '颜色', 'name' => 'color[]', 'readonly' => true), 
			// 'unit'=>array('type'=>'bttext',"title"=>'单位','name'=>'unit[]','readonly'=>true),
			'pihao' => array('type' => 'bttext', 'title' => '批号', 'name' => 'pihao[]'),
			'cnt' => array('type' => 'bttext', "title" => '领用数量(kg)', 'name' => 'cnt[]'),
			//'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			//'money' => array('type' => 'bttext', "title" => '金额(元)', 'name' => 'money[]'), 
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			// 'plan2proId' => array('type' => 'bthidden', 'name' => 'plan2proId[]'),
		); 

	}

	function actionAdd(){
		$this->authCheck('3-1-8');
		parent::actionAdd();
	}

	function actionRight(){
		$this->authCheck('3-1-9');
		parent::actionRight(false);
	}
}