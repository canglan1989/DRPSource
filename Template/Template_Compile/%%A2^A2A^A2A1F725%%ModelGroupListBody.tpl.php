<?php /* Smarty version 2.6.26, created on 2012-11-16 16:05:24
         compiled from System/ModelManager/ModelGroupListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/ModelGroupListBody.tpl', 2, false),array('function', 'au', 'System/ModelManager/ModelGroupListBody.tpl', 7, false),array('modifier', 'date_format', 'System/ModelManager/ModelGroupListBody.tpl', 17, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayModelGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr <?php if ($this->_tpl_vars['data']['rootModel'] == 0): ?>indent_2<?php endif; ?>">
    <?php if ($this->_tpl_vars['data']['rootModel'] != 0): ?>
    <strong><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</strong>
    <?php else: ?>
    <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelList'), $this);?>
&pid=<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
')"><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</a>
    <?php endif; ?>            
    </div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mgroup_code']; ?>
</div></td>
    <td style="align:right;"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['sort_index']; ?>
</div></td>
    <td><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="LockData(<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
)">
    <?php if ($this->_tpl_vars['data']['is_lock'] == 0): ?><span style="color:#028100;">正常</span><?php else: ?><span style="color:#EE5F00;">关闭</span><?php endif; ?></a>
    </div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mgroup_remark']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
    <td><div class="ui_table_tdcntr">
      <ul class="list_table_operation">
      <?php if ($this->_tpl_vars['isDepEvn'] == 1): ?>
      <?php if ($this->_tpl_vars['data']['rootModel'] == 0): ?>
        <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelGroup','a' => 'ModelGroupModify'), $this);?>
&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
&id=<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
')">编辑</a></li>
        <li><a m="ModelGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelGroup','a' => 'ModelGroupDel'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
&mgroupNo=<?php echo $this->_tpl_vars['data']['mgroup_no']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
<?php echo '}'; ?>
 ,'删除模块',this)">删除</a></li>
        <?php else: ?>
       <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelGroup','a' => 'ModelGroupModify'), $this);?>
&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
&pno=<?php echo $this->_tpl_vars['data']['mgroup_no']; ?>
')" >添加子模块</a></li>
       <?php endif; ?>
      <?php endif; ?>
       </ul>
       </div>
    </td>            
  </tr>
<?php endforeach; endif; unset($_from); ?>
        