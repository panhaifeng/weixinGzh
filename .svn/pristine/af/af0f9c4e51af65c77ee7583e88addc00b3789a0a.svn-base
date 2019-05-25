{literal}
<script language="javascript">
$(function(){
	$('#_money,#zhekouMoney').change(function(){
		var _money = parseFloat($('#_money').val())||0;
		var zhekouMoney = parseFloat($('#zhekouMoney').val())||0;
		var money = (_money-zhekouMoney).toFixed(2);
		$('#money').val(money);
	});
	
	$('#danjia').change(function(){
	//alert(1);
	var danjia=$('#danjia').val()||0;
	var cnt=$('#cnt').val()||0;
	var _money=(danjia*cnt).toFixed(2);
		$('#_money').val(_money);
		$('#money').val(_money);
	});
	

	$('[name="ruku2ProId"]').bind('onSel',function(event,ret){
		// debugger;
		// alert(1);
		$('#qitaMemo').val(ret.qitaMemo);
		$('#rukuId').val(ret.rukuId);//主表订单Id
		$('#supplierId').val(ret.supplierId);
		$('#productId').val(ret.productId);
		$('#rukuDate').val(ret.rukuDate);
		$('#cnt').val(ret.cnt);
		$('#danjia').val(ret.danjia);
		$('#_money').val(ret.money);
		$('#kind').val(ret.kind);//莠ｧ蜩！D
		$('#_money').change();
		

		// $('#qitaMemo').val(ret.qitaMemo);//颜色
		// $('#rukuId').val(ret.rukuId);//主表订单Id
		// // $('#ruku2ProId').val(ret.ruku2ProId);//产品ID
		// $('#supplierId').val(ret.supplierId);//产品ID
		// $('#productId').val(ret.productId);//产品ID
		// $('#rukuDate').val(ret.rukuDate);//产品ID
		// $('#cnt').val(ret.cnt);//产品ID
		// $('#danjia').val(ret.danjia);//产品ID
		// $('#_money').val(ret.money);//产品ID
		// // $('#kuweiName').val(ret.kuweiName);//产品ID
		// $('#kind').val(ret.kind);//产品ID
		// // $('#kuweiId').val(ret.kuwei);//产品ID
		// $('#_money').change();
	});
	

});
</script>
{/literal}