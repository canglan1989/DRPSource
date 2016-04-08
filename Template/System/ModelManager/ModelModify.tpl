<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：模块管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=System&c=Model&a=ModelList&pid={$pModelID}&isAgent={$isAgent}')">模块列表</a>
<span>&gt;</span>{$strTitle}</div>
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
    <form action="" method="post" name="form1" id="form1">
      <div class="tf" style="padding-top:20px;">
        <label><em class="require">*</em>选择模块组：</label>
        <div class="inp">
          <select name="cbModelGroup" id="cbModelGroup" style="width:150px">        
                  {foreach from=$arryModelGroup item=data key=index}              
            <option value="{$data.mgroup_id}" {if $pModelID == $data.mgroup_id }selected="selected"{/if}>{$data.mgroup_name}</option>
                  {/foreach}            
          </select>
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
        <label><em class="require">*</em>模块名：</label>
        <div class="inp"><input name="tbxModelName" type="text" id="tbxModelName" size="30" maxlength="30"  value="{$objModel->strModelName}" valid="required isNull"/></div>
        <span class="info">请输入实际意义的模块名称，用于权限分配的显示</span>
        <span class="ok">&nbsp;</span><span class="err">请输入实际意义的模块名称，用于权限分配的显示</span>
      </div>
      <div class="tf">
        <label><em class="require">*</em>模块代号：</label>
        <div class="inp"><input name="tbxModelCode" type="text" id="tbxModelCode" size="30" maxlength="30" value="{$objModel->strModelCode}"  valid="required isNull" /></div>
        <span class="info">模块的权限代号，用于权限判断 </span>
        <span class="ok">&nbsp;</span><span class="err">模块的权限代号，用于权限判断 </span>
      </div>
      <div class="tf">
        <label><em class="require">*</em>模块显示名：</label>
        <div class="inp"><input type="text" id="tbxModelShowName" name="tbxModelShowName" size="30" maxlength="30" value="{$objModel->strShowName}"  valid="required isNull" /></div>
        <span class="info">可以和模块名相同，系统菜单显示的名称 </span>
        <span class="ok">&nbsp;</span><span class="err">可以和模块名相同，系统菜单显示的名称 </span>
      </div>
      <div class="tf">
        <label><em class="require">*</em>模块页面：</label>
        <div class="inp"><input type="text" id="tbxModelPage" name="tbxModelPage" size="80" maxlength="256" style="width:330px;" value="{$objModel->strModelPage}"  valid="required isNull" /></div>
        <span class="info">模块对应的页面</span>
        <span class="ok">&nbsp;</span><span class="err">模块对应的页面</span>
      </div>
      <div class="tf">
        <label>显示顺序：</label>
        <div class="inp">
          <input name="tbxSortIndex" type="text" id="tbxSortIndex" value="{$objModel->iSortIndex}" size="10" maxlength="5"/>
        </div>
      </div>
      <div class="tf">
        <label>关闭此模块：</label>
        <input name="chkIsLock" id="chkIsLock" type="checkbox" value="1" class="checkInp" {if $objModel->iIsLock == 1} checked='checked' {/if} /> 
      </div>
      <div class="tf">
        <label>菜单：</label>
        <input name="chkIsMenu" id="chkIsMenu" type="checkbox" value="1" class="checkInp" {if $objModel->iIsMenu == 1} checked='checked' {/if} /> 
      </div>
      <div class="tf">
        <label>模块描述：</label>
        <div class="inp">
          <textarea name="tbxRemark" cols="50" id="tbxRemark">{$objModel->strModelRemark}</textarea>
        </div>
      </div>
        <div class="tf tf_submit">
        	<label>&nbsp;</label>
        	<div class="inp">
                <div class="ui_button ui_button_confirm">
                <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
                </div>
                <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=Model&a=ModelList&pid={$pModelID}&isAgent={$isAgent}')" 
                href="javascript:;">返 回</a>
                </div>
            </div>
    	</div>
    </form>
</div>
{literal} 
<script language="javascript" type="text/javascript">
function v_isNull(e){return $.trim(e)!='';}                                       
new Reg.vf($('#form1'),{extValid:{isNull:v_isNull},callback:function(data){
	//数据已提交，正在处理标识
	var _InDealWith = false;
	if (_InDealWith) 
    {
        IM.tip.show("数据已提交，正在处理中！");
        return false;
    }
    
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
    var isAgent = {$isAgent};
    var formValues = "id={$id}&isAgent="+ isAgent +"&"+$('#form1').serialize()+"&productTypes="+productTypes;
    {literal} 
    
    _InDealWith = true;
    var data = $PostData("/?d=System&c=Model&a=ModelModifySubmit",formValues);
    
    if(parseInt(data) != 0)
    {
        IM.tip.warn(data);
        _InDealWith = false;
    }
    else
        JumpPage("/?d=System&c=Model&a=ModelList&pid=" + $("#cbModelGroup").val()+"&isAgent="+ isAgent);
}});
</script> 
{/literal}