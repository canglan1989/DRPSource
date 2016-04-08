<?php /* Smarty version 2.6.26, created on 2012-12-11 15:06:25
         compiled from System/AreaSet/AccountBindBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/AreaSet/AccountBindBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
  
  
  <td><div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkCheck" value="<?php echo $this->_tpl_vars['data']['account_group_user_id']; ?>
" id="chk_<?php echo $this->_tpl_vars['data']['account_group_user_id']; ?>
"/>
  </div></td>
  
  
	<td  style="width:" title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['e_name']; ?>
"><div class="ui_table_tdcntr"> <a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;" ><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a> </div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['area_group_name']; ?>
</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
            <ul class="list_table_operation">
            <li><a m="AccountAreaList" v="4" ispurview="true" href="javascript:;" 
                onclick="RemoveBind(<?php echo $this->_tpl_vars['data']['account_group_user_id']; ?>
)">移除</a></li>
                <?php if ($this->_tpl_vars['account_len'] == 6): ?>
            <li><a href="javascript:;" onclick="AreaBind(<?php echo $this->_tpl_vars['id']; ?>
,<?php echo $this->_tpl_vars['data']['account_group_user_id']; ?>
)">绑定区域组</a></li><?php endif; ?>
            <!--
账号组区域绑定中，如果账号组不是三级，该账号组下面的账户不可以绑定区域组
-->
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>