{foreach from=$arrayData item=arr}
    <tr class="">
        
        <td title="{$arr.pact_number}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=singleSignDetail}&pactId={$arr.aid}&agentId={$arr.agent_id}');">{$arr.pact_number}</a></div></td>
        <td title="{$arr.cur_agent_name}" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$arr.agent_id}')">{$arr.cur_agent_name}</a></div></td>        
       
        
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.old_id});">{$arr.old_ename}{$arr.old_username}</a></div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.new_id});">{$arr.new_ename}{$arr.new_username}</a></div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.create_uid});">{$arr.e_name}{$arr.user_name}</a></div></td>
        <td><div class="ui_table_tdcntr">{$arr.create_time}</div></td>   
        
    </tr>
{/foreach}