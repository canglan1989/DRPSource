<?php /* Smarty version 2.6.26, created on 2012-11-21 14:42:40
         compiled from Agent/ReportManage/AgentAdhaiOldReportBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/ReportManage/AgentAdhaiOldReportBody.tpl', 14, false),)), $this); ?>
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
    
    <td title="<?php echo $this->_tpl_vars['arrReportList']['begin_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrReportList']['begin_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrReportList']['end_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrReportList']['end_time']; ?>
</div></td>
    
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_new_count']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'FM','c' => 'UnitInMoney','a' => 'Back_UnitInMoneyList'), $this);?>
&agentNo=<?php echo $this->_tpl_vars['arrReportList']['agent_no']; ?>
&chargetype=1&begintime=<?php echo $this->_tpl_vars['arrReportList']['begin_time']; ?>
&endtime=<?php echo $this->_tpl_vars['arrReportList']['end_time']; ?>
')"><?php echo $this->_tpl_vars['arrReportList']['month_new_count']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_new_money']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
','<?php echo $this->_tpl_vars['arrReportList']['begin_time']; ?>
','<?php echo $this->_tpl_vars['arrReportList']['end_time']; ?>
','1');"><?php echo $this->_tpl_vars['arrReportList']['month_new_money']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_old_count']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'FM','c' => 'UnitInMoney','a' => 'Back_UnitInMoneyList'), $this);?>
&agentNo=<?php echo $this->_tpl_vars['arrReportList']['agent_no']; ?>
&chargetype=2&begintime=<?php echo $this->_tpl_vars['arrReportList']['begin_time']; ?>
&endtime=<?php echo $this->_tpl_vars['arrReportList']['end_time']; ?>
')"><?php echo $this->_tpl_vars['arrReportList']['month_old_count']; ?>
</a></div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['arrReportList']['month_old_money']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showMoneyDialog('<?php echo $this->_tpl_vars['arrReportList']['agent_id']; ?>
','<?php echo $this->_tpl_vars['arrReportList']['begin_time']; ?>
','<?php echo $this->_tpl_vars['arrReportList']['end_time']; ?>
','2');"><?php echo $this->_tpl_vars['arrReportList']['month_old_money']; ?>
</a></div></td>
    
</tr>
<?php endforeach; endif; unset($_from); ?>