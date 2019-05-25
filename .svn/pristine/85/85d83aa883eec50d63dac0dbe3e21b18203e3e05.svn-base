{literal}
<script language="javascript">
$(function(){	
	//对控件的回调函数进行定义
	//ret为选中对象
	//为控件绑定一个自定义的事件,注意参数的写法
	$('[name="productId[]"]').bind('onSel',function(event,ret){	
		// debugger;	
	    var tr = $(this).parents(".trRow");
	    $('[name="proCode"]',tr).val(ret.proCode);
	    $('[name="productId[]"]',tr).val(ret.id);
	    $('[name="proName[]"]',tr).val(ret.proName);
	    $('[name="guige[]"]',tr).val(ret.guige);
	    //alert(ret.color);
	    $('[name="color[]"]',tr).val(ret.color);
	    if(!ret.unit){
	      $('[name="unit[]"]',tr).val('吨');
	    }
	    else{
	      $('[name="unit[]"]',tr).val(ret.unit);
	    }
	    $('[name="cnt[]"]',tr).focus();

	    // if(onSelProduct) onSelProduct(this);
	    return;
	});
});
</script>
{/literal}