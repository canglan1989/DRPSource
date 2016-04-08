<?php /* Smarty version 2.6.26, created on 2012-12-11 17:22:30
         compiled from OM/Back_UnitOrderListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'OM/Back_UnitOrderListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayOrder']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td  title="<?php echo $this->_tpl_vars['data']['order_no']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id=<?php echo $this->_tpl_vars['data']['order_id']; ?>
')"><?php echo $this->_tpl_vars['data']['order_no']; ?>
</a>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr">
            <a onclick="ShowAgentCard(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
    </div></td>
    <td class="TA_r" title="<?php echo $this->_tpl_vars['data']['act_price']; ?>
"><div class="ui_table_tdcntr" ><?php echo $this->_tpl_vars['data']['act_price']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['order_type']; ?>
</div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['order_status_text']; ?>
</a>
    </div></td>
    <?php if ($this->_tpl_vars['data']['check_status'] == -2): ?>
        <td title=""><div class="ui_table_tdcntr">--</div></td>
        <td title=""><div class="ui_table_tdcntr">--</div></td>
    <?php else: ?>  
        <td  title="<?php echo $this->_tpl_vars['data']['post_user_name']; ?>
 <?php echo $this->_tpl_vars['data']['post_e_name']; ?>
"><div class="ui_table_tdcntr">
        <a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['post_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['post_user_name']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['data']['post_e_name']; ?>
</a>
        </div></td>  
        <td title="<?php echo $this->_tpl_vars['data']['post_date']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['post_date']; ?>
</div></td>
    <?php endif; ?>
    <td><div class="ui_table_tdcntr">
            <ul class="list_table_operation">
                <li><a m="UnitOrderList" v="4" ispurview="true" href="javascript:;" onclick="OrderTransfer(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)">转移</a></li>
          </ul>
        </div>
      </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>