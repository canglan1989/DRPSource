<?php /* Smarty version 2.6.26, created on 2013-01-28 10:44:52
         compiled from Agent/WorkManagement/VisitTaskManageBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/VisitTaskManageBody.tpl', 2, false),array('function', 'au', 'Agent/WorkManagement/VisitTaskManageBody.tpl', 33, false),array('modifier', 'truncate', 'Agent/WorkManagement/VisitTaskManageBody.tpl', 17, false),array('modifier', 'date_format', 'Agent/WorkManagement/VisitTaskManageBody.tpl', 19, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
    <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title="<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
" ><div class="ui_table_tdcntr"><nobr><?php echo $this->_tpl_vars['data']['appoint_id']; ?>
</nobr></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
" ><div class="ui_table_tdcntr">
            <?php if ($this->_tpl_vars['data']['agent_no'] == $this->_tpl_vars['data']['agent_id']): ?>
                <?php echo $this->_tpl_vars['data']['inten_level']; ?>

                <?php else: ?>
                    <?php echo $this->_tpl_vars['data']['product_name']; ?>

                    <?php endif; ?>
            </div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['position']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['position']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['role']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['role']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['sappoint_time_cn']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['sappoint_time_cn']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['title']; ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '50', "……") : smarty_modifier_truncate($_tmp, '50', "……")); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_id']; ?>
);"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
        <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['check_status_cn']; ?>
" ><div class="ui_table_tdcntr">
                <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
                    <?php echo $this->_tpl_vars['data']['check_status_cn']; ?>

                    <?php else: ?>
                        <a href="javascript:void(0)" onclick="CheckDetail(<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
)"><?php echo $this->_tpl_vars['data']['check_status_cn']; ?>
</a>
                        <?php endif; ?>
                
            </div></td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <?php if ($this->_tpl_vars['data']['note'] == 0): ?>
                    <?php if ($this->_tpl_vars['data']['check_status'] == 1): ?>
                        <li><a href="javascript:void(0);" m="VisitAppoint" v="32" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitAppoint','a' => 'showAddVisitNote'), $this);?>
&appid=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
')">生成小记</a></li>	
                    <?php else: ?>
                        <?php if ($this->_tpl_vars['UserID'] == $this->_tpl_vars['data']['create_id']): ?>
                    <li><a href="javascript:void(0);" m="VisitAppoint" v="4" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitAppoint','a' => 'showAddVisitInvite'), $this);?>
&appointid=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
')">编辑</a></li>	
                    <li><a href="javascript:void(0);" m="VisitAppoint" v="8" ispurview="true" onclick="delTask(<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
)">删除</a></li>
                    <?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['check_status'] == 0): ?>
                    <li><a href="javascript:void(0);" m="VisitAppoint" v="16" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'TelWork','a' => 'showCheckVisitInvite'), $this);?>
&appid=<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
')">审核</a></li>        
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>