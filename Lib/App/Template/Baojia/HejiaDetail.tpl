<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>{$title}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  {webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
  {webcontrol type='LoadJsCss' src="Resource/Script/Print/LodopFuncs.js"}
</head>
<body>
<div id="printBox" style=" width:210mm; margin:0 auto; position:relative;">
{literal}
<style>
table{
  border-collapse:collapse;
}
.tr-t{border: 1px solid #000; text-align:center; height:35px; vertical-align:middle;}
.tr-td{font-size:16px;font-weight:900;}
</style>
{/literal}
<!-- <div id="div1">
<div style="line-height: 25px;font-size:20px;letter-spacing:15px;" align=center>
<STRONG>沃丰纺织核价单</STRONG></div>  
</div> -->
<div> 
<table border=1 cellSpacing=0 cellPadding=1 width="100%" style="border-collapse:collapse" bordercolor="#333333">
  <tbody>
      <tr style=" border: 1px solid #000; text-align:center; height:40px; vertical-align:middle;font-size:22px;font-weight:900;">
        <td colspan="5">苏博纺织核价单</td>
      </tr>
       <tr class="tr-t">
        <td class="tr-td">产品编码</td>
        <td colspan="4">{$aRow.proCode}</td>
      </tr>
      <tr class="tr-t">
        <td class="tr-td">品名</td>
        <td colspan="4">{$aRow.proName}</td>
      </tr>
      <tr class="tr-t">
        <td class="tr-td">规格</td>
        <td colspan="4">{$aRow.guige}</td>
      </tr>
      <tr class="tr-t">
        <td class="tr-td">门幅/克重</td>
        <td colspan="4">{$aRow.menfu}/{$aRow.kezhong}</td>
      </tr>
      <tr class="tr-t">
        <td class="tr-td">系数</td>
        <td colspan="4">{$aRow.ratio}</td>
      </tr>
      <tr class="tr-t">
        <td class="tr-td">纱比</td>
        <td class="tr-td">用纱</td>
        <td class="tr-td">比例%</td>
        <td class="tr-td">单价</td>
        <td class="tr-td">金额</td>
      </tr>
      {foreach from=$aRow.Products item=sha key=key}
      <tr class="tr-t">
        <td></td>
        <td>{$sha.proName}</td>
        <td>{$sha.viewPer}</td>
        <td>{$sha.price}</td>
        <td>{$sha.money}</td>
      </tr>
      {/foreach}
      <tr class="tr-t">
        <td class="tr-td">工序</td>
        <td class="tr-td">工序名称</td>
        <td class="tr-td">损耗系数</td>
        <td class="tr-td"></td>
        <td class="tr-td">金额</td>
      </tr>
      {foreach from=$aRow.Gongxu item=gongxu }
      <tr class="tr-t">
        <td></td>
        <td>{$gongxu.name}</td>
        <td>{$gongxu.sunhaoXiShu}</td>
        <td></td>
        <td>{$gongxu.price}</td>
      </tr>
      {/foreach}
      <tr class="tr-t">
        <td class="tr-td">报价</td>
        <td colspan="4">{$aRow.money}</td>
      </tr>
   </tbody>
  
   </table>
</div>
</div>
</body>
</html>