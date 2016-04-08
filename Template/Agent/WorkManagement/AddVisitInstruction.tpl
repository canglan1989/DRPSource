<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}<span>&gt;</span>批示</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_AddTelVerfity" name="J_AddTelVerfity">	
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <div class="list_table_main marginBottom10 agentInfoToggle">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd"><div class="ui_table_hd_inner">
                                <h4 class="title">拜访小记信息</h4>
                            </div></div>
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
                                    <td class="even"><div class="ui_table_tdcntr">拜访类型</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strCreateTime}</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">联系方式</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strTel}/{$NoteInfo->strMobile}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">拜访计划</div></td>
                                    <td><div class="ui_table_tdcntr"></div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">操作人</div></td>
                                    <td><div class="ui_table_tdcntr">{$UserName}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">拜访内容</div></td>
                                    <td><div class="ui_table_tdcntr"></div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">操作时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strCreateTime}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">预计到账信息</div></td>
                                    <td><div class="ui_table_tdcntr">
                                           预计到账金额：<b class="amountStyle">{$NoteInfo->iExpectMoney} 元</b>; 
                                           预计到账类型：<b class="amountStyle">{$NoteInfo->strExpectTypeCN}</b>; 
                                           预计到账时间：<b class="amountStyle">{$NoteInfo->strExpectTime|date_format:"%Y-%m-%d"}</b>; 
                                           预计达成率：<b class="amountStyle">{$NoteInfo->iChargePercentage}%</b>;
                                        </div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">拜访时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strVisitTimestart|date_format:"%Y-%m-%d %H:%M"} ~ {$NoteInfo->strVisitTimeend|date_format:"%H:%M"}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">下次拜访时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strFollowUpTime|date_format:'%Y-%m-%d'}</div></td>
                                </tr>
                            </tbody>
                        </table>   
                    </div>
                </div>
                                <div class="list_table_main marginBottom10 agentInfoToggle">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd"><div class="ui_table_hd_inner">
                                <h4 class="title">拜访小记质检信息</h4>
                            </div></div>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody class="ui_table_bd">
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">质检位置</div></td>
                                    <td width="300"><div class="ui_table_tdcntr"><a target="_blank" href="http://{$VertifyInfo.record_no}">{$VertifyInfo.record_no}</a></div></td>
                                    <td class="even"><div class="ui_table_tdcntr">质检结果</div></td>
                                    <td><div class="ui_table_tdcntr">
                                        {if $VertifyInfo.verfity_status == 1}
                                            通过
                                            {else}
                                                不通过
                                                {/if}
                                        </div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">质检操作时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$VertifyInfo.create_time}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">质检人</div></td>
                                    <td><div class="ui_table_tdcntr">{$VertifyInfo.create_user_name}</div></td>
                                </tr>
                                <tr class="">
                                   <td class="even"><div class="ui_table_tdcntr">质检情况</div></td>
                                    <td colspan="3"><div class="ui_table_tdcntr">{$VertifyInfo.vertify_remark}</div></td>
                                </tr>
                            </tbody>
                        </table>   
                    </div>
                </div>
                <div class="tf ">
                    <label><em class="require">*</em>请批示：</label>
                    <div class="inp">
                        <textarea name="vertify_instruction" cols="50" rows="30"></textarea>
                    </div>
                    
                </div>
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">   
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
                    </div>
                </div>
            </div>
            <!--E form_block_bd--> 
        </form>
    </div>
    <!--E form_bd--> 
</div>
<!--E form_edit-->
<script type="text/javascript">
    {literal}
//验证代理商数据
new Reg.vf($('#J_AddTelVerfity'),{
        callback:function(data){
	 	if(!IM.IsSending(true)){return false;};
        $.ajax({
                type:'POST',
    {/literal}
                data:$('#J_AddTelVerfity').serialize()+"&vertifyid={$VertifyInfo.vertify_id}&noteId={$NoteInfo->iId}",
                url:'{au d="WorkM" c="VisitVerify" a="AddVisitInstruction"}',
    {literal}
		dataType:'json',
                success:function(data)
                {
					IM.IsSending(false);
					if(data.success)
					{
						IM.tip.show(data.msg);
						PageBack();
					}
					else
					{
						IM.tip.warn(data.msg);
					}
                }
            });
}});

    {/literal}
</script>