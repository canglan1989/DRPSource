{foreach from=$arrayAccountList item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_name}</td>
    <td><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.in_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.out_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.balance_money}</div></td>
    <td><div class="ui_table_tdcntr">
     <ul class="list_table_operation">
            <li><a class="ui_button" m="MoneyInAccountList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=InMoney&a=MoneyInAccountList&agentNo={$data.agent_no}&accountType={$data.account_type}&productType={$data.product_type_id}');">收款明细</a></li>
        	<li><a m="Back_AccountMoneyInOutList" v="2" ispurview="true" href="javascript:;" onClick="ClearStockQueryData();JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$data.agent_no}&accountType={$data.account_type}&productType={$data.product_type_id}&inOutType=1');">充值记录</a></li>
        	<li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="ChargeMoney({$data.agent_id},{$data.account_type},{$data.product_type_id})">支出</a></li>
        	<li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="MoveMoney({$data.agent_id},{$data.account_type},{$data.product_type_id})">帐户间转款</a></li>
        </ul>
    </div>
    </td>
</tr>
{/foreach}