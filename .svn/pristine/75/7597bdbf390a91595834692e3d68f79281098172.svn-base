<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script src="Resource/Script/jquery.js"></script>
<script type="text/javascript">
{literal}

</script>
{/literal}
</head>

<body>

<form action="{url controller=$smarty.get.controller action='ExportChuku'}" method="POST">
  <div>选择导出的内容
     <input type="checkbox" name="gongjin" value="checkbox" /> 公斤
     <input type="checkbox" name="mi" value="checkbox" /> 米  
     <input type="checkbox" name="mashu" value="checkbox" /> 码数 
     <input type="checkbox" name="bang" value="checkbox" /> 磅
  </div>
     <div >
       <input type='hidden' name='id' value='{$id}' />
       <input type='submit' name='btnsubmit' value='提交' />
       <input type='button' name='btnreturn' value='返回' onclick="javascript:window.location.href='{url controller=Cangku_Chengpin_ChukuSell action='right'}'" />
     </div>
</form>
</body>
</html>
