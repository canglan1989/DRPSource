{foreach from=$arrayAccountDetail item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a onclick="JumpPage('/?d=FM&c=GuaranteeMoney&a=PayMoneyDetail&id={$data.source_id}')" href="javascript:;">{$data.source_bill_no}</a></div></td>
    <td><div class="ui_table_tdcntr"><a onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}')" href="javascript:;">{$data.agent_pact_no}</a></div></td>
    <td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td ><div class="ui_table_tdcntr">
    {$data.data_type}
    </div></td>               
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.rev_money == 0}--{else}{$data.rev_money}{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.pay_money == 0}--{else}{$data.pay_money}{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.balance_money}</div></td>
    <td><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td><div class="ui_table_tdcntr">{$data.remark}</div></td>
</tr>
{/foreach}