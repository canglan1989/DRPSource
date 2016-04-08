<?php /* Smarty version 2.6.26, created on 2012-12-17 14:24:57
         compiled from Agent/PactMoveListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/PactMoveListBody.tpl', 4, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
    <tr class="">
        
        <td title="<?php echo $this->_tpl_vars['arr']['pact_number']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'singleSignDetail'), $this);?>
&pactId=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
');"><?php echo $this->_tpl_vars['arr']['pact_number']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['arr']['cur_agent_name']; ?>
" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['cur_agent_name']; ?>
</a></div></td>        
       
        
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arr']['old_id']; ?>
);"><?php echo $this->_tpl_vars['arr']['old_ename']; ?>
<?php echo $this->_tpl_vars['arr']['old_username']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arr']['new_id']; ?>
);"><?php echo $this->_tpl_vars['arr']['new_ename']; ?>
<?php echo $this->_tpl_vars['arr']['new_username']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arr']['create_uid']; ?>
);"><?php echo $this->_tpl_vars['arr']['e_name']; ?>
<?php echo $this->_tpl_vars['arr']['user_name']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['create_time']; ?>
</div></td>   
        
    </tr>
<?php endforeach; endif; unset($_from); ?>