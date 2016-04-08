<?php /* Smarty version 2.6.26, created on 2012-11-14 16:02:34
         compiled from FM/Backend/ContractCheckList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'FM/Backend/ContractCheckList.tpl', 17, false),array('function', 'au', 'FM/Backend/ContractCheckList.tpl', 46, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrPactcheckList']):
?>
<tr class="">                                                                       
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard(<?php echo '{'; ?>
'id':<?php echo $this->_tpl_vars['arrPactcheckList']['agent_id']; ?>
<?php echo '}'; ?>
)"><?php echo $this->_tpl_vars['arrPactcheckList']['agent_no']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['cur_agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['cur_agent_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['area_fullname']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['pact_number']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId=<?php echo $this->_tpl_vars['arrPactcheckList']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arrPactcheckList']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['arrPactcheckList']['pact_number']; ?>
</a></div></td>
    <td>
    <div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 0): ?>
    未签约
    <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 1): ?>
    <?php echo $this->_tpl_vars['arrPactcheckList']['pact_stage']; ?>
(新签)
    <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 2): ?>
    <?php echo $this->_tpl_vars['arrPactcheckList']['pact_stage']; ?>
(续签)
    <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 3): ?>
    解除签约
    <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 4 || $this->_tpl_vars['arrPactcheckList']['pact_edate'] < ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d'))): ?>
    <?php echo $this->_tpl_vars['arrPactcheckList']['pact_stage']; ?>
(失效)
    <?php endif; ?>
    </div>
    </td>
    <td title="<?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 0): ?>无等级<?php elseif ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 1): ?>金牌<?php elseif ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 2): ?>银牌<?php endif; ?>">
    <div class="ui_table_tdcntr">
    	<?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 0): ?>无等级<?php endif; ?>
	    <?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 1): ?>金牌<?php endif; ?>
	    <?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 2): ?>银牌<?php endif; ?>
    </div>
    </td> 
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['product_type_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['product_type_name']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['user_name']; ?>
(<?php echo $this->_tpl_vars['arrPactcheckList']['e_name']; ?>
)"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['user_name']; ?>
(<?php echo $this->_tpl_vars['arrPactcheckList']['e_name']; ?>
)</div></td>
    <td title="<?php echo $this->_tpl_vars['arrPactcheckList']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['create_time']; ?>
</div></td>
    <td title="<?php if ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 0): ?>未审核<?php elseif ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 1): ?>审核通过<?php elseif ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 2): ?>审核退回<?php endif; ?>">
    <div class="ui_table_tdcntr">
    	<?php if ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 0): ?>
        	未审核
        <?php elseif ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 1): ?>
        	审核通过
        <?php elseif ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 2): ?>
        	审核退回
        <?php endif; ?>
    </div>
    </td>                                     
    <td>
    	<?php if ($this->_tpl_vars['arrPactcheckList']['contract_check'] == 0): ?>
        <div class="ui_table_tdcntr">
        <a href="javascript:;" m="ContractCheck" v="4" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'signCheckShow'), $this);?>
&aid=<?php echo $this->_tpl_vars['arrPactcheckList']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arrPactcheckList']['agent_id']; ?>
&pactType=<?php echo $this->_tpl_vars['arrPactcheckList']['pact_type']; ?>
&checkPerson=contractManager');">签约审核</a>
        </div>
        <?php endif; ?>
    </td>
</tr> 
<?php endforeach; endif; unset($_from); ?>   