{foreach from=$IntentionRatingList item=data}
    <tr>
<td title=""><div class="ui_table_tdcntr">{$data.rating_name}</div></td>
<td title=""><div class="ui_table_tdcntr">{$data.remark}</div></td>
<td title=""><div class="ui_table_tdcntr">{$data.sort_index}</div></td>
<td title=""><div class="ui_table_tdcntr">{if $data.is_money_time == "1"}是{else}否{/if}</div></td>
<td title=""><div class="ui_table_tdcntr">{if $data.is_report == "1"}是{else}否{/if}</div></td>
<td title=""><div class="ui_table_tdcntr"><ul class="list_table_operation">
            {if $data.is_report == "0"}
            <li><a m="CustomerInfo" ispurview="true" v="128" onclick="setIntentionRating({$data.rating_id})" href="javascript:;">编辑</a></li>
            <li><a m="CustomerInfo" ispurview="true" v="128" onclick="delItem('/?d=System&c=ComSetting&a=DelIntentionRating&id={$data.rating_id}','IntentionRatingBody','/?d=System&c=ComSetting&a=getCMIntentionRatingBody');" href="javascript:;">删除</a></li>
            {/if}
</ul></div></td>
    </tr>
{foreachelse}
 <tr><td clospan="6" title=""><div class="ui_table_tdcntr">无数据</div></td>   </tr>
{/foreach}