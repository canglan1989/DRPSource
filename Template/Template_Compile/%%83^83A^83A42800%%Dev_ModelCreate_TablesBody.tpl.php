<?php /* Smarty version 2.6.26, created on 2012-11-22 10:48:48
         compiled from System/ModelManager/Dev_ModelCreate_TablesBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/Dev_ModelCreate_TablesBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayTableList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
    <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['table_name']; ?>
</div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onClick="CreateCode('<?php echo $this->_tpl_vars['data']['table_name']; ?>
','<?php echo $this->_tpl_vars['data']['table_comment']; ?>
')">生成</a></div></td>
        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['table_comment']; ?>
</div></td>
    </tr>
<?php endforeach; endif; unset($_from); ?>