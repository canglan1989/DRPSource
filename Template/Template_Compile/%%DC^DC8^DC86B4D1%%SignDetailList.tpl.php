<?php /* Smarty version 2.6.26, created on 2013-01-24 19:01:40
         compiled from Agent/SignDetailList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/SignDetailList.tpl', 2, false),array('function', 'au', 'Agent/SignDetailList.tpl', 7, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['arr']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title=""><div class="ui_table_tdcntr">
        <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['arr']['aid']; ?>
"/></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['agent_no']; ?>
</div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['cur_agent_name']; ?>
</a></div></td>
        <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'singleSignDetail'), $this);?>
&pactId=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
');"><?php echo $this->_tpl_vars['arr']['pact_number']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['export_pact_type']; ?>
</div> </td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['agent_reg_area_full_name']; ?>
</div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['pact_product_names']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['agent_type_text']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['export_agent_level']; ?>
</div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['pact_sdate']; ?>
至<?php echo $this->_tpl_vars['arr']['pact_edate']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['export_pact_status']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><a onclick="IM.agent.getSubmittedBy('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'showPactCheckInfoCard'), $this);?>
&aid=<?php echo $this->_tpl_vars['arr']['aid']; ?>
','','审核状态',900)" href="javascript:;"><?php echo $this->_tpl_vars['arr']['export_liucheng_status']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['money_received']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arr']['create_uid']; ?>
);"><?php echo $this->_tpl_vars['arr']['create_user_name']; ?>
</a></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['account_name']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['create_time']; ?>
</div></td>   
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a m="SignDetail" v="16" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'EachsignDetialPager'), $this);?>
&aid=<?php echo $this->_tpl_vars['arr']['aid']; ?>
&agentId=<?php echo $this->_tpl_vars['arr']['agent_id']; ?>
');">签约记录</a></li>
                    <?php if ($this->_tpl_vars['arr']['pact_status'] == 2): ?>
                            <li><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PactMoneyInAccountList&productID=<?php echo $this->_tpl_vars['arr']['product_id']; ?>
&agentNo=<?php echo $this->_tpl_vars['arr']['agent_no']; ?>
');">款项到帐状态</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>