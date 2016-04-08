{foreach from=$arrayData item=arrPactAgent}
<tr>
    <td title="{$arrPactAgent.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="IM.agent.getAgentInfoCard('id={$arrPactAgent.agent_id}')" href="javascript:;">{$arrPactAgent.agent_name}</a>
    </div></td>
    <td title="{$arrPactAgent.number_of_contacts}"><div class="ui_table_tdcntr">{$arrPactAgent.number_of_contacts}</div></td>  
    <td title="{$arrPactAgent.e_name}"><div class="ui_table_tdcntr">{$arrPactAgent.e_name}</div></td>      
    <td title="{$arrPactAgent.contact_name}"><div class="ui_table_tdcntr">{$arrPactAgent.contact_name}</div></td>                               
    <td title="{$arrPactAgent.tel}"><div class="ui_table_tdcntr">{$arrPactAgent.mobile}{if $arrPactAgent.tel neq ''}/{$arrPactAgent.tel}{/if}</div></td>
    <td title="{$arrPactAgent.contact_time}"><div class="ui_table_tdcntr">{$arrPactAgent.contact_time}</div></td>    
    <td title="{$arrPactAgent.create_time}"><div class="ui_table_tdcntr">{$arrPactAgent.create_time}</div></td>                                
    <td title="{$arrPactAgent.product_type_name}"><div class="ui_table_tdcntr">{$arrPactAgent.product_type_name}</div></td>
    <td title="{if $arrPactAgent.is_invite == 1}是{else}否{/if}"><div class="ui_table_tdcntr">{if $arrPactAgent.is_invite == 1}是{else}否{/if}</div></td>
    <td title="{$arrPactAgent.remark}"><div class="ui_table_tdcntr">{$arrPactAgent.remark}</div></td>
</tr>
{/foreach}