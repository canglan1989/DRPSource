{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyDetail&id={$data.post_money_id}')">{$data.post_money_no}</a></div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a>
    <br/>{$data.agent_name}</td>
    <td><div class="ui_table_tdcntr">{$data.product_type_names}</div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_pact_nos}</div></td>
    <td><div class="ui_table_tdcntr">{$data.payment_name}<br/>{$data.agent_bank_name}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.rp_files != ""}
    <a href="javascript:;" onclick="ViewPic('{$data.rp_files}')">查看</a>
    {else}
    --
    {/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.post_money_amount}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.in_account_money}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.post_money_state == 2}<a href="javascript:;" onClick="MoneyInAccountDetail({$data.post_money_id})">
    {$data.post_money_state_text}</a>{else}{$data.post_money_state_text}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{$data.post_date|date_format:"%Y-%m-%d"}</div></td>
    <td><div class="ui_table_tdcntr">{$data.account_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.create_user_name}/{$data.create_time}</div></td>    
    <td><div class="ui_table_tdcntr">{$data.bank_name}</div></td>
    {if $data.received_uid > 0}
    <td><div class="ui_table_tdcntr">{$data.received_time|date_format:"%Y-%m-%d"}</div></td>
    {else}
    <td><div class="ui_table_tdcntr">--</div></td>
    {/if}
    {if $data.check_in_account_uid > 0}
    <td><div class="ui_table_tdcntr">{$data.erp_banck_record_id}</div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onClick="CheckMoneyInAccountDetail({$data.post_money_id})">已认领</a></div></td>
    {else}
    <td><div class="ui_table_tdcntr">--</div></td>
    <td><div class="ui_table_tdcntr">未认领</div></td>
    {/if}
    <td><div class="ui_table_tdcntr">
    <ul class="list_table_operation">    
    {if $data.post_money_state == 0}
    <li><a m="ReceivablesDetails" v="4" ispurview="true" href="javascript:;" onClick="BackMoney({$data.post_money_id})">退回</a></li>
    <li><a m="ReceivablesDetails" v="4" ispurview="true" href="javascript:;" onClick="MoneyInAccount({$data.post_money_id})">收款</a></li>
    {/if}
    {if $data.post_money_state == 1}
    <li><a m="ReceivablesDetails" v="4" ispurview="true" href="javascript:;" onClick="BackMoney({$data.post_money_id})">退回</a></li>
    <li><a m="ReceivablesDetails" v="8" ispurview="true" href="javascript:;" onClick="CheckMoneyInAccount({$data.post_money_id})">认领</a></li>
    <li><a m="ReceivablesDetails" v="4" ispurview="true" href="javascript:;" onClick="PostMoneyConfirm({$data.post_money_id})">到账确认</a></li>
    {/if}
    {if $data.post_money_state == 2 && $data.check_in_account_uid<= 0}
    <li><a m="ReceivablesDetails" v="4" ispurview="true" href="javascript:;" onClick="BackMoney({$data.post_money_id})">退回</a></li>
    <li><a m="ReceivablesDetails" v="8" ispurview="true" href="javascript:;" onClick="CheckMoneyInAccount({$data.post_money_id})">认领</a></li>
    {/if}
    {if $data.check_in_account_uid > 0}
    <li><a href="javascript:;" onClick="MoneyInAccountDetail({$data.post_money_id})">收款详情</a></li>
    <li><a href="javascript:;" onClick="CheckMoneyInAccountDetail({$data.post_money_id})">认领详情</a></li>
    {/if}
    </ul>
    </div></td>
</tr>
{/foreach}