<?php /* Smarty version 2.6.26, created on 2013-01-23 21:33:22
         compiled from Agent/ExpectMoneyListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/ExpectMoneyListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td ><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)"><?php echo $this->_tpl_vars['data']['agent_no']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>   
    <td ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['channel_uid']; ?>
);" href="javascript:;"><?php echo $this->_tpl_vars['data']['agent_channel_user_name']; ?>
</a></div></td>
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['account_name']; ?>
</div></td>
    <td class="TA_r" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['expect_money']; ?>
</div></td>
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['expect_time']; ?>
</div></td>                                 
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['expect_type_text']; ?>
</div></td>
    <td class="TA_r" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['charge_percentage']; ?>
</div></td>
    <td ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
);" href="javascript:;"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
    <td ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>