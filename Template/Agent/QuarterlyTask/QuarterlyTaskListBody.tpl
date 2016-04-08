{foreach from=$arrayQuarterlyTaskList item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.agent_no}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_no}</a></div></td>
    <td  title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td  title="{if $data.agent_level == 1}金牌{else}银牌{/if}"><div class="ui_table_tdcntr">{if $data.agent_level == 1}金牌{else}银牌{/if}</div></td>
    <td  title="{$data.product_type_name}"><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td title="{$data.task_quarterly_text}"><div class="ui_table_tdcntr">{$data.task_quarterly_text}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{$data.task_money}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{$data.finish_money}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.sale_award_money != 0 }{$data.sale_award_money}{else}--{/if}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">
    {if $data.award_money != 0}{$data.award_money}{else}--{/if}
    </div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.market_funds != 0 }{$data.market_funds}{else}--{/if}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.distribution_funds != 0 }{$data.distribution_funds}{else}--{/if}</div></td>    
    <td title=""><div class="ui_table_tdcntr">
    <a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title=""><div class="ui_table_tdcntr">
        <ul class="list_table_operation">
        {if $data.award_money <= 0}
        <li><a href="javascript:;" m="AgentQuarterlyTaskList" ispurview="true" v="8" onclick="IM.account.delOper('{au d="Agent" c="QuarterlyTask" a="DelQuarterlyTask"}&id={$data.quarterly_task_id}',{literal}{{/literal}id:{$data.quarterly_task_id}{literal}}{/literal},'季度任务删除',this)">删除</a></li>
        {/if}
        </ul>
    </div></td>
  </tr>
{/foreach}