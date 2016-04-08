<?php /* Smarty version 2.6.26, created on 2012-11-16 16:14:45
         compiled from System/ModelManager/UserRightModifyBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/UserRightModifyBody.tpl', 44, false),)), $this); ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="UserRightList">
<thead class="ui_table_hd">
  <tr>
    <th width="30">
    <div class="ui_table_thcntr">
        <div class="ui_table_thtext">
        <input class="checkInp" type="checkbox" name="chkCheckAll" id="chkCheckAll" onclick="CheckAll(this);" value="0" />
        </div>
      </div>
    </th>
    <th width="200"><div class="ui_table_thcntr">
        <div class="ui_table_thtext">模块组/模块名</div>
      </div>
    </th>
    <th width="150"><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限名</div>
      </div>
    </th>
    <th width="80" style=""><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限状态</div>
      </div>
    </th>
    <th width="80" style=""><div class="ui_table_thcntr">
        <div class="ui_table_thtext">分配状态</div>
      </div>
    </th>
    <th style="width:80px" > <div class="ui_table_thcntr">
        <div class="ui_table_thtext">操作</div>
      </div>
    </th>
    <th><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限描述</div>
      </div>
    </th>
  </tr>
</thead>
<tbody class="ui_table_bd" id="list_table_body">
<?php $_from = $this->_tpl_vars['arrayUserRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<?php if ($this->_tpl_vars['data']['mgroup_name'] != ""): ?> 
<?php if ($this->_tpl_vars['index'] > 0): ?>
</tbody>
<tbody class="ui_table_bd">         
<?php endif; ?>        
<tr class="ui_table_tr_tit <?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
  <td>
  <div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkGroupCheck" onclick="IM.table.selectSub(this.checked,this)" value="0" />
  </div></td>
  <td><div class="ui_table_tdcntr">  <b><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</b>  </div></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['data']['model_name'] != ""): ?> 
<tr class="ui_table_tr_subtit <?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
  <td>
  <div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkModelCheck" onclick="IM.table.selectSub(this.checked,this,'.ui_table_tr_sub<?php echo $this->_tpl_vars['data']['model_id']; ?>
');" value="0" />
  </div></td>
  <td><div class="ui_table_tdcntr">  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['data']['model_name']; ?>
  </div></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
<?php endif; ?>
<tr class="ui_table_tr_sub<?php echo $this->_tpl_vars['data']['model_id']; ?>
 <?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
  <td><div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkCheck" id="chk_<?php echo $this->_tpl_vars['data']['right_id']; ?>
" value="<?php echo $this->_tpl_vars['data']['right_id']; ?>
" />
      <input name="tbxIsCheck" type="hidden" value="<?php echo $this->_tpl_vars['data']['is_check']; ?>
" id="tbx_<?php echo $this->_tpl_vars['data']['right_id']; ?>
" />              
  </div></td>
  <td></td>
  <td><div class="ui_table_tdcntr"> <?php echo $this->_tpl_vars['data']['right_name']; ?>
 </div></td>
  <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['data']['is_lock'] == 1): ?><span style='color:#EE5F00;'>停用</span><?php else: ?><span style="color:#028100;">正常</span><?php endif; ?>  </div></td>
  <td><div class="ui_table_tdcntr" id="div_flag_<?php echo $this->_tpl_vars['data']['right_id']; ?>
"> <?php if ($this->_tpl_vars['data']['is_check'] == 1): ?><span style='color:#028100'>已分配</span><?php else: ?><span style='color:#EE5F00;'>未分配</span><?php endif; ?>  </div></td>
  <td><div class="ui_table_tdcntr"> <a m="UserRightList" v="4" ispurview="true" href="javascript:;" onclick="CheckRight(this)" id="a_<?php echo $this->_tpl_vars['data']['right_id']; ?>
" ><?php if ($this->_tpl_vars['data']['is_check'] == 1): ?>取消<?php else: ?>分配<?php endif; ?></a> </div></td>
  <td><div class="ui_table_tdcntr"> <?php echo $this->_tpl_vars['data']['right_remark']; ?>
  </div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>     
</table>