<div class="DContInner setPWDComfireCont">
	<form id="J_editYuChunKuanInfoForm" action="" name="editYuChunKuanInfoForm">
    <div style="text-align:center" class="table_attention"><label>请您核对收到的发票信息，内容如下</label></div> 
	<div class="bd">        
        <div class="tf">
          <label>发票号：</label>
          <div class="inp">
          {$objInvoiceInfo->strInvoiceNo}
          </div>
        </div>        
        <div class="tf">
          <label>发票金额：</label>
          <div class="inp">
          {$objInvoiceInfo->iInvoiceMoney}
          </div>
        </div>         
        <div class="tf">
          <label>开票时间：</label>
          <div class="inp">
          {$objInvoiceInfo->strOpenTime}
          </div>
        </div>                 
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
        <div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" onclick="IM.dialog.ok(false)">否</button></div>
        <div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" onclick="IM.dialog.ok(true)">是</button></div>
    </div>
    </form>
</div> 