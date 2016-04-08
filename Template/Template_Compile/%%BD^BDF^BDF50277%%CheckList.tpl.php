<?php /* Smarty version 2.6.26, created on 2013-01-24 19:02:22
         compiled from Agent/CheckList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/CheckList.tpl', 48, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrcheckList']):
?>
<?php if ($this->_tpl_vars['arrcheckList']['operate_type'] == 2 && $this->_tpl_vars['arrcheckList']['is_check'] == 2): ?>
<?php else: ?>
<tr>
    <!--<td title=""><div class="ui_table_tdcntr">
    	<input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['arrcheckList']['aid']; ?>
"/></div>
    </td>-->
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['area_fullname']; ?>
</div>                    
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_person']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_person']; ?>
</div></td>              				
    <td title="<?php if ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_tel'] != '' && $this->_tpl_vars['arrcheckList']['charge_phone'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] != ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php endif; ?>">
    <div class="ui_table_tdcntr">			
    
    <?php if ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_tel'] != '' && $this->_tpl_vars['arrcheckList']['charge_phone'] == ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php elseif ($this->_tpl_vars['arrcheckList']['charge_phone'] != '' && $this->_tpl_vars['arrcheckList']['charge_tel'] != ''): ?>
    <?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>

    <?php endif; ?>
    
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['e_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['user_name']; ?>
<?php if ($this->_tpl_vars['arrcheckList']['e_name'] != ''): ?>(<?php echo $this->_tpl_vars['arrcheckList']['e_name']; ?>
)<?php endif; ?></div></td>                                    
    <td>
        <div class="ui_table_tdcntr">
            
            <?php if ($this->_tpl_vars['arrcheckList']['check_type'] == 0): ?>
            企业新增
            <?php elseif ($this->_tpl_vars['arrcheckList']['check_type'] == 1): ?>
            企业修改
            <?php elseif ($this->_tpl_vars['arrcheckList']['check_type'] == 2): ?>
            企业删除
            <?php endif; ?>
            
        </div>
    </td>
    <td title=" "><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['create_time']; ?>
</div></td>
    <td>
        <div class="ui_table_tdcntr">            
            <ul class="list_table_operation">
                <li><a m="AgentCheckList" v="4" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentDetail'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&operaType=<?php echo $this->_tpl_vars['arrcheckList']['operate_type']; ?>
&checkId=<?php echo $this->_tpl_vars['arrcheckList']['aid']; ?>
');" style="cursor:pointer;">审核</a></li>
            </ul>            
        </div>
    </td>
</tr>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>