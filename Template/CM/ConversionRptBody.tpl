{foreach from=$arrayData item=data key=index}
  <tr>    
    <td title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td title="{$data.channel_user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.channel_uid})" href="javascript:;" >{$data.channel_user_name}</a></div></td>
    
    <td title="{$data.de2bm}"><div class="ui_table_tdcntr">{$data.de2bm}</div></td>
    <td title="{$data.de2bp}"><div class="ui_table_tdcntr">{$data.de2bp}</div></td>
    <td title="{$data.de2a}"><div class="ui_table_tdcntr">{$data.de2a}</div></td>
    <td title="{$data.bm2bp}"><div class="ui_table_tdcntr">{$data.bm2bp}</div></td>
    <td title="{$data.bp2a}"><div class="ui_table_tdcntr">{$data.bp2a}</div></td>
    <td title="{$data.bm2a}"><div class="ui_table_tdcntr">{$data.bm2a}</div></td>
    
    <td title="{$data.a2bp}"><div class="ui_table_tdcntr">{$data.a2bp}</div></td>
    <td title="{$data.a2bm}"><div class="ui_table_tdcntr">{$data.a2bm}</div></td>
    <td title="{$data.a2de}"><div class="ui_table_tdcntr">{$data.a2de}</div></td>
    <td title="{$data.bp2bm}"><div class="ui_table_tdcntr">{$data.bp2bm}</div></td>
    <td title="{$data.bp2de}"><div class="ui_table_tdcntr">{$data.bp2de}</div></td>
    <td title="{$data.bm2de}"><div class="ui_table_tdcntr">{$data.bm2de}</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a  href="javascript:;" onclick="ShowDetail({$data.agent_id})">详细</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}