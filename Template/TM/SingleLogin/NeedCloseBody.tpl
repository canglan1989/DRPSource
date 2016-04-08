{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="{$data.customer_id}">
            <div class="ui_table_tdcntr">{$data.customer_name}/{$data.customer_id}</div>
        </td>
        <td title="{$data.product_type_name}">
            <div class="ui_table_tdcntr">{$data.product_type_name}</div>
        </td>
        <td title="{$data.login_name}">
            <div class="ui_table_tdcntr">{$data.login_name}</div>
        </td>
        <td title="{$data.effect_sdate|date_format:"%Y-%m-%d"}至{$data.effect_edate|date_format:"%Y-%m-%d"}">
            <div class="ui_table_tdcntr">
                {$data.effect_sdate|date_format:"%Y-%m-%d"}至{$data.effect_edate|date_format:"%Y-%m-%d"}</div>
        </td>
        <td title="{$data.account_close_time|date_format:"%Y-%m-%d"}">
            <div class="ui_table_tdcntr">
                {if $data.account_close_time == '0000-00-00 00:00:00'}
                    未设置
                 {else}
                {$data.account_close_time|date_format:"%Y-%m-%d"}
                {/if}
                </div>
        </td>
        <td title="{$data.account_close_user_name}">
            <div class="ui_table_tdcntr">
                {$data.account_close_user_name}
            </div>
        </td>
        <td title="{$data.account_close_time|date_format:"%Y-%m-%d"}">
            <div class="ui_table_tdcntr">
                {if $data.login_state == 1}正常{else}关闭{/if}
                </div>
        </td>
<!--        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    {if $data.login_state == 1}<li><a m="NeedClostAccount" v="4" ispurview="true" href="javascript:;" onclick="CloseAccount({$data.aid})">
                            关闭账号</a></li>{/if}
                </ul>
            </div>
        </td>-->
    </tr>
{/foreach}