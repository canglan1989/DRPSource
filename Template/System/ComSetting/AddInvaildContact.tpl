<div class="DContInner setPWDComfireCont">
    <form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>选项内容：</label>
                <div class="inp">
                    <input name="optionitem" value="{$OptionItem}" id="optionitem"  class="inpCommon"  valid="required"/>
                </div>
                <span class="info">请填写选项内容</span><span class="ok">&nbsp;</span><span class="err">请填写选项内容</span> 
            </div> 
                 <div class="tf">
                <label><em class="require">*</em>选项排序：</label>
                <div class="inp">
                    <input name="sortindex" value="{$SortIndex}" id="sortindex"  class="inpCommon"  valid="required amount"/>
                </div>
                <span class="info">请填写选项排序</span><span class="ok">&nbsp;</span><span class="err">排序必须为数字</span> 
            </div> 
        </div>
        <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
        <div class="ft">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="3" type="submit">确定</button></div>
        </div>
    </form>
</div>