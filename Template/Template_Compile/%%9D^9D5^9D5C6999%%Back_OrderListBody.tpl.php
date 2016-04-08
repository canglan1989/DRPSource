<?php /* Smarty version 2.6.26, created on 2012-12-11 17:22:28
         compiled from OM/Back_OrderListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'OM/Back_OrderListBody.tpl', 2, false),array('modifier', 'date_format', 'OM/Back_OrderListBody.tpl', 30, false),)), $this); ?>
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
    <td class="TA_r" title="<?php echo $this->_tpl_vars['data']['act_price']; ?>
"><div class="ui_table_tdcntr" ><?php echo $this->_tpl_vars['data']['act_price']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr" >
            <?php if ($this->_tpl_vars['data']['act_price'] != 0 && $this->_tpl_vars['data']['check_status'] >= 0): ?>
                <?php if ($this->_tpl_vars['data']['is_charge'] == 1): ?>
                    <a href="javascript:;" onclick="OrderPriceStatus(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)"><?php echo $this->_tpl_vars['data']['money_state_text']; ?>
</a>
                <?php else: ?>
                    <a href="javascript:;" onclick="OrderPriceStatus(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)"><?php echo $this->_tpl_vars['data']['money_state_text']; ?>
</a>
                <?php endif; ?>
            <?php else: ?>
                <?php echo $this->_tpl_vars['data']['money_state_text']; ?>

            <?php endif; ?>    
        </div></td><td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['order_type']; ?>
</div></td>
    <td><div class="ui_table_tdcntr">
            <a onclick="OrderStatusInfo(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['order_status_text']; ?>
</a>
        </div></td>
    <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['order_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 -- <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['order_edate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['order_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
<br /><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['order_edate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 -- <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_edate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_sdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
<br /><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['effect_edate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <td ><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['order_status'] != 60 && $this->_tpl_vars['data']['order_status'] != 70): ?>
            <a href="javascript:;" m="OrderList" v="4" ispurview="true" onclick="BackOrderAndMoney(<?php echo $this->_tpl_vars['data']['order_id']; ?>
)">退单</a>
    <?php endif; ?>
        </div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>