<select name="dengji" id="dengji">
	<option value='' {if $arr_condition.dengji == ''} selected="selected" {/if}>请选择等级</option>
	<option value='好布' {if $arr_condition.dengji == '好布'} selected="selected" {/if}>好布</option>
	<option value='疵布' {if $arr_condition.dengji == '疵布'} selected="selected" {/if}>疵布</option>
	<option value='疵点多' {if $arr_condition.dengji == '疵点多'} selected="selected" {/if}>疵点多</option>
</select>