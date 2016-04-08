{foreach from=$arrayInMoney item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyDetail&id={$data.post_money_id}')">{$data.post_money_no}</a></div></td>
    <td><div class="ui_table_tdcntr"><a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_no}</a><br />{$data.agent_name}</td>
    <td><div class="ui_table_tdcntr">{$data.product_type_names}</div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_pact_nos}</td>
    <td><div class="ui_table_tdcntr">{$data.payment_name}<br/>{$data.agent_bank_name}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.post_money_amount}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.in_account_money}</div></td>
    <td><div class="ui_table_tdcntr">{$data.post_money_state_text}</div></td>
    <td><div class="ui_table_tdcntr">{$data.income_state_text}</div></td>
    {if $data.income_uid >0}
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.income_money}</div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$data.income_uid})">{$data.income_user_name}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.income_time}</div></td>
    <td><div class="ui_table_tdcntr">{$data.income_remark}</div></td>
    <td><div class="ui_table_tdcntr">
    <!--
    <ul class="list_table_operation">
    <li><a m="MoneyInAccountList" v="4" ispurview="true" href="javascript:;" onClick="DelInMoney({$data.post_money_id})">取消充值</a></li>
    </ul>-->
    </div></td>
    {else}
    <td class="TA_r"><div class="ui_table_tdcntr">--</div></td>
    <td><div class="ui_table_tdcntr">--</div></td>
    <td><div class="ui_table_tdcntr">--</div></td>
    <td><div class="ui_table_tdcntr">--</div></td>
    
    <td><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
    {if $data.post_money_state == 2}
    <li><a m="MoneyInAccountList" v="4" ispurview="true" href="javascript:;" onClick="InMoney({$data.post_money_id},'{$data.post_money_no}','{$data.agent_name}')">充值</a></li>
    {/if}
    </ul>
    </div></td>{/if}
</tr>
{/foreach}