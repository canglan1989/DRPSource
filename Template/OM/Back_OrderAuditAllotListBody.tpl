{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td title="">
        <div class="ui_table_tdcntr">
        {if $data.check_status == 0}
            <input class="checkInp" type="checkbox" name="listid" value="{$data.order_id}"/>
    	{else}
    	   <input class="checkInp" type="checkbox" disabled="disabled"/>
        {/if}
        </div>
    </td>
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td  title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td  title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_name}</a>
    </div></td>
    <td  title="{$data.product_name}"><div class="ui_table_tdcntr">
    {$data.product_name}
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.order_type}</div></td>
    <td title="{$data.post_date|date_format:"%Y-%m-%d"}"><div class="ui_table_tdcntr">{$data.post_date|date_format:"%Y-%m-%d"}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.allolt_audit_uid > 0}
    <a onclick="UserDetial({$data.allolt_audit_uid})" href="javascript:;">{$data.audit_user_name}</a>
    {else}
    --
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo({$data.order_id})" href="javascript:;">{if $data.check_status_text == "审核中"}未审核{else}{$data.check_status_text}{/if}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.allolt_audit_uid > 0}
    <a onclick="UserDetial({$data.allolt_uid})" href="javascript:;">{$data.allolt_user_name}</a>
    {else}
    --
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.allolt_audit_uid > 0}
    {$data.allolt_time}
    {else}
    --
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr">
        
            <ul class="list_table_operation">
                {if $data.check_status == 0}
                {if $data.allolt_audit_uid == 0}
                <li><a m="Back_OrderAuditAllotList" v="4" ispurview="true" href="javascript:;" onclick="AlloltAudit({$data.order_id},-100,'')">分配</a></li>
                {else}
                <li><a m="Back_OrderAuditAllotList" v="4" ispurview="true" href="javascript:;" onclick="ChangeAudit('{$data.order_id}','{$data.audit_uid}','{$data.audit_user_name}')">转移</a></li>
                {/if}
                {/if}
          </ul>
          
        </div>
      </td>
  </tr>
{/foreach}