    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商用户管理<span>&gt;</span>账号开通</div>
    <!--E crumbs-->
    <!--S form_edit-->
	<div class="form_edit">
    	<div class="form_hd">
            	<div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>编辑账号</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
		</div>
        <div class="form_bd">
            <form id="J_openAccount">
            <div class="bd">
                <div class="tf">
                <label><em class="require">*</em>账号名：</label>
                <div class="inp"><input class="accountName" type="text" name="accountName"  valid="required accountName2" value="" tabindex="1"/></div>
                <span class="info">3-32个字符，允许英文、数子、下划线</span>
                <span class="ok">&nbsp;</span><span class="err">3-32个字符，允许英文、数子、下划线</span>
                </div>                 
                <div class="tf">
                <label><em class="require">*</em>状态：</label>
                <div class="inp">
                    <div class="ui_comboBox">
                    <select name="state" tabindex="2">
                        <option value="1">正常</option>
                        <option value="0">关闭</option>                		
                    </select>
                    </div>
                </div>
                </div>       
                <div class="tf">
                <label><em class="require">*</em>所属公司：</label>
                <div class="inp">
                    <input class="companyName" type="text" name="companyName"  valid="required companyName" tabindex="3" value="{$arrAgentInfo.agent_name}" readonly />
                    <input type="hidden" value="{$arrAgentInfo.agent_id}" name="agentID">
                </div>
                <span class="info">请输入公司名称</span>
                <span class="ok">&nbsp;</span><span class="err">请输入公司名称</span>
                </div>
                <div class="tf">
                <label><em class="require">*</em>联系人：</label>
                <div class="inp"><input class="contactName" type="text" name="contactName" tabindex="6" valid="required LegalPersonName" value="{$arrAgentInfo.charge_person}" /></div>
                <span class="info">请输入联系人</span>
                <span class="ok">&nbsp;</span><span class="err">请输入联系人</span>
                </div>
                <div class="tf">
                <label><em class="require">*</em>手机号：</label>
                <div class="inp"><input class="mPhone" type="text" name="mPhone"   valid="mPhone" tabindex="4" value="{$arrAgentInfo.charge_phone}"/></div>
                <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
                <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
                </div>
                <div class="tf">
                <label>固定电话：</label>
                <div class="inp"><input class="fPhone" type="text" name="fPhone"   valid="fPhone" tabindex="5" value="{$arrAgentInfo.charge_tel}" /></div>
                <span class="info">手机号或固定电话必须输入一项&nbsp;&nbsp;固话格式:0571-8888888</span>
                <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号&nbsp;&nbsp;格式:0571-8888888</span>
                </div>
                <div class="tf tf_submit">
                	<label>&nbsp;</label>
                    <div class="inp">   
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack()">取消</a> </div>
                    </div>  
                </div>
            </div>
            </form>
		</div>
    </div>
    <!--E form_edit-->                 
{literal}
    <script type="text/javascript">
new Reg.vf($('#J_openAccount'),{callback:function(data){
	if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
	if(!IM.IsSending(true)){return false;};
	$.ajax({
    {/literal}url:'{au d=Agent c=AgentMove a=addAccount}',{literal}
	    data:$('#J_openAccount').serialize(),
	    type:"post",
	    success:function(data){
		IM.IsSending(false);
		if(data==-1){
		    IM.tip.warn("此账户名已经存在");
		    
		}
		else if(data==0){
		    IM.tip.warn("无法开通此账户");
		}
		else{
		    IM.tip.show("开通成功");
            PageBack();
		}
	    }					
	});
}});

    </script>
{/literal}
