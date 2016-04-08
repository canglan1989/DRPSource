{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.order_id}');">{$data.order_no}</a></div>
        </td>
        <td title="{$data.cus_name_id}">
            <div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$data.cus_name_id}</a></div>
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
                {$data.post_user_name_id}</div>
        </td>
        <td title="{$data.post_time}">
            <div class="ui_table_tdcntr">
                {$data.post_time}</div>
        </td>
        <td title="{$data.last_check_time}">
            <div class="ui_table_tdcntr">
                {$data.last_check_time}</div>
        </td>
        <td title="{$data.task_state}">
            <div class="ui_table_tdcntr">
                {$data.task_state}</div>
        </td>
        <td title="{$data.make_name}">
            <div class="ui_table_tdcntr">
                <a onclick="UserDetial({$data.make_uid})"
                   href="javascript:;">{$data.make_name}</a></div>
        </td>
        <td title="{$data.assign_name}">
            <div class="ui_table_tdcntr">
                <a onclick="UserDetial({$data.assign_uid})"
                   href="javascript:;">{$data.assign_name}</a></div>
        </td>
        <td title="{$data.assign_time}">
            <div class="ui_table_tdcntr">
                {$data.assign_time}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    {if $data.task_state=="未分配"}
                    <li><a m="NetTask" v="512" ispurview="true" href="javascript:;" onClick="IM.task.taskDist({literal}{{/literal}id:{$data.order_id}{literal}}{/literal})">分配</a></li>
                    {/if}
                    {if $data.task_state=="已分配"}
                    <li><a m="NetTask" v="1024" ispurview="true" href="javascript:;" onClick="IM.task.taskMove({literal}{{/literal}oid:{$data.order_id},mkuid:{$data.make_uid},mkname:'{$data.make_name}'{literal}}{/literal})">转移</a></li>
                    {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}