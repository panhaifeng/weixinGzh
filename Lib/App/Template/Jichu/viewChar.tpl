<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    {webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css"}
    {webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
    {webcontrol type='LoadJsCss' src="Resource/Script/jquery.json.js"}
    {literal}
    <style type="text/css">
        html,body{overflow:hidden;}
        #selfcharsTab,#selfMode,#selfDrawingBoard{width: 97%;margin: 10px auto; zoom:1;position: relative;}
        #selfcharsTab .tabbody {height:60px;border: 1px solid #808080;}
        #selfcharsTab .tabbody span{ margin: 5px 3px;text-align: center;display:inline-block;width: 40px;height:16px;line-height: 16px;cursor: pointer; font-size: 20px; }
        input.charsItem{width: 1.5em;padding:.15em;text-align: center;font-size: 15px;}
        input.charsNum{width: 1.9em;text-align: center;font-size: 12px;}
        #boardBody{overflow: auto;height:350px;}
        .mode {border-bottom: gray 1px solid;}
        .removeChars{float: right;}
    </style>
    {/literal}
</head>

<script type="text/javascript">
    var index = '{$smarty.get.index}';
    var _chars = "{$chars}";
</script>

<body>
    <div id="selfMode" class="tabFooter">
        模式：<label for="btnLtR" class="mode">从左向右</label>
       <!--  <label for="btnLtR" class="mode"><input type="radio" name="inputMode" value="btnLtR" id="btnLtR">从左向右</label>
        &nbsp;
        <label for="btnTtD" class="mode"><input type="radio" name="inputMode" value="btnTtD" id="btnTtD">从上向下</label>
        &nbsp;
        <label for="btnSD" class="mode"><input type="radio" name="inputMode" value="btnSD" id="btnSD">手动</label> -->
       <!--  <span>
             &nbsp;|&nbsp;限定范围：
            <label for="row">行数</label>
            <input type="text" id="row" size="4">
            <label for="col">列数</label>
            <input type="text" id="col" size="6">
            <button id="btnChooseRange"> 选定 </button>
        </span> -->
        <button id='removeChars' class="removeChars btn btn-default">清空</button>
    </div>
    <div id="selfcharsTab">
        <div id="tabHeads" class="tabhead"></div>
        <div id="tabBodys" class="tabbody"></div>
    </div>
    <div id="selfDrawingBoard">
        <div id="boardBody" class="tabbody">
            <table id="selfHead" border="0" cellpadding="1" cellspacing="1">
            </table>
            <span>上三角</span>
            <table id="tableBoard" border="0" cellpadding="1" cellspacing="1">
            </table>
        </div>
    </div>

    <!-- 按钮区 -->
    <div class="form-group col-xs-12">
        <div class="text-center">
            <input class="btn btn-default" type="button" id="ok" name="ok" value=" 确定 ">
            <input class="btn btn-warning" type="button" id="back" name="back" value=" 返 回 ">
        </div>
    </div>

</body>
</html>
{webcontrol type='LoadJsCss' src="Resource/Script/selfchars.js"}

