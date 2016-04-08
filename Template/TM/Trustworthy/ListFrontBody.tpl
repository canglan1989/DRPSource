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
        <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=Trustworthy a=getOrderStatus}','id={$data.order_id}','产品订单流程',800);">{$data.order_state}</a></div>
    </td>
    <td title="{$data.user_name_id}">
        <div class="ui_table_tdcntr">
            <a onclick="UserDetial({$data.post_uid})"
                href="javascript:;">{$data.user_name_id}</a></div>
    </td>
    <td title="{$data.create_time}">
        <div class="ui_table_tdcntr">
            {$data.create_time}</div>
    </td>
    <td title="{$data.last_check_time}">
        <div class="ui_table_tdcntr">
            {$data.last_check_time}</div>
    </td>
    <td title="{$data.task_state}">
        <div class="ui_table_tdcntr">
            {$data.task_state}</div>
    </td>
    <td title="{$data.web_site}">
        <div class="ui_table_tdcntr">
            <a href="http://{$data.web_site}" target="_blank">{$data.web_site}</a></div>
    </td>
    <td title="{$data.contact_name|strip_tags}">
        <div class="ui_table_tdcntr">
            {$data.contact_name}</div>
    </td>
    <td title="{$data.order_date|strip_tags}">
        <div class="ui_table_tdcntr">{$data.order_date}</div>
    </td>
    <td title="{$data.effect_date|strip_tags}">
        <div class="ui_table_tdcntr">{$data.effect_date}</div>
    </td>
    <td title="{$data.i_verify}">
        <div class="ui_table_tdcntr">
            {$data.i_verify}</div>
    </td>
    <td>
        <div class="ui_table_tdcntr">
            <ul class="list_table_operation">
            {if $data.get_code_state=="已获取"}
                <li><a m="Trustworthy" v="512" ispurview="true" href="javascript:;" onclick="IM.task.checkRegCode({literal}{{/literal}id:{$data.order_id}{literal}}{/literal})">查看认证代码</a></li>
            {if $data.task_state=="未添加"}
                <li><a m="Trustworthy" v="1024" ispurview="true" href="javascript:;" onclick="IM.task.addTaskTag({literal}{{/literal}id:{$data.order_id}{literal}}{/literal})">任务标记</a></li>
            {/if}
            {/if}
            </ul>
        </div>
    </td>
</tr>
{/foreach}