
<script language="javascript">
var orderCode = '{$orderCode|default:''}';
{literal}
// var orderCode = {$orderCode|default:'""'};
$(function(){	
	$('#traderId').change(function(){
		var param={id:$(this).val()};
		var url='?controller=Jichu_Employ&action=AjaxCodeAtEmploy'
			$.getJSON(url,param,function(json){
				var code = orderCode+json.codeAtEmploy
				$('#orderCode').val(code);
		})
	});
});
</script>
{/literal}