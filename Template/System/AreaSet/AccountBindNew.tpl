<div class="DContInner">
<form id="J_newAccount">
	<div class="bd">
    <div class="tf">
      <label>  账号组名称： </label>
      <div class="inp">{$account_name}<input type="hidden" id="account_group_id" name="account_group_id"  value="{$account_group_id}"/></div>
      </div>
    <div class="tf">
      <label> <em class="require">*</em> 账号/姓名： </label>
      <div class="inp">
        <input class="ac_input" type="text" tabindex="1" maxlength="18" valid="required accountName3" id="accountName" name="accountName" autocomplete="off"/>
        <input name="tbxEmpID" id="tbxEmpID" type="hidden" value="-100"/>
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