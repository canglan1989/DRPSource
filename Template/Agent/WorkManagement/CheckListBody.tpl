
{foreach from=$arrayNote item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.visitnoteid}" ><div class="ui_table_tdcntr">{$data.visitnoteid}</div></td>
        <td title="{$data.user_id}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.user_id})" href="javascript:;">{$data.e_name}</a></div></td>
        <td title="{$data.contact_name}"><div class="ui_table_tdcntr">{$data.visitor}</div></td>
        <td title="{$data.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_name}</a></div></td>
        <td title="{if $data.last_revisit_time != "0000-00-00 00:00:00"}{$data.last_revisit_time}{/if}"><div class="ui_table_tdcntr">
        {if $data.last_revisit_time != "0000-00-00 00:00:00"}<a href="javascript:;" onclick="JumpPage('/?d=WorkM&c=VisitNote&a=ReturnVisitList&visitnoteid={$data.visitnoteid}')">{$data.last_revisit_time}</a>{else}--{/if}</div></td>
        <td title="{$data.mobile}"><div class="ui_table_tdcntr">{$data.mobile}/{$data.tel}</div></td>
        <td title="{$data.title}"><div class="ui_table_tdcntr">{$data.title|truncate:"20":"..."}</div></td>
        <td title="{$data.result}" ><div class="ui_table_tdcntr">{$data.result|truncate:"80":"..."}</div></td>
        <td title="{$data.afterlevel}" ><div class="ui_table_tdcntr">{if $data.product_name != ""}{$data.product_name}{else}{$data.afterlevel}{/if}</div></td>

        <td title="{$data.visit_timestart}" ><div class="ui_table_tdcntr">{$data.visit_timestart}/{$data.visit_timeend}</div></td>

        <td title="{$data.check_status}" ><div class="ui_table_tdcntr">
            {if $data.check_status == 0}未审查{/if}
            <a href="javascript:;" onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=showCheckInfo','id={$data.visitnoteid}','审查结果信息',700);">
            {if $data.check_status == 1}审查通过{/if}
        {if $data.check_status == 2}审查未通过{/if}</a>
        </div></td>
        <td ><div class="ui_table_tdcntr">{if $data.has_return == '0'}未处理{elseif $data.has_return == '1'}已回访{else}不回访{/if}</div></td>

<td>
    <div class="ui_table_tdcntr">
        <ul class="list_table_operation">
            {if $data.ac_id > 0}
            <li><a m="VisitNote" v="2" ispurview="true" href="javascript:;"  onclick="JumpPage('/?d=WorkM&c=AccompanyVisit&a=RelateAccompany&visitnoteid={$data.visitnoteid}')">查看陪访小记</a></li>
            {/if}  
            {if $data.check_status == 0}
                <li><a m="VisitManagementCheck" v="32" ispurview="true" href="javascript:;"  onclick="JumpPage('/?d=WorkM&c=VisitNote&a=CheckPage&visitnoteid={$data.visitnoteid}&check=1')" title="审核拜访小记">审核拜访小记</a></li>
                {/if}  
            <li><a m="VisitNote" v="2" ispurview="true" href="javascript:;"  onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=NoteDetial&appoint_id={$data.visitnoteid}',{literal}{{/literal}id:{$data.visitnoteid}{literal}}{/literal},'拜访小记信息',1000)">查看拜访小记</a></li>
            {if $data.has_return == 1}
                <li><a href="javascript:;" onclick="IM.Agent.addVisitRecord('/?d=WorkM&c=VisitNote&a=ShowAddReturnVisit',{literal}{{/literal}id:{$data.visitnoteid},act:'edit'{literal}}{/literal},'修改回访记录')">修改回访记录</a></li>
            {elseif $data.has_return == 0}
                <li><a href="javascript:;" onclick="NoReturnVisit({$data.visitnoteid})">不回访</a></li>
                <li><a href="javascript:;" onclick="IM.Agent.addVisitRecord('/?d=WorkM&c=VisitNote&a=ShowAddReturnVisit',{literal}{{/literal}id:{$data.visitnoteid},act:'add'{literal}}{/literal},'添加回访记录')">添加回访</a></li>
            {/if}
        </ul>
    </div>
</td>
</tr>
{/foreach}