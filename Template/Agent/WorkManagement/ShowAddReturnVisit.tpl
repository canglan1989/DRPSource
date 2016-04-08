<div class="DContInner setPWDComfireCont">
    <form id="J_addVisitRecord">
        <input type="hidden" value='{$id}' name='id'/>
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>回访时间：</label>
                <div class="inp"><input type="text" name="visitTime" class="inpDate" valid="required" tabindex="1" value="{$ReturnInfo.return_time}" onfocus="WdatePicker({literal}{dateFmt:'yyyy-MM-dd HH:mm:ss'}{/literal})"></div>
                <span class="info">请输入回访时间</span><span class="err">请输入回访时间</span>
            </div>
            <div class="tf">

                <label><em class="require">*</em>回访内容：</label>
                <div class="inp"><textarea valid="required" cols="30" name="visitContent">{$ReturnInfo.content}</textarea></div>
                <span class="info">请输入回访内容</span><span class="err">请输入回访内容</span>
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>
        </div>
    </form>
</div>