{foreach from=$arrayAccountDetail item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.account_detail_no}</div></td>
    <td><div class="ui_table_tdcntr"><a onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}');" href="javascript:;">{$data.agent_pact_no}</a></div></td>
    <td ><div class="ui_table_tdcntr">{$data.account_type}</div></td>
    <td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td ><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AccountLevelDetail&id=',{literal}{{/literal}id:{$data.finance_uid}{literal}}{/literal},'账号层级信息',400)">
    {$data.finance_user_name} {$data.finance_e_name}</a></div></td>               
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.rev_money}</div></td>  
    <td><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a></div></td>  
    <td><div class="ui_table_tdcntr">{$data.act_date}</div></td>
    <td><div class="ui_table_tdcntr">{$data.remark}</div></td>
</tr>
{/foreach}