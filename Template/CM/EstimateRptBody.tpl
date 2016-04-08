{foreach from=$arrayData item=data key=index}
  <tr>    
    <td title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td title="{$data.channel_user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.channel_uid})" href="javascript:;" >{$data.channel_user_name}</a></div></td>

    <td title="{$data.income_money}"><div class="ui_table_tdcntr">{$data.income_money|string_format:"￥%.2f"}</div></td>
    <td title="{$data.order_count}"><div class="ui_table_tdcntr">{$data.order_count}</div></td>
    <td title="{$data.charge_money}"><div class="ui_table_tdcntr">{$data.charge_money|string_format:"￥%.2f"}</div></td>
    <td title="{$data.charge_count}"><div class="ui_table_tdcntr">{$data.charge_count}</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a  href="javascript:;" onclick="ShowDetail({$data.agent_id})">详细</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}