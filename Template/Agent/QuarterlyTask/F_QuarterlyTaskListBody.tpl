{foreach from=$arrayQuarterlyTaskList item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.agent_no}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_no}</a><br />
    {$data.agent_name}</div></td>
    <td  title="{if $data.agent_level == 1}金牌{else}银牌{/if}"><div class="ui_table_tdcntr">{if $data.agent_level == 1}金牌{else}银牌{/if}</div></td>
    <td  title="{$data.product_type_name}"><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td title="{$data.task_quarterly_text}"><div class="ui_table_tdcntr">{$data.task_quarterly_text}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{$data.task_money}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{$data.finish_money}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.sale_award_money != 0 }{$data.sale_award_money}{else}--{/if}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.award_money != 0}{$data.award_money}{else}--{/if}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.market_funds != 0 }{$data.market_funds}{else}--{/if}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.distribution_funds != 0 }{$data.distribution_funds}{else}--{/if}</div></td>    
    <td title=""><div class="ui_table_tdcntr">
    <a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a><br />
    {$data.create_time}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.award_money != 0}
    <a onclick="UserDetial({$data.award_uid})" href="javascript:;">{$data.award_user_name}</a><br />
    {$data.award_time}
    {else}--
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.award_remark}</div></td>
    <td title=""><div class="ui_table_tdcntr">
        <ul class="list_table_operation">
        {if $data.award_money == 0}
        <li><a href="javascript:;" m="F_QuarterlyTaskList" ispurview="true" v="4" onclick="JumpPage('/?d=Agent&c=QuarterlyTask&a=QuarterlyTaskModify&id={$data.quarterly_task_id}')">编辑</a></li>
            {if $data.product_group == 0}
            <li><a href="javascript:;" m="F_QuarterlyTaskList" ispurview="true" v="8" onclick="AwardMoney({$data.quarterly_task_id})">销奖充值</a></li>
            {/if}
        {else}
        <li><a href="javascript:;" m="F_QuarterlyTaskList" ispurview="true" v="8" onclick="DropAwardMoney({$data.quarterly_task_id})">取消充值</a></li>
        {/if}
        </ul>
    </div></td>
  </tr>
{/foreach}