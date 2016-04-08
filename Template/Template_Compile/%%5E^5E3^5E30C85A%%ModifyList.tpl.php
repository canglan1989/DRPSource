<?php /* Smarty version 2.6.26, created on 2012-11-12 10:21:55
         compiled from Agent/ModifyList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/ModifyList.tpl', 39, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrModifyList']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyList']['agent_name']; ?>
</div></td>      
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyList']['area_fullname']; ?>
</div></td>                               
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['charge_person']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyList']['charge_person']; ?>
</div></td>
    <td title="<?php if ($this->_tpl_vars['arrModifyList']['charge_phone'] != '' && $this->_tpl_vars['arrModifyList']['charge_tel'] == ''): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['charge_phone']; ?>

    <?php elseif ($this->_tpl_vars['arrModifyList']['charge_tel'] != '' && $this->_tpl_vars['arrModifyList']['charge_phone'] == ''): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['charge_tel']; ?>

    <?php elseif ($this->_tpl_vars['arrModifyList']['charge_phone'] != '' && $this->_tpl_vars['arrModifyList']['charge_tel'] != ''): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrModifyList']['charge_tel']; ?>

    <?php endif; ?>"><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrModifyList']['charge_phone'] != '' && $this->_tpl_vars['arrModifyList']['charge_tel'] == ''): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['charge_phone']; ?>

    <?php elseif ($this->_tpl_vars['arrModifyList']['charge_tel'] != '' && $this->_tpl_vars['arrModifyList']['charge_phone'] == ''): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['charge_tel']; ?>

    <?php elseif ($this->_tpl_vars['arrModifyList']['charge_phone'] != '' && $this->_tpl_vars['arrModifyList']['charge_tel'] != ''): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrModifyList']['charge_tel']; ?>

    <?php endif; ?>
    </div></td>   
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['create_time']; ?>
<?php if ($this->_tpl_vars['arrModifyList']['update_time'] != '0000-00-00 00:00:00'): ?>/<?php echo $this->_tpl_vars['arrModifyList']['update_time']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyList']['create_time']; ?>
<?php if ($this->_tpl_vars['arrModifyList']['update_time'] != '0000-00-00 00:00:00'): ?>/<?php echo $this->_tpl_vars['arrModifyList']['update_time']; ?>
<?php endif; ?></div></td>                                 
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['cuname']; ?>
(<?php echo $this->_tpl_vars['arrModifyList']['cname']; ?>
)"><div class="ui_table_tdcntr">
    <?php echo $this->_tpl_vars['arrModifyList']['cuname']; ?>

    <?php if ($this->_tpl_vars['arrModifyList']['cname'] != ''): ?>
    (<?php echo $this->_tpl_vars['arrModifyList']['cname']; ?>
)
    <?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['check_time']; ?>
"><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrModifyList']['check_time'] != '0000-00-00 00:00:00'): ?>
    <?php echo $this->_tpl_vars['arrModifyList']['check_time']; ?>

    <?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyList']['uname']; ?>
(<?php echo $this->_tpl_vars['arrModifyList']['uuname']; ?>
)"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyList']['uname']; ?>
(<?php echo $this->_tpl_vars['arrModifyList']['uuname']; ?>
)</div></td>
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a m="showModifyPager" v="4" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showModifyLogList'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrModifyList']['agent_id']; ?>
');" style="cursor:pointer;">修改记录</a></li>
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>