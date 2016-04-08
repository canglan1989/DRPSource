<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:23
         compiled from CM/ContactRecord/ContactRecordListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'CM/ContactRecord/ContactRecordListBody.tpl', 2, false),array('modifier', 'truncate', 'CM/ContactRecord/ContactRecordListBody.tpl', 20, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['intention_rating_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</div></td>    
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_tel']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_mobile']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['not_valid_contact_id'] > 0): ?>
    <span style="color:#EE5F00;"><?php echo $this->_tpl_vars['data']['is_valid_text']; ?>
</span>
    <?php else: ?>
    <?php echo $this->_tpl_vars['data']['is_valid_text']; ?>

    <?php endif; ?>
    </div></td>    
    <td title="<?php echo $this->_tpl_vars['data']['contact_recode']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="GetRecordDetail(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['contact_recode'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '60', "...") : smarty_modifier_truncate($_tmp, '60', "...")); ?>
</a></div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_time']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['revisit_uid'] > 0): ?>
    <a href="javascript:;" onclick="ShowRevisitCard(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)"><?php echo $this->_tpl_vars['data']['revisit_status_text']; ?>
</a>
    <?php else: ?>
    <?php echo $this->_tpl_vars['data']['revisit_status_text']; ?>

    <?php endif; ?>
    </div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>