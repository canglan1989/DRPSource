{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.order_no}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.order_id}');">{$data.order_no}</a></div></td>
        <td title="{$data.product_name}"><div class="ui_table_tdcntr">{$data.product_name}</div></td>
        <td title="{$data.order_state}">
            <div class="ui_table_tdcntr">
                <a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=NetOpe a=getOrderStatusLong}','id={$data.order_id}','产品订单流程',800);">
                    {$data.order_state}</a></div>
        </td>
        <td title="{$data.cus_name_id}"><div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$data.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$data.cus_name_id}</a></div></td>
        <td title="{$data.icp_contact_name|strip_tags}"><div class="ui_table_tdcntr">{$data.icp_contact_name}</div></td>
        <td title="{$data.web_site|strip_tags}"><div class="ui_table_tdcntr">{$data.web_site}</div></td>
        <td title="{$data.backUp_state}"><div class="ui_table_tdcntr">{$data.backUp_state}</div></td>
        <td title="{$data.bakcUp_code}">
            <div class="ui_table_tdcntr">{$data.bakcUp_code}</div>
        </td>
<!--        <td title="{$data.begin_back|strip_tags}">
            <div class="ui_table_tdcntr">{$data.begin_back}</div>
        </td>-->
        <td title="{$data.end_back|strip_tags}">
            <div class="ui_table_tdcntr">{$data.end_back}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a m="ICP" v="512" ispurview="true" href="javascript:;" onclick="IM.agent.getSubmittedBy('{au d=TM c=NetOpe a=ShowICPModifyContact}','order_id={$data.order_id}','网站评审',500)">修改联系人</a></li>
                    {if $data.backUp_state=="未备案"}
                    <li><a m="ICP" v="1024" ispurview="true" href="javascript:;" onclick="IM.task.BAFinish({$data.order_id})">完成备案</a></li>
                    {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}