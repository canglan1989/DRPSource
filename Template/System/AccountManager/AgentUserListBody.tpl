{foreach from=$arrayUser item=data key=index}
<tr class="{sdrclass rIndex=$index}">
<td><div class="ui_table_tdcntr">{$data.user_name}</div></td>
<td><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.user_id})" href="javascript:;">{$data.e_name}</a></div></td>
<td><div class="ui_table_tdcntr">{if $data.is_lock == 1 }<span style="color:#EE5F00;">停用</span>{else}<span style="color:#028100;">正常</span>{/if}</div></td>
<td  title="{$data.dept_name}"><div class="ui_table_tdcntr">{$data.dept_name}</div></td>
<td><div class="ui_table_tdcntr">{if $data.is_finance == 1}<span style="color:red">是</span>{else}否{/if}</div></td>
<td><div class="ui_table_tdcntr">{$data.finance_user_name}</div></td>
<td><div class="ui_table_tdcntr">            
{if $data.account_level == 1}
{$data.account_level}级
{else}
<a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AccountLevelDetail&id=',{literal}{{/literal}id:{$data.user_id}{literal}}{/literal},'账号层级信息',400)">{$data.account_level}级</a>
{/if}            
</div></td>
<td><div class="ui_table_tdcntr">{$data.phone}</div></td>
<td><div class="ui_table_tdcntr">{$data.tel}</div></td>
{if $iCanToCRM == 1}
<td><div class="ui_table_tdcntr">{$data.haveToCRM}</div></td>
{/if}
<td><div class="ui_table_tdcntr">{$data.create_time|date_format:"%Y-%m-%d"}</div></td>
<td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    <li><a m="AgentUserList" v="4" ispurview="true" href="javascript:;" onclick="IM.agent.setPWDComfirm({$data.user_id})">重置密码</a></li>
    <li><a m="AgentUserList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="AgentUser" a="AgentUserModify"}&id={$data.user_id}')">编辑</a></li>
    <li><a m="AgentUserList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="AgentUser" a="AgentUserModify"}&pno={$data.user_no}')">添加下级</a></li>
    {if !($data.finance_no == $finance_no && $data.is_finance == 1)}
    <li><a m="AgentUserList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="System" c="AgentUser" a="AgentUserDel"}&id={$data.user_id}',{literal}{{/literal}id:{$data.user_id}{literal}}{/literal},'删除用户',this)">删除</a></li>
    {/if}
    {if $data.haveToCRM == "是"}
    <li><a m="AgentUserList" v="8" ispurview="true" href="javascript:;" onclick="DelCRMUser({$data.user_id})">删除CRM帐户</a></li>
    {/if}
  </ul></div>
</td>            
</tr>
{/foreach}