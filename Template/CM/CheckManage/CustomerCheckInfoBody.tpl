{foreach from=$arrayData item=data key=index}
  <tr>
    <td title="{$data.customer_id}"><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr" >{$data.agent_name}</div></td>
    <td title="{if $data.check_type == '1'}新增{elseif $data.check_type == '2'}编辑{else}删除{/if}"><div class="ui_table_tdcntr" >{if $data.check_type == '1'}新增{elseif $data.check_type == '2'}编辑{else}删除{/if}</div></td>
    <td title="{$data.create_time}"><div class="ui_table_tdcntr" >{$data.create_time}</div></td>
    <td title="{$data.create_user_name}"><div class="ui_table_tdcntr" ><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a></div></td>
<!--    <td title="{$data.check_user_name}"><div class="ui_table_tdcntr" >{$data.check_user_name}</div></td>-->
    <td title=""><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
        <li><a m="showVerifyList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMVerify" a="showCHechInfo"}&aid={$data.aid}&posttype={$data.check_type}')">审核</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}