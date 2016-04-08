<div class="DContInner setPWDComfireCont">
    <form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>设置值：</label>
                <div class="inp">
                    <input name="valueday" value="{$ValueData}" id="scope" scope="{$ScopeValue}"  class="inpCommon"  valid="required amount inscope"/>
                </div>
                <span class="info">请在{$ScopeValue}范围内进行设置数值</span><span class="ok">&nbsp;</span><span class="err">请在{$ScopeValue}范围内进行设置数值</span> 
            </div> 
        </div>
        <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
        <div class="ft">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="3" type="submit">确定</button></div>
        </div>
    </form>
</div>