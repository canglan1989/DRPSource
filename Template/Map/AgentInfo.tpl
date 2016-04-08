<div class="DContInner">
    <div class="list_table_head">
        <div class="list_table_head_right">
            <div class="list_table_head_mid">
                <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>代理商信息</h4>
            </div>
        </div>
    </div>
    <div class="list_table_main">
        <div class="ui_table ui_table_nohead" id="J_ui_table">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
               <tbody class="ui_table_bd">
                    <tr class="">
                        <td class="even"><div class="ui_table_tdcntr">公司名称</div></td>
                        <td><div class="ui_table_tdcntr">{$data->strAgentName}</div></td>
                        <td class="even"><div class="ui_table_tdcntr">代理区域</div></td>
                        <td><div class="ui_table_tdcntr">{$data->strArea}</div></td>
                    </tr>
                    <tr class="">
                        <td class="even"><div class="ui_table_tdcntr">代理产品</div></td>
                        <td><div class="ui_table_tdcntr">{$data->strProductName}</div></td>
                        <td class="even"><div class="ui_table_tdcntr">代理截止时间</div></td>
                        <td><div class="ui_table_tdcntr">{$data->strDeadline}</div></td>
                    </tr>
                    <tr class="">
                        <td class="even"><div class="ui_table_tdcntr">保证金</div></td>
                        <td><div class="ui_table_tdcntr">{$data->iEnsureMoney}</div></td>
                        <td class="even"><div class="ui_table_tdcntr">预存款</div></td>
                        <td><div class="ui_table_tdcntr">{$data->iDeposits}</div></td>
                    </tr>
                    <tr class="">
                        <td class="even"><div class="ui_table_tdcntr">签单人员</div></td>
                        <td><div class="ui_table_tdcntr">{$data->strSignName}</div></td>
                        <td class="even"><div class="ui_table_tdcntr">到账情况</div></td>
                        <td><div class="ui_table_tdcntr">{$data->strStatus}</div></td>
                    </tr>
                </tbody>
           </table>
        </div>
    </div>
</div>