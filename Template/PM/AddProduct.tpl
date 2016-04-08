<div class="DContInner setPWDComfireCont">
<form id="J_newProduct" class="newProductForm" name="J_newProduct" >
  <div class="bd">
  {if $canDel == 1}
    <div class="tf">
      <label> <em class="require">*</em><input type="hidden" id="tbxOldProductTypeID" name="tbxOldProductTypeID" value="{$objPro->iProductTypeId}" /> 产品类别： </label>
      <div class="inp">
      <select id="cbProductType" name="cbProductType" valid="required cbProductType" onchange="selectProduct()"> 
      </select></div>
	  <span class="info">请选择产品类别</span> <span class="ok">&nbsp;</span><span class="err">请选择产品类别</span>
      </div>
    <div class="tf">
      <label> <em class="require">*</em> 产品编号：</label>
      <div class="inp">
        <input id="tbxProductNo" class="ac_input" type="text" tabindex="1" maxlength="18" valid="required tbxProductNo" 
        name="tbxProductNo" style="float:left; width:200px;" value="{$objPro->strProductNo}" />
        <input name="id" value="{$id}" type="hidden" />
      </div>
      <span class="info">请输入编号</span> <span class="ok">&nbsp;</span><span class="err">请输入编号</span> 
      </div>
     <div class="tf">
      <label> <em class="require">*</em> 产品名称： </label>
      <div class="inp">
        <input id="tbxProductSeries" class="ac_input" type="text" tabindex="1" maxlength="18" valid="required tbxProductSeries" name="tbxProductSeries" style="float:left; width:200px;" value="{$objPro->strProductSeries}" />
      </div>
      <span class="info">请输入产品名称</span> <span class="ok">&nbsp;</span><span class="err">请输入产品名称</span> </div> 
      <div class="tf" id="tbxUserNumber">
      <label> 用户数： </label>
      <div class="inp">
        <input id="tbxUserNumber" class="ac_input" type="text" tabindex="1" maxlength="9" name="tbxUserNumber" style="float:left; width:200px;" value="{$objPro->strProductSpecs}" />
      </div></div>
      {else}
    <div class="tf">
      <label> <em class="require">*</em><input type="hidden" id="tbxOldProductTypeID" name="tbxOldProductTypeID" value="{$objPro->iProductTypeId}" /> 产品类别： </label>
      <div class="inp" id="divProductTypeText"></div><div style="display:none" >
      <select id="cbProductType" name="cbProductType" onchange="selectProduct()">
      </select></div>
      </div>
    <div class="tf">
      <label> <em class="require">*</em> 产品编号：</label>
      <div class="inp">
        <input id="tbxProductNo" class="ac_input" type="hidden" name="tbxProductNo" style="float:left; width:200px;" value="{$objPro->strProductNo}" />
        <input name="id" value="{$id}" type="hidden" />{$objPro->strProductNo}
      </div>
      </div>
     <div class="tf">
      <label> <em class="require">*</em> 产品名称： </label>
      <div class="inp">
        <input id="tbxProductSeries" class="ac_input" type="hidden" name="tbxProductSeries" style="float:left; width:200px;" value="{$objPro->strProductSeries}" />{$objPro->strProductSeries}
      </div>
      <div class="tf" id="tbxUserNumber">
      <label> 用户数： </label>
      <div class="inp">
        <input id="tbxUserNumber" class="ac_input" type="hidden" name="tbxUserNumber" style="float:left; width:200px;" value="{$objPro->strProductSpecs}" />{$objPro->strProductSpecs}
      </div></div>
      {/if}
    <div class="tf">
      <label> 可赠送：</label>
      <div class="inp">
        <input id="chkIsGift" type="checkbox" name="chkIsGift" class="checkInp" value="1" {if $objPro->iIsGift == 1} checked='checked' {/if} />
      </div><span class="info">该产品是否可做为赠品</span> <span class="ok">&nbsp;</span><span class="err">该产品是否可做为赠品</span> 
      </div>
      <div class="tf">
      <label>  备注： </label>
      <div class="inp">
        <textarea id="tbxProductRemark" class="ac_input" tabindex="1" style="float:left; width:300px;" name="tbxProductRemark">{$objPro->strProductRemark}</textarea>
      </div>
     </div> 
  </div>
  <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>
	</div>
</form>
</div>
    
   