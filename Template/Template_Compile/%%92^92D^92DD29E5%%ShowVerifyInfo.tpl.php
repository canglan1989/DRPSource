<?php /* Smarty version 2.6.26, created on 2013-01-24 13:03:42
         compiled from Agent/WorkManagement/ShowVerifyInfo.tpl */ ?>
<div class="DContInner">
<div class="bd">           
    <div class="tf">
            <label><?php echo $this->_tpl_vars['content']; ?>
:</label>
            <div class="inp"><?php echo $this->_tpl_vars['record_no']; ?>
</div>
    </div> 
     <div class="tf">
            <label>质检情况:</label>
            <div class="inp"><?php echo $this->_tpl_vars['vertify_remark']; ?>
</div>
    </div>    
    <div class="tf">
            <label>质检结果:</label>
            <div class="inp"><?php if ($this->_tpl_vars['verfity_status'] == 0): ?>不通过<?php endif; ?><?php if ($this->_tpl_vars['verfity_status'] == 1): ?>通过<?php endif; ?></div>
    </div> 
    <div class="tf">
            <label>操作人:</label>
            <div class="inp"><?php echo $this->_tpl_vars['create_user_name']; ?>
</div>
    </div>
    <div class="tf">
            <label>操作时间:</label>
            <div class="inp"><?php echo $this->_tpl_vars['create_time']; ?>
</div>
    </div>
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</div>