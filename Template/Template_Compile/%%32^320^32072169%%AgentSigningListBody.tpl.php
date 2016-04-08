<?php /* Smarty version 2.6.26, created on 2013-01-29 09:57:23
         compiled from Agent/AgentSigningListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AgentSigningListBody.tpl', 5, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrcheckList']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr">
    <a m="AgentList" v="8" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentinfoAddContact'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=yes&isPact=no');" href="javascript:;"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</a>
    <?php if ($this->_tpl_vars['arrcheckList']['share_uid'] != ''): ?><span style="color:red;">(享)</span><?php endif; ?>
    <?php if ($this->_tpl_vars['arrcheckList']['agent_type'] == '核心'): ?><span style="color:red;">(核)</span><?php endif; ?>
    </div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['industry']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['industry']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['pact_product_names']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['pact_product_names']; ?>
</div></td> 
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['share_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['share_name']; ?>
</div></td>                                          
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_type']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_type']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['train_number']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['train_number']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['communicate_number']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['communicate_number']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['last_time']; ?>
<?php if ($this->_tpl_vars['arrcheckList']['last_type'] != ''): ?>(<?php if ($this->_tpl_vars['arrcheckList']['last_type'] == 1): ?>电话<?php else: ?>拜访<?php endif; ?>)<?php endif; ?></div></td>
    
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a  href="javascript:;" onClick="IM.agent.setAgentType('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'setAgentType'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
',<?php echo '{}'; ?>
,'设置代理商类型')">设置类型</a></li>
                <?php if ($this->_tpl_vars['arrcheckList']['channel_uid'] == $this->_tpl_vars['userID'] && ! $this->_tpl_vars['arrcheckList']['share_uid'] && $this->_tpl_vars['arrcheckList']['check_status'] != 0): ?>
                <li><a  href="javascript:;" onClick="setShare(<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
)">共享</a></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['arrcheckList']['channel_uid'] != $this->_tpl_vars['userID'] && $this->_tpl_vars['arrcheckList']['share_uid'] == $this->_tpl_vars['userID']): ?>
                <li><a  href="javascript:;" onClick="cancelShare(<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
)">取消共享</a></li>
                <?php endif; ?>
            </ul>           
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>