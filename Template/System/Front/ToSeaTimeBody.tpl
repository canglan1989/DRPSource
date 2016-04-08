{foreach from=$ToSeaTime item=data}
<tr class="">
    <td title=""><div class="ui_table_tdcntr">{$data.back_value}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if empty($data.front_value)}遵从默认时间区间范围{else}{$data.front_value}{/if}</div></td>
    <td title=""><div class="ui_table_tdcntr"><ul class="list_table_operation">
                <li><a m="FrontCommonSet" ispurview="true" v="4" onclick="setToSeaTime({$data.front_id},{$data.back_id})" href="javascript:;">设置</a></li>
    </ul></div></td>
</tr>
{foreachelse}
<tr class="">
    <td clospan="2"><div class="ui_table_tdcntr">无选项值</div><td>
</tr>
 {/foreach}