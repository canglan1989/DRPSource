<?php /* Smarty version 2.6.26, created on 2013-01-06 17:48:21
         compiled from Agent/showEditContactInfo.tpl */ ?>
<div class="DContInner setPWDComfireCont">
<form id="J_addContactInfoForm" action="" name="addContactInfoForm" class="addContactInfoForm">
    <div class="bd">
        <div class="tf">
            <label><em class="require">*</em>姓名：</label>
            <div class="inp">
                <input class="contactName" type="text" name="contactName"  valid="required customerName" maxlength="18" tabindex="1" value="<?php echo $this->_tpl_vars['arrContacterInfo']['contact_name']; ?>
"/>
                <input type="hidden" name="aid" id="aid" value="<?php echo $this->_tpl_vars['arrContacterInfo']['aid']; ?>
" />
                <input type="hidden" name="isCharge" id="isCharge" value="<?php echo $this->_tpl_vars['arrContacterInfo']['isCharge']; ?>
" />
                <input type="checkbox" class="checkInp" value="1" name="ischarge" style="margin-top:3px; vertical-align:middle" id="ischarge" <?php if ($this->_tpl_vars['arrContacterInfo']['isCharge'] == 0): ?>checked<?php endif; ?>/> 是负责人</span>
            </div>
            <span class="info">请正确输入联系人姓名</span>
            <span class="ok">&nbsp;</span><span class="err">请正确输入联系人姓名</span>
        </div>
        <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp"><input type="text" valid="mPhone" name="mPhone" class="mPhone" value="<?php echo $this->_tpl_vars['arrContacterInfo']['mobile']; ?>
"></div>
            <span class="info" style="display:inline">固定电话与手机号一项必填</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
        </div>
        <div class="tf">
            <label><em class="require">*</em>固定电话：</label>
            <div class="inp"><input type="text" valid="fPhone" name="fPhone" class="fPhone" value="<?php echo $this->_tpl_vars['arrContacterInfo']['tel']; ?>
"></div>
            <span class="info">固话格式:0571-8888888</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号</span>
        </div>
        <div class="tf">
            <label>传真号码：</label>
            <div class="inp"><input type="text" id="charge_fax" valid="faxPhone" name="charge_fax" class="faxPhone"  value="<?php echo $this->_tpl_vars['arrContacterInfo']['fax']; ?>
"></div>
            <span class="info">格式:0571-8888888</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span>
        </div>
        <div class="tf">
        <label>电子邮箱：</label>
            <div class="inp"><input type="text" id="charge_email" valid="email" name="charge_email" class="email" value="<?php echo $this->_tpl_vars['arrContacterInfo']['email']; ?>
"></div>
            <span class="info">请输入正确邮箱</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
        </div>                       
        <div class="tf">
            <label><!--<em class="require">*</em>-->职务：</label>
            <div class="inp"><input type="text" name="officer" class="officer" valid="officer" value="<?php echo $this->_tpl_vars['arrContacterInfo']['position']; ?>
"></div><!--<span class="ok">&nbsp;</span>-->
        </div>
        <div class="tf">
            <label>QQ：</label>
            <div class="inp"><input type="text"  name="charge_qq" value="<?php if ($this->_tpl_vars['arrContacterInfo']['qq'] != 0): ?><?php echo $this->_tpl_vars['arrContacterInfo']['qq']; ?>
<?php endif; ?>"></div>
		<span class="ok">&nbsp;</span>
        </div>
        <div class="tf">
            <label>MSN：</label>
            <div class="inp"><input type="text" name="charge_msn" value="<?php echo $this->_tpl_vars['arrContacterInfo']['msn']; ?>
"></div><span class="ok">&nbsp;</span>
        </div>
        <div class="tf">
            <label>微博：</label>
            <div class="inp"><input type="text" name="charge_twitter" value="<?php echo $this->_tpl_vars['arrContacterInfo']['twitter']; ?>
"><span class="info" style="display:inline">多个微博请以","隔开</span></div><span class="ok">&nbsp;</span>
        </div>
        <div class="tf">
            <label>备注：</label>                            
            <div class="inp"><textarea valid="businessPosition" id="contactMark" cols="50" name="contactMark"><?php echo $this->_tpl_vars['contactRemark']; ?>
</textarea></div>
            <span class="info">限制100字以内</span>
            <span class="ok">&nbsp;</span><span class="err">限制100字以内</span>
        </div>
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div> 
    </div>
</form>
</div>                

        