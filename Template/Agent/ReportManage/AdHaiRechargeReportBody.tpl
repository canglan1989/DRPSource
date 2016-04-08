{foreach from=$arrayData item=arrReportList}
<tr>
    <td title="{$arrReportList.customer_name}"><div class="ui_table_tdcntr">{$arrReportList.customer_name}</div></td>
    <td title="{$arrReportList.owner_account_name}"><div class="ui_table_tdcntr">{$arrReportList.owner_account_name}</div></td>
    <td title="{$arrReportList.add_time}"><div class="ui_table_tdcntr">{$arrReportList.add_time}</div></td>
    <td title="{$arrReportList.recharge_money}"><div class="ui_table_tdcntr">{$arrReportList.recharge_money}</div></td>
    <td title="{$arrReportList.create_user_name}"><div class="ui_table_tdcntr">{$arrReportList.create_user_name}</div></td>
    <td title="{$arrReportList.create_time}"><div class="ui_table_tdcntr">{$arrReportList.create_time}</div></td>
</tr>
{/foreach}