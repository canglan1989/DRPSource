<div class="DContInner setPWDComfireCont">
<form id="J_addContactInfoForm" action="" name="addContactInfoForm" class="addContactInfoForm">
    <div class="bd">
        <div class="tf">
            <label><em class="require">*</em>姓名：</label>
            <div class="inp">
                <input class="contactName" type="text" name="contactName"  valid="required customerName" maxlength="18" tabindex="1" value="{$arrContacterInfo.contact_name}"/>
                <input type="hidden" name="aid" id="aid" value="{$arrContacterInfo.aid}" />
                <input type="hidden" name="isCharge" id="isCharge" value="{$arrContacterInfo.isCharge}" />
                <input type="checkbox" class="checkInp" value="1" name="ischarge" style="margin-top:3px; vertical-align:middle" id="ischarge" {if $arrContacterInfo.isCharge eq 0}checked{/if}/> 是负责人</span>
            </div>
            <span class="info">请正确输入联系人姓名</span>
            <span class="ok">&nbsp;</span><span class="err">请正确输入联系人姓名</span>
        </div>
        <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp"><input type="text" valid="mPhone" name="mPhone" class="mPhone" value="{$arrContacterInfo.mobile}"></div>
            <span class="info" style="display:inline">固定电话与手机号一项必填</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
        </div>
        <div class="tf">
            <label><em class="require">*</em>固定电话：</label>
            <div class="inp"><input type="text" valid="fPhone" name="fPhone" class="fPhone" value="{$arrContacterInfo.tel}"></div>
            <span class="info">固话格式:0571-8888888</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号</span>
        </div>
        <div class="tf">
            <label>传真号码：</label>
            <div class="inp"><input type="text" id="charge_fax" valid="faxPhone" name="charge_fax" class="faxPhone"  value="{$arrContacterInfo.fax}"></div>
            <span class="info">格式:0571-8888888</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span>
        </div>
        <div class="tf">
        <label>电子邮箱：</label>
            <div class="inp"><input type="text" id="charge_email" valid="email" name="charge_email" class="email" value="{$arrContacterInfo.email}"></div>
            <span class="info">请输入正确邮箱</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
        </div>                       
        <div class="tf">
            <label><!--<em class="require">*</em>-->职务：</label>
            <div class="inp"><input type="text" name="officer" class="officer" valid="officer" value="{$arrContacterInfo.position}"></div><!--<span class="ok">&nbsp;</span>-->
        </div>
        <div class="tf">
            <label><!--<em class="require">*</em>-->角色：</label>
            <div class="inp"><input type="text" name="role"  value="{$arrContacterInfo.role}"></div><!--<span class="ok">&nbsp;</span>-->
        </div>
        <div class="tf">
            <label>QQ：</label>
            <div class="inp"><input type="text"  name="charge_qq" value="{if $arrContacterInfo.qq neq 0}{$arrContacterInfo.qq}{/if}"></div>
		<span class="ok">&nbsp;</span>
        </div>
        <div class="tf">
            <label>MSN：</label>
            <div class="inp"><input type="text" name="charge_msn" value="{$arrContacterInfo.msn}"></div><span class="ok">&nbsp;</span>
        </div>
        <div class="tf">
            <label>微博：</label>
            <div class="inp"><input type="text" name="charge_twitter" value="{$arrContacterInfo.twitter}"><span class="info" style="display:inline">多个微博请以","隔开</span></div><span class="ok">&nbsp;</span>
        </div>
        <div class="tf">
            <label>备注：</label>                            
            <div class="inp"><textarea valid="businessPosition" id="contactMark" cols="50" name="contactMark">{$contactRemark}</textarea></div>
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

        