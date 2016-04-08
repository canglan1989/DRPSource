{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">
            <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_name}</a>
    </div></td>
    <td class="TA_r" title="{$data.act_price}"><div class="ui_table_tdcntr" >{$data.act_price}</div></td>
    <td><div class="ui_table_tdcntr">{$data.order_type}</div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo({$data.order_id})" href="javascript:;">{$data.order_status_text}</a>
    </div></td>
    {if $data.check_status == -2}
        <td title=""><div class="ui_table_tdcntr">--</div></td>
        <td title=""><div class="ui_table_tdcntr">--</div></td>
    {else}  
        <td  title="{$data.post_user_name} {$data.post_e_name}"><div class="ui_table_tdcntr">
        <a onclick="UserDetial({$data.post_uid})" href="javascript:;">{$data.post_user_name}&nbsp;&nbsp;{$data.post_e_name}</a>
        </div></td>  
        <td title="{$data.post_date}"><div class="ui_table_tdcntr">{$data.post_date}</div></td>
    {/if}
    <td><div class="ui_table_tdcntr">
            <ul class="list_table_operation">
                <li><a m="UnitOrderList" v="4" ispurview="true" href="javascript:;" onclick="OrderTransfer({$data.order_id})"> 转移 </a></li>
          </ul>
        </div>
      </td>
  </tr>
{/foreach}