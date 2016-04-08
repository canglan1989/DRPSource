{foreach from=$arrayAccountList item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_name}</td>
    <td><div class="ui_table_tdcntr">{if $data.account_type == 1}保证金{elseif $data.account_type == 2}增值产品预存款{elseif $data.account_type == 7}网盟预存款{else}未知{/if}</td>
    <td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td> 
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.balance_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
</tr>
{/foreach}