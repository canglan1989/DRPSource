<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：系统管理<span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<!--S list_table_head-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2>{$strTitle}</h2>
                </div>
            </div>
        </div>
        <span class="declare">
        “<em class="require">*</em>”为必填信息
        </span>
    </div>
<!--E list_table_head--> 
<!--S list_table_main-->
  <div class="form_bd">
    <form id="J_modifyPassword">
      <div class="tf" style="padding-top:20px;">
        <label><em class="require">*</em>原密码：</label>
        <div class="inp">
          <input type="password" class="password" name="password" id="password" maxlength="20" valid="required isNull" />
        </div>
        <span class="info">请输入原密码</span>
        <span class="ok">&nbsp;</span><span class="err">请确认原密码</span> </div>
      <div class="tf">
        <label><em class="require">*</em>新密码：</label>
        <div class="inp">
          <input type="password" class="newPassword" name="newPassword" id="newPassword" maxlength="20" valid="required isNull" />
        </div>
        <span class="info">请输入新密码</span>
        <span class="ok">&nbsp;</span><span class="err">请输入新密码</span> </div>
      <div class="tf">
        <label><em class="require">*</em>确认密码：</label>
        <div class="inp">
          <input type="password" class="RNewPassword" name="RNewPassword" id="RNewPassword" maxlength="20" valid="required isNull" />
        </div>
        <span class="info">请重新输入确认密码</span>
        <span class="ok">&nbsp;</span><span class="err">请重新输入确认密码</span> </div>
      <div class="tf tf_submit">
        <label>&nbsp;</label>
        <div class="inp">
            <div class="ui_button ui_button_confirm">
            <button id="btnSave" class="ui_button_inner" type="submit">确定</button>
            </div>
            <div class="ui_button ui_button_cancel">
            <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">取消</a>
            </div>
        </div>  
      </div>
    </form>
  </div>
</div>
<!--E list_table_main--> 
<!--S Main--> 
{literal} 
<script type="text/javascript">
function RNewPassword(e){return e == $('.newPassword').val();}
new Reg.vf($('#J_modifyPassword'),{extValid:{RNewPassword:RNewPassword},callback:function(formData){
    MM.ajax({
		data:formData,
		url: $.currentBasePathGet() + "?d=System&c=Account&a=PwdModifySubmit",
		success:function(q){
            q=MM.json(q);
			if(q.success){
			     IM.tip.show(q.msg);
			}else{
                 IM.tip.warn(q.msg);
            }
		}
	});
}});
</script> 
{/literal}