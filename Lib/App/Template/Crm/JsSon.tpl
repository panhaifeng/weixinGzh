{literal}
<script language="javascript">
$(function(){
    $('#province').change();
    $('#city').change();
	 //省市县联动
    $('#province').change(function(){
 		var province = $(this).val();

        var url="?controller=Crm_Intention&action=GetCity";
		var param={fatherid:province}
		$.getJSON(url,param,function(json){
            var cities = eval(json);
			if(cities){
                $('#city').html("<option value=''>请选择城市</option>");
                $('#area').html("<option value=''>请选择区域</option>");
                for(i=0;i<cities.length;i++){
                    $("<option value='"+cities[i]['cityid']+"'>"+cities[i]['city']+"</option>").appendTo("#city");
                    }
            }else{

            }
		});

    });
    $('#city').change(function(){
 		var city = $(this).val();
        var url="?controller=Crm_Intention&action=GetArea";
		var param={fatherid:city}
		$.getJSON(url,param,function(json){
            var area = eval(json);
            if(area){
                $('#area').html("<option value=''>请选择区域</option>");
                for(i=0;i<area.length;i++){
                    $("<option value='"+area[i]['areaid']+"'>"+area[i]['area']+"</option>").appendTo("#area");
                    }
            }else{

            }
		});

    });	
	

});
</script>
{/literal}