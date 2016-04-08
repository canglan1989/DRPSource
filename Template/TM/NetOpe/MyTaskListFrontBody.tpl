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
    <td title="{$data.order_state}">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=NetOpe a=getOrderStatusLong}','id={$data.order_id}','产品订单流程',800);">
                {$data.order_state}</a></div>
    </td>
    <td title="{$data.make_state}">
        <div class="ui_table_tdcntr">
            {$data.make_state}</div>
    </td>
    <td title="{$data.verify_state}">
        <div class="ui_table_tdcntr">
            {$data.verify_state}</div>
    </td>
    <td title="{$data.make_finish_time}">
        <div class="ui_table_tdcntr">
            {$data.make_finish_time}</div>
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
            {if $data.verify_state=="未审核"}
                <li><a m="MyTask" v="1024" ispurview="true" href="javascript:;" onclick="IM.task.addTag('{au d=TM c=NetOpe a=setFinish}',{literal}{{/literal}id:{$data.order_id},status:1{literal}}{/literal},'标记完成')">
                    完成</a></li><!--state  0完成 1修改完成-->
            {/if}
            {if $data.verify_state=="审核未通过"}
                <li><a m="MyTask" v="512" ispurview="true" href="javascript:;" onclick="IM.task.addTag('{au d=TM c=NetOpe a=setFinish}',{literal}{{/literal}id:{$data.order_id},status:2{literal}}{/literal},'标记已修改完成')">
                    修改完成</a></li>
            {/if}
            <li><a m="MyTask" v="2048" ispurview="true" target="_blank" href="{$data.site_url}" onclick="">制作</a></li>
            </ul>
        </div>
    </td>
</tr>
{/foreach}