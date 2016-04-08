{foreach from=$arrayData item=data key=index}
  <tr>    
    <td title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td title="{$data.channel_user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.channel_uid})" href="javascript:;" >{$data.channel_user_name}</a></div></td>
    <td title="{$data.valid_count}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowValidDetail({$data.agent_id})">{$data.valid_count}</a></div></td>
    <td title="{$data.invalid_count}"><div class="ui_table_tdcntr">{$data.invalid_count}</div></td>
    <td title="{$data.record_count}"><div class="ui_table_tdcntr">{$data.record_count}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.valid_rate*100|string_format:"%2.2f"|cat:"%"}</div></td>
    <td title="{$data.visit_count}"><div class="ui_table_tdcntr"><a  href="javascript:;" onclick="ShowVisitDetail({$data.agent_id})">{$data.visit_count}</a></div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a href="javascript:;" onclick="ShowDetail({$data.agent_id})">详细</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}