<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">              
        <div class="tf">
        	<label>帐户余额：</label>
            <div class="inp">
                网盟预存款：{$iPreDepositsAccountMoney}  返点：{$iSaleAccountMoney} 
            </div>
        </div>               
        <div class="tf">
        	<label><em class="require">*</em>转款帐号：</label>
            <div class="inp">
                <input type="text" id="tbxCustomerUser" name="tbxCustomerUser" style="width:200px" value="" autocomplete="off"/>
            </div>
            <span class="info">请选择转款帐户</span>
            <span class="err">请选择转款帐户</span>
        </div>             
        <div class="tf">
        	<label>           
            <em class="require">*</em>转款金额：</label>
            <div class="inp">
                <input name="tbxActMoney" type="text" id="tbxActMoney" onkeyup='FloatNumber(this);CalculatePreReMoney()' value="0" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
            </div>
            <span class="info">请输入转款金额</span>
            <span class="err">请输入转款金额</span>
        </div> 
        <div class="tf">
        	<label>帐户扣款：</label>
            <div class="inp">
                网盟预存款：<span id="spanPreMoney">0</span>  返点：<span id="spanReMoney">0</span>  
            </div>
        </div>
        <div class="tf">                                    
            <label>备 注：</label>                             
            <div class="inp"><textarea name="tbxRemark" id="tbxRemark" cols="40" style="width:320px;height:80px"></textarea></div>
            <span class="info">请输入备注</span><span class="ok">&nbsp;</span><span class="err">限制100字以内</span>                 
        </div>                                                                                 
    </div>                                                                                      
    <div class="ft">                                                                             
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>                      
    </div>                                                                                                                              
</form>                                                                                                                                  
</div>