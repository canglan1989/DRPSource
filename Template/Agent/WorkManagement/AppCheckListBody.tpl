
{foreach from=$arrayAppoint item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td title="{$data.appoint_id}" ><div class="ui_table_tdcntr"><nobr>{$data.appoint_id}</nobr></div></td>
	<td title="{$data.e_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.euser_id})" href="javascript:;">{$data.e_name}</a></div></td>
	<td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
	<td title="{$data.agent_name}"><div class="ui_table_tdcntr"><nobr><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_name}</a></nobr></div></td>
    <td title="{$data.title}"><div class="ui_table_tdcntr"><nobr>
                <a  href="javascript:;" 
                onclick="IM.agent.getTableList('/?d=WorkM&c=VisitAppoint&a=AppointDetial&appoint_id={$data.appoint_id}',{literal}{{/literal}id:{$data.appoint_id}{literal}}{/literal},'拜访预约信息',800)"
				 title="查看">{$data.v_title}{if strlen($data.title)>strlen($data.v_title)}...{/if}</a>
                 
                 </nobr></div></td>
    <td title="{$data.product_name}"><div class="ui_table_tdcntr"><nobr>{if $data.product_name!=""}{$data.product_name}{else}{$data.inten_level}{/if}</nobr></div></td>
    <td title="{$data.visitor}" ><div class="ui_table_tdcntr">{$data.visitor}</div></td>
    <td title="{$data.tel}" ><div class="ui_table_tdcntr">{$data.tel}/{$data.mobile}</div></td>
    
    <td title="{$data.sappoint_time}" ><div class="ui_table_tdcntr">{$data.sappoint_time}/{$data.eappoint_time}</div></td>
    
    <td title="{$data.note}" ><div class="ui_table_tdcntr">{if $data.note == 1}是{else}否{/if}</div></td>
    <td title="{$data.check_status}" ><div class="ui_table_tdcntr">
    {if $data.check_status == 0}
    未审查
    {/if}
    {if $data.check_status == 1}
    审查通过
    {/if}
    {if $data.check_status == 2}
    审查不通过
    {/if}
    </div></td>
	<td>
		<div class="ui_table_tdcntr">
			<ul class="list_table_operation">
                {if $data.note == 1}
                <li><a m="AppCheckList" v="32" ispurview="true" href="javascript:;" 
                onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=NoteDetial&appoint_id={$data.appoint_id}',{literal}{{/literal}id:{$data.appoint_id}{literal}}{/literal},'拜访小记信息',1000)"
				
				 title="编辑">查看小记</a></li>
                {/if}
				
			</ul>
		</div>
	</td>
</tr>
{/foreach}