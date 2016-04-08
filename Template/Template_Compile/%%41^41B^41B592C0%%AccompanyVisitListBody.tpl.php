<?php /* Smarty version 2.6.26, created on 2013-01-28 10:41:15
         compiled from Agent/WorkManagement/AccompanyVisitListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/AccompanyVisitListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayAccompanyVisit']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
	<td title="<?php echo $this->_tpl_vars['data']['id']; ?>
" ><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['id']; ?>
</nobr></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['e_name']; ?>
" ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['user_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['inviter_name']; ?>
" ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['inviter_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['inviter_name']; ?>
</a> </div></td>
    <td title="<?php echo $this->_tpl_vars['data']['s_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['s_time']; ?>
/<?php echo $this->_tpl_vars['data']['e_time']; ?>
</div></td>
	<td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><nobr><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></nobr></div></td>
    <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['tel']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['content']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['content']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['check_status']; ?>
" ><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['check_statu'] == 0): ?> 未审查
    <?php elseif ($this->_tpl_vars['data']['check_statu'] == 1): ?>
    <a m="AccompanyVisit" v="2" ispurview="true" href="javascript:;"  onclick="ShowCheckDetial(<?php echo $this->_tpl_vars['data']['id']; ?>
)">审查通过</a>    
    <?php elseif ($this->_tpl_vars['data']['check_statu'] == 2): ?>
    <a m="AccompanyVisit" v="2" ispurview="true" href="javascript:;"  onclick="ShowCheckDetial(<?php echo $this->_tpl_vars['data']['id']; ?>
)">审查未通过</a>
    <?php endif; ?>
    </div></td>    
</tr>
<?php endforeach; endif; unset($_from); ?>