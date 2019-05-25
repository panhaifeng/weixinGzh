<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Plan extends Tmis_Controller {
	// /构造函数
	function Controller_Shengchan_Plan() {
		$this->_modelDefault = &FLEA::getSingleton('Model_Trade_Order');
		$this->_modelOrder2Product = &FLEA::getSingleton('Model_Trade_Order2Product');
	} 
	// /生产计划
	function actionListForAdd() {
		// $this->authCheck('2-1');
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
				'dateTo' => date("Y-m-d"),
				'clientId' => '',
				'traderId' => '', 
				// 'isCheck' => 0,
				'orderCode' => '',
				'key' => '',
				)); 
		// /查询sql语句
		$sql = "select y.orderCode,
		               y.orderDate,
		               y.clientId,
		               y.traderId,
		               y.clientOrder,
		               y.memo as orderMemo,
		               y.isCheck,
		               x.id,
		               x.orderId as orderId,
		               x.productId,
		               x.danjia,
		               x.cntYaohuo,
		               x.unit,
		               x.memo 
			               from trade_order2product x
	                       left join trade_order y on (x.orderId = y.id)";

		$str = "select
		        x.id,
				x.orderId,
				x.orderCode,
				x.orderDate,
				x.clientId,
				x.traderId,
				x.productId,
				x.clientOrder,
				x.cntYaohuo,
				x.danjia,
				x.danjia*x.cntYaohuo as money,
				x.orderMemo,
				x.memo,
				x.isCheck,
				x.unit,
				y.id as clientId,
				y.compName,
				z.proCode,
				z.proName,
				z.guige,
				z.menfu,
				z.kezhong,
				m.employName
				from (" . $sql . ") x
				left join jichu_client y on x.clientId = y.id
				left join jichu_product z on x.productId = z.id
				left join jichu_employ m on m.id=x.traderId
                where 1";

		$str .= " and orderDate >= '$serachArea[dateFrom]' and orderDate<='$serachArea[dateTo]'";
		if ($serachArea['key'] != '') $str .= " and (x.orderCode like '%$serachArea[key]%'
											or z.proName like '%$serachArea[key]%'
											or z.proCode like '%$serachArea[key]%'
											or z.guige like '%$serachArea[key]%')"; 
		// if($serachArea['isCheck'] != '')   $str .= " and x.isCheck = '$serachArea[isCheck]'";
		if ($serachArea['orderCode'] != '') $str .= " and x.orderCode like '%$serachArea[orderCode]%'";
		if ($serachArea['clientId'] != '') $str .= " and x.clientId = '$serachArea[clientId]'";
		if ($serachArea['traderId'] != '') $str .= " and x.traderId = '$serachArea[traderId]'";
		$str .= " order by orderDate desc, orderCode desc"; 
		// dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll(); 
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$value) {
			// $value['clientName'] = $value['Client']['compName'];
			// $value['chejianName'] = $value['Chejian']['name'];
			$arrPro = array();
			if (count($value['Products']) > 0) foreach($value['Products'] as &$pv) {
				$arrPro[] = $mPro->getProStr($mPro->find(array('id' => $pv['productId']))) . ": $pv[cnt]";
			} 
			// if($value["guozhangId"]){
			// $tip = "ext:qtip='已设置加权平均单价禁止修改'";
			// }
			$title = join("<br>", $arrPro);
			$value['cntYaohuo'] = round($value['cntYaohuo'], 2);
			$value['danjia'] = round($value['danjia'], 2);
			$value['money'] = round($value['money'], 2);

			if ($value["isCheck"] != 1) {
				$tip = "ext:qtip='未审核'";
				$value['_edit'] .= "<a href='javascript:void(0)' style='color:black' $tip>导出</a>";
			}else {
				$value['_edit'] .= "<a href='" . $this->_url('Export', array('id' => $value['id']
						)) . "' target='_blank'>生成计划</a>";
			}

			// 设定颜色
			if ($value['isCheck'] != 1) {
				$value['_bgColor'] = "lightgray";
			}
		}

		$smarty = &$this->_getView();
		$arrFieldInfo = array("_edit" => '操作',
			"orderDate" => "日期",
			"orderCode" => "单号",
			"compName" => "客户名称",
			'orderCode' => '客户合同号',
			'employName' => '业务员',
			'proName' => '品名',
			'guige' => '规格', 
			'menfu' => '门幅', 
			'kezhong' => '克重', 
			// 'unit'=>'单位',
			"cntYaohuo" => '数量',
			"unit" => '单位',
			// "danjia" => '单价',
			// "money" => '金额', 
			// "orderMemo" =>'订单备注',
			// "memo" =>'产品备注'
			);

		$smarty->assign('title', '订单查询');
		$smarty->assign('pk', $this->_modelDefault->primaryKey);
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea)."<font color='gray'><p>灰色表示未审核<p></font>");
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$smarty->display('TableList.tpl');
	} 
	// /导出excel
	function actionExport() {
		// dump($_GET);exit;
		$arr = $this->_modelOrder2Product->find($_GET['id']);
		// dump($arr);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign('aRow',$arr);

		FLEA::loadClass('TMIS_Common');
		TMIS_Common::exportExcel($arr["Order"]["orderCode"]."日期".date("Ymd").'.xls');
		$smarty->display("Chengpin/dingChanDan.xml");
	}


	/**
	 * 弹出选择生产计划,在生产领用和生产入库时一般都需要用到
	 */
	function actionPopup() {
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
				'dateTo' => date("Y-m-d"),
				'clientId' => '',
				'traderId' => '',
				'orderCode' => '',
				'key' => '',
				)); 
		// /查询sql语句
		$sql = "select y.orderCode,
		   y.orderDate,
		   y.clientId,
		   y.traderId,
		   y.clientOrder,
		   y.isCheck,
		   x.id,
		   x.orderId as orderId,
		   x.productId,
		   x.danjia,
		   x.cntYaohuo
		       from trade_order2product x
		       left join trade_order y on (x.orderId = y.id)";

		$str = "select
		x.orderId,
		x.orderCode,
		x.orderDate,
		x.clientId,
		x.traderId,
		x.productId,
		x.clientOrder,
		x.cntYaohuo,
		x.danjia,
		x.danjia*x.cntYaohuo as money,
		x.isCheck,
		y.id,
		y.compName,
		z.proCode,
		z.proName,
		z.guige,
		z.color,
		z.kind,
		z.color,
		m.employName
		from (" . $sql . ") x
		left join jichu_client y on x.clientId = y.id
		left join jichu_product z on x.productId = z.id
		left join jichu_employ m on m.id=x.traderId
		where 1 and x.isCheck=1"; 
		// /判断是从哪个页面进入的
		if (isset($_GET['isSePiSha'])) {
			if ($_GET['isSePiSha'] == 1) {
				$str .= " and z.kind in ('坯纱','色纱')";
			}
		}elseif (isset($_GET['isChengPing'])) {
			if ($_GET['isChengPing'] == 1) {
				$str .= " and z.kind in ('坯布','其他')";
			}
		}

		$str .= " and orderDate >= '$serachArea[dateFrom]' and orderDate<='$serachArea[dateTo]'";
		if ($serachArea['key'] != '') $str .= " and (x.orderCode like '%$serachArea[key]%'
						or z.proName like '%$serachArea[key]%'
						or z.proCode like '%$serachArea[key]%'
						or z.guige like '%$serachArea[key]%')";
		if ($serachArea['orderCode'] != '') $str .= " and x.orderCode like '%$serachArea[orderCode]%'";
		if ($serachArea['clientId'] != '') $str .= " and x.clientId = '$serachArea[clientId]'";
		if ($serachArea['traderId'] != '') $str .= " and x.traderId = '$serachArea[traderId]'";
		$str .= " order by orderDate desc, orderCode desc"; 
		// dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll();

		if (count($rowset) > 0) foreach($rowset as $i => &$v) {
			$v['cnt'] -= $cnt;
			$v['danjia'] = round($v['danjia'], 2);
			$v['money'] = round($v['money'], 2);
		}
		$arrFieldInfo = array("orderCode" => "单号",
			"orderDate" => "日期",
			"compName" => "客户名称",
			'employName' => '业务员',
			'proName' => '产品名称',
			'guige' => '规格', 
			'color' => '颜色', 
			// 'unit'=>'单位',
			"cntYaohuo" => '数量', 
			// "danjia" =>'单价',
			// "money" =>'金额'
			);
		$smarty = &$this->_getView();
		$smarty->assign('title', '选择客户');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('page_info', $pager->getNavBar($this->_url('Popup', $serachArea)));
		$smarty->display('Popup/CommonNew.tpl');
	}
	// // /导出excel
	// function actionExport() {
	// 	// 需求 每个花型对应一个导出功能
	// 	// 根据传过来的 id 查询trade_order2product表
	// 	if (!$_GET['id'])exit;
	// 	$trade_order2product = &FLEA::getSingleton('Model_Trade_Order2Product');
	// 	$jichu_client = &FLEA::getSingleton('Model_Jichu_Client');
	// 	$arr = $trade_order2product->find($_GET['id']); 
	// 	// 查出客户名称
	// 	$arrClinet = $jichu_client->find($arr['Order']['clientId']); 
	// 	// dump($arr);exit;
	// 	// 将所需数据放入$data中
	// 	$data = array('cntYaohuo' => $arr['cntYaohuo'],
	// 		'unit' => $arr['unit'],
	// 		'memo' => $arr['memo'],
	// 		'proCode' => $arr['Products']['proCode'],
	// 		'proName' => $arr['Products']['proName'],
	// 		'guige' => $arr['Products']['guige'],
	// 		'finalDate' => $arr['dateJiaohuo'],
	// 		'clientOrder' => $arr['Order']['clientOrder'],
	// 		'clientName' => $arrClinet['compName'], // 客户名称
	// 		); 
	// 	// dump( $data);exit;
	// 	// 实例化EXCEl类
	// 	$tpl = "test.xls";
	// 	$p = new Excel_Reader($tpl);
	// 	$p->add_data($data);
	// 	$p->export();
	// 	exit;
	// }
}


?>