<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :Ruku.php
*  Time   :2014/05/13 18:31:40
*  Remark :成品入库	控制器
\*********************************************************************/
FLEA::loadClass('Controller_Cangku_Chuku');
class Controller_Cangku_Chengpin_ChukuSell extends Controller_Cangku_Chuku {
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
			'orderId' => array(
				'title' => '相关订单', 
				'type' => 'popup', 
				'value' => '',
				'name'=>'orderId',
				'text'=>'',
				'url'=>url('Trade_Order','Popup'),
				//'jsTpl'=>'Cangku/Chengpin/jsRuku.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
				'onSelFunc'=>'onSel',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'orderCode',//显示在text中的字段
				'hiddenFld'=>'orderId',//显示在hidden控件中的字段
			),
			//'clientName' => array('title' => '客户名称', 'type' => 'text', 'value' => '', 'readonly' => true),
			//'traderName' => array('title' => '业务员', 'type' => 'text', 'value' => '', 'readonly' => true),

			'memo' => array('title' => '出库备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'chukuMemo'), 
			'clientId' => array('type' => 'hidden', 'value' =>'','name'=>'clientId'), 
			'id' => array('type' => 'hidden', 'value' => $_GET['id'],'name'=>'chukuId'), 
		); 
		
	$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'proCode' => array('type' => 'bttext', "title" => '产品编码', 'name' => 'proCode[]','readonly'=>true),
			// 'ord2proId' => array(
			// 	'title' => '', //表头文字
			// 	'type' => 'BtPopup', 
			// 	'value' => '',
			// 	'name'=>'ord2proId[]',
			// 	'text'=>'',//现在在文本框中的文字
			// 	'url'=>url('Shengchan_Plan','popup'),//弹出地址,回调函数在sonTpl中进行定义,主要是对缓存中的关联数组进行重写
			// 	'textFld'=>'orderCode',//显示在text中的字段
			// 	'hiddenFld'=>'id',//显示在hidden控件中的字段
			// 	'inTable'=>1,
			// ),
			// 'productId' => array('type' => 'btProductpopup', "title" => '产品编码', 'name' => 'productId[]'),
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
			//'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			//'money' => array('type' => 'bttext', "title" => '金额(元)', 'name' => 'money[]'), 
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
		); 
		// 表单元素的验证规则定义
		$this->rules = array('chukuDate' => 'required',
			'orderId' => 'required',
			// 'supplierId' => 'required',
			'kuwei' => 'required',
			'kind' => 'required',
		);

		//查询时的字段信息,在查询界面和收发存弹出明细窗口需要用到
		$this->fldRight = array(
			"_edit" => '操作',
			//'madan'=>array('text'=>'码单','width'=>50),
			"chukuDate" => "出库日期",
			'chukuCode' => '出库单号',
			"kuwei" => "库位",
			'orderCode' => '生产编码',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'cntJian' => '件数',
			//'cntM' => '米数',
			'depName' => '领用部门',
			// 'zhonglei' => '种类',
			// 'color' => '颜色',
			'cntOrg' => '数量', 
			'unit'=>'单位',
			'cnt'=>'折合公斤数',
			'danjia' => '单价', 
			'money' => '金额', 
			// ''=>'',
			);

	}

	//新增时调整子模板
	function _beforeDisplayAdd(&$smarty) {
		$smarty->assign('sonTpl', 'Cangku/Chengpin/jsSell.tpl');
	}

	//修改时要显示订单号,客户和业务员
	function _beforeDisplayEdit(&$smarty) {
		// $rowsSon = $smarty->_tpl_vars['rowsSon'];
		$areaMain = & $smarty->_tpl_vars['areaMain'];
		// // dump($smarty->_tpl_vars);dump($areaMain);exit;
		$orderId= $areaMain['fld']['orderId']['value'];
		$m = & FLEA::getSingleton('Model_Trade_Order');
		$order = $m->find(array('id'=>$orderId));
		// 'clientName' => array('title' => '客户名称', 'type' => 'text', 'value' => '', 'readonly' => true),
		// 	'traderName' => array('title' => '业务员', 'type' => 'text', 'value' => '', 'readonly' => true),
		$areaMain['fld']['orderId']['text'] = $order['orderCode'];
		// $areaMain['fld']['clientName']['value'] = $order['Client']['compName'];
		// $areaMain['fld']['traderName']['value'] = $order['Trader']['employName'];
		// // dump($sql);
		// $_rows = $this->_modelExample->findBySql($sql);

		// $areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];
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

	function actionReport() {
		//dump($_GET);exit();
		$this->authCheck('3-2-7');
		FLEA::loadClass("TMIS_Pager");
		$arr = &TMIS_Pager::getParamArray(array(
			"dateFrom" => date('Y-m-01'), 
			"dateTo" => date('Y-m-d'), 
			 "proCode" =>"",
			//"proName"=>"",
			"guige" =>"",
			"kuweiName"  =>'',
			'dengji'=>'',
			//"key"=>'',
		)); 

		//处理库位
		// $strKuwei = join("','",$this->_arrKuwei);
	   //找到所有属于成品的库位
		$str="select kuweiName from jichu_kuwei where type='成品'";
		$res=$this->_modelExample->findBySql($str);
		$strKuwei=join("','",array_col_values($res,'kuweiName'));
        $strCon .= " and kuwei in ('{$strKuwei}')";
		
         if($arr['kuweiName']!='') $strCon.=" and kuwei='{$arr['kuweiName']}'";
         if($arr['guige']!='') $map .=" and guige like '%{$arr['guige']}%'";
         if($arr['proCode']!='') $map .="and proCode like '%{$arr['proCode']}%'";
         if($arr['dengji']!='') $map .="and dengji = '{$arr['dengji']}'";
		// }
		$strGroup="kuwei,productId,dengji";
		$sqlUnion="select {$strGroup},
		sum(cntFasheng) as cntInit,
		sum(cntJian) as cntJianInit,
		sum(moneyFasheng) as moneyInit,
		0 as cntJianRuku,
		0 as cntRuku,0 as moneyRuku,0 as cntChuku,0 as moneyChuku,0 as cntJianChuku
		from `cangku_common_kucun` where dateFasheng<'{$arr['dateFrom']}' 
		 {$strCon} group by {$strGroup} 
		union 
		select {$strGroup},
		0 as cntInit,
		0 as cntJianInit,
		0 as moneyInit,
		sum(cntJian) as cntJianRuku,
		sum(cntFasheng) as cntRuku,
		sum(moneyFasheng) as moneyRuku,
		0 as cntChuku,0 as moneyChuku,
		0 as cntJianChuku
		from `cangku_common_kucun` where 
		dateFasheng>='{$arr['dateFrom']}' and dateFasheng<='{$arr['dateTo']}'
		and rukuId>0  {$strCon} group by {$strGroup} 
		union 
		select {$strGroup},
		0 as cntInit,
		0 as cntJianInit,
		0 as moneyInit,
		0 as cntJianRuku,
		0 as cntRuku,
		0 as moneyRuku,
		sum(cntFasheng*-1) as cntChuku,
		sum(moneyFasheng*-1) as moneyChuku,
		sum(cntJian) as cntJianChuku
		from `cangku_common_kucun` where 
		dateFasheng>='{$arr['dateFrom']}' and dateFasheng<='{$arr['dateTo']}'
		and chukuId>0  {$strCon} group by {$strGroup}";
		$sql="select 
		{$strGroup},
		sum(cntInit) as cntInit,
		sum(cntJianInit) as cntJianInit,
		sum(moneyInit) as moneyInit,
		sum(cntJianRuku) as cntJianRuku,
		sum(cntRuku) as cntRuku,
		sum(moneyRuku) as moneyRuku,
		sum(cntChuku) as cntChuku,
		sum(moneyChuku) as moneyChuku,
		sum(cntJianChuku) as cntJianChuku
		from ({$sqlUnion}) as x
		left join jichu_product y on x.productId = y.id
		where 1 {$map}	
		group by {$strGroup}
		having sum(cntInit)<>0 or sum(moneyInit)<>0 
		or sum(cntRuku)<>0 or sum(moneyRuku)<>0
		or sum(cntChuku)<>0 or sum(moneyChuku)<>0
		order by x.productId"; 
		//dumP($sql);exit;
		// todo.....
		if ($_GET['Export']) {
			$rowset = $this->_modelExample->findBySql($sql);
		}else{
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
		}
		
		//得到合计信息	
		
		foreach($rowset as &$v) {
			// dump($v);exit;
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelMain->findBySql($sql);
			$v['proCode'] = $temp[0]['proCode'];
			$v['proName'] = $temp[0]['proName'];
			$v['guige'] = $temp[0]['guige'];
			$v['color'] = $temp[0]['color'];

			// $sql = "select * from jichu_supplier where id='{$v['supplierId']}'";
			// $temp = $this->_modelMain->findBySql($sql);
			// $v['supplierName'] = $temp[0]['compName'];
			$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'], 2);
            $v['cntJian']= round( $v['cntJianInit'] +$v['cntJianRuku'] - $v['cntJianChuku'], 2);
			//本期入库和本期出库点击可看到明细
		} 
		$heji = $this->getHeji($rowset,array('cntInit','cntRuku','cntChuku','cntKucun','cntJian'),'kuwei');

		//出入库数量形成可弹出明细的链接
		foreach($rowset as & $v) {
			if ($_GET['Export']) {
				$v['cntRuku'] = $v['cntRuku'];
				$v['cntChuku'] = $v['cntChuku'];
			}else{
				$v['cntRuku'] = "<a href='".url('Cangku_Yuanliao_Ruku','popup',array(
					'dateFrom'=>$arr['dateFrom'],
					'dateTo'=>$arr['dateTo'],
					'kuwei'=>$v['kuwei'],
					'productId'=>$v['productId'],
					//'state'=>$this->_state,
					// 'supplierId'=>$v['supplierId'],
				))."' target='_blank'>{$v['cntRuku']}</a>";

				$v['cntChuku'] = "<a href='".url("Cangku_Yuanliao_Chuku",'popup',array(
					'dateFrom'=>$arr['dateFrom'],
					'dateTo'=>$arr['dateTo'],
					'kuwei'=>$v['kuwei'],
					'productId'=>$v['productId'],
					//'state'=>$this->_state,
					// 'supplierId'=>$v['supplierId'],
				))."' target='_blank'>{$v['cntChuku']}</a>";
			}
			// $cName = str_replace('chuku', 'ruku', strtolower($_GET['controller']));
		}

		$rowset[] = $heji;
		// 显示信息
		$arrFieldInfo = array(
			'kuwei' => '库位', 
			//'state' => '状态', 
			"proCode" => "产品编码",
			'proName' => '品名',
			"guige" => "规格",
			"color" => "颜色",
			"dengji" => "等级",
			// "supplierName" => '供应商',
			// 'pihao'=>'批号',
			'cntInit' => '期初',
			'cntJianInit' => '期初件数',
			'cntRuku' => '本期入库',
			'cntJianRuku' => '本期入库件数',
			'cntChuku' => '本期出库',
			'cntJianChuku' => '本期出库件数',
			'cntKucun' => '余存', 
			'cntJian'=>'件数',
			);

		$smarty = &$this->_getView();
		$smarty->assign('title', '收发存报表'); 
		// $smarty->assign('pk', $this->_modelDefault->primaryKey);
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);

		//得到总计
		$sql = "select 
		sum(cntFasheng) as cnt,
		sum(moneyFasheng) as money
		from `cangku_common_kucun` 
		where dateFasheng<='{$arr['dateTo']}' {$strCon}";
		// dump($sql);exit;
		$zongji = $this->_modelMain->findBySql($sql);
		$zongji = $zongji[0];
		$smarty->assign('fn_export',$this->_url("Report",array("Export"=>1)));
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		if($_GET['Export']){
			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=xsfx.xls");
			$smarty->display('Export2Excel.tpl');
			exit();
		}else{
			$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $arr)."<font color='red'>数量总计:{$zongji['cnt']}</font>");
			$smarty->display('TableList.tpl');
		}
		
	}

    //根据订单销售出库
	function actionAdd(){
		//$this->authCheck('3-2-5');
		parent::actionAdd();

	}

	function actionRight(){
		//$this->authCheck('3-2-6');
		parent::actionRight();
	}

	function actionSave(){
		// dump($_POST);exit;
		$yuanliao_llck2product = array();
		$order2pro=&FLEA::getSingleton('Model_Trade_Order2Product');
		foreach ($_POST['productId'] as $key => $v) {
			// 当没有记录 或者 没有输入数量时 跳出本次循环 防止多保存
			if (empty($_POST['productId'][$key]) || empty($_POST['cnt'][$key])) continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$key];
				//根据ord2proId 取得订单明细表中的 单价
				if($k=='ord2proId'){
                    $res=$order2pro->find(array('id'=>$_POST['ord2proId'][$key]));
                    $temp['danjia'] = $res['danjia'];
				}
			}
			$yuanliao_llck2product[] = $temp;
		} 
		//dump($yuanliao_llck2product);exit;
		//如果没有选择物料，返回
		if(count($yuanliao_llck2product)==0) {
			js_alert('请选择有效物料并输入有效数量!','window.history.go(-1)');
			exit;
		}
		// yuanliao_llck 表 的数组	
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$yuanliao_llck[$k] = $_POST[$name];
		}	

		// 表之间的关联
		$yuanliao_llck['Products'] = $yuanliao_llck2product; 
		// 保存 并返回yuanliao_cgrk表的主键
		$row = $this->notNull($yuanliao_llck);
		//dump($yuanliao_llck);exit;
		$row['creater'] = $_SESSION['REALNAME']?$_SESSION['REALNAME']:" ";
		$itemId = $this->_modelExample->save($row);
		if (!$itemId) {
			echo "保存失败";
			exit;			
		}
		js_alert(null, 'window.parent.showMsg("保存成功!")', url($_POST['fromController'],$_POST['fromAction']));
	}


}