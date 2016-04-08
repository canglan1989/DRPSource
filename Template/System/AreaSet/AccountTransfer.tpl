<div class="DContInner setPWDComfireCont">
<form id="J_AccountTransfer" class="newLXXiaoJiForm" name="J_AccountTransfer" action="">
<div class="bd"> 
    <div class="tf">
        <label>账号组名：</label>
        <div class="inp">
        <select id="cbAccountGroupName1" name="cbAccountGroupName1" onchange="GetLowLevelArray({$id})">
        <option value="-100" selected="selected">==请选择一级账号组==</option>
        {foreach from=$level1 item=data key=index}
        <option value="{$data.account_group_id}">{$data.account_name}</option>
        {/foreach}
        </select></div>
        <div class="inp">
        <select id="cbAccountGroupName2" name="cbAccountGroupName2" onchange="GetLowLevel3Array({$id})">
        <option value="-100">==请选择二级账号组==</option>
        </select></div>
        <div class="inp">
        <select id="cbAccountGroupName3" name="cbAccountGroupName3">
        </select></div>
    </div> 
</div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>			
	</div>
            
</form> 
</div>