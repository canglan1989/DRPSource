<div class="DContInner setPWDComfireCont">
<form id="J_VisitInviteModify" name="J_VisitInviteModify" >
  <div class="bd">  
    <div class="tf">
      <label>客户名称：</label>
      <div class="inp">
        <input id="tbxID" name="tbxID" value="{$objAgContactRecodeInfo->iRecodeId}" type="hidden" /> 
        <input id="tbxCustomerID" name="tbxCustomerID" value="{$objAgContactRecodeInfo->iCustomerId}" type="hidden" />
        <input type="checkbox" value="1" name="chkIsManager" id="chkIsManager" class="checkInp" style="display:none" {if $isManager == 1} checked="checked" {/if} />
        {$objAgContactRecodeInfo->strCustomerName}
      </div>
      </div>
    <div class="tf">
      <label><em class="require">*</em>拜访主题：</label>
      <div class="inp">
        <input type="text" valid="required" style="width:300px" maxlength="32" name="tbxVisitTheme" id="tbxVisitTheme" value="{$objAgContactRecodeInfo->strVisitTheme}"/>
      </div>
      <span class="info">请输入拜访主题</span> <span class="ok">&nbsp;</span><span class="err">请输入拜访主题</span> 
      </div>     
    <div class="tf">
      <label> <em class="require">*</em>预约拜访时间：</label>
      <div class="inp">
      <input type="text" id="tbxInviteContactTime" valid="required" class="inpDate" name="tbxInviteContactTime" value="{$objAgContactRecodeInfo->strInviteTime|date_format:'%Y-%m-%d %H:%M'}" {literal}onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m'})"/>{/literal}
      -- 
      <input type="text" valid="required" class="inpCommon inpDate" name="tbxInviteContactETime" value="{$objAgContactRecodeInfo->strInviteETime|date_format:'%H:%M'}" {literal}onfocus="WdatePicker({dateFmt:'HH:mm',minDate:'#F{$dp.$D(\'tbxInviteContactTime\')}'})"/>{/literal}
      </div>
      <span class="info">请输入预约拜访时间</span> <span class="ok">&nbsp;</span><span class="err">请输入预约拜访时间</span> 
      </div>
     <div class="tf">
      <label> <em class="require">*</em>预约被访人： </label>
      <div class="inp">
        <input type="text" tabindex="1" maxlength="18" valid="required" name="tbxInviteContactName" id="tbxInviteContactName" class="contactName" value="{$objAgContactRecodeInfo->strInviteContactName}" autocomplete="off"/>
      </div>
      <span class="info">请输入预约被访人</span> <span class="ok">&nbsp;</span><span class="err">请输入预约被访人</span> </div> 
      <div class="tf">
        <label><em class="require">*</em>手机号：</label>
        <div class="inp">
          <input type="text" valid="mPhone" maxlength="20" name="tbxInviteContactMobile" id="tbxInviteContactMobile" class="mPhone" value="{$objAgContactRecodeInfo->strInviteContactMobile}"/>
        </div>
        <span style="display: inline;" class="info">手机号或固定电话必须输入一项</span> <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span> </div>
      <div class="tf">
        <label>固定电话：</label>
        <div class="inp">
          <input type="text" valid="fPhone" name="tbxInviteContactTel" id="tbxInviteContactTel" maxlength="20" class="fPhone" value="{$objAgContactRecodeInfo->strInviteContactTel}"/>
        </div>
        <span style="display: none;" class="info">固话格式:0571-8888888</span> <span style="display: none;" class="err">请输入正确固定电话号</span> </div>
      </div>
    <div class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>
	</div>
</form>
</div>
    
   