<?php
//外协定型通知单
FLEA::loadClass('Controller_Shengchan_Waixie_Tongzhidan');
class Controller_Shengchan_Waixie_Dingxing extends Controller_Shengchan_Waixie_Tongzhidan {
	
	function __construct() {
	    parent::__construct();
	      $this->fldMain['kind'] = array('title'=>'类型','type'=>'select','value'=>'','options'=>array(
					array('text' => '外协定型', 'value' => '外协定型'),
					array('text' => '外协水洗', 'value' => '外协水洗'),
					array('text' => '外协染色', 'value' => '外协染色'),
		      		array('text' => '外协印花', 'value' => '外协印花'),
		      		array('text' => '外协磨毛', 'value' => '外协磨毛'),
					));
	}

	function actionAdd(){
        $this->authCheck('8-4');
        //坯布数据
		$pibuData = array(
			'xiajiMenfu' => array('title' => '下机门幅', 'type' => 'text',  'name' => 'xiajiMenfu','addonEnd' => 'cm'),
			'fachuJianshu' => array('title' => '发出件数', 'type' => 'text',  'name' => 'fachuJianshu','addonEnd'=>'件'),
			'fachuCnt' => array('title' => '发出数量', 'type' => 'text', 'name' => 'fachuCnt','addonEnd'=>'KG'),
			'xiajiKezhong' => array('title' => '下机克重', 'type' => 'text',  'name' => 'xiajiKezhong','addonEnd'=>'g/m2'),
			); 

		//成布要求
		$chengbuYaoqiu=array(
            'yaoqiuMenfu'=>array('title'=>'要求门幅','type'=>'text','name'=>'yaoqiuMenfu','addonEnd' => 'cm'),
            'yaoqiuSuolvJingxiang'=>array('title'=>'要求缩率经向','type'=>'text','name'=>'yaoqiuSuolvJingxiang','addonEnd' => '%','addonPre' => '-'),
            'yaoqiuSuolvWeixiang'=>array('title'=>'要求缩率纬向','type'=>'text','name'=>'yaoqiuSuolvWeixiang','addonEnd' => '%','addonPre' => '-'),
             'yaoqiuKezhong'=>array('title'=>'要求克重','type'=>'text','name'=>'yaoqiuKezhong','addonEnd' => 'g/m2'),
			);

		//成品实际数据
        $chengpinShijiData=array(
            'shijiMenfu'=>array('title'=>'实际门幅','type'=>'text','name'=>'shijiMenfu','addonEnd' => 'cm'),
            'shijiSuolvJingxiang'=>array('title'=>'实际缩率经向','type'=>'text','name'=>'shijiSuolvJingxiang','addonEnd' => '%','addonPre' => '-'),
            'xihouMenfu'=>array('title'=>'洗后门幅','type'=>'text','name'=>'xihouMenfu','addonEnd' => 'cm'),
             'shijiKezhong'=>array('title'=>'实际克重','type'=>'text','name'=>'shijiKezhong','addonEnd' => 'g/m2'),
            'shijiSuolvWeixiang'=>array('title'=>'实际缩率纬向','type'=>'text','name'=>'shijiSuolvWeixiang','addonEnd' => '%','addonPre' => '-'),
            'xihouKezhong'=>array('title'=>'洗后克重','type'=>'text','name'=>'xihouKezhong','addonEnd' => 'g/m2'),
        	);

        // 主表信息字段
		$fldMain = $this->fldMain;
        
        // 主表区域信息描述
		$areaMain = array('title' => '外协定型基本信息', 'fld' => $fldMain);
        
        $arr_item1=array('title' => '坯布数据 ', 'fld' => $pibuData);
        $arr_item2=array('title' => '成布要求 ', 'fld' => $chengbuYaoqiu);
        $arr_item3=array('title' => '成品实际数据 ', 'fld' => $chengpinShijiData);

        $smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('rules', $this->rules);
        $smarty->assign("arr_item1", $arr_item1);
		$smarty->assign("arr_item2", $arr_item2);
		$smarty->assign("arr_item3", $arr_item3);
		//$smarty->assign("tbl_son_width", '120%');
		//$smarty->assign("otherInfoTpl", 'Trade/otherInfoTpl.tpl');
		$smarty->assign('sonTpl', 'Waixie/jsSell.tpl');
		$smarty->display('Main2Son/waixie.tpl');
	}
    
    function _getEdit(& $rowset){
    	//dump(123);exit;
        if (count($rowset) > 0) foreach($rowset as &$value) {
        	/* if($value['kind']=='外协定型'){
                $value['_edit'] = "<a href='" . url('Shengchan_Waixie_Dingxing','PrintWaiXie', array('id' => $value['waixieId'])) . "' target='_blank' title='$title'>导出</a>";
                $value['_edit'] .= " <a href='".url('Shengchan_Waixie_Dingxing','Edit',array(
					'id'=>$value['waixieId'],
					'fromAction' => $_GET['action']
				))."'>修改</a>";
                $value['_edit'] .= " ".$this->getRemoveHtml($value['waixieId']);
        	}
        	//当kind不同时，在下面重写url
        	else{
                $value['_edit'] = "<a href='" . url('Shengchan_Waixie_Tongzhidan','PrintWaiXie', array('id' => $value['waixieId'])) . "' target='_blank' title='$title'>导出</a>";
                $value['_edit'] .= " <a href='".url('Shengchan_Waixie_Tongzhidan','Edit',array(
					'id'=>$value['waixieId'],
					'fromAction' => $_GET['action']
				))."'>修改</a>";
                $value['_edit'] .= " ".$this->getRemoveHtml($value['waixieId']);

        	} */
        	$value['_edit'] = "<a href='" . url('Shengchan_Waixie_Dingxing','PrintWaiXie', array('id' => $value['waixieId'])) . "' target='_blank' title='$title'>导出</a>";
        	$value['_edit'] .= " <a href='".url('Shengchan_Waixie_Dingxing','Edit',array(
        			'id'=>$value['waixieId'],
        			'fromAction' => $_GET['action']
        	))."'>修改</a>";
        	$value['_edit'] .= " ".$this->getRemoveHtml($value['waixieId']);
        	
            
		}
		//dump($rowset);exit;
    }

    function actionEdit(){
    	//dump('定型编辑');exit;
    	//dump($_GET);exit;
    	// $shengchan_waixie2product = &FLEA::getSingleton('Model_Shengchan_Waixie');
    	$arr = $this->_modelExample->find(array('id' => $_GET['id'])); 
    	//dump($arr);exit;
    	//处理$this->fldMain中的控件
    	foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value']; 
		}
		//设置waixieId的值
		$this->fldMain['waixieId']['value'] = $arr['id'];
		//dump($this->fldMain);exit;
        //设置id的值
		$this->fldMain['id']['value'] = $arr['waixie'][0]['id'];
		//处理productId
		$this->fldMain['productId']['value'] = $arr['waixie'][0]['productId'];
		//设置proName的值
		$this->fldMain['proName']['value']=$arr['waixie'][0]['proName'];
		//设置guige的值
		$this->fldMain['guige']['value']=$arr['waixie'][0]['guige'];
		// //设置缸号
		 $this->fldMain['ganghao']['value']=$arr['waixie'][0]['ganghao'];
		//处理ord2proId控件
		$ord2pro = &FLEA::getSingleton('Model_Trade_Order2Product');
        $res=$ord2pro->find(array('id'=>$arr['waixie'][0]['ord2proId']));
        $this->fldMain['ord2proId']['text']=$res['Order']['orderCode'];//显示的字段
         $this->fldMain['ord2proId']['value']=$arr['waixie'][0]['ord2proId'];

		//反序列化
		$s=array();
		$s=unserialize($arr['waixie'][0]['strSerial']);
		//dump($s);exit;

        // 主表区域信息描述
		$areaMain = array('title' => '外协定型基本信息', 'fld' => $this->fldMain);
		
        //坯布数据
		$pibuData = array(
			'xiajiMenfu' => array('title' => '下机门幅', 'type' => 'text',  'name' => 'xiajiMenfu','addonEnd' => 'cm'),
			'fachuJianshu' => array('title' => '发出件数', 'type' => 'text',  'name' => 'fachuJianshu','addonEnd'=>'件'),
			'fachuCnt' => array('title' => '发出数量', 'type' => 'text', 'name' => 'fachuCnt','addonEnd'=>'KG'),
			'xiajiKezhong' => array('title' => '下机克重', 'type' => 'text',  'name' => 'xiajiKezhong','addonEnd'=>'g/m2'),
			); 

		foreach ($pibuData as $key => $value) {
			$pibuData[$key]['value']=$s[$key];
		}
		//设置发出数量
        $pibuData['fachuCnt']['value']=$arr['waixie'][0]['cntSend'];

		//成布要求
		$chengbuYaoqiu=array(
            'yaoqiuMenfu'=>array('title'=>'要求门幅','type'=>'text','name'=>'yaoqiuMenfu','addonEnd' => 'cm'),
            'yaoqiuSuolvJingxiang'=>array('title'=>'要求缩率经向','type'=>'text','name'=>'yaoqiuSuolvJingxiang','addonEnd' => '%','addonPre' => '-'),
            'yaoqiuSuolvWeixiang'=>array('title'=>'要求缩率纬向','type'=>'text','name'=>'yaoqiuSuolvWeixiang','addonEnd' => '%','addonPre' => '-'),
             'yaoqiuKezhong'=>array('title'=>'要求克重','type'=>'text','name'=>'yaoqiuKezhong','addonEnd' => 'g/m2'),
			);
		
        foreach ($chengbuYaoqiu as $key => $value) {
			$chengbuYaoqiu[$key]['value']=$s[$key];
		}
        

		//成品实际数据
        $chengpinShijiData=array(
            'shijiMenfu'=>array('title'=>'实际门幅','type'=>'text','name'=>'shijiMenfu','addonEnd' => 'cm'),
            'shijiSuolvJingxiang'=>array('title'=>'实际缩率经向','type'=>'text','name'=>'shijiSuolvJingxiang','addonEnd' => '%','addonPre' => '-'),
            'xihouMenfu'=>array('title'=>'洗后门幅','type'=>'text','name'=>'xihouMenfu','addonEnd' => 'cm'),
             'shijiKezhong'=>array('title'=>'实际克重','type'=>'text','name'=>'shijiKezhong','addonEnd' => 'g/m2'),
            'shijiSuolvWeixiang'=>array('title'=>'实际缩率纬向','type'=>'text','name'=>'shijiSuolvWeixiang','addonEnd' => '%','addonPre' => '-'),
            'xihouKezhong'=>array('title'=>'洗后克重','type'=>'text','name'=>'xihouKezhong','addonEnd' => 'g/m2'),
        	);
        foreach ($chengpinShijiData as $key => $value) {
			$chengpinShijiData[$key]['value']=$s[$key];
		}

        $arr_item1=array('title' => '坯布数据 ', 'fld' => $pibuData);
        $arr_item2=array('title' => '成布要求 ', 'fld' => $chengbuYaoqiu);
        $arr_item3=array('title' => '成品实际数据 ', 'fld' => $chengpinShijiData);

        $smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('rules', $this->rules);
        $smarty->assign("arr_item1", $arr_item1);
		$smarty->assign("arr_item2", $arr_item2);
		$smarty->assign("arr_item3", $arr_item3);
		//$smarty->assign("tbl_son_width", '120%');
		//$smarty->assign("otherInfoTpl", 'Trade/otherInfoTpl.tpl');
		$smarty->assign('sonTpl', 'Waixie/jsSell.tpl');
		$smarty->display('Main2Son/waixie.tpl');
    }

    function actionPrintWaixie(){
    	//dump("定型导出。。。");exit;
    	$arr = $this->_modelExample->find(array('id' => $_GET['id']));
    	//取出数据 
    	$jianggonghu=&FLEA::getSingleton('Model_Jichu_Jiagonghu');
    	$res=$jianggonghu->find(array('id'=>$arr['jiagonghuId']));
    	$s=unserialize($arr['waixie'][0]['strSerial']);
    	//dump($s);exit;
    	$waixie2pro=$arr['waixie'][0];

		$this->exportWithXml('Waixie/Dingxing.xml',array(
			'arr'=>$arr,
			's'=>$s,
			'res'=>$res,
			'waixie2pro'=>$waixie2pro,
		));
    }
    
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
        x.id as ord2proId,
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

}
?>