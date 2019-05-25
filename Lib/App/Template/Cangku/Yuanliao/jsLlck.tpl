<script language="javascript">
{literal}
//本行的产品信息进行自动选择
$("[name='ord2proId[]']").bind('onSel',function(event,ret){
	// debugger;
	var tr = $(this).parents('.trRow');
	$('[name="productId[]"]',tr).val(ret.productId);
	$('[name="proCode"]',tr).val(ret.proCode);
	$('[name="proName[]"]',tr).val(ret.proName);
	$('[name="guige[]"]',tr).val(ret.guige);
	$('[name="color[]"]',tr).val(ret.color);
	// $('[name="proCode"]',tr).val(ret.productId);
	// $('[name="proCode"]',tr).val(ret.productId);
	// var g = $(this).parents('.input-group');
	//  $('#textBox',g).val(ret.orderCode);
	//  $("[name='ord2proId[]']",g).val(ret.id);
	// alert(1);
});
{/literal}
</script>