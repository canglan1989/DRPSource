{foreach from=$arrayData item=data key=index}
        <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.id}" ><div class="ui_table_tdcntr">{$data.id}</div></td>
        <td title="{$data.agent_no} {$data.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_no}</a> {$data.agent_name}</div></td>
        <td title="{$data.product_name}" ><div class="ui_table_tdcntr">           
            {if $data.contact_type == 0}
                {if $data.afterlevel <= 'B+'}
                    <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.afterlevel}</a>
                {else}
                    {$data.afterlevel}
                {/if}
            {else}
                {$data.product_name}
            {/if}
        </div></td>
        <td title="{$data.visit_type}" ><div class="ui_table_tdcntr">{$data.visit_type}</div></td>
        <td title="{$data.visitor}"><div class="ui_table_tdcntr">{$data.visitor}</div></td>    
        <td title="{$data.mobile}"><div class="ui_table_tdcntr">{$data.mobile}/{$data.tel}</div></td>
        <td title="{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}~{$data.visit_timeend|date_format:"%H:%M"}" ><div class="ui_table_tdcntr">{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}~{$data.visit_timeend|date_format:"%H:%M"}</div></td>   
	<td title="{$data.create_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a></div></td>
	<td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>	

        <td title="{$data.visit_content}"><div class="ui_table_tdcntr">{$data.visit_content|truncate:'20':'……'}</div></td>
        <td title="{$data.result}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getVisitNoteDetail({$data.id})">{$data.result|truncate:'20':'……'}</a></div></td>        

        <td title="{$data.follow_up_time}" ><div class="ui_table_tdcntr">{if $data.follow_up_time neq '0000-00-00 00:00:00'}{$data.follow_up_time|date_format:"%Y-%m-%d"}{/if}</div></td>  
        <td title="{$data.follow_up_content}" ><div class="ui_table_tdcntr">{$data.follow_up_content|truncate:'20':'……'}</div></td>
        <td title="{$data.instruction}" >
            <div class="ui_table_tdcntr">
            {if $data.instruction neq '未批示' and $data.instruction neq '已阅'}
            <a onclick="inDetail({$data.id})" href="javascript:;">{$data.instruction}</a>
            {else} 
            {$data.instruction}
            {/if}
            </div> </td>
	<td><div class="ui_table_tdcntr">
           {if $data.verfity_status eq '通过' or $data.verfity_status eq '不通过' }
            <a onclick="verfityDetail({$data.id})" href="javascript:;">{$data.verfity_status}</a>
           {else}
           {$data.verfity_status}
           {/if}
           </div></td>
        </tr>
{/foreach}