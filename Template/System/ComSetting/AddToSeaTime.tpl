<div class="DContInner setPWDComfireCont">
    <form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>区间值：</label>
                <div class="inp">
                    <input id="min_time" type="text" value="{$MinTime}" class="inpCommon inpDate" name="min_time" onClick="WdatePicker({literal}{minDate:'00:00:00',maxDate:'#F{$dp.$D(\'max_time\')}',dateFmt:' HH:mm:ss'}){/literal}"/> 至
                    <input id="max_time" type="text" value="{$MaxTime}" class="inpCommon inpDate" name="max_time" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'min_time\')}',maxDate:'23:59:59', dateFmt:' HH:mm:ss'}){/literal}"/>
                </div>
                <span class="info">请填写区间值</span><span class="ok">&nbsp;</span><span class="err">区间值不为零且必须是数字</span> 
            </div> 
        </div>
        <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
        <div class="ft">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="3" type="submit">确定</button></div>
        </div>
    </form>
</div>