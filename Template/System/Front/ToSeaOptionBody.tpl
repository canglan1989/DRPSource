{foreach from=$ToSeaList item=data}
<tr class="">
    <td title=""><div class="ui_table_tdcntr">{$data.d_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.d_value}</div></td>
    <td title=""><div class="ui_table_tdcntr"><ul class="list_table_operation">
                <li><a m="FrontCommonSet" ispurview="true" v="16" onclick="setToSeaOption({$data.d_id},{$data.s_id},{$data.d_value})" href="javascript:;">编辑</a></li>
    </ul></div></td>
</tr>
{foreachelse}
<tr class="">
    <td clospan="2"><div class="ui_table_tdcntr">无选项值</div><td>
</tr>
 {/foreach}