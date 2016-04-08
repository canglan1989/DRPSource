<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">   
		<div class="tf">
        	<label>代理商名称：</label>
            <div class="inp">{$strAgentName}</div>
        </div>       
        <div class="tf">
        	<label>账户：</label>
            <div class="inp">{$strAccountTypeText}</div>
        </div>      
        <div class="tf">
        	<label>产品：</label>
            <div class="inp">{$strProductTypeName}</div>
        </div>            
        <div class="tf">
        	<label><input value="{$objQuarterlyTaskInfo->iSaleAwardMoney}" id="tbxSaleAwardMoney" name="tbxSaleAwardMoney" type="hidden"/>销奖金额：</label>
            <div class="inp">
                {$objQuarterlyTaskInfo->iSaleAwardMoney}
            </div>
        </div>        
        <div class="tf">
        	<label>           
            <em class="require">*</em>充值金额：</label>
            <div class="inp">
                <input name="tbxActMoney" type="text" id="tbxActMoney" onkeyup='return FloatNumber(this)' value="{$objQuarterlyTaskInfo->iSaleAwardMoney}" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
            </div>
            <span class="info">请输入充值金额</span>
            <span class="err">请输入充值金额</span>
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