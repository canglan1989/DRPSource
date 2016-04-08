<?php /* Smarty version 2.6.26, created on 2013-01-24 19:02:25
         compiled from Agent/AgentShareCheckListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/AgentShareCheckListBody.tpl', 2, false),array('function', 'au', 'Agent/AgentShareCheckListBody.tpl', 4, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['arrcheckList']):
?>
<tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a m="AgentList" v="8" ispurview="true" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentinfoAddContact'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=yes&isPact=no');" href="javascript:;"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</a>   
    </div></td>      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['oldOwnerName']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['oldOwnerName']; ?>
</div></td>   
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['sharePerson']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['sharePerson']; ?>
</div></td>  
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['newOwnerName']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['newOwnerName']; ?>
</div></td>                                       
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['share_remark']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['share_remark']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['shareCreate']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['shareCreate']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['share_create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['share_create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['check_status']; ?>
"><div class="ui_table_tdcntr">
      <?php if ($this->_tpl_vars['arrcheckList']['check_status'] != '未审核'): ?>
      <a href="javascript:void(0)" onclick="showCheckPage('<?php echo $this->_tpl_vars['arrcheckList']['id']; ?>
')"><?php echo $this->_tpl_vars['arrcheckList']['check_status']; ?>
</a>
      <?php else: ?>
      <?php echo $this->_tpl_vars['arrcheckList']['check_status']; ?>

      <?php endif; ?>
</div></td>
    <td>
        <div class="ui_table_tdcntr">            
            <ul class="list_table_operation">
                <?php if ($this->_tpl_vars['arrcheckList']['check_status'] == '未审核'): ?>
                <li><a  href="javascript:;" onClick="check(<?php echo $this->_tpl_vars['arrcheckList']['id']; ?>
)">审核</a></li>
                <?php endif; ?>
            </ul>
            
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>