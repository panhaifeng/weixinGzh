{literal}
<script language="javascript">
$(function(){	

	$('[name="ord2proId"]').bind('onSel',function(event,ret){
		// debugger;
		// $(this).siblings('#rukuCode').val(ret.rukuCode);//产品编码
	 	// $(this).siblings('#ord2proId').val(ret.id);//从表id
	 	// $('#textBox').val(ret.orderCode);
	 	// $('#ord2proId').val(ret.ord2proId);
	    $('#proName').val(ret.proName);//产品名字
	    $('#guige').val(ret.guige);//产品规格
	    $('#pihao').val(ret.pihao);//批号
        $('#color').val(ret.color);//颜色
        $('#menfu').val(ret.menfu);//门幅
        $('#kezhong').val(ret.kezhong);//克重
	    $('#rukuId').val(ret.rukuId);//主表订单Id
	    $('#ruku2ProId').val(ret.ruku2ProId);//产品ID
		$('#supplierId').val(ret.supplierId);//产品ID
		$('#productId').val(ret.productId);//产品ID
		$('#rukuDate').val(ret.rukuDate);//产品ID
		$('#cnt').val(ret.cnt);//产品ID
		$('#danjia').val(ret.danjia);//产品ID
		$('#_money').val(ret.money);//产品ID
		$('#orderId').val(ret.orderId);//订单ID
	    return;
	});
});
</script>
{/literal}