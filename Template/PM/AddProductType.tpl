<div class="DContInner setPWDComfireCont">
<form id="J_newProductType" class="newProductForm" name="J_newProductType" >
  <div class="bd">
  {if $canDel == 1}
    <div class="tf">
      <label> <em class="require">*</em>所属分类：</label>
      <div class="inp">
        <select id="cbType" name="cbType">
        <option value="0" {if $objProductTypeInfo->iDataType == 0} selected="selected"{/if}>增值产品</option>
        <option value="1" {if $objProductTypeInfo->iDataType == 1} selected="selected"{/if}>网盟产品</option>
        </select>
      </div>
      </div>
    <div class="tf">
      <label> <em class="require">*</em>类别编号：</label>
      <div class="inp">
        <input id="tbxTypeNo" class="ac_input" type="text" tabindex="1" maxlength="18" valid="required tbxProductNo" name="tbxTypeNo" value="{$objProductTypeInfo->strProductTypeNo}" />
        <input name="id" value="{$id}" type="hidden" />
      </div>
      <span class="info">请输入类别编号</span> <span class="ok">&nbsp;</span><span class="err">请输入类别编号</span> 
      </div>
    <div class="tf">
      <label> <em class="require">*</em>类别名称：</label>
      <div class="inp">
        <input id="tbxTypeName" class="ac_input" type="text" tabindex="1" maxlength="18" valid="required tbxProductNo" name="tbxTypeName" value="{$objProductTypeInfo->strProductTypeName}" />
      </div>
      <span class="info">请输入类别名称</span> <span class="ok">&nbsp;</span><span class="err">请输入类别名称</span> 
      </div>
    {else}
    <div class="tf">
      <label> <em class="require">*</em>所属分类：</label>
      <div class="inp">{if $objProductTypeInfo->iDataType == 0}增值产品{else}网盟产品{/if}
      <input id="cbType" name="cbType" type="hidden" value="{$objProductTypeInfo->iDataType}" /> </div>
      </div>
    <div class="tf">
      <label> <em class="require">*</em>类别编号：</label>
      <div class="inp">
        <input id="tbxTypeNo" class="ac_input" type="hidden" name="tbxTypeNo" value="{$objProductTypeInfo->strProductTypeNo}" />
        <input name="id" value="{$id}" type="hidden" />{$objProductTypeInfo->strProductTypeNo}
      </div>
      </div>
    <div class="tf">
      <label> <em class="require">*</em>类别名称：</label>
      <div class="inp">
        <input id="tbxTypeName" class="ac_input" type="hidden" name="tbxTypeName" value="{$objProductTypeInfo->strProductTypeName}" />
        {$objProductTypeInfo->strProductTypeName}
      </div>
      </div>
    {/if}
      <div class="tf">
      <label>备注：</label>
      <div class="inp">
        <textarea id="tbxTypeRemark" class="ac_input" tabindex="1" cols="40"  name="tbxTypeRemark">{$objProductTypeInfo->strTypeRemark}</textarea>
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