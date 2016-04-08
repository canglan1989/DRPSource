<?php /* Smarty version 2.6.26, created on 2013-01-23 10:56:59
         compiled from Agent/WorkManagement/TelVerifyBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/WorkManagement/TelVerifyBody.tpl', 2, false),array('function', 'au', 'Agent/WorkManagement/TelVerifyBody.tpl', 21, false),array('modifier', 'date_format', 'Agent/WorkManagement/TelVerifyBody.tpl', 13, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
    <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
        <td title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
" ><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['data']['agent_id']; ?>
')"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td>
        <td title="<?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)" ><div class="ui_table_tdcntr">
                    <?php if ($this->_tpl_vars['data']['afterlevel'] <= 'B+'): ?>
                        <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
</a>
                    <?php else: ?>
                        <?php echo $this->_tpl_vars['data']['afterlevel']; ?>

                    <?php endif; ?>
            </div></td>
        <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['tel']; ?>
/<?php echo $this->_tpl_vars['data']['mobile']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['tel']; ?>
/<?php echo $this->_tpl_vars['data']['mobile']; ?>
</div></td>
        <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
" ><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
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
        <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['result']; ?>
</div></td>
        <td title="<?php echo $this->_tpl_vars['data']['dynamics']; ?>
" ><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['dynamics']; ?>
</div></td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a href="javascript:void(0);" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitVerify','a' => 'showAddTelVerfity'), $this);?>
&noteid=<?php echo $this->_tpl_vars['data']['id']; ?>
')">质检</a></li>
                    <li><a href="javascript:void(0);" onclick="FlagNoteUnVertify(<?php echo $this->_tpl_vars['data']['id']; ?>
)">不质检</a></li>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>