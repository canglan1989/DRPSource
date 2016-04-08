<?php /* Smarty version 2.6.26, created on 2012-11-29 10:23:14
         compiled from System/ModelManager/ModelRightModify.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
    <div id="J_table_filter_main" class="table_filter_main"> 
        <div class="table_filter_main_row">
        模块名：<a href="javascript:;" onclick="JumpPage('/?d=System&c=ModelRight&a=ModelRightList&mid=<?php echo $this->_tpl_vars['modelID']; ?>
',true,true)"><?php echo $this->_tpl_vars['objModelInfo']->strModelName; ?>
</a>
        </div>
    </div>
</div>
<!--E table_filter-->
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
    “<em class="require">*</em>”为必填信息
    </span>
</div>
<div class="form_bd">
    <form action="" method="post" name="form1" id="form1">  
      <div class="tf" style="padding-top:20px;">
        <label><em class="require">*</em>权限值：</label>
        <div class="inp">
          <select name="cbRightValue" id="cbRightValue" style="width:160px">
            <?php $_from = $this->_tpl_vars['arrayRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
            <option value="<?php echo $this->_tpl_vars['data']; ?>
" <?php if ($this->_tpl_vars['objModelRight']->iRightValue == $this->_tpl_vars['data']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['data']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>权限名：</label>
        <div class="inp"><input name="tbxRightName" type="text" id="tbxRightName" size="30" style="width:160px;" maxlength="30"  value="<?php echo $this->_tpl_vars['objModelRight']->strRightName; ?>
"   valid="required isNull" /></div>
        <span class="info">请输入实际意义的权限名称</span>
        <span class="ok">&nbsp;</span><span class="err">请输入实际意义的权限名称</span>
      </div>
      <div class="tf">
        <label>关闭此权限：</label>
        <input name="chkIsLock" class="checkInp" id="chkIsLock" type="checkbox" value="1" <?php if ($this->_tpl_vars['objModelRight']->iIsLock == 1): ?> checked='checked' <?php endif; ?> /> </div>
      <div class="tf">
        <label>权限描述：</label>
        <div class="inp">
          <textarea name="tbxRemark" cols="50" id="tbxRemark"><?php echo $this->_tpl_vars['objModelRight']->strRightRemark; ?>
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
                <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=ModelRight&a=ModelRightList&mid=<?php echo $this->_tpl_vars['modelID']; ?>
')" href="javascript:;">返 回</a>
            </div>
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
        '; ?>
 
        var mid = <?php echo $this->_tpl_vars['modelID']; ?>
;
        //提交数据
        var formValues = "id=<?php echo $this->_tpl_vars['id']; ?>
&mid=" + mid+"&"+$('#form1').serialize();
        <?php echo ' 
        _InDealWith = true;
        var data = $PostData("/?d=System&c=ModelRight&a=ModelRightModifySubmit&mid="+mid,formValues);
        
        if(parseInt(data) != 0)
        {
            IM.tip.warn(data); 
            _InDealWith = false;
        }
        else
            JumpPage("/?d=System&c=ModelRight&a=ModelRightList&mid=" + mid);            
    }});
    </script> 
  '; ?>