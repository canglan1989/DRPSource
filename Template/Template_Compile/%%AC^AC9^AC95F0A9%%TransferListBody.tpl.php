<?php /* Smarty version 2.6.26, created on 2013-01-11 15:33:24
         compiled from CM/TransferListBody.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    <td title="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['customer_id']; ?>
<?php echo '}'; ?>
,'客户基本信息',700)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['industry_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['industry_fullname']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['area_fullname']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['product_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['product_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['ag_out_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['ag_out_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_out_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_out_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['ag_in_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['ag_in_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_in_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_in_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr"><a onclick = "UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>