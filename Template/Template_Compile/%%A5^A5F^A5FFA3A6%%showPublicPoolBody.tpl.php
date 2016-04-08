<?php /* Smarty version 2.6.26, created on 2013-03-08 09:44:07
         compiled from CM/PublicPool/showPublicPoolBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/PublicPool/showPublicPoolBody.tpl', 10, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
    <tr class="">
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><input type="checkbox" value="<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
" name="listid" class="checkInp"><?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php echo $this->_tpl_vars['arr']['customer_id']; ?>
<?php endif; ?></div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><a href="javascript:void(0);"onclick="JumpPage('/?d=CM&c=CMInfo&a=showCustomerDetail&customer_id=<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['customer_name']; ?>
</a><?php else: ?><span  style="color:grey;"><?php echo $this->_tpl_vars['arr']['customer_name']; ?>
</span><?php endif; ?></div></td>      
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php echo $this->_tpl_vars['arr']['industry_name']; ?>
<?php endif; ?></div></td>                               
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php echo $this->_tpl_vars['arr']['area_name']; ?>
<?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php echo $this->_tpl_vars['arr']['customer_resource_cn']; ?>
<?php endif; ?></div></td>                                    
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php echo $this->_tpl_vars['arr']['create_time']; ?>
<?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><a href="javascript:void(0);" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'ContactRecord','a' => 'ContactRecordList'), $this);?>
&customerID=<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['record_count']; ?>
</a><?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php if ($this->_tpl_vars['arr']['last_record_time'] == '0000-00-00 00:00:00'): ?>还未联系<?php else: ?><?php echo $this->_tpl_vars['arr']['last_record_time']; ?>
<?php endif; ?><?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php if ($this->_tpl_vars['arr']['last_to_sea_time'] == '0000-00-00 00:00:00'): ?>未有踢入公海操作<?php else: ?><?php echo $this->_tpl_vars['arr']['last_to_sea_time']; ?>
<?php endif; ?><?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['customer_state'] < 1): ?><?php echo $this->_tpl_vars['arr']['buy_product_name']; ?>
<?php endif; ?></div></td>
        <td>
            <div class="ui_table_tdcntr">
                <?php if ($this->_tpl_vars['arr']['customer_state'] < 2): ?>
                <li><a m="PublicPoolManager" ispurview="true" v="8" onclick="DefendCustomer(<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
)" href="javascript:;">拉取</a></li>
                <?php endif; ?>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>