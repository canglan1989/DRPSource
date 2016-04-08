<?php /* Smarty version 2.6.26, created on 2012-12-07 13:57:01
         compiled from CM/InfoListBackBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/InfoListBackBody.tpl', 15, false),)), $this); ?>

<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr>
<!--    <td><div class="ui_table_tdcntr"><input name="listid" class="checkInp" value="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
" type="checkbox"/></div></td>-->
    <td title="<?php echo $this->_tpl_vars['data']['customer_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><a title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
" href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['customer_id']; ?>
<?php echo '}'; ?>
,'客户基本信息',700)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['industry_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['industry_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['area_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['area_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_resource_cn']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_resource_cn']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['check_status_cn']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showCheckStatus(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)"><?php echo $this->_tpl_vars['data']['check_status_cn']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
"><div class="ui_table_tdcntr" ><a onclick = "UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)" href="javascript:;" ><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a m='showBackInfoList' v="16" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showModifyBack'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['data']['customer_id']; ?>
')">编辑</a></li>
        <li><a m='showBackInfoList' v="16" ispurview="true" href="javascript:;" onclick="showTransfer(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)">转移</a></li>
      </ul>
      </div>
    </td>    
  </tr>
<?php endforeach; endif; unset($_from); ?>