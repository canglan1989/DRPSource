{foreach from=$arrayAccompanyVisit item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td title="{$data.id}" ><div class="ui_table_tdcntr">{$data.id}</div></td>
	<td title="{$data.create_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a></div></td>
	<td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title="{$data.invaited_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.invaited_uid})" href="javascript:;">{$data.invaited_user_name}</a> </div></td>
    <td title="{$data.s_time|date_format:'%Y-%m-%d %H:%M'}~{$data.e_time|date_format:'%H:%M'}" ><div class="ui_table_tdcntr">{$data.s_time|date_format:'%Y-%m-%d %H:%M'}~{$data.e_time|date_format:'%H:%M'}</div></td>
	<td title="{$data.agent_no} {$data.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_no}</a> {$data.agent_name}</div></td>
    <td title="{$data.visitor}" ><div class="ui_table_tdcntr">{$data.visitor}</div></td>
    <td title="{$data.tel}" ><div class="ui_table_tdcntr">{$data.tel}</div></td>
    <td title="{$data.content}" ><div class="ui_table_tdcntr">{$data.content|truncate:"100":"……"}</div></td>
    <td title="{$data.check_statu_text}" ><div class="ui_table_tdcntr">
    {if $data.check_statu == 0} {$data.check_statu_text}
    {elseif $data.check_statu == 1}
    <a href="javascript:;"  onclick="ShowCheckDetial({$data.id})">{$data.check_statu_text}</a>    
    {elseif $data.check_statu == 2}
    <a href="javascript:;"  onclick="ShowCheckDetial({$data.id})">{$data.check_statu_text}</a>
    {/if}
    </div></td>    
</tr>
{/foreach}