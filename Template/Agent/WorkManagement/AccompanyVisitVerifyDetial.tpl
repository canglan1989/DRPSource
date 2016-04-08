<div class="DContInner">
<div class="bd">                   
     <div class="tf">
            <label>质检位置:</label>
            <div class="inp">{if $objVisitAccompanyInfo->strCheckAddress!=""}{$objVisitAccompanyInfo->strCheckAddress}
            {else}--{/if}</div>
    </div> 
     <div class="tf">
            <label>质检结果:</label>
            <div class="inp">{$strCheckStatu}</div>
    </div>    
    <div class="tf">
            <label>质检人:</label>
            <div class="inp">{$objVisitAccompanyInfo->strCheckUserName}</div>
    </div> 
    <div class="tf">
            <label>质检时间:</label>
            <div class="inp">{$objVisitAccompanyInfo->strCheckTime}</div>
    </div> 
    <div class="tf">
            <label>质检情况:</label>
            <div class="inp" style="width:400px;">{if $objVisitAccompanyInfo->strCheckDetial!=""}{$objVisitAccompanyInfo->strCheckDetial}
            {else}--{/if}</div>
    </div> 
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</div>