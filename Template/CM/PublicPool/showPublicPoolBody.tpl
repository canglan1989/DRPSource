{foreach from=$arrayData item=arr}
    <tr class="">
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}<input type="checkbox" value="{$arr.customer_id}" name="listid" class="checkInp">{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{$arr.customer_id}{/if}</div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{if $arr.customer_state < 1}<a href="javascript:void(0);"onclick="JumpPage('/?d=CM&c=CMInfo&a=showCustomerDetail&customer_id={$arr.customer_id}')">{$arr.customer_name}</a>{else}<span  style="color:grey;">{$arr.customer_name}</span>{/if}</div></td>      
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{$arr.industry_name}{/if}</div></td>                               
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{$arr.area_name}{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{$arr.customer_resource_cn}{/if}</div></td>                                    
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{$arr.create_time}{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}<a href="javascript:void(0);" onclick="JumpPage('{au d="CM" c="ContactRecord" a="ContactRecordList"}&customerID={$arr.customer_id}')">{$arr.record_count}</a>{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{if $arr.last_record_time == '0000-00-00 00:00:00'}还未联系{else}{$arr.last_record_time}{/if}{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{if $arr.last_to_sea_time == '0000-00-00 00:00:00'}未有踢入公海操作{else}{$arr.last_to_sea_time}{/if}{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_state < 1}{$arr.buy_product_name}{/if}</div></td>
        <td>
            <div class="ui_table_tdcntr">
                {if $arr.customer_state < 2}
                <li><a m="PublicPoolManager" ispurview="true" v="8" onclick="DefendCustomer({$arr.customer_id})" href="javascript:;">拉取</a></li>
                {/if}
            </div>
        </td>
    </tr>
{/foreach}