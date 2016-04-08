{foreach from=$arrayAccountDetail item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.account_detail_no}</div></td>
    <td><div class="ui_table_tdcntr"><a onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}');" href="javascript:;">{$data.agent_pact_no}</a></div></td>
    <td><div class="ui_table_tdcntr">
    {if $data.source_bill_no != ""}
    {$data.source_bill_no}
    {else}--{/if}
    </div></td>
    <td ><div class="ui_table_tdcntr">{$data.account_type}</div></td>
    <td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>               
    <td ><div class="ui_table_tdcntr">{$data.data_type}</div></td>  
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.rev_money != 0}{$data.rev_money}{else}--{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.pay_money != 0}{$data.pay_money}{else}--{/if}</div></td>  
    <td><div class="ui_table_tdcntr">{$data.create_user_name}</div></td>  
    <td><div class="ui_table_tdcntr">{$data.act_date}</div></td>
    <td><div class="ui_table_tdcntr">{$data.remark}</div></td>
</tr>
{/foreach}