<?php /* Smarty version 2.6.26, created on 2012-12-11 17:22:22
         compiled from OM/Back_OrderAuditAllotListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'OM/Back_OrderAuditAllotListBody.tpl', 2, false),array('modifier', 'date_format', 'OM/Back_OrderAuditAllotListBody.tpl', 25, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayOrder']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td title="">
        <div class="ui_table_tdcntr">
        <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
            <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['data']['order_id']; ?>
"/>
    	<?php else: ?>
    	   <input class="checkInp" type="checkbox" disabled="disabled"/>
        <?php endif; ?>
        </div>
    </td>
    <td  title="<?php echo $this->_tpl_vars['data']['order_no']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id=<?php echo $this->_tpl_vars['data']['order_id']; ?>
')"><?php echo $this->_tpl_vars['data']['order_no']; ?>
</a>
    </div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a>
    </div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
    </div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['product_name']; ?>
"><div class="ui_table_tdcntr">
    <?php echo $this->_tpl_vars['data']['product_name']; ?>

    </div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['order_type']; ?>
</div></td>
    <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['allolt_audit_uid'] > 0): ?>
    <a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['allolt_audit_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['audit_user_name']; ?>
</a>
    <?php else: ?>
    --
    <?php endif; ?>
    </div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)" href="javascript:;"><?php if ($this->_tpl_vars['data']['check_status_text'] == "审核中"): ?>未审核<?php else: ?><?php echo $this->_tpl_vars['data']['check_status_text']; ?>
<?php endif; ?></a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['allolt_audit_uid'] > 0): ?>
    <a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['allolt_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['allolt_user_name']; ?>
</a>
    <?php else: ?>
    --
    <?php endif; ?>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['allolt_audit_uid'] > 0): ?>
    <?php echo $this->_tpl_vars['data']['allolt_time']; ?>

    <?php else: ?>
    --
    <?php endif; ?>
    </div></td>
    <td><div class="ui_table_tdcntr">
        
            <ul class="list_table_operation">
                <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
                <?php if ($this->_tpl_vars['data']['allolt_audit_uid'] == 0): ?>
                <li><a m="Back_OrderAuditAllotList" v="4" ispurview="true" href="javascript:;" onclick="AlloltAudit(<?php echo $this->_tpl_vars['data']['order_id']; ?>
,-100,'')">分配</a></li>
                <?php else: ?>
                <li><a m="Back_OrderAuditAllotList" v="4" ispurview="true" href="javascript:;" onclick="ChangeAudit('<?php echo $this->_tpl_vars['data']['order_id']; ?>
','<?php echo $this->_tpl_vars['data']['audit_uid']; ?>
','<?php echo $this->_tpl_vars['data']['audit_user_name']; ?>
')">转移</a></li>
                <?php endif; ?>
                <?php endif; ?>
          </ul>
          
        </div>
      </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>