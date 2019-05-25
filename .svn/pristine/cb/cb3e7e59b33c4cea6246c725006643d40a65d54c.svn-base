<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>条码打印</title>
<link href="Resource/Css/Print.css" type="text/css" rel="stylesheet" />
{literal}
<script language="javascript" src="Resource/Script/Print/LodopFuncs.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<param name="CompanyName" value="常州易奇信息科技有限公司">
	<param name="License" value="664717080837475919278901905623">
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop.exe"></embed>
</object>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/Print.css" type="text/css" rel="stylesheet" />
<script language="javascript">
$(function(){
	prn1_preview();
})

//传递的参数处理
var obj ={/literal}{$aRow|@json_encode}{literal};
// alert(obj.proName);
function prn1_preview() {
	//dump(obj);
	CreateOneFormPage(obj);
	// LODOP.PRINT_DESIGN();return false;
	LODOP.PREVIEW();//return false;
	//LODOP.PRINT();
	window.close();
};
var LODOP;
function CreateOneFormPage(obj){
		LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));

		LODOP.PRINT_INITA(0,5,522,333,"");
		LODOP.SET_PRINT_PAGESIZE(1,"60mm","45mm","条码打印");
		//竖线
		// LODOP.ADD_PRINT_LINE(34,-4,131,-3,0,1);
		// LODOP.ADD_PRINT_LINE(34,60,130,61,0,1);
		// LODOP.ADD_PRINT_LINE(34,250,131,251,0,1);
		// LODOP.ADD_PRINT_LINE(34,-4,35,250,0,1);
		// LODOP.ADD_PRINT_LINE(55,-4,56,252,0,1);
		// LODOP.ADD_PRINT_LINE(74,-3,75,251,0,1);
		// LODOP.ADD_PRINT_LINE(93,-4,94,250,0,1);
		// LODOP.ADD_PRINT_LINE(111,-3,112,251,0,1);
		// LODOP.ADD_PRINT_LINE(130,-4,131,250,0,1);

		LODOP.SET_PRINT_STYLE("FontSize",14);
		LODOP.SET_PRINT_STYLE("Alignment",2);
		LODOP.SET_PRINT_STYLE("Bold",1);
		LODOP.ADD_PRINT_TEXT(2,2,215,23,"苏博针织");
		LODOP.SET_PRINT_STYLE("FontSize",8);
		LODOP.SET_PRINT_STYLE("Alignment",2);
		LODOP.SET_PRINT_STYLE("Bold",0);
		// LODOP.ADD_PRINT_TEXT(20,-6,258,23,"WOFENG DYEING CO.LTD");
		LODOP.SET_PRINT_STYLE("FontName","黑体");
		LODOP.SET_PRINT_STYLE("FontSize",8);
		LODOP.SET_PRINT_STYLE("Alignment",0);

		LODOP.ADD_PRINT_TEXT(30,4,80,20,"编号 Art");
		LODOP.ADD_PRINT_TEXT(47,4,80,20,"品名 Dcrp");		
		LODOP.ADD_PRINT_TEXT(64,4,80,20,"规格 Spec");
		LODOP.ADD_PRINT_TEXT(81,4,80,20,"成分 Comp");
		LODOP.ADD_PRINT_TEXT(98,4,80,20,"门幅 Width");
		LODOP.ADD_PRINT_TEXT(115,4,80,20,"克重 Wei");

		LODOP.SET_PRINT_STYLE("FontName","黑体");
		LODOP.SET_PRINT_STYLE("FontSize",10);
		//编号
		LODOP.ADD_PRINT_TEXT(30,71,170,20,obj.proCode=obj.proCode!=null?obj.proCode:'');
		//品名
		LODOP.ADD_PRINT_TEXT(47,71,170,20,obj.proName=obj.proName!=null?obj.proName:'');
		//规格
		LODOP.ADD_PRINT_TEXT(64,71,220,20,obj.guige=obj.guige!=null?obj.guige:'');
		//成分
		LODOP.ADD_PRINT_TEXT(81,71,220,20,obj.chengFen=obj.chengFen!=null?obj.chengFen:'');
		//门幅
		LODOP.ADD_PRINT_TEXT(98,71,170,20,obj.menfu=obj.menfu!=null?obj.menfu+' cm':'');
		//克重
		LODOP.ADD_PRINT_TEXT(115,71,170,20,obj.kezhong=obj.kezhong!=null?obj.kezhong+' g/㎡':'');
		// LODOP.ADD_PRINT_BARCODE(128,9,209,40,"128A","WF721721T-FH");
		LODOP.ADD_PRINT_BARCODE(128,9,209,40,"128A",obj.proCode);


}


</script>

<style type="text/css">
.tdList td{height:40px;}
.fuckTd span{font-weight:normal}
#rsTable td{font-size:14px;}
.xhx {width:200px; border-bottom:1px solid #000;}
</style>
{/literal}
</head>

<body onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()" style="text-align:center">
<div></div>
</body>
</html>
