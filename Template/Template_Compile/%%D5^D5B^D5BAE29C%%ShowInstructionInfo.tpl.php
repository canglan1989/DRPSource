<?php /* Smarty version 2.6.26, created on 2013-01-22 11:33:33
         compiled from Agent/WorkManagement/ShowInstructionInfo.tpl */ ?>
<div class="DContInner">
<div class="bd">           
    <div class="tf">
            <label>批示内容:</label>
            <div class="inp"><?php echo $this->_tpl_vars['instruction']; ?>
</div>
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