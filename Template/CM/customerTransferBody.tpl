{foreach from=$arrayData item=data key=index}
  <tr>
    <td><div class="ui_table_tdcntr"><input name="listid" class="checkInp" value="{$data.agent_customer_id}" type="checkbox"/></div></td>

    <td title="{$data.customer_id}"><div class="ui_table_tdcntr">{$data.customer_id}</div></td>

    <td><div class="ui_table_tdcntr"><a title="{$data.customer_name}" href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td title="{$data.user_name}"><div class="ui_table_tdcntr">{$data.user_name}</div></td>
  </tr>
{/foreach}
