<div class="DContInner">
    <div class="bd">                    	
        <!--<div class="tf">
            <label>产品：</label>
            <div class="inp">{$arrCashDeposit.product_type_name}</div>
        </div>  -->                      
        <div class="tf">
            <label><em class="require">*</em>金额：</label>
            <div class="inp"><b class="amountStyle">￥{$arrCashDeposit.fr_rev_money}</b></div>
        </div>
        <div class="tf">
            <label>打款底单：</label>
            <div class="inp"><a target="_blank" href="/{$arrCashDeposit.fr_rp_files}">{$arrCashDeposit.fr_rp_files}</a></div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>打款时间：</label>
            <div class="inp">{$arrCashDeposit.fr_peer_date}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>支付方式：</label>
            <div class="inp">
            {if $arrCashDeposit.fr_payment_id eq 1}
            现金
            {elseif $arrCashDeposit.fr_payment_id eq 7}
            网银支付
            {elseif $arrCashDeposit.fr_payment_id eq 8}
            银行汇款
            {elseif $arrCashDeposit.fr_payment_id eq 11}
            快钱
            {else}
            其他
            {/if}
            </div>
        </div>
        {if $arrCashDeposit.fr_payment_id eq 11}
        <div class="tf">
            <label><em class="require">*</em>交易号：</label>
            <div class="inp">{$arrCashDeposit.fr_rp_num}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>打款账户名称：</label>
            <div class="inp">{$arrCashDeposit.fr_peer_bank_name}</div>
        </div>
        {else}
        <div class="tf">
            <label><em class="require">*</em>打款账号：</label>
            <div class="inp">{$arrCashDeposit.bank_name}&nbsp;&nbsp;&nbsp;{$arrCashDeposit.account_name}&nbsp;&nbsp;&nbsp;{$arrCashDeposit.account_no}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>收款账户：</label>
            <div class="inp">{$arrCashDeposit.dept_name}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>收款银行：</label>
            <div class="inp">{$arrCashDeposit.ba_account_name}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>收款账号：</label>
            <div class="inp">{$arrCashDeposit.ba_account_no}</div>
        </div>
        {/if}
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
    </div>
</div>                
                
                        