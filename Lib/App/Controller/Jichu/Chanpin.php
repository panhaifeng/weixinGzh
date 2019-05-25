<?php
FLEA::loadClass('Controller_Jichu_Product');
class Controller_Jichu_Chanpin extends Controller_Jichu_Product{
  var $_modelExample;
  var $fldMain;

  ///构造函数
  function __construct() {
    $this->_modelExample = & FLEA::getSingleton('Model_Jichu_Product');
    $this->_modelPro = & FLEA::getSingleton('Model_Jichu_ProductSon');
    $this->_modelGx = & FLEA::getSingleton('Model_Jichu_ProductGx');

    $sql = "select color from jichu_product group by color";
    $rowset = $this->_modelExample->findBySql($sql);
    foreach($rowset as &$v) {
      $color[] = array('text' => $v['color'], 'value' => $v['color']);
    }
    $this->fldMain = array(
      'kind' => array('title' => '分类', "type" => "select", 'value' => '', 'options' => array(
          array('text' => '针织', 'value' => '针织'),
          )),
      'proCode' => array('title' => '物料编号', "type" => "text", 'value' => ''),
      'chiCun' => array('title' => '尺寸', 'type' => 'select', 'value' => '',
        'options'=> array(
          array('text' => '30寸', 'value' => '30寸'),
          array('text' => '26寸', 'value' => '26寸'),
          array('text' => '34寸', 'value' => '34寸'),
          array('text' => '38寸', 'value' => '38寸'),
        )
      ),
      'zhenXing' => array('title' => '针型', 'type' => 'select', 'value' => '',
        'options'=>array(
          array('text' => '24针', 'value' => '24针'),
          array('text' => '28针', 'value' => '28针'),
          array('text' => '23针', 'value' => '23针'),
          array('text' => '18针', 'value' => '18针'),
          array('text' => '20针', 'value' => '20针'),
        )
      ),
      'proName' => array('title' => '品名', 'type' => 'text', 'value' => ''),
      'guige' => array('title' => '规格', 'type' => 'text', 'value' => ''),
      'color' => array('title' => '颜色', 'type' => 'text', 'value' => ''),
      'chengFen' => array('title' => '成份', 'type' => 'text', 'value' => ''),
      'menfu' => array('title' => '门幅', 'type' => 'text', 'value' => ''),
      'kezhong' => array('title' => '克重', 'type' => 'text', 'value' => ''),
      'memo' => array('title' => '备注说明', 'type' => 'textarea', 'value' => ''),
      'upNeedle' => array('title' => '上针', 'type' => 'text', 'value' => ''),
      'downNeedle' => array('title' => '下针', 'type' => 'text', 'value' => ''),
      'newSj' => array('title' => '三角', 'type' => 'btBtnChar', 'value' => '','name'=>'btBtnChar'),
      // 'id' => array('type' => 'hidden', 'value' => ''),
      'id' => array('type' => 'hidden', 'value' => '','name'=>'proId'),
      'chars' => array('type' => 'hidden', 'value' => '','name'=>'chars'),
      // 'kind'=>array('value'=>''),
      );

    $this->headSon = array(
      '_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
      'productId' => array(
              'title' => '选择纱支',
              "type" => "btPopup",
              'name' => 'productId[]',
              'url'=>url('jichu_product','PopupSha'),
              'textFld'=>'proCode',
              'hiddenFld'=>'id',
              'inTable'=>true,
          ),
      'proNameson'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proNameson[]','readonly'=>true),
      //用于计算，原来称成分比例，后来客户提出为纱支比例，用于计算
      'viewPer'=>array('type'=>'bttext',"title"=>'纱支比列(%)','name'=>'viewPer[]','class'=>'needChange'),
      'xianchang'=>array('type'=>'bttext',"title"=>'线长','name'=>'xianchang[]'),
      'memoView'=>array('type'=>'bttext',"title"=>'备注','name'=>'memoView[]'),
      //***************如何处理hidden?
      'id'=>array('type'=>'bthidden','name'=>'id[]'),
    );
    $this->headGongxu = array(
      '_edit'=>array('type'=>'btBtnRemoveA',"title"=>'+5行','name'=>'_edit[]'),
      'xuhao'=>array('type'=>'bttext',"title"=>'序号','name'=>'xuhao[]','readonly'=>true,'style'=>'width:50px;'),
      'gongxuId'=>array('type'=>'btselect',"title"=>'工序','name'=>'gongxuId[]','model'=>'Model_Baojia_Gongxu','action'=>'getOptions'),
      'id'=>array('type'=>'bthidden','name'=>'gxId[]'),
    );
    $this->rules = array(
      'menfu'=>'required',
      'kezhong'=>'required',
    );
  }


  function actionRight() {
    $this->authCheck('6-21');
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array("kind" => "",
      'proCode' => '',
      'proName' => '',
      'color' => '',
      'guige' => '',
      'chengfen' => '',
      'kezhong' => '',
    ));
    $str = "select * from jichu_product where 1 and kind='针织'";
    if ($arr['proCode']!='') $str .= " and proCode like '%{$arr['proCode']}%'";
    if ($arr['proName']!='') $str .= " and proName like '%{$arr['proName']}%'";
    if ($arr['color'] != '') $str .= " and color like '%{$arr['color']}%'";
    if ($arr['guige'] != ''){
        // 规格的检索
        $tmpGuiges = trim($arr['guige']);
        $tmpGuiges = explode(' ', $tmpGuiges);
        $tmpSql = array();

        foreach ($tmpGuiges as $guige)
        {
            $tmpSql[] =  " guige like '%{$guige}%'";
        }
        $str .= " and (".(join(' and ', $tmpSql)).")";
    }
    if ($arr['chengfen'] != '') $str .= " and chengFen like '%{$arr['chengfen']}%'";
    if ($arr['kezhong'] != '') $str .= " and kezhong like '%{$arr['kezhong']}%'";
    $arr['kind'] && $str .= " and kind='{$arr['kind']}'";
    $str .= " order by proCode asc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAllBySql($str);
    if(count($rowset)>0) foreach($rowset as & $v){
    	$v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']).' '. $this->getCopyHtml($v['id']);
      $v['_edit'] .= " <a href='".$this->_url('PrintBarCode',array(
      		'id'=>$v['id']
      ))."' target='_blank'>条码</a>";
      $sql="select * from jichu_product_chengfen where proId='{$v['id']}'";
      $ret=$this->_modelPro->findBySql($sql);
      foreach ($ret as $k=>& $r){
      	if($k==0) {
      		$v['viewPer']=$r['viewPer']!='0.0'?$r['viewPer']:'';;
      		$v['xianchang']=$r['xianchang'];
      	}else{
      		$v['viewPer'].=$r['viewPer']!='0.0'?'/'.$r['viewPer']:'';
      		$v['xianchang'].=$r['xianchang']?'/'.$r['xianchang']:'';
      	}
      }
        // $this->makeEditable($v,'guige');
      // $v['baojia']="<input type='text' name='baojia[]' value='{$v['baojia']}' />
      // 				<input type='hidden' name='id[]' value='{$v['id']}' />";
      //添加了查看图片列，点击小图片弹出窗口显示布匹图片，2015-09-11，by liuxin
      $spic = $v['spicPath']!=''?$v['spicPath']:'Resource/Image/img.gif';
      if($v['imageFile']!='') $v['imageFile'] = "<a href='".$this->_url('showImage',array(
        'barCode'=>$v['barCode'],
        'img'=>$v['imageFile']!=''?$v['imageFile']:'',
        'width'=>'1000',
        'height'=>'580',
        'baseWindow'=>'parent',
        'TB_iframe'=>1
      ))."'  class='thickbox' title='查看图片'><img src='{$spic}' style='border:0px'></a>";

    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '选择产品');
    $pk = $this->_modelExample->primaryKey;
    $smarty->assign('pk', $pk);
    //2015-7-7 by jiang 添加报价一览的权限
    // if($this->authCheck('6-4-3',true))
    	$arr_field_info = array(
    			"_edit" => '操作',
    			"kind" => '类别',
    			"proCode" => "产品编号",
    			"proName" => "品名",
    			"color" => "颜色" ,
    			"guige" => "规格",
          // "imageFile" => "图片文件",
    			// "baojia" => "报价区间",
    			"chengFen" =>"成份",
    			'menfu'=>'门幅',
    			'kezhong'=>'克重',
    			"viewPer"=>'纱支比例',
    			"xianchang"=>'线长',
          // 'quanmenfu'=>'全门幅',
          'chiCun'=>'寸数',
          'zhenXing'=>'针型',
    			'memo'=>'备注'
    	);
   //  else
	  //   $arr_field_info = array(
	  //   	"_edit" => '操作',
	  //     "kind" => '类别',
  	// 		"proCode" => "产品编号",
  	// 		"proName" => "品名",
  	// 		"color" => "颜色" ,
  	// 		"guige" => "规格",
   //      // "imageFile" => "图片文件",
  	// 		"chengFen" =>"成份",
  	// 		'menfu'=>'门幅',
  	// 		'kezhong'=>'克重',
	  //   	"viewPer"=>'纱支比例',
	  //   	"xianchang"=>'线长',
   //      // 'quanmenfu'=>'全门幅',
   //      'chiCun'=>'寸数',
   //      'zhenXing'=>'针型',
			// 'memo'=>'备注'
	  //   );
    //验证是否有查看纱支比例和线长字段的权限，没有则隐藏这两个字段，2015-09-10，by liuxin
    // if (!($this->authCheck('6-4-4',true))){
    //   unset($arr_field_info['viewPer']);
    // }
    // if (!($this->authCheck('6-4-5',true))) {
    //   unset($arr_field_info['xianchang']);
    // }
    $smarty->assign('arr_field_info',$arr_field_info);
    $smarty->assign('arr_field_value',$rowset);
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('sonTpl', 'Jichu/Chanpin.tpl');
    $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
    $smarty-> display('TblList.tpl');
  }

  function actionAdd() {
    // 新增权限，单独控制
    $this->authCheck('6-21-1');
    // 从表区域信息描述
    $areaMain = array('title' => '成布基本信息', 'fld' => $this->fldMain);
    // 从表信息字段,默认5行
    for($i = 0;$i < 5;$i++) {
      $rowsSon[] = array();
    }
    for($i=0;$i<5;$i++){
      $temp['xuhao'] = array('value'=>$i+1);
      $gongxuSon[]=$temp;
    }
    $smarty = &$this->_getView();
    $smarty->assign('areaMain', $areaMain);
    $smarty->assign('headSon', $this->headSon);
    $smarty->assign('headGongxu', $this->headGongxu);
    $smarty->assign('rowsSon', $rowsSon);
    $smarty->assign('gongxuSon', $gongxuSon);
    $smarty->assign('rules', $this->rules);
    $smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
    $smarty->assign("otherInfoTpl",'Baojia/GongxuInfoTpl.tpl');
    $smarty->display('Main2Son/T1.tpl');
  }

  function actionEdit() {
    $this->authCheck('6-21-2');
    $arr = $this->_modelExample->find(array('id' => $_GET['id']));
    $arr['picture']=$arr['imageFile'];
    $arr['spicPath']=$arr['spicPath'];
		// dump($arr);exit;
		//设置主表id的值
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$pro = $this->_modelExample->find(array('id' => $v['productId']));
			$temp['productId']=array('text' => $pro['proCode'],'value' => $pro['id']);
			$temp['proNameson']=array('value' => $pro['proName']."   ".$pro["guige"]);
			$temp['sonId']=array('value' => $v['id']);
			$rowsSon[] = $temp;
		}
    $i = 1;
    foreach($arr['Gongxu'] as &$vx) {
      $temp = array();
      foreach($this->headGongxu as $key => &$vv) {
        if($key=='xuhao' && !$vx[$key]){
          $vx[$key]= $i;
          $i++;
        }elseif($key=='xuhao' && $vx[$key]){
          $i = $vx[$key];
          $i++;
        }
        $temp[$key] = array('value' => $vx[$key]);
      }
      $gongxuSon[] = $temp;
    }
		//补齐5行
		$cnt = count($rowsSon);
		for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}
    $cntGx = count($gongxuSon);
    for($i=5;$i>$cntGx;$i--) {
      $gongxuSon[] = array();
    }

    //补全序号
    if($cntGx<5){
      $i=1;
      foreach ($gongxuSon as $k => &$v) {
        if(!$v){
          $v['xuhao']['value'] =  $i;
        }else{
          $i = $v['xuhao']['value'];
        }
        $i++;
      }
    }
    
    // dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('areaMain',array('title' => '成布基本信息', 'fld' => $this->fldMain));
		$smarty->assign('headSon', $this->headSon);
    $smarty->assign('headGongxu', $this->headGongxu);
		$smarty->assign('rowsSon', $rowsSon);
    $smarty->assign('gongxuSon', $gongxuSon);
		$smarty->assign('rules', $this->rules);
    $smarty->assign("otherInfoTpl",'Baojia/GongxuInfoTpl.tpl');
 		$smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
		$smarty->assign('print', 'yes');
		$smarty->display('Main2Son/T1.tpl');
  }

  function actionSave(){
  //dump($_FILES);exit;
  	// dump($_POST);exit;
  	if (!$_POST['kind']) {
  		js_alert('请选择类别!', null, $this->_url($_POST['fromAction']));
  		exit;
  	}
  	if (!$_POST['proCode']) {
  		js_alert('产品编码缺失!', null, $this->_url($_POST['fromAction']));
  		exit;
  	}else {
  		// 产品编码不重复
  		$sql = "select count(*) cnt from jichu_product where  proCode='{$_POST['proCode']}' and id<>'{$_POST['proId']}'";
  		$_rows = $this->_modelExample->findBySql($sql);
      // dump($_rows);die;
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
   
  	foreach ($_POST['productId'] as $key =>& $value){
  		if(empty($_POST['productId'][$key])) continue;
  		$arr[]=array(
  			'id'=>$_POST['id'][$key],
  			'productId'=>$_POST['productId'][$key],
  			'viewPer'=>$_POST['viewPer'][$key],
  			'xianchang'=>$_POST['xianchang'][$key],
  			'memoView'=>$_POST['memoView'][$key],
  		);
  	}
    foreach ($_POST['gongxuId'] as $k =>& $v){
      if(empty($_POST['gongxuId'][$k])) continue;
      $gongxu[]=array(
        'id'=>$_POST['gxId'][$k],
        'gongxuId'=>$_POST['gongxuId'][$k],
        'xuhao'=>$_POST['xuhao'][$k]
      );
    }
    $_POST['chars'] = str_replace('"', "'", $_POST['chars']);
    $gl = array("'", "[", "]");  
    $_POST['chars'] = str_replace($gl, "", $_POST['chars']);
  	$row=array(
  		'id'=>$_POST['proId'],
  		'kind' =>$_POST['kind'],
  		'proCode' =>$_POST['proCode'],
  		'proName' =>$_POST['proName'],
  		'guige' =>$_POST['guige'],
  		'color' => $_POST['color'],
  		'chengFen' =>$_POST['chengFen'],
  		'menfu' =>$_POST['menfu'],
  		'kezhong' =>$_POST['kezhong'],
      'imageFile' =>$imgPath['imageFile'],
      'quanmenfu' =>$_POST['quanmenfu'],
      'chiCun' =>$_POST['chiCun'],
      'zhenXing' =>$_POST['zhenXing'],
      'spicPath' =>$imgPath['spicPath'],
  		'memo' =>$_POST['memo'],
      'state' =>$_POST['state'],
      'chars' => $_POST['chars'],
      'upNeedle' => $_POST['upNeedle'],
  		'downNeedle' => $_POST['downNeedle'],
  		'Products' =>$arr,
      'Gongxu' =>$gongxu
  	);
   	// dump($row);exit;
  	$id = $this->_modelExample->save($row);
  	js_alert(null, 'window.parent.showMsg("保存成功")',$this->_url('right'));
  	exit;
  }

  function actionPopup() {
		// dump($_GET);exit;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(
				array(
					'key' => '',
				));
		$str = "select * from jichu_product where 1 and state=1";
		if ($arr['key'] != '') $str .= " and (proCode like '%$arr[key]%'
                        or proName like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
		$str .= " order by proCode asc,proName asc,guige asc";
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str);
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
   function actionRemove(){
      $this->authCheck('6-21-3');
      //查找订单信息
      $sql="select count(*) as cnt from trade_order2product where productId='{$_GET['id']}'";
      $rest = $this->_modelExample->findBySql($sql);
      if($rest[0]['cnt']>0){
        js_alert('订单中已使用该产品信息，禁止删除','',$this->_url('right'));
        exit;
      }
      //删除功能同时删除该记录上传的图片，2015-09-11，by liuxin
      $from = $_GET['fromAction']?$_GET['fromAction']:$_GET['from'];
      $re = $this->_modelExample->find(array('id'=>$_GET['id']));
      if ($this->_modelExample->removeByPkv($_GET['id'])) {
        unlink($re['imageFile']);
        if($from=='') redirect($this->_url("right"));
        else js_alert(null,"window.parent.showMsg('成功删除')",$this->_url($from));
    }
    else js_alert('出错，不允许删除!','',$this->_url($from));
      // parent::actionRemove();
   }
   /**
   * 打印条码标签
   * by jeff
   */
  function actionPrintBarCode() {
    $this->authCheck('6-21-5');
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
   function actionGetShaInfo(){
   	// 		dump($arr);
   		$str="select x.*,y.proCode from jichu_product_chengfen x
   			left join jichu_product y on x.productId=y.id where proId='{$_GET['proId']}'";
   		$ret = $this->_modelExample->findBySql($str);
   	echo json_encode(array('success'=>count($ret)>0,'Sha'=>$ret));exit;
   }
   //修改界面中ajax删除
   function actionRemoveByAjax() {
   	$id=$_POST['id'];
   	$r = $this->_modelPro->removeByPkv($id);
   	if(!$r) {
   		// js_alert('删除失败');
   		echo json_encode(array('success'=>false,'msg'=>'删除失败'));
   		exit;
   	}
   	echo json_encode(array('success'=>true));
   }

   function actionRemoveGxByAjax(){
      $id=$_POST['id'];
      $r = $this->_modelGx->removeByPkv($id);
      if(!$r) {
        // js_alert('删除失败');
        echo json_encode(array('success'=>false,'msg'=>'删除失败'));
        exit;
      }
      echo json_encode(array('success'=>true));
   }
   function actionbuMingxi(){
	   	$str = "select x.chengFen,y.xianchang,y.viewPer from jichu_product x
	   			left join jichu_product_chengfen y on x.id=y.proId
	   			left join jichu_product p on y.productId=y.id
	   			 where 1 and x.state=1 and x.id='{$_GET['productId']}'";
		$rowset=$this->_modelExample->findBySql($str);
		foreach ($rowset as $k=>&$v){
			$temp[0]['chengFen']=$v['chengFen'];
			if($k==0){
				$temp[0]['xianchang']=$v['xianchang'];
				$temp[0]['viewPer']=$v['viewPer'].'%';
			}
			else{
				$temp[0]['xianchang'].='/'.$v['xianchang'].'%';
				$temp[0]['viewPer'].='/'.$v['viewPer'].'%';
			}
		}
// 		dump($rowset);exit;
	   	$smarty = & $this->_getView();
	   	$smarty->assign('title', '选择产品');
	   	$pk = $this->_modelExample->primaryKey;
	   	$smarty->assign('pk', $pk);
	   	$arr_field_info = array(
	   			"xianchang" => "线长",
	   			"viewPer" => "纱支比列(%)",
	   			"chengFen" =>"成份",
	   	);
	   	$smarty->assign('arr_field_info',$arr_field_info);
	   	$smarty->assign('arr_field_value',$temp);
	   	$smarty-> display('TblList.tpl');
   }
   function actionSetBaojia(){
   		$arr=array(
   				'id'=>$_GET['id'],
   				'baojia'=>$_GET['baojia']
   		);
   		$id = $this->_modelExample->save($arr);

   		js_alert(null, 'window.parent.showMsg("保存成功")',$this->_url('right'));
   		exit;
   }

  //显示图片大图，2015-09-11，by liuxin
  function actionShowImage(){
      $arr=$_GET;
      $size=GetImageSize($arr["img"]);
      // 以不超过弹窗宽度来调整
      if($size[0]>960){
        $isOverSize = true;
        $newSize['width'] = 960;
        $newSize['height'] = round(ceil($size[1]/$size[0]*960));
      }else{
        $isOverSize = false;
      }
      // dump($isOverSize);
      // dump($newSize);exit;
      $smarty = & $this->_getView();
      $smarty->assign('title','布匹大图');
      $smarty->assign('row',$arr);
      $smarty->assign('newSize',$newSize);//图片显示尺寸
      $smarty->assign('isOverSize',$isOverSize);//是否超过弹窗宽度
      $smarty->display('Jichu/showImage.tpl');
  }
   //上传图片处理函数，2015-09-11，by liuxin
  function upLoad($arrFile) {
    $file = $arrFile["imageFile"];
    $uptypes=array('image/jpg',  //上传文件类型列表
    'image/jpeg',
    'image/png',
    'audio/x-pn-realaudio-plugin',
    'image/gif',
    'image/bmp',
    'application/x-shockwave-flash',
    'image/x-png');
    $max_file_size=20000000;
    $destination_folder="Upload/Sample/"; //上传文件路径,必须属性为７７７否则出现移动文件出错的错误
    $watermark=2;   //是否附加水印(1为加水印,其他为不加水印);
    $watertype=1;   //水印类型(1为文字,2为图片)
    $waterposition=1;   //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
    $waterstring="wtenglish.com"; //水印字符串
    $waterimg="xplore.gif";  //水印图片
    $imgpreview=2;   //是否生成预览图(1为生成,其他为不生成);
    $imgpreviewsize=1/1;  //缩略图比例

    if (!is_uploaded_file($file['tmp_name']))//是否存在文件
    {
    echo "<font color='red'>文件不存在！</font>";
    exit;
    }

    if($max_file_size < $file["size"])//检查文件大小
    {
    echo "<font color='red'>文件太大！</font>";
    exit;
    }
    if(!file_exists($destination_folder)) mkdir($destination_folder);

    $filename=$file["tmp_name"];
    //$image_size = getimagesize($file["tmp_name"]);
    $pinfo=pathinfo($file["name"]);
    $ftype=$pinfo['extension'];
    $bfileName = $destination_folder.'b'.date('ymdHis').'.'.$ftype;//创建大图文件名和路径
    $sfileName = $destination_folder.'s'.date('ymdHis').'.'.$ftype; //创建小图文件名和路径
    if (file_exists($bfileName) || file_exists($sfileName) && $overwrite != true)
    {
      echo "<font color='red'>同名文件已经存在了！</a>";
      exit;
    }
    //dump($file);exit;
    //dump($destination);exit;
    $size=GetImageSize($file["tmp_name"]);
    //定义大图和小图的尺寸
    $picSize = array(
        'big'=>array($size[0],$size[1]),
        'small'=>array(30,30)
    );
    //echo($width);dump($size);exit;
    if($size[2]==1)
        $im_in=imagecreatefromgif($filename);
    if($size[2]==2)
        $im_in=imagecreatefromjpeg($filename);
    if($size[2]==3)
        $im_in=imagecreatefrompng($filename);
    if($size[2]==6)
        $im_in=imagecreatefrombmp($filename);

    $im_outB = imagecreatetruecolor($picSize['big'][0],$picSize['big'][1]);
    $im_outS = imagecreatetruecolor($picSize['small'][0],$picSize['small'][1]);
    imagecopyresampled($im_outB,$im_in,0,0,0,0,$picSize['big'][0],$picSize['big'][1],$size[0],$size[1]);
    imagecopyresampled($im_outS,$im_in,0,0,0,0,$picSize['small'][0],$picSize['small'][1],$size[0],$size[1]);
    if(!move_uploaded_file ($filename, $bfileName))
    {
        echo "<font color='red'>移动文件出错！</a>";
        exit;
    }

    $pinfoB=pathinfo($bfileName);
    $pinfoS=pathinfo($sfileName);
    $fnameB=$pinfoB['basename'];
    $fnameS=$pinfoS['basename'];
    $upfileB=$destination_folder.$fnameB;
    $upfileS=$destination_folder.$fnameS;
    //移动时改变图片大小
    imagejpeg($im_outB,$upfileB);
    imagejpeg($im_outS,$upfileS);
    chmod($upfileB,0777);
    chmod($upfileS,0777);
    return array('imageFile'=>$upfileB,'spicPath'=>$upfileS);
  }
 
    /**
     * ps ：复制功能
     * Time：2017年12月5日 15:44:39
     * @author shen
     * @param 参数类型
     * @return 返回值类型
    */
    function actionCopy() {
        $arr = $this->_modelExample->find(array('id' => $_GET['id']));
        unset($arr['id']);
        unset($arr['proCode']);
        $arr['picture']=$arr['imageFile'];
        $arr['spicPath']=$arr['spicPath'];
        // dump($arr);exit;
        //设置主表id的值
        foreach ($this->fldMain as $k => &$v) {
          $v['value'] = $arr[$k]?$arr[$k]:$v['value'];
        }
        foreach($arr['Products'] as &$v) {
          unset($v['id']);
          $temp = array();
          foreach($this->headSon as $kk => &$vv) {
            $temp[$kk] = array('value' => $v[$kk]);
          }
          $pro = $this->_modelExample->find(array('id' => $v['productId']));
          $temp['productId']=array('text' => $pro['proCode'],'value' => $pro['id']);
          $temp['proNameson']=array('value' => $pro['proName']."   ".$pro["guige"]);
          $temp['sonId']=array('value' => $v['id']);
          $rowsSon[] = $temp;
        }
        $i = 1;
        foreach($arr['Gongxu'] as &$vx) {
          unset($vx['id']);
          $temp = array();
          foreach($this->headGongxu as $key => &$vv) {
            if($key=='xuhao' && !$vx[$key]){
              $vx[$key]= $i;
              $i++;
            }elseif($key=='xuhao' && $vx[$key]){
              $i = $vx[$key];
              $i++;
            }
            $temp[$key] = array('value' => $vx[$key]);
          }
          $gongxuSon[] = $temp;
        }
        //补齐5行
        $cnt = count($rowsSon);
        for($i=5;$i>$cnt;$i--) {
          $rowsSon[] = array();
        }
        $cntGx = count($gongxuSon);
        for($i=5;$i>$cntGx;$i--) {
          $gongxuSon[] = array();
        }

        //补全序号
        if($cntGx<5){
          $i=1;
          foreach ($gongxuSon as $k => &$v) {
            if(!$v){
              $v['xuhao']['value'] =  $i;
            }else{
              $i = $v['xuhao']['value'];
            }
            $i++;
          }
        }
        
        // dump($this->fldMain);exit;
        $smarty = &$this->_getView();
        $smarty->assign('areaMain',array('title' => '入库基本信息', 'fld' => $this->fldMain));
        $smarty->assign('headSon', $this->headSon);
        $smarty->assign('headGongxu', $this->headGongxu);
        $smarty->assign('rowsSon', $rowsSon);
        $smarty->assign('gongxuSon', $gongxuSon);
        $smarty->assign('rules', $this->rules);
        $smarty->assign("otherInfoTpl",'Baojia/GongxuInfoTpl.tpl');
        $smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
        $smarty->assign('print', 'yes');
        $smarty->display('Main2Son/T1.tpl');
    }

    function actionViewChar(){
        // dump($_GET);die;
        $smarty = &$this->_getView();
        $smarty->assign('chars', $_GET['chars']);
        $smarty->display('Jichu/viewChar.tpl');
    }
}
?>