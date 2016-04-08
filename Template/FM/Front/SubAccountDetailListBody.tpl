{foreach from=$arrayAccountList item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td ><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AccountLevelDetail&id=',{literal}{{/literal}id:{$data.finance_uid}{literal}}{/literal},'账号层级信息',400)">
    {$data.finance_user_name} {$data.finance_e_name}</a></div></td>
    <td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.account_type_text}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.in_money}</div></td>
    {if $data.account_type == 1}
    <td class="TA_r"><div class="ui_table_tdcntr">--</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">--</div></td>
    {elseif $data.account_type == 2}
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.lock_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.order_out_money}</div></td>
    {else}
    <td class="TA_r"><div class="ui_table_tdcntr">--</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.order_out_money}</div></td>
    {/if}
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.other_out_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td> 
    <td class="TA_r"><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
    <li><a m="SubAccountDetailList" v="4" ispurview="true" href="javascript:;" onClick="MoveMoney({$data.finance_uid},{$data.account_type},{$data.product_type_id})">帐户间转款</a></li><br/>
    </ul>
    </div></td>
</tr>
{/foreach}