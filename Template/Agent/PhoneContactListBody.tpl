{foreach from=$arrayData item=arrPactAgent}
<tr>
    <td title="{$arrPactAgent.agent_no}"><div class="ui_table_tdcntr">{$arrPactAgent.agent_no}</div></td>
    <td title="{$arrPactAgent.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="IM.agent.getAgentInfoCard('id={$arrPactAgent.agent_id}')" href="javascript:;">{$arrPactAgent.agent_name}</a>
    </div></td>
    <td title="意向等级或签约产品"><div class="ui_table_tdcntr">
      {if $arrPactAgent.contact_type == 0 && $arrPactAgent.afterlevel <= 'B+' }
                    <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$arrPactAgent.id})" >{$arrPactAgent.intertion_product}</a>
                {else}
                {$arrPactAgent.intertion_product}
            {/if}
    </div></td>  
        
    <td title="{$arrPactAgent.visitor}"><div class="ui_table_tdcntr">{$arrPactAgent.visitor}</div></td>                               
    <td title="{$arrPactAgent.tel}"><div class="ui_table_tdcntr">{$arrPactAgent.mobile}{if !empty($arrPactAgent.mobile) && !empty($arrPactAgent.tel)}<br />{/if}{$arrPactAgent.tel}</div></td>
    <td title="{$arrPactAgent.visit_timestart|date_format:'%Y-%m-%d %H:%M'}"><div class="ui_table_tdcntr">{$arrPactAgent.visit_timestart|date_format:'%Y-%m-%d %H:%M'}</div></td> 
    <td title="{$arrPactAgent.create_user_name}"><div class="ui_table_tdcntr"><a onclick="UserDetial({$arrPactAgent.create_uid})" href="javascript:;">{$arrPactAgent.create_user_name}</a></div></td>     
    <td title="{$arrPactAgent.create_time}"><div class="ui_table_tdcntr">{$arrPactAgent.create_time}</div></td>                                
    <td title="{$arrPactAgent.result}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getTelNoteDetail({$arrPactAgent.id})" >{$arrPactAgent.result|truncate:'18':'……'}</a></div></td>
    <td title="{$arrPactAgent.dynamics}"><div class="ui_table_tdcntr">{$arrPactAgent.dynamics|truncate:'8':'……'}</div></td>
    <td title="{$arrPactAgent.verfity_status}"><div class="ui_table_tdcntr">
      {if $arrPactAgent.verfity_status eq '通过' or $arrPactAgent.verfity_status eq '不通过' }
            <a onclick="verfityDetail({$arrPactAgent.id},1)" href="javascript:;">{$arrPactAgent.verfity_status}</a>
           {else}
           {$arrPactAgent.verfity_status}
           {/if}
     </div></td>
</tr>
{/foreach}