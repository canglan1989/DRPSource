<div class="DContInner">
<form id="J_newAccountAreaModify" class="newLXXiaoJiForm" name="J_newAccountAreaModify" action="">
<div class="bd">         
    <div class="tf">
        <label>上级账号组：</label>
        <div class="inp">
     {$sup_account_name}
     <input type="hidden" id="supid" value="{$supid}" name="supid" />
     
        </div>
    </div> 
     <div class="tf">
            <label><em class="require">*</em>账号组名称：</label>
                <div class="inp">
                    <input type="text" id="txtaccountGroupName" name="txtaccountGroupName" value="{$account_name}" valid="required" />
                </div>
            <input type="hidden" id="id" value="{$id}" name="id" />
	    <span class="info">请输入账号组名称</span><span class="ok">&nbsp;</span><span class="err">请输入账号组名称</span>
    </div>   
</div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>			
	</div>
            
</form> 
</div>