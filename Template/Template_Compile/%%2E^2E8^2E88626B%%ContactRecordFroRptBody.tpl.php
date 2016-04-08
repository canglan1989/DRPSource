<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:53
         compiled from CM/ContactRecordFroRptBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'CM/ContactRecordFroRptBody.tpl', 8, false),array('modifier', 'cat', 'CM/ContactRecordFroRptBody.tpl', 8, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    
    <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr" ><a onclick = "UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;" ><?php echo $this->_tpl_vars['data']['user_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['valid_count']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == 0): ?><a href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,1)"><?php echo $this->_tpl_vars['data']['valid_count']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['valid_count']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['invalid_count']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == 0): ?><a href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,2)"><?php echo $this->_tpl_vars['data']['invalid_count']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['invalid_count']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['record_count']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == 0): ?><a href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,3)"><?php echo $this->_tpl_vars['data']['record_count']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['record_count']; ?>
<?php endif; ?></div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['valid_rate']*100)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%2.2f") : smarty_modifier_string_format($_tmp, "%2.2f")))) ? $this->_run_mod_handler('cat', true, $_tmp, "%") : smarty_modifier_cat($_tmp, "%")); ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['visit_count']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == 0): ?><a href="javascript:;" onclick="ShowVisitDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)"><?php echo $this->_tpl_vars['data']['visit_count']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['visit_count']; ?>
<?php endif; ?></div></td>
    
  </tr>
<?php endforeach; endif; unset($_from); ?>