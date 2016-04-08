<?php /* Smarty version 2.6.26, created on 2012-12-17 14:22:30
         compiled from System/AccountManager/AgentPactCh.tpl */ ?>
﻿<div id="J_ui_table" class="ui_table">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead class="ui_table_hd">
          <tr>
            <th style="width:100px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">账号名</div>
              </div></th>
            <th style="width:100px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">账号层级</div>
              </div></th>
            <th style="width:80px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">状态</div>
              </div></th>      
          </tr>
        </thead>
        <tbody class="ui_table_bd" id="pageListContent">
             <?php $_from = $this->_tpl_vars['arrayAgentPacthCh']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
              <tr>
                <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</div></td>
                <td title="<?php echo $this->_tpl_vars['data']['account_level']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['account_level']; ?>
级</div></td>
                <td><div class="ui_table_tdcntr" ><?php if ($this->_tpl_vars['data']['is_lock'] == 1): ?>关闭<?php else: ?><span style="color:#028100;">正常</span><?php endif; ?></div></td>
              </tr>
            <?php endforeach; endif; unset($_from); ?>
        </tbody>
  </table>
  <!--
<div class="ft">
      
<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
 </div>-->
</div>