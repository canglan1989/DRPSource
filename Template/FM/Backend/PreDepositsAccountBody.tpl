{foreach from=$arrayAccountList item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    {if $data.account_type <> 7}
    <td><div class="ui_table_tdcntr">增值产品预存款</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=2&inOutTypes=2,24&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.in_money}</a></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&priceStatus=1&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.lock_money}</a></div></td>
    <!--<td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&priceStatus=2&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.order_out_money}</a></div></td>-->
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=2&inOutTypes=13,14&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.order_out_money}</a></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=2&inOutTypes=15,16,25&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.other_out_money}</a></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.p_can_use_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.f_can_use_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="MoveMoney({$data.agent_id},2,{$data.product_type_id})">帐户间转款</a></li><br/>
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="ChargeMoney({$data.agent_id},2,{$data.product_type_id})">支出</a></li>
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PreDeposits&a=AgentPreDepositsAccount&agentID={$data.agent_id}&productTypeID={$data.product_type_id}')">详细</a></li>
    </ul>
    </div></td>
    {else}    
    <td><div class="ui_table_tdcntr">网盟预存款</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&inOutTypes=17,18,24&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.in_money}</a></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">--</div></td>
    <!--<td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=Back_UnitInMoneyList&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.order_out_money}</a></div></td>-->
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&inOutTypes=19,21&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.order_out_money}</a></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&inOutTypes=15,16,25,26&agentNo={$data.agent_no}&productTypeID={$data.product_type_id}')">{$data.other_out_money}</a></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.p_can_use_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.f_can_use_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="MoveMoney({$data.agent_id},7,{$data.product_type_id})">帐户间转款</a></li><br/>
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="AdhaiReturnMoney({$data.agent_id},'{$data.agent_name}')">终端退款</a></li><br/>
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="ChargeMoney({$data.agent_id},7,{$data.product_type_id})">支出</a></li>
    <li><a m="InOutMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PreDeposits&a=UnitAgentPreDepositsAccount&agentID={$data.agent_id}&productTypeID={$data.product_type_id}')">详细</a></li>
    </ul>
    </div></td>
    {/if}
</tr>
{/foreach}