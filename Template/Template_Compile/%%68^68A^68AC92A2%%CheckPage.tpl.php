<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:29
         compiled from CM/CheckManage/CheckPage.tpl */ ?>
<div class="DContInner">
<div class="bd">           
    <div class="tf">
            <label>审核类型:</label>
            <div class="inp"><?php echo $this->_tpl_vars['CheckType']; ?>
</div>
    </div> 
     <div class="tf">
            <label>审核结果:</label>
            <div class="inp"><?php echo $this->_tpl_vars['CheckStateCN']; ?>
</div>
    </div>    
    <div class="tf">
            <label>审核人:</label>
            <div class="inp"><?php echo $this->_tpl_vars['CheckUser']; ?>
</div>
    </div> 
    <div class="tf">
            <label>审核时间:</label>
            <div class="inp"><?php echo $this->_tpl_vars['CheckTime']; ?>
</div>
    </div> 
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</div>