<div class="DContInner setPWDComfireCont">
<form id="J_Audit" class="newAuditForm" name="newAuditForm" action="">
  <div class="bd" style="padding-bottom:0;">
    <div class="tf">
      <label>审核备注：</label>
      <div class="inp">
        <textarea name="tbxAuditRemark" cols="50" id="tbxAuditRemark" onblur="ClearText(this,50)">同意</textarea>
        <span class="info">限制50字以内</span><span class="ok">&nbsp;</span><span class="err">限制50字以内</span> 
      </div>
      </div>
    </div>
    <div class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="button" onclick="Auditting.Pass()">通过</button></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="8" type="button" onclick="Auditting.NotPass()">不通过</button></div>
	</div>
</form>
</div>