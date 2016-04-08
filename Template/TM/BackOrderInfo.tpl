{if !empty($BackInfo)}
<div class="list_table_main" style="margin-top: 15px;">
        <div class="ui_table ui_table_nohead">
            <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">退单信息</h4></div></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$BackInfo.agent_name}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">订单号</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$BackInfo.source_bill_no}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">款项状态</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$BackInfo.back_type}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">订单金额</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">预存款：{$BackInfo.freeze_predepositis_money} 销奖：{$BackInfo.freeze_salereward_money}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款金额</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">预存款：{$BackInfo.backed_predepositis_money} 销奖：{$BackInfo.backed_salereward_money}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款操作备注</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$BackInfo.remark}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款操作人</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$BackInfo.create_user}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款时间</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$BackInfo.create_time}</div></td>
                </tr>
            </table> 
        </div>
    </div>
{/if}