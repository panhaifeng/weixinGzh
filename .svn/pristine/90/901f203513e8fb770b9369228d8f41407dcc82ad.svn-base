<script language="javascript">
{literal}
$(function(){
 $('[name="ratio[]"]').change(function(){
 	var index = $('[name="ratio[]"]').index(this);
 	var id = $('[name="id[]"]').eq(index).val();
 	var value = $(this).val();
 	var url = "?controller=Baojia_Ratio&action=SaveRatio";
 	var param = {id:id,ratio:value};
 	$.getJSON(url,param,function(json){
 		if(json==true){
 			alert('设置成功！');
 		}
 	});

 });
});
{/literal}
</script>