{foreach from=$arrayData item=data key=index}
  <tr>    
    <td title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td title="{$data.channel_user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.channel_uid})" href="javascript:;" >{$data.channel_user_name}</a></div></td>
    
    <td title="{$data.rating_1}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},1)">{$data.rating_1}</a></div></td>
    <td title="{$data.rating_2}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},2)">{$data.rating_2}</a></div></td>
    <td title="{$data.rating_3}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},3)">{$data.rating_3}</a></div></td>
    <td title="{$data.rating_4}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},4)">{$data.rating_4}</a></div></td>
    <td title="{$data.rating_5}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},5)">{$data.rating_5}</a></div></td>
    <td title="{$data.rating_6}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},6)">{$data.rating_6}</a></div></td>
    <td title="{$data.rating_7}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id},7)">{$data.rating_7}</a></div></td>
    
    <td title="{$data.income_money}"><div class="ui_table_tdcntr">{$data.income_money}</div></td>
    <td title="{$data.order_count}"><div class="ui_table_tdcntr">{$data.order_count}</div></td>
    <td title="{$data.charge_money}"><div class="ui_table_tdcntr">{$data.charge_money}</div></td>
    <td title="{$data.charge_count}"><div class="ui_table_tdcntr">{$data.charge_count}</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a  href="javascript:;" onclick="ShowDetail({$data.agent_id})">详细</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}