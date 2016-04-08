<div class="DContInner setPWDComfireCont">
<form id="form2" action="" name="form2">
	<input name="customer_ids" id="customer_ids" type="hidden" value="{$customer_ids}" />
	<div class="bd">
        <div class="tf">
            <label>审核人：</label>
            <div class="inp"><input type="text" id="assign_check_Name" name="assign_check_Name" valid="required"/><input name="assign_check_id" id="assign_check_id" type="hidden" value="-1" /></div>
            <span class="info">请输入姓名(或工号)</span>
            <span class="ok">&nbsp;</span><span class="err">请输入姓名(或工号)</span>
        </div>
    </div>  
	<div class="ft">
		<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
		<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确定</button></div>
	</div>
</form>
</div>