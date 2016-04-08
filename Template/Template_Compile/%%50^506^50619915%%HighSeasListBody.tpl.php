<?php /* Smarty version 2.6.26, created on 2013-01-31 11:22:44
         compiled from Agent/HighSeasListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'Agent/HighSeasListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td title=""><div class="ui_table_tdcntr">
    <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['data']['agent_id']; ?>
"/></div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['agent_no']; ?>
"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['data']['agent_no']; ?>
</a></div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['agent_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
</div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['intention_level']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['intention_level']; ?>
</div></td>   
    <td title="<?php echo $this->_tpl_vars['data']['industry_text']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['industry_text']; ?>
</div></td>   
    <td  title="<?php echo $this->_tpl_vars['data']['agent_reg_area_full_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['agent_reg_area_full_name']; ?>
</div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['communicate_number']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['communicate_number']; ?>
</div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['train_number']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['train_number']; ?>
</div></td>   
    <td title="<?php echo $this->_tpl_vars['data']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['data']['charge_tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['data']['charge_tel']; ?>
</div></td> 
    <td  title="<?php if ($this->_tpl_vars['data']['last_contact_id'] > 0): ?><?php echo $this->_tpl_vars['data']['last_time']; ?>
(<?php echo $this->_tpl_vars['data']['last_type_text']; ?>
)<?php else: ?>--<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['last_contact_id'] > 0): ?><?php echo $this->_tpl_vars['data']['last_time']; ?>
(<?php echo $this->_tpl_vars['data']['last_type_text']; ?>
)<?php else: ?>--<?php endif; ?></div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
    <td  title="<?php echo $this->_tpl_vars['data']['in_sea_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['in_sea_time']; ?>
</div></td>
    <td><div class="ui_table_tdcntr">        
          <ul class="list_table_operation">
                <li><a m="HighSeasList" v="4" ispurview="true" href="javascript:;" onclick="GetAgent(<?php echo $this->_tpl_vars['data']['agent_id']; ?>
)">拉取</a></li>
          </ul>
        </div>
      </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>