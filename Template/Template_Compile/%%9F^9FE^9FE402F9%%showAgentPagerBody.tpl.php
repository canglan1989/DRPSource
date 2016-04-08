<?php /* Smarty version 2.6.26, created on 2013-01-29 11:22:48
         compiled from Agent/showAgentPagerBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/showAgentPagerBody.tpl', 18, false),)), $this); ?>
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
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['intention_level']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['intention_level']; ?>
</div></td>     
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['industry_text']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['industry_text']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_reg_area_full_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_reg_area_full_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_person']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_person']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
</div></td>            
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['communicate_number']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['communicate_number']; ?>
</div></td>     
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
</div></td>                                                     
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_channel_user_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arrcheckList']['channel_uid']; ?>
);"><?php echo $this->_tpl_vars['arrcheckList']['agent_channel_user_name']; ?>
</a></div></td>
    <td>
        <div class="ui_table_tdcntr">            
            <ul class="list_table_operation">
                <li><a m="showAgentPager" v="8" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'EditShow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=no&fromType=4');" style="cursor:pointer;">修改</a></li>
                <li><a m="showAgentPager" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentInfo'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&type=2&needCheck=no&fromType=4');" style="cursor:pointer;">查看</a></li>
                <li><a m="showAgentPager" v="16" ispurview="true" href="javascript:;" onclick="IM.agent.agentMove('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'agentmoveshow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
',<?php echo '{}'; ?>
,'转移代理商')" style="cursor:pointer;">转移</a></li>
                <li><a m="showMovePager" v="2" ispurview="true" onclick="JumpPage('/?d=Agent&c=Agent&a=showMovePager&agentNo=<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
');" style="cursor:pointer;">查看流转记录</a></li> 
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>