<?php /* Smarty version 2.6.26, created on 2012-11-27 14:38:03
         compiled from FM/Backend/AccountMoneyInOutListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'FM/Backend/AccountMoneyInOutListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayAccountDetail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['account_detail_no']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><a onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId=<?php echo $this->_tpl_vars['data']['agent_pact_id']; ?>
&agentId=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
');" href="javascript:;"><?php echo $this->_tpl_vars['data']['agent_pact_no']; ?>
</a></div></td>
    <td><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['source_bill_no'] != ""): ?>
    <?php echo $this->_tpl_vars['data']['source_bill_no']; ?>

    <?php else: ?>--<?php endif; ?></div></td>   
    <td><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['agent_no']; ?>
</a>
    <br /><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['account_type']; ?>
</div></td>
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['product_type_name']; ?>
</div></td>               
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['data_type']; ?>
</div></td>            
    <td class="TA_r"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['rev_money'] != 0): ?><?php echo $this->_tpl_vars['data']['rev_money']; ?>
<?php else: ?>--<?php endif; ?></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['pay_money'] != 0): ?><?php echo $this->_tpl_vars['data']['pay_money']; ?>
<?php else: ?>--<?php endif; ?></div></td>  
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>  
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['act_date']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['remark']; ?>
</div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>