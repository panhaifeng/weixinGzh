<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script src="Resource/Script/jquery.js"></script>
<script type="text/javascript">
  var jsonEnable = {$rowsE|@json_encode};
  // debugger;
{literal}
  $(function(){
    
    $('input[type!="hidden"]').attr('disabled',true);
    for(var i=0;jsonEnable[i];i++) {
      //debugger;
      $('#'+jsonEnable[i]).attr('disabled',false);
    }
     
     //控制ischeck 是否审核字段
     $('#subZuizhong').click(function(){
      //判断当前按钮的值
     //alert($('#subZuizhong').val());
        if($('#subZuizhong').val()==='最终审核'){

          $('#ischeck').val(1);
        }else{
           $('#ischeck').val(0);
        }
    });
  $('#memo').change(function(){
	//alert($('#memo').val());
	var gendan=$('#subGendan').val();
	if(gendan=='跟单审核') return true;
	var id=$('#trdId').val();
	var memo=$('#memo').val();
	var param={id:id,memo:memo};
	var url='?controller=Trade_Order&action=saveMemo'
	$.getJSON(url,param,function(json){
	})
	
	});
  });

</script>
<style type="text/css">
td{
  text-align: center;
}
input{
  width:90px;
}
</style>
{/literal}
</head>
<body>

<form action='' method="post">
<div >
  <div style="float:right">下单日期:{$ord2pro.Order.orderDate}</div>
  <div style="float:left">生产编号:{$ord2pro.Order.orderCode}</div>
  <div style="clear:both"></div>
</div>
<div>
  <div style="float:right">交货日期:{$ord2pro.dateJiaohuo}</div>
  <div style="float:left">产品编号:{$ord2pro.Products.proCode}</div>
   <div style="clear:both"></div>
</div>
<!-- <div>品名:{$ord2pro.Products.proName}</div>
<div>颜色：{$ord2pro.Products.color}</div>
<div>规格：{$ord2pro.Products.guige}</div>
<div>机型：</div>
<div>门幅：{$ord2pro.Products.menfu}</div>
<div>克重：{$ord2pro.Products.kezhong}</div>
<div>订单数量：{$ord2pro.cntYaohuo}</div>
<div>短溢范围：±{$ord2pro.Order.overflow}%</div> -->
<!-- <div><div>经营要求:</div><textarea rows="5" cols="100" name='memoTrade' id='memoTrade' readonly="true">{$ord2pro.Order.memoTrade}</textarea></div> -->
<!-- <div>工艺数据:</div> -->
<input type='hidden' id='ischeck' name='ischeck' value='{$ord2pro.Shenhe.isCheck}'/>
<div>
<table width="1090" height="200" border="1" style="border-collapse:collapse">
  <tr>
    <td colspan='3'>品名:</td>
    <td colspan='3'>{$ord2pro.Products.proName}</td>
    <td colspan='3'>品质样</td>
  </tr>
  <tr>
    <td colspan='3'>颜色:</td>
    <td colspan='3'>{$ord2pro.Products.color}</td>
    <td colspan='3' rowspan='7'>贴样处</td>
  </tr>
  <tr>
    <td colspan='3'>规格:</td>
    <td colspan='3'>{$ord2pro.Products.guige}</td>
  </tr>
  <tr>
    <td colspan='3'>机型:</td>
    <td colspan='3'>{$ord2pro.jixing}</td>
  </tr>
  <tr>
     <td colspan='3'>门幅:</td>
    <td colspan='3'>{$ord2pro.Products.menfu}</td>
  </tr>
  <tr>
     <td colspan='3'>克重:</td>
    <td colspan='3'>{$ord2pro.Products.kezhong}</td>
  </tr>
  <tr>
    <td colspan='3'>订单数量:</td>
    <td colspan='3'>{$ord2pro.cntYaohuo}</td>
  </tr>
  <tr>
     <td colspan='3'>短溢范围:</td>
    <td colspan='3'>±{$ord2pro.Order.overflow}%</td>
  </tr>
  <tr>
    <td colspan='3' style="text-align:left;">包装要求:{$ord2pro.Order.packing}</td>
    <td colspan='2' style="text-align:left;">跟单:{$ord2pro.Order.checkingMan}</td>
    <td colspan='2' style="text-align:left;">经向缩率:{$ord2pro.Order.warpShrink}</td>
    <td colspan='2' style="text-align:left;">纬向缩率:{$ord2pro.Order.weftShrink}</td>
  </tr>
  <tr>
   <!--  <td>
      经营要求
    </td> -->
    <td colspan="9" style='text-align:left'>经营要求:
      {$ord2pro.Order.memoTrade}
    </td>
  </tr>
  <tr >
    <td colspan="9" style="text-align:left;"><b>工艺数据:</b></td>
  </tr>
  <tr>
    <td  align="center">坯布</td>
    <td align="center">下机门幅</td>
    <td  align="center"><input type='text' name='pibuMenfu' id='pibuMenfu' value='{$sh.pibuMenfu}' /></td>
    <td align="center">下机克重</td>
    <td  align="center"><input type='text' name='pibuKeZhong' id='pibuKeZhong' value='{$sh.pibuKeZhong}' /></td>
    <td  align="center">线长</td>
    <td align="center"><input type='text' name='pibuXianChang' id='pibuXianChang' value='{$sh.pibuXianChang}' /></td>
    <td  align="center">成分</td>
    <td align="center"><input type='text' name='pibuChengfen' id='pibuChengfen' value='{$sh.pibuChengfen}' /></td>
  </tr>
  <tr>
    <td >成布</td>
    <td>成品门幅</td>
    <td><input type='text' name='ChengbuMenfu' id='ChengbuMenfu' value='{$sh.ChengbuMenfu}' /></td>
    <td>成品克重</td>
    <td><input type='text' name='ChengbuKeZhong' id='ChengbuKeZhong' value='{$sh.ChengbuKeZhong}' /></td>
    <!-- <td>打卷实际门幅</td>
    <td><input type='text' name='ChengbuShiJiMenfu' id='ChengbuShiJiMenfu' value='{$sh.ChengbuShiJiMenfu}' /></td>
    <td>打卷实际克重</td>
    <td><input type='text' name='ChengbuShiJiKeZhong' id='ChengbuShiJiKeZhong' value='{$sh.ChengbuShiJiKeZhong}' /></td> -->
  </tr>
  <tr>
    <td>测缩</td>
    <td>门幅cm</td>
    <td><input type='text' name='ceshiMenfu' id='ceshiMenfu' value='{$sh.ceshiMenfu}' /></td>
    <td>克重g/m2</td>
    <td><input type='text' name='ceshiKeZhong' id='ceshiKeZhong' value='{$sh.ceshiKeZhong}' /></td>
    <td>经向缩率</td>
    <td><input type='text' name='ceshiJingXiang' id='ceshiJingXiang' value='{$sh.ceshiJingXiang}' /></td>
    <td>纬向缩率</td>
    <td><input type='text' name='ceshiWeiXiang' id='ceshiWeiXiang' value='{$sh.ceshiWeiXiang}' /></td>
  </tr>
  <tr>
    <td  rowspan="6">用纱计划</td>
    <td>纱支</td>
    <!-- <td>比率</td> -->
    <td>纱厂家</td>
    <td>计划用纱</td>
    <!-- <td>纱情况</td> -->
    <td>比率</td>
    <td>用纱损耗</td>
    <!-- <td>实发坯布</td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='shifapibu' id='shifapibu' value='{$sh.shifapibu}' style="width:115px"></div>
    <div style="float:left;width:30px">匹</div>
    </div></td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='shifaGongjin' id='shifaGongjin' value='{$sh.shifaGongjin}' style="width:115px"></div>
    <div style="float:left;width:30px">公斤</div>
    </div></td> -->
    <td>机台号</td><td colspan="2"><input type='text' name='jitaihao' id='jitaihao' value='{$sh.jitaihao}'></td>
  </tr>
  <tr>
    <td><input type='text' name='shazhi1' id='shazhi1' value='{$sh.shazhi1}' /></td>
    <td><input type='text' name='shaqingkuang1' id='shaqingkuang1' value='{$sh.shaqingkuang1}' /></td>
    <td><input type='text' name='jihuaYongSha1' id='jihuaYongSha1' value='{$sh.jihuaYongSha1}' /></td>
    <td><input type='text' name='bilv1' id='bilv1' value='{$sh.bilv1}' /></td>
    <td><input type='text' name='sunhao1' id='sunhao1' value='{$sh.sunhao1}' /></td>
    <!-- <td>成布数量</td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='chengbushuliang' id='chengbushuliang' value='{$sh.chengbushuliang}' style="width:115px"></div>
    <div style="float:left;width:30px">匹</div>
    </div></td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='chengbuGongjin' id='chengbuGongjin' value='{$sh.chengbuGongjin} ' style="width:115px"></div>
    <div style="float:left;width:30px">公斤</div>
    </div></td> -->
    <td>实发坯布</td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='shifapibu' id='shifapibu' value='{$sh.shifapibu}' style="width:100px"></div>
    <div style="float:left;width:30px">匹</div>
    </div></td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='shifaGongjin' id='shifaGongjin' value='{$sh.shifaGongjin}' style="width:100px"></div>
    <div style="float:left;width:30px">公斤</div>
    </div></td>
  </tr>
  <tr>
     <td><input type='text' name='shazhi2' id='shazhi2' value='{$sh.shazhi2}' /></td>
    <td><input type='text' name='shaqingkuang2' id='shaqingkuang2' value='{$sh.shaqingkuang2}' /></td>
    <td><input type='text' name='jihuaYongSha2' id='jihuaYongSha2' value='{$sh.jihuaYongSha2}' /></td>
    <td><input type='text' name='bilv2' id='bilv2' value='{$sh.bilv2}' /></td>
    <td><input type='text' name='sunhao2' id='sunhao2' value='{$sh.sunhao2}' /></td>
   <!--  <td>定型损耗</td>
    <td colspan="2"><input type='text' name='dingxingSunhao' id='dingxingSunhao' value='{$sh.dingxingSunhao}'>%</td> -->
    <td>成布数量</td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='chengbushuliang' id='chengbushuliang' value='{$sh.chengbushuliang}' style="width:100px"></div>
    <div style="float:left;width:30px">匹</div>
    </div></td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='chengbuGongjin' id='chengbuGongjin' value='{$sh.chengbuGongjin} ' style="width:100px"></div>
    <div style="float:left;width:30px">公斤</div>
    </div></td>
  </tr>
  </tr>
   <tr>
    <td><input type='text' name='shazhi5' id='shazhi5' value='{$sh.shazhi5}' /></td>
    <td><input type='text' name='shaqingkuang5' id='shaqingkuang5' value='{$sh.shaqingkuang5}' /></td>
    <td><input type='text' name='jihuaYongSha5' id='jihuaYongSha5' value='{$sh.jihuaYongSha5}' /></td>
    <td><input type='text' name='bilv5' id='bilv5' value='{$sh.bilv5}' /></td>
    <td><input type='text' name='sunhao5' id='sunhao5' value='{$sh.sunhao5}' /></td>
    <td>已发数量</td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='yifashuliang' id='yifashuliang' value='{$sh.yifashuliang}' style="width:100px"></div>
    <div style="float:left;width:30px">匹</div>
    </div></td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='yifaGongjin' id='yifaGongjin' value='{$sh.yifaGongjin} ' style="width:100px"></div>
    <div style="float:left;width:30px">公斤</div>
    </div></td>
  </tr>
  <tr>
    <td><input type='text' name='shazhi3' id='shazhi3' value='{$sh.shazhi3}' /></td>
    <td><input type='text' name='shaqingkuang3' id='shaqingkuang3' value='{$sh.shaqingkuang3}' /></td>
    <td><input type='text' name='jihuaYongSha3' id='jihuaYongSha3' value='{$sh.jihuaYongSha3}' /></td>
    <td><input type='text' name='bilv3' id='bilv3' value='{$sh.bilv3}' /></td>
    <td><input type='text' name='sunhao3' id='sunhao3' value='{$sh.sunhao3}' /></td>
    <!-- <td>机台号</td>
    <td colspan="2"><input type='text' name='jitaihao' id='jitaihao' value='{$sh.jitaihao}'></td> -->
    <td>余布数量</td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='yubushuliang' id='yubushuliang' value='{$sh.yubushuliang}' style="width:100px"></div>
    <div style="float:left;width:30px">匹</div>
    </div></td>
    <td><div style="width:160px;">
    <div  style=" float:left;width:120px ;"><input type='text' name='yubuGongjin' id='yubuGongjin' value='{$sh.yubuGongjin} ' style="width:100px"></div>
    <div style="float:left;width:30px">公斤</div>
    </div></td>
  
  <tr>
    <td><input type='text' name='shazhi4' id='shazhi4' value='{$sh.shazhi4}' /></td>
    <td><input type='text' name='shaqingkuang4' id='shaqingkuang4' value='{$sh.shaqingkuang4}' /></td>
    <td><input type='text' name='jihuaYongSha4' id='jihuaYongSha4' value='{$sh.jihuaYongSha4}' /></td>
    <td><input type='text' name='bilv4' id='bilv4' value='{$sh.bilv4}' /></td>
    <td><input type='text' name='sunhao4' id='sunhao4' value='{$sh.sunhao4}' /></td>
    <!-- <td>次品数量</td>
    <td colspan="2"><input type='text' name='cipinshuliang' id='cipinshuliang' value='{$sh.cipinshuliang}'></td> -->
    <td>定型损耗</td>
    <td colspan="2"><input type='text' name='dingxingSunhao' id='dingxingSunhao' value='{$sh.dingxingSunhao}'>%</td>
  </tr>
 
  <!-- <tr>
    <td><input type='text' name='shazhi5' id='shazhi5' value='{$sh.shazhi5}' /></td>
    <td><input type='text' name='bilv5' id='bilv5' value='{$sh.bilv5}' /></td>
    <td><input type='text' name='jihuaYongSha5' id='jihuaYongSha5' value='{$sh.jihuaYongSha5}' /></td>
    <td><input type='text' name='shaqingkuang5' id='shaqingkuang5' value='{$sh.shaqingkuang5}' /></td>
    <td><input type='text' name='sunhao5' id='sunhao5' value='{$sh.sunhao5}' /></td>
    <td>完成日期</td>
    <td colspan="2"><input type='text' name='wanchengDate' id='wanchengDate' value='{$sh.wanchengDate}'></td>
  </tr> -->
  <tr>
  <!-- <td>生产备注</td> -->
    <td colspan="9" style='text-align:left'>生产备注:<textarea name='memo' id='memo' style="height:20px; width:90%;">{$sh.memo}</textarea>
    <input type='hidden' id='trdId' value='{$ord2pro.id}' />
    </td>
  </tr>
  <tr>
    <!-- <td>跟单备注</td> -->
    <td colspan="9" style='text-align:left'>跟单备注:<textarea name='memo2' id='memo2' style="height:20px; width:90%;">{$sh.memo2}</textarea>
    <input type='hidden' id='trdId' value='{$ord2pro.id}' />
    </td>
  </tr>
  <tr>
    <!-- <td>其他备注</td> -->
    <td colspan="9" style='text-align:left'>其他备注:<textarea name='memo3' id='memo3' style="height:20px; width:90%;">{$sh.memo3}</textarea>
    <input type='hidden' id='trdId' value='{$ord2pro.id}' />
    </td>
  </tr>
</table>
<div>审核人:{$sh.subTrader},审核时间:{$sh.subTraderTime}<input type='submit' value='{if $sh.subTrader}取消{else}业务员审核{/if}' name='subTrader' id='subTrader'/></div>
<div>审核人:{$sh.subGendan},审核时间:{$sh.subGendanTime}<input type='submit' value='{if $sh.subGendan}取消{else}跟单审核{/if}' name='subGendan' id='subGendan' /></div>
<div>审核人:{$sh.subZhizao},审核时间:{$sh.subZhizaoTime}<input type='submit' value='{if $sh.subZhizao}取消{else}织造审核{/if}' name='subZhizao' id='subZhizao' /></div>
<div>审核人:{$sh.subDingxing},审核时间:{$sh.subDingxingTime}<input type='submit' value='{if $sh.subDingxing}取消{else}定型审核{/if}' name='subDingxing' id='subDingxing' /></div>
<div>审核人:{$sh.subChengpin},审核时间:{$sh.subChengpinTime}<input type='submit' value='{if $sh.subChengpin}取消{else}成品审核{/if}' name='subChengpin' id='subChengpin' /></div>
<div>审核人:{$sh.subShengchan},审核时间:{$sh.subShengchanTime}<input type='submit' value='{if $sh.subShengchan}取消{else}生产负责审核{/if}' name='subShengchan' id='subShengchan' /></div>
<div>审核人:{$sh.subZuizhong},审核时间:{$sh.subZuizhongTime}<input type='submit' value='{if $sh.subZuizhong}取消{else}最终审核{/if}' name='subZuizhong' id='subZuizhong' /></div>
<div><input type="button" id="returnBack" name="returnBack" value='返回' onClick="javascript:window.location.href='{url controller=Trade_Order action='ShenheList'}'" /></div>
<input type='hidden' id='ord2proId' name='ord2proId' value='{$smarty.get.ord2proId}'/>
</form>
</body>
</html>
