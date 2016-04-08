{foreach from=$arrayRole item=data key=index}
<tr class="{sdrclass rIndex=$index}">
<td><div class="ui_table_tdcntr">{$data.role_name}</div></td>
<td><div class="ui_table_tdcntr">{if $data.is_finance == 1}<span style="color:red">是</span>{else}否{/if}</div></td>
<td><div class="ui_table_tdcntr">{if $data.finance_uid > 0}
<a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AccountLevelDetail&id=',{literal}{{/literal}id:{$data.finance_uid}{literal}}{/literal},'账号层级信息',400)">{$data.finance_user_name}</a>
{else}系统角色{/if}</div></td>
<td><div class="ui_table_tdcntr">{$data.user_name}</div></td>
<td><div class="ui_table_tdcntr">{if $data.create_user_name != ""}
<a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a>{else}--{/if}
</div></td>
<td><div class="ui_table_tdcntr">{$data.create_time}</div></td>
<td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    <li><a m="RoleManager" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="Role" a="RoleModify"}&id={$data.role_id}')">{if $data.is_system != 1}编辑{else}查看{/if}</a></li>
    {if $data.is_system != 1}
    <li><a m="RoleRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="Role" a="RoleRightModify"}&id={$data.role_id}')">权限</a></li>
        {if $data.user_name == ""}
        <li><a m="RoleManager" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="System" c="Role" a="RoleDel"}&id={$data.role_id}',{literal}{{/literal}id:{$data.role_id}{literal}}{/literal} ,'删除角色',this)">删除</a></li>
        {/if}
    {/if}
  </ul></div>
</td>            
</tr>
{/foreach}