<div class="DContInner">
<div class="bd">           
    <div class="tf">
            <label>审核结果:</label>
            <div class="inp">{if $check_status eq 1}通过{else}不通过{/if}</div>
    </div> 
     <div class="tf">
            <label>审核备注:</label>
            <div class="inp">{$check_remark}</div>
    </div>    
    <div class="tf">
            <label>审核人:</label>
            <div class="inp">{$e_name}{$user_name}</div>
    </div> 
    <div class="tf">
            <label>审核时间:</label>
            <div class="inp">{$check_time}</div>
    </div> 
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</div>