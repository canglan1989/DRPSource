<?php /* Smarty version 2.6.26, created on 2013-01-07 15:44:28
         compiled from OM/GiftProduct/Back_GiftOrderListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'OM/GiftProduct/Back_GiftOrderListBody.tpl', 2, false),array('modifier', 'date_format', 'OM/GiftProduct/Back_GiftOrderListBody.tpl', 20, false),)), $this); ?>
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
    <td  title="<?php echo $this->_tpl_vars['data']['source_order_no']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id=<?php echo $this->_tpl_vars['data']['source_order_id']; ?>
')"><?php echo $this->_tpl_vars['data']['source_order_no']; ?>
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
    <td title="<?php echo $this->_tpl_vars['data']['owner_domain_url']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['owner_domain_url']; ?>
</div></td>
    <?php if ($this->_tpl_vars['data']['effect_sdate'] != $this->_tpl_vars['data']['effect_edate']): ?>
    <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 -- <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
<br/><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_edate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <?php else: ?>
    <td title=""><div class="ui_table_tdcntr">--</div></td>
    <?php endif; ?>
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
    <a onclick="OrderStatusInfo(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['order_status_text']; ?>
</a>
    </div></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>