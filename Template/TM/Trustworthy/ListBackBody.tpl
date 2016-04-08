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
        <td title="{$data.agent_name_id}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}id:{$data.agent_id}{literal}}{/literal})">{$data.agent_name_id}</a></div>
        </td>
        <td title="{$data.order_type}">
            <div class="ui_table_tdcntr">
                {$data.order_type}</div>
        </td>
        <td title="{$data.order_state}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('{au d=TM c=Trustworthy a=getOrderStatus}','id={$data.order_id}','产品订单流程',800);">{$data.order_state}</a></div>
        </td>
        <td title="{$data.trustworthy_code}">
            <div class="ui_table_tdcntr">{if $data.trustworthy_code != "" }<a href="javascript:;" onclick="ViewComfirmCode({$data.order_id})">{$data.trustworthy_code}</a>{else}--{/if}</div>
        </td>
        <td title="{$data.web_site}">
            <div class="ui_table_tdcntr"><a href="http://{$data.web_site}" target="_blank">{$data.web_site}</a></div>
        </td>
        <td title="{$data.order_date|strip_tags}">
            <div class="ui_table_tdcntr">{$data.order_date}</div>
        </td>
        <td title="{$data.effect_date|strip_tags}">
            <div class="ui_table_tdcntr">{$data.effect_date}</div>
        </td>
        <td title="{$data.i_verify}">
            <div class="ui_table_tdcntr">{$data.i_verify}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li>
                    <a m="Trustworthy" v="512" ispurview="true" href="javascript:;" onclick="IM.task.CXCode('{au d=TM c=Trustworthy a=TrustCodeCard}',{literal}{{/literal}oid:{$data.order_id}{literal}}{/literal},
                    '{if $data.get_code_uid > 0}修改{else}添加{/if}认证代码')">{if $data.get_code_uid > 0}修改{else}添加{/if}认证代码</a>
                    </li>                    
                        {if $data.i_verify eq "未校验" &&  $data.task_state eq "已添加"}
                    <li><a m="Trustworthy" v="1024" ispurview="true" href="javascript:;" onclick="IM.task.check({literal}{{/literal}id:{$data.order_id}{literal}}{/literal})">校验</a>
                    </li>{/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}