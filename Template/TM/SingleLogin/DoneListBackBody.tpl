{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.ord_order_id}');">{$data.order_no}</a></div>
        </td>
        <td title="{$data.cus_name_id}">
            <div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$data.cus_name_id}</a></div>
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
        <td title="{$data.product_name}">
            <div class="ui_table_tdcntr">
                {$data.product_name}</div>
        </td>
        <td title="{$data.deal_user_name}">
            <div class="ui_table_tdcntr">
                {$data.deal_user_name}</div>
        </td>
        <td title="{$data.deal_time}">
            <div class="ui_table_tdcntr">
                {$data.deal_time}</div>
        </td>
        <td title="{$data.login_name}">
            <div class="ui_table_tdcntr">
                {$data.login_name}</div>
        </td>
        <td title="{$data.account_close_user_name}">
            <div class="ui_table_tdcntr">
                {$data.account_close_user_name}</div>
        </td>
        <td title="{if $data.account_close_time == '0000-00-00 00:00:00'}未设置{else}{$data.account_close_time|date_format:"%Y-%m-%d"}{/if}">
            <div class="ui_table_tdcntr">
                {if $data.account_close_time == '0000-00-00 00:00:00'}未设置{else}
                {$data.account_close_time|date_format:"%Y-%m-%d"}
                {/if}
            </div>
        </td>
        <td title="{if empty($data.login_state)}关闭{else}正常{/if}">
            <div class="ui_table_tdcntr">
                {if empty($data.login_state)}关闭{else}正常{/if}
            </div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a m="Done" v="512" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=TM c=SingleLogin a=showAccount }&uid={$data.customer_id}&oid={$data.ord_order_id}')">
                            查看账户</a></li>
                            {if $data.login_state == 1 && $data.order_type_num == -1 && $data.order_status == 60 }
                     <li><a m="Done" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=TM c=SingleLogin a=ToCloseAccount }&uid={$data.customer_id}&oid={$data.ord_order_id}')">
                            关闭账户设置</a></li>
                            {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}