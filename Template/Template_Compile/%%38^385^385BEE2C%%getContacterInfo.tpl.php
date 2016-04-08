<?php /* Smarty version 2.6.26, created on 2012-11-21 17:34:39
         compiled from Agent/getContacterInfo.tpl */ ?>
<div class="DContInner">
<form id="J_newLXXiaoJi" action="" name="newLXXiaoJiForm" class="newLXXiaoJiForm">
    <div class="bd">
        <div class="tf">
            <label><em class="require">*</em>姓名：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['contact_name']; ?>
<?php if ($this->_tpl_vars['arrContacterInfo']['isCharge'] == 0): ?>（负责人）<?php endif; ?></div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['mobile']; ?>
</div>
        </div>
        <div class="tf">
            <label>固定电话：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['tel']; ?>
</div>
        </div>
        <div class="tf">
            <label>传真号码：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['fax']; ?>
</div>
        </div>
        <div class="tf">
            <label>电子邮箱：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['email']; ?>
</div>
        </div>                        
        <div class="tf">
            <label>职务：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['position']; ?>
</div>
        </div>
        <div class="tf">
            <label>QQ：</label>
            <div class="inp"><?php if ($this->_tpl_vars['arrContacterInfo']['qq'] != 0): ?><?php echo $this->_tpl_vars['arrContacterInfo']['qq']; ?>
<?php endif; ?></div>
        </div>
         <div class="tf">
            <label>MSN：</label>
            <div class="inp"><?php echo $this->_tpl_vars['arrContacterInfo']['msn']; ?>
</div>
        </div>
        <div class="tf">
            <label>备注：</label>
            <div class="inp"><?php echo $this->_tpl_vars['contactRemark']; ?>
</div>
        </div>
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
    </div>
</form>
</div>
                
                        