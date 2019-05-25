{*
次模板为单一界面的通用模板，主要在基础档案中应用或其他单一表的编辑时使用
*}<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
</head>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap_eqinfo.css">
{literal}
<style type="text/css">
body{margin-left:5px; margin-top:5px; margin-right: 8px;}

.panel-body::-webkit-scrollbar {
  -webkit-appearance: none;
  background-color: rgba(0,0,0, .10);
  width: 8px;
  height: 8px;
}

.panel-body::-webkit-scrollbar-thumb {
  border-radius: 0;
  background-color: rgba(0,0,0, .4);
}
.btns { position:absolute; right:16px; top:1px; height:28px;}
.relative { position:relative;}
.frbtn {position:absolute; top:1px; right:0px; height:28px;z-index:1000;}
.pd5{ padding-left:5px;}
#heji { padding-left:20px; height:20px; line-height:20px; margin-bottom:5px;}
label.error {
  color: #FF0000;
  font-style: normal;
  position:absolute;
  right:-50px;
  top:5px;
}
.lableMain {
  padding-left: 2px !important;
  padding-right: 2px !important;
}
.trRow input{
  min-width: 75px;
}
.form-horizontal{
  overflow: hidden;
}
.trRow select{
  width: auto;
}
.btnSubmit .btn{
  padding: 6px 17px 6px 17px;
  font-weight: bold;
}
.heji_div_auto{
  /*margin-bottom: 0px;*/
  padding-left: 10px;
  height: 28px;
  /*background: #efefef;*/
  line-height: 28px;
}
</style>
{/literal}
<body>
<!-- <div class="panel panel-default"> --> <!-- class='container-min' -->
  <form name="form1" id="form1" class="form-horizontal" action="{url controller=$smarty.get.controller action=$form.action|default:'save'}" method="post" {if $form.upload==true}enctype="multipart/form-data"{/if}>

    <!-- 主表字段登记区域 -->
    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">{$title}</h3></div>
      <div class="panel-body">
        <div class="row">
          {foreach from=$fldMain item=item key=key}
          {include file="Main2Son/"|cat:$item.type|cat:".tpl"}
          {/foreach}
        </div>       
      </div>
    </div>

  {if $otherInfoTpl!=''}
  {include file=$otherInfoTpl}
  {/if}
  <div class="form-group col-xs-12">
    <div class="text-center btnSubmit">
        <input class="btn btn-info" type="submit" id="Submit" name="Submit" value=" 保存(Alt+S) " accesskey="S" onclick="$('#submitValue').val('保存')">
    {*其他一些功能按钮,*}
    {$other_button}
        {*<input class="btn btn-default" type="reset" id="Reset" name="Reset" value=" 重 置 ">*}
    </div>
  </div>
  <div style="clear:both;"></div>
  <input type='hidden' name='fromAction' value='{$smarty.get.fromAction|default:"right"}' />
  <input type='hidden' name='submitValue' id='submitValue' value=''/>
  <input type='hidden' name='fromController' value='{$fromController|default:$smarty.get.controller}' />
  </form>
<!-- </div> -->
{*通用的js代码放在_jsCommon中,主要是一些组件的效果*}
{include file='Main2Son/_jsCommon.tpl'}
{*下面是个性化的js代码,和特殊的业务逻辑挂钩,比如某些模板中自动合计的效果等*}
{if $sonTpl}
  {if $sonTpl|@is_string==1}
    {include file=$sonTpl}
  {else}
    {foreach from=$sonTpl item=js_item}
      {include file=$js_item}
    {/foreach}
  {/if}
{/if}
</body>
</html>