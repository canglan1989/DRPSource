{foreach from=$arrayData item=arr}
    <tr class="">
        <td title=""><div class="ui_table_tdcntr"><input type="checkbox" value="{$arr.customer_id}" name="listid" class="checkInp"></div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.customer_id}</div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$arr.customer_id}','客户基本信息',700);">{$arr.customer_name}</a></div></td>      
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{$arr.industry_fullname}</div></td>                               
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{$arr.area_fullname}</div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.create_time}</div></td>                                    
        <td title=""><div class="ui_table_tdcntr">{if $arr.customer_resource eq 3}自动注册{else}厂商推荐{/if}</div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.intention_name}</div></td>
        <td>
            <div class="ui_table_tdcntr">
                <li><a onclick="IM.account.delOper('{au d=CM c=CMInfo a=delFrontClient1}',{literal}{}{/literal},'删除客户',this)" href="javascript:;">删除</a></li>
            </div>
        </td>
    </tr>
{/foreach}