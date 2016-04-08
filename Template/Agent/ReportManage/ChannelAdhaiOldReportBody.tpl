{foreach from=$arrayData item=arrReportList}
<tr>
    <td title="{$arrReportList.account_name}"><div class="ui_table_tdcntr">{$arrReportList.account_name}</div></td>  
    <td title="{$arrReportList.user_name}({$arrReportList.e_name})"><div class="ui_table_tdcntr">
            {if !empty($arrReportList.user_name)}
            <a href="javascript:void(0)" onclick="UserDetial({$arrReportList.user_id})">{$arrReportList.user_name}({$arrReportList.e_name})</a>
            {/if}
        </div></td>
        
        <td title="{$arrReportList.begin_time}"><div class="ui_table_tdcntr">{$arrReportList.begin_time}</div></td>
        <td title="{$arrReportList.end_time}"><div class="ui_table_tdcntr">{$arrReportList.end_time}</div></td>
        
    <td title="{$arrReportList.new_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="jump2sign('{$arrReportList.e_name}','{$arrReportList.begin_time}','{$arrReportList.end_time}');">{$arrReportList.new_count}</a></div></td>
    <td title="{$arrReportList.new_money}"><div class="ui_table_tdcntr">{$arrReportList.new_money}</div></td>
    <td title="{$arrReportList.new_cash_money}"><div class="ui_table_tdcntr">{$arrReportList.new_cash_money}</div></td>
    <td title="{$arrReportList.new_pre_money}"><div class="ui_table_tdcntr">{$arrReportList.new_pre_money}</div></td>
</tr>
{/foreach}