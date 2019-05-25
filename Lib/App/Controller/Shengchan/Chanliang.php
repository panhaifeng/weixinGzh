<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Chanliang extends Tmis_Controller {
	// **************************************构造函数 begin********************************
	function Controller_Shengchan_Chanliang() {
		$this->_modelDefault = &FLEA::getSingleton('Model_Shengchan_Chanliang');
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_Chanliang'); 
		// 定义模板中的主表字段
		$this->fldMain = array('chanliangDate' => array('title' => '产量日期', "type" => "calendar", 'value' => date('Y-m-d')),
			// 'ord2proId' => array('title' => '相关订单', "type" => "ord2propopup", 'value' => ''),
			'ord2proId' => array(
				'title' => '相关订单', 
				'type' => 'popup', 
				'value' => '',
				'name'=>'ord2proId',
				'text'=>'选择订单',
				'url'=>url('Shengchan_Chanliang','Popup'),//弹出地址,回调函数在sonTpl中进行定义,主要是对缓存中的关联数组进行重写
				// 'url'=>url('jichu_client','popup'),//弹出地址
				//'jsTpl'=>'Caiwu/Yf/jsGuozhang.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
				//'onSelFunc'=>'onSelRuku',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'orderCode',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
			),
			'proName' => array('title' => '品名', 'type' => 'text', 'value' => '','readonly'=>true),
			'guige' => array('title' => '规格', 'type' => 'text', 'value' => '','readonly'=>true),
			'menfu'=>array('title' => '门幅', 'type' => 'text', 'value' => '','readonly'=>true),
			'kezhong'=>array('title' => '克重', 'type' => 'text', 'value' => '','readonly'=>true),
			'color' => array('title' => '颜色', 'type' => 'text', 'value' => '','readonly'=>true),
			'ganghao' => array('title' => '缸号', 'type' => 'text', 'value' => ''),
			'ban' => array('title' => '班别', 'type' => 'select', 'value' => '','options'=>array(
						array('text'=>'白班','value'=>'1'),
						array('text'=>'夜班','value'=>'0'),
			)),
			'workCode' => array('title' => '工号', 'type' => 'text', 'value' => ''),
			'jizhiId'=> array('title' => '机台号', 'type' => 'select', 'value' => '','model'=>'Model_Jichu_Zhiji'),
			'cnt' => array('title' => '数量', 'type' => 'text', 'value' => ''),
			'memo' => array('title' => '匹数', 'type' => 'textarea', 'value' => ''), 
			// 用来存放订单表id 与 产品id
			'orderId' => array('type' => 'hidden', 'value' => ''),
			'productId' => array('type' => 'hidden', 'value' => ''), 
			// 用来存放shengchan_chanliang表的 主键
			'id' => array('type' => 'hidden', 'value' => ''),
			); 
		// 表单元素的验证规则定义
		$this->rules = array(
			'ord2proId' => 'required',
			'workCode' => 'required',
			'cnt' => 'required',
			);
	}
	// **************************************构造函数 end******************************** 
	// ************************产量登记 begin*****************
	function actionListForAdd() {
		$this->authCheck('8-1');
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '产量基本信息');
		$smarty->assign('sonTpl', 'Shengchan/_chanliang.tpl');
		$smarty->display('Main/A1.tpl');
	}
	// ************************产量登记 end*****************
	// *********************产量查询 begin********************
	function actionRight() {
		$this->authCheck('8-2');
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
				'dateTo' => date("Y-m-d"), 
				// 'supplierId' => '',
				// 'traderId' => '',
				'orderCode' => '',
				'key' => '',
				));
		$sql = "select x.id,
                   x.orderId,
                   x.ord2proId,
                   x.productId,
                   x.chanliangDate,
                   x.workCode,
                   x.cnt,
                   x.jizhiId,
                   x.ganghao,
                   x.memo,
                   y.proCode,
                   y.proName,
                   y.guige,
                   y.color
                   from shengchan_chanliang x
                   left join jichu_product y on x.productId= y.id";

		$str = "select  x.id,
                      x.orderId,
                      x.ord2proId,
                      x.chanliangDate,
                      x.workCode,
                      x.cnt,
                      x.proCode,
                      x.proName,
                      x.guige,
                      x.color,
                      x.ganghao,
                      x.memo,
                      y.orderCode,
                      z.cntYaohuo,
                      m.zhijiCode
                      from (" . $sql . ") x
                      left join trade_order2product z on x.ord2proId=z.id
                      left join trade_order y on z.orderId = y.id
                      left join jichu_zhiji m on x.jizhiId=m.id
                      where 1";

		$str .= " and chanliangDate >= '$serachArea[dateFrom]' and chanliangDate<='{$serachArea[dateTo]}'";
		if ($serachArea['key'] != '') $str .= " and (x.workCode like '%{$serachArea[key]}%' or x.guige like '%{$serachArea[key]}%' or x.ganghao like '%{$serachArea[key]}%' or x.color like '%{$serachArea[key]}%' or x.proCode like '%{$serachArea[key]}%' or x.proName like '%{$serachArea[key]}%')";
		if ($serachArea['orderCode'] != '') $str .= " and y.orderCode like '%{$serachArea[orderCode]}%'";

		$str .= " order by chanliangDate desc, orderCode desc"; 
		 // dump($str);exit;
        
        //得到总计
		$zongji = $this->getZongji($str,array('cnt'=>'x.cnt','memo'=>'x.memo'));

		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll(); 
		//dump($rowset);exit;
		$trade_order2product = &FLEA::getSingleton('Model_Trade_Order2Product'); 
		if (count($rowset) > 0) foreach($rowset as &$value) {
			//根据ord2proId来 获取orderCode (因为在产量登记中，没有保存orderId)
			$res=$trade_order2product->find(array('id'=>$value['ord2proId'])); 
			$value['orderCode']=$res['Order']['orderCode'];
			
			if ($value["guozhangId"]) {
				$tip = "ext:qtip='已过账禁止修改'";
				$value['_edit'] .= "<a href='javascript:void(0)' style='color:black' $tip>修改</a> | ";
				$value['_edit'] .= "<a $tip  >删除</a>";
			}else {
				$value['_edit'] .= "<a href='" . $this->_url('Edit', array('id' => $value['id'])) . "'>修改</a> | ";
				$value['_edit'] .= "<a href='" . $this->_url('Remove', array('id' => $value['id'])) . "'  onclick=\"return confirm('确认删除吗?')\" >删除</a> |";
			}
		} 
        
        // 合计行
		$heji = $this->getHeji($rowset, array('cnt','memo'), '_edit');//匹数合计
		$rowset[] = $heji;


		// 标题栏信息
		$arrFieldInfo = array("_edit" => '操作',
			"chanliangDate" => "产量日期",
			'orderCode' => '生产编号', 
			// "compName" =>"客户名称",
			// 'workCode'=>'工号',
			'proCode'=>'产品编码',
			'proName' => '品名',
			'guige' => '规格',
			"color" => '颜色',
			'ganghao'=>'缸号',
			"workCode" => '工号',
			'zhijiCode'=>'机台号',
			"cnt" => '数量', 
			//"bizhong" =>'币种',
			// "orderMemo" =>'订单备注',
			"memo" =>'匹数',
			);

		$smarty = &$this->_getView();
		$smarty->assign('title', '产量查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('arr_field_value', $rowset);
		$msg = "<font color='red'>数量总计:{$zongji['cnt']};匹数总计:{$zongji['memo']}</font>";
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea).$msg);
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$smarty->display('TableList.tpl');
	}
	// *********************产量查询 end********************
	// ********************编辑 begin********************
	function actionEdit() {
		//dump($_GET);exit;
		$arr = $this->_modelDefault->find(array('id' => $_GET['id'])); 
		//dump($arr);exit;
		// /加载数据到fldMain中
		$this->fldMain['chanliangDate']['value'] = $arr['chanliangDate'];
		$this->fldMain['workCode']['value'] = $arr['workCode'];
		$this->fldMain['cnt']['value'] = $arr['cnt'];
		$this->fldMain['memo']['value'] = $arr['memo'];

        //根据$arr['ord2proId'] 查找到orderCode
        $order2Product=&FLEA::getSingleton('Model_Trade_Order2Product');
        $res= $order2Product->find(array('id'=>$arr['ord2proId']));
		$this->fldMain['ord2proId']['text'] = $res['Order']['orderCode'];
        //必须添加，否则在修改时 会显示该字段没有填   会无法保存
		$this->fldMain['ord2proId']['value'] = $arr['ord2proId'];

		$this->fldMain['proName']['value'] = $arr['Products']['proName'];
		$this->fldMain['guige']['value'] = $arr['Products']['guige'];
		$this->fldMain['color']['value'] = $arr['Products']['color']; 
		$this->fldMain['menfu']['value'] = $arr['Products']['menfu'];
		$this->fldMain['kezhong']['value'] = $arr['Products']['kezhong'];
        $this->fldMain['jizhiId']['value'] = $arr['jizhiId']; 
        $this->fldMain['ganghao']['value'] = $arr['ganghao'];
        $this->fldMain['ban']['value'] = $arr['ban'];

		// 加载隐藏字段
		$this->fldMain['orderId']['value'] = $arr['orderId'];
		$this->fldMain['productId']['value'] = $arr['productId'];
		$this->fldMain['id']['value'] = $arr['id'];
        //dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '产量基本信息'); 
		$smarty->assign('sonTpl', 'Shengchan/_chanliang.tpl');
		$smarty->assign('rules', $this->rules);
		$smarty->display('Main/A.tpl');
	}
	// ********************编辑 end***********************
	// ********************保存 begin*****************
	function actionSave() {
		//dump($_POST);exit;
		$shengchan_chanliang = array('chanliangDate' => $_POST['chanliangDate'],
			'orderId' => $_POST['orderId'],
			'ord2proId' => $_POST['ord2proId'],
			'workCode' => $_POST['workCode'],
			'cnt' => $_POST['cnt'],
			'memo' => $_POST['memo'],
			'productId' => $_POST['productId'],
			'id' => $_POST['id'], 
			'jizhiId'=>$_POST['jizhiId'],
            'ganghao'=>$_POST['ganghao'],
			'ban'=>$_POST['ban'],
			// ''=>'',
			); 
		//dump($shengchan_chanliang);exit;
		$itemId = $this->_modelExample->save($shengchan_chanliang);
		if ($itemId) {
			if ($_POST['Submit'] == '保存并新增下一个') {
				js_alert('保存成功！', '', $this->_url('ListForAdd'));
			}else {
				js_alert('保存成功！', '', $this->_url('right'));
			}
		}else die('保存失败!');
	}
	// ********************保存 end*********************
	// *****************控件弹出 begin**********************
	function actionPopup() {
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
				'dateTo' => date("Y-m-d"),
				'key' => '',
				));

		$sql = "select y.clientId,
                     y.orderDate,
                     y.orderCode,
                     y.isCheck,
                     x.productId,
                     x.id,
                     x.cntYaohuo,
                     x.orderId as orderId
                     from trade_order2product x
                     left join trade_order y on (x.orderId = y.id)";

		$str = "select
        x.cntYaohuo,
        x.orderId,
        x.id,
        x.orderCode,
        x.orderDate,
        x.productId,
        x.isCheck,
        y.compName,
        z.proCode,
        z.proName,
        z.zhonglei,
        z.guige,
        z.color,
        z.menfu,
        z.kezhong
        from (" . $sql . ") x
        left join jichu_client y on x.clientId = y.id
        left join jichu_product z on x.productId = z.id
                where 1 ";

		$str .= " and orderDate >= '{$arr[dateFrom]}' and orderDate<='{$arr[dateTo]}'";
		if ($arr['key'] != '') $str .= " and (x.orderCode like '%{$arr[key]}%'
                      or z.proName like '%{$arr[key]}%'
                      or z.proCode like '%{$arr[key]}%'
                      or z.guige like '%{$arr[key]}%')";
        $str .="order by orderDate desc";
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str);
		// if(count($rowset)>0)foreach ($rowset as $i=> & $v ) {
		// }
		// dump($rowset);exit;
		// 标题栏信息
		$arrFieldInfo = array(
			"orderDate" => '订单日期',
			"orderCode" => '生产编号',
			// "compName" => "客户",
			'proCode' => '产品编码',
			'proName' => '品名',
			'zhonglei' => '种类',
			'guige' => '规格',
			'color' => '颜色',
			'cntYaohuo' => '要货数量', 
			// ''=>'',
			);

		$smarty = &$this->_getView();
		$smarty->assign('title', '订单选择');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url('Popup', $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}
	// ****************控件弹出 end************************
    
    //*产量统计报表
	function actionReport(){
        $this->authCheck('8-3');
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
				'dateTo' => date("Y-m-d"), 
				// 'supplierId' => '',
				'jizhi' => '',
				'orderCode' => '',
				'key' => '',
				));
		$sql = "select x.id,
                   x.ord2proId,
                   x.productId,
                   x.chanliangDate,
                   x.workCode,
                   x.cnt,
                   x.jizhiId,
                   x.ganghao,
                   x.memo,
                   y.proCode,
                   y.proName,
                   y.guige,
                   y.color,
                   t.orderId
                   from shengchan_chanliang x
                   left join jichu_product y on x.productId= y.id
                   left join trade_order2product t on x.ord2proId=t.id";

		$str = "select  x.id,
                      x.orderId,
                      x.ord2proId,
                      x.chanliangDate,
                      x.workCode,
                      x.cnt,
                      x.proCode,
                      x.proName,
                      x.guige,
                      x.color,
                      x.ganghao,
                      x.memo,
                      y.orderCode,
                      z.cntYaohuo,
                      m.zhijiCode
                      from (" . $sql . ") x
                      left join trade_order y on x.orderId = y.id
                      left join trade_order2product z on x.ord2proId=z.id
                      left join jichu_zhiji m on x.jizhiId=m.id
                      where 1";

		$str .= " and chanliangDate >= '$serachArea[dateFrom]' and chanliangDate<='{$serachArea[dateTo]}'";
		if ($serachArea['key'] != '') $str .= " and (x.workCode like '%{$serachArea[key]}%' or x.guige like '%{$serachArea[key]}%' or x.ganghao like '%{$serachArea[key]}%' or x.color like '%{$serachArea[key]}%' or x.proCode like '%{$serachArea[key]}%' or x.proName like '%{$serachArea[key]}%')";
        
        if ($serachArea['jizhi'] != '') $str .= " and x.jizhiId='{$serachArea[jizhi]}'";

        if($serachArea['orderCode'] != '') $str .= " and y.orderCode like '%{$serachArea[orderCode]}%'";

		$str .= " order by chanliangDate desc"; 
		//dump($str);exit;
        
        //得到总计
		$zongji = $this->getZongji($str,array('cnt'=>'x.cnt','memo'=>'x.memo'));

		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll(); 

        // 合计行
		$heji = $this->getHeji($rowset, array('cnt','memo'), 'chanliangDate');
		$rowset[] = $heji; 

		// 标题栏信息
		$arrFieldInfo = array(
			"chanliangDate" => "产量日期",
			'orderCode' => '生产编号', 
			// "compName" =>"客户名称",
			 'proCode'=>'产品编码',
			'proName' => '品名',
			'guige' => '规格',
			"color" => '颜色',
			'ganghao'=>'缸号',
			"workCode" => '工号',
			'zhijiCode'=>'机台号',
			"cnt" => '数量', 
			'memo'=>'匹数',
			//"bizhong" =>'币种',
			// "orderMemo" =>'订单备注',
			// "memo" =>'产品备注'
			);
        
		$smarty = &$this->_getView();
		$smarty->assign('title', '产量查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('arr_field_value', $rowset);
		
        $msg = "<font color='red'>数量总计:{$zongji['cnt']};匹数总计:{$zongji['memo']}</font>";
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea).$msg);

		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$smarty->display('TableList.tpl');
	}
	
	/*
	 * 订单日生产报表
	 */
	function actionDayReport(){
		
		FLEA::loadClass('TMIS_Pager');
		// /构造搜索区域的搜索类型
		$serachArea = TMIS_Pager::getParamArray(array(				
				'dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
				//'orderCode' => '',
				//'key' => '',
		));

		$sql="select x.id,x.cntYaohuo,x.dateJiaohuo,y.id orderId,x.productId,y.orderDate,y.orderCode,
			z.employName traderName,a.proName,a.guige,a.color,a.proCode
			from trade_order2product x
			left join trade_order y on x.orderId=y.id
			left join jichu_employ z on y.traderId=z.id
			left join jichu_product a on x.productId=a.id
			group by x.id";		
		$rowset =$this->_modelExample->findBySql($sql);
		//$pager = &new TMIS_Pager($sql);
		//$rowset = $pager->findAll();
		//dump($rowset);exit;
		
		$mShenhe = & FLEA::getSingleton('Model_Trade_Shenhe');
		$ret=array();
		foreach ($rowset as & $v){
			
			$v['proGuige']=$v['proName'].','.$v['guige'];
			//dump($orderCode);dump($v['orderCode']);
			
			//获得订单相关产品产量
			$sql="select x.cnt,y.zhijiCode,x.memo,x.ban,x.chanliangDate from shengchan_chanliang x 
			left join jichu_zhiji y on x.jizhiId=y.id
			where ord2proId='{$v['id']}' and x.chanliangDate<='{$serachArea['dateFrom']}' order by x.chanliangDate desc";
			$chanliang =$this->_modelExample->findBySql($sql);
			//判断当下日期是否有产量变化
			$chan=false;
			if($chanliang[0]['chanliangDate']==$serachArea['dateFrom'])$chan=true;

			$v['zhijiCode'] = join(',',array_unique(array_col_values($chanliang, 'zhijiCode')));
			$v['liangCnt'] = array_sum(array_col_values($chanliang, 'cnt'));
			$v['Pcnt'] = array_sum(array_col_values($chanliang, 'memo'));
			
			$i=0;
			$j=0;
			$Bcnt=0;
			$Ycnt=0;
			
			//获得白班和夜班的数量与次数
			foreach ($chanliang as & $vv){
				//dump($v);exit;
				
				if($vv['ban']==0){
					$Ycnt=$Ycnt+$vv['cnt'];
					$i++;
				}elseif($vv['ban']==1){
					$Bcnt=$Bcnt+$vv['cnt'];
					$j++;
				}
				
			}
// 			if($chanliang[0]['chanliangDate']==$serachArea['dateFrom']){
// 				dump($Bcnt);dump($i);dump($Ycnt);dump($j);exit;
// 			}
			$v['Bcnt']=$Bcnt;
			$v['Bcount']=$i;
			$v['Ycnt']=$Ycnt;
			$v['Ycount']=$j;
			
			//dump(array_col_values($chanliang, 'cnt'));//exit;
			//dump($v);exit;
			//获得入库产量
			$sql="select y.cnt,y.cntJian,x.rukuDate from cangku_common_ruku x
					left join cangku_common_ruku2product y on y.rukuId=x.id
					where x.orderId='{$v['orderId']}' and y.productId='{$v['productId']}'
			 		and x.rukuDate<='{$serachArea['dateFrom']}' order by x.rukuDate desc";
			$ruku =$this->_modelExample->findBySql($sql);
			//判断当下日期是否有入库变化
			$ru=false;
			if($ruku[0]['rukuDate']==$serachArea['dateFrom'])$ru=true;
			$v['rukuCnt'] = array_sum(array_col_values($ruku, 'cnt'));
			$v['rukuJian'] = array_sum(array_col_values($ruku, 'cntJian'));
			
			//dump($ruku);exit;
			//获得出库产量
			$sql="select y.cnt,y.cntJian,x.chukuDate from cangku_common_chuku x
			left join cangku_common_chuku2product y on y.chukuId=x.id
			where x.orderId='{$v['orderId']}' and y.productId='{$v['productId']}'
			and x.chukuDate<='{$serachArea['dateFrom']}' order by x.chukuDate desc";
			$chuku =$this->_modelExample->findBySql($sql);
			//判断当下日期是否有出库变化
			$chu=false;
			if($chuku[0]['chukuDate']==$serachArea['dateFrom'])$chu=true;
			$v['chukuCnt'] = array_sum(array_col_values($chuku, 'cnt'));
			$v['chukuJian'] = array_sum(array_col_values($chuku, 'cntJian'));
			$v['kucunCnt']=$v['rukuCnt']-$v['chukuCnt'];
			$v['kucunJian']=$v['rukuJian']-$v['chukuJian'];
			
			//欠数		
			$v['qianshu']=$v['cntYaohuo']-$v['liangCnt'];
			//门幅、克重
			$row = $mShenhe->find(array('ord2proId'=>$v['id']));
			$sh = unserialize($row['serialStr']);
			$v['menfu']=$sh['pibuMenfu'];
			$v['kezhong']=$sh['pibuKeZhong'];
			//	如果订单下的产量当前日期无变化，则不显示
			if($chan==true || $ru==true || $chu==true)$ret[]=$v;
		}
		//隐藏相同订单号和相关日期
		$orderCode=null;
		foreach ($ret as & $v){
			if($orderCode==$v['orderCode']){
				$orderCode=$v['orderCode'];
				$v['orderCode']=null;
				$v['orderDate']=null;
				$v['dateJiaohuo']=null;
			}else{
				$orderCode=$v['orderCode'];
			}
				
		}
		//dump($ret);exit;
		$heji = $this->getHeji($ret, array(
				'cntYaohuo','memo','rukuCnt','rukuJian','chukuCnt','chukuJian',
				'liangCnt','Pcnt','Bcnt','Bcount','Ycnt','Ycount','kucunCnt','kucunJian','qianshu'), 'orderCode');//匹数合计
		$heji['orderCode']='合计';
		$ret[]=$heji;
		// 标题栏信息
		$arrFieldInfo = array(
				'traderName'=>array('text'=>'业务员','width'=>'60'),
				"orderCode" => "订单号",
				'proCode' =>array('text'=>'产品编号','width'=>'70'),
				"color" =>array('text'=>'颜色','width'=>'50'),
				'proName' => '品名',	
				'guige' => '规格',
				'zhijiCode'=>array('text'=>'开机机台','width'=>'70'),
				"cntYaohuo" => array('text'=>'订单数','width'=>'60','type'=>'Number'),
				"Pcnt" => array('text'=>'合计匹数','width'=>'70','type'=>'Number'),
				'liangCnt'=>array('text'=>'合计过磅数量','width'=>'90','type'=>'Number'),
				'qianshu' => array('text'=>'生产欠数','width'=>'70','type'=>'Number'),
				"rukuJian" => array('text'=>'入库匹数','width'=>'70','type'=>'Number'),
				'rukuCnt'=>array('text'=>'入库数量','width'=>'70','type'=>'Number'),
				"chukuJian" =>array('text'=>'出库匹数','width'=>'70','type'=>'Number'),
				"chukuCnt" =>array('text'=>'出库数量','width'=>'70','type'=>'Number'),
				"kucunJian" =>array('text'=>'库存匹数','width'=>'70','type'=>'Number'),
				"kucunCnt" =>array('text'=>'库存数量','width'=>'70','type'=>'Number'),
				"orderDate" =>array('text'=>'下单日期','width'=>'75'),
				"dateJiaohuo" =>array('text'=>'交货日期','width'=>'75'),
				"menfu" =>array('text'=>'坯布门幅','width'=>'70','type'=>'Number'),
				"kezhong" =>array('text'=>'坯布克重','width'=>'70','type'=>'Number'),
				"Bcount" =>array('text'=>'白班开机数','width'=>'80','type'=>'Number'),
				"Bcnt" =>array('text'=>'白班过磅数量','width'=>'90','type'=>'Number'),
				"Ycount" =>array('text'=>'夜班开机数','width'=>'80','type'=>'Number'),
				"Ycnt" =>array('text'=>'夜班过磅数量','width'=>'90','type'=>'Number'),
		);
		
		$smarty = & $this->_getView();
		$smarty->assign('title', '生产日报表');
		$smarty->assign('arr_field_value', $ret);
 		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('heji', $heji);
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('add_display', 'none');
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$serachArea)));
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('fn_export',$this->_url($_GET['action'],array(
				'export'=>1
		)));
		if($_GET['export']!=1) {
			// $smarty->assign('page_info',$pager->getNavBar());
			$smarty->assign('page_info',"<font color='green'>金额已折合人民币</font>");
			$smarty->display('TableList.tpl');
			exit;
		}
		$smarty->assign('title',$serachArea['dateFrom'].'生产日报表');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$ret);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=test.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty->display('Export2Excel2.tpl');
	}

}

?>