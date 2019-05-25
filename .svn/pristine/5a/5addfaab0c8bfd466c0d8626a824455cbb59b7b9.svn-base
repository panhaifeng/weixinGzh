{webcontrol type='LoadJsCss' src="Resource/Script/jquery.json.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/layer/layer.js"}
<script language="javascript">
var controller = '{$smarty.get.controller}';
var _removeUrl2='?controller={$smarty.get.controller}&action=RemoveGxByAjax';
{literal}
// var beforeSubmit= function(){
//     var perData = countPer();
//     if(!perData){
//     	alert('成分所占的比例和不为100%,请确认后再输入!');
//     }
//     return perData;
// };

// 计算纱支比例
var countPer = function(){
    var data ={};
    var viewPer = 0;
    $('.trRow').each(function(){
        var cnt = $('[name="viewPer[]"]',$(this)).val(),
     	pro = $('[name="productId[]"]',$(this)).val();
     	if(pro && !isNaN(cnt)){
	        viewPer =parseFloat(viewPer) + parseFloat(cnt?cnt:0);
     	}
    });
    if(viewPer=='100'){
    	return true;
    }
    return false;
}

$('[name="productId[]"]').bind('onSel',function(event,ret){
    $('[name="proNameson[]"]',$(this).parents('tr')).val(ret.proName);
});
$(function(){
    $('#btnAdd','[name="table_gongxu"]').click(function(){
      var tbl=$(this).parents('.trRow').attr('name');
      fnAdd('[name="table_gongxu"]');
    });


    $('#btnAdd','[name="table_main"]').click(function(){
      	var tbl=$(this).parents('.trRow').attr('name');

      	var rows = $('.trRow','[name="table_main"]');
		var len = rows.length;
		for(var i=0;i<5;i++) {
		  var nt = rows.eq(len-1).clone(true);
		  $('input,select',nt).val('');
		
		  //拼接
		  $('[name="table_main"]').append(nt);
		}
		return;

    });

    //联动显示纱支比例
	 $('[name="viewPer[]"]').live('change',function(){
    	var viewPer = 0;
		$('.trRow').each(function(){
	        var cnt = $('[name="viewPer[]"]',$(this)).val(),
	     	pro = $('[name="productId[]"]',$(this)).val();
	     	if(pro && !isNaN(cnt)){
		        viewPer =parseFloat(viewPer) + parseFloat(cnt?cnt:0);
	     	}
	    });
	    if(viewPer!='100'){
	    	var showViewPer = '('+viewPer+'%)';
			$('.needChange').text(showViewPer);
	    }else{
			$('.needChange').text('');
	    }
	});

	//点击工艺字符
 	$('[name="btBtnChar"]').click(function(){
        //先取得批号和产品Id
        var tr = $(this).parents('.trRow');
        var index=$('[name="btBtnChar"]').index(this);
        var chars=$('[name="chars"]').val();

        var url="?controller="+controller+"&action=ViewChar&index="+index+"&chars="+chars;
        Char_layer = $.layer({
              type: 2,
              shade: [1],
              fix: false,
              title: '选择',
              maxmin: true,
              iframe: {src : url},
              // border:false,
              area: ['1024px' , '640px'],
              close: function(index){//关闭时触发
                  
              },
              //回调函数定义
              callback:function(index,ret) {
                $('[name="btBtnChar"]').val(ret.data);
                $('[name="chars"]').val(ret.data);
            }
        });
    })


    $('[id="btnRemoveA"]').click(function(){
	    //利用ajax删除,后期需要利用sea.js进行封装
	    var url=_removeUrl2;
	    var trs = $('.trRow');
	    if(trs.length<=1) {
	      alert('至少保存一个明细');
	      return;
	    }

	    var tr = $(this).parents('.trRow');
	    var id = $('[name="gxId[]"]',tr).val();
	    if(!id) {
	      tr.remove();
	      return;
	    }

	    if(!confirm('此删除不可恢复，你确认吗?')) return;
	    var param={'id':id};
	    $.post(url,param,function(json){
	      if(!json.success) {
	        alert('出错');
	        return;
	      }
	      tr.remove();
	      window.parent.showMsg('删除成功!');
	    },'json');
	    return;
  	});

});
//修改布匹图片时，删除原有图片，2015-09-11，by liuxin
function setBox(){
	var imagevalue=document.getElementById('imageFile').value;
	var cbdelImage=document.getElementById('isDelImage');
	if(imagevalue!='' &&　cbdelImage!=null){
		document.getElementById('isDelImage').checked=true;			
	}else{
		document.getElementById('isDelImage').checked=false;
	}
}
function fnAdd(tblId) {
	var rows = $('.trRow',tblId);
	var len = rows.length;
	var xuhao=$('[name="xuhao[]"]').eq(-1).val();
	for(var i=0;i<5;i++) {
	  var nt = rows.eq(len-1).clone(true);
	  $('input,select',nt).val('');
	  $('input[type="radio"],input[type="checkbox"]',nt).attr('checked',false);
	  if(isNaN(parseInt(xuhao))){
		  $('[name="xuhao[]"]',nt).val();
	  }else{
		  $('[name="xuhao[]"]',nt).val(parseInt(xuhao)+1+i);
	  }
	   //加载新增后运行的代码
	  if(typeof(beforeAdd) == 'function'){
	    beforeAdd(nt,tblId);
	  }
	  //拼接
	  $(tblId).append(nt);
	}
	return;
}

function tb_remove(){
    layer.close(Char_layer); //执行关闭
}
{/literal}
</script>