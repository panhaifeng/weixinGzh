<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Product extends Tmis_Controller {
	var $_modelExample;
	var $fldMain; 
	var $rules; //表单元素的验证规则
	// /构造函数
	function Controller_Jichu_Product() {
		$this->_modelExample = &FLEA::getSingleton('Model_Jichu_Product'); 
		// 得到所有的历史成分
		// $sql = "select zhonglei from jichu_product group by zhonglei";
		// $rowset = $this->_modelExample->findBySql($sql);
		// foreach($rowset as &$v) {
		// 	$opt[] = array('text' => $v['zhonglei'], 'value' => $v['zhonglei']);
		// } 
		// 得到所有的历史颜色
		$sql = "select color from jichu_product group by color";
		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as &$v) {
			$color[] = array('text' => $v['color'], 'value' => $v['color']);
		}
		$this->fldMain = array('kind' => array('title' => '分类', "type" => "select", 'value' => '', 'options' => array(
					array('text' => '坯纱', 'value' => '坯纱'),
					array('text' => '色纱', 'value' => '色纱'),
					array('text' => '针织', 'value' => '针织'),
					array('text' => '其他', 'value' => '其他'),
					)),
			'proCode' => array('title' => '物料编号', "type" => "text", 'value' => ''),
			'proName' => array('title' => '品名', 'type' => 'text', 'value' => ''),
			'guige' => array('title' => '规格', 'type' => 'text', 'value' => ''),
			'color' => array('title' => '颜色', 'type' => 'text', 'value' => ''),
			'chengFen' => array('title' => '成份', 'type' => 'text', 'value' => ''),
			'menfu' => array('title' => '门幅', 'type' => 'text', 'value' => ''),
			'kezhong' => array('title' => '克重', 'type' => 'text', 'value' => ''),
			'memo' => array('title' => '备注说明', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''), 
			// 'kind'=>array('value'=>''),
			);
	}

	function actionRight() {
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array("kind" => "",
				'key' => '',
				));
		$str = "select * from jichu_product where 1";
		if ($arr['key'] != '') $str .= " and (proCode like '%{$arr['key']}%'
                        or proName like '%{$arr['key']}%'
                        or guige like '%{$arr['key']}%')";
		$arr['kind'] && $str .= " and kind='{$arr['kind']}'";
		$str .= " order by proCode asc,proName asc,guige asc";
		// dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str); 
		// $pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']).' '. $this->getCopyHtml($v['id']);
			$v['_edit'] .= " <a href='".$this->_url('PrintBarCode',array(
				'id'=>$v['id']
			))."' target='_blank'>条码</a>";
		}
		$smarty = &$this->_getView();
		$smarty->assign('title', '选择产品');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array("_edit" => '操作',
			"kind" => '类别',
			"proCode" => "产品编号",
			"proName" => "品名",
			"color" => "颜色" ,
			"guige" => "规格",
			"chengFen" =>"成份",
			'menfu'=>'门幅',
			'kezhong'=>'克重',
			'memo'=>'备注'
			);
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset); 
		// $smarty->assign('add_display','none');
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	} 
	// **************************弹出产品信息 begin***************************
	function actionPopup() {
		// dump($_GET);exit;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key' => '',
			'kind' => '',
		)); 
		// var_dump(empty($_GET['proKind']));exit;
		if (isset($_GET['proKind'])) {
			// 如果$_GET['proKind']不为空 并且url过来的kind=0 表示要选择的是色坯纱;否则选择的是成品
			if ($_GET['proKind'] == 0) {
				$sql = " and kind in ('坯纱','色纱')";
			}else {
				$sql = " and kind in ('针织','其他')";
			}
		}else {
			$sql = "";
		}  

		// dump($sql);exit;
		$str = "select * from jichu_product where 1" . $sql;

		if ($arr['key'] != '') $str .= " and (proCode like '%$arr[key]%'
                        or proName like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
		if ($arr['kind'] != '') $str .= " and kind='$arr[kind]'";
		$str .= " order by proCode asc,proName asc,guige asc"; //dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str); 
		// $pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//显示
			$v["_proName"] = $v["proName"];
			$v["proName"] = $v["proName"]."   ".$v["guige"];
		}
		$smarty = &$this->_getView();
		$smarty->assign('title', '选择产品');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"kind" => "分类",
			"proCode" => "编码",
			"_proName" => "产品名称",
			"guige" => "规格",
			"color" => "颜色", 
		); 
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url('Popup', $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	} 
	// **************************弹出产品信息 end***************************
	function actionAdd() {
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '原料信息编辑');
		$smarty->display('Main/A.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row); 
		// dump($row);dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '原料信息编辑');
		$smarty->assign('aRow', $row);
		$smarty->display('Main/A.tpl');
	}
	function actionCopy() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$row2['proName']=$row['proName'];
		$row2['guige']=$row['guige'];
		$row2['proName']=$row['proName'];
		$row2['chengFen']=$row['chengFen'];
		$row2['menfu']=$row['menfu'];
		$row2['kezhong']=$row['kezhong'];
		$row2['memo']=$row['memo'];
		//dump($row2);die;
		$this->fldMain = array('kind' => array('title' => '分类', "type" => "select", 'value' => '', 'options' => array(
				array('text' => '坯纱', 'value' => '坯纱'),
				array('text' => '色纱', 'value' => '色纱'),
				array('text' => '针织', 'value' => '针织'),
				array('text' => '其他', 'value' => '其他'),
		)),
				'proCode' => array('title' => '物料编号', "type" => "text", 'value' => ''),
				'proName' => array('title' => '品名', 'type' => 'text', 'value' => ''),
				'guige' => array('title' => '规格', 'type' => 'text', 'value' => ''),
				'color' => array('title' => '颜色', 'type' => 'text', 'value' => ''),
				'chengFen' => array('title' => '成份', 'type' => 'text', 'value' => ''),
				'menfu' => array('title' => '门幅', 'type' => 'text', 'value' => ''),
				'kezhong' => array('title' => '克重', 'type' => 'text', 'value' => ''),
				'memo' => array('title' => '备注说明', 'type' => 'textarea', 'value' => ''),
				'id' => array('type' => 'hidden', 'value' => ''),
				
		);
		$this->rules = array(
				'color' => 'required',
		);
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row2);
		 //dump($row);dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '原料信息编辑');
		$smarty->assign('aRow', $row2);
		$smarty->display('Main/A.tpl');
	}
	function actionSave() {
		//dump($_POST);exit;
		// 确保产品编码,品名,规格,颜色都存在
		if (!$_POST['kind']) {
			js_alert('请选择类别!', null, $this->_url($_POST['fromAction']));
			exit;
		}
		if (!$_POST['proCode']) {
			js_alert('产品编码缺失!', null, $this->_url($_POST['fromAction']));
			exit;
		}else {
			// 产品编码不重复
			$sql = "select count(*) cnt from jichu_product where proCode='{$_POST['proCode']}' and id<>'{$_POST['id']}'";
			$_rows = $this->_modelExample->findBySql($sql);
			if ($_rows[0]['cnt'] > 0) {
				js_alert('产品编码重复!', "window.history.go(-1)");
				exit;
			}
		}
		if (!$_POST['proName']) {
			js_alert('品名缺失!', null, $this->_url($_POST['fromAction']));
			exit;
		}
		if (!$_POST['guige']) {
			js_alert('规格缺失!', null, $this->_url($_POST['fromAction']));
			exit;
		}
		
		// if (!$_POST['color']) {
		// 	js_alert('颜色缺失!', null, $this->_url($_POST['fromAction']));
		// 	exit;
		// }
		// dump($_POST);exit;
		$this->_modelExample->save($_POST);
		if ($_POST["tijiao"]==" 保 存 ") {
			js_alert(null, 'window.parent.showMsg("保存成功")', $this->_url($_POST['fromAction']));
		}elseif ($_POST["tijiao"]=="保存并新增") {
			js_alert(null, 'window.parent.showMsg("保存成功")', $this->_url("add"));
		}
		exit;
	}

	/**
	 * 打印条码标签
	 * by jeff
	 */
	function actionPrintBarCode() {
		$row=$this->_modelExample->find(array('id'=>$_GET['id']));
		// $row['guige'] = str_replace('（','(',$row['guige']);
		// $row['guige'] = str_replace('）',')',$row['guige']);
		// $row['guige'] = preg_replace('/([\x80-\xff]*)/i','',$row['guige']);
		// $row['guige'] = str_replace('()','',$row['guige']);
		// $row['guige'] = "";
		// $row['proKind']=($row['proColor']!=''?$row['proColor'].' ':'').$row['proKind'];
		//dump($row);exit;
		$smarty=& $this->_getView();
		$smarty->assign('aRow',$row);
		$smarty->display('JiChu/PrintBarcode.tpl');
	}

	/**
     * ps ：修改单价
     * Time：2017年10月25日 11:15:09
     * @author Shen
     * @param 参数类型
     * @return 返回值类型
    */
    function actionSetPrice(){
    	$time= time();
    	$editDate = date('Y-m-d H:i:s',$time); 
        $row = array(
            'id'=>$_GET['id'],
            'price'=>$_GET['price'],
            'editDate'=>$editDate
        );
        $this->_modelExample->save($row);
        echo json_encode(true);exit;
    }
    /**
     * ps ：查看纱档案
     * Time：2017年12月5日 15:32:02
     * @author Shen
     * @param 参数类型
     * @return 返回值类型
    */
    function actionPopupSha() {
		// dump($_GET);exit;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key' => '',
			'kind' => '',
		)); 
	
		$sql =" and kind in('色纱','坯纱','其他','涤丝','氨纶')";
		
		$str = "select * from jichu_product where 1" . $sql;

		if ($arr['key'] != '') $str .= " and (proCode like '%$arr[key]%'
                        or proName like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
		if ($arr['kind'] != '') $str .= " and kind='$arr[kind]'";
		$str .= " order by proCode asc,proName asc,guige asc"; //dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str); 
		// $pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//显示
			$v["_proName"] = $v["proName"];
			$v["proName"] = $v["proName"]."   ".$v["guige"];
		}
		$smarty = &$this->_getView();
		$smarty->assign('title', '选择产品');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"kind" => "分类",
			"proCode" => "编码",
			"_proName" => "产品名称",
			"guige" => "规格",
			"color" => "颜色", 
		); 
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url('PopupSha', $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	} 


	 #展会系统中，导入产品
    function actionGetProduct(){
        
        $str="select * from jichu_product where 1  and kind='针织'";
        $row=$this->_modelExample->findBySql($str);
        // dump($row);exit;
        $data=array(
            'proCode'=>array_col_values($row,'proCode'),
            'proName'=>array_col_values($row,'proName'),
            'color'=>array_col_values($row,'color'),
            'guige'=>array_col_values($row,'guige'),
            'chengFen'=>array_col_values($row,'chengFen'),
            'menfu'=>array_col_values($row,'menfu'),
            'kezhong'=>array_col_values($row,'kezhong'),
            'memo'=>array_col_values($row,'memo'),
            'comeFrom'=>array_col_values($row,'comeFrom'),
        );
        echo json_encode($data);
        exit;
    }

}

?>