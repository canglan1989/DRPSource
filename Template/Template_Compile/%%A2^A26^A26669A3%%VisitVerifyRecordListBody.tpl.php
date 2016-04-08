<?php /* Smarty version 2.6.26, created on 2013-01-29 10:30:31
         compiled from Agent/WorkManagement/VisitVerifyRecordListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/VisitVerifyRecordListBody.tpl', 2, false),array('modifier', 'date_format', 'Agent/WorkManagement/VisitVerifyRecordListBody.tpl', 7, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
    <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title="<?php echo $this->_tpl_vars['data']['vertify_id']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['vertify_id']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['note_id']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getVisitNoteDetail(<?php echo $this->_tpl_vars['data']['note_id']; ?>
)"><?php echo $this->_tpl_vars['data']['note_id']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['note_create_user']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['visit_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
        <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</div></td> 
        <td title="<?php echo $this->_tpl_vars['data']['note_create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['note_create_time']; ?>
</div></td>        
        <td title="<?php echo $this->_tpl_vars['data']['record_no']; ?>
" ><div class="ui_table_tdcntr"><a href="<?php echo $this->_tpl_vars['data']['record_no']; ?>
" ><?php echo $this->_tpl_vars['data']['record_no']; ?>
</a></div></td>        
        <td title="<?php echo $this->_tpl_vars['data']['verfity_status']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['verfity_status']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['vertify_remark']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['vertify_remark']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>        
        
    </tr>
<?php endforeach; endif; unset($_from); ?>