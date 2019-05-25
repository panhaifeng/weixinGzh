<?php
/*
*2014-3-26 by jeff : select需要被bootstrap控件使用，所以这里改动为select1
*/
function _ctlBtSelect($name,$params){	
	$itemName 	= $params['itemName'];
	$opts 	= $params['options'];
	$selected = $params['value'];
    $disabled = $params['disabled']?"disabled":'';
     //如果是在表格中显示，宽度需要自适应，方便显示内容,否则会压缩看不到内容.
    $autoWidth =  $params['inTable']?'style="width:auto;"':'';
    //$selected = 1;
    // dump($params);
    $model = $params['model'];
    $condition = $params['condition'];
 
    if($model!='') {
        if(count($opts)==0) { //根据model取得所有的基础档案数据
            $m = & FLEA::getSingleton($model);
            $rowset = $m->findAll($condition);
            foreach($rowset as & $v) {
                $opts[] = array('text'=>$v[$m->primaryName],'value'=>$v[$m->primaryKey]);
            }
            // dump($opts);exit;
        }       
    }

    $html = "<select name='{$itemName}' id='{$itemName}' {$disabled} class='form-control' {$autoWidth}>";
    $html .= "<option value=''>请选择</option>";
    foreach($opts as &$v) {
    	$html.= "<option value='{$v['value']}'";
    	if($selected==$v['value']) $html.=" selected ";
    	$html.=">{$v['text']}</option>";
    }
    $html .= "</select>";
	return $html;	
}
?>