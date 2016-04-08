<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:16
         compiled from CM/TransferBody.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    <td><div class="ui_table_tdcntr">
    <input name="listid" class="checkInp listid" checked value="<?php echo $this->_tpl_vars['data']['agent_customer_id']; ?>
" type="hidden"/> 
    <!--
    <input name="listid" class="checkInp" value="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
" type="checkbox"/>
    -->
    </div></td>

    <td title="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>

    <td><div class="ui_table_tdcntr"><a title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
" href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['customer_id']; ?>
<?php echo '}'; ?>
,'客户基本信息',700)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</div></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>