{foreach from=$arrayData item=arrcheckList}
<tr>
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr">
    <a m="AgentList" v="8" ispurview="true" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentinfoAddContact'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&needCheck=yes&isPact=no');" href="javascript:;">{$arrcheckList.agent_name}</a>
    {if $arrcheckList.share_uid neq ''}<span style="color:red;">(享)</span>{/if}
    {if $arrcheckList.agent_type eq '核心'}<span style="color:red;">(核)</span>{/if}
    </div></td>      
    <td title="{$arrcheckList.industry}"><div class="ui_table_tdcntr">{$arrcheckList.industry}</div></td>      
    <td title="{$arrcheckList.pact_product_names}"><div class="ui_table_tdcntr">{$arrcheckList.pact_product_names}</div></td> 
    <td title="{$arrcheckList.share_name}"><div class="ui_table_tdcntr">{$arrcheckList.share_name}</div></td>                                          
    <td title="{$arrcheckList.agent_type}"><div class="ui_table_tdcntr">{$arrcheckList.agent_type}</div></td>
    <td title="{$arrcheckList.train_number}"><div class="ui_table_tdcntr">{$arrcheckList.train_number}</div></td>
    <td title="{$arrcheckList.communicate_number}"><div class="ui_table_tdcntr">{$arrcheckList.communicate_number}</div></td>
    <td title="{$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}"><div class="ui_table_tdcntr">{$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}</div></td>
    <td><div class="ui_table_tdcntr">{$arrcheckList.last_time}{if $arrcheckList.last_type neq ''}({if $arrcheckList.last_type == 1}电话{else}拜访{/if}){/if}</div></td>
    
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a  href="javascript:;" onClick="IM.agent.setAgentType('{au d=Agent c=Agent a=setAgentType}&agentId={$arrcheckList.agent_id}',{literal}{}{/literal},'设置代理商类型')">设置类型</a></li>
                {if $arrcheckList.channel_uid eq $userID and !$arrcheckList.share_uid and $arrcheckList.check_status neq 0}
                <li><a  href="javascript:;" onClick="setShare({$arrcheckList.agent_id})">共享</a></li>
                {/if}
                {if $arrcheckList.channel_uid neq $userID and $arrcheckList.share_uid eq $userID }
                <li><a  href="javascript:;" onClick="cancelShare({$arrcheckList.agent_id})">取消共享</a></li>
                {/if}
            </ul>           
        </div>
    </td>
</tr>
{/foreach}