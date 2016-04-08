{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.order_id}');">{$data.order_no}</a></div>
        </td>
        <td title="{$data.cus_name_id}">
            <div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$data.cus_name_id}</a></div>
        </td>
        <td title="{$data.product_name}">
            <div class="ui_table_tdcntr">{$data.product_name}</div>
        </td>
        <td title="{$data.order_type}">
            <div class="ui_table_tdcntr">{$data.order_type}</div>
        </td>
        <td title="{$data.order_state}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=EMail a=getOrderStatus}','id={$data.order_id}','产品订单流程',800);">{$data.order_state}</a></div>
        </td>
        <td title="{$data.user_name}">
            <div class="ui_table_tdcntr">{$data.user_name}</div>
        </td>
        <td title="{$data.create_time}">
            <div class="ui_table_tdcntr">{$data.create_time}</div>
        </td>
        <td title="{$data.contact_name}">
            <div class="ui_table_tdcntr">{$data.contact_name}</div>
        </td>
        <td title="{$data.contact_way}">
            <div class="ui_table_tdcntr">{$data.contact_way}</div>
        </td>
        <td title="{$data.last_check_time}">
            <div class="ui_table_tdcntr">{$data.last_check_time}</div>
        </td>
        <td title="{$data.info_state}">
            <div class="ui_table_tdcntr">{$data.info_state}</div>
        </td>
        <td title="{$data.mail_state}">
            <div class="ui_table_tdcntr">{$data.mail_state}</div>
        </td>
        <td title="{$data.product_specs}">
            <div class="ui_table_tdcntr">{$data.product_specs}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                {if $data.order_state=="未确认"}
                    <li><a m="EMail" v="512" ispurview="true" href="javascript:;" onclick="IM.task.midifyInfo({literal}{{/literal}id:{$data.order_id}{literal}}{/literal})">信息状态</a></li>
                {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}