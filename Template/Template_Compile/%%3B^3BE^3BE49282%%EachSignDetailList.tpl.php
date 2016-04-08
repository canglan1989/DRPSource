<?php /* Smarty version 2.6.26, created on 2012-12-17 14:24:50
         compiled from Agent/EachSignDetailList.tpl */ ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pactlog']):
?>
<tr class="">
    <td>
    <div class="ui_table_tdcntr">
    	<?php if ($this->_tpl_vars['pactlog']['pact_type'] == 0): ?>
        	未签约
        <?php elseif ($this->_tpl_vars['pactlog']['pact_type'] == 1): ?>    
            新签
        <?php elseif ($this->_tpl_vars['pactlog']['pact_type'] == 2): ?>
            续签
        <?php elseif ($this->_tpl_vars['pactlog']['pact_type'] == 3): ?>
            解除签约
        <?php elseif ($this->_tpl_vars['pactlog']['pact_type'] == 4): ?>
            失效
        <?php endif; ?>
       <?php if ($this->_tpl_vars['pactlog']['pact_stage'] != ''): ?>(<?php echo $this->_tpl_vars['pactlog']['pact_stage']; ?>
)<?php endif; ?>
    </div>
    </td>
    <td>
    <div class="ui_table_tdcntr">
    	<?php if ($this->_tpl_vars['pactlog']['pact_status'] == 0): ?>
        	未提交
        <?php elseif ($this->_tpl_vars['pactlog']['pact_status'] == 1): ?>
        	流程中
        <?php elseif ($this->_tpl_vars['pactlog']['pact_status'] == 2): ?>
        	已签约
        <?php elseif ($this->_tpl_vars['pactlog']['pact_status'] == 3): ?>
        	已解除签约
        <?php elseif ($this->_tpl_vars['pactlog']['pact_status'] == 3): ?>
        	已失效
        <?php endif; ?>
    </div>
    </td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['pactlog']['cash_deposit'] != '0.00'): ?>￥<?php echo $this->_tpl_vars['pactlog']['cash_deposit']; ?>
<?php endif; ?></div></td>
    <td class="TA_r"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['pactlog']['pre_deposit'] != '0.00'): ?>￥<?php echo $this->_tpl_vars['pactlog']['pre_deposit']; ?>
<?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['pactlog']['e_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['pactlog']['account_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['pactlog']['check_time']; ?>
</div></td></td>
</tr>
<?php endforeach; endif; unset($_from); ?>     
       