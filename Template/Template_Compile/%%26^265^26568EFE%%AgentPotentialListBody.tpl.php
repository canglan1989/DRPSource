<?php /* Smarty version 2.6.26, created on 2013-01-29 09:53:22
         compiled from Agent/AgentPotentialListBody.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AgentPotentialListBody.tpl', 8, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrcheckList']):
?>
<tr>
    <td title=""><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrcheckList']['channel_uid'] != $this->_tpl_vars['userID'] && $this->_tpl_vars['arrcheckList']['share_uid'] == $this->_tpl_vars['userID']): ?>
    <?php else: ?>
    <input class="checkInp" type="checkbox" name="listid" value="<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
"/><?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_no']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
"><div class="ui_table_tdcntr"><a onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentinfoAddContact'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrcheckList']['is_check']; ?>
&needCheck=yes&isPact=no');" href="javascript:;"><?php echo $this->_tpl_vars['arrcheckList']['agent_name']; ?>
</a>
    <?php if ($this->_tpl_vars['arrcheckList']['share_uid'] != ''): ?><span style="color:red;">(享)</span><?php endif; ?>
    </div></td>   
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['agent_reg_area_full_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['agent_reg_area_full_name']; ?>
</div></td>   
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['industry']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['industry']; ?>
</div></td>   
    <td title="<?php if ($this->_tpl_vars['arrcheckList']['agent_from'] == 0): ?>自录<?php elseif ($this->_tpl_vars['arrcheckList']['agent_from'] == 1): ?>拉取<?php elseif ($this->_tpl_vars['arrcheckList']['agent_from'] == 2): ?>共享<?php else: ?>被转入<?php endif; ?>"><div class="ui_table_tdcntr">
        <?php if ($this->_tpl_vars['arrcheckList']['agent_from'] == 0): ?>自录<?php elseif ($this->_tpl_vars['arrcheckList']['agent_from'] == 1): ?>拉取<?php elseif ($this->_tpl_vars['arrcheckList']['agent_from'] == 2): ?>共享<?php else: ?>被转入<?php endif; ?>
    </div></td>                            
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['inten_level']; ?>
"><div class="ui_table_tdcntr">
     <?php if ($this->_tpl_vars['arrcheckList']['inten_level'] <= 'B+'): ?>
            <a href="javascript:void(0)" onclick="getExpectInfo(<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
)" ><?php echo $this->_tpl_vars['arrcheckList']['inten_level']; ?>
</a>
        <?php else: ?>
            <?php echo $this->_tpl_vars['arrcheckList']['inten_level']; ?>

        <?php endif; ?>
      
      
     </div></td>   
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['share_ename']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['share_ename']; ?>
<?php echo $this->_tpl_vars['arrcheckList']['share_username']; ?>
</div></td>                                      
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['expect_type']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrcheckList']['expect_type'] == 1): ?>承诺<?php elseif ($this->_tpl_vars['arrcheckList']['expect_type'] == 2): ?>备份<?php endif; ?></div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['contactOldNum']; ?>
"><div class="ui_table_tdcntr">
           <?php if ($this->_tpl_vars['arrcheckList']['contactOldNum'] >= 40): ?>
           <span style="color:red;"><?php echo $this->_tpl_vars['arrcheckList']['contactOldNum']; ?>
</span>
           <?php else: ?><?php echo $this->_tpl_vars['arrcheckList']['contactOldNum']; ?>
<?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['bAddOldNum']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['bAddOldNum']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['charge_phone']; ?>
/<?php echo $this->_tpl_vars['arrcheckList']['charge_tel']; ?>
</div></td>
    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrcheckList']['last_time']; ?>
<?php if ($this->_tpl_vars['arrcheckList']['last_type'] != ''): ?>(<?php if ($this->_tpl_vars['arrcheckList']['last_type'] == 0): ?>拜访<?php else: ?>电话<?php endif; ?>)<?php endif; ?></td>
    <td ><div class="ui_table_tdcntr">
         <?php if ($this->_tpl_vars['arrcheckList']['last_type'] == 0): ?>
         <a href="javascript:void(0)" onclick="getVisitNoteDetail(<?php echo $this->_tpl_vars['arrcheckList']['note_id']; ?>
)"><?php echo $this->_tpl_vars['arrcheckList']['last_content']; ?>
</a>
         <?php else: ?>
         <a href="javascript:void(0)" onclick="getTelNoteDetail(<?php echo $this->_tpl_vars['arrcheckList']['note_id']; ?>
)" ><?php echo $this->_tpl_vars['arrcheckList']['last_content']; ?>
</a>
         <?php endif; ?>
    </div></td>

    
    <td>
        <div class="ui_table_tdcntr">
            <ul class="list_table_operation">
               
                <li><a m="TelTaskManage" v="4" ispurview="true" href="javascript:void(0);" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'TelWork','a' => 'showAddTelInvite'), $this);?>
&agentid=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
')">设置电话任务</a></li>
                <li><a onclick="JumpPage('/?d=WorkM&c=TelWork&a=showAddTelNote&agentid=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
')" ispurview="true" v="32" m="TelTaskManage" href="javascript:;">添加联系小记</a></li>
                <li><a onclick="JumpPage('/?d=WorkM&c=VisitAppoint&a=showAddVisitInvite&agentid=<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
')" m="VisitAppoint" v="32" ispurview="true" href="javascript:;">添加拜访预约</a></li>
                <?php if ($this->_tpl_vars['arrcheckList']['channel_uid'] == $this->_tpl_vars['userID'] && $this->_tpl_vars['arrcheckList']['share_uid'] == '' && ( $this->_tpl_vars['arrcheckList']['inten_level'] == 'B+' || $this->_tpl_vars['arrcheckList']['inten_level'] == 'A' ) && ( $this->_tpl_vars['arrcheckList']['check_status'] == '' || $this->_tpl_vars['arrcheckList']['check_status'] > 0 ) && $this->_tpl_vars['arrcheckList']['passVerify'] == 1): ?>
                <li><a  href="javascript:;" onClick="setShare(<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
)">共享</a></li>              
                <?php endif; ?>
                
                <?php if ($this->_tpl_vars['arrcheckList']['channel_uid'] != $this->_tpl_vars['userID'] && $this->_tpl_vars['arrcheckList']['share_uid'] == $this->_tpl_vars['userID']): ?>
                <li><a  href="javascript:;" onClick="cancelShare(<?php echo $this->_tpl_vars['arrcheckList']['agent_id']; ?>
)">取消共享</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>