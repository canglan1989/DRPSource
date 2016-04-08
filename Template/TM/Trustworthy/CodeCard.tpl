<div class="DContInner setPWDComfireCont">
    <form id="J_CodeCardForm">
        <input type="hidden" name="order_id" value="{$order_id}">
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>客户名称：</label>
                <div class="inp">{$data.0.customer_name}</div>
            </div>
            <div class="tf">			
                <label><em class="require">*</em>网址：</label>
                <div class="inp">{$data.0.web_site}</div>
            </div>
            <div class="tf">
                <label><em class="require">*</em>认证代码：</label>
                <div class="inp"><textarea cols="40" rows="10" valid="required" tabindex="1" id="code" name="code">{$code}</textarea></div>
                <span class="info">请输入认证代码</span>
                <span class="ok">&nbsp;</span>
                <span class="err">请输入认证代码</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>订单有效期：</label>
                <div class="inp">                
                    <input id="J_editTimeS" value="{$data.0.effect_sdate}" class="inpCommon inpDate" valid="required" type="text"  {literal}onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})"{/literal} name="create_timeS">
                    至
                    <input id="J_editTimeE" value="{$data.0.effect_edate}" class="inpCommon inpDate" type="text" valid="required" {literal}onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})"{/literal} name="create_timeE">
                </div>
                <span class="info">请输入订单有效期</span>
                <span class="ok">&nbsp;</span>
                <span class="err">请输入订单有效期</span>
            </div>
        </div>	
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
            <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="3">确定</button></div> 
        </div>
    </form>
</div>                
