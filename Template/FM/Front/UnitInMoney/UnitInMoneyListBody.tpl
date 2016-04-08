{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.recharge_no}</div></td>
    <td title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td><div class="ui_table_tdcntr"><a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_name}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.customer_account}</a>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.recharge_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.pre_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.rebate_money}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.create_user_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
</tr>
{/foreach}