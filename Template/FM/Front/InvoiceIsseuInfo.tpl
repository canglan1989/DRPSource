<div class="DContInner setPWDComfireCont">
<form id="J_newAccount" class="newAccountForm" name="newtAccountForm" action="">
	<div class="bd" style="padding-bottom:0;">
    <div class="tf">
      <label>收据号：</label>
      <div class="inp">
      {$objInvoiceBillInfo->strInvoiceNo}
      </div>
    </div>
    <div class="tf">
      <label>收据金额：</label>
      <div class="inp">
      <b class="amountStyle">{$objInvoiceBillInfo->iInvoiceMoney}</b>
      </div>
    </div>
    <div class="tf">
      <label>开据时间：</label>
      <div class="inp">
      {$objInvoiceBillInfo->strOpenTime}
      </div>
    </div>
    <div class="tf">
      <label>确认人：</label>
      <div class="inp">
      {if $objInvoiceBillInfo->iReceiptState >0}
      {$objInvoiceBillInfo->strReceiptUserName}
      {else}
      --
      {/if}
      </div>
    </div>
    <div class="tf">
      <label>确认时间：</label>
      <div class="inp">
      {if $objInvoiceBillInfo->iReceiptState >0}
      {$objInvoiceBillInfo->strReceiptTime}
      {else}
      --
      {/if}
      </div>
    </div>    
    </div>
	<div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关  闭</a></div>
	</div>
</form>
</div>