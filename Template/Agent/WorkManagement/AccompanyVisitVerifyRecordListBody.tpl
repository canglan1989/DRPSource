{foreach from=$arrayAccompanyVisit item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td title="{$data.id}" ><div class="ui_table_tdcntr">{$data.id}</div></td>
	<td title="{$data.agent_no} {$data.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_no}</a> {$data.agent_name}</div></td>
	<td title="{$data.create_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a></div></td>
    <td title="{$data.s_time|date_format:'%Y-%m-%d %H:%M'}~{$data.e_time|date_format:'%H:%M'}" ><div class="ui_table_tdcntr">{$data.s_time|date_format:'%Y-%m-%d %H:%M'}~{$data.e_time|date_format:'%H:%M'}</div></td>
    <td title="{$data.invaited_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.invaited_uid})" href="javascript:;">{$data.invaited_user_name}</a> </div></td>
	<td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title="{$data.check_address}" ><div class="ui_table_tdcntr">{if $data.check_address == ""}--{else}<a href="{$data.check_address}" target="_blank">{$data.check_address}</a>{/if}</div></td>
    <td title="{$data.check_statu_text}" ><div class="ui_table_tdcntr">{$data.check_statu_text}</div></td>
    <td title="{$data.check_detial}" ><div class="ui_table_tdcntr">{$data.check_detial|truncate:"48":"……"}</div></td>
    <td title="{$data.check_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.check_uid})" href="javascript:;">{$data.check_user_name}</a></div></td>
   	<td title="{$data.check_time}" ><div class="ui_table_tdcntr">{$data.check_time}</div></td>
</tr>
{/foreach}