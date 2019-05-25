<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :Ruku.php
*  Time   :2014/05/13 18:31:40
*  Remark :采购入库控制器
\*********************************************************************/
FLEA::loadClass('Controller_Cangku_Ruku');
class Controller_Cangku_Yuanliao_Ruku extends Controller_Cangku_Ruku {
	// var $fldMain;
	// var $headSon;
	// var $rules;//表单元素的验证规则
	// **************************************构造函数 begin********************************
	function __construct() {
		$this->_state = '原料';
		$this->_head = 'CGRKA';
		// $this->_kind='采购入库';
		$this->_kind='采购入库';
		$this->_modelDefault = &FLEA::getSingleton('Model_Cangku_Yuanliao_Ruku');
		$this->_modelExample = &FLEA::getSingleton('Model_Cangku_Yuanliao_Ruku');
		// $this->_modelExample = &FLEA::getSingleton('Model_Cangku_Yuanliao_Ruku');
		// $this->_modelExample = &FLEA::getSingleton('Model_Cangku_Yuanliao_Ruku');
		$this->_modelMain = &FLEA::getSingleton('Model_Cangku_Yuanliao_Ruku');
		$this->_modelSon = &FLEA::getSingleton('Model_Cangku_Yuanliao_Ruku2Product');
		parent::__construct();

	}

	function actionAdd(){
		$this->authCheck('3-1-2');
		parent::actionAdd();
	}

	function actionRight(){
		$this->authCheck('3-1-3');
		// $this->authCheck('3-3');
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-01"),
			'dateTo' => date("Y-m-d"),
			'supplierId' => '', 
			'key' => '',
		));
		
        // dump($this->_kind);exit;
		$sql = "select 
			y.rukuCode,
			y.kuwei,
			y.rukuDate,
			y.supplierId,
			y.memo as rukuMemo,
			y.kind,
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
			a.compName as compName
			from cangku_common_ruku y
			left join cangku_common_ruku2product x on y.id=x.rukuId
			left join jichu_supplier a on y.supplierId=a.id
			left join jichu_product b on x.productId=b.id
			where y.kind in ('采购退货','采购入库')
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
       // dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
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
				//设置码单
				//查找是否存在码单
// 				$sql="select id from cangku_madan where ruku2proId='{$value['id']}' limit 0,1";
// 				$temp=$this->_modelExample->findBySql($sql);
// 				$color='';
// 				$title='';
// 				if($temp[0]['id']>0){
// 					$color="green";
// 					$title="码单已设置";
// 				}
// 				$value['_edit'] .=" <a style='color:{$color}' href='".url('Cangku_Chengpin_Ruku','SetMadan',array('ruku2proId'=>$value['id']))."' title='{$title}'>码单</a>";				
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
		$arrFieldInfo = array("_edit" => '操作')+$this->fldRight;
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
	
}