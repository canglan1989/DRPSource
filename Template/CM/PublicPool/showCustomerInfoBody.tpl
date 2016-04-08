{foreach from=$arrayData item=arr}
    <tr class="">
        <td title=""><div class="ui_table_tdcntr"><input type="checkbox" value="{$arr.customer_id}" name="listid" class="checkInp"></div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.customer_id}</div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:void(0);"onclick="JumpPage('/?d=CM&c=CMInfo&a=showCustomerDetail4CustomerInfo&customer_id={$arr.customer_id}')">{$arr.customer_name}</a></div></td>      
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{$arr.area_name}</div></td>                               
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{$arr.industry_name}</div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.customer_resource_cn}</div></td>                                    
        <td title=""><div class="ui_table_tdcntr">{if $arr.log_check > -2}<a href="javascript:void(0);" onclick="JumpPage('{au d="CM" c="CMModify" a="showModifyHistroyList"}&customer_id={$arr.customer_id}&agentid={$AgentID}')">{$arr.check_status_cn}</a>{else}{$arr.check_status_cn}{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.create_time}</div></td>
        <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="CM" c="ContactRecord" a="ContactRecordList"}&customerID={$arr.customer_id}')">{$arr.record_count}</a></div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.is_shield}</div></td>
        <td title=""><div class="ui_table_tdcntr">
                {if $arr.to_sea_time < $smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}
                    公海客户
                {else}
                    <a href="javascript:void(0);" onclick="UserDetial({$arr.user_id})">{$arr.user_info}</a></div></td>
                {/if}
                
        <td>
            <div class="ui_table_tdcntr">
                <li><a m="CustomerInfo" ispurview="true" v="16" onclick="JumpPage('{au d="CM" c="CMInfo" a="showModifyFront"}&customer_id={$arr.customer_id}')" href="javascript:;">编辑</a></li>
            </div>
        </td>
    </tr>
{/foreach}