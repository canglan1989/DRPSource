{foreach from=$arrayAccountDetail item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">
    {if $data.source_bill_no != ""}
    <a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=PayMoneyDetail&id={$data.source_id}')">{$data.source_bill_no}</a>
    {else}--{/if}
    </div></td>
    <td><div class="ui_table_tdcntr">    
    <a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}')">{$data.agent_pact_no}</a>    
    </div></td>
    <td ><div class="ui_table_tdcntr">{if $data.product_type_name == ""}--{else}{$data.product_type_name}{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.act_money}</div></td>
    <td ><div class="ui_table_tdcntr">
    {$data.data_type}
    </div></td>               
    <td><div class="ui_table_tdcntr">{$data.create_time}</div></td>
</tr>
{/foreach}