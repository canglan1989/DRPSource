
{foreach from=$arrayNote item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td title="{$data.visitnoteid}" ><div class="ui_table_tdcntr"><nobr>{$data.visitnoteid}</nobr></div></td>
	<td title="{$data.e_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.user_id})" href="javascript:;">{$data.e_name}</a></div></td>
	<td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
	<td title="{$data.visitor}"><div class="ui_table_tdcntr"><nobr>{$data.visitor}</nobr></div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr"><nobr><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_name}</a></nobr></div></td>
    <td title="{$data.mobile}"><div class="ui_table_tdcntr"><nobr>{$data.mobile}/{$data.tel}</nobr></div></td>
    <td title="{$data.title}"><div class="ui_table_tdcntr"><nobr>{$data.v_title}{if strlen($data.title)>strlen($data.v_title)}...{/if}</nobr></div></td>
    <td title="{$data.result}" ><div class="ui_table_tdcntr">{$data.result}</div></td>
    <td title="{$data.product_name}" ><div class="ui_table_tdcntr">{if $data.product_name != ""}{$data.product_name}{else}{$data.afterlevel}{/if}</div></td>
    
    <td title="{$data.visit_timestart}/{$data.visit_timeend}" ><div class="ui_table_tdcntr">{$data.visit_timestart}/{$data.visit_timeend}</div></td>
    
    <td title="{$data.check_status}" ><div class="ui_table_tdcntr">
    {if $data.check_status == 0}未审查{/if}
    <a href="javascript:;" onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=showCheckInfo','id={$data.visitnoteid}','审查结果信息',700);">
    {if $data.check_status == 1}审查通过{/if}
    {if $data.check_status == 2}审查未通过{/if}</a>
    </div></td>
	<td>
		<div class="ui_table_tdcntr">
			<ul class="list_table_operation">
            {if $data.check_status == 0}
                <li><a m="VisitManagementCheck" v="32" ispurview="true" href="javascript:;" 
				onclick="JumpPage('/?d=WorkM&c=VisitNote&a=CheckPage&visitnoteid={$data.visitnoteid}')" title="审查">审查</a></li>
            {/if} 
                {if $data.create_uid == $uid && $data.check_status == 2}
				<li><a m="VisitNote" v="4" ispurview="true" href="javascript:;" 
				onclick="JumpPage('/?d=WorkM&c=VisitNote&a=ModifyNote&id={$data.id}&appoint_id={$data.visitnoteid}')" title="编辑">编辑</a></li>
                {/if}
              
            
                <li><a m="VisitNote" v="2" ispurview="true" href="javascript:;" 
                onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=NoteDetial&appoint_id={$data.visitnoteid}',{literal}{{/literal}id:{$data.visitnoteid}{literal}}{/literal},'拜访小记信息',1000)"
				 title="查看">查看</a></li>
			
			</ul>
		</div>
	</td>
</tr>
{/foreach}