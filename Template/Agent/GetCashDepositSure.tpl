<div class="DContInner">
<form id="J_TiJiaoBaoZhengJin_submitForm" action="" name="TiJiaoBaoZhengJin_submitForm" class="TiJiaoBaoZhengJin_submitForm">
    <div class="table_attention"><label>请确认您提交的保证金信息</label></div>
    <div class="bd">
        <!--<div class="tf">
            <label>产品：</label>
            <div class="inp">{$arrAddCashDeposit.productName}</div>
        </div>-->                        
        <div class="tf">
            <label><em class="require">*</em>金额：</label>
            <div class="inp"><b class="amountStyle">￥{$arrAddCashDeposit.amount}</b></div>
        </div>
        <div class="tf">
            <label>打款底单：</label>
            <div class="inp"><a href="{$arrAddCashDeposit.permitJ_upload1}" target="_blank">{$arrAddCashDeposit.permitJ_upload1}</a></div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>打款时间：</label>
            <div class="inp">{$arrAddCashDeposit.registeredTime}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>支付方式：</label>
            <div class="inp">
            {if $arrAddCashDeposit.payment eq 1}
            现金
            {elseif $arrAddCashDeposit.payment eq 7}
            网银支付
            {elseif $arrAddCashDeposit.payment eq 8}
            银行汇款
            {elseif $arrAddCashDeposit.payment eq 11}
            快钱
            {else $arrAddCashDeposit.payment eq 15}
            其他
            {/if}
            </div>
        </div>
        {if $arrAddCashDeposit.payment eq 11}
        <div class="tf">
            <label><em class="require">*</em>交易号：</label>
            <div class="inp">{$arrAddCashDeposit.trans_code}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>打款帐户名称：</label>
            <div class="inp">{$arrAddCashDeposit.payAccountName}</div>
        </div>
        {else}
        <div class="tf">
            <label><em class="require">*</em>支付银行：</label>
            <div class="inp">{$arrAddCashDeposit.bankName}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>打款账号：</label>
            <div class="inp">{$arrAddCashDeposit.AccountNo}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>打款账户：</label>
            <div class="inp">{$arrAddCashDeposit.AccountName}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>收款账户：</label>
            <div class="inp">{$arrAddCashDeposit.ToBankName}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>收款账号：</label>
            <div class="inp">{$arrAddCashDeposit.ToBankNo}</div>
        </div>
        {/if}
    </div>
    <input type="hidden" id="fr_id" name="fr_id" value="{$arrAddCashDeposit.fr_id}" />
    <input type="hidden" id="agentId" name="agentId" value="{$arrAddCashDeposit.agentId}" />
    <input type="hidden" id="pactId" name="pactId" value="{$arrAddCashDeposit.pactId}" />
    <input type="hidden" id="productId" name="productId" value="{$arrAddCashDeposit.productId}" /> 
    <input type="hidden" id="productName" name="productName" value="{$arrAddCashDeposit.productName}" />
    <input type="hidden" id="amount" name="amount" value="{$arrAddCashDeposit.amount}" />
    <input type="hidden" id="picName" name="picName" value="{$arrAddCashDeposit.permitJ_upload1}" />
    <input type="hidden" id="payTime" name="payTime" value="{$arrAddCashDeposit.registeredTime}" />
    <input type="hidden" id="payMent" name="payMent" value="{$arrAddCashDeposit.payment}" />
    <input type="hidden" id="bankName" name="bankName" value="{$arrAddCashDeposit.bankName}" />
    <input type="hidden" id="AccountName" name="AccountName" value="{$arrAddCashDeposit.AccountName}" />
    <input type="hidden" id="AccountNo" name="AccountNo" value="{$arrAddCashDeposit.AccountNo}" />
    <input type="hidden" id="AcceBankName" name="AcceBankName" value="{$arrAddCashDeposit.ToBankName}" />
    <input type="hidden" id="AcceAccountNo" name="AcceAccountNo" value="{$arrAddCashDeposit.ToBankNo}" />
    <input type="hidden" id="AcceBankId" name="AcceBankId" value="{$arrAddCashDeposit.ToBankId}" />
    <input type="hidden" id="BllCode" name="BllCode" value="{$arrAddCashDeposit.trans_code}" />
    <input type="hidden" id="bllAccountNo" name="bllAccountNo" value="{$arrAddCashDeposit.payAccountName}" />
    <input type="hidden" id="remark" name="remark" value="{$arrAddCashDeposit.direction}" />
    <input type="hidden" id="trans_code" name="trans_code" value="{$arrAddCashDeposit.trans_code}" />
    <input type="hidden" id="payAccountName" name="payAccountName" value="{$arrAddCashDeposit.payAccountName}" />
    
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div>
        <div class="ui_button ui_button_confirm" onClick="IM.agent.TiJiaoBaoZhengJin('{au d=Agent c=AgentMove a=showAddCashDeposit}',{literal}{{/literal}'id':'{$pactId}'{literal}}{/literal},'提交保证金')"><a href="javascript:;" class="ui_button_inner">上一步</a></div>
    </div>
</form>
</div>                
                
                        