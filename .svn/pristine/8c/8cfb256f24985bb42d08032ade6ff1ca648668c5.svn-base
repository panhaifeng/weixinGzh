{*2012-8-15 重构 by jeff,新特点
1,增加了扩展性，如果需要在Tbllist.tpl的基础上增加其他的功能，可以进行如下操作:
   比如，我需要在Tbllist.tpl现有的基础上增加其他的script，只需要
   a,在action中$smarty->assign('sonTpl', $sonTpl);//sonTpl为一个子模板，可在其中定义css文件和js代码
   b,新建一个sonTpl文件，定义function afterRender() {页面渲染后的执行动作},或者其他需要的函数等
1,固定表头*
2,表头超出内容宽度以内容宽度为准*
3,自带导出功能,导出使用javascript，必须进行相关设置，如果有异常，弹出提醒界面，提醒用户应该如何设置。自动去掉表格中的html代码
//改设计老车觉得不友好，去掉，还是使用后台导出的模式。
4,利用ext的布局管理自适应，自动匹配页面的高和宽。
5,样式改进，行背景色交替，onmouseover效果
6,打印需要使用lodop的自带分页功能进行打印。保证表头的锁定。
7,实现按字段排序的功能
td需要有padding
15,已设置的搜索条件，应该以红色表示，或者在页面的某个位置显示，以提醒客户目前的搜索条件。
9,搜索条件多了后，搜索栏不能自适应，很难看。
*}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{webcontrol type='LoadJsCss' src="Resource/Script/ext/adapter/ext/ext-base.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/ext/ext-all.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.query.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/common.js"}
{webcontrol type='LoadJsCss' src="Resource/Css/SearchItemTpl.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/ext/resources/css/ext-all.css"}
{webcontrol type='LoadJsCss' src="Resource/Css/TblList.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/tblList.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/TmisGrid.js"}
<script language="javascript">
var _hasSearch = {if $arr_condition}true{else}false{/if};
var _printUrl = '{$print_href|default:null}';//打印的url
var _printUrl1 = '{$print_href1|default:null}';//打印的url
var _showExport = '{$fn_export|default:null}';//是否显示导出
var _debug = false;//打开调试，不进行viewport，不显示蒙版
var _textPrint  = '{$textPrint|default:"打印"}';
var _textPrint1  = '{$textPrint1|default:"打印"}';
{literal}
try{//解决ie6下背景图片延迟的问题
	document.execCommand("BackgroundImageCache", false, true);
}
catch (e){
}
Ext.onReady(function() {
	//开始布局
	var items = [];
	if(_hasSearch && document.getElementById('searchGuide')) items.push({
		xtype: 'box',
		region: 'north',
		height: 28,
		//frame:true,
		contentEl: 'searchGuide'
	});

	var bbar = [{
		xtype: 'tbtext',
		contentEl: 'p_bar'
	}, '->',
	{
		text: ' 刷 新 ',
		iconCls: 'x-tbar-loading',
		cls: 'x-btn-mc',
		handler: function() {
			window.location.href = window.location.href
		}
	}];
	if(_printUrl || typeof(fnPrint) == 'function') {
		bbar.push('-');
		bbar.push({
			text: _textPrint,
			iconCls: 'btnPrint',
			handler: function() {
				if(typeof(fnPrint) == 'function') {
					fnPrint();
					return;
				}
				window.location.href = _printUrl;
			}
		});
	}
	if(_printUrl1 || typeof(fnPrint1) == 'function') {
		bbar.push('-');
		bbar.push({
			text: _textPrint1,
			iconCls: 'btnPrint1',
			handler: function() {
				if(typeof(fnPrint1) == 'function') {
					fnPrint1();
					return;
				}
				window.location.href = _printUrl1;
			}
		});
	}
	if(_showExport) {
		bbar.push('-');
		bbar.push({
			text: '导 出',
			iconCls: 'btnExport',
			handler: function() {
				window.location.href = _showExport;
				//alert('导出');
			}
		});
	}
	if(divGrid) items.push({
		id: 'gridView',
		collapsible: false,
		region: 'center',
		layout: 'fit',
		contentEl: 'divGrid',
		autoScroll: true,
		bbar: bbar
	});
	if(!_debug) var viewport = new Ext.Viewport({
		layout: 'border',
		items: items,
		onLayout: function() {
			
		},
		onRender: function() {
			//载入插件
			if(typeof(afterRender) != 'undefined') afterRender();
			Ext.QuickTips.init(); //使得所有标记了ext:qtip='点击显示订单跟踪明细'的元素显示出tip,比如
			Ext.apply(Ext.QuickTips.getQuickTip(), {
				dismissDelay: 0
			});
			//鼠标移上变边框
			$('[name="divRow"]', divGrid).hover(fnOver, fnOut);
			//表头以上改变cursor
			//$('.headTd', divGrid).mousemove(changeCursor);

			//使列宽可调整
			var splitZone = new SplitDragZone(divGrid);
			//载入插件
			if(typeof(afterRender) != 'undefined') afterRender();
			Ext.QuickTips.init(); //使得所有标记了ext:qtip='点击显示订单跟踪明细'的元素显示出tip,比如
			Ext.apply(Ext.QuickTips.getQuickTip(), {
				dismissDelay: 0
			});
			//<input value='' ext:qtip='点击显示订单跟踪明细' />
			renderForm(document.getElementById('FormSearch'));
		}
	});
	
	//自动加载鼠标提示信息
	qtipToCellContents();
	//处理搜索
	autoSearchDiv();
	Ext.get('loading').remove();
	Ext.get('loading-mask').remove();
	
});


//选择月份后改变dateFrom和dateTo
function changeDate(obj){
	//alert(obj.value);
	var df = document.getElementById('dateFrom');
	var dt = document.getElementById('dateTo');
	var d=new Date();
	// var year=;

	var year=$('#year').val()||d.getFullYear();
	var m=parseInt(obj.value)+1;
	// alert(m);
	if(m=='0'){
		m=d.getMonth()+1;
	}
	if(m<10) m="0"+m;
	df.value=year+'-'+m+'-'+'01';
	//如果为1、3、5、7、8、10、12一个月为31天
	// alert(obj.value);
	//如果只选择了年份，没选月份时，日期取当天的日期
	if(obj.value=='-1'){
		var day = d.getDate();
		dt.value=year+'-'+m+'-'+day;
	}
	if(obj.value=='0'||obj.value=='2'||obj.value=='4'||obj.value=='6'||obj.value=='7'||obj.value=='9'||obj.value=='11')
	{
		dt.value=year+'-'+m+'-'+'31';
	}
	//如果是2月份判断是否闰年
	if(obj.value=='1') {
		if((year%4==0 && year%100!=0) || year%400==0){
			dt.value=year+'-'+m+'-'+'29';
		}else{
			dt.value=year+'-'+m+'-'+'28';;
		}
	}
	if(obj.value=='13') {
		df.value='{/literal}{php}echo date("2000-01-01");{/php}{literal}';
		dt.value='{/literal}{php}echo date("Y-m-d",mktime(0,0,0,1,0,date("Y")+1));{/php}{literal}';
	}
	if(obj.value=='3'||obj.value=='5'||obj.value=='8'||obj.value=='10')
	{
		dt.value=year+'-'+m+'-'+'30';
	}

}

function form_submit(){
	document.getElementById("FormSearch").submit();
}
</script>

<style type="text/css">
table.hovertable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #999999;
	border-collapse: collapse;
}
table.hovertable th {
	background-color:#c3dde0;
	border-width: 1px;
	padding: 0px;
	border-style: solid;
	border-color: #a9c6c9;
	font-size:12px;	
	width:50px;
}
table.hovertable tr {
	background-color:#d4e3e5;
	
}
table.hovertable td {
	border-width: 1px;
	padding: 0px;
	border-style: solid;
	border-color: #a9c6c9;
	font-size:10px;	
}
.headTd{
	width:60px;
	}
</style>
{/literal}
{*需要在action中对sonTpl进行赋值,
$smarty->assign('sonTpl',sonTpl.tpl');
并新建一个sonTpl.tpl模板，如下：
literal
<script language='javascript'>
function fnPrint() {
	alert(1);
}
</script>
/literal
模板中可定义fnPrint(打印触发函数),或者print_href变量
*}
{if $sonTpl}{include file=$sonTpl}{/if}
</head>
<body style='position:static'>

<div id="loading-mask"></div>
<div id="loading">
  <div class="loading-indicator"><img src="Resource/Script/ext/resources/images/default/grid/loading.gif" width="16" height="16" style="margin-right:8px;" align="absmiddle"/>正在载入...</div>
</div>

{if $smarty.get.no_edit!=1}{include file="_Search.tpl"}{/if}
{*传递no_edit=1,可使_edit字段不显示*}
{*grid*}
<div id="divGrid" class="divGrid">
  <table border="1" cellpadding="0" cellspacing="0" id='tblHead' class="hovertable" width="1500">
  {*表头*}
   <tr>
    
      <th rowspan="2" style=" width:85px;" class='headTd'>订单号</th>
      <th rowspan="2" style=" width:240px;" class='headTd'>品名规格</th>
      <th rowspan="2" class='headTd'>颜色</th>
      <th rowspan="2" class='headTd'>开机机台</th>
      <th rowspan="2" class='headTd'>产品编号</th>
      <th rowspan="2" class='headTd'>生产欠数</th>
      <th rowspan="2" class='headTd'>订单数</th>
      <th rowspan="2" class='headTd'>业务员</th>
      <th colspan="2" style="text-align:center; width:120px;" class='headTd'>合计</th>
      <th rowspan="2" class='headTd'>入库匹数</th>
      <th rowspan="2" class='headTd'>入库数量</th>
      <th rowspan="2" class='headTd'>出库匹数</th>
      <th rowspan="2" class='headTd'>出库数量</th>
      <th rowspan="2" class='headTd'>库存匹数</th>
      <th rowspan="2" class='headTd'>库存数量</th>
      <th rowspan="2" style="width:65px;" class='headTd'>下单日期</th>
      <th rowspan="2" style="width:65px;" class='headTd'>交货日期</th>
      <th rowspan="2" class='headTd'>坯布门幅</th>
      <th rowspan="2" class='headTd'>坯布克重</th>
      <th colspan="2"  style="text-align:center; width:110px;" align="center" class='headTd'>白班</th>
      <th colspan="2"  style="text-align:center; width:110px;" align="center" class='headTd'>夜班</th>
  </tr>
  <tr>
      <th class='headTd'>匹数</th>
      <th class='headTd'>过磅数量</th>
      <th class='headTd'>开机数</th>
      <th class='headTd'>过磅数量</th>
      <th class='headTd'>开机数</th>
      <th class='headTd'>过磅数量</th>
  </tr>
  
  {*主内容*}
  {foreach from=$arr_field_value item=item}
  <tr style="height:30px;">
    <td>{$item.orderCode}</td>
    <td>{$item.proGuige}</td>
    <td>{$item.color}</td>
    <td>{$item.zhijiCode}</td>
    <td>{$item.proCode}</td> 
    <td>{$item.qianshu}</td>
    <td>{$item.cntYaohuo}</td>
    <td>{$item.traderName}</td>
    <td>{$item.Pcnt}</td>
    <td>{$item.liangCnt}</td>
    <td>{$item.rukuJian}</td>
    <td>{$item.rukuCnt}</td>
    <td>{$item.chukuJian}</td>
    <td>{$item.chukuCnt}</td> 
    <td>{$item.kucunJian}</td>
    <td>{$item.kucunCnt}</td>
    <td>{$item.orderDate}</td>
    <td>{$item.dateJiaohuo}</td>
    <td>{$item.menfu}</td>
    <td>{$item.kezhong}</td>
    <td>{$item.Bcnt}</td> 
    <td>{$item.Bcount}</td>
    <td>{$item.Ycnt}</td>
    <td>{$item.Ycount}</td>  
  </tr>
   {/foreach}
  </table>

</div>
<div id='p_bar'>{$page_info}</div>
</body>
</html>