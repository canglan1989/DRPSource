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
      <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">当代理商提交的网盟转款大于设置的金额时，则允许提交，否则不允许。0表示不限制。</span></div>
    	<div class="form_block_bd">
          <div class="tf" >
                <label ><em class="require">*</em>网盟最低转款金额：</label>
                <div class="inp">
                <input name="tbxMinInMoney" type="text" id="tbxMinInMoney" onkeyup='return FloatNumber(this)' value="{$iMinInMoney}" class="inpCommon" style="text-align:right" size="30" maxlength="7" valid="required amount"/> 元 
                </div>
                <span class="info">请输入网盟最低转款金额</span>
                <span class="ok">&nbsp;</span><span class="err">请输入网盟最低转款金额</span>
            </div> 
      <!--    <div class="tf" style="padding-top:20px;">
                <label style="width:200px;"><em class="require">*</em>网盟转款比例：</label>
                <div class="inp">
                预存款：<input name="tbxPreRate" type="text" id="tbxPreRate" onkeydown='return NumberOnly(event)' value="{$iPreRate}" class="inpCommon" style="text-align:right" size="30" maxlength="7" valid="required amount"/>&nbsp;&nbsp;&nbsp; 
                返点：<input name="tbxReRate" type="text" id="tbxReRate" onkeydown='return NumberOnly(event)' value="{$iReRate}" class="inpCommon" style="text-align:right" size="30" maxlength="7" valid="required amount"/>
                </div>
                <span class="info">请输入网盟转款比例</span>
                <span class="ok">&nbsp;</span><span class="err">请输入网盟转款比例</span>
            </div> -->
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
<style>.tf label{width:200px;}</style>
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
		url: "/?d=System&c=ComSetting&a=UnitMinInMoneySubmit",
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