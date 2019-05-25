<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Baojia_Ratio extends Tmis_Controller{
  var $_modelExample;
  ///构造函数
  function __construct() {
    $this->_modelExample = & FLEA::getSingleton('Model_Jichu_Product');
  }
  function actionListForSet() {
    $this->authCheck('10-2');
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      	'proCode' => '',
    		'proName' => '',
    		'guige' => '',
    		'chenfen' => '',
        'kezhong'=>'',
        'leixing'=>'',
    ));
    $str = "select * from jichu_product where 1 and kind='针织'";
    if ($arr['proCode']!='') $str .= " and proCode like '%{$arr['proCode']}%'";
    if ($arr['proName']!='') $str .= " and proName like '%{$arr['proName']}%'";
    if ($arr['guige']!='') $str .= " and guige like '%{$arr['guige']}%'";
    if ($arr['chenfen']!='') $str .= " and chengFen like '%{$arr['chenfen']}%'";
    if($arr['kezhong']!='')$str .= " and kezhong like '%{$arr['kezhong']}%'";
    if($arr['leixing']!='')$str .= " and kind like '%{$arr['leixing']}%'";
    $str .=" order by proCode desc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAllBySql($str);
    if(count($rowset)>0) foreach($rowset as & $v){
        $v['ratio'] = $v['ratio']==0?'':$v['ratio'];
        $v['ratio']="<input type='text' name='ratio[]' value='{$v['ratio']}' />
      				<input type='hidden' name='id[]' value='{$v['id']}' />";
    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '产品系数设置');
  	$arr_field_info = array(
		"kind" => '类别',
		"proCode" => "产品编号",
		"proName" => "品名",
		"color" => "颜色" ,
		"guige" => "规格",
		"chengFen" =>"成份",
		'menfu'=>'门幅',
		'kezhong'=>'克重',
		"ratio"=>'系数'
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
     * ps ：系数设置
     * Time：2016/11/03 23:01:03
     * @author Sjj
     * @param 参数类型
     * @return 返回值类型
    */
    function actionSaveRatio(){
        $row = array(
            'id'=>$_GET['id'],
            'ratio'=>$_GET['ratio']
        );
        $this->_modelExample->save($row);
        echo json_encode(true);exit;
    }


}
?>