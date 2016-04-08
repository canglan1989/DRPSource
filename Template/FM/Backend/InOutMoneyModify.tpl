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
        	<label>可用余额：</label>
        {if $bIsPre == 1}
            <div class="inp">预存款：{$canUseMoneyText}&nbsp;&nbsp;&nbsp; {if $bIsUnit == 1}返点：{else}销奖：{/if}{$canRewardUseMoneyText}</div>  
        {else}
            <div class="inp">{$canUseMoneyText}</div>   
        {/if}
        </div>  
        <div class="tf">
        	<label><em class="require">*</em>收支类型：</label>
            <div class="inp">
            <input type="hidden" id="tbxAgentID" name="tbxAgentID" value="{$agentID}"/>
            <input type="hidden" id="tbxAccountType" name="tbxAccountType" value="{$accountType}"/>
            <input type="hidden" id="tbxProductTypeID" name="tbxProductTypeID" value="{$productTypeID}"/>  
            <select name="cbInOutType" id="cbInOutType">
            <option value="-100">请选择</option>
            {$strDataTypeHTML}
            </select>
            </div>
        </div>       
        <div class="tf">
        	<label>          
            <em class="require">*</em>金额：</label>
            <div class="inp">
             {if $bIsPre == 1}<div class="inp">预存款：<input name="tbxActMoney" type="text" id="tbxActMoney" onkeyup='return FloatNumber(this)' value="0" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>&nbsp;&nbsp;&nbsp; 
                {if $bIsUnit == 1}返点：{else}销奖：{/if}<input name="tbxRewardActMoney" type="text" id="tbxRewardActMoney" onkeyup='return FloatNumber(this)' value="0" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/></div>  
            {else}
                <input name="tbxActMoney" type="text" id="tbxActMoney" onkeyup='return FloatNumber(this)' value="0" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
            {/if}
            </div>
            <span class="info">请输入金额</span>
            <span class="err">请输入金额</span>
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