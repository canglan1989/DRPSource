<div class="DContInner tableFormCont">

    <div class="bd">
        <div class="list_table_main">
            <div class="ui_table ui_table_nohead">
                <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">电话小记信息</h4></div></div>
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody class="ui_table_bd">
                        <tr class="">
                            <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                            <td width="300"><div class="ui_table_tdcntr">{$AgentInfo->strAgentName}</div></td>
                            <td class="even"><div class="ui_table_tdcntr">
                            {if $AgentInfo->iAgentId == $AgentInfo->strAgentNo}意向等级{else}签约产品{/if}
                        </div></td>
                    <td><div class="ui_table_tdcntr">
                            {if $AgentInfo->iAgentId == $AgentInfo->strAgentNo}
                                {$NoteInfo->strAfterlevel}({$NoteInfo->strProductName})
                            {else}
                                {$NoteInfo->strProductName}
                            {/if}
                        </div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">被访人</div></td>
                    <td><div class="ui_table_tdcntr">{$NoteInfo->strVisitor}</div></td>
                    <td class="even"><div class="ui_table_tdcntr">联系时间</div></td>
                    <td><div class="ui_table_tdcntr">{$NoteInfo->strVisitTimestart|date_format:"%Y-%m-%d %H:%M"}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">联系方式</div></td>
                    <td><div class="ui_table_tdcntr">{$NoteInfo->strTel}/{$NoteInfo->strMobile}</div></td>
                    <td class="even"><div class="ui_table_tdcntr">下次联系时间</div></td>
                    <td><div class="ui_table_tdcntr">{$NoteInfo->strFollowUpTime|date_format:'%Y-%m-%d'}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">操作人</div></td>
                    <td><div class="ui_table_tdcntr">{$NoteInfo->strCreateUserName}</div></td>
                    <td class="even"><div class="ui_table_tdcntr">操作时间</div></td>
                    <td><div class="ui_table_tdcntr">{$NoteInfo->strCreateTime}</div></td>

                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">预计到账信息</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">
                        预计到账金额：<b class="amountStyle">{$NoteInfo->iExpectMoney} 元</b>; 
                            预计到账类型：<b class="amountStyle">{$NoteInfo->strExpectTypeCN}</b>; 
                            预计到账时间：<b class="amountStyle">{$NoteInfo->strExpectTime|date_format:"%Y-%m-%d"}</b>; 
                            预计达成率：<b class="amountStyle">{$NoteInfo->iChargePercentage}%</b>;
                        </div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">行业动态</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$AgentInfo->strDynamics}</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">联系小记内容</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">{$NoteInfo->strResult}</div></td>
                </tr>
            </tbody>
        </table>    
    </div>
</div>
</div>
<div class="ft">
    <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a>
    </div>
</div>
</div>