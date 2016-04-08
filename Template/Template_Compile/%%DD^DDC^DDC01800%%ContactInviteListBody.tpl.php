<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:20
         compiled from CM/ContactRecord/ContactInviteListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'CM/ContactRecord/ContactInviteListBody.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
  <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
    <td title="">
        <div class="ui_table_tdcntr">
        <?php if ($this->_tpl_vars['data']['create_uid'] <= 0 && $this->_tpl_vars['data']['invite_status'] != '1'): ?>
            <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['data']['recode_id']; ?>
"/>
        <?php endif; ?>
        </div>
    </td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['customer_id']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['customer_name']; ?>
"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard(<?php echo $this->_tpl_vars['data']['customer_id']; ?>
)"><?php echo $this->_tpl_vars['data']['customer_name']; ?>
</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['invite_contact_name']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['invite_contact_tel']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['invite_contact_mobile']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['invite_time']; ?>
</div></td>    
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['invite_status'] == -1): ?>
    <span style="color:#EE5F00;"><?php echo $this->_tpl_vars['data']['invite_status_text']; ?>
</span>
    <?php elseif ($this->_tpl_vars['data']['invite_status'] == 1): ?>
    <a href="javascript:void(0)" onclick="GetRecordDetail(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
);"><span style="color:#028100;"><?php echo $this->_tpl_vars['data']['invite_status_text']; ?>
</span></a>
    <?php else: ?>
    <?php echo $this->_tpl_vars['data']['invite_status_text']; ?>

    <?php endif; ?>
    </div></td>    
    <td title=""><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['invite_create_time']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['data']['revisit_uid'] > 0): ?>
    <a href="javascript:;" onclick="ShowRevisitCard(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)"><?php echo $this->_tpl_vars['data']['revisit_status_text']; ?>
</a>
    <?php else: ?>
    <?php echo $this->_tpl_vars['data']['revisit_status_text']; ?>

    <?php endif; ?>
    </div></td>
    <td><div class="ui_table_tdcntr">        
            <ul class="list_table_operation">
                <?php if ($this->_tpl_vars['data']['create_uid'] <= 0 && $this->_tpl_vars['data']['invite_status'] == 0): ?>
                <li><a m="ContactRecordList" ispurview="true" v="4" href="javascript:;" 
                    onclick="JumpPage('/?d=CM&c=ContactRecord&a=ContactRecodeModify&inviteID=<?php echo $this->_tpl_vars['data']['recode_id']; ?>
')">添加联系小记</a></li>                    
                <li><a m="ContactInviteList" ispurview="true" v="4" href="javascript:;" onclick="DropInvite(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)">作废</a></li>
                <li><a m="ContactInviteList" ispurview="true" v="4" href="javascript:;" onclick="EditInvite(<?php echo $this->_tpl_vars['data']['recode_id']; ?>
)">编辑预约</a></li>                
                <?php endif; ?>
          </ul>
          
        </div>
      </td>
</tr>
<?php endforeach; endif; unset($_from); ?>