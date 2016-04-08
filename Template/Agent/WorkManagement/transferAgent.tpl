<div class="DContInner setPWDComfireCont">
    <form id="J_transferAgent" action="" name="J_transferAgent" class="">
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>新代理商：</label>
                <div class="inp">
                    <input  type="text" name="trans_agent_name" autocomplete="off" id="trans_agent_name" value=""  valid="required" tabindex="1"/>
                    <input type="hidden" name="trans_agent_id" id="trans_agent_id" value="-1" />
                </div>
                <span class="info">请输入代理名称或者主账号</span>
		<span class="ok">&nbsp;</span><span class="err">请输入代理名称或者主账号</span>
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
            <div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" onclick="goTransfer();">确定</button></div> 
        </div>
    </form>
</div>                

