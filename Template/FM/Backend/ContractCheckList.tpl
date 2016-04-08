{foreach from=$arrayData item=arrPactcheckList}
<tr class="">                                                                       
    <td title="{$arrPactcheckList.agent_no}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}'id':{$arrPactcheckList.agent_id}{literal}}{/literal})">{$arrPactcheckList.agent_no}</a></div></td>
    <td title="{$arrPactcheckList.cur_agent_name}"><div class="ui_table_tdcntr">{$arrPactcheckList.cur_agent_name}</div></td>
    <td title="{$arrPactcheckList.area_fullname}"><div class="ui_table_tdcntr">{$arrPactcheckList.area_fullname}</div></td>
    <td title="{$arrPactcheckList.pact_number}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$arrPactcheckList.aid}&agentId={$arrPactcheckList.agent_id}')">{$arrPactcheckList.pact_number}</a></div></td>
    <td>
    <div class="ui_table_tdcntr">
    {if $arrPactcheckList.pact_type eq 0}
    未签约
    {elseif $arrPactcheckList.pact_type eq 1}
    {$arrPactcheckList.pact_stage}(新签)
    {elseif $arrPactcheckList.pact_type eq 2}
    {$arrPactcheckList.pact_stage}(续签)
    {elseif $arrPactcheckList.pact_type eq 3}
    解除签约
    {elseif $arrPactcheckList.pact_type eq 4 || $arrPactcheckList.pact_edate < $smarty.now|date_format:'%Y-%m-%d'}
    {$arrPactcheckList.pact_stage}(失效)
    {/if}
    </div>
    </td>
    <td title="{if $arrPactcheckList.agent_level eq 0}无等级{elseif $arrPactcheckList.agent_level eq 1}金牌{elseif $arrPactcheckList.agent_level eq 2}银牌{/if}">
    <div class="ui_table_tdcntr">
    	{if $arrPactcheckList.agent_level eq 0}无等级{/if}
	    {if $arrPactcheckList.agent_level eq 1}金牌{/if}
	    {if $arrPactcheckList.agent_level eq 2}银牌{/if}
    </div>
    </td> 
    <td title="{$arrPactcheckList.product_type_name}"><div class="ui_table_tdcntr">{$arrPactcheckList.product_type_name}</div></td>      
    <td title="{$arrPactcheckList.user_name}({$arrPactcheckList.e_name})"><div class="ui_table_tdcntr">{$arrPactcheckList.user_name}({$arrPactcheckList.e_name})</div></td>
    <td title="{$arrPactcheckList.create_time}"><div class="ui_table_tdcntr">{$arrPactcheckList.create_time}</div></td>
    <td title="{if $arrPactcheckList.contract_check eq 0}未审核{elseif $arrPactcheckList.contract_check eq 1}审核通过{elseif $arrPactcheckList.contract_check eq 2}审核退回{/if}">
    <div class="ui_table_tdcntr">
    	{if $arrPactcheckList.contract_check eq 0}
        	未审核
        {elseif $arrPactcheckList.contract_check eq 1}
        	审核通过
        {elseif $arrPactcheckList.contract_check eq 2}
        	审核退回
        {/if}
    </div>
    </td>                                     
    <td>
    	{if $arrPactcheckList.contract_check eq 0}
        <div class="ui_table_tdcntr">
        <a href="javascript:;" m="ContractCheck" v="4" ispurview="true" onclick="JumpPage('{au d=Agent c=AgentMove a=signCheckShow}&aid={$arrPactcheckList.aid}&agentId={$arrPactcheckList.agent_id}&pactType={$arrPactcheckList.pact_type}&checkPerson=contractManager');">签约审核</a>
        </div>
        {/if}
    </td>
</tr> 
{/foreach}   