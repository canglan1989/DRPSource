{foreach from=$arrAgentList item=arrcheckList}
    <tr>
	<td><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
	<td><div class="ui_table_tdcntr"><a onclick="JumpPage('{au d=agent c=agent a=showAgentInfo p='agentId='}{$arrcheckList.agent_id}&checkStatus=1&fromType=2');" style="cursor:pointer;">{$arrcheckList.cur_agent_name}</a></div></td>
	<td><div class="ui_table_tdcntr">{$arrcheckList.area_fullname}</div></td>
	<td><div class="ui_table_tdcntr">{$arrcheckList.product_type_name}</div></td>
	<td><div class="ui_table_tdcntr">{$arrcheckList.cname}</div></td>
	<td><div class="ui_table_tdcntr">{$arrcheckList.ename}</div></td>
	<td><div class="ui_table_tdcntr">{$arrcheckList.check_time}</div></td>
	<td><div class="ui_table_tdcntr">
	    {if $arrcheckList.agent_level eq 0}无等级{/if}
	    {if $arrcheckList.agent_level eq 1}金牌{/if}
	    {if $arrcheckList.agent_level eq 2}银牌{/if}
	</div></td>
	<td><div class="ui_table_tdcntr">
		<ul class="list_table_operation">
		    <li><a m="AgentSigned" v="8" ispurview="true" onclick="JumpPage('{au d=Agent c=AgentMove a=RemoveSign p='pactid='}{$arrcheckList.aid}&agentID={$arrcheckList.agent_id}');" style="cursor:pointer;">解除签约</a></li>
		</ul>
	    </div></td>
    </tr>
{/foreach}