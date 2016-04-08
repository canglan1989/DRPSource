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
    <td title="{$data.web_site|strip_tags}">
        <div class="ui_table_tdcntr">
            {$data.web_site}</div>
    </td>
    <td title="{$data.is_analy}">
        <div class="ui_table_tdcntr">
            {$data.is_analy}</div>
    </td>
    <td title="{$data.last_check_time}">
        <div class="ui_table_tdcntr">
            {$data.last_check_time}</div>
    </td>
    <td title="{$data.analy_time}">
        <div class="ui_table_tdcntr">
            {if $data.analy_time eq "0000-00-00 00:00:00"}{else}{$data.analy_time}{/if}</div>
    </td>
    <td title="{$data.analy_name}">
        <div class="ui_table_tdcntr">
            <a onclick="UserDetial({$data.analy_uid})"
                href="javascript:;">{$data.analy_name}</a></div>
    </td>
    <td>
        <div class="ui_table_tdcntr">
            <ul class="list_table_operation">
            {if $data.is_analy<>"已解析"}
                <!--
                邮箱
                -->
                {if $data.product_type_id==1}
                <li><a m="RealmNameAnaly" v="512" ispurview="true" href="javascript:;" onclick="IM.task.addTag('{au d=TM c=EMail a=setAnalyFinsh}',{literal}{{/literal}id:{$data.order_id}{literal}}{/literal},'标记完成')">
                    完成</a></li>
                {/if}
                <!--
                网营
                -->
                {if $data.product_type_id==2}
                <li><a m="RealmNameAnaly" v="512" ispurview="true" href="javascript:;" onclick="IM.task.addTag('{au d=TM c=NetOpe a=setAnalyFinsh}',{literal}{{/literal}id:{$data.order_id}{literal}}{/literal},'标记完成')">
                    完成</a></li>
                {/if}
            {/if}
            </ul>
        </div>
    </td>
</tr>
{/foreach}