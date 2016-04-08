<div class="DContInner setPWDComfireCont">
<form id="J_EditPredictIncome" name="J_EditPredictIncome" >
  <div class="bd">  
    <div class="tf">
      <label>客户名称：</label>
      <div class="inp">
        <input id="tbxID" name="tbxID" value="{$objAgContactRecodeInfo->iRecodeId}" type="hidden" /> 
        {$objAgContactRecodeInfo->strCustomerName}
      </div>
      </div>     
      <div class="tf">
        <label>意向等级：</label>
        <div class="inp">
            {$objAgContactRecodeInfo->strIntentionRatingName}
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>预计到账时间：</label>
        <div class="inp">
            <input id="tbxIncomeDate" type="text" class="inpCommon inpDate" value="{$objAgContactRecodeInfo->strIncomeDate}" name="tbxIncomeDate" onClick="WdatePicker({literal}{dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'}){/literal}"/>
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>预计到账金额：</label>
        <div class="inp">
            <input name="tbxIncomeMoney" id="tbxIncomeMoney" type="text"  value="{$objAgContactRecodeInfo->iIncomeMoney}" maxlength="8" onkeyup='return FloatNumber(this)' style="width:80px;text-align:right"/>元
        </div>
      </div>
      <div class="tf">
        <label>操作人：</label>
        <div class="inp">
        {$objAgContactRecodeInfo->strCreateUserName}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作时间：{$objAgContactRecodeInfo->strCreateTime}
        </div>
      </div>
     </div>
    <div class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>
	</div>
</form>
</div>
    
   