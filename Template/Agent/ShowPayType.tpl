{if $payType eq 7 || $payType eq 8 || $payType eq 15}
<div class="tf" style="margin:0">
	<label><em class="require">*</em>打款账号：</label>
</div>
<div class="tf" style="margin-left:20px;">
	<label>开户行：</label>
	<div class="inp"><input type="text"  valid="required" name="bankName" value="{$arrCashDeposit.bank_name}"/></div>
	<span class="info">请输入开户行</span>
	<span class="ok">&nbsp;</span><span class="err">请输入开户行</span>
</div>
<div class="tf" style="margin-left:20px;">
	<label>开户名：</label>
	<div class="inp"><input type="text"  valid="required" name="AccountName" value="{$arrCashDeposit.account_name}"/></div>
	<span class="info">请输入开户名</span>
	<span class="ok">&nbsp;</span><span class="err">请输入开户名</span>
</div>
<div class="tf" style="margin-left:20px;">
	<label>帐 号：</label>
	<div class="inp"><input type="text"  valid="required" name="AccountNo" value="{$arrCashDeposit.account_no}"/></div>
	<span class="info">请输入帐号</span>
	<span class="ok">&nbsp;</span><span class="err">请输入帐号</span>
</div>
<div class="tf">
	<label><em class="require">*</em>收款账户：</label>
	<div class="inp">
		<select id="payAccount" name="payAccount" valid="required payAccount">
	              	<option value="-100">请选择</option>
	                {foreach item=bank from=$arrayAccount}
	                <option {if $bank.ba_account_id eq $arrCashDeposit.fr_bank_id} selected="selected" {/if} value="{$bank.ba_account_id}@{$bank.ba_account_name}@{$bank.ba_account_no}">{$bank.ba_account_name}&nbsp;&nbsp;&nbsp;&nbsp;{$bank.ba_account_no}</option>
	                {/foreach}
	      	</select>
	</div>
	<span class="info">请选择收款账户</span>
	<span class="ok">&nbsp;</span><span class="err">请选择收款账户</span>
</div>
{elseif $payType eq 11}
<div class="tf">
  <label><em class="require">*</em>交易号：</label>
  <div class="inp"><input type="text"  valid="required" name="trans_code" value="{$arrCashDeposit.fr_rp_num}"/></div>
  <span class="info">请输入交易号</span>                                                            
  <span class="err">请输入交易号</span>                                                              
</div>                                                                                              
<div class="tf">                                                                                     
      <label><em class="require">*</em>打款账户名称：</label>                                                
      <div class="inp"><input type="text"  valid="required" name="payAccountName" value="{$arrCashDeposit.fr_peer_bank_name}"/></div> 
      <span class="info">如果为签约代理商对公账户支付，请完整填写代理商企业名称，如果非签约代理商对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写签约代理商的企业名称。</span>                                                               
      <span class="err">如果为签约代理商对公账户支付，请完整填写代理商企业名称，如果非签约代理商对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写签约代理商的企业名称。</span>                                                                 
</div>
{/if}