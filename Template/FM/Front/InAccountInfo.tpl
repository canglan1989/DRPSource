<div class="DContInner setPWDComfireCont">
<form id="J_newAccount" class="newAccountForm" name="newtAccountForm" action="">
	<div class="bd" style="padding-bottom:0;">
    <div class="tf">
      <label>充值金额：</label>
      <div class="inp">
      {$objReceivablePayInfo->iIncomeMoney}
      </div>
    </div>
    <div class="tf">
      <label>充值操作时间：</label>
      <div class="inp">
      {$objReceivablePayInfo->strIncomeTime}
      </div>
    </div> 
    <div class="tf">
      <label>备注：</label>
      <div class="inp">
      {$objReceivablePayInfo->strIncomeRemark}
      </div>
    </div>    
    </div>
	<div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关  闭</a></div>
	</div>
</form>
</div>