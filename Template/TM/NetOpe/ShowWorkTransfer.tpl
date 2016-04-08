<div class="DContInner">
    <form id="J_taskMoveForm">
        <input type="hidden" name="userid" id="userid">
        <div class="bd">
            <div style="float:left; width:69%">
                <div class="table_attention marginBottom10"><label>新制作人</label></div>
                <div class="tf">
                    <label><em class="require">*</em>账号：</label>
                    <div class="inp"><input type="text" valid="required number" id="amount" name="amount" class="amount"></div>
                    <span class="info">请输入账号</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入正确账号</span>
                </div>
            </div>
            <div style="float:right; width:30%;">
                <div class="table_attention marginBottom10"><label>原制作人</label></div>
                <div class="tf">
                    <div class="inp" style="padding-left:18px;">{$mkname}</div>
                </div>  
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
            <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div> 
        </div>
    </form>
</div>
