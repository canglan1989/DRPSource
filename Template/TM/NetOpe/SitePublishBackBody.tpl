{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="">
            <div class="ui_table_tdcntr">
                {if $data.publish_state eq "未发布" || $data.publish_state eq "发布失败"}
                    <input type="radio" value="{$data.order_id}" name="listid" class="checkInp"/>
                {/if}
            </div>
        </td>
        <td title="{$data.order_no}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=OM c=Order a=OrderDetail }&id={$data.order_id}');">{$data.order_no}</a></div>
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
        <td title="{$data.product_name}">
            <div class="ui_table_tdcntr">
                {$data.product_name}</div>
        </td>
        <td title="{$data.web_site}">
            <div class="ui_table_tdcntr">
                {$data.web_site}</div>
        </td>
        <td title="{$data.publish_state}">
            <div class="ui_table_tdcntr">
                {$data.publish_state}</div>
        </td>
        <td title="{$data.i_backUp}">
            <div class="ui_table_tdcntr">
            {$data.i_backUp}</div>
        </td>
        <td title="{$data.onLine_time}">
            <div class="ui_table_tdcntr">
                {$data.onLine_time}</div>
        </td>
        <td title="{$data.publish_name}">
            <div class="ui_table_tdcntr">
                {$data.publish_name}</div>
        </td>
        <td title="{$data.publish_time|strip_tags}">
            <div class="ui_table_tdcntr">
                {$data.publish_time}</div>
        </td>
    </tr>
{/foreach}