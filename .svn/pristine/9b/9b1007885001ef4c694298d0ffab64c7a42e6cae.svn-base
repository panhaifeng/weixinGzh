<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Baojia_Report extends Tmis_Controller {
	var $_modelExample;
	var $fldMain; 
	var $explodeStr; 
	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Jichu_Product'); 
	}

	function actionReport() {
		$this->authCheck('10-3');
	    FLEA::loadClass('TMIS_Pager');
	    $arr = TMIS_Pager::getParamArray(array(
			'proCode' => '',
			'proName' => '',
			'guige'   => '',
			'chenfen' => '',
			'leixing' => '',
			'kezhongFrom' => '',
			'kezhongTo' => '',
			'moneyFrom' => '',
			'moneyTo' => '',
	    ));
	    // $str = "select * from jichu_product where 1 and state=1";
		$str =  "select x.*,y.viewPer
			from jichu_product  x
			left join jichu_product_chengfen y on x.id=y.proId 
			where 1 and x.kind='针织' 
			";
	    if ($arr['proCode']!='') $str .= " and x.proCode like '%{$arr['proCode']}%'";
	    if ($arr['proName']!='') $str .= " and x.proName like '%{$arr['proName']}%'";
	    if ($arr['guige']!='') $str .= " and x.guige like '%{$arr['guige']}%'";
	    if ($arr['chenfen']!='') $str .= " and x.chengFen like '%{$arr['chenfen']}%'";
	    if($arr['leixing']!='')$str .= " and x.kind like '%{$arr['leixing']}%'";
    	if(is_numeric($arr['kezhongFrom'])) $str .= "  and left(x.kezhong,3)>='{$arr['kezhongFrom']}'";
    	if(is_numeric($arr['kezhongTo'])) $str .= " and left(x.kezhong,3)<='{$arr['kezhongTo']}'";
    	 $str .= " GROUP BY x.id ";
	    if(is_numeric($arr['moneyFrom'])) $str .= "   having  money>='{$arr['moneyFrom']}' ";
    	if(is_numeric($arr['moneyTo'])) $str .= " and money<='{$arr['moneyTo']}'";

    	// dump($str);die;
	   
	    // dump($str);die;
	    $str .=" order by x.proCode desc,x.proName asc,x.guige asc";
	    $pager =& new TMIS_Pager($str);
	    $rowset =$pager->findAllBySql($str);
	    // dump($rowset);die;
	    if(count($rowset)>0) foreach($rowset as & $v){
	       // $baojia = $this->getBaojia($v['id']);
	       /*$v['money'] = round($v['money'],2);*/
	       $sqls = "select x.productId,y.price,x.viewPer
	                from jichu_product_chengfen x
	                left join jichu_product y on x.productId=y.id
	                where x.proId = '{$v['id']}'
	       ";
	       	$shazhi = $this->_modelExample->findBySql($sqls);
      	 	$gongxusql = "select j.price as gongxuPrice,j.sunhaoXiShu,a.ratio from jichu_product a left join jichu_product_gongxu b on a.id = b.productId left join baojia_gongxu j on b.gongxuId = j.id where b.productId = '{$v['id']}'";
     	   	$gongxuInfo = $this->_modelExample->findBySql($gongxusql);
            $v['ratios'] = $gongxuInfo[0]['ratio'];
     	   	$price = 0;
     	   	$pTotal = 0;
     	   	foreach ($shazhi as $key => &$value) {
     	   		$price +=(round($value['price']*$value['viewPer']/100,2)); 
     	   	}
     	   	/*dump($price);die;*/
     	   	$i = 0;
     	   	foreach ($gongxuInfo as $ke => &$va) {
     	   		
     	   		if($i==0){
     	   			$price = $price;
     	   		}else{
     	   			$price = $pTotal;
     	   		}
     	   		$pTotal = ($price+$va['gongxuPrice'])*$va['sunhaoXiShu'];
     	   		$i++;
     	   	}

		   $v['money'] = $pTotal*$v['ratios']*1.035+0.5;
	       $v['money'] = "<a href='".$this->_url('Detail',array(
					'id'    => $v['id'],
					'moneys' => $v['money']
   	       		))."' target='_blank'>{$v['money']}</a>";
	    }


	    $smarty = & $this->_getView();
	    $smarty->assign('title', '产品报价一览表');
	  	$arr_field_info = array(
			"kind"     => '类别',
			"proCode"  => "产品编号",
			"proName"  => "品名",
			"color"    => "颜色" ,
			"guige"    => "规格",
			"chengFen" => "成份",
			'menfu'    => '门幅',
			'kezhong'  => '克重',
			"money"   => '报价'
	  	);
	    $smarty->assign('arr_field_info',$arr_field_info);
	    $smarty->assign('arr_field_value',$rowset);
	    $smarty->assign('arr_condition',$arr);
    	$smarty->assign('add_display', 'none');
	    $smarty->assign('sonTpl', 'Baojia/JsRatio.tpl');
	    $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
	    $smarty-> display('TblList.tpl');
	} 

	/**
	 * ps ：获取产品纱和工序成本
	 * Time：2016/11/04 09:20:19
	 * @author Sjj
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function getBaojia($id){
		$sqlSha = "select sum(x.viewPer/100*y.price) as shaMoney
			from jichu_product_chengfen x
			left join jichu_product y on x.productId=y.id
			where x.proId='{$id}'";
		$sha = $this->_modelExample->findBySql($sqlSha);
		$sqlGX = "select sum(b.price) as gxMoney
			from jichu_product_gongxu a 
			left join baojia_gongxu b on a.gongxuId=b.id
			where a.productId='{$id}'";
		$gongxu = $this->_modelExample->findBySql($sqlGX);
		return $sha[0]['shaMoney']+$gongxu[0]['gxMoney'];
	}
	/**
	 * ps ：产品报价组成
	 * Time：2016/11/04 09:19:56
	 * @author Sjj
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionDetail(){
		$row = $this->_modelExample->find($_GET['id']);
		$moneys = $_GET['moneys'];
		// dump($moneys);die;
		$money = 0;
		foreach($row['Products'] as & $vs){
			$sqlSha = "select proName,price from jichu_product where id='{$vs['productId']}'";
			$sha = $this->_modelExample->findBySql($sqlSha);
			$vs['proName'] = $sha[0]['proName'];
			$vs['price'] = $sha[0]['price'];
			$vs['money'] = round($vs['price']*$vs['viewPer']/100,2);
			
		}
		$row['Products'][] = $hejiSha= $this->getHeji($row['Products'],array('money'),'proName');
		foreach($row['Gongxu'] as & $vx){
			$sqlGX = "select name,price,sunhaoXiShu from baojia_gongxu where id='{$vx['gongxuId']}'";
			$gongxu = $this->_modelExample->findBySql($sqlGX);
			$vx['name'] = $gongxu[0]['name'];
			$vx['price'] = $gongxu[0]['price'];
			$vx['sunhaoXiShu'] = $gongxu[0]['sunhaoXiShu'];
		}
		$row['Gongxu'][] = $hejiGx = $this->getHeji($row['Gongxu'],array('price'),'name');
		/*$row['money'] = round(($hejiSha['money']+$hejiGx['price'])*$row['ratio'],2);*/
		$row['money'] = $moneys;
		// dump($row);die;
		$smarty = & $this->_getView();
	    $smarty->assign('title', '核价单');
	    $smarty->assign('aRow',$row);
	    $smarty->display('Baojia/HejiaDetail.tpl');
	}

}

?>