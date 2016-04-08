{foreach from=$arrayData item=data key=index}
  <tr>
    <td title=""><div class="ui_table_tdcntr">{$data.order_move_id}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a></div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.new_order_id}')">{$data.new_order_no}</a></div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.owner_account_name}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id={$data.from_agent_id}')">{$data.from_agent_name}</a></div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id={$data.to_agent_id}')">{$data.to_agent_name}</a></div></td>
     <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid});">{$data.create_user_name}</a></div></td>
     <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
  </tr>
{/foreach}
