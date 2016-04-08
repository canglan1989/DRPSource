<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:20
         compiled from CM/CheckManage/CustomerCheckInfoBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/CheckManage/CustomerCheckInfoBody.tpl', 12, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    <td title="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['customer_id']; ?>
<?php echo '}'; ?>
,'客户基本信息',700)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr" ><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td title="<?php if ($this->_tpl_vars['data']['check_type'] == '1'): ?>新增<?php elseif ($this->_tpl_vars['data']['check_type'] == '2'): ?>编辑<?php else: ?>删除<?php endif; ?>"><div class="ui_table_tdcntr" ><?php if ($this->_tpl_vars['data']['check_type'] == '1'): ?>新增<?php elseif ($this->_tpl_vars['data']['check_type'] == '2'): ?>编辑<?php else: ?>删除<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr" ><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
"><div class="ui_table_tdcntr" ><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
<!--    <td title="<?php echo $this->_tpl_vars['data']['check_user_name']; ?>
"><div class="ui_table_tdcntr" ><?php echo $this->_tpl_vars['data']['check_user_name']; ?>
</div></td>-->
    <td title=""><div class="ui_table_tdcntr">
    <ul class="list_table_operation">
        <li><a m="showVerifyList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMVerify','a' => 'showCHechInfo'), $this);?>
&aid=<?php echo $this->_tpl_vars['data']['aid']; ?>
&posttype=<?php echo $this->_tpl_vars['data']['check_type']; ?>
')">审核</a></li>
      </ul>
      </div>
    </td>    
  </tr>
<?php endforeach; endif; unset($_from); ?>