<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S list_table_head-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2>{$strTitle}</h2>
                </div>
            </div>
        </div>
        <span class="declare">
        “<em class="require">*</em>”为必填信息
        </span>
    </div>
<!--E list_table_head--> 
<!--S list_table_main-->
  <div class="form_bd">
    <form id="J_modify" style="padding-top:10px;">
    	<div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">当代理商保证金账户或预存款账户可用余额小于设置金额时，系统将提醒代理商打款，0表示不提示。</span></div>
		
    <div class="form_block_bd">

                  <div class="tf">
                        <label>产品名称</label>
                        <div class="inp">
                        <label style="width:100px;">保证金</label><label style="width:100px;">预存款</label>
                        </div>
                  </div>
                  {foreach from=$arrayData item=data key=index}
                  <div class="tf">
                        <label><em class="require">*</em>{$data.product_type_name}：</label>
                        <div class="inp">
                        <input type="hidden" id="tbxProductID_{$data.product_type_id}" name="tbxProductID_{$data.product_type_id}" value="{$data.product_type_id}" />
                        <label style="width:100px;"><input name="tbxGuaMoney_{$data.product_type_id}" type="text" id="tbxGuaMoney_{$data.product_type_id}" onkeyup='return FloatNumber(this)' value="{$data.gua_balance_warning}" class="inpCommon" style="text-align:right" size="30" maxlength="7" valid="required amount"/></label>
                        <label style="width:100px;"><input name="tbxPreMoney_{$data.product_type_id}" type="text" id="tbxPreMoney_{$data.product_type_id}" onkeyup='return FloatNumber(this)' value="{$data.pre_balance_warning}" class="inpCommon" style="text-align:right" size="30" maxlength="7" valid="required amount"/></label>
                        </div>
                        <span class="info">请输入{$data.product_type_name}打款提醒金额</span>
                        <span class="ok">&nbsp;</span><span class="err">请输入{$data.product_type_name}打款提醒金额</span>
                    </div>      
                  {/foreach}       
                  <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">
                        <div class="ui_button ui_button_confirm">
                        <button id="btnOK" class="ui_button_inner" type="submit">确定</button>
                        </div>
                        <div class="ui_button ui_button_cancel">
                        <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">取消</a>
                        </div>
                    </div>  
                  </div>
      </div>
    </form>
  </div>
</div>
<!--E list_table_main--> 
<!--S Main--> 
{literal} 
<script type="text/javascript">
var _InDealWith = false;
new Reg.vf($('#J_modify'),{callback:function(formData){
    //数据已提交，正在处理标识
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    
    MM.ajax({
		data:$('#J_modify').serialize(),
		url: "/?d=System&c=ComSetting&a=AgentAccountBalanceWarningSubmit",
		success:function(backData){
			if(parseInt(backData) == 0){
			     IM.tip.show("设置成功！");
			}else{
                 IM.tip.warn(backData);
            }
            _InDealWith = false;
		}
	});
}});
</script> 
{/literal}