<?php /* Smarty version 2.6.26, created on 2012-11-12 10:23:44
         compiled from Agent/SignCheckList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/SignCheckList.tpl', 58, false),)), $this); ?>
﻿<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrPactcheckList']):
?>
    <tr>
	<td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['agent_no']; ?>
</div></td>
	<td><div class="ui_table_tdcntr"><a title="<?php echo $this->_tpl_vars['arrPactcheckList']['cur_agent_name']; ?>
" href="javascript:;" onclick="IM.agent.getAgentInfoCard(<?php echo '{'; ?>
'id':<?php echo $this->_tpl_vars['arrPactcheckList']['agent_id']; ?>
<?php echo '}'; ?>
)"><?php echo $this->_tpl_vars['arrPactcheckList']['cur_agent_name']; ?>
</a></div></td>
	<td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPactcheckList']['area_fullname']; ?>
</div></td>
	<td><div class="ui_table_tdcntr">
	    <?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 0): ?>无等级<?php endif; ?>
	    <?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 1): ?>金牌<?php endif; ?>
	    <?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 2): ?>银牌<?php endif; ?>
	</div></td>
	<td title="<?php echo $this->_tpl_vars['arrcheckList']['product_type_name']; ?>
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
	<td>
    <div class="ui_table_tdcntr">
	    <?php if ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 0): ?>
        	未签约
        <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 1): ?>
        	新签
        <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 2): ?>
        	续签
        <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 3): ?>
        	解除签约
        <?php elseif ($this->_tpl_vars['arrPactcheckList']['pact_type'] == 4): ?>
        	失效
        <?php endif; ?>
	</div>
    </td>
    <td>
    <div class="ui_table_tdcntr">
	    <?php if (( $this->_tpl_vars['arrPactcheckList']['agent_level'] == 1 || $this->_tpl_vars['arrPactcheckList']['agent_level'] == 2 ) && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 0): ?>
        	大区总监未审核
        <?php endif; ?>
        <?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 1 && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 1 && $this->_tpl_vars['arrPactcheckList']['channel_check'] == 0): ?>
        	渠道副总未审核
        <?php endif; ?>
        <?php if (( ( $this->_tpl_vars['arrPactcheckList']['agent_level'] == 1 && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 1 && $this->_tpl_vars['arrPactcheckList']['channel_check'] == 1 ) || ( $this->_tpl_vars['arrPactcheckList']['agent_level'] == 2 && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 1 ) ) && $this->_tpl_vars['arrPactcheckList']['contract_check'] == 0): ?>
        	部门审核通过
        <?php endif; ?>
        <?php if (( ( $this->_tpl_vars['arrPactcheckList']['agent_level'] == 1 && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 1 && $this->_tpl_vars['arrPactcheckList']['channel_check'] == 1 ) || ( $this->_tpl_vars['arrPactcheckList']['agent_level'] == 2 && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 1 ) ) && $this->_tpl_vars['arrPactcheckList']['contract_check'] == 1): ?>
        	合同部审核通过
        <?php endif; ?>
        <?php if ($this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 2 || $this->_tpl_vars['arrPactcheckList']['channel_check'] == 2 || $this->_tpl_vars['arrPactcheckList']['contract_check'] == 2): ?>
        	审核退回
        <?php endif; ?>
	</div>
    </td>
    <td>
    <div class="ui_table_tdcntr">
	    <?php echo $this->_tpl_vars['arrPactcheckList']['account_name']; ?>

	</div>
    </td>
	<td>
    <div class="ui_table_tdcntr">
        <ul class="list_table_operation">
        <?php if (( $this->_tpl_vars['arrPactcheckList']['agent_level'] == 1 || $this->_tpl_vars['arrPactcheckList']['agent_level'] == 2 ) && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 0): ?>
            <li>
                <a m="AgentSignedAudit" v="32" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'signCheckShow'), $this);?>
&aid=<?php echo $this->_tpl_vars['arrPactcheckList']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arrPactcheckList']['agent_id']; ?>
&pactType=<?php echo $this->_tpl_vars['arrPactcheckList']['pact_type']; ?>
&checkPerson=bigBoss');">大区总监审核</a>
            </li>
        <?php endif; ?>
       	<?php if ($this->_tpl_vars['arrPactcheckList']['agent_level'] == 1 && $this->_tpl_vars['arrPactcheckList']['bigregion_check'] == 1 && $this->_tpl_vars['arrPactcheckList']['channel_check'] == 0): ?>
            <li>
                <a m="AgentSignedAudit" v="512" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'signCheckShow'), $this);?>
&aid=<?php echo $this->_tpl_vars['arrPactcheckList']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arrPactcheckList']['agent_id']; ?>
&pactType=<?php echo $this->_tpl_vars['arrPactcheckList']['pact_type']; ?>
&checkPerson=bigCeo');">渠道副总审核</a>
            </li>
       	<?php endif; ?>
        </ul>
    </div>
    </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>