{literal}
<script language="javascript">
$(function(){
	$('#_money,#zhekouMoney').change(function(){
		var _money = parseFloat($('#_money').val())||0;
		var zhekouMoney = parseFloat($('#zhekouMoney').val())||0;
		var money = (_money-zhekouMoney).toFixed(2);
		$('#money').val(money);
	});
	// debugger;

	//自动计算金额
	// $('#money').change(function(){
	// 	var s=$('#money').val();//保存初值
	// 	var cnt=parseFloat($('#cnt').val())||0;
	// 	var danjia=parseFloat($('#danjia').val())||0;
	// 	var money =(cnt*danjia).toFixed(2);
	// 	if(money=='0.00'){
	// 		$('#money').val(s);
	// 	}else{
	// 		$('#money').val(money);
	// 	}
		
	// })
    $('[name="cnt"],[name="danjia"]').change(function(){
        var danjia =parseFloat($('#danjia').val())||0;
        var cnt = parseFloat($('#cnt').val())||0;
        $('[name="money"]').val((danjia*cnt).toFixed(2));
        return;
    });

	$('[name="chuku2proId"]').bind('onSel',function(event,ret){
		//debugger;
		// alert(1);
		$('#qitaMemo').val(ret.qitaMemo);

		$('#clientName').val(ret.compName);
		$('#clientId').val(ret.clientId);

		$('#chukuDate').val(ret.chukuDate);
		$('#cnt').val(ret.cnt);
		$('#unit').val(ret.unit);
		$('#danjia').val(ret.danjia);
		$('#cnt').change();
		$('#productId').val(ret.productId);
		$('#chukuId').val(ret.chukuId);
		$('#orderId').val(ret.orderId);
		$('#ord2proId').val(ret.ord2proId);
		$('#kind').val(ret.kind);
		$('#_money').change();
	});
});
</script>
{/literal}