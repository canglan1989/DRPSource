<div class="DContInner setPWDComfireCont">
<form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
  <div class="bd">
    <div class="tf">
      <label> <em class="require">*</em> 开户行： </label>
      <div class="inp">
        <input id="tbxBankName" class="ac_input" type="text" tabindex="1" maxlength="18" valid="required tbxProductNo" 
        name="tbxBankName" style="float:left; width:200px;" value="{$objBankAccountInfo->strBankName}" />
      </div>
      <span class="info">请输入开户行</span> <span class="ok">&nbsp;</span><span class="err">请输入开户行</span> 
      </div>  
    <div class="tf">
      <label> <em class="require">*</em> 账户名： </label>
      <div class="inp">
        <input id="tbxAccountName" class="ac_input" type="text" tabindex="1" maxlength="20" valid="required tbxProductNo" 
        name="tbxAccountName" style="float:left; width:200px;" value="{$objBankAccountInfo->strAccountName}" />
      </div>
      <span class="info">请输入账户名</span> <span class="ok">&nbsp;</span><span class="err">请输入账户名</span> 
      </div>
     <div class="tf">
      <label> <em class="require">*</em> 账号： </label>
      <div class="inp">
        <input id="tbxAccountNo" class="ac_input" type="text" tabindex="1" maxlength="25" valid="required tbxProductSeries" 
        name="tbxAccountNo" style="float:left; width:200px;" value="{$objBankAccountInfo->strAccountNo}" />
      </div>
      <span class="info">请输入账号</span> <span class="ok">&nbsp;</span><span class="err">请输入账号</span> </div> 
  </div>
  <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>
	</div>
</form>
</div>