<?php /* Smarty version 2.6.26, created on 2013-01-11 11:31:51
         compiled from CM/ContactRecord/AgentContactRecordBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'CM/ContactRecord/AgentContactRecordBody.tpl', 2, false),array('modifier', 'date_format', 'CM/ContactRecord/AgentContactRecordBody.tpl', 14, false),array('modifier', 'truncate', 'CM/ContactRecord/AgentContactRecordBody.tpl', 21, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_visit'] == '0'): ?>联系小记<?php else: ?>拜访小记<?php endif; ?></div></td>  
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['intention_rating_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_name']; ?>
</div></td>   
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['contact_tel']; ?>
<br/>
    <?php echo $this->_tpl_vars['data']['contact_mobile']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr">
            <?php if ($this->_tpl_vars['data']['is_visit'] == '0'): ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['contact_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>

            <?php else: ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['contact_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['contact_e_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

            <?php endif; ?>
    </div></td>    
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</div></td> 
    <td title=""><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="GetRecordDetail(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['contact_recode'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '60', "...") : smarty_modifier_truncate($_tmp, '60', "...")); ?>
</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['revisit_uid'] > 0): ?>
    <a href="javascript:;" onclick="ShowRevisitCard(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)">已回访</a>
    <?php else: ?>
    还未回访
    <?php endif; ?>
    </div></td> 
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['revisit_user_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['revisit_time'] != '2000-01-01 00:00:00'): ?><?php echo $this->_tpl_vars['data']['revisit_time']; ?>
<?php endif; ?></div></td>    
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['not_valid_contact_id'] > 0): ?>否<?php else: ?>是<?php endif; ?></div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['channel_uid']; ?>
)"><?php echo $this->_tpl_vars['data']['user_name']; ?>
<?php echo $this->_tpl_vars['data']['e_name']; ?>
</a></div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard(<?php echo '{'; ?>
'id':<?php echo $this->_tpl_vars['data']['agent_id']; ?>
<?php echo '}'; ?>
)"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</a></div></td> 
</tr>
<?php endforeach; endif; unset($_from); ?>