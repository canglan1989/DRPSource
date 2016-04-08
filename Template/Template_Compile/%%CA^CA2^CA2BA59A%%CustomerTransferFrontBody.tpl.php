<?php /* Smarty version 2.6.26, created on 2013-03-08 09:45:09
         compiled from CM/CustomerTransferFrontBody.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id=<?php echo $this->_tpl_vars['data']['customer_id']; ?>
','客户基本信息',700)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a></div></td>                                
    <td title="<?php echo $this->_tpl_vars['data']['industry_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['industry_fullname']; ?>
</div></td>                               
    <td title="<?php echo $this->_tpl_vars['data']['area_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['area_fullname']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_out_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['from_user_id']; ?>
)"><?php echo $this->_tpl_vars['data']['user_out_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_in_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['to_user_id']; ?>
)"><?php echo $this->_tpl_vars['data']['user_in_name']; ?>
</a></div></td>                                    
    <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>                                    
    <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</a></div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>