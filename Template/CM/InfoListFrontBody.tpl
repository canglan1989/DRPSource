{foreach from=$arrayData item=data key=index}
  <tr>
    <td><div class="ui_table_tdcntr"><input class="checkInp" type="checkbox" value="{$data.customer_id}" name="listid"/></div></td>
    <td title="{$data.customer_id}"><div class="ui_table_tdcntr">{$data.customer_id}</div></td>   
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" title="{$data.customer_name}" onclick="JumpPage('{au d="CM" c="CMInfo" a="showDetailFront"}&customer_id={$data.customer_id}')">{$data.customer_name}</a></div></td>    
    <td title="{$data.industry_name}"><div class="ui_table_tdcntr">{$data.industry_name}</div></td>
    <td title="{$data.area_name}"><div class="ui_table_tdcntr">{$data.area_name}</div></td>
    <td title="{$data.customer_resource_cn}"><div class="ui_table_tdcntr">{$data.customer_resource_cn}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a onclick="showCheckStatus('{$data.customer_id}')" href="javascript:;">{$data.check_status_cn}</a></div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.record_count}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.last_time}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.defend_state_cn}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.last_record_time != '0000-00-00 00:00:00'}{$data.last_record_time}{else}--{/if}</div></td>
    <td title="{$data.last_record_content}"><div class="ui_table_tdcntr">{$data.last_record_content|truncate:"50":"……"}</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    {if $data.history_check == "1"  }
    {if $valueProduct == 1}
      <li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showCustomerOrderFront"}&customer_id={$data.customer_id}')" >提交增值产品订单</a></li>
      {/if}
      {if $unitProduct == 1}
      <li><a m="UnitOrderModify" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="OM" c="Order" a="UnitOrderPostStep1"}&customer_id={$data.customer_id}')" >提交网盟订单</a></li>
      {/if}
      {/if}
      <li><a onclick="showAddContactRecode({$data.customer_id})" href="javascript:;">添加联系小记</a></li>
      <li><a onclick="showAddVisitInvite({$data.customer_id})" href="javascript:;">添加拜访预约</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}
