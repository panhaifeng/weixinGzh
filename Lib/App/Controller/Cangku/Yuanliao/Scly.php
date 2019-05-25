<?php
FLEA::loadClass('Controller_Cangku_Chuku');
class Controller_Cangku_Yuanliao_Scly extends Controller_Cangku_Chuku {
	function __construct() {
		// $this->_kuwei = '仓库';//库位
		$this->_head = 'LLCKA';//单据前缀
		$this->_kind='领料出库';
		// $this->_state = '切断后';
		
		parent::__construct();

		//浏览界面的字段
		$this->fldRight = array(			
			"chukuDate" => "出库日期",
			
			// "kind" => "类别",
			'kuwei' => '库位',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'cnt' => '领用数量', 
			'chukuCode' => array("text"=>'出库单号','width'=>150),
			'memo' => '备注'
		);

		
		// /从表表头信息
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			// 'ord2proId' => array('type' => 'BtPlanPopup', "title" => '相关生产计划', 'name' => 'ord2proId[]'),
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
			'cnt' => array('type' => 'bttext', "title" => '数量(G)', 'name' => 'cnt[]'),
			//'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			//'money' => array('type' => 'bttext', "title" => '金额(元)', 'name' => 'money[]'), 
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			// 'plan2proId' => array('type' => 'bthidden', 'name' => 'plan2proId[]'),
		); 

	}

	function actionAdd(){
		$this->authCheck('3-1-6');
		parent::actionAdd();
	}

	function actionRight(){
		$this->authCheck('3-1-7');
		parent::actionRight(false);
	}
}