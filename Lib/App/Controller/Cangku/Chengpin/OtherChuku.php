<?php
/*********************************************************************\
*没有订单的销售出库
\*********************************************************************/
FLEA::loadClass('Controller_Cangku_Chuku');
class Controller_Cangku_Chengpin_OtherChuku extends Controller_Cangku_Chuku {
	// var $fldMain;
	// var $headSon;
	// var $rules;//表单元素的验证规则
	// **************************************构造函数 begin********************************
	function __construct() {
		$this->_state = '成品';
		$this->_head = 'XSCKA';
		$this->_kind='销售出库';
		$this->_arrKuwei = array('成品仓库');

		$this->_modelDefault = &FLEA::getSingleton('Model_Cangku_Chengpin_Chuku');
		$this->_modelExample = &FLEA::getSingleton('Model_Cangku_Chengpin_Chuku'); 
		$this->_modelMain = &FLEA::getSingleton('Model_Cangku_Chengpin_Chuku');
		$this->_modelSon = &FLEA::getSingleton('Model_Cangku_Chengpin_Chuku2Product');
		//得到库位信息
		$sql = "select * from jichu_kuwei where 1";
		$rowset = $this->_modelMain->findBySql($sql);
		foreach($rowset as &$v) {
			// *根据要求：options为数组,必须有text和value属性
			$rowsKuwei[] = array('text' => $v['kuweiName'], 'value' => $v['kuweiName']);
		} 

		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', 'type' => 'text', 'readonly' => true, 'value' => $this->_getNewCode($this->_head, $this->_modelMain->qtableName, 'chukuCode')),
			'chukuDate' => array('title' => '出库日期', "type" => "calendar", 'value' => date('Y-m-d')), 
			'kind' => array('title' => '出库类别', 'type' => 'text', 'value' => $this->_kind, 'readonly' => true),
			'kuwei' => array('title' => '库位选择', 'type' => 'select', 'value' => '','options'=>$rowsKuwei), 
			// 'orderId' => array(
			// 	'title' => '相关订单', 
			// 	'type' => 'popup', 
			// 	'value' => '',
			// 	'name'=>'orderId',
			// 	'text'=>'',
			// 	'url'=>url('Trade_Order','Popup'),
			// 	//'jsTpl'=>'Cangku/Chengpin/jsRuku.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
			// 	'onSelFunc'=>'onSel',//选中后需要执行的回调函数名,需要在jsTpl中书写
			// 	'textFld'=>'orderCode',//显示在text中的字段
			// 	'hiddenFld'=>'orderId',//显示在hidden控件中的字段
			// ),
			'clientId' => array('title' => '客户', "type" => "clientpopup", 'value' => ''),
			//'traderName' => array('title' => '业务员', 'type' => 'text', 'value' => '', 'readonly' => true),

			'memo' => array('title' => '出库备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'chukuMemo'), 
			'id' => array('type' => 'hidden', 'value' => $_GET['id'],'name'=>'chukuId'), 
		); 
		
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'productId' => array('type' => 'btProductpopup', "title" => '产品编码', 'name' => 'productId[]'),
			'proName' => array('type' => 'bttext', "title" => '品名', 'name' => 'proName[]', 'readonly' => true),
			'guige' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true),
			'color' => array('type' => 'bttext', "title" => '颜色', 'name' => 'color[]', 'readonly' => true), 
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>array(
				array("text"=>'好布',"value"=>'好布',),
				array("text"=>'疵布',"value"=>'疵布',),
				array("text"=>'疵点多',"value"=>'疵点多',),				
			)), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'), 
			'cntOrg' => array('type' => 'bttext', "title" => '数量', 'name' => 'cntOrg[]'), 
			//'cntM' => array('type' => 'bttext', "title" => '米数', 'name' => 'cntM[]'), 
			'unit'=>array('type'=>'btSelect','title'=>'单位','name'=>'unit[]','options'=>array(
				array('text'=>'公斤','value'=>'公斤'),
				array('text'=>'米','value'=>'米'),
				array('text'=>'码','value'=>'码'),
				array('text'=>'磅','value'=>'磅'),
				array('text'=>'条','value'=>'条'),
				)), 
			'cnt'=>array('type' => 'bttext', "title" => '折合公斤数', 'name' => 'cnt[]'),
			'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			'bizhong' => array('title' => '交易币种', 'type' => 'btSelect','name'=>'bizhong[]', 'value' => '', 
				'options' => array(
					array('text' => 'RMB', 'value' => 'RMB'),
					array('text' => 'USD', 'value' => 'USD'),
					)), 
			'money' => array('type' => 'bttext', "title" => '金额(元)', 'name' => 'money[]'), 
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array('chukuDate' => 'required',
			'clientId' => 'required',
			// 'supplierId' => 'required',
			'kuwei' => 'required',
			'kind' => 'required',
		);


		//查询时的字段信息,在查询界面和收发存弹出明细窗口需要用到
		$this->fldRight = array(
			"_edit" => '操作',
			"chukuDate" => "出库日期",
			'chukuCode' => '出库单号',
			"kuwei" => "库位",
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'cntJian' => '件数',
			'cntM' => '米数',
			'depName' => '领用部门',
			// 'zhonglei' => '种类',
			// 'color' => '颜色',
			'cnt' => '数量', 
			'danjia' => '单价', 
			'money' => '金额', 
			// ''=>'',
			);

	}

	function actionAdd(){
		parent::actionAdd();
	}
    
    function actionEdit(){
    	$arr = $this->_modelMain->find(array('id' => $_GET['id'])); //dump($arr);exit;
		//设置主表id的值
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value']; 
		}
		//dump($this->fldMain);//exit;
		//处理客户信息
		//$this->areaMain['']
		// 入库明细处理
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelDefault->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			$v['color'] = $_temp[0]['color'];
		} 
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}

			//得到订单编号
			// $sql = "";
			$m = & FLEA::getSingleton('Model_Trade_Order2product');
			$row = $m->find(array('id'=>$v['ord2proId']));

			// dump($row);exit;
			$temp['ord2proId']['text'] = $row['Order']['orderCode'];
			$rowsSon[] = $temp;
		} 
		// dump($rowsSon);exit;
		//补齐5行
		$cnt = count($rowsSon);
		for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}
        // dump($rowsSon);exit;
		$smarty = &$this->_getView();
		$smarty->assign('areaMain',array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain));
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', 'Cangku/Yuanliao/jsLlck.tpl');
		$this->_beforeDisplayEdit($smarty);
		$smarty->display('Main2Son/T1.tpl');
    }

    //去掉领用部门
	function _beforeDisplayRight(&$smarty) {
		$f = & $smarty->_tpl_vars['arr_field_info'];
		unset($f['depName']);
		unset($f['danjia']);
		unset($f['money']);
		$f['memo'] = "备注";
		// $areaMain = & $smarty->_tpl_vars['areaMain'];
		// // dump($smarty->_tpl_vars);dump($areaMain);exit;
		// $orderId= $areaMain['fld']['orderId']['value'];
		// $sql = "select orderCode from trade_order where id='{$orderId}'";
		// // dump($sql);
		// $_rows = $this->_modelExample->findBySql($sql);

		// $areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];
	}
    
}
