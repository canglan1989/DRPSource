{foreach from=$arrayUser item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.pact_sdate}/{$data.pact_edate}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.user_id == 0}无{else}{$data.user_name}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.user_id != 0}{$data.e_name}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.user_id != 0}{$data.phone}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.user_id != 0}{$data.tel}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.user_id == 0}<span style="color:#EE5F00;">未开通</span>{else}{if $data.is_lock==0}<span style="color:#028100;">正常</span>{else}<span style="color:#EE5F00;">关闭</span>{/if}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.user_id == 0}无{else}{$data.create_time|date_format:"%Y-%m-%d"}{/if}</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    {if $data.user_id == 0}
	<li><a m="Back_AgentUserList" v="4" ispurview="true"  onclick="JumpPage('/?d=System&c=AgentUser&a=createAccountShow&agentid={$data.agent_id}');" style="cursor:pointer;">账户开通</a></li>
    {else}
    <li><a m="Back_AgentUserList" v="16" ispurview="true" href="javascript:;" onclick="IM.agent.setPWDComfirm('{$data.user_id}')">重置密码</a></li>
    <li><a m="Back_AgentUserList" v="8" ispurview="true" onclick="JumpPage('{au d="System" c="AgentUser" a="createAccountShow"}&agentid={$data.agent_id}');" style="cursor:pointer;">编辑</a></li>
    <li><a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AgentPactChild','id={$data.agent_id}','查看子账户')">子账号</a></li>
    {/if}
      </ul></div>
    </td>            
  </tr>
{/foreach}
