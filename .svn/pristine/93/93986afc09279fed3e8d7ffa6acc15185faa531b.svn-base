<?php
FLEA::loadClass('Tmis_Controller');
class Controller_Caiwu_Ys_Guozhang extends Tmis_Controller {
	var $_tplEdit = 'Caiwu/Ys/GuozhangEdit.tpl';
    function __construct() {
        $this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Ys_Guozhang');
        $this->_modelChukuProduct = & FLEA::getSingleton('Model_Cangku_Chuku2Product');
        
        //搭建过账界面
        $this->fldMain = array(
			'guozhangDate' => array('title' => '过账日期', "type" => "calendar", 'value' => date('Y-m-d')),
			// 'btnRukuYuanliao' => array('title' => '选择入库', 'type' => 'BtnRukuYuanliao', 'value' => ''),
			'chuku2proId' => array(
				'title' => '选择出库', 
				'type' => 'popup', 
				'value' => '',
				'name'=>'chuku2proId',
				'text'=>'选择出库',
				'url'=>url('Cangku_Chuku','PopupOnGuozhang'),
				'jsTpl'=>'Caiwu/Ys/jsGuozhang.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
				'onSelFunc'=>'onSelChuku',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'chukuCode',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
			),
			'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
			// 'proName' => array('title' => '品名', 'type' => 'text', 'value' => '','readonly'=>true),
			// 'guige' => array('title' => '规格', 'type' => 'text', 'value' => '','readonly'=>true),
			'qitaMemo' => array('title' => '描述', 'type' => 'text', 'value' => '','readonly'=>true),
			// 'kuweiName' => array('title' => '库位', 'type' => 'text', 'value' => '','readonly'=>true),
			'chukuDate' => array('title' => '出库日期', 'type' => 'text', 'value' => '','readonly'=>true),
			'cnt' => array('title' => '折合公斤数', 'type' => 'text', 'value' => '','readonly'=>true,'addonEnd'=>'kg'),
			// 'unit'=>array('type'=>'select','title'=>'单位','name'=>'unit','options'=>array(
			// 	array('text'=>'公斤','value'=>'公斤'),
			// 	array('text'=>'米','value'=>'米'),
			// 	array('text'=>'码','value'=>'码'),
			// 	array('text'=>'磅','value'=>'磅'),
			// 	array('text'=>'条','value'=>'条'),
			// 	)), 
			'danjia' => array('title' => '单价', 'type' => 'text', 'value' => '','addonEnd'=>'元/kg'),
			'money' => array('title' => '应收金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'bizhong' => array('title' => '币种', 'type' => 'select', 'value' => 'RMB', 'options' => array(
					array('text' => 'RMB', 'value' => 'RMB'),
					array('text' => 'USD', 'value' => 'USD'),
					)),
			'huilv' => array('title' => '汇率', 'type' => 'text', 'value' => '1'),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
			'kind' => array('type' => 'hidden', 'value' => ''),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'chukuId' => array('type' => 'hidden', 'value' => ''),
			'orderId' => array('type' => 'hidden', 'value' => ''),
			'ord2proId' => array('type' => 'hidden', 'value' => ''),
		);

		// 表单元素的验证规则定义
		$this->rules = array(
			'guozhangDate' => 'required',
			'clientId' => 'required',
			'money' => 'required number'
		);
    }

    function actionRight() {
		// $this->authCheck('4-2-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'orderCode'=>'',
			'proName'=>'',
			'guigeDesc'=>'',
			'orderId'=>'',
			'no_edit'=>'',
			'no_time'=>'',
		));
		$sql="SELECT x.*,z.compName,y.orderCode,b.guige as guigeDesc,b.proName
			from caiwu_ar_guozhang x 
			left join trade_order y on x.orderId=y.id
			left join trade_order2product a on a.id=x.ord2proId
			left join jichu_client z on z.id=x.clientId
			left join jichu_product b on b.id=x.productId
			where 1";
		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['no_time']!=''){
			$arr['dateFrom']='';
			$arr['dateTo']='';
		}

		$sql.=" and guozhangDate >='{$arr['dateFrom']}' and guozhangDate<='{$arr['dateTo']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		if ($arr['guigeDesc'] != '')$sql.=" and b.guige like '%{$arr['guigeDesc']}%'";
		if ($arr['proName'] != '') $sql.=" and b.proName like '%{$arr['proName']}%'";
		$sql.=" order by guozhangDate desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		// dump($pager);exit;
		$rowset = $pager->findAll(); 
		foreach($rowset as & $v) {
			$v['_edit']= "<a href='".$this->_url('Edit',array(
				'id'=>$v['id']
			))."' title='过账编辑'>修改</a>". '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);

			//核销的情况下不能修改删除
			if($v['moneyYishou']>0 || $v['moneyFapiao']>0)$v['_edit']="<span title='已核销，禁止操作'>修改&nbsp;&nbsp;删除</span>";

			$v['money']=round($v['money'],2);

			//折合人民币
			$v['moneyRmb']=round($v['money']*$v['huilv'],2);
		}
		$rowset[] = $this->getHeji($rowset, array('cnt','money','moneyRmb'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			"_edit"=>'操作',
			"compName"=>'客户',
			"guozhangDate"=>'日期',
			"orderCode"=>'订单编号',
			// "product"=>$this->getManuCodeName(),
			// "guigeDesc"=>'规格',
			// "proName"=>array('text'=>'品名','width'=>100),
			"qitaMemo"=>array('text'=>'描述','width'=>160),
			// 'kuweiName'=>'库位',
			"cnt"=>array('text'=>'数量','width'=>70),
			"danjia"=>array('text'=>'单价','width'=>70),
			"money"=>array('text'=>'应收金额','width'=>70),
			'moneyRmb'=>'金额(RMB)',
			"bizhong"=>array('text'=>'币种','width'=>70),
			"huilv"=>array('text'=>'汇率','width'=>70),
			"memo"=>"备注",
			"creater"=>"制单人",
		);
  
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action']),$arr));
		$smarty->display($tpl);
	}

	//已收款查询，对账单中编辑的信息
	function actionRightYis() {
		// $this->authCheck('4-2-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			// 'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			// 'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'orderCode'=>'',
			'product'=>'',
			'guige'=>'',
			'orderId'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,z.compName,y.orderCode from caiwu_ar_guozhang x 
			left join trade_order y on x.orderId=y.id
			left join trade_order2product a on a.id=x.ord2proId
			left join jichu_client z on z.id=x.clientId
			where 1";
		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		$sql.=" order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		foreach($rowset as & $v) {
			// $v['_edit']= $this->getEditHtml(array(
			// 	'id'=>$v['id'],
			// 	'fromAction'=>$_GET['action']
			// 	)) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);

			// $v['money']=round($v['money'],2);

			//折合人民币
			$v['moneyRmb']=round($v['money']*$v['huilv'],2);
			$v['moneyRmb2']=round($v['moneyYishou']*$v['huilv'],2);
		}
		$rowset[] = $this->getHeji($rowset, array('moneyRmb2','money','moneyRmb'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			// "_edit"=>'操作',
			"compName"=>'客户',
			"guozhangDate"=>'日期',
			"orderCode"=>'生产编号',
			"product"=>$this->getManuCodeName(),
			"guige"=>'规格',
			// "unit"=>array('text'=>'单位','width'=>70),
			// "cnt"=>array('text'=>'数量','width'=>70),
			// "danjia"=>array('text'=>'单价','width'=>70),
			// "money"=>array('text'=>'应收金额','width'=>70),
			'moneyRmb'=>'金额(RMB)',
			'moneyRmb2'=>'已收金额(RMB)',
			// "bizhong"=>array('text'=>'币种','width'=>70),
			// "huilv"=>array('text'=>'汇率','width'=>70),
			"memo"=>"备注",
			// "creater"=>"制单人",
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}

	

	function actionSave(){
		//dump($_POST);exit;
		$arr=array(
			'id'=>$_POST['id'],
			'clientId'=>$_POST['clientId'],
			'guozhangDate'=>$_POST['guozhangDate'],
			'orderId'=>$_POST['orderId'],
			'ord2proId'=>$_POST['ord2proId'],
			'chukuId'=>$_POST['chukuId'],
			'chuku2proId'=>$_POST['chuku2proId'],
			'productId'=>$_POST['productId'],
			'qitaMemo'=>$_POST['qitaMemo'],
			'chukuDate'=>$_POST['chukuDate'],
			'unit'=>$_POST['unit'].'',
			'cnt'=>$_POST['cnt'],
			'kind'=>$_POST['kind'],
			'danjia'=>$_POST['danjia'],
			'money'=>$_POST['money'],
			'memo'=>$_POST['memo'],
			'creater'=>$_POST['creater'],
			'memo'=>$_POST['memo'],
			'bizhong'=>$_POST['bizhong']?$_POST['bizhong']:'RMB',
			'huilv'=>empty($_POST['huilv'])?1:$_POST['huilv'],
		);
		// dump($arr);exit;
		$id=$this->_modelExample->save($arr);
		$guozhangId=$_POST['id']>0?$_POST['id']:$id;
		//改变入库表中的过账id
		// if($_POST['chuku2proId']){
		// 	$arr_rk=array(
		// 		'id'=>$_POST['chuku2proId'],
		// 		'guozhangId'=>$guozhangId,
		// 	);
		// 	$this->_modelChukuProduct->update($arr_rk);
		// 	// dump($arr_rk);exit;
		// }
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($_POST['id']>0?'right':'add'));
	}

	
	
	//应付款报表
	function actionReport(){
		//$this->authCheck('4-2-7');
		$tpl = $_GET['print']?'Print.tpl':'TblList.tpl';
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'traderId'=>'',
		));
		//得到期初发生
		//应付款表中查找,日期为期初日期
		//按照加工商汇总
		$sql="select sum(a.money*a.huilv) as fsMoney,a.clientId from caiwu_ar_guozhang a
		             left join jichu_client t on t.id=a.clientId  
		             where guozhangDate < '{$arr['dateFrom']}'";
		if($arr['clientId']!=''){
			$sql.=" and a.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']!=''){
			$sql.=" and t.traderId='{$arr['traderId']}'";
		}
		//用户对应的业务员
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
			//得到当前用户匹配的员工id
			$traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
			if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
				$sql .= " and 0";
			} else {
				$s = join(',',$traderIds);
				$sql .= " and t.traderId in ({$s})";
			}
		}
		$sql.=" group by clientId order by clientId";
		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as & $v){
			//期初金额
			$row[$v['clientId']]['initMoney']=$v['fsMoney']+0;//期初余额
			$row[$v['clientId']]['initIn']=$v['fsMoney']+0;
		}
		//得到起始日期前的收款金额
		//从付款表中查找
		//按照加工商汇总
		$sqlIncome = "SELECT sum(a.money*a.huilv) as shouKuanMoney,a.clientId FROM `caiwu_ar_income` a
		   left join jichu_client t on t.id=a.clientId                 
		                               where  shouhuiDate < '{$arr['dateFrom']}'";
		if($arr['clientId']!=''){
			$sqlIncome.=" and a.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']!=''){
			$sqlIncome.=" and t.traderId='{$arr['traderId']}'";
		}
		//用户对应的业务员
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
			//得到当前用户匹配的员工id
			$traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
			if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
				$sqlIncome .= " and 0";
			} else {
				$s = join(',',$traderIds);
				$sqlIncome .= " and t.traderId in ({$s})";
			}
		}
		$sqlIncome.=" group by clientId order by clientId";
		$rowset = $this->_modelExample->findBySql($sqlIncome);
		foreach($rowset as & $v){
			//期初金额
			$row[$v['clientId']]['initMoney']=round($row[$v['clientId']]['initMoney']-$v['shouKuanMoney']+0,2);//期初余额=期初发生-期初已付款
			$row[$v['clientId']]['initOut']=round($v['shouKuanMoney'],2);
		}
		
		//得到本期的已收款
		//付款表中查找
		//按照客户汇总
		$str="SELECT sum(a.money*a.huilv) as moneySk,a.clientId from caiwu_ar_income a 
		 left join jichu_client t on t.id=a.clientId  
		where 1 ";
		if($arr['dateFrom']!=''){
			$str.=" and shouhuiDate>='{$arr['dateFrom']}' and shouhuiDate<='{$arr['dateTo']}'";
		}
		if($arr['clientId']!=''){
			$str.=" and a.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']!=''){
			$str.=" and t.traderId='{$arr['traderId']}'";
		}
		//用户对应的业务员
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
			//得到当前用户匹配的员工id
			$traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
			if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
				$str .= " and 0";
			} else {
				$s = join(',',$traderIds);
				$str .= " and t.traderId in ({$s})";
			}
		}
		$str.=" group by clientId order by clientId";
		//echo $str;exit;
		$fukuan=$this->_modelExample->findBySql($str);
		foreach($fukuan as & $v1){
			$row[$v1['clientId']]['moneySk']=round(($v1['moneySk']+0),2);
		}

		//得到本期发生
		//应付款表中查找
		//按照客户汇总
		$sql="select sum(a.money*a.huilv) as fsMoney,a.clientId ,a.id from caiwu_ar_guozhang a
		 left join jichu_client t on t.id=a.clientId  
		where 1";
		if($arr['dateFrom']!=''){
			$sql.=" and guozhangDate>='{$arr['dateFrom']}' and guozhangDate<='{$arr['dateTo']}'";
		}
		if($arr['clientId']!=''){
			$sql.=" and a.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']!=''){
			$sql.=" and t.traderId='{$arr['traderId']}'";
		}

		//用户对应的业务员
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
			//得到当前用户匹配的员工id
			$traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
			if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
				$sql .= " and 0";
			} else {
				$s = join(',',$traderIds);
				$sql .= " and t.traderId in ({$s})";
			}
		}
		$sql.=" group by clientId order by clientId";
		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as & $v2){
			$row[$v2['clientId']]['fsMoney']=round(($v2['fsMoney']+0),2);
		}

		//得到本期发票
		$str1="SELECT sum(a.money*a.huilv) as faPiaoMoney,a.clientId FROM `caiwu_ar_fapiao` a 
		 left join jichu_client t on t.id=a.clientId  
		where 1";
		if($arr['dateFrom']!=''){
			$str1.=" and fapiaoDate>='{$arr['dateFrom']}' and fapiaoDate<='{$arr['dateTo']}'";
		}
		if($arr['clientId']!=''){
			$str1.=" and a.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']!=''){
			$str1.=" and t.traderId='{$arr['traderId']}'";
		}
		//用户对应的业务员
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
			//得到当前用户匹配的员工id
			$traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
			if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
				$str1 .= " and 0";
			} else {
				$s = join(',',$traderIds);
				$str1 .= " and t.traderId in ({$s})";
			}
		}
		$str1.=" group by clientId order by clientId";
		$fukuan=$this->_modelExample->findBySql($str1);
		foreach ($fukuan as $v2){
			$row[$v2['clientId']]['faPiaoMoney']=$v2['faPiaoMoney']+0;
		}
		$mClient=& FLEA::getSingleton('Model_jichu_client');
		if(count($row)>0){
			foreach($row as $key => & $v){
				$c=$mClient->find(array('id'=>$key));
				$v['clientId']=$key;
				$v['compName']=$c['compName'];
				// $v['weishouMoney']=round($v['initMoney'],2)+round($v['fsMoney'],2)-round($v['moneySk'],2);
				$v['weishouMoney']=$v['initMoney']+$v['fsMoney']-$v['moneySk'];
				$v['weishouMoney']=round($v['weishouMoney'],2);
			}
		}
		// dump($row);exit;
		$heji=$this->getHeji($row,array('initMoney','fsMoney','moneySk','weishouMoney','faPiaoMoney'),'compName');
		foreach($row as $key=>& $v){
			$v['moneySk']="<a href='".url('caiwu_ys_Income','right',array(
						'clientId'=>$v['clientId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='收款明细'>".$v['moneySk']."</a>";
			$v['faPiaoMoney']="<a href='".url('caiwu_ys_fapiao','right',array(
						'clientId'=>$v['clientId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='开票明细'>".$v['faPiaoMoney']."</a>";
			$v['fsMoney']="<a href='".url('caiwu_ys_guozhang','right',array(
						'clientId'=>$v['clientId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='应收明细'>".$v['fsMoney']."</a>";

			//查看对账单
			$v['duizhang']="<a href='".$this->_url('Duizhang',array(
					'dateFrom'=>$arr['dateFrom'],
					'dateTo'=>$arr['dateTo'],
					'clientId'=>$v['clientId'],
					'no_edit'=>1,
			))."' target='_blank'>查看</a>";

		}
		$row[]=$heji;
		// dump($row);exit;
		
		$arrFiled=array(
			'compName'=>array('text'=>"客户",'width'=>'200'),
			"initMoney" =>"期初余额",
			"fsMoney" =>"本期发生",
			"moneySk" =>"本期收款",
			"weishouMoney" =>"本期未收款",
			"faPiaoMoney" =>"本期开票",
			'duizhang'=>'对账单',
		);
		if($_GET['print']){
			unset($arrFiled['duizhang']);
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrFiled);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_value',$row);
		$smarty->assign('heji',$heji);
		$smarty->assign('print_href',$this->_url($_GET['action'],array(
			'print'=>1
		)));
		$smarty->assign('title','应收款报表');
		if($_GET['print']) {
			//设置账期显示
			$smarty->assign('arr_main_value',array(
				'账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo'],
				'注'=>'金额已折合人民币',
			));
		}
		$smarty->assign('page_info',"<font color='green'>金额已折合人民币</font>");
		$smarty->display($tpl);
	}

	//对账单
	function actionDuizhang(){
		// dump($_GET);exit;
		$arr=$_GET;
		if(empty($arr['clientId'])){
			echo "缺少客户信息";exit;
		}
		//查找对账单客户
		$mClient=& FLEA::getSingleton('Model_jichu_client');
		$jgh=$mClient->find($arr['clientId']);
		// 对账单设计格式
		//查找期初欠款的情况
		//期初发生
		$sql="select sum(money) as money from caiwu_ar_guozhang where guozhangDate < '{$arr['dateFrom']}' and clientId='{$arr['clientId']}'";
		$res1=mysql_fetch_assoc(mysql_query($sql));
		//期初付款
		$sql="select sum(money) as money from caiwu_ar_income where shouhuiDate < '{$arr['dateFrom']}' and clientId='{$arr['clientId']}'";
		$res2=mysql_fetch_assoc(mysql_query($sql));
		$row['money']=$res1['money']-$res2['money'];
		$row['guozhangDate']="<b>期初余额</b>";

		//本期应付款对账信息
		//查找应付款信息
		$sql="select x.*,y.orderCode,z.cntYaohuo,y.clientOrder,z.unit as unitYaohuo from caiwu_ar_guozhang x
			left join trade_order y on x.orderId=y.id
			left join trade_order2product z on z.id=x.ord2proId
			where 1";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.guozhangDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.guozhangDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by guozhangDate";
		$rows = $this->_modelExample->findBySql($sql);
		
		//查找已收款信息
		$sql="select x.money*x.huilv as shouhuimoney,x.shouhuiDate as guozhangDate,x.memo from caiwu_ar_income x where 1 ";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.shouhuiDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.shouhuiDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by shouhuiDate";
		$rows2 = $this->_modelExample->findBySql($sql);
		//合并应收款与已收款明细信息
		$rows=array_merge($rows,$rows2);
		//按照日期排序
		$rows=array_column_sort($rows,'guozhangDate',SORT_ASC);
		// dump($sql);exit;
		//处理数据
		// dump($rows);exit;
		foreach($rows as  & $v){
			$v['shouhuimoney']=$v['shouhuimoney']==0?'':round($v['shouhuimoney'],2);
			$v['money']=$v['money']==0?'':round($v['money'],2);
			$v['moneyRmb']=$v['money']==0?'':round($v['money']*$v['huilv'],2);
			$v['moneyJieyu']=round(($v['money']*$v['huilv']-$v['shouhuimoney']),2);			
			if(!empty($v['cntYaohuo']))$v['cntYaohuo']=round($v['cntYaohuo'],2).$v['unitYaohuo'];
			if(!empty($v['cnt']))$v['cnt']=round($v['cnt'],2).$v['unit'];		
		}
		//合并数组
		$rowset=array_merge(array($row),$rows);
		// else $rowset=$rows;

		$heji = $this->getHeji($rowset, array('moneyRmb','shouhuimoney'), 'money');
		$rowset[]=$heji;
		
		$arr_field_info=array(
			'guozhangDate'=>'日期',
			'orderCode'=>'订单编号',
			'clientOrder'=>'客户合同号',
			// 'proName'=>'品名',
			// 'guigeDesc'=>'规格',
			'qitaMemo'=>'描述',
			'chukuDate'=>'出库日期',
			'cntYaohuo'=>'要货数',
			'cnt'=>'出库数',
			'bizhong'=>'币种',
			'danjia'=>'单价',
			'money'=>'应收金额',
			'moneyRmb'=>'应收(RMB)',
			'shouhuimoney'=>'已收(RMB)',
			'moneyJieyu'=>'结余',
			'memo'=>'备注',
		);
		$smarty=& $this->_getView();
		$smarty->assign('title',"{$jgh['compName']}对账单");
		$smarty->assign('arr_main_value',array('账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo']));
		$smarty->assign('arr_condition',$arr);
		if($_GET['no_edit']!=1){
			$smarty->assign('sonTpl',"caiwu/ys/sonTpl.tpl");
		}
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->display('printOld.tpl');
	}


	//删除
	function actionRemove(){
		//去掉入库信息中的guozhangid
		// $temp=$this->_modelExample->find($_GET['id']);
		// // dump($temp);exit;
		// $sql="update cangku_chuku2product set guozhangId='0' where id='{$temp['chuku2proId']}'";
		// $this->_modelExample->execute($sql);

		parent::actionRemove();
	}

	function actionAdd() {
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('sonTpl', 'caiwu/ys/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));//dump($row);exit;
		//查找库位
		// $sql="select kuweiName from jichu_kuwei where id='{$row['kuweiId']}'";
		// $temp = $this->_modelExample->findBySql($sql);
		// $row['kuweiName']=$temp[0]['kuweiName'];

		// //查找产品
		// $row['proName']=$row['Product']['proName'];
		// $row['guige']=$row['Product']['guige'];
		// $row['clientName']=$row['Client']['compName'];

		$this->fldMain = $this->getValueFromRow($this->fldMain, $row); 
		//处理出库单号
		$mChuku = & FLEA::getSingleton('Model_Cangku_Chuku');
		$chuku = $mChuku->find(array('id'=>$row['chukuId']));
		$this->fldMain['chuku2proId']['text'] = $chuku['chukuCode'];
		$this->fldMain['clientId']['clientName']=$row['Client']['compName'];
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('aRow', $row);
		$smarty->assign('sonTpl', 'caiwu/ys/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}
	
}
?>