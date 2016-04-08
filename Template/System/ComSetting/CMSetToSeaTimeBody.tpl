{foreach from=$ToSeaTimeList item=data}
<tr class="">
    <td title=""><div class="ui_table_tdcntr">{$data.d_value}</div></td>
    <td title=""><div class="ui_table_tdcntr"><ul class="list_table_operation">
                <li><a m="CustomerCommentParse" ispurview="true" v="4" onclick="setToSeaTimeParse({$data.d_id})" href="javascript:;">编辑</a></li>
                <li><a m="CustomerCommentParse" ispurview="true" v="4" onclick="delItem('/?d=System&c=ComSetting&a=DelToSeaTime&id={$data.d_id}','ToSeaTimeBody','/?d=System&c=ComSetting&a=getCMToSeaBody');" href="javascript:;">删除</a></li>
            </ul></div></td>
</tr>
{foreachelse}
<tr class="">
    <td clospan="2"><div class="ui_table_tdcntr">无时间限制</div><td>
</tr>
 {/foreach}