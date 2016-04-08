<?php /* Smarty version 2.6.26, created on 2013-01-23 19:19:47
         compiled from System/AreaSet/AccountAreaListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/AreaSet/AccountAreaListBody.tpl', 3, false),)), $this); ?>

<?php $_from = $this->_tpl_vars['arrayGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
	<td  style="width:" title="<?php echo $this->_tpl_vars['data']['account_no']; ?>
"><div class="ui_table_tdcntr "><?php echo $this->_tpl_vars['data']['account_no']; ?>
</div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['account_name']; ?>
"><div class="ui_table_tdcntr <?php if (strlen ( $this->_tpl_vars['data']['account_no'] ) > 2): ?>indent_2<?php endif; ?>"><?php if (strlen ( $this->_tpl_vars['data']['account_no'] ) == 2): ?><strong><?php echo $this->_tpl_vars['data']['account_name']; ?>
</strong><?php else: ?><?php echo $this->_tpl_vars['data']['account_name']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['data']['is_system'] == 1): ?><span style="color:red">（该账号组不可删除）</span><?php endif; ?></div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['account_name']; ?>
"><div class="ui_table_tdcntr"> <?php echo $this->_tpl_vars['data']['user_name']; ?>
</div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['account_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['account_group_level']; ?>
级</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
            <ul class="list_table_operation">
                <li><a m="AccountAreaList" v="4" ispurview="true" href="javascript:;" 
                onclick="ModifyAccountGroup(<?php echo $this->_tpl_vars['data']['account_group_id']; ?>
,0)">编辑</a></li>
                <?php if ($this->_tpl_vars['data']['account_group_level'] < 3): ?>
                <li><a m="AccountAreaList" v="4" ispurview="true" href="javascript:;" 
                onclick="ModifyAccountGroup(0,<?php echo $this->_tpl_vars['data']['account_group_id']; ?>
)">添加下级</a></li>
                <?php endif; ?>
                
<?php if ($this->_tpl_vars['data']['have_sub'] != 1 && $this->_tpl_vars['data']['is_system'] != 1): ?>
                <li><a m="AccountAreaList" v="8" ispurview="true" href="javascript:;" 
                onclick="IM.account.delOper('/?d=System&c=AccountArea&a=DelAccountGroup&id=<?php echo $this->_tpl_vars['data']['account_group_id']; ?>
',<?php echo '{'; ?>

                id:<?php echo $this->_tpl_vars['data']['account_group_id']; ?>
<?php echo '}'; ?>
,'删除账号组',this)">删除</a></li>
<?php endif; ?>
                <li><a href="javascript:;" onclick="JumpPage('/?d=System&c=AccountArea&a=AccountBindList&id=<?php echo $this->_tpl_vars['data']['account_group_id']; ?>
')">绑定账号</a></li>
                
     
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>