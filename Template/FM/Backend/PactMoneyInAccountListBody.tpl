{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.aid}&agentId={$data.agent_id}');">{$data.pact_no}</a></div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.pact_type_text}</div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_level_text}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.cash_deposit}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    {if $data.cash_post_money != ""}
    <a href="javascript:;" onclick="ViewPostMoneyDetail('{$data.agent_no}',1,{$data.product_type_id},'{$data.product_type_name}')">{$data.cash_post_money}</a>
    {/if}
    </div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.cash_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.pre_deposit}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    {if $data.pre_post_money != ""}
    <a href="javascript:;" onclick="ViewPostMoneyDetail('{$data.agent_no}',2,{$data.product_type_id},'{$data.product_type_name}')">{$data.pre_post_money}</a>
    {/if}
    </div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.pre_money}</div></td>
</tr>
{/foreach}