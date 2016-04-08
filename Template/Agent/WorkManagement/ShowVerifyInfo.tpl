<div class="DContInner">
<div class="bd">           
    <div class="tf">
            <label>{$content}:</label>
            <div class="inp">{$record_no}</div>
    </div> 
     <div class="tf">
            <label>质检情况:</label>
            <div class="inp">{$vertify_remark}</div>
    </div>    
    <div class="tf">
            <label>质检结果:</label>
            <div class="inp">{if $verfity_status eq 0}不通过{/if}{if $verfity_status eq 1}通过{/if}</div>
    </div> 
    <div class="tf">
            <label>操作人:</label>
            <div class="inp">{$create_user_name}</div>
    </div>
    <div class="tf">
            <label>操作时间:</label>
            <div class="inp">{$create_time}</div>
    </div>
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</div>