{foreach from=$arrayData item=arrcheckList}
<tr>
    <td title=""><div class="ui_table_tdcntr">
    <input class="checkInp" type="checkbox" name="listid" value="{$arrcheckList.agent_id}"/></div></td>
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$arrcheckList.agent_id}')">{$arrcheckList.agent_name}</a></div></td>
    <td title="{$arrcheckList.intention_level}"><div class="ui_table_tdcntr">{$arrcheckList.intention_level}</div></td>     
    <td title="{$arrcheckList.industry_text}"><div class="ui_table_tdcntr">{$arrcheckList.industry_text}</div></td>      
    <td title="{$arrcheckList.agent_reg_area_full_name}"><div class="ui_table_tdcntr">{$arrcheckList.agent_reg_area_full_name}</div></td>
    <td title="{$arrcheckList.charge_person}"><div class="ui_table_tdcntr">{$arrcheckList.charge_person}</div></td>
    <td title="{$arrcheckList.charge_tel}"><div class="ui_table_tdcntr">{$arrcheckList.charge_tel}</div></td>            
    <td title="{$arrcheckList.communicate_number}"><div class="ui_table_tdcntr">{$arrcheckList.communicate_number}</div></td>     
    <td title="{$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}"><div class="ui_table_tdcntr">{$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}</div></td>                                                     
    <td title="{$arrcheckList.agent_channel_user_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arrcheckList.channel_uid});">{$arrcheckList.agent_channel_user_name}</a></div></td>
    <td>
        <div class="ui_table_tdcntr">            
            <ul class="list_table_operation">
                <li><a m="showAgentPager" v="8" ispurview="true" href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='EditShow'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&needCheck=no&fromType=4');" style="cursor:pointer;">修改</a></li>
                <li><a m="showAgentPager" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentInfo'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&type=2&needCheck=no&fromType=4');" style="cursor:pointer;">查看</a></li>
                <li><a m="showAgentPager" v="16" ispurview="true" href="javascript:;" onclick="IM.agent.agentMove('{au d=Agent c=AgentMove a=agentmoveshow}&agentId={$arrcheckList.agent_id}',{literal}{}{/literal},'转移代理商')" style="cursor:pointer;">转移</a></li>
                <li><a m="showMovePager" v="2" ispurview="true" onclick="JumpPage('/?d=Agent&c=Agent&a=showMovePager&agentNo={$arrcheckList.agent_no}');" style="cursor:pointer;">查看流转记录</a></li> 
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}