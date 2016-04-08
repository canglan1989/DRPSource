{foreach from=$arrayData item=arrcheckList}
<tr>
    <td title=""><div class="ui_table_tdcntr"><input class="checkInp" type="checkbox" name="listid" value="{$arrcheckList.agent_id}"/></div></td>
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr"><a m="AgentList" v="8" ispurview="true" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentinfoAddContact'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&needCheck=yes&isPact=no');" href="javascript:;">{$arrcheckList.agent_name}</a></div></td>      
    <td title="{$arrcheckList.area_fullname}"><div class="ui_table_tdcntr">{$arrcheckList.area_fullname}</div></td>                               
    <td title="{$arrcheckList.intention_level}"><div class="ui_table_tdcntr">{$arrcheckList.intention_level}</div></td>
    <td title="{if $arrcheckList.agent_from eq 0}我录入的{elseif $arrcheckList.agent_from eq 1}自动注册{else}上级分配{/if}"><div class="ui_table_tdcntr">{if $arrcheckList.agent_from eq 0}我录入的{elseif $arrcheckList.agent_from eq 1}自动注册{else}上级分配{/if}</div></td>                                    
    <td title="{$arrcheckList.e_name}({$arrcheckList.user_name})"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arrcheckList.user_id});">{$arrcheckList.e_name}({$arrcheckList.user_name})</a></div></td>
    <td title="{if $arrcheckList.is_check eq 0}未审核{elseif $arrcheckList.is_check eq 1}审核通过{else}审核不通过{/if}">
    <div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="IM.agent.getAgentCheckInfo({literal}{{/literal}'id':{$arrcheckList.agent_id}{literal}}{/literal});">
    {if $arrcheckList.is_check eq 0}未审核{elseif $arrcheckList.is_check eq 1}审核通过{else}审核不通过{/if}
    </a>
    </div>
    </td>
    <td title="{$arrcheckList.contact_num}"><div class="ui_table_tdcntr">{$arrcheckList.contact_num}</div></td>
    <td><div class="ui_table_tdcntr">{$arrcheckList.create_time}<br/>
    {if $arrcheckList.update_time neq '' && $arrcheckList.update_time neq '0000-00-00 00:00:00'}{$arrcheckList.update_time}{else}--{/if}</div></td>
    <td ><div class="ui_table_tdcntr">{if $arrcheckList.final_contact_time eq '' || $arrcheckList.final_contact_time eq '0000-00-00 00:00:00'}--{else}{$arrcheckList.final_contact_time}{/if}</div></td>
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a m="AgentList" v="8" ispurview="true" href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentinfoAddContact'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&needCheck=yes&isPact=no');">联系小记</a></li>
                <li><a m="TelTaskManage" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d='WorkM' c='TelWork' a='showAddTelInvite'}&agentid={$arrcheckList.agent_id}');">设置电话任务</a></li>
                <!--<li><a m="AgentList" v="16" ispurview="true" href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentInfo'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&type=1&needCheck=yes&fromType=1&isPact=no');">详细</a></li>-->
                <li><a m="HighSeasList" v="4" ispurview="true" href="javascript:;" onclick="ToSea({$arrcheckList.agent_id});">踢入公海</a></li>
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}