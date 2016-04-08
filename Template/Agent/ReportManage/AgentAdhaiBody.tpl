{foreach from=$arrayData item=arrReportList}
<tr>
    <td title="{$arrReportList.account_name}"><div class="ui_table_tdcntr">{$arrReportList.account_name}</div></td>
    <td title="{$arrReportList.e_name}"><div class="ui_table_tdcntr">
            {if !empty($arrReportList.user_name)}
            <a href="javascript:void(0)" onclick="UserDetial({$arrReportList.channel_uid})">{$arrReportList.user_name}({$arrReportList.e_name})</a>
            {/if}
        </div></td>      
    <td title="{$arrReportList.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}'id':{$arrReportList.agent_id}{literal}}{/literal})">{$arrReportList.agent_name}</a></div></td>                               
    <td class="TA_r" title="{$arrReportList.today_new_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="Back_UnitInMoneyList"}&agentNo={$arrReportList.agent_no}&begintime={$smarty.now|date_format:'%Y-%m-%d'}&endtime={$smarty.now|date_format:'%Y-%m-%d'}&chargetype=1')">{$arrReportList.today_new_count}</a></div></td>
    <td class="TA_r" title="{$arrReportList.month_new_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="Back_UnitInMoneyList"}&agentNo={$arrReportList.agent_no}&begintime={$BeginTime}&endtime={$EndTime}&chargetype=1')">{$arrReportList.month_new_count}</a></div></td>
    <td class="TA_r" title="{$arrReportList.today_old_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="Back_UnitInMoneyList"}&agentNo={$arrReportList.agent_no}&begintime={$smarty.now|date_format:'%Y-%m-%d'}&endtime={$smarty.now|date_format:'%Y-%m-%d'}&chargetype=2')">{$arrReportList.today_old_count}</a></div></td>
    <td class="TA_r" title="{$arrReportList.month_old_count}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="Back_UnitInMoneyList"}&agentNo={$arrReportList.agent_no}&begintime={$BeginTime}&endtime={$EndTime}&chargetype=2')">{$arrReportList.month_old_count}</a></div></td>
    <td class="TA_r" title="{$arrReportList.today_new_money}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('{$arrReportList.agent_id}','{$smarty.now|date_format:'%Y-%m-%d'}','{$smarty.now|date_format:'%Y-%m-%d'}','1');">{$arrReportList.today_new_money}</a></div></td> 
    <td class="TA_r" title="{$arrReportList.month_new_money}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('{$arrReportList.agent_id}','{$BeginTime}','{$EndTime}','1');">{$arrReportList.month_new_money}</a></div></td>
    <td class="TA_r" title="{$arrReportList.today_old_money}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('{$arrReportList.agent_id}','{$smarty.now|date_format:'%Y-%m-%d'}','{$smarty.now|date_format:'%Y-%m-%d'}','2');">{$arrReportList.today_old_money}</a></div></td> 
    <td class="TA_r" title="{$arrReportList.month_old_money}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('{$arrReportList.agent_id}','{$BeginTime}','{$EndTime}','2');">{$arrReportList.month_old_money}</a></div></td> 
</tr>
{/foreach}