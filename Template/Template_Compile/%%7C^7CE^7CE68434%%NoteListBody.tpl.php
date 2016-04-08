<?php /* Smarty version 2.6.26, created on 2012-11-22 09:54:44
         compiled from Agent/WorkManagement/NoteListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/NoteListBody.tpl', 3, false),)), $this); ?>

<?php $_from = $this->_tpl_vars['arrayNote']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
	<td title="<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
" ><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
</nobr></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['e_name']; ?>
" ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
	<td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
"><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['visitor']; ?>
</nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><nobr><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['mobile']; ?>
"><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
</nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['title']; ?>
"><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['v_title']; ?>
<?php if (strlen ( $this->_tpl_vars['data']['title'] ) > strlen ( $this->_tpl_vars['data']['v_title'] )): ?>...<?php endif; ?></nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['result']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['product_name']; ?>
" ><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['product_name'] != ""): ?><?php echo $this->_tpl_vars['data']['product_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
<?php endif; ?></div></td>
    
    <td title="<?php echo $this->_tpl_vars['data']['visit_timestart']; ?>
/<?php echo $this->_tpl_vars['data']['visit_timeend']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visit_timestart']; ?>
/<?php echo $this->_tpl_vars['data']['visit_timeend']; ?>
</div></td>
    
    <td title="<?php echo $this->_tpl_vars['data']['check_status']; ?>
" ><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>未审查<?php endif; ?>
    <a href="javascript:;" onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=showCheckInfo','id=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
','审查结果信息',700);">
    <?php if ($this->_tpl_vars['data']['check_status'] == 1): ?>审查通过<?php endif; ?>
    <?php if ($this->_tpl_vars['data']['check_status'] == 2): ?>审查未通过<?php endif; ?></a>
    </div></td>
	<td>
		<div class="ui_table_tdcntr">
			<ul class="list_table_operation">
            <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
                <li><a m="VisitManagementCheck" v="32" ispurview="true" href="javascript:;" 
				onclick="JumpPage('/?d=WorkM&c=VisitNote&a=CheckPage&visitnoteid=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
')" title="审查">审查</a></li>
            <?php endif; ?> 
                <?php if ($this->_tpl_vars['data']['create_uid'] == $this->_tpl_vars['uid'] && $this->_tpl_vars['data']['check_status'] == 2): ?>
				<li><a m="VisitNote" v="4" ispurview="true" href="javascript:;" 
				onclick="JumpPage('/?d=WorkM&c=VisitNote&a=ModifyNote&id=<?php echo $this->_tpl_vars['data']['id']; ?>
&appoint_id=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
')" title="编辑">编辑</a></li>
                <?php endif; ?>
              
            
                <li><a m="VisitNote" v="2" ispurview="true" href="javascript:;" 
                onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=NoteDetial&appoint_id=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
<?php echo '}'; ?>
,'拜访小记信息',1000)"
				 title="查看">查看</a></li>
			
			</ul>
		</div>
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?>