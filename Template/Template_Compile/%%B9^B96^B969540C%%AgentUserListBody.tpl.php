<?php /* Smarty version 2.6.26, created on 2013-03-12 11:24:03
         compiled from System/AccountManager/AgentUserListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/AccountManager/AgentUserListBody.tpl', 2, false),array('function', 'au', 'System/AccountManager/AgentUserListBody.tpl', 23, false),array('modifier', 'date_format', 'System/AccountManager/AgentUserListBody.tpl', 20, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
<td><div sort="sort_user_name" class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</div></td>
<td><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
<td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_lock'] == 1): ?><span style="color:#EE5F00;">停用</span><?php else: ?><span style="color:#028100;">正常</span><?php endif; ?></div></td>
<td  title="<?php echo $this->_tpl_vars['data']['dept_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['dept_name']; ?>
</div></td>
<td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_finance'] == 1): ?><span style="color:red">是</span><?php else: ?>否<?php endif; ?></div></td>
<td><div class="ui_table_tdcntr">            
<?php if ($this->_tpl_vars['data']['account_level'] == 1): ?>
<?php echo $this->_tpl_vars['data']['account_level']; ?>
级
<?php else: ?>
<a href="javascript:;" onclick="IM.agent.getTableList('/?d=System&c=AgentUser&a=AccountLevelDetail&id=',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['user_id']; ?>
<?php echo '}'; ?>
,'账号层级信息',400)"><?php echo $this->_tpl_vars['data']['account_level']; ?>
级</a>
<?php endif; ?>            
</div></td>
<td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['phone']; ?>
</div></td>
<td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
<?php if ($this->_tpl_vars['iCanToCRM'] == 1): ?>
<td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['haveToCRM']; ?>
</div></td>
<?php endif; ?>
<td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
<td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    <li><a m="AgentUserList" v="4" ispurview="true" href="javascript:;" onclick="IM.agent.setPWDComfirm(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)">重置密码</a></li>
    <li><a m="AgentUserList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'AgentUser','a' => 'AgentUserModify'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['user_id']; ?>
')">编辑</a></li>
    <li><a m="AgentUserList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'AgentUser','a' => 'AgentUserModify'), $this);?>
&pno=<?php echo $this->_tpl_vars['data']['user_no']; ?>
')">添加下级</a></li>
    <?php if (! ( $this->_tpl_vars['data']['finance_no'] == $this->_tpl_vars['finance_no'] && $this->_tpl_vars['data']['is_finance'] == 1 )): ?>
    <li><a m="AgentUserList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'AgentUser','a' => 'AgentUserDel'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['user_id']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['user_id']; ?>
<?php echo '}'; ?>
,'删除用户',this)">删除</a></li>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['data']['haveToCRM'] == "是"): ?>
    <li><a m="AgentUserList" v="8" ispurview="true" href="javascript:;" onclick="DelCRMUser(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)">删除CRM帐户</a></li>
    <?php endif; ?>
  </ul></div>
</td>            
</tr>
<?php endforeach; endif; unset($_from); ?>