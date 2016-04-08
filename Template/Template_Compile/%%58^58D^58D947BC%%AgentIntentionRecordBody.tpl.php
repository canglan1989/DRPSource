<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:46
         compiled from CM/ContactRecord/AgentIntentionRecordBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'CM/ContactRecord/AgentIntentionRecordBody.tpl', 2, false),array('modifier', 'string_format', 'CM/ContactRecord/AgentIntentionRecordBody.tpl', 11, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['customer_id']; ?>
<?php echo '}'; ?>
,'客户基本信息',700)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_visit'] == 0): ?>电话<?php else: ?>拜访<?php endif; ?></div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['intention_rating_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['income_money'] != '0.000'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['income_money'])) ? $this->_run_mod_handler('string_format', true, $_tmp, '%.2f') : smarty_modifier_string_format($_tmp, '%.2f')); ?>
<?php endif; ?></div></td>   
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['income_date'] != '0000-00-00'): ?><?php echo $this->_tpl_vars['data']['income_date']; ?>
<?php endif; ?></div></td> 
    <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['channel_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td> 
</tr>
<?php endforeach; endif; unset($_from); ?>