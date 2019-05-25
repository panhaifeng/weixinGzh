<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :Ruku.php
*  Time   :2014/05/13 18:31:40
*  Remark :成品入库	控制器
\*********************************************************************/
FLEA::loadClass('Controller_Cangku_Ruku');
class Controller_Cangku_Chengpin_Ruku extends Controller_Cangku_Ruku {
	// var $fldMain;
	// var $headSon;
	// var $rules;//表单元素的验证规则
	// **************************************构造函数 begin********************************
	function __construct() {
		$this->_state = '成品';
		$this->_head = 'SCRKA';
		$this->_kind='生产入库';
		$this->_modelDefault = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku');
		$this->_modelExample = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku'); 
		$this->_modelMain = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku');
		$this->_modelSon = &FLEA::getSingleton('Model_Cangku_Chengpin_Ruku2Product');
		
		//浏览界面的字段
		$this->fldRight = array(			
			"rukuDate" => "入库日期",
			"kind" => "类别",
			'kuwei' => '库位',
			// 'state' => '状态',
			// 'proKind' => '种类',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			// 'pihao'=>'批号',
			// 'color' => '颜色',
			'cntJian' => '件数', 
			'cnt' => '公斤数', 
			'cntM' => '米数', 
			// 'danjia' => '单价', 
			// 'money' => '金额', 
			// "orderCode" => "相关订单",
			// 'songhuoCode' => '送货单号',
			'rukuCode' => array("text"=>'入库单号','width'=>150),
			'memo' => '备注'
		);
		//得到库位信息
		// 生成库位 名称信息
		$m = & FLEA::getSingleton('Model_Jichu_Client');
		$sql = "select * from jichu_kuwei where 1";
		$rowset = $m->findBySql($sql);
		foreach($rowset as &$v) {
			// *根据要求：options为数组,必须有text和value属性
			$rowsKuwei[] = array('text' => $v['kuweiName'], 'value' => $v['kuweiName']);
		} 

		// 定义模板中的主表字段
		$this->fldMain = array(
			// /*******2个一行******
			'rukuDate' => array('title' => '入库日期', "type" => "calendar", 'value' => date('Y-m-d')), 
			// 入库单号，自动生成
			'rukuCode' => array('title' => '入库单号', 'type' => 'text', 'readonly' => true, 'value' => ''), 
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

			// 'songhuoCode' => array('title' => '送货单号', 'type' => 'text', 'value' => ''),
			'kind' => array('title' => '入库类别', 'type' => 'text', 'value' => $this->_kind, 'readonly' => true),
			'kuwei' => array('title' => '库位选择', 'type' => 'select' ,'options'=>$rowsKuwei),
			// 'state' => array('title' => '状态', 'type' => 'text', 'value' =>$this->_state, 'readonly'=>true), 
			// /*******2个一行******
			// 定义了name以后，就不会以memo作为input的id了
			'memo' => array('title' => '备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'rukuMemo'), 
			// 下面为隐藏字段
			'id' => array('type'=>'hidden', 'value'=>$_GET['id'],'name'=>'rukuId'),
			// 'isGuozhang' => array('type' => 'hidden', 'value' => ''),
		); 
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'proCode' => array('type' => 'bttext', "title" => '产品编码', 'name' => 'proCode[]','readonly'=>true),
			// 'productId' => array(
			// 	'title' => '物料编码', 
			// 	'type' => 'BtPopup', 
			// 	'value' => '',
			// 	'name'=>'productId[]',
			// 	'text'=>'选择入库',
			// 	'url'=>url('jichu_product','popup'),//弹出地址,回调函数在sonTpl中进行定义,主要是对缓存中的关联数组进行重写
			// 	'textFld'=>'proCode',//显示在text中的字段
			// 	'hiddenFld'=>'id',//显示在hidden控件中的字段
			// 	'inTable'=>1,
			// ),
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
			'Madan' => array('type' => 'btBtnMadan', "title" => '码单', 'name' => 'Madan[]'),
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'), 
			'cnt' => array('type' => 'bttext', "title" => '公斤数', 'name' => 'cnt[]'), 
			'cntM' => array('type' => 'bttext', "title" => '米数', 'name' => 'cntM[]'), 
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'madanCache'=>array('type' => 'bthidden', 'name' => 'madanCache[]'),
			); 
		// 表单元素的验证规则定义
		$this->rules = array('rukuDate' => 'required', 
			// 'orderDate'=>'required',
			'orderId' => 'required', 
			'kuwei' => 'required', 
			// 'traderId'=>'required'
		);

	}

	//新增时调整子模板
	function _beforeDisplayAdd(&$smarty) {
		$smarty->assign('sonTpl', 'Cangku/Chengpin/jsRuku.tpl');
		$smarty->assign('sonTpl2', 'Cangku/Chengpin/MadanRukuJs.tpl');
	}

	//修改时要显示订单号
	function _beforeDisplayEdit(&$smarty) {
		$rowsSon = $smarty->_tpl_vars['rowsSon'];
		$areaMain = & $smarty->_tpl_vars['areaMain'];
		// dump($smarty->_tpl_vars);dump($areaMain);exit;
		$orderId= $areaMain['fld']['orderId']['value'];
		$sql = "select orderCode from trade_order where id='{$orderId}'";
		// dump($sql);
		$_rows = $this->_modelExample->findBySql($sql);

		$areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];

		$smarty->assign('sonTpl2', 'Cangku/Chengpin/MadanRukuJs.tpl');
	}

	// //去掉打印按钮
	// function _beforeDisplayRight(&$smarty) {

	// }
    

	function actionAdd(){
		$this->authCheck('3-2-2');
		parent::actionAdd();
	}

	function actionRight(){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-01"),
			'dateTo' => date("Y-m-d"),
			// 'supplierId' => '', 
			'key' => '',
		)); 
		$sql = "select 
			y.rukuCode,
			y.kuwei,
			y.rukuDate,
			y.supplierId,
			y.memo as rukuMemo,
			y.kind,
			y.orderId,
			y.songhuoCode,
			x.id,
			x.pihao,
			x.rukuId,
			x.productId,
			x.cnt,
			x.danjia,
			x.money,
			x.memo,
			x.cntJian,
			x.cntM,
			b.proCode,
			b.proName,
			b.guige,
			b.color,
			b.kind as proKind,
			t.orderCode,
			a.compName as compName
			from cangku_common_ruku y
			left join trade_order t on y.orderId=t.id
			left join cangku_common_ruku2product x on y.id=x.rukuId
			left join jichu_supplier a on y.supplierId=a.id
			left join jichu_product b on x.productId=b.id
			where y.kind='{$this->_kind}'
			";
		$sql .= " and rukuDate >= '{$serachArea['dateFrom']}' and rukuDate<='{$serachArea['dateTo']}'";
		if ($serachArea['key'] != '') $sql .= " and (b.proName like '%{$serachArea['key']}%'
											or b.proCode like '%{$serachArea['key']}%'
											or b.guige like '%{$serachArea['key']}%')"; 
		if ($serachArea['rukuCode'] != '') $sql .= " and y.rukuCode like '%{$serachArea['rukuCode']}%'";
		if ($serachArea['supplierId'] != '') $sql .= " and y.supplierId = '{$serachArea['supplierId']}'"; 
		$sql .= " order by y.rukuCode desc";
		//得到总计
		$zongji = $this->getZongji($sql,array('cnt'=>'x.cnt','money'=>'x.money'));
        //dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		//dump($rowset);die;
		if (count($rowset) > 0) foreach($rowset as &$value) {
			$value['_edit'] = "<a href='" . $this->_url('View', array('id' => $value['rukuId'])) . "' target='_blank' title='$title'>打印</a>";
			//$tip = "ext:qtip='已过账禁止修改'";
			if($value['kind']=='采购退货') {
				$value['_edit'] .= " <a href='".url('Cangku_Yuanliao_Cgth','Edit',array(
					'id'=>$value['rukuId'],
					'fromAction' => $_GET['action']
				))."'>修改</a>";
			} elseif($value['kind']=='生产入库') {
				$value['_edit'] .= " <a href='".url('Cangku_Chengpin_Ruku','Edit',array(
					'id'=>$value['rukuId'],
					'fromAction' => $_GET['action']
				))."'>修改</a>";
				// 设置码单
				// 查找是否存在码单
				// $sql="select id from cangku_madan where ruku2proId='{$value['id']}' limit 0,1";
				// $temp=$this->_modelExample->findBySql($sql);
				// $color='';
				// $title='';
				// if($temp[0]['id']>0){
				// 	$color="green";
				// 	$title="码单已设置";
				// }
				// $value['_edit'] .=" <a style='color:{$color}' href='".url('Cangku_Chengpin_Ruku','SetMadan',array('ruku2proId'=>$value['id']))."' title='{$title}'>码单</a>";				
			} elseif($value['kind']=='成品初始化') {
				$value['_edit'] .= " <a href='".url('Cangku_Chengpin_RukuInit','Edit',array(
					'id'=>$value['rukuId'],
					'fromAction' => $_GET['action']
				))."'>修改</a>";				
			} else {
				$value['_edit'] .= " <a href='".url('Cangku_Yuanliao_Ruku','Edit',array(
					'id'=>$value['rukuId'],
					'fromAction' => $_GET['action']
				))."'>修改</a>";				
			}
			$value['_edit'] .= " ".$this->getRemoveHtml($value['rukuId']);
            
            //码单导出
            if($value['kind']=='生产入库'){
            	$sql="select id from cangku_madan where ruku2proId='{$value['id']}' limit 0,1";
				$temp=$this->_modelExample->findBySql($sql);
				$color='';
				$title='';
				if($temp[0]['id']>0){
					//有码单入库信息
					$value['_edit'] .=" <a style='color:{$color}' href='".url('Cangku_Chengpin_Madan','SelexportRuku',array('id'=>$value['id']))."' target='_blank' title='{$title}'>码单导出</a>";
				}
					
            }



			if($value['cnt']<0) $value['_bgColor'] = 'pink';
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), '_edit');
		$rowset[] = $heji; 
		// 左边信息
		$arrFieldInfo = array(			
			'_edit'=>array("text"=>'操作','width'=>170),
			// 'id'=>'从表id',
			// 'rukuId'=>'主表id',
			"rukuDate" => "入库日期",
			"kind" => "类别",
			'kuwei' => '库位',
			// 'state' => '状态',
			'orderCode' => '生产编码',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'cntJian' => '件数',
			'cnt' => '数量', 
			'danjia' => '单价', 
			'money' => '金额', 
			// "compName" => "供应商",
			'songhuoCode' => '送货单号',
			'rukuCode' => array("text"=>'入库单号','width'=>150),
			'memo' => '备注'
	    );
		// array_unshift($arrFieldInfo,);
		// dump($arrFieldInfo);exit;
		

		$smarty = &$this->_getView();
		$smarty->assign('title', '订单查询'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', $isShowAdd?'display':'none');
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('arr_field_value', $rowset);
		$msg = "<font color='red'>数量总计:{$zongji['cnt']},金额总计:{$zongji['money']}</font>";
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea).$msg);
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$this->_beforeDisplayRight($smarty);
		$smarty->display('TableList.tpl'); 
		// $smarty->display('TblListMore.tpl');
	}

	// /**
	//  * 添加码单信息
	//  * Time：2014/06/25 15:30:23
	//  * @author li
	// */
	// function actionSetMadan(){
	// 	//$this->authCheck();
	// 	$_GET['ruku2proId']=(int)$_GET['ruku2proId'];
	// 	//查找所有已设置的码单信息
	// 	$madan = & FLEA::getSingleton('Model_Cangku_Chengpin_Madan');
	// 	$madan->clearLinks();
	// 	//查找所有码单
	// 	$madanArr = $madan->findAll(array('ruku2proId'=>$_GET['ruku2proId']));
	// 	$temp=array();
	// 	foreach ($madanArr as $key => & $v) {
	// 		//标示已出库的
	// 		if($v['chuku2proId']>0)$v['readonly']=true;
	// 		$temp[$v['number']-1]=$v;
	// 	}
	// 	$madanArr=$temp;
	// 	//dump($madanArr);exit;
 //        // dump(json_encode($madanArr));exit;
	// 	$smarty = & $this->_getView();
	// 	$smarty->assign('title', "设置码单");
	// 	$smarty->assign('ruku2proId', $_GET['ruku2proId']);
	// 	$smarty->assign('madanRows', json_encode($madanArr));
	// 	$smarty->assign('arr_field_value', $madanArr[0]);
	// 	$smarty->display("Cangku/Chengpin/RkDajuanEdit.tpl");
	// }

	/**
	 * 保存码单信息
	 * Time：2014/06/25 17:15:18
	 * @author li
	*/
	function actionSaveMadanByAjax(){
		// dump($_POST);exit;
		$_P = json_decode($_POST['jsonStr'],true);
		// dump($_P);
		$madan_arr = array();//需要保存的码单信息
		$madan_clear = array();//需要删除的码单信息

		foreach ($_P as $key => & $v) {
			//数量不存在，说明该码单不需要保存
			if(empty($v['cntFormat']) && empty($v['cnt_M'])&&empty($v['cntMadan'])){
				//如果id存在，则说明该码单需要在数据表中删除
				if($v['id']>0){
					$madan_clear[]=$v['id'];
				}
				continue;
			}
			//入库明细表id
			$madan_arr[]=array(
				'id'=>$v['id']+0,
				'ruku2proId'=>$_POST['ruku2proId'],
				'number'=>$v['number'],
				'cntFormat'=>$v['cntFormat'],
				'cnt'=>$v['cnt'],
				'cntM'=>$v['cntM'],
				'cnt_M'=>$v['cnt_M'],
				'cntMadan'=>$v['cntMadan'],
				'lot'=>$v['lot'].'',
				'menfu'=>$_POST['menfu'],
				'kezhong'=>$_POST['kezhong'],
			);
		}
		// dump($madan_arr);

		// //如果码单信息存在，则保存
		// if(count($madan_arr)>0){
		// 	$madan = & FLEA::getSingleton('Model_Cangku_Chengpin_Madan');
		// 	$madan->saveRowset($madan_arr);
		// }
		// //处理需要清空的数据
		// $strSonId=join(',',$madan_clear);
		// if($strSonId!=''){
		// 	$sql="delete from cangku_madan where id in ({$strSonId})";
		// 	$this->_subModel->execute($sql);
		// }
		
		//
		echo json_encode(array(
			'success'=>true,
			'msg'=>'操作完成',
			'madan'=>$madan_arr,
		));exit;

	}
    
	/**
	 * 删除码单信息
	 * Time：2014/06/25 17:15:18
	 * @author li
	 */
	function actionRemoveMadanByAjax(){
		$madan = &FLEA::getSingleton('Model_Cangku_Chengpin_Madan');
		if($madan->removeByPkv($_POST['id'])){
			echo json_encode(array(
					'state'=>1
			));
		}else{
			echo json_encode(array(
					'state'=>0
			));
		}
	}
    function actionSetMadan(){
    	//dump($_GET);die;
    	//$this->authCheck();
		$_GET['ruku2proId']=(int)$_GET['ruku2proId'];
		//查找所有已设置的码单信息
		$madan = & FLEA::getSingleton('Model_Cangku_Chengpin_Madan');
		$madan->clearLinks();
		//查找所有码单
		$madanArr = $madan->findAll(array('ruku2proId'=>$_GET['ruku2proId']));
		$temp=array();
		foreach ($madanArr as $key => & $v) {
			//标示已出库的
			if($v['chuku2proId']>0)$v['readonly']=true;
			$temp[$v['number']-1]=$v;
		}
		$madanArr=$temp;

		// dump($madanArr);exit;
        // dump(json_encode($madanArr));exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', "设置码单");
		$smarty->assign('ruku2proId', $_GET['ruku2proId']);
		$smarty->assign('madanRows', json_encode($madanArr));
		$smarty->assign('arr_field_value', $madanArr[0]);
		$smarty->display("Cangku/Chengpin/RkDajuanEdit.tpl");
    }
 
    function actionSave(){
         //dump($_POST);exit;	
		//根据headSon,动态组成明细表数据集
		$cangku_common_ruku2product = array();
		foreach ($_POST['productId'] as $key => $v) {
			// 当没有记录 或者 没有输入数量时 跳出本次循环 防止多保存
			if (empty($_POST['productId'][$key]) || empty($_POST['cnt'][$key])) continue;
			$temp = array();
			$madan=array();
			foreach($this->headSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$key];
				if($k=='Madan'){
					//将Madan json_decode
					$madan=json_decode($_POST[$k][$key]);
					// dump($madan);exit;
					//stdClass Object转array 函数
                    $madan=$this->object_array($madan);
                    foreach ($madan as $kk => &$value) {
                    	//删除码单中没有输入公斤数的数组，防止多保存
						if($value['cntFormat']==Null||$value['cntFormat']==''){
							unset($madan[$kk]);
						}
					}
					// dump($madan);exit;
				}

			}
			//dump($madan);exit;
			$cangku_common_ruku2product[$key] = $temp;
			//明显表与码单表关联
			$cangku_common_ruku2product[$key]['Madan'] = $madan;
		} 
		foreach ($cangku_common_ruku2product as $k=>$v){
			if(!isset($v['productId'])) unset($cangku_common_ruku2product[$k]);
		}
		//如果没有选择物料，返回
		if(count($cangku_common_ruku2product)==0) {
			js_alert('请选择有效物料并输入有效数量!','window.history.go(-1)');
			exit;
		}
		// cangku_common_ruku 表 的数组
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$cangku_common_ruku[$k] = $_POST[$name];
		}


		// 表之间的关联
		$cangku_common_ruku['Products'] = $cangku_common_ruku2product; 
		// dump($cangku_common_ruku2product);exit;
		// dump($cangku_common_ruku);exit;
		// 保存 并返回cangku_common_ruku表的主键
		$itemId = $this->_modelExample->save($this->notNull($cangku_common_ruku));
		if (!$itemId) {
			echo "保存失败";
			exit;			
		}
		js_alert(null, 'window.parent.showMsg("保存成功!")', url($_POST['fromController'],$_POST['fromAction']));

    }

     function actionEdit() {
		$arr = $this->_modelMain->find(array('id' => $_GET['id']));
		// dump($arr);exit;
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value']; 
		}

		//设置rukuId的值
		$this->fldMain['id']['value'] = $arr['id'];

		// //加载库位信息的值
		$areaMain = array('title' => '入库基本信息', 'fld' => $this->fldMain); 

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelDefault->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			$v['color'] = $_temp[0]['color'];
			$sql2="select * from cangku_madan where ruku2proId='{$v['id']}'";
			$_temp2 = $this->_modelDefault->findBySql($sql2);//dump($_temp2);exit;
            $v['Madan']=json_encode($_temp2);
		} 
		// dump($arr['Products']);exit;
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			// dump($v);exit;
			//定义弹出选择控件的text属性为proCode
			$temp['productId']['text'] = $v['proCode'];
			$rowsSon[] = $temp;
		}
		// dump($rowsSon);exit;
		//补齐5行
		$cnt = count($rowsSon);
		for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}

		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', 'Cangku/Chengpin/jsRuku.tpl');
		$this->_beforeDisplayEdit($smarty);
		// dump($smarty);dump(get_class_vars($smarty));dump(get_class_methods($smarty));exit;
		$smarty->display('Main2Son/T1.tpl');
	}
}
?>