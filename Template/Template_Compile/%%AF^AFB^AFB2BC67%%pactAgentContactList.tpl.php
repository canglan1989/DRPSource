<?php /* Smarty version 2.6.26, created on 2012-11-13 14:26:25
         compiled from Agent/pactAgentContactList.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrPactAgent']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['agent_name']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arrPactAgent']['agent_id']; ?>
')" href="javascript:;"><?php echo $this->_tpl_vars['arrPactAgent']['agent_name']; ?>
</a>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['number_of_contacts']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['number_of_contacts']; ?>
</div></td>  
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['e_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['e_name']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['contact_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['contact_name']; ?>
</div></td>                               
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['mobile']; ?>
<?php if ($this->_tpl_vars['arrPactAgent']['tel'] != ''): ?>/<?php echo $this->_tpl_vars['arrPactAgent']['tel']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['contact_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['contact_time']; ?>
</div></td>    
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['create_time']; ?>
</div></td>                                
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['product_type_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['product_type_name']; ?>
</div></td>
    <td title="<?php if ($this->_tpl_vars['arrPactAgent']['is_invite'] == 1): ?>是<?php else: ?>否<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrPactAgent']['is_invite'] == 1): ?>是<?php else: ?>否<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['remark']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['remark']; ?>
</div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>