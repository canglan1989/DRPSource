<?php /* Smarty version 2.6.26, created on 2012-11-09 18:22:40
         compiled from Agent/ListDataBank.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/ListDataBank.tpl', 31, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrcheckList']):
?>
<tr>
    <td title=""><div class="ui_table_tdcntr">
    <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
"/></div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['leval']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['leval']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_person']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_person']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['user_name']; ?>
(<?php echo $this->_tpl_vars['arrcheckList']['e_name']; ?>
)"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arrcheckList']['user_id']; ?>
);"><?php echo $this->_tpl_vars['arrcheckList']['user_name']; ?>
(<?php echo $this->_tpl_vars['arrcheckList']['e_name']; ?>
)</a></div></td>
    <td title="<?php if ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_tel'] != '' && $this->_tpl_vars['arrcheckList']['charge_phone'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] != ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php endif; ?>"><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_tel'] != '' && $this->_tpl_vars['arrcheckList']['charge_phone'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] != ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php endif; ?>
    </div></td>
    <td title="2010-11-10"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrcheckList']['check_time'] != '0000-00-00 00:00:00'): ?><?php echo $this->_tpl_vars['arrcheckList']['check_time']; ?>
<?php endif; ?></div></td>                                                                        
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a m="showAgentPager" v="8" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'EditShow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=no&fromType=4');" style="cursor:pointer;">修改</a></li>
                <li><a m="showAgentPager" v="2" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentInfo'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&type=2&needCheck=no&fromType=4');" style="cursor:pointer;">查看</a></li>  
                <li><a m="showAgentPager" v="16" ispurview="true" href="javascript:;" onClick="IM.agent.agentMove('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'agentmoveshow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
',<?php echo '{}'; ?>
,'转移代理商')" class="ui_button">转移代理商</a></li>                          
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>