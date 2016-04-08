<?php /* Smarty version 2.6.26, created on 2012-12-11 15:05:28
         compiled from System/AreaSet/AreaGroupListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/AreaSet/AreaGroupListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
	<td  style="width:" title="<?php echo $this->_tpl_vars['data']['agroup_name']; ?>
"><div class="ui_table_tdcntr <?php if (strlen ( $this->_tpl_vars['data']['group_no'] ) > 2): ?>indent_2<?php endif; ?>"><?php if (strlen ( $this->_tpl_vars['data']['group_no'] ) == 2): ?><strong><?php echo $this->_tpl_vars['data']['agroup_name']; ?>
</strong><?php else: ?><?php echo $this->_tpl_vars['data']['agroup_name']; ?>
<?php endif; ?></div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['group_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['len_no']/2; ?>
级</div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['area_name']; ?>
"><div class="ui_table_tdcntr "><a m="AreaGroupManagement" v="2" ispurview="true" href="javascript:;" onclick="ShowArea(<?php echo $this->_tpl_vars['data']['agroup_id']; ?>
)">查看地区范围</a></div></td>
    <td  style="width:" title="<?php echo $this->_tpl_vars['data']['group_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agroup_remark']; ?>
</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">        	
            <ul class="list_table_operation">
                <li><a m="AreaGroupManagement" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=System&c=AreaGroupSet&a=AreaGroupModify&group_no=<?php echo $this->_tpl_vars['data']['group_no']; ?>
&id=<?php echo $this->_tpl_vars['data']['agroup_id']; ?>
')">编辑</a></li>                
                <li><a m="AreaGroupManagement" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('/?d=System&c=AreaGroupSet&a=DelGroup&id=<?php echo $this->_tpl_vars['data']['agroup_id']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['agroup_id']; ?>
<?php echo '}'; ?>
,'删除区域',this)">删除</a></li>                
                              
                <?php if (strlen ( $this->_tpl_vars['data']['group_no'] ) <= 4): ?>
                <li><a m="AreaGroupManagement" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=System&c=AreaGroupSet&a=AreaGroupModify&group_no=<?php echo $this->_tpl_vars['data']['group_no']; ?>
&supid=<?php echo $this->_tpl_vars['data']['agroup_id']; ?>
')">添加下级区域组</a></li>                
                <?php endif; ?>
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>