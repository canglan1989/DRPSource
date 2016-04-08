<?php /* Smarty version 2.6.26, created on 2012-12-17 14:22:50
         compiled from FM/Backend/PactMoneyInAccountListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'FM/Backend/PactMoneyInAccountListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId=<?php echo $this->_tpl_vars['data']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
');"><?php echo $this->_tpl_vars['data']['pact_no']; ?>
</a></div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)"><?php echo $this->_tpl_vars['data']['agent_no']; ?>
</a></div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['product_type_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['pact_type_text']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_level_text']; ?>
</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['cash_deposit']; ?>
</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['cash_post_money'] != ""): ?>
    <a href="javascript:;" onclick="ViewPostMoneyDetail('<?php echo $this->_tpl_vars['data']['agent_no']; ?>
',1,<?php echo $this->_tpl_vars['data']['product_type_id']; ?>
,'<?php echo $this->_tpl_vars['data']['product_type_name']; ?>
')"><?php echo $this->_tpl_vars['data']['cash_post_money']; ?>
</a>
    <?php endif; ?>
    </div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['cash_money']; ?>
</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['pre_deposit']; ?>
</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['pre_post_money'] != ""): ?>
    <a href="javascript:;" onclick="ViewPostMoneyDetail('<?php echo $this->_tpl_vars['data']['agent_no']; ?>
',2,<?php echo $this->_tpl_vars['data']['product_type_id']; ?>
,'<?php echo $this->_tpl_vars['data']['product_type_name']; ?>
')"><?php echo $this->_tpl_vars['data']['pre_post_money']; ?>
</a>
    <?php endif; ?>
    </div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['pre_money']; ?>
</div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>