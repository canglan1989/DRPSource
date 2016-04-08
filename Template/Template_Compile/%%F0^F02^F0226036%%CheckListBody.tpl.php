<?php /* Smarty version 2.6.26, created on 2012-12-18 17:30:34
         compiled from Agent/WorkManagement/CheckListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/CheckListBody.tpl', 3, false),array('modifier', 'truncate', 'Agent/WorkManagement/CheckListBody.tpl', 11, false),)), $this); ?>

<?php $_from = $this->_tpl_vars['arrayNote']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
    <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title="<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['user_id']; ?>
" ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['contact_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td>
        <td title="<?php if ($this->_tpl_vars['data']['last_revisit_time'] != "0000-00-00 00:00:00"): ?><?php echo $this->_tpl_vars['data']['last_revisit_time']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr">
        <?php if ($this->_tpl_vars['data']['last_revisit_time'] != "0000-00-00 00:00:00"): ?><a href="javascript:;" onclick="JumpPage('/?d=WorkM&c=VisitNote&a=ReturnVisitList&visitnoteid=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
')"><?php echo $this->_tpl_vars['data']['last_revisit_time']; ?>
</a><?php else: ?>--<?php endif; ?></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['mobile']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['title']; ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '20', "...") : smarty_modifier_truncate($_tmp, '20', "...")); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['result'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '80', "...") : smarty_modifier_truncate($_tmp, '80', "...")); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['afterlevel']; ?>
" ><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['product_name'] != ""): ?><?php echo $this->_tpl_vars['data']['product_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
<?php endif; ?></div></td>

        <td title="<?php echo $this->_tpl_vars['data']['visit_timestart']; ?>
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
        <td ><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['has_return'] == '0'): ?>未处理<?php elseif ($this->_tpl_vars['data']['has_return'] == '1'): ?>已回访<?php else: ?>不回访<?php endif; ?></div></td>

<td>
    <div class="ui_table_tdcntr">
        <ul class="list_table_operation">
            <?php if ($this->_tpl_vars['data']['ac_id'] > 0): ?>
            <li><a m="VisitNote" v="2" ispurview="true" href="javascript:;"  onclick="JumpPage('/?d=WorkM&c=AccompanyVisit&a=RelateAccompany&visitnoteid=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
')">查看陪访小记</a></li>
            <?php endif; ?>  
            <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
                <li><a m="VisitManagementCheck" v="32" ispurview="true" href="javascript:;"  onclick="JumpPage('/?d=WorkM&c=VisitNote&a=CheckPage&visitnoteid=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
&check=1')" title="审核拜访小记">审核拜访小记</a></li>
                <?php endif; ?>  
            <li><a m="VisitNote" v="2" ispurview="true" href="javascript:;"  onclick="IM.agent.getTableList('/?d=WorkM&c=VisitNote&a=NoteDetial&appoint_id=<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
<?php echo '}'; ?>
,'拜访小记信息',1000)">查看拜访小记</a></li>
            <?php if ($this->_tpl_vars['data']['has_return'] == 1): ?>
                <li><a href="javascript:;" onclick="IM.Agent.addVisitRecord('/?d=WorkM&c=VisitNote&a=ShowAddReturnVisit',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
,act:'edit'<?php echo '}'; ?>
,'修改回访记录')">修改回访记录</a></li>
            <?php elseif ($this->_tpl_vars['data']['has_return'] == 0): ?>
                <li><a href="javascript:;" onclick="NoReturnVisit(<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
)">不回访</a></li>
                <li><a href="javascript:;" onclick="IM.Agent.addVisitRecord('/?d=WorkM&c=VisitNote&a=ShowAddReturnVisit',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['visitnoteid']; ?>
,act:'add'<?php echo '}'; ?>
,'添加回访记录')">添加回访</a></li>
            <?php endif; ?>
        </ul>
    </div>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>