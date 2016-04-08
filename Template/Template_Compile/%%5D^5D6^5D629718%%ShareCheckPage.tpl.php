<?php /* Smarty version 2.6.26, created on 2013-01-25 10:29:51
         compiled from Agent/ShareCheckPage.tpl */ ?>
<div class="DContInner">
<div class="bd">           
    <div class="tf">
            <label>审核结果:</label>
            <div class="inp"><?php if ($this->_tpl_vars['check_status'] == 1): ?>通过<?php else: ?>不通过<?php endif; ?></div>
    </div> 
     <div class="tf">
            <label>审核备注:</label>
            <div class="inp"><?php echo $this->_tpl_vars['check_remark']; ?>
</div>
    </div>    
    <div class="tf">
            <label>审核人:</label>
            <div class="inp"><?php echo $this->_tpl_vars['e_name']; ?>
<?php echo $this->_tpl_vars['user_name']; ?>
</div>
    </div> 
    <div class="tf">
            <label>审核时间:</label>
            <div class="inp"><?php echo $this->_tpl_vars['check_time']; ?>
</div>
    </div> 
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</div>