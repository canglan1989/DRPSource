{foreach from=$arrayData item=data key=index}
  <tr>
    <td><div class="ui_table_tdcntr"><input value="{$data.aid}" name="listid" class="checkInp" type="checkbox"/></div></td>
    <td title="{$data.customer_id}"><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a title="{$data.customer_name}" href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td title="{$data.info_type}"><div class="ui_table_tdcntr" >{$data.info_type}</div></td>
    <td title="{if $data.info_type eq '修改'}{$data.clog_create_time}{else}{$data.create_time}{/if}">
    	<div class="ui_table_tdcntr">{if $data.info_type eq '修改'}{$data.clog_create_time}{else}{$data.create_time}{/if}</div>
    </td>
    <td title="{$data.user_name}"><div class="ui_table_tdcntr"><a onclick = "UserDetial({$data.create_uid})" href="javascript:;">{$data.user_name}</a></div></td>
    <td title="{$data.check_name}"><div class="ui_table_tdcntr">{if $data.info_type eq '修改'}
                                                                                <a onclick = "UserDetial({$data.clog_assign_check_id})" href="javascript:;">{$data.clog_check_name}</a>
                                                                    {else}
                                                                                <a onclick = "UserDetial({$data.assign_check_id})" href="javascript:;">{$data.check_name}</a>
                                                                    {/if}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
        <li><a m="showVerifyList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMVerify" a="showVerify"}&aid={$data.aid}&agent_customer_id={$data.agent_customer_id}&agent_id={$data.agent_id}')">审核</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}