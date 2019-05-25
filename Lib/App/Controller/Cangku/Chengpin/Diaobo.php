<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :jeff
*  FName  :Ruku.php
*  Time   :2014/05/13 18:27:29
*  Remark :仓库入库的通用控制器
\*********************************************************************/
FLEA::loadClass('Controller_Cangku_Chuku');
// / 父类，被Controller_Shengchan_Yuliao_ruku继承
class Controller_Cangku_Chengpin_Diaobo extends Controller_Cangku_Chuku {
	
	var $fldMain;
	var $headSon;
	var $rules; // 表单元素的验证规则
	var $_modelDefault;
	var $_modelExample;
	var $_modelMain;
	var $_modelSon;
	var $isState = 2; // 状态 原料|已热轧|已精轧|已电解|已切断
	var $_head; // 单据前缀
	var $_kind='调拨';
	var $fldRight; // 浏览时需要显示的字段
	var $isReturn = 1; // 用来在sql中标示是退货的 $_kind=$isReturn，在Controller_Cangku_Yuanliao_Ruku中的构造函数中赋值
	/**
	 * 构造函数
	 */
	function __construct() {
		$this->_state = '成品';
		$this->_kind='调拨';
		$this->_arrKuwei = array('成品仓库');
		$this->_modelTrader = &FLEA::getSingleton('Model_Trade_Order');
		//$this->_modelCaigou = &FLEA::getSingleton('Model_Caigou_Order');
		$this->_modelExample = &FLEA::getSingleton ( 'Model_Cangku_Chengpin_Diaobo' );
		$this->_modelSon = &FLEA::getSingleton ( 'Model_Cangku_Chengpin_Chuku2Product' );
		$this->_modelKuwei = &FLEA::getSingleton ( 'Model_Jichu_Kuwei' );
		$this->_modelMain = &FLEA::getSingleton ( 'Model_Cangku_Ruku' );
		$this->_modelChuku = &FLEA::getSingleton ( 'Model_Cangku_Chuku' );
		// 得到库位信息
		// 生成库位 名称信息
		$m = & FLEA::getSingleton ( 'Model_Jichu_Client' );
		$sql = "select * from jichu_kuwei where 1";
		$rowset = $m->findBySql ( $sql );
		foreach ( $rowset as &$v ) {
			// *根据要求：options为数组,必须有text和value属性
			$rowsKuwei [] = array (
					'text' => $v ['kuweiName'],
					'value' => $v ['kuweiName'] 
			);
		}
			
			// 定义模板中的主表字段
		$this->fldMain = array (
				// /*******2个一行******
				'chukuDate' => array (
						'title' => '调拨日期',
						"type" => "calendar",
						'value' => date ( 'Y-m-d' ) 
				),
				// 入库单号，自动生成
				'chukuCode' => array (
						'title' => '调拨单号',
						'type' => 'text',
						'readonly' => true,
						'value' => $this->_getNewCode ( $this->_head, $this->_modelExample->qtableName, 'chukuCode' ) 
				),
				// /*******2个一行******
				// 'supplierpopup需要显示供应商名称，所以需要定义supplierName属性,value属性作为supplierId用
				'kuwei' => array('title' => '调出库位', 'type' => 'select', 'value' => '','options'=>$rowsKuwei), 
				'diaoru' => array('title' => '调入库位', 'type' => 'select', 'value' => '','options'=>$rowsKuwei),
				
				// /*******2个一行******
				// 定义了name以后，就不会以memo作为input的id了
				'memo' => array (
						'title' => '备注',
						'type' => 'textarea',
						'disabled' => true,
						'name' => 'chukuMemo' 
				),
				// 下面为隐藏字段
				'id' => array (
						'type' => 'hidden',
						'value' => '',
						'name' => 'chukuId' 
				),
				'isState' => array (
						'type' => 'hidden',
						'value' => '2',
						'name' => 'isState' 
				),
				'rukuId' => array (
						'type' => 'hidden',
						'name' => 'rukuId'
				),
				
		// 'isGuozhang' => array('type' => 'hidden', 'value' => ''),
				);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array (
				'_edit' => array (
						'type' => 'btBtnRemove',
						"title" => '+5行',
						'name' => '_edit[]' 
				),
				'productId' => array (
						'type' => 'btproductpopup',
						"title" => '产品选择',
						'name' => 'productId[]' 
				),
				'proName' => array (
						'type' => 'bttext',
						"title" => '品名',
						'name' => 'proName[]',
						'readonly' => true 
				),
				'guige' => array (
						'type' => 'bttext',
						"title" => '规格',
						'name' => 'guige[]',
						'readonly' => true 
				),
				'cnt' => array (
						'type' => 'bttext',
						'title' => '公斤数',
						'name' => 'cnt[]'
				),
				'cntJian' => array (
						'type' => 'bttext',
						"title" => '件数',
						'name' => 'cntJian[]' 
				),
				// ***************如何处理hidden?
				'id' => array (
						'type' => 'bthidden',
						'name' => 'id[]' 
				), 
				'ruku2proId' => array (
						'type' => 'bthidden',
						'name' => 'ruku2proId[]'
				),
		);
		// 表单元素的验证规则定义
		$this->rules = array (
				'chukuDate' => 'required',
				'supplierId' => 'required',
				'kuweiId' => 'required',
				
		);
		// 表单元素的验证规则定义
		$this->rules = array (
				'chukuDate' => 'required',
				'supplierId' => 'required',
				'kuweiId' => 'required',
		
		);
	}
	/**
	 * 新增
	 * $varTpl,模板变量，需要在默认的变量基础上增加新的模板变量
	 */
	function actionAdd($varTpl) {
		// 主表信息字段
		$fldMain = $this->fldMain;
		// *入库号的默认值的加载*
		$fldMain ['chukuCode'] ['value'] = $this->_getNewCode ( $this->_head, $this->_modelExample->qtableName, 'chukuCode' );
		$headSon = $this->headSon;
		// 从表信息字段,默认5行
		for($i = 0; $i < 1; $i ++) {
			$rowsSon [] = array ();
		}
		// 主表区域信息描述
		$areaMain = array (
				'title' => $this->_kind . '基本信息',
				'fld' => $fldMain 
		);
		// 从表区域信息描述
		$smarty = &$this->_getView ();
		$smarty->assign ( 'areaMain', $areaMain );
		$smarty->assign ( 'headSon', $headSon );
		$smarty->assign ( 'rowsSon', $rowsSon );
		$smarty->assign ( 'rules', $this->rules );
		foreach ( $varTpl as $k => &$v ) {
			$smarty->assign ( $k, $v );
		}
		$smarty->assign ( 'sonTpl', 'Cangku/chukuSonTpl.tpl' );
		$smarty->display ( 'Main2Son/T1.tpl' );
	}
	
	/**
	 * 编辑
	 * $varTpl,模板变量，需要在默认的变量基础上增加新的模板变量
	 */
	function actionEdit($varTpl) {
		//dump($_GET);die;
		$arr = $this->_modelExample->find ( array (
				'id' => $_GET ['id'] 
		) );
		//dump($arr);die;
		$sql="select kuwei ,id as rukuId from cangku_common_ruku where diaoboId={$_GET['id']}";
		$arr1=$this->_modelExample->findBySql($sql);
//  		dump($arr1);die;
		foreach ( $this->fldMain as $k => &$v ) {
			$v ['value'] = $arr [$k] ? $arr [$k] : $v ['value'];
		}
		$this->fldMain ['id'] ['value'] = $arr ['id'];
		$this->fldMain ['diaoru'] ['value'] = $arr1[0]['kuwei'];
		$this->fldMain ['rukuId'] ['value'] = $arr1[0]['rukuId'];
		foreach ($arr ['Products'] as &$v){
			$temp1 = array ();
			foreach ( $this->headSon as $kk => &$vv ) {
				$temp1 [$kk] = array (
						'value' => $v [$kk]
				);
			}
					$rowsSon1 [] = $temp1;
		}
		//dump($rowsSon1);die;
		// //加载库位信息的值
		$areaMain = array (
				'title' => '调拨基本信息',
				'fld' => $this->fldMain 
		);
		// 入库明细处理
		$rukuInfo = $this->_modelMain->find(array('diaoboId'=>$arr['id']));
// 		dump($rowsSon1);exit;
		$ruku2pros = array();
		$rowsSon = array ();
		foreach ( $rukuInfo ['Products'] as &$v ) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelMain->findBySql ( $sql );
			//dump($_temp);exit;
			$sql = "select cnt from cangku_common_ruku2product where id='{$v['ruku2proId']}'";
			$cnt = $this->_modelMain->findBySql ( $sql ); // dump($_temp);exit;
			$v ['proName'] = $_temp [0] ['proName'];
			$v ['guige'] = $_temp [0] ['guige'];
		}
// 		dump($rukuInfo['Products']);exit;
		foreach ( $rukuInfo ['Products'] as &$v ) {
			$temp = array ();
			foreach ( $this->headSon as $kk => &$vv ) {
				$temp [$kk] = array (
						'value' => $v [$kk] 
				);
			}
			$temp['ruku2proId']['value'] = $v['id'];
		}
		$rowsSon [] = $temp;
		$rowsSon[0]['id']=$rowsSon1[0]['id'];
		
// 		 dump($this->headSon);die;
         //$rowsSon[0][ruku2proId]=$temp['id'];
		// 补齐5行
		$cnt = count ( $rowsSon );
		for($i = 1; $i > $cnt; $i --) {
			$rowsSon [] = array ();
		}
		$smarty = &$this->_getView ();
		$smarty->assign ( 'areaMain', $areaMain );
		$smarty->assign ( 'headSon', $this->headSon );
		$smarty->assign ( 'rowsSon', $rowsSon );
		//$smarty->assign ( 'rowsSon1', $rowsSon1 );
		$smarty->assign ( 'rules', $this->rules );
		$smarty->assign ( 'sonTpl', 'Cangku/chukuSonTpl.tpl' );
		foreach ( $varTpl as $k => &$v ) {
			$smarty->assign ( $k, $v );
		}
		$smarty->display ( 'Main2Son/T1.tpl' );
	}
	
	/**
	 * 保存
	 */
	function actionSave() {
//  		dump($_POST);//die;
		$arr = $this->_modelSon->find ( array (
				'chukuId' => $_POST ['id']
		) );
		//dump($arr);die;
		$cangku_common_chuku = array ();
		$cangku_common_ruku = array ();
		// 根据headSon2,动态组成明细表数据集
		$cangku_common_chuku2product = array ();
		// cangku_common_chuku 表 的数组
		foreach ( $this->fldMain as $k => &$vv ) {
			$name = $vv ['name'] ? $vv ['name'] : $k;
			$cangku_common_chuku [$k] = $_POST [$name];
			$cangku_common_chuku ['id'] = $_POST ['chukuId'];
			unset ( $cangku_common_chuku ['chukuId'] );
		}
		//dump($cangku_common_chuku);//die;
		// 入库从表保存
		foreach ( $_POST ['productId'] as $key => $v ) {
			// 当没有记录 或者 没有输入数量时 跳出本次循环 防止多保存
			if (empty ( $_POST ['productId'] [$key] ) || empty ( $_POST ['cnt'] [$key] ))
				continue;
			
			//入库信息
			foreach ( $this->headSon as $k => &$vv ) {
				//dump($vv);
				$temp [$k] = $_POST [$k] [$key];
				$temp ['productId'] = $_POST ['productId'] [$key];
				$temp ['diaobo2Id'] = $key;
				$temp ['id'] = $_POST ['ruku2proId'] [$key];
			}
			unset($temp['ruku2proId']);
			$cangku_common_ruku2product [] = $temp;
			//出库信息
			$arr=array();
			foreach ( $this->headSon as $k => &$vv ) {
				$temp1 [$k] = $_POST [$k] [$key];
				$temp1 ['productId'] = $_POST ['productId'] [$key];
				$temp1 ['diaobo2Id'] = $key;
				$arr = $this->_modelSon->find ( array (
						'chukuId' => $_GET ['id']
				) );
				
			}
			$cangku_common_chuku2product [] = $temp1;
		}
		//dump($arr);
		//dump($cangku_common_chuku2product);die;
		if (count ( $cangku_common_chuku2product ) == 0) {
			js_alert ( '请选择有效物料并输入有效数量!', 'window.history.go(-1)' );
			exit ();
		}
		// 出库特殊化处理
		$cangku_common_chuku ['isState'] = 2;
		// 入库特殊化处理
		$cangku_common_ruku ['rukuCode'] = $cangku_common_chuku ['chukuCode'];
		$cangku_common_ruku ['rukuDate'] = $cangku_common_chuku ['chukuDate'];
		$cangku_common_ruku ['kuwei'] = $_POST['diaoru'];
		$cangku_common_ruku ['memo'] = $cangku_common_chuku ['memo'];
		//$cangku_common_ruku ['rukuType'] = 3;
		// 表之间的关联
		$cangku_common_chuku ['Products'] = $cangku_common_chuku2product;
		$cangku_common_ruku ['Products'] = $cangku_common_ruku2product;
		//dump($cangku_common_chuku);die;
		// 保存 并返回cangku_common_ruku表的主键
		$itemId = $this->_modelChuku->save ( $this->notNull ( $cangku_common_chuku ) );
		//入库保存操作
		$id = $itemId;
		$cangku_common_ruku ['id'] = $_POST['rukuId'];
		if ($itemId==1) {
			$cangku_common_ruku ['diaoboId'] =$_POST['chukuId'];
		}else{
			$cangku_common_ruku ['diaoboId'] =$id;
		}
// 		dump($cangku_common_ruku);die;
		$itemId = $this->_modelMain->save ( $this->notNull ( $cangku_common_ruku ) );
		if (! $itemId) {
			echo "保存失败";
			exit ();
		}
		js_alert ( null, 'window.parent.showMsg("保存成功!")', url ( $_POST ['fromController'], $_POST ['fromAction'] ) );
	}
	/**
	 * 浏览
	 * $isShowAdd:是否显示新增按钮
	 */
	function actionRight($isShowAdd) {
		FLEA::loadClass ( 'TMIS_Pager' );
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray ( array (
				'dateFrom' => date ( "Y-m-d", mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - 30, date ( "Y" ) ) ),
				'dateTo' => date ( "Y-m-d" ),
				'kuweiId' => '',
				'key' => '' 
		) );
		$sql = "select DISTINCT
		        x.id,x.chukuDate,x.chukuCode,x.memo,z.kuwei as diaoru,x.isState,x.kuwei,d.productId,d.cnt,d.cntJian,p.proName,p.proCode
				from cangku_common_chuku x
				left join cangku_common_chuku2product d on x.id = d.chukuId
				left join jichu_product p on p.id=d.productId
				left join cangku_common_ruku z on z.diaoboId=x.id
                where x.isState=2";
		$sql .= " and x.chukuDate >= '$serachArea[dateFrom]' and x.chukuDate<='$serachArea[dateTo]'";
		//if ($serachArea ['key'] != '')
		//	$sql .= " and (x.chukuCode like '%{$serachArea[key]}%')";
	//	if ($serachArea ['kuweiId'] != '')
			//$sql .= " and d.kuweiId = '{$serachArea[kuweiId]}'";
		$sql .= " order by x.id desc";
		$pager = &new TMIS_Pager ( $sql );  //dump($str);
		$rowset = $pager->findAll (); 
		
		//dump($rowset);exit;
		$ruku2product = &FLEA::getSingleton ( 'Model_Cangku_Ruku2Product' );
		if (count ( $rowset ) > 0)
			foreach ( $rowset as &$value ) {
			//dump($_GET=$value['id']);die;
				$value ['_edit'] = "<a href='" . $this->_url ( 'Edit', array (
						'id' => $value ['id'],
						'fromAction' => $_GET ['action'] 
				) ) . "'>修改</a>";
				$value ['_edit'] .= " <a href='" . $this->_url ( 'Remove', array (
						'id' => $value ['id'],
				) ) . "'  onclick=\"return confirm('确认删除吗?')\" >删除</a>";
		
				//$sql2 = "select x.*,y.proName,y.proCode,k.kuweiName from cangku_common_ruku2product x
				//left join jichu_product y on x.productId = y.id
				//where x.rukuId='{$value['teshuId']}'";
				//$res = $ruku2product->findBySql ( $sql2 );
				//dump($res);die;
				//$value ['ruku'] = $res;
				// dump($value);exit;
			}
			// 合计行
		$smarty = &$this->_getView ();
		// 左侧信息
		$arrFieldInfo = array (
				"_edit" => array (
						'text' => '操作',
						'width' => 100 
				),
				"chukuDate" => "调拨日期",
				"chukuCode" => "调拨编号",
				"kuwei" =>'出库名',
				"diaoru" => '入库名',
				'proCode' => '产品编号',
				'proName' => '产品名称',
				'cnt'=>'公斤数',
				"cntJian" => '件数' 
		);
		$smarty->assign ( 'title', '订单查询' );
		$smarty->assign ( 'pk', $this->_modelExample->primaryKey );
		$smarty->assign ( 'arr_field_info', $arrFieldInfo );
		$smarty->assign ( 'sub_field', 'ruku' );
		$smarty->assign ( 'add_display', 'none' );
		$smarty->assign ( 'arr_condition', $serachArea );
		$smarty->assign ( 'arr_field_value', $rowset );
		$smarty->assign ( "page_info", $pager->getNavBar ( $this->_url ( $_GET ['action'] ), $serachArea ) );
		$smarty->assign ( 'arr_js_css', $this->makeArrayJsCss ( array (
				'grid',
				'calendar' 
		) ) );
		 $smarty->display('TableList.tpl');
		//$smarty->display ( 'TblListMore3.tpl' );
	}
	/**
	 * 删除调拨
	 * @caibin
	 * @2014-07-31
	 */
	function actionRemove() {
		$chukuId = $_GET['id'];
		$query = "select y.id from cangku_common_chuku x left join cangku_common_ruku y on x.id = y.diaoboId where x.isState = 2 and x.id = ".$chukuId;
		$res = mysql_fetch_array(mysql_query($query));
		//dump($res);die;
		$rukuId = $res['id'];
		$res = $this->_modelExample->removeByPkv($chukuId);
		$res1 = $this->_modelMain->removeByPkv($rukuId);
		if($res && $res1){
			js_alert(null,"window.parent.showMsg('成功删除')",$this->_url("right"));
		}else{
			js_alert('出错，不允许删除!',$this->_url("right"));
		}
	}
	
	/**
	 * 编辑界面利用ajax删除
	 */
	function actionRemoveByAjax() {
		$m = & $this->_modelSon;
		$r = $m->removeByPkv ( $_POST ['id'] );
		if (! $r) {
			$arr = array (
					'success' => false,
					'msg' => '删除失败' 
			);
			echo json_encode ( $arr );
			exit ();
		}
		$arr = array (
				'success' => true 
		);
		echo json_encode ( $arr );
		exit ();
	}
}

?>