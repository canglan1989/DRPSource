<?php /* Smarty version 2.6.26, created on 2013-01-31 14:37:57
         compiled from Agent/WorkManagement/VisitNoteListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/VisitNoteListBody.tpl', 2, false),array('modifier', 'date_format', 'Agent/WorkManagement/VisitNoteListBody.tpl', 19, false),array('modifier', 'truncate', 'Agent/WorkManagement/VisitNoteListBody.tpl', 23, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
        <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title="<?php echo $this->_tpl_vars['data']['id']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['id']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['agent_no']; ?>
 <?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_no']; ?>
</a> <?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['product_name']; ?>
" ><div class="ui_table_tdcntr">           
            <?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?>
                <?php if ($this->_tpl_vars['data']['afterlevel'] <= 'B+'): ?>
                    <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
</a>
                <?php else: ?>
                    <?php echo $this->_tpl_vars['data']['afterlevel']; ?>

                <?php endif; ?>
            <?php else: ?>
                <?php echo $this->_tpl_vars['data']['product_name']; ?>

            <?php endif; ?>
        </div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visit_type']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visit_type']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>    
        <td title="<?php echo $this->_tpl_vars['data']['mobile']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
        <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H")); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H") : smarty_modifier_date_format($_tmp, "%H")); ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H")); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H") : smarty_modifier_date_format($_tmp, "%H")); ?>
</div></td>   
	<td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
" ><div class="ui_table_tdcntr"><a onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
	<td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>	

        <td title="<?php echo $this->_tpl_vars['data']['visit_content']; ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '20', '……') : smarty_modifier_truncate($_tmp, '20', '……')); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getVisitNoteDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['result'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '20', '……') : smarty_modifier_truncate($_tmp, '20', '……')); ?>
</a></div></td>        

        <td title="<?php echo $this->_tpl_vars['data']['follow_up_time']; ?>
" ><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['follow_up_time'] != '0000-00-00 00:00:00'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['follow_up_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
<?php endif; ?></div></td>  
        <td title="<?php echo $this->_tpl_vars['data']['follow_up_content']; ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['follow_up_content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '20', '……') : smarty_modifier_truncate($_tmp, '20', '……')); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['instruction']; ?>
" >
            <div class="ui_table_tdcntr">
            <?php if ($this->_tpl_vars['data']['instruction'] != '未批示' && $this->_tpl_vars['data']['instruction'] != '已阅'): ?>
            <a onclick="inDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['instruction']; ?>
</a>
            <?php else: ?> 
            <?php echo $this->_tpl_vars['data']['instruction']; ?>

            <?php endif; ?>
            </div> </td>
	<td><div class="ui_table_tdcntr">
           <?php if ($this->_tpl_vars['data']['verfity_status'] == '通过' || $this->_tpl_vars['data']['verfity_status'] == '不通过'): ?>
            <a onclick="verfityDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['verfity_status']; ?>
</a>
           <?php else: ?>
           <?php echo $this->_tpl_vars['data']['verfity_status']; ?>

           <?php endif; ?>
           </div></td>
        </tr>
<?php endforeach; endif; unset($_from); ?>