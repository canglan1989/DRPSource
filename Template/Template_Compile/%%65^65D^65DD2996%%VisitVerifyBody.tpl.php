<?php /* Smarty version 2.6.26, created on 2013-01-29 10:02:21
         compiled from Agent/WorkManagement/VisitVerifyBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/VisitVerifyBody.tpl', 2, false),array('function', 'au', 'Agent/WorkManagement/VisitVerifyBody.tpl', 31, false),array('modifier', 'date_format', 'Agent/WorkManagement/VisitVerifyBody.tpl', 19, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
    <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td>
        <td title="<?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)<?php else: ?><?php echo $this->_tpl_vars['data']['product_name']; ?>
<?php endif; ?>" ><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?>
                                            <?php if ($this->_tpl_vars['data']['afterlevel'] <= 'B+'): ?>
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)</a>
                                            <?php else: ?>
                                                <?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo $this->_tpl_vars['data']['product_name']; ?>

                                        <?php endif; ?>
            </div></td>
            <td title="<?php echo $this->_tpl_vars['data']['visit_type']; ?>
" ><div class="ui_table_tdcntr">
                    <?php echo $this->_tpl_vars['data']['visit_type']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['tel']; ?>
/<?php echo $this->_tpl_vars['data']['mobile']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['tel']; ?>
/<?php echo $this->_tpl_vars['data']['mobile']; ?>
</div></td>
        <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visit_content']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visit_content']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['result']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['verfity_status']; ?>
" ><div class="ui_table_tdcntr">
                <?php echo $this->_tpl_vars['data']['verfity_status']; ?>

            </div></td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <?php if ($this->_tpl_vars['data']['is_vertifyed'] == 0): ?>
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="4" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitVerify','a' => 'showAddVisitVerfity'), $this);?>
&noteid=<?php echo $this->_tpl_vars['data']['id']; ?>
')">质检</a></li>
                    <?php else: ?>
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="8" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitVerify','a' => 'showAddVisitInstruction'), $this);?>
&noteid=<?php echo $this->_tpl_vars['data']['id']; ?>
')">批示</a></li>
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="32" ispurview="true" onclick="FlagReviewVertify(<?php echo $this->_tpl_vars['data']['id']; ?>
)">审阅</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>