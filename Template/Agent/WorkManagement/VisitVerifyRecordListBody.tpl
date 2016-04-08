{foreach from=$arrayData item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.vertify_id}" ><div class="ui_table_tdcntr">{$data.vertify_id}</div></td>
        <td title="{$data.agent_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_name}</a></div></td>
        <td title="{$data.note_id}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getVisitNoteDetail({$data.note_id})">{$data.note_id}</a></div></td>
        <td title="{$data.note_create_user}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.visit_uid})">{$data.user_name} {$data.e_name}</a></div></td>
        <td title="{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}~{$data.visit_timeend|date_format:"%H:%M"}" ><div class="ui_table_tdcntr">{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}~{$data.visit_timeend|date_format:"%H:%M"}</div></td> 
        <td title="{$data.note_create_time}" ><div class="ui_table_tdcntr">{$data.note_create_time}</div></td>        
        <td title="{$data.record_no}" ><div class="ui_table_tdcntr"><a href="{$data.record_no}" >{$data.record_no}</a></div></td>        
        <td title="{$data.verfity_status_cn}" ><div class="ui_table_tdcntr">{$data.verfity_status_cn}</div></td>
        <td title="{$data.vertify_remark}" ><div class="ui_table_tdcntr">{$data.vertify_remark}</div></td>
        <td title="{$data.create_user_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a></div></td>
        <td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>        
        
    </tr>
{/foreach}