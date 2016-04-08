<?php /* Smarty version 2.6.26, created on 2012-11-23 10:10:45
         compiled from Agent/WorkManagement/AppointListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/AppointListBody.tpl', 3, false),)), $this); ?>

<?php $_from = $this->_tpl_vars['arrayAppoint']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
	<td title="<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
" ><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['appoint_id']; ?>
</nobr></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['e_name']; ?>
" ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['euser_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
	<td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><nobr><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['title']; ?>
"><div class="ui_table_tdcntr"><nobr>
                <a  href="javascript:;" 
                onclick="IM.agent.getTableList('/?d=WorkM&c=VisitAppoint&a=AppointDetial&appoint_id=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
<?php echo '}'; ?>
,'拜访预约信息',800)"
				 title="<?php echo $this->_tpl_vars['data']['v_title']; ?>
"><?php echo $this->_tpl_vars['data']['v_title']; ?>
<?php if (strlen ( $this->_tpl_vars['data']['title'] ) > strlen ( $this->_tpl_vars['data']['v_title'] )): ?>...<?php endif; ?></a>
                 
                 </nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['product_name']; ?>
"><div class="ui_table_tdcntr"><nobr><?php if ($this->_tpl_vars['data']['product_name'] != ""): ?><?php echo $this->_tpl_vars['data']['product_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['data']['inten_level']; ?>
<?php endif; ?></nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['tel']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['tel']; ?>
/<?php echo $this->_tpl_vars['data']['mobile']; ?>
</div></td>
    
    <td title="<?php echo $this->_tpl_vars['data']['sappoint_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['sappoint_time']; ?>
/<?php echo $this->_tpl_vars['data']['eappoint_time']; ?>
</div></td>
    
    <td title="<?php echo $this->_tpl_vars['data']['note']; ?>
" ><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['note'] == 1): ?>是<?php else: ?>否<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['check_status']; ?>
" ><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
    未审查
    <?php endif; ?>
    <?php if ($this->_tpl_vars['data']['check_status'] == 1): ?>
    审查通过
    <?php endif; ?>
    <?php if ($this->_tpl_vars['data']['check_status'] == 2): ?>
    审查未通过
    <?php endif; ?>
    </div></td>
	<td>
		<div class="ui_table_tdcntr">
			<ul class="list_table_operation">
				
                <?php if ($this->_tpl_vars['data']['note'] == 0 && $this->_tpl_vars['data']['create_id'] == $this->_tpl_vars['uid']): ?>
                <li><a m="VisitAppoint" v="4" ispurview="true" href="javascript:;" 
				onclick="JumpPage('/?d=WorkM&c=VisitAppoint&a=AppointModifyStep2&appoint_id=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
&agentId=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')" title="编辑">编辑</a></li>
                <li><a m="VisitNote" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=WorkM&c=VisitNote&a=ModifyNote&appoint_id=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
&agentId=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')" title="生成小记">生成小记</a></li>
                <li><a  m="VisitAppoint" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('/?d=WorkM&c=VisitAppoint&a=DelAppoint&appoint_id=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
<?php echo '}'; ?>
,'删除',this)">删除</a></li>

                <?php endif; ?>
                <?php if ($this->_tpl_vars['data']['note'] == 1): ?>
                <li><a m="VisitAppoint" v="4" ispurview="true" href="javascript:;" 
                onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=NoteDetial&appoint_id=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
<?php echo '}'; ?>
,'拜访小记信息',1000)"
				
				 title="编辑">查看小记</a></li>
                <?php endif; ?>
				
			</ul>
		</div>
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?>