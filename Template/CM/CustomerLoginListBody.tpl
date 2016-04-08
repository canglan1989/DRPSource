{foreach from=$arrayData item=data key=index}
  <tr>
    <td><div class="ui_table_tdcntr"><input class="checkInp" type="checkbox" value="{$data.customer_id}" name="listid"/></div></td>
    <td title="{$data.customer_no}"><div class="ui_table_tdcntr">{$data.customer_no}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a title="{$data.customer_name}" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)" href="javascript:;">{$data.customer_name}</a></div></td>
    <td title="{$data.industry_fullname}"><div class="ui_table_tdcntr">{$data.industry_fullname}</div></td>
    <td title="{$data.area_fullname}"><div class="ui_table_tdcntr">{$data.area_fullname}</div></td>
    <td title="{$data.inten_product}"><div class="ui_table_tdcntr">{$data.inten_product}</div></td>
    <td title="{$data.transstat}"><div class="ui_table_tdcntr">{$data.transstat}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td title="{$data.check_status_name}"><div class="ui_table_tdcntr">{$data.check_status_name}</div></td>
    <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
  </tr>
{/foreach}