<div class="DContInner setPWDComfireCont">
<form id="J_newAccount" class="newAccountForm" name="newtAccountForm" action="">
{foreach from=$arrayData item=data key=index}
	<div class="bd" style="padding-bottom:0;">
    <div class="tf">
      <label>交易号：</label>
      <div class="inp">
      {$data.source_bill_no}
      </div>
    </div>
    <div class="tf">
      <label>充值类型：</label>
      <div class="inp">
      {$data.data_type}
      </div>
    </div>
    <div class="tf">
      <label>充值金额：</label>
      <div class="inp">
      {$data.act_money}
      </div>
    </div>
    <div class="tf">
      <label>充值操作时间：</label>
      <div class="inp">
      {$data.act_date}
      </div>
    </div> 
    <div class="tf">
      <label>备注：</label>
      <div class="inp">
      {$data.remark}
      </div>
    </div>    
    </div>
{/foreach}
	<div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关  闭</a></div>
	</div>
</form>
</div>