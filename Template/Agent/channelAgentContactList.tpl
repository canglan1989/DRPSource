{foreach from=$arrayData item=arrChannelAgent}
<tr>
    <td title=""><div class="ui_table_tdcntr">
    <input class="checkInp" type="checkbox" name="listid" value="{$arrChannelAgent.agent_id}"/></div></td>
    <td title="{$arrChannelAgent.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="IM.agent.getAgentInfoCard('id={$arrChannelAgent.agent_id}')" href="javascript:;">{$arrChannelAgent.agent_name}</a>
    </div></td>
    <td title="{$arrChannelAgent.number_of_contacts}"><div class="ui_table_tdcntr">{$arrChannelAgent.number_of_contacts}</div></td> 
    <td title="{$arrChannelAgent.e_name}"><div class="ui_table_tdcntr">{$arrChannelAgent.e_name}</div></td>      
    <td title="{$arrChannelAgent.contact_name}"><div class="ui_table_tdcntr">{$arrChannelAgent.contact_name}</div></td>                               
    <td title="{$arrChannelAgent.tel}"><div class="ui_table_tdcntr">{$arrChannelAgent.mobile}{if $arrChannelAgent.tel neq ''}/{$arrChannelAgent.tel}{/if}</div></td>
    <td title="{$arrChannelAgent.contact_time}"><div class="ui_table_tdcntr">{$arrChannelAgent.contact_time}</div></td>
    <td title="{$arrChannelAgent.create_time}"><div class="ui_table_tdcntr">{$arrChannelAgent.create_time}</div></td>
    <td title="{if $arrChannelAgent.is_invite == 1}是{else}否{/if}"><div class="ui_table_tdcntr">{if $arrChannelAgent.is_invite == 1}是{else}否{/if}</div></td>
    <td title="{$arrChannelAgent.remark}"><div class="ui_table_tdcntr">{$arrChannelAgent.remark}</div></td>                                    
    <td title="{$arrChannelAgent.leval}"><div class="ui_table_tdcntr">{$arrChannelAgent.leval}</div></td>
</tr>
{/foreach}