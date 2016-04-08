{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.order_id}');">{$data.order_no}</a></div>
        </td>
        <td title="{$data.agent_name_id}">
            <div class="ui_table_tdcntr">{$data.agent_name_id}</div>
        </td>
        <td title="{$data.order_type}">
            <div class="ui_table_tdcntr">{$data.order_type}</div>
        </td>
        <td title="{$data.cus_name_id}">
            <div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$data.cus_name_id}</a></div>
        </td>
        <td title="{$data.product_name}">
            <div class="ui_table_tdcntr">{$data.product_name}</div>
        </td>
        <td title="{$data.make_type}">
            <div class="ui_table_tdcntr">{$data.make_type}</div>
        </td>
<!--
        <td title="{$data.verify_state}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=NetOpe a=getOrderStatusShort}','id={$data.order_id}','产品订单流程',800);">{$data.verify_state}</a></div>
        </td>
-->
        <td title="{$data.order_state}">
            <div class="ui_table_tdcntr">
                <a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=NetOpe a=getOrderStatusLong}','id={$data.order_id}','产品订单流程',800);">
                    {$data.order_state}</a></div>
        </td>
        <td title="{$data.bakcUp_code}">
            <div class="ui_table_tdcntr">{$data.bakcUp_code}</div>
        </td>
        <td title="{$data.i_backUp}">
            <div class="ui_table_tdcntr">{$data.i_backUp}</div>
        </td>
        <td title="{$data.verify_remark}">
            <div class="ui_table_tdcntr">{$data.verify_remark}</div>
        </td>
        <td title="{$data.verify_time|strip_tags}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$data.verify_uid})">{$data.verify_name_id}</a><br />{$data.verify_time}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    {if $data.verify_state neq "审核通过"}
                        <li><a m="SiteVerify" v="512" ispurview="true" href="javascript:;" onclick="IM.agent.getSubmittedBy('{au d=TM c=NetOpe a=ShowSiteVerifyCard}','order_id={$data.order_id}','网站评审',700)">评审</a></li>
                    {/if}
                    <li><a m="SiteVerify" v="1024" target="_blank" ispurview="true" href="{$data.site_ip}">预览</a></li>
                </ul>
            </div>
        </td>
    </tr>
{/foreach}