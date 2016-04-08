{foreach from=$arrayData item=arrPactcheckList}
    <tr>
	<td title=""><div class="ui_table_tdcntr">{$arrPactcheckList.agent_no}</div></td>
	<td><div class="ui_table_tdcntr"><a title="{$arrPactcheckList.cur_agent_name}" href="javascript:;" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}'id':{$arrPactcheckList.agent_id}{literal}}{/literal})">{$arrPactcheckList.cur_agent_name}</a></div></td>
	<td title=""><div class="ui_table_tdcntr">{$arrPactcheckList.area_fullname}</div></td>
	<td><div class="ui_table_tdcntr">
	    {if $arrPactcheckList.agent_level eq 0}无等级{/if}
	    {if $arrPactcheckList.agent_level eq 1}金牌{/if}
	    {if $arrPactcheckList.agent_level eq 2}银牌{/if}
	</div></td>
	<td title="{$arrcheckList.product_type_name}"><div class="ui_table_tdcntr">{$arrPactcheckList.product_type_name}</div></td>
	<td title="{$arrPactcheckList.user_name}({$arrPactcheckList.e_name})"><div class="ui_table_tdcntr">{$arrPactcheckList.user_name}({$arrPactcheckList.e_name})</div></td>
	<td title="{$arrPactcheckList.create_time}"><div class="ui_table_tdcntr">{$arrPactcheckList.create_time}</div></td>
	<td>
    <div class="ui_table_tdcntr">
	    {if $arrPactcheckList.pact_type eq 0}
        	未签约
        {elseif $arrPactcheckList.pact_type eq 1}
        	新签
        {elseif $arrPactcheckList.pact_type eq 2}
        	续签
        {elseif $arrPactcheckList.pact_type eq 3}
        	解除签约
        {elseif $arrPactcheckList.pact_type eq 4}
        	失效
        {/if}
	</div>
    </td>
    <td>
    <div class="ui_table_tdcntr">
	    {if ($arrPactcheckList.agent_level eq 1 || $arrPactcheckList.agent_level eq 2) && $arrPactcheckList.bigregion_check eq 0}
        	大区总监未审核
        {/if}
        {if $arrPactcheckList.agent_level eq 1 && $arrPactcheckList.bigregion_check eq 1 && $arrPactcheckList.channel_check eq 0}
        	渠道副总未审核
        {/if}
        {if (($arrPactcheckList.agent_level eq 1 && $arrPactcheckList.bigregion_check eq 1 && $arrPactcheckList.channel_check eq 1) || ($arrPactcheckList.agent_level eq 2 && $arrPactcheckList.bigregion_check eq 1)) && $arrPactcheckList.contract_check eq 0}
        	部门审核通过
        {/if}
        {if (($arrPactcheckList.agent_level eq 1 && $arrPactcheckList.bigregion_check eq 1 && $arrPactcheckList.channel_check eq 1) || ($arrPactcheckList.agent_level eq 2 && $arrPactcheckList.bigregion_check eq 1)) && $arrPactcheckList.contract_check eq 1}
        	合同部审核通过
        {/if}
        {if $arrPactcheckList.bigregion_check eq 2 || $arrPactcheckList.channel_check eq 2 || $arrPactcheckList.contract_check eq 2}
        	审核退回
        {/if}
	</div>
    </td>
    <td>
    <div class="ui_table_tdcntr">
	    {$arrPactcheckList.account_name}
	</div>
    </td>
	<td>
    <div class="ui_table_tdcntr">
        <ul class="list_table_operation">
        {if ($arrPactcheckList.agent_level eq 1 || $arrPactcheckList.agent_level eq 2) && $arrPactcheckList.bigregion_check eq 0}
            <li>
                <a m="AgentSignedAudit" v="32" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=signCheckShow}&aid={$arrPactcheckList.aid}&agentId={$arrPactcheckList.agent_id}&pactType={$arrPactcheckList.pact_type}&checkPerson=bigBoss');">大区总监审核</a>
            </li>
        {/if}
       	{if $arrPactcheckList.agent_level eq 1 && $arrPactcheckList.bigregion_check eq 1 && $arrPactcheckList.channel_check eq 0}
            <li>
                <a m="AgentSignedAudit" v="512" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=signCheckShow}&aid={$arrPactcheckList.aid}&agentId={$arrPactcheckList.agent_id}&pactType={$arrPactcheckList.pact_type}&checkPerson=bigCeo');">渠道副总审核</a>
            </li>
       	{/if}
        </ul>
    </div>
    </td>
    </tr>
{/foreach}