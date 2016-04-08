<?php /* Smarty version 2.6.26, created on 2012-12-07 16:29:09
         compiled from System/AccountManager/EmployeeDetial.tpl */ ?>
<div class="DContInner">
<form id="J_newLXXiaoJi" class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="">
<div class="bd">
<?php $_from = $this->_tpl_vars['arrayUserList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>          
      <!--<div class="tf">
        <label>公司：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['company_name']; ?>
</div>
    </div>-->     
     <div class="tf">
            <label>
            账号名：
            </label>
            <div class="inp"><?php echo $this->_tpl_vars['data']['e_workno']; ?>
</div>
    </div>        
    <div class="tf">
        <label>
        姓名：
        </label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</div>
    </div>  
     <div class="tf">
        <label>性别 ：</label>
        <div class="inp"><?php if ($this->_tpl_vars['data']['e_sex'] == 0): ?>男 <?php else: ?>女<?php endif; ?>  </div>
    </div>
       <div class="tf">
        <label>部 门：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['dept_fullname']; ?>
</div>
    </div>
    <div class="tf">
        <label>职 位 ：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['post_name']; ?>
 </div>
    </div>
    <div class="tf">
        <label>上级：</label>
        <div class="inp">
        <?php if ($this->_tpl_vars['supPosition'] != ""): ?><a onclick="UserSupDetial(<?php echo $this->_tpl_vars['sup_uid']; ?>
)" href="javascript:;"><?php echo $this->_tpl_vars['supPosition']; ?>
</a><?php endif; ?>
        </div>
    </div> 
    <div class="tf">
        <label>员工状态：</label>
        <div class="inp"><?php if ($this->_tpl_vars['data']['e_status'] == 0): ?>聘用<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == 1): ?>实习<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == 2): ?>见习<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == 3): ?>外派<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == 4): ?>停薪留职<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == 5): ?>试用<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == -1): ?>离职中<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == -9): ?>已离职<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == -10): ?>已辞退<?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['e_status'] == -11): ?>已流失<?php endif; ?></div>
    </div>   
    <div class="tf">
        <label>手机 ：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['e_mobile']; ?>
</div>
    </div>
     <div class="tf">
        <label>公司电话 ：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['e_phone']; ?>
</div>
    </div>
    <div class="tf">
        <label>分 机 号：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['e_tel_extension']; ?>
</div>
    </div> 
    <div class="tf">
        <label>Email：</label>
        <div class="inp"><?php echo $this->_tpl_vars['data']['e_email']; ?>
</div>
    </div>               
<?php endforeach; endif; unset($_from); ?>
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</form> 
</div>