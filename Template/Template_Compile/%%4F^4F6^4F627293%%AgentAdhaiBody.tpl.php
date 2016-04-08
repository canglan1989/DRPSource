<?php /* Smarty version 2.6.26, created on 2012-11-21 14:27:32
         compiled from Agent/ReportManage/AgentAdhaiBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/ReportManage/AgentAdhaiBody.tpl', 10, false),array('modifier', 'date_format', 'Agent/ReportManage/AgentAdhaiBody.tpl', 10, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrReportList']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrReportList']['account_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrReportList']['account_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrReportList']['e_name']; ?>
"><div class="ui_table_tdcntr">
            <?php if (! empty ( $this->_tpl_vars['arrReportList']['user_name'] )): ?>
            <a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['arrReportList']['channel_uid']; ?>
)"><?php echo $this->_tpl_vars['arrReportList']['user_name']; ?>
(<?php echo $this->_tpl_vars['arrReportList']['e_name']; ?>
)</a>
            <?php endif; ?>
        </div></td>      
    <td title="<?php echo $this->_tpl_vars['arrReportList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard(<?php echo '{'; ?>
'id':<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
<?php echo '}'; ?>
)"><?php echo $this->_tpl_vars['arrReportList']['agent_name']; ?>
</a></div></td>                               
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['today_new_count']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'FM','c' => 'UnitInMoney','a' => 'Back_UnitInMoneyList'), $this);?>
&agentNo=<?php echo $this->_tpl_vars['arrReportList']['agent_no']; ?>
&begintime=<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
&endtime=<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
&chargetype=1')"><?php echo $this->_tpl_vars['arrReportList']['today_new_count']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_new_count']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'FM','c' => 'UnitInMoney','a' => 'Back_UnitInMoneyList'), $this);?>
&agentNo=<?php echo $this->_tpl_vars['arrReportList']['agent_no']; ?>
&begintime=<?php echo $this->_tpl_vars['BeginTime']; ?>
&endtime=<?php echo $this->_tpl_vars['EndTime']; ?>
&chargetype=1')"><?php echo $this->_tpl_vars['arrReportList']['month_new_count']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['today_old_count']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'FM','c' => 'UnitInMoney','a' => 'Back_UnitInMoneyList'), $this);?>
&agentNo=<?php echo $this->_tpl_vars['arrReportList']['agent_no']; ?>
&begintime=<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
&endtime=<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
&chargetype=2')"><?php echo $this->_tpl_vars['arrReportList']['today_old_count']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_old_count']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'FM','c' => 'UnitInMoney','a' => 'Back_UnitInMoneyList'), $this);?>
&agentNo=<?php echo $this->_tpl_vars['arrReportList']['agent_no']; ?>
&begintime=<?php echo $this->_tpl_vars['BeginTime']; ?>
&endtime=<?php echo $this->_tpl_vars['EndTime']; ?>
&chargetype=2')"><?php echo $this->_tpl_vars['arrReportList']['month_old_count']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['today_new_money']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
','<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
','<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
','1');"><?php echo $this->_tpl_vars['arrReportList']['today_new_money']; ?>
</a></div></td> 
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_new_money']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
','<?php echo $this->_tpl_vars['BeginTime']; ?>
','<?php echo $this->_tpl_vars['EndTime']; ?>
','1');"><?php echo $this->_tpl_vars['arrReportList']['month_new_money']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['today_old_money']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
','<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
','<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
','2');"><?php echo $this->_tpl_vars['arrReportList']['today_old_money']; ?>
</a></div></td> 
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_old_money']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
','<?php echo $this->_tpl_vars['BeginTime']; ?>
','<?php echo $this->_tpl_vars['EndTime']; ?>
','2');"><?php echo $this->_tpl_vars['arrReportList']['month_old_money']; ?>
</a></div></td> 
</tr>
<?php endforeach; endif; unset($_from); ?>