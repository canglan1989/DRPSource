<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">
    {if $iIsAgentUser == 1}
		<div class="tf">
        	<label>财务帐户名：</label>
            <div class="inp">{$strFinanceUserName}</div>
        </div>
    {else}
		<div class="tf">
        	<label>代理商名称：</label>
            <div class="inp">{$strAgentName}</div>
        </div>
    {/if}
        <div class="tf">
            <input type="hidden" id="tbxFinanceUid" name="tbxFinanceUid" value="{$iFinanceUid}"/>
            <input type="hidden" id="tbxAgentID" name="tbxAgentID" value="{$agentID}"/>
            <input type="hidden" id="tbxAccountType" name="tbxAccountType" value="{$accountType}"/>
            <input type="hidden" id="tbxProductTypeID" name="tbxProductTypeID" value="{$productTypeID}"/> 
            <input type="hidden" value="{$bIsUnitPreDeposits}" name="IsUnitPreDeposits" id="IsUnitPreDeposits"/> 
        	<label>转出账户：</label>
            <div class="inp">{$strProductTypeName}{$strAccountTypeText}</div>
        </div>
        {if $bIsUnitPreDeposits == 1}     
        <div class="tf">
        	<label>可用余额：</label>
            <div class="inp">预存款：{$canUseMoneyText}     &nbsp;&nbsp;返点：{$iUnitSaleRewardMoneyText}</div>
        </div> 
        {else}
        <div class="tf">
        	<label>可用余额：</label>
            <div class="inp">{$canUseMoneyText}</div>
        </div> 
        {/if}    
        <div class="tf">
        	<label><em class="require">*</em>转入帐户：</label>
            <div class="inp"><select name="cbAccountProductType" id="cbAccountProductType" onchange="ShowReMoney(this)">
            <option value="">请选择</option>
            {foreach from=$arrayAgentAccount item=data key=index}
            <option value="{$data.account_type},{$data.product_type_id}">{$data.account_type_text}</option>
            {/foreach}
            </select>
            </div>
        </div>      
        <div class="tf">
        	<label>          
            <em class="require">*</em>转款金额：</label>
            <div class="inp">
                <input name="tbxActMoney" type="text" id="tbxActMoney" onkeyup='return FloatNumber(this)' onblur="CalculateReMoney()" value="0" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/> 
                {if $bIsUnitPreDeposits == 1}     &nbsp;取消返点：<input id="tSaleRewardMoney" value="0" readonly="readonly" disabled="disabled" style="width:80px;text-align:right;"/>{/if}
            </div>
            <span class="info">请输入金额{if $bIsUnitPreDeposits == 1}(返点不到转入帐户){/if}</span>
            <span class="err">请输入金额</span>
        </div>
        <div id="divReMoney" style="display:none" class="tf">
        	<label>返点：</label>
            <div id="divReMoneyValue" class="inp">
            {$reMoney}
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