<?php /* Smarty version 2.6.26, created on 2013-01-11 11:31:12
         compiled from System/AccountManager/UserDetial.tpl */ ?>
<div class="DContInner">
<form id="J_newLXXiaoJi" class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="">
<div class="bd">
<?php $_from = $this->_tpl_vars['arrayUserList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
     <div class="tf">
            <label>用户名：
            </label>
            <div class="inp"><?php echo $this->_tpl_vars['data']['user_name']; ?>
 </div>
    </div>            
    <div class="tf">
        <label>
        姓名：
        </label>
        <div class="inp"> <?php echo $this->_tpl_vars['data']['e_name']; ?>
</div>
    </div>     
     <div class="tf">
        <label>公司：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['agent_name']; ?>
 </div>
    </div>
    <div class="tf">
        <label>部门：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['dept_name']; ?>
 </div>
    </div>
    <div class="tf">
        <label>上级：</label>
        <div class="inp">
        <?php if ($this->_tpl_vars['supName'] != ""): ?><a onclick="AgentUserSupDetial(<?php echo $this->_tpl_vars['supid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['supName']; ?>
</a><?php endif; ?>        
        </div>
    </div>
     <div class="tf">
        <label>员工状态：</label>
        <div class="inp"><?php if ($this->_tpl_vars['data']['is_lock'] == 0): ?><span style="color:#028100;">正常</span><?php else: ?><span style="color:#EE5F00;">停用</span><?php endif; ?></div>
    </div>        
    <div class="tf">
        <label>手机：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['phone']; ?>
 </div>
    </div> 
    <div class="tf">
        <label>电话：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['tel']; ?>
</div>
    </div>                                
<?php endforeach; endif; unset($_from); ?>
</div>
<div class="ft"><div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div></div>
</form> 
</div>