<script language="javascript">
{literal}
$(function(){
 $('[name="setPrice[]"]').change(function(){
 	var index = $('[name="setPrice[]"]').index(this);
 	var id = $('[name="id[]"]').eq(index).val();
 	var value = $(this).val();
 	var url = "?controller=Jichu_Product&action=SetPrice";
 	var param = {id:id,price:value};
 	$.getJSON(url,param,function(json){
 		if(json==true){
 			alert('修改成功！');
 		}
 	});

 });
});
{/literal}
</script>