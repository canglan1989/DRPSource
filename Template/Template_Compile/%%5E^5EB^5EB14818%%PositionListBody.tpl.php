<?php /* Smarty version 2.6.26, created on 2012-11-16 16:13:54
         compiled from System/ModelManager/PositionListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/PositionListBody.tpl', 2, false),array('function', 'au', 'System/ModelManager/PositionListBody.tpl', 9, false),array('modifier', 'date_format', 'System/ModelManager/PositionListBody.tpl', 7, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayPosition']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['company_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['dept_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['post_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['level_name']; ?>
(<?php echo $this->_tpl_vars['data']['m_value']; ?>
)</div></td>
    <td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a m="PositionRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Position','a' => 'PositionRightModify'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['post_id']; ?>
')">权限</a></li>
      </ul>
      </div>
    </td>    
  </tr>
<?php endforeach; endif; unset($_from); ?>