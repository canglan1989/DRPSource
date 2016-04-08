<?php /* Smarty version 2.6.26, created on 2013-01-16 16:58:11
         compiled from System/AccountManager/Back_AgentUserListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/AccountManager/Back_AgentUserListBody.tpl', 2, false),array('function', 'au', 'System/AccountManager/Back_AgentUserListBody.tpl', 18, false),array('modifier', 'date_format', 'System/AccountManager/Back_AgentUserListBody.tpl', 12, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_no']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['product_type_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['pact_sdate']; ?>
/<?php echo $this->_tpl_vars['data']['pact_edate']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['user_id'] == 0): ?>无<?php else: ?><?php echo $this->_tpl_vars['data']['user_name']; ?>
<?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['user_id'] != 0): ?><?php echo $this->_tpl_vars['data']['e_name']; ?>
<?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['user_id'] != 0): ?><?php echo $this->_tpl_vars['data']['phone']; ?>
<?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['user_id'] != 0): ?><?php echo $this->_tpl_vars['data']['tel']; ?>
<?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['user_id'] == 0): ?><span style="color:#EE5F00;">未开通</span><?php else: ?><?php if ($this->_tpl_vars['data']['is_lock'] == 0): ?><span style="color:#028100;">正常</span><?php else: ?><span style="color:#EE5F00;">关闭</span><?php endif; ?><?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['user_id'] == 0): ?>无<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
<?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    <?php if ($this->_tpl_vars['data']['user_id'] == 0): ?>
	<li><a m="Back_AgentUserList" v="4" ispurview="true"  onclick="JumpPage('/?d=System&c=AgentUser&a=createAccountShow&agentid=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
');" style="cursor:pointer;">账户开通</a></li>
    <?php else: ?>
    <li><a m="Back_AgentUserList" v="16" ispurview="true" href="javascript:;" onclick="IM.agent.setPWDComfirm('<?php echo $this->_tpl_vars['data']['user_id']; ?>
')">重置密码</a></li>
    <li><a m="Back_AgentUserList" v="8" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'AgentUser','a' => 'createAccountShow'), $this);?>
&agentid=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
');" style="cursor:pointer;">编辑</a></li>
    <li><a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AgentPactChild','id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
','查看子账户')">子账号</a></li>
    <?php endif; ?>
      </ul></div>
    </td>            
  </tr>
<?php endforeach; endif; unset($_from); ?>