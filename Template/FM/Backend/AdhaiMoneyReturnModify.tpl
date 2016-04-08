<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">   
		<div class="tf">
        	<label>代理商名称：</label>
            <div class="inp"><input type="hidden" id="tbxAgentID" name="tbxAgentID" value="{$agentID}"/>
            {$agentName}
            </div>
            <span class="c_info">请仔细核对网盟账号</span>
            <span class="err">请仔细核对网盟账号</span>
        </div>       
        <div class="tf">
        	<label><em class="require">*</em>退款帐号：</label>
            <div class="inp">
                <input type="text" id="tbxCustomerUser" name="tbxCustomerUser" style="width:200px" value="" autocomplete="off"/>
            </div>
            <span class="c_info">请选择退款帐户</span>
            <span class="err">请选择退款帐户</span>
        </div> 
        <div class="tf">
        	<label>可退金额：</label>
            <div id="divCanReturnMoney" class="inp">0</div>
        </div>
        <div style="display:none" class="tf">
        	<label>  
            <input type="hidden" id="tbxPreRate" name="tbxPreRate" value="1"/>
            <input type="hidden" id="tbxReRate" name="tbxReRate" value="0"/>     
            <em class="require">*</em>退款金额：</label>
            <div class="inp">
                <input name="tbxActMoney" type="text" id="tbxActMoney" onkeyup='return FloatNumber(this)' onblur="CalculateReturnMoney(this)" 
                value="0" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
            </div>
            <span class="info">请输入退款金额</span>
            <span class="err">请输入退款金额</span>
        </div>  
        <div class="tf">
        	<label>退入帐户：</label>
            <div class="inp">
            预存款：<span id="spanPre">0</span>     &nbsp;&nbsp;返点：<span id="spanRePre">0</span>  
            </div>
        </div>      
        <div class="tf">
            <label>备 注：</label>                             
            <div class="inp"><textarea name="tbxRemark" id="tbxRemark" cols="40" style="width:320px;height:80px" ></textarea></div>
            <span class="c_info">限200字内</span><span class="ok">&nbsp;</span><span class="err">限200字以内</span>                 
        </div>                                                                                 
    </div>                                                                                      
    <div class="ft">                                                                             
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>                      
    </div>                                                                                                                              
</form>                                                                                                                                  
</div>