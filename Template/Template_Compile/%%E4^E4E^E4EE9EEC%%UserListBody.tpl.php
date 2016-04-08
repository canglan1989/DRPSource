<?php /* Smarty version 2.6.26, created on 2012-11-16 16:14:32
         compiled from System/AccountManager/UserListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/AccountManager/UserListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td  title="<?php echo $this->_tpl_vars['data']['e_name']; ?>
"><div class="ui_table_tdcntr" ><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['e_workno']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['e_workno']; ?>
</div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['dept_fullname']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['dept_fullname']; ?>
</div></td>
    <td  title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['last_login_time'] == "2000-01-01 00:00:00"): ?>--<?php else: ?><?php echo $this->_tpl_vars['data']['last_login_time']; ?>
<?php endif; ?></div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['post_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['post_name']; ?>
</div></td>
    <td><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['e_status'] == 0): ?>聘用
    <?php elseif ($this->_tpl_vars['data']['e_status'] == -11): ?>已流失
    <?php elseif ($this->_tpl_vars['data']['e_status'] == -10): ?>已辞退
    <?php elseif ($this->_tpl_vars['data']['e_status'] == -9): ?>已离职
    <?php elseif ($this->_tpl_vars['data']['e_status'] == -1): ?>离职中
    <?php elseif ($this->_tpl_vars['data']['e_status'] == 1): ?>实习
    <?php elseif ($this->_tpl_vars['data']['e_status'] == 2): ?>见习
    <?php elseif ($this->_tpl_vars['data']['e_status'] == 3): ?>外派
    <?php elseif ($this->_tpl_vars['data']['e_status'] == 4): ?>停薪留职
    <?php elseif ($this->_tpl_vars['data']['e_status'] == 5): ?>试用
    <?php else: ?>聘用
    <?php endif; ?>
    </div></td>
    <td><div class="ui_table_tdcntr" id="divStatu<?php echo $this->_tpl_vars['data']['user_id']; ?>
"><?php if ($this->_tpl_vars['data']['is_lock'] == 1): ?><span style="color:#EE5F00;">是</span><?php else: ?><span style="color:#028100;">否</span><?php endif; ?></div></td>
    <td><div class="ui_table_tdcntr">
    
    <ul class="list_table_operation">
        <li><a m="UserList" ispurview="true" v="4" href="javascript:;" onclick="LockUser(this,<?php echo $this->_tpl_vars['data']['user_id']; ?>
)"><?php if ($this->_tpl_vars['data']['is_lock'] == 1): ?>启用<?php else: ?>停用<?php endif; ?></a></li>
        <li><a m="UserRightList" ispurview="true" v="2" href="javascript:;" onclick="JumpPage('/?d=System&c=User&a=UserRightList&id=<?php echo $this->_tpl_vars['data']['user_id']; ?>
')">权限</a></li>
      </ul>
      
      </div>
      </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>