<div class="DContInner">
<form id="J_newLXXiaoJi" action="" name="newLXXiaoJiForm" class="newLXXiaoJiForm">
    <div class="bd">
        <div class="tf">
            <label><em class="require">*</em>姓名：</label>
            <div class="inp">{$contactInfo.contact_name}{if $contactInfo.isCharge eq 1}（负责人）{/if}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp">{$contactInfo.contact_mobile}</div>
        </div>
        <div class="tf">
            <label>固定电话：</label>
            <div class="inp">{$contactInfo.contact_tel}</div>
        </div>
        <div class="tf">
            <label>传真号码：</label>
            <div class="inp">{$contactInfo.contact_fax}</div>
        </div>
        <div class="tf">
            <label>电子邮箱：</label>
            <div class="inp">{$contactInfo.contact_email}</div>
        </div>                        
        <div class="tf">
            <label>职务：</label>
            <div class="inp">{$contactInfo.contact_position}</div>
        </div>
        <div class="tf">
            <label>备注：</label>
            <div class="inp">{$contactInfo.contact_remark}</div>
        </div>
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
    </div>
</form>
</div>
                
                        