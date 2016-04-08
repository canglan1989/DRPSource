<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:37
         compiled from CM/CheckManage/ContactCheckInfoBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/CheckManage/ContactCheckInfoBody.tpl', 13, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    <td title="<?php echo $this->_tpl_vars['data']['contact_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['contact_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showConatctCard(<?php echo $this->_tpl_vars['data']['contact_id']; ?>
)"><?php echo $this->_tpl_vars['data']['contact_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['contact_position']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_position']; ?>
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
        <li><a m="ContractCheckBack" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMVerify','a' => 'showEditContactCheck'), $this);?>
&aid=<?php echo $this->_tpl_vars['data']['aid']; ?>
')">审核</a></li>
      </ul>
      </div>
    </td>    
  </tr>
<?php endforeach; endif; unset($_from); ?>