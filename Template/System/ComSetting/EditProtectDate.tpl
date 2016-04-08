<div class="DContInner setPWDComfireCont">
<form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
  <div class="bd"> 
          <div class="tf">
      <label><em class="require">*</em>区间值：</label>
        <div class="inp">
             <input id="J_editTimeS" value="{$MinTime}"  class="" style="width:80px;text-align:right" size="8" maxlength="3" onkeydown="return NumberOnly(event)" name="min_day" valid="required" />
            至
             <input id="J_editTimeE" value="{$MaxTime}"  class="" style="width:80px;text-align:right" size="8" maxlength="3" onkeydown="return NumberOnly(event)" name="max_day" valid="required" />	
        </div>
        <span class="info">请填写区间值</span><span class="ok">&nbsp;</span><span class="err">区间值不为零且必须是数字</span> 
      </div> 
  </div>
  <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="3" type="submit">确定</button></div>
	</div>
</form>
</div>