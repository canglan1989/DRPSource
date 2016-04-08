{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td  title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
    </div></td>
    <td  title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_name}</a>
    </div></td>
    <td title="{$data.product_name}"><div class="ui_table_tdcntr">
    {$data.product_name}
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.order_type}</div></td>
    <td class="TA_r" title="{$data.act_price}"><div class="ui_table_tdcntr" >
    {if $data.data_type == 1}
    --
    {else}
    {$data.act_price}
    {/if}
    </div></td>
    <td title="{$data.order_sdate|date_format:"%Y-%m-%d"} -- {$data.order_edate|date_format:"%Y-%m-%d"}"><div class="ui_table_tdcntr">{$data.order_sdate|date_format:"%Y-%m-%d"}<br/>{$data.order_edate|date_format:"%Y-%m-%d"}</div></td>
    <td title="{$data.post_date|date_format:"%Y-%m-%d"}"><div class="ui_table_tdcntr">{$data.post_date|date_format:"%Y-%m-%d"}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    <a  onclick="UserDetial({$data.allolt_uid})" href="javascript:;">{$data.allolt_user_name}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.allolt_time|date_format:"%Y-%m-%d"}
    </div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo({$data.order_id})" href="javascript:;">{if $data.check_status_text == "审核中"}未审核{else}{$data.check_status_text}{/if}</a>
    </div></td>
    <td><div class="ui_table_tdcntr">        
            <ul class="list_table_operation">
            {if $data.check_status == 0}
                <li><a m="My_AuditWorkList" v="32" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}&checkFlag=1')">审核</a></li>
            {elseif $data.check_status == 1 && $data.order_status <3}
                <li><a m="My_AuditWorkList" v="32" ispurview="true" href="javascript:;" onclick="DeleteAudit({$data.order_id})">撤销审核</a></li>
            {/if}
            </ul>          
        </div>
      </td>
  </tr>
{/foreach}