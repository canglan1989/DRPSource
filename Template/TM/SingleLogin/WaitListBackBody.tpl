{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.ord_order_id}');">{$data.order_no}</a></div>
        </td>
        <td title="{$data.cus_name_id}">
            <div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$data.cus_name_id}</a></div>
        </td>
        <td title="{$data.product_name}">
            <div class="ui_table_tdcntr">
                {$data.product_name}</div>
        </td>
        <td title="{$data.agent_name_id}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}id:{$data.agent_id}{literal}}{/literal})">{$data.agent_name_id}</a></div>
        </td>
        <td title="{$data.order_type}">
            <div class="ui_table_tdcntr">
                {$data.order_type}</div>
        </td>
        <td title="{$data.order_state}">
            {if $data.pro_type eq 'py'}
                <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=EMail a=getOrderStatus}','id={$data.ord_order_id}','产品订单流程',800);">{$data.order_state}</a></div>
            {elseif $data.pro_type eq 'wymh'}
                <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=NetOpe a=getOrderStatusLong}','id={$data.ord_order_id}','产品订单流程',800);">{$data.order_state}</a></div>
            {elseif $data.pro_type eq 'cxrz'}
                <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=Trustworthy a=getOrderStatus}','id={$data.ord_order_id}','产品订单流程',800);">{$data.order_state}</a></div>
            {else}
                <div class="ui_table_tdcntr">{$data.order_state}</div>
            {/if}
        </td>
        <td title="{$data.ord_create_time}">
            <div class="ui_table_tdcntr">
                {$data.ord_create_time}</div>
        </td>
        <td title="{$data.last_check_time}">
            <div class="ui_table_tdcntr">
                {$data.last_check_time}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a m="Wait" v="512" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=TM c=SingleLogin a=showAddAccount}&uid={$data.customer_id}&oid={$data.ord_order_id}')">开通账户</a></li>
                </ul>
            </div>
        </td>
    </tr>
{/foreach}