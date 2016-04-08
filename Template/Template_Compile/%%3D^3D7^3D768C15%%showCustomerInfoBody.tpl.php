<?php /* Smarty version 2.6.26, created on 2013-03-08 09:44:58
         compiled from CM/PublicPool/showCustomerInfoBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/PublicPool/showCustomerInfoBody.tpl', 9, false),array('modifier', 'date_format', 'CM/PublicPool/showCustomerInfoBody.tpl', 14, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
    <tr class="">
        <td title=""><div class="ui_table_tdcntr"><input type="checkbox" value="<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
" name="listid" class="checkInp"></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['customer_id']; ?>
</div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:void(0);"onclick="JumpPage('/?d=CM&c=CMInfo&a=showCustomerDetail4CustomerInfo&customer_id=<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['customer_name']; ?>
</a></div></td>      
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['area_name']; ?>
</div></td>                               
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['industry_name']; ?>
</div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['customer_resource_cn']; ?>
</div></td>                                    
        <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['log_check'] > -2): ?><a href="javascript:void(0);" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMModify','a' => 'showModifyHistroyList'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
&agentid=<?php echo $this->_tpl_vars['AgentID']; ?>
')"><?php echo $this->_tpl_vars['arr']['check_status_cn']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['arr']['check_status_cn']; ?>
<?php endif; ?></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['create_time']; ?>
</div></td>
        <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'ContactRecord','a' => 'ContactRecordList'), $this);?>
&customerID=<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
')"><?php echo $this->_tpl_vars['arr']['record_count']; ?>
</a></div></td>
        <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['is_shield']; ?>
</div></td>
        <td title=""><div class="ui_table_tdcntr">
                <?php if ($this->_tpl_vars['arr']['to_sea_time'] < ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S'))): ?>
                    公海客户
                <?php else: ?>
                    <a href="javascript:void(0);" onclick="UserDetial(<?php echo $this->_tpl_vars['arr']['user_id']; ?>
)"><?php echo $this->_tpl_vars['arr']['user_info']; ?>
</a></div></td>
                <?php endif; ?>
                
        <td>
            <div class="ui_table_tdcntr">
                <li><a m="CustomerInfo" ispurview="true" v="16" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showModifyFront'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['arr']['customer_id']; ?>
')" href="javascript:;">编辑</a></li>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>