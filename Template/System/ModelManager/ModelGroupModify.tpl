<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：模块组管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=System&c=ModelGroup&a=ModelGroupList&isAgent={$isAgent}',true,true)">模块组列表</a><span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
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
    “
    <em class="require">*</em>
    ”为必填信息
    </span>
</div>
<div class="form_bd">
<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
<div class="form_block_bd">
  <div class="tf">
    <label><em class="require">*</em>根模块组：</label>
    <div class="inp">
      <select name="cbRootModelGroup" id="cbRootModelGroup" style="width:150px">        
        {foreach from=$arryModelGroup item=data key=index}              
        <option value="{$data.mgroup_no}" {if $rootModelGroupNo == $data.mgroup_no }selected="selected"{/if}>{$data.mgroup_name}</option>
        {/foreach}            
      </select>
      <input type="hidden" name="tbxModelGroupNo" id="tbxModelGroupNo" value="{$objModelGroup->strMgroupNo}" />
    </div>
  </div>
  {if $isAgent == 1}
  <div class="tf">
    <label title="签约此产品后才会显示该菜单">关联签约产品：</label>
    <div class="inp">
      {foreach from=$arrayProductTypes item=data key=index}
      <input class="checkInp" type="checkbox" value="{$data.aid}" name="chkProductTypes" id="chkProductType{$data.aid}" {if $data.is_check == 1} checked="checked" {/if} />{$data.product_type_name}&nbsp;&nbsp;&nbsp;&nbsp;{if ($index+1)%5 == 0} <br />{/if}
      {/foreach}
    </div>
    <span class="info">签约此产品后才会显示该菜单</span>
	<span class="ok">&nbsp;</span><span class="err">签约此产品后才会显示该菜单</span>
  </div>
  {/if}
  <div class="tf">
    <label><em class="require">*</em>模块组名：</label>
    <div class="inp">
      <input name="tbxModelGroupName" type="text" id="tbxModelGroupName" size="30" maxlength="30"  value="{$objModelGroup->strMgroupName}"  valid="required isNull"/>
    </div>
    <span class="info">请输入实际意义的模块名称</span>
	<span class="ok">&nbsp;</span><span class="err">请输入实际意义的模块名称</span>
  </div>
  <div class="tf">
    <label><em class="require">*</em>模块组代号：</label>
    <div class="inp">
      <input name="tbxModelGroupCode" type="text" id="tbxModelGroupCode" size="30" maxlength="30" value="{$objModelGroup->strMgroupCode}"  valid="required isNull"/>
    </div>
    <span class="info">模块的权限代号，提供系统使用 </span>
	<span class="ok">&nbsp;</span><span class="err">模块的权限代号，提供系统使用 </span>
  </div>
  <div class="tf">
    <label>显示顺序：</label>
    <div class="inp">
      <input name="tbxSortIndex" type="text" id="tbxSortIndex" value="{$objModelGroup->iSortIndex}" size="10" maxlength="5" style="text-align:right"/>
    </div>
  </div>
  <div class="tf">
    <label>关闭此模块组：</label>
    <input name="chkIsLock" id="chkIsLock" type="checkbox" class="checkInp" value="1" {if $objModelGroup->iIsLock == 1} checked='checked' {/if} />
    </div>
  <div class="tf">
    <label>模块组描述：</label>
    <div class="inp">
      <textarea name="tbxRemark" cols="50"  id="tbxRemark">{$objModelGroup->strMgroupRemark}</textarea>
    </div>
  </div>
  <div class="tf tf_submit">
    <label>&nbsp;</label>
    <div class="inp">
    <div class="ui_button ui_button_confirm">
    <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
    </div>
    <div class="ui_button ui_button_cancel">
    <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=ModelGroup&a=ModelGroupList&isAgent={$isAgent}')" 
    href="javascript:;">返 回</a>
    </div>
    </div>
  </div>
</div>
</div>
  {literal} 
  <script language="javascript" type="text/javascript">
    function v_isNull(e){return $.trim(e)!='';}                                       
	new Reg.vf($('#tableFilterForm'),{extValid:{isNull:v_isNull},callback:function(data){
		//数据已提交，正在处理标识
		var _InDealWith = false;
			if (_InDealWith) 
			{
				IM.tip.show("数据已提交，正在处理中！");					
				return false;
			}
	
			//在这里添加输入数据正确性验证
            var chkProductTypes = document.getElementsByName("chkProductTypes");
			var productTypes = ",";
            for(var i=0;i<chkProductTypes.length;i++)
            {
                if(chkProductTypes[i].checked == true)
                {
                    productTypes +=  chkProductTypes[i].value + ",";
                }
            }
            if(productTypes.length < 2)
                productTypes = "";
            
			//提交数据
			{/literal} 
			var formValues = "isAgent={$isAgent}&id={$id}&"+$('#tableFilterForm').serialize()+"&productTypes="+productTypes;
			{literal} 
			
			_InDealWith = true;
			var data = $PostData("/?d=System&c=ModelGroup&a=ModelGroupModifySubmit",formValues);
			
			if(parseInt(data) != 0)
			{
				//alert(data);
				IM.tip.warn(data);
				_InDealWith = false;
			}
			else
            {/literal} 
                JumpPage("/?d=System&c=ModelGroup&a=ModelGroupList&isAgent={$isAgent}");
            {literal} 

	}});
    </script> 
  {/literal}
</form>
</div>