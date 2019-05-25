{if $arr_condition.dateTo!==null}
<select name="dateSelect" id="dateSelect" onchange="changeDateTime(this)">
	<!-- <option value= -1>月份</option>
		{section loop=12 name=loop}
			<option value={$smarty.section.loop.index}>{$smarty.section.loop.index+1}月</option>
		{/section}
	<option value=13>全部</option> -->
	<option value=-1>月份</option>
	<option value=14>本月</option>
	<option value=15>上月</option>
	<option value=16>本年</option>
	<option value=17>全部</option>
<!-- 	<option value=-1>月份</option>
	<option value=14>本月</option>
	<option value=15>上月</option>
	<option value=16>本年</option> -->
</select>
{/if}
<input name="dateFrom" type="text" id="dateFrom" value="{$arr_condition.dateFrom}" size="8" onclick="calendar()" emptyText='选择日期' placeholder='选择日期' />{if $arr_condition.dateTo!==null}到<input name="dateTo" size="8" type="text" id="dateTo" value="{$arr_condition.dateTo}"  onclick="calendar()" emptyText='选择日期' placeholder='选择日期'/>{/if}