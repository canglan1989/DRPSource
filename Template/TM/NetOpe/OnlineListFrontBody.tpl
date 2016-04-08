{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr">
                 <a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.order_id}');">{$data.order_no}</a></div>
        </td>
        <td title="{$data.cus_name_id}">
            <div class="ui_table_tdcntr">
                <a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);"
                   href="javascript:void(0)">{$data.cus_name_id}</a></div>
        </td>
        <td title="{$data.product_name}">
            <div class="ui_table_tdcntr">
                {$data.product_name}</div>
        </td>
        <td title="{$data.order_type}">
            <div class="ui_table_tdcntr">
                {$data.order_type}</div>
        </td>
        <td title="{$data.order_state}">
            <div class="ui_table_tdcntr">
                <a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=NetOpe a=getOrderStatusLong}','id={$data.order_id}','产品订单流程',800);">
                    {$data.order_state}</a></div>
        </td>
        <td title="{$data.post_user_name_id}">
            <div class="ui_table_tdcntr">
                <a onclick="UserDetial({$data.post_uid})"
                   href="javascript:;">{$data.post_user_name_id}</a></div>
        </td>
        <td title="{$data.post_time}">
            <div class="ui_table_tdcntr">
                {$data.post_time}</div>
        </td>
        <td title="{$data.last_check_time}">
            <div class="ui_table_tdcntr">
                {$data.last_check_time}</div>
        </td>
        <td title="{$data.onLine_time}">
            <div class="ui_table_tdcntr">
                {$data.onLine_time}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a m="OnlineSite" v="512" target="_blank" ispurview="true" href="{$data.site_ip}" onclick="">预览</a></li>
                </ul>
            </div>
        </td>
    </tr>
{/foreach}