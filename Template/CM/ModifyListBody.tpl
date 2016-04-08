
{foreach from=$arrayData item=data key=index}
  <tr>
    <td title="{$data.customer_id}"><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a title="{$data.customer_name}" href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title="{$data.industry_fullname}"><div class="ui_table_tdcntr">{$data.industry_fullname}</div></td>
    <td title="{$data.area_fullname}"><div class="ui_table_tdcntr">{$data.area_fullname}</div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title="{$data.user_name}"><div class="ui_table_tdcntr"><a onclick = "UserDetial({$data.create_uid})" href="javascript:;">{$data.user_name}</a></div></td>

    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a m="showModifyList" v="128" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMModify" a="showModifyHistroyList"}&customer_id={$data.customer_id}')">修改记录</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}
