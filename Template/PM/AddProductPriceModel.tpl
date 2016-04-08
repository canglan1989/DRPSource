<div class="DContInner"> {literal}
  <style>
#J_newProductpPriceModel label{width:160px;}
</style>
  {/literal}
  <form id="J_newProductpPriceModel">
    <div class="bd">
      <div class="tf">
        <label><em class="require">*</em> 产品： </label>
        <div class="inp">
          <select id="cbProductTypeID" name="cbProductTypeID" >
          </select>
          <select id="cbProductID" onchange="setModelName(this)" name="cbProductID" valid="required cbProductID">
          </select>
        </div>
        <span class="info">请选择产品</span> <span class="ok">&nbsp;</span><span class="err">请选择产品</span> </div>
      <div class="tf">
        <label> <em class="require">*</em> 模板名称： </label>
        <div class="inp">
          <input id="mbName" type="text" tabindex="1" maxlength="18" style="width:200px" valid="required" name="mbName" value="{$objProductPriceModelInfo->strModelName}" />
          <input name="id" value="{$id}" type="hidden" />
        </div>
        <span class="info">请输入模板名称</span> <span class="ok">&nbsp;</span><span class="err">请输入模板名称</span> </div>
      <div class="tf">
        <label><em class="require">*</em> 模板类型： </label>
        <div class="inp">
          <select id="mbType" name="mbType">
            <option value="0">代理价模板</option>
            <option value="1">促销价模板</option>
          </select>
        </div>
      </div>
      <div class="tf">
        <label> <em class="require">*</em> 价格： </label>
        <div class="inp">
          <input id="mbPriceRate" type="text" tabindex="1" maxlength="7" style="width:100px;text-align:right" valid="required amount" name="mbPriceRate" value="{$objProductPriceModelInfo->iPriceOrRate}" />
          <input name="id" value="{$id}" type="hidden" />
        </div>
        <span class="info">请输入价格</span> <span class="ok">&nbsp;</span><span class="err">请输入价格</span> </div>
      <div class="tf">
        <label><em class="require">*</em>预存款销奖扣款比例 ：</label>
        <div class="inp">
          <input onkeydown='return NumberOnly(event)' maxlength="5" value="{$objProductPriceModelInfo->iSaleBonusPes}" type="text" id="txtsale_bonus_pes" name="txtsale_bonus_pes" style="width:40px; text-align:center"  valid="required"/>
          :
          <input onkeydown='return NumberOnly(event)' value="{$objProductPriceModelInfo->iDeductionPes}" maxlength="5" type="text" id="txtdeduction_pes" name="txtdeduction_pes" style="width:40px; text-align:center"  valid="required"/>
        </div>
        <span class="info">请输入预存款与销奖扣款比例</span> <span class="ok">&nbsp;</span> <span class="err">请输入预存款与销奖扣款比例</span> </div>
    </div>
    <div class="ft">
      <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
      <div class="ui_button ui_button_confirm">
        <button class="ui_button_inner" tabindex="7" type="submit">确定</button>
      </div>
    </div>
  </form>
</div>
{literal} 
<script type="text/javascript">
 $(function(){
    {/literal}
    var id = {$id};
    var productTypeID={$productTypeID};
    var productID = {$objProductPriceModelInfo->iProductId};
    {literal}
    
     if(parseInt(id) >0)
        $GetProduct.Select("cbProductTypeID", "cbProductID",true,productTypeID,productID,"",ProductGroups.ValueIncrease);
     else
        $GetProduct.Init("cbProductTypeID", "cbProductID", true,"",ProductGroups.ValueIncrease);
 });
    </script> 
{/literal}