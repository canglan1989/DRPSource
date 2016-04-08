{foreach from=$arrayData item=arrReportList}
<tr>           
    <td title="{$arrReportList.account_name}"><div class="ui_table_tdcntr">{$arrReportList.account_name}</div></td>
    <td title="{$arrReportList.e_name}"><div class="ui_table_tdcntr">
            {if !empty($arrReportList.user_name)}
            <a href="javascript:void(0)" onclick="UserDetial({$arrReportList.channel_uid})">{$arrReportList.user_name}({$arrReportList.e_name})</a>
            {/if}
        </div></td>      
    <td title="{$arrReportList.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}'id':{$arrReportList.agent_id}{literal}}{/literal})">{$arrReportList.agent_name}</a></div></td>   
    
    <td title="{$arrReportList.begin_time}"><div class="ui_table_tdcntr">{$arrReportList.begin_time}</div></td>
    <td title="{$arrReportList.end_time}"><div class="ui_table_tdcntr">{$arrReportList.end_time}</div></td>
    
    <td class="TA_r" title="{$arrReportList.month_new_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="Back_UnitInMoneyList"}&agentNo={$arrReportList.agent_no}&chargetype=1&begintime={$arrReportList.begin_time}&endtime={$arrReportList.end_time}')">{$arrReportList.month_new_count}</a></div></td>
    <td class="TA_r" title="{$arrReportList.month_new_money}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('{$arrReportList.agent_id}','{$arrReportList.begin_time}','{$arrReportList.end_time}','1');">{$arrReportList.month_new_money}</a></div></td>
    <td class="TA_r" title="{$arrReportList.month_old_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="Back_UnitInMoneyList"}&agentNo={$arrReportList.agent_no}&chargetype=2&begintime={$arrReportList.begin_time}&endtime={$arrReportList.end_time}')">{$arrReportList.month_old_count}</a></div></td>
    <td class="TA_r" title="{$arrReportList.month_old_money}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('{$arrReportList.agent_id}','{$arrReportList.begin_time}','{$arrReportList.end_time}','2');">{$arrReportList.month_old_money}</a></div></td>
    
</tr>
{/foreach}