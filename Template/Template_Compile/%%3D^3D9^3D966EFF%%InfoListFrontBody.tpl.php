<?php /* Smarty version 2.6.26, created on 2013-03-08 09:43:06
         compiled from CM/InfoListFrontBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/InfoListFrontBody.tpl', 5, false),array('modifier', 'truncate', 'CM/InfoListFrontBody.tpl', 15, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    <td><div class="ui_table_tdcntr"><input class="checkInp" type="checkbox" value="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
" name="listid"/></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>   
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showDetailFront'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['data']['customer_id']; ?>
')"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a></div></td>    
    <td title="<?php echo $this->_tpl_vars['data']['industry_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['industry_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['area_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['area_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_resource_cn']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_resource_cn']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><a onclick="showCheckStatus('<?php echo $this->_tpl_vars['data']['customer_id']; ?>
')" href="javascript:;"><?php echo $this->_tpl_vars['data']['check_status_cn']; ?>
</a></div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['record_count']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['last_time']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['defend_state_cn']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['intention_rating_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['last_record_time'] != '0000-00-00 00:00:00'): ?><?php echo $this->_tpl_vars['data']['last_record_time']; ?>
<?php else: ?>--<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['last_record_content']; ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['last_record_content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '50', "……") : smarty_modifier_truncate($_tmp, '50', "……")); ?>
</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
    <?php if ($this->_tpl_vars['data']['history_check'] == '1'): ?>
    <?php if ($this->_tpl_vars['valueProduct'] == 1): ?>
      <li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showCustomerOrderFront'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['data']['customer_id']; ?>
')" >提交增值产品订单</a></li>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['unitProduct'] == 1): ?>
      <li><a m="UnitOrderModify" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'OM','c' => 'Order','a' => 'UnitOrderPostStep1'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['data']['customer_id']; ?>
')" >提交网盟订单</a></li>
      <?php endif; ?>
      <?php endif; ?>
      <li><a onclick="showAddContactRecode(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)" href="javascript:;">添加联系小记</a></li>
      <li><a onclick="showAddVisitInvite(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)" href="javascript:;">添加拜访预约</a></li>
      </ul>
      </div>
    </td>    
  </tr>
<?php endforeach; endif; unset($_from); ?>