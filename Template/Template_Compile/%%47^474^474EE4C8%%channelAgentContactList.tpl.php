<?php /* Smarty version 2.6.26, created on 2012-12-24 13:57:59
         compiled from Agent/channelAgentContactList.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrChannelAgent']):
?>
<tr>
    <td title=""><div class="ui_table_tdcntr">
    <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['arrChannelAgent']['agent_id']; ?>
"/></div></td>
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['agent_name']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arrChannelAgent']['agent_id']; ?>
')" href="javascript:;"><?php echo $this->_tpl_vars['arrChannelAgent']['agent_name']; ?>
</a>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['number_of_contacts']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['number_of_contacts']; ?>
</div></td> 
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['e_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['e_name']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['contact_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['contact_name']; ?>
</div></td>                               
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['mobile']; ?>
<?php if ($this->_tpl_vars['arrChannelAgent']['tel'] != ''): ?>/<?php echo $this->_tpl_vars['arrChannelAgent']['tel']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['contact_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['contact_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['create_time']; ?>
</div></td>
    <td title="<?php if ($this->_tpl_vars['arrChannelAgent']['is_invite'] == 1): ?>是<?php else: ?>否<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrChannelAgent']['is_invite'] == 1): ?>是<?php else: ?>否<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['remark']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['remark']; ?>
</div></td>                                    
    <td title="<?php echo $this->_tpl_vars['arrChannelAgent']['leval']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrChannelAgent']['leval']; ?>
</div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>