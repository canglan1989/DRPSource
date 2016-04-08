<?php /* Smarty version 2.6.26, created on 2012-11-16 16:07:08
         compiled from System/ModelManager/ModelModify.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：模块管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=System&c=Model&a=ModelList&pid=<?php echo $this->_tpl_vars['pModelID']; ?>
&isAgent=<?php echo $this->_tpl_vars['isAgent']; ?>
')">模块列表</a>
<span>&gt;</span><?php echo $this->_tpl_vars['strTitle']; ?>
</div>
<!--E crumbs--> 
<div class="form_edit">
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2><?php echo $this->_tpl_vars['strTitle']; ?>
</h2>
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
                  <?php $_from = $this->_tpl_vars['arryModelGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>              
            <option value="<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
" <?php if ($this->_tpl_vars['pModelID'] == $this->_tpl_vars['data']['mgroup_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</option>
                  <?php endforeach; endif; unset($_from); ?>            
          </select>
        </div>
      </div>
      <?php if ($this->_tpl_vars['isAgent'] == 1): ?>
      <div class="tf">
        <label title="签约此产品后才会显示该菜单">关联签约产品：</label>
        <div class="inp">
          <?php $_from = $this->_tpl_vars['arrayProductTypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
          <input class="checkInp" type="checkbox" value="<?php echo $this->_tpl_vars['data']['aid']; ?>
" name="chkProductTypes" id="chkProductType<?php echo $this->_tpl_vars['data']['aid']; ?>
" <?php if ($this->_tpl_vars['data']['is_check'] == 1): ?> checked="checked" <?php endif; ?> /><?php echo $this->_tpl_vars['data']['product_type_name']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php if (( $this->_tpl_vars['index']+1 ) % 5 == 0): ?> <br /><?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
        </div>
        <span class="info">签约此产品后才会显示该菜单</span>
    	<span class="ok">&nbsp;</span><span class="err">签约此产品后才会显示该菜单</span>
      </div>
      <?php endif; ?>
      <div class="tf">
        <label><em class="require">*</em>模块名：</label>
        <div class="inp"><input name="tbxModelName" type="text" id="tbxModelName" size="30" maxlength="30"  value="<?php echo $this->_tpl_vars['objModel']->strModelName; ?>
" valid="required isNull"/></div>
        <span class="info">请输入实际意义的模块名称，用于权限分配的显示</span>
        <span class="ok">&nbsp;</span><span class="err">请输入实际意义的模块名称，用于权限分配的显示</span>
      </div>
      <div class="tf">
        <label><em class="require">*</em>模块代号：</label>
        <div class="inp"><input name="tbxModelCode" type="text" id="tbxModelCode" size="30" maxlength="30" value="<?php echo $this->_tpl_vars['objModel']->strModelCode; ?>
"  valid="required isNull" /></div>
        <span class="info">模块的权限代号，用于权限判断 </span>
        <span class="ok">&nbsp;</span><span class="err">模块的权限代号，用于权限判断 </span>
      </div>
      <div class="tf">
        <label><em class="require">*</em>模块显示名：</label>
        <div class="inp"><input type="text" id="tbxModelShowName" name="tbxModelShowName" size="30" maxlength="30" value="<?php echo $this->_tpl_vars['objModel']->strShowName; ?>
"  valid="required isNull" /></div>
        <span class="info">可以和模块名相同，系统菜单显示的名称 </span>
        <span class="ok">&nbsp;</span><span class="err">可以和模块名相同，系统菜单显示的名称 </span>
      </div>
      <div class="tf">
        <label><em class="require">*</em>模块页面：</label>
        <div class="inp"><input type="text" id="tbxModelPage" name="tbxModelPage" size="80" maxlength="256" style="width:330px;" value="<?php echo $this->_tpl_vars['objModel']->strModelPage; ?>
"  valid="required isNull" /></div>
        <span class="info">模块对应的页面</span>
        <span class="ok">&nbsp;</span><span class="err">模块对应的页面</span>
      </div>
      <div class="tf">
        <label>显示顺序：</label>
        <div class="inp">
          <input name="tbxSortIndex" type="text" id="tbxSortIndex" value="<?php echo $this->_tpl_vars['objModel']->iSortIndex; ?>
" size="10" maxlength="5"/>
        </div>
      </div>
      <div class="tf">
        <label>关闭此模块：</label>
        <input name="chkIsLock" id="chkIsLock" type="checkbox" value="1" class="checkInp" <?php if ($this->_tpl_vars['objModel']->iIsLock == 1): ?> checked='checked' <?php endif; ?> /> 
      </div>
      <div class="tf">
        <label>菜单：</label>
        <input name="chkIsMenu" id="chkIsMenu" type="checkbox" value="1" class="checkInp" <?php if ($this->_tpl_vars['objModel']->iIsMenu == 1): ?> checked='checked' <?php endif; ?> /> 
      </div>
      <div class="tf">
        <label>模块描述：</label>
        <div class="inp">
          <textarea name="tbxRemark" cols="50" id="tbxRemark"><?php echo $this->_tpl_vars['objModel']->strModelRemark; ?>
</textarea>
        </div>
      </div>
        <div class="tf tf_submit">
        	<label>&nbsp;</label>
        	<div class="inp">
                <div class="ui_button ui_button_confirm">
                <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
                </div>
                <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=Model&a=ModelList&pid=<?php echo $this->_tpl_vars['pModelID']; ?>
&isAgent=<?php echo $this->_tpl_vars['isAgent']; ?>
')" 
                href="javascript:;">返 回</a>
                </div>
            </div>
    	</div>
    </form>
</div>
<?php echo ' 
<script language="javascript" type="text/javascript">
function v_isNull(e){return $.trim(e)!=\'\';}                                       
new Reg.vf($(\'#form1\'),{extValid:{isNull:v_isNull},callback:function(data){
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
    '; ?>

    var isAgent = <?php echo $this->_tpl_vars['isAgent']; ?>
;
    var formValues = "id=<?php echo $this->_tpl_vars['id']; ?>
&isAgent="+ isAgent +"&"+$('#form1').serialize()+"&productTypes="+productTypes;
    <?php echo ' 
    
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
'; ?>