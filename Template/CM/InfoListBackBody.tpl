
{foreach from=$arrayData item=data key=index}
  <tr>
<!--    <td><div class="ui_table_tdcntr"><input name="listid" class="checkInp" value="{$data.customer_id}" type="checkbox"/></div></td>-->
    <td title="{$data.customer_id}"><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a title="{$data.customer_name}" href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title="{$data.industry_name}"><div class="ui_table_tdcntr">{$data.industry_name}</div></td>
    <td title="{$data.area_name}"><div class="ui_table_tdcntr">{$data.area_name}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td title="{$data.customer_resource_cn}"><div class="ui_table_tdcntr">{$data.customer_resource_cn}</div></td>
    <td title="{$data.check_status_cn}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showCheckStatus({$data.customer_id})">{$data.check_status_cn}</a></div></td>
    <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title="{$data.create_user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.create_uid})" href="javascript:;" >{$data.create_user_name}</a></div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a m='showBackInfoList' v="16" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showModifyBack"}&customer_id={$data.customer_id}')">编辑</a></li>
        <li><a m='showBackInfoList' v="16" ispurview="true" href="javascript:;" onclick="showTransfer({$data.customer_id})">转移</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}
