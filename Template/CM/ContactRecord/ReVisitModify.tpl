<div class="DContInner setPWDComfireCont">
<form id="J_ReVisitModify" name="J_ReVisitModify" >
  <div class="bd">  
    <div class="tf">
      <label>客户名称：</label>
      <div class="inp">
        <input id="tbxID" name="tbxID" value="{$objAgContactRecodeInfo->iRecodeId}" type="hidden" /> 
        {$objAgContactRecodeInfo->strCustomerName}
      </div>
      </div>
      {if $objAgContactRecodeInfo->iIsVisit == 1}
    <div class="tf">
      <label>拜访主题：</label>
      <div class="inp">
        {$objAgContactRecodeInfo->strVisitTheme}
      </div>
      </div>
    <div class="tf">
      <label>实际拜访时间：</label>
      <div class="inp">
      {$objAgContactRecodeInfo->strContactTime|date_format:'%Y-%m-%d %H:%M'}
      -- 
      {$objAgContactRecodeInfo->strContactETime|date_format:'%H:%M'}
      </div>
      </div>
     <div class="tf">
      <label>被访人： </label>
      <div class="inp">
        {$objAgContactRecodeInfo->strContactName}
      </div>
      </div>
      {else}
      <div class="tf">
      <label>联系时间：</label>
      <div class="inp">
      {$objAgContactRecodeInfo->strContactTime|date_format:'%Y-%m-%d %H:%M'}
      </div>
      </div>
     <div class="tf">
      <label>被联系人： </label>
      <div class="inp">
        {$objAgContactRecodeInfo->strContactName}
      </div>
      </div>
      {/if}
      <div class="tf">
        <label>联系方式：</label>
        <div class="inp">
          {if $objAgContactRecodeInfo->strContactMobile!=""}手机号：{$objAgContactRecodeInfo->strContactMobile}{/if}
          {if $objAgContactRecodeInfo->strContactTel!=""}固定电话：{$objAgContactRecodeInfo->strContactTel}{/if}          
        </div>
        </div>
        {if $objAgContactRecodeInfo->iIsVisit == 0}
      <div class="tf">
        <label>联系结果：</label>
        <div class="inp">
            {if $objAgContactRecodeInfo->iNotValidContactId == 0 }有效联系            
            {else}无效联系 &nbsp;&nbsp;{$objAgContactRecodeInfo->strNotValidContactName}{/if}
        </div>
      </div>      
        {/if}
      <div class="tf">
        <label>为网盟推广：</label>
        <div class="inp">
            {if $objAgContactRecodeInfo->iIsAlliance == 0 }否            
            {else}是 &nbsp;&nbsp;{if $objAgContactRecodeInfo->iIntentionRating > 0}意向等级：{$objAgContactRecodeInfo->strIntentionRatingName}
            {if $objAgContactRecodeInfo->iIncomeMoney >0}<br/>
            &nbsp;&nbsp;预计到账时间：{$objAgContactRecodeInfo->strIncomeDate}
            &nbsp;&nbsp;预计到账金额：{$objAgContactRecodeInfo->iIncomeMoney}元{/if}{/if}{/if}
        </div>
      </div>
      <div class="tf">
        <label>{if $objAgContactRecodeInfo->iIsVisit == 1}拜访{else}联系{/if}内容：</label>
        <div class="inp">        
        <textarea name="tbxContactRecode" cols="50" style="width:400px;height:56px; border:none; background-color:#FFF" id="tbxContactRecode">{$objAgContactRecodeInfo->strContactRecode}</textarea>
        </div>
      </div>
      <div class="tf">
        <label>下次电话联系时间：</label>
        <div class="inp">
        {if $objAgContactRecodeInfo->strNextTime != ""}{$objAgContactRecodeInfo->strNextTime}{else}--{/if}
        </div>
      </div>
      <div class="tf">
        <label>操作人：</label>
        <div class="inp">
        {$objAgContactRecodeInfo->strCreateUserName}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作时间：{$objAgContactRecodeInfo->strCreateTime}
        </div>
      </div>
      {if $isReVisit == 1}
      <div class="tf">
        <label><em class="require">*</em>回访内容：</label>
        <div class="inp">
          <textarea name="tbxRevisitContent" cols="50" style="width:300px;height:60px;" id="tbxRevisitContent"></textarea>
          <span class="c_info">限制500字以内</span><span class="ok">&nbsp;</span><span class="err">限制500字以内</span> </div>
      </div>
     </div>
    <div class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>
	</div>
    {else}
    <div class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
	</div>
    {/if}
</form>
</div>
    
   