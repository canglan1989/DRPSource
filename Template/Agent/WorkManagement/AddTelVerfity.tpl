<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>电话任务设置</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_AddTelVerfity" name="J_AddTelVerfity">	
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <div class="table_attention marginBottom10"><label class="attention">提示：</label>前几次已通过的考核项不能取消，标有星号(“<em class="require">*</em>”)的为B+必要条件。</div>
                <div class="tf">
                    <label>代理商名称：</label>
                    <div class="inp"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id={$AgentInfo->iAgentId}')">{$AgentInfo->strAgentName}</a></div>
                </div>
                <div>
                    <div class="form_block_left">
                        {foreach from=$VertifyListItemLeft item=data}
                            <div class="tf">
                                <label>{if $data.check_b == 1}<em class="require">*</em>{/if}{$data.item_name}：</label>
                                <div class="inp">
                                <input type="checkbox" {if $data.checked == 1} onclick="return false;" checked {/if} class="checkInp" name="item[{$data.item_id}]" value="{$data.item_name}" />{$data.item_result}
                                </div>
                            </div>
                        {/foreach}
                    </div>
                    <div class="form_block_right">
                        {foreach from=$VertifyListItemRight item=data}
                            <div class="tf">
                                <label>{if $data.check_b == 1}<em class="require">*</em>{/if}{$data.item_name}：</label>
                                <div class="inp">
                                    <input type="checkbox" {if $data.checked == 1} onclick="return false;" checked {/if} class="checkInp" name="item[{$data.item_id}]" value="{$data.item_name}" />{$data.item_result}
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
                <div class="tf ">
                    <label>录音编号：</label>
                    <div class="inp">
                        <input name="record_no" />
                    </div>
                </div>
                <div class="tf ">
                    <label>质检结果：</label>
                    <div class="inp">
                        <select name="vertify_status" >
                            <option value="1">通过</option>
                            <option value="0">不通过</option>
                        </select>
                    </div>
                </div>
                <div class="tf ">
                    <label>质检情况：</label>
                    <div class="inp">
                        <textarea name="vertify_remark" cols="50" rows="30"></textarea>
                    </div>
                </div>
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">   
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
                    </div>
                </div>

                <div class="list_table_main marginBottom10 agentInfoToggle">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd"><div class="ui_table_hd_inner">
                                <h4 class="title">联系小记信息</h4>
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
                                    <td class="even"><div class="ui_table_tdcntr">联系时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strVisitTimestart|date_format:"%Y-%m-%d %H:%M"}</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">联系方式</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strTel}/{$NoteInfo->strMobile}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">预计到账信息</div></td>
                                    <td><div class="ui_table_tdcntr">
                                           预计到账金额：<b class="amountStyle">{$NoteInfo->iExpectMoney} 元</b>; 
                                           预计到账类型：<b class="amountStyle">{$NoteInfo->strExpectTypeCN}</b>; 
                                           预计到账时间：<b class="amountStyle">{$NoteInfo->strExpectTime|date_format:"%Y-%m-%d"}</b>; 
                                           预计达成率：<b class="amountStyle">{$NoteInfo->iChargePercentage}%</b>;
                                        </div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">操作人</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strCreateUserName}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">行业动态</div></td>
                                    <td><div class="ui_table_tdcntr">{$AgentInfo->strDynamics}</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">操作时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strCreateTime}</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">下次联系时间</div></td>
                                    <td><div class="ui_table_tdcntr">{$NoteInfo->strFollowUpTime|date_format:'%Y-%m-%d'}</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">联系小记内容</div></td>
                                    <td colspan="3"><div class="ui_table_tdcntr">{$NoteInfo->strResult}</div></td>
                                </tr>
                            </tbody>
                        </table>   
                    </div>
                </div>

                <div class="list_table_head">
                    <div class="list_table_head_right">
                        <div class="list_table_head_mid">
                            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>电话质检操作记录</h4>
<!--                            <a onclick="IM.agent.addContactInfo('/?d=Agent&amp;c=Agent&amp;a=showAddContacter','添加联系人信息',362,'no')" href="javascript:;" class="ui_button ui_link"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系人</a>-->
                        </div>
                    </div>			           
                </div>

                <div id="ContacterInfo" class="list_table_main marginBottom10">
                    <div id="J_ui_table" class="ui_table">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <thead class="ui_table_hd">
                                <tr class="odd">                                        
                                    <th title="编号">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">编号</div>
                            </div>
                            </th>
                            <th title="联系小记编号">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">联系小记编号</div>
                            </div>
                            </th>
                            <th title="录音编号">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">录音编号</div>
                            </div>
                            </th>
                            <th title="本次质检操作通过的项">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">本次质检操作通过的项</div>
                            </div>
                            </th>
                            <th title="质检结果">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">质检结果</div>
                            </div>
                            </th>
                            <th title="质检评语">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">质检评语</div>
                            </div>
                            </th>
                            <th title="质检人">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">质检人</div>
                            </div>
                            </th>
                            <th title="质检操作时间">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">质检操作时间</div>
                            </div>
                            </th>
                            </tr>
                            </thead>
                            <tbody class="ui_table_bd">
                                {foreach from=$VertifyList item=data}
                                <tr class="">
                                    <td title="{$data.vertify_id}"><div class="ui_table_tdcntr">{$data.vertify_id}</div></td>
                                    <td title="{$data.note_id}"><div class="ui_table_tdcntr">{$data.note_id}</div></td>
                                    <td title="{$data.record_no}"><div class="ui_table_tdcntr">{$data.record_no}</div></td>
                                    <td title="{$data.new_item_name}"><div class="ui_table_tdcntr">{$data.new_item_name}</div></td>
                                    <td title="{if $data.verfity_status == 0}不通过{else}通过{/if}"><div class="ui_table_tdcntr">{if $data.verfity_status == 0}不通过{else}通过{/if}</div></td>
                                    <td title="{$data.vertify_remark}"><div class="ui_table_tdcntr">{$data.vertify_remark}</div></td>
                                    <td title="{$data.create_user_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid});">{$data.create_user_name}</a></div></td>
                                    <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                                </tr>   
                                {foreachelse}
                                    <tr  class=""><td colspan="8">无历史数据</td></tr> 
                                {/foreach}
                            </tbody>
                        </table>   
                    </div>
                    <!--E ui_table-->
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
                data:$('#J_AddTelVerfity').serialize()+"&agentId={$AgentInfo->iAgentId}&noteId={$NoteInfo->iId}",
                url:'{au d="WorkM" c="VisitVerify" a="AddTelVerfity"}',
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