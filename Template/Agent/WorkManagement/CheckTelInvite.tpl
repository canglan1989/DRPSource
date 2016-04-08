<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}<span>&gt;</span>{if $IsVisit == 1}电话任务审核{else}拜访预约审核{/if}</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{if $IsVisit == 1}电话任务设置{else}拜访预约设置{/if}</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_TelInviteCheck" name="J_TelInviteCheck">	
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <div class="tf">
                    <label>代理商名称：</label>
                    <div class="inp">{$AgentName}</div>
                    </div>
                    <div class="tf ">
                        <label>网盟意向等级：</label>
                        <div class="inp">{if empty($IntertionRating)}未指定意向等级{else}{$IntertionRating}{/if}</div>
                    </div>
                    
                    <div class="tf">
                        <label>被访人：</label>
                        <div class="inp">{$ModelInfo->strVisitor}</div>
                    </div>
                    <div class="tf tf2">
                        <label>固定电话：</label>
                        <div class="inp">{$ModelInfo->strTel}</div>
                    </div>
                    <div class="tf tf2">
                        <label>手机：</label>
                        <div class="inp">{$ModelInfo->strMobile}</div>
                    </div>
                    <div class="tf">
                        <label>计划联系日期：</label>
                        <div class="inp">{$ModelInfo->strSappointTime|date_format:'%Y-%m-%d'}</div>
                    </div>
                    <div class="tf">
                        <label>联系切入点：</label>
                        <div class="inp">{$ModelInfo->strTitle}</div>
                    </div>
                    <div class="tf">
                        <label>审核状态：</label>
                        <div class="inp">
                            <select name="checkstatus" id="checkstatus">
                                <option value="1">审核通过</option>
                                <option value="2">审核不通过</option>
                            </select>
                        </div>
                    </div>
                    <div class="tf">
                        <label>备注：</label>
                        <div class="inp">
                            <textarea name="remark" cols="40" tabindex="5" ></textarea>
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
    var AppointId = '{$ModelInfo->iAppointId}';
    {literal}
//验证代理商数据
new Reg.vf($('#J_TelInviteCheck'),{
        callback:function(data){
	 	if(!IM.IsSending(true)){return false;};
        $.ajax({
                type:'POST',
                data:$('#J_TelInviteCheck').serialize(),
                url:'/?d=WorkM&c=TelWork&a=CheckTelInvite&appid='+AppointId,
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