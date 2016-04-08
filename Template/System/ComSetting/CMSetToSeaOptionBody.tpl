{foreach from=$ToSeaOptionList item=data}
<tr class="">
    <td title=""><div class="ui_table_tdcntr">{$data.d_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.d_value}</div></td>
    <td title=""><div class="ui_table_tdcntr"><ul class="list_table_operation">
                <li><a m="CustomerCommentParse" ispurview="true" v="8" onclick="setToSeaOptionParse({$data.d_id})" href="javascript:;">编辑</a></li>
                <li><a m="CustomerCommentParse" ispurview="true" v="8" onclick="delItem('/?d=System&c=ComSetting&a=DelToSeaOption&id={$data.d_id}','ToSeaOptionBody','/?d=System&c=ComSetting&a=getCMToSeaOptionBody');" href="javascript:;">删除</a></li>
    </ul></div></td>
</tr>
{foreachelse}
<tr class="">
    <td clospan="2"><div class="ui_table_tdcntr">无选项值</div><td>
</tr>
 {/foreach}