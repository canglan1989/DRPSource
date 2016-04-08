<?php /* Smarty version 2.6.26, created on 2013-01-31 14:47:42
         compiled from Agent/PhoneContactListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Agent/PhoneContactListBody.tpl', 17, false),array('modifier', 'truncate', 'Agent/PhoneContactListBody.tpl', 20, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrPactAgent']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['agent_name']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arrPactAgent']['agent_id']; ?>
')" href="javascript:;"><?php echo $this->_tpl_vars['arrPactAgent']['agent_name']; ?>
</a>
    </div></td>
    <td title="意向等级或签约产品"><div class="ui_table_tdcntr">
      <?php if ($this->_tpl_vars['arrPactAgent']['contact_type'] == 0 && $this->_tpl_vars['arrPactAgent']['afterlevel'] <= 'B+'): ?>
                    <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['arrPactAgent']['id']; ?>
)" ><?php echo $this->_tpl_vars['arrPactAgent']['intertion_product']; ?>
</a>
                <?php else: ?>
                <?php echo $this->_tpl_vars['arrPactAgent']['intertion_product']; ?>

            <?php endif; ?>
    </div></td>  
        
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['visitor']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['visitor']; ?>
</div></td>                               
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['mobile']; ?>
<?php if (! empty ( $this->_tpl_vars['arrPactAgent']['mobile'] ) && ! empty ( $this->_tpl_vars['arrPactAgent']['tel'] )): ?><br /><?php endif; ?><?php echo $this->_tpl_vars['arrPactAgent']['tel']; ?>
</div></td>
    <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrPactAgent']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrPactAgent']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
</div></td> 
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['create_user_name']; ?>
"><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['arrPactAgent']['create_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['arrPactAgent']['create_user_name']; ?>
</a></div></td>     
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactAgent']['create_time']; ?>
</div></td>                                
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['result']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getTelNoteDetail(<?php echo $this->_tpl_vars['arrPactAgent']['id']; ?>
)" ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrPactAgent']['result'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '18', '……') : smarty_modifier_truncate($_tmp, '18', '……')); ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['dynamics']; ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrPactAgent']['dynamics'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '8', '……') : smarty_modifier_truncate($_tmp, '8', '……')); ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactAgent']['verfity_status']; ?>
"><div class="ui_table_tdcntr">
      <?php if ($this->_tpl_vars['arrPactAgent']['verfity_status'] == '通过' || $this->_tpl_vars['arrPactAgent']['verfity_status'] == '不通过'): ?>
            <a onclick="verfityDetail(<?php echo $this->_tpl_vars['arrPactAgent']['id']; ?>
,1)" href="javascript:;"><?php echo $this->_tpl_vars['arrPactAgent']['verfity_status']; ?>
</a>
           <?php else: ?>
           <?php echo $this->_tpl_vars['arrPactAgent']['verfity_status']; ?>

           <?php endif; ?>
     </div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>