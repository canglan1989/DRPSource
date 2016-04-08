<?php /* Smarty version 2.6.26, created on 2012-11-28 15:34:49
         compiled from Agent/PurposeGradeList.tpl */ ?>
<tr class="first">
    <td class="first"><div class="ui_table_tdcntr">代理商个数</div></td> 
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['rstA']['0']['A']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['rstA']['0']['B']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['rstA']['0']['C']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['rstA']['0']['D']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['rstA']['0']['E']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['rstA']['0']['qianyue']; ?>
</div></td>
</tr>
<?php $this->assign('step', 0); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key']):
?>
<?php if (( $this->_tpl_vars['step']++ ) % 2 == 0): ?><tr class="odd"><?php else: ?> <tr class="even"><?php endif; ?>
    <td class="first"><div class="ui_table_tdcntr">代理商名称</div></td>
    <td  title="<?php if ($this->_tpl_vars['key']['leval_a'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_a']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['key']['leval_a'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_a']; ?>
<?php endif; ?></div></td>
    <td  title="<?php if ($this->_tpl_vars['key']['leval_b'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_b']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['key']['leval_b'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_b']; ?>
<?php endif; ?></div></td>
    <td  title="<?php if ($this->_tpl_vars['key']['leval_c'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_c']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['key']['leval_c'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_c']; ?>
<?php endif; ?></div></td>
    <td  title="<?php if ($this->_tpl_vars['key']['leval_d'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_d']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['key']['leval_d'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_d']; ?>
<?php endif; ?></div></td>
    <td  title="<?php if ($this->_tpl_vars['key']['leval_e'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_e']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['key']['leval_e'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['leval_e']; ?>
<?php endif; ?></div></td>
    <td  title="<?php if ($this->_tpl_vars['key']['qianyue'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['qianyue']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['key']['qianyue'] == '0'): ?><?php else: ?><?php echo $this->_tpl_vars['key']['qianyue']; ?>
<?php endif; ?></div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>