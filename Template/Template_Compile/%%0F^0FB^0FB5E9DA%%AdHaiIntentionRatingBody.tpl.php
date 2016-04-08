<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:12
         compiled from CM/ContactRecord/AdHaiIntentionRatingBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'CM/ContactRecord/AdHaiIntentionRatingBody.tpl', 2, false),array('function', 'au', 'CM/ContactRecord/AdHaiIntentionRatingBody.tpl', 6, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showDetailFront'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['data']['customer_id']; ?>
')"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_visit'] == 0): ?>联系小记<?php else: ?>拜访小记<?php endif; ?></div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['intention_rating_name']; ?>
</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['income_money'] != '0.000'): ?><?php echo $this->_tpl_vars['data']['income_money']; ?>
<?php endif; ?></div></td>   
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['income_date'] != '0000-00-00'): ?><?php echo $this->_tpl_vars['data']['income_date']; ?>
<?php endif; ?></div></td> 
    <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td> 
</tr>
<?php endforeach; endif; unset($_from); ?>