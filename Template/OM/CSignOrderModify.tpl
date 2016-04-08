<div class="DContInner">
<form id="form_cSignOrder" name="form_cSignOrder" action="">
<div class="bd">
 <div class="tf">
    <label>订单号：</label>
    <div class="inp">
    {$objOrder->strOrderNo}
    </div>
</div>
 <div class="tf">
    <label>客户名：</label>
    <div class="inp">
    {$objOrder->strCustomerName}
    </div>
</div>
 <div class="tf">
    <label>产品：</label>
    <div class="inp">
    {$strProductName}
    </div>
</div>
 <div class="tf">
    <label>订单有效期：</label>
    <div class="inp">
    {$objOrder->strOrderSdate|date_format:"%Y-%m-%d"} 至 {$objOrder->strOrderEdate|date_format:"%Y-%m-%d"}
    </div>
</div>
 <div class="tf">
    <label><em class="require">*</em>价格：</label>
    <div class="inp">
    <input name="tbxPrice" type="text" id="tbxPrice" onkeyup='return FloatNumber(this)' value="{$objOrder->iActPrice}" class="inpCommon" style="text-align:right" size="30" maxlength="7" valid="required amount"/>
    </div>
        <span class="info">请输入产品价格</span>
		<span class="ok">&nbsp;</span><span class="err">请输入产品价格</span>
</div> 
 <div class="tf">
    <label><em class="require">*</em>续签至：</label>
    <div class="inp">
    <input id="tbxEDate" class="inpCommon inpDate" type="text" {literal} onfocus="WdatePicker({minDate:{/literal}'{$objOrder->strOrderEdate|date_format:"%Y-%m-%d"}'{literal}})" {/literal}name="tbxEDate" 
        value="{$strOrderEdate|date_format:"%Y-%m-%d"}" valid="required"/>
    </div>
        <span class="info">请输入续签结束日期</span>
		<span class="ok">&nbsp;</span><span class="err">请输入续签结束日期</span>
</div>  
</div>                                                                                  
    <div class="ft">                                                                             
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>                      
    </div>  
</form> 
</div>