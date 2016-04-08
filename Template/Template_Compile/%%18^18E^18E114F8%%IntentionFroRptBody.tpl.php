<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:54
         compiled from CM/IntentionFroRptBody.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
    <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr" ><a onclick = "UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;" ><?php echo $this->_tpl_vars['data']['user_name']; ?>
</a></div></td>
    
    <td title="<?php echo $this->_tpl_vars['data']['rating_1']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,1)"><?php echo $this->_tpl_vars['data']['rating_1']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_1']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['rating_2']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,2)"><?php echo $this->_tpl_vars['data']['rating_2']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_2']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['rating_3']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,3)"><?php echo $this->_tpl_vars['data']['rating_3']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_3']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['rating_4']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,4)"><?php echo $this->_tpl_vars['data']['rating_4']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_4']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['rating_5']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,5)"><?php echo $this->_tpl_vars['data']['rating_5']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_5']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['rating_6']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,6)"><?php echo $this->_tpl_vars['data']['rating_6']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_6']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['rating_7']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowValidDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
,7)"><?php echo $this->_tpl_vars['data']['rating_7']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['rating_7']; ?>
<?php endif; ?></div></td>
    
    <td title="<?php echo $this->_tpl_vars['data']['income_money']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowEstimateDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)"><?php echo $this->_tpl_vars['data']['income_money']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['income_money']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['order_count']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a  href="javascript:;" onclick="ShowEstimateDetail(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)"><?php echo $this->_tpl_vars['data']['order_count']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['order_count']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['charge_money']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a href="javascript:void(0)" onclick="GoUnitInMoneyList('<?php echo $this->_tpl_vars['data']['user_name']; ?>
')"><?php echo $this->_tpl_vars['data']['charge_money']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['charge_money']; ?>
<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['charge_count']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['IsBack'] == '0'): ?><a href="javascript:void(0)" onclick="GoUnitInMoneyList('<?php echo $this->_tpl_vars['data']['user_name']; ?>
')"><?php echo $this->_tpl_vars['data']['charge_count']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['data']['charge_count']; ?>
<?php endif; ?></div></td>
    
  </tr>
<?php endforeach; endif; unset($_from); ?>