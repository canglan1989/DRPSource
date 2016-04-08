<?php /* Smarty version 2.6.26, created on 2012-11-19 11:43:18
         compiled from Agent/MoveList.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrAgentList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrcheckList']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
</div></td>                               
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['funame']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['funame']; ?>
(<?php echo $this->_tpl_vars['arrcheckList']['fname']; ?>
)</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['tuname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['tuname']; ?>
(<?php echo $this->_tpl_vars['arrcheckList']['tname']; ?>
)</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['cname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['cname']; ?>
(<?php echo $this->_tpl_vars['arrcheckList']['cuname']; ?>
)</div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>