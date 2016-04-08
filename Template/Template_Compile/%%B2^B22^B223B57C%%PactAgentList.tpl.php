<?php /* Smarty version 2.6.26, created on 2012-12-10 10:14:45
         compiled from Agent/PactAgentList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/PactAgentList.tpl', 4, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrcheckList']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentinfoAddContact'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=yes&isPact=yes');" href="javascript:;"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</a></div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['pact_products']; ?>
</div></td>                                    
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['e_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arrcheckList']['user_id']; ?>
);"><?php echo $this->_tpl_vars['arrcheckList']['e_name']; ?>
(<?php echo $this->_tpl_vars['arrcheckList']['user_name']; ?>
)</a></div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="IM.agent.getAgentCheckInfo(<?php echo '{'; ?>
'id':<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
<?php echo '}'; ?>
);">
    <?php if ($this->_tpl_vars['arrcheckList']['is_check'] == 0): ?>未审核<?php elseif ($this->_tpl_vars['arrcheckList']['is_check'] == 1): ?>审核通过<?php else: ?>审核不通过<?php endif; ?>
    </a>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['contact_num']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['contact_num']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['create_time']; ?>
<br/><?php if ($this->_tpl_vars['arrcheckList']['update_time'] != '' && $this->_tpl_vars['arrcheckList']['update_time'] != '0000-00-00 00:00:00'): ?><?php echo $this->_tpl_vars['arrcheckList']['update_time']; ?>
<?php else: ?>--<?php endif; ?></div></td>
    <td ><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrcheckList']['final_contact_time'] == '' || $this->_tpl_vars['arrcheckList']['final_contact_time'] == '0000-00-00 00:00:00'): ?>--<?php else: ?><?php echo $this->_tpl_vars['arrcheckList']['final_contact_time']; ?>
<?php endif; ?></div></td>
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a m="AgentList" v="8" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentinfoAddContact'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=yes&isPact=yes');" href="javascript:;">联系小记</a></li>
                <li><a m="HighSeasList" v="4" ispurview="true" href="javascript:;" onclick="ToSea(<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
);">踢入公海</a></li>
            </ul>
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>