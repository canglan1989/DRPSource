<?php /* Smarty version 2.6.26, created on 2012-11-09 18:34:53
         compiled from Agent/MySignList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Agent/MySignList.tpl', 27, false),array('modifier', 'escape', 'Agent/MySignList.tpl', 77, false),array('function', 'au', 'Agent/MySignList.tpl', 37, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
    <tr class="">
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['agent_no']; ?>
</div></td>
        <td class="TA_l" title="<?php echo $this->_tpl_vars['arr']['cur_agent_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['cur_agent_name']; ?>
</a></div></td>
        <td class="TA_l"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['area_fullname']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['arr']['product_type_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['product_type_name']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['product_mode'] == 0): ?>渠道代理<?php else: ?>渠道商务<?php endif; ?></div></td>
        <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['agent_level'] == 0): ?>无等级<?php elseif ($this->_tpl_vars['arr']['agent_level'] == 1): ?>金牌<?php else: ?>银牌<?php endif; ?></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['pact_sdate']; ?>
至<?php echo $this->_tpl_vars['arr']['pact_edate']; ?>
</div></td>                       
        <td>
        <div class="ui_table_tdcntr">
        <?php echo $this->_tpl_vars['arr']['pact_number']; ?>

        </div>
        </td>
        <td>
        <div class="ui_table_tdcntr">
        <?php if ($this->_tpl_vars['arr']['pact_type'] == 0): ?>
        未签约
        <?php elseif ($this->_tpl_vars['arr']['pact_type'] == 1): ?>
        <?php echo $this->_tpl_vars['arr']['pact_stage']; ?>
(新签)
        <?php elseif ($this->_tpl_vars['arr']['pact_type'] == 2): ?>
        <?php echo $this->_tpl_vars['arr']['pact_stage']; ?>
(续签)
        <?php elseif ($this->_tpl_vars['arr']['pact_type'] == 3): ?>
        解除签约
        <?php elseif ($this->_tpl_vars['arr']['pact_type'] == 4): ?>
        <?php echo $this->_tpl_vars['arr']['pact_stage']; ?>
(已失效)
        <?php elseif ($this->_tpl_vars['arr']['pact_edate'] <= ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d"))): ?>
        <?php echo $this->_tpl_vars['arr']['pact_stage']; ?>
(已失效)
        <?php endif; ?>
        </div>
        </td>
        <td>
        <div class="ui_table_tdcntr">
        <?php if ($this->_tpl_vars['arr']['pact_status'] == 0): ?>
        未提交
        <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 1): ?>
        <a onclick="IM.agent.getSubmittedBy('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'showPactCheckInfoCard'), $this);?>
&aid=<?php echo $this->_tpl_vars['arr']['aid']; ?>
','','审核状态',900)" href="javascript:;">流程中</a>
        <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 4 || $this->_tpl_vars['arr']['pact_edate'] < ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d"))): ?>
        已失效
        <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 2): ?>
        已签约
        <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 3): ?>
        已解除签约
        <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 5): ?>
        保存
        <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 6): ?>
        审核退回
        <?php endif; ?>
        </div>
        </td>
        <td title="<?php echo $this->_tpl_vars['arr']['e_name']; ?>
<?php echo $this->_tpl_vars['arr']['user_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arr']['create_uid']; ?>
);"><?php echo $this->_tpl_vars['arr']['e_name']; ?>
<?php echo $this->_tpl_vars['arr']['user_name']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['create_time']; ?>
</div></td>                        
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <?php if ($this->_tpl_vars['arr']['pact_status'] == 0 || $this->_tpl_vars['arr']['pact_status'] == 5 || $this->_tpl_vars['arr']['pact_status'] == 6): ?>
                        <li><a m="mySigned" v="4" ispurview="true" href="javascript:;" onclick="<?php if ($this->_tpl_vars['arr']['pact_type'] == 2): ?>JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'EditRenewalInfo'), $this);?>
<?php else: ?>JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'EditSignInfo'), $this);?>
<?php endif; ?>&pactId=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
');">编辑</a></li>
                    <?php elseif ($this->_tpl_vars['arr']['pact_status'] == 4 || $this->_tpl_vars['arr']['pact_edate'] <= ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d"))): ?>
                    	<li><a m="mySigned" v="128" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'singleSignDetail'), $this);?>
&pactId=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
&pactType=<?php echo $this->_tpl_vars['arr']['pact_type']; ?>
&pactStatus=<?php echo $this->_tpl_vars['arr']['pact_status']; ?>
');">签约详情</a></li>
                    <?php else: ?>
                    
                        <?php if ($this->_tpl_vars['arr']['post_money_id'] > 0): ?>
                            <?php if ($this->_tpl_vars['arr']['post_money_state'] == 0): ?>
                            <li><a m="mySigned" v="32" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyModify&agentID=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
&id=<?php echo $this->_tpl_vars['arr']['post_money_id']; ?>
')">编辑打款</a></li>
                            <?php endif; ?>
                            <li><a m="mySigned" v="64" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=SignedPayMoneyDetail&id=<?php echo $this->_tpl_vars['arr']['post_money_id']; ?>
')">打款明细</a></li>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['arr']['pact_status'] == 2): ?>
                            <li><a m="mySigned" v="32" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyModify&agentID=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
')">提交打款</a></li>
                            <li><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PactMoneyInAccountList&productID=<?php echo $this->_tpl_vars['arr']['product_id']; ?>
&agentNo=<?php echo $this->_tpl_vars['arr']['agent_no']; ?>
');">款项状态</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['arr']['pact_type'] == 1 || $this->_tpl_vars['arr']['pact_type'] == 2): ?>
                        <li><a m="mySigned" v="256" ispurview="true" href="javascript:;" onclick="RemoveSign(<?php echo $this->_tpl_vars['arr']['aid']; ?>
,'<?php echo $this->_tpl_vars['arr']['pact_number']; ?>
<?php echo $this->_tpl_vars['arr']['pact_stage']; ?>
','<?php echo $this->_tpl_vars['arr']['cur_agent_name']; ?>
')">解除签约</a></li>
                        <?php endif; ?>
                        <li><a m="mySigned" v="128" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'singleSignDetail'), $this);?>
&pactId=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
&pactType=<?php echo $this->_tpl_vars['arr']['pact_type']; ?>
&pactStatus=<?php echo $this->_tpl_vars['arr']['pact_status']; ?>
');">签约详情</a></li>
                        <!--<li><a m="mySigned" v="256" ispurview="true" href="javascript:;" onclick="IM.agent.addReplenish('/?d=Agent&c=AgentReplenish&a=Replenish&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
&pactId=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&strAgent=<?php echo ((is_array($_tmp=$this->_tpl_vars['arr']['cur_agent_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&strPactNo=<?php echo ((is_array($_tmp=$this->_tpl_vars['arr']['pact_number'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
','代理商合同补签',<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
,<?php echo $this->_tpl_vars['arr']['aid']; ?>
);">补签</a></li>-->
                    <?php endif; ?>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>