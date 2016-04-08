<?php /* Smarty version 2.6.26, created on 2013-03-12 11:24:08
         compiled from System/AccountManager/AgentUserModify.tpl */ ?>
 <!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：系统管理<span>&gt;</span>
  <a href="javascript:;" onclick="PageBack()">用户管理</a><span>&gt;</span><?php echo $this->_tpl_vars['strTitle']; ?>
</div>
  <!--E crumbs--> 
<div class="form_edit">
  <!--S list_table_head-->
    <div class="form_hd">
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2><?php echo $this->_tpl_vars['strTitle']; ?>
</h2>
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
    <form id="form1" class="newAccountForm" name="form1" action="">
      <div class="tf" style="padding-top:20px;">
      <?php if ($this->_tpl_vars['id'] <= 0): ?>
        <label><em class="require">*</em>账号名： </label>
        <div class="inp">
        <input class="contactName" type="text" valid="required accountName3" name="tbxUserName" id="tbxUserName" value="<?php echo $this->_tpl_vars['objUserInfo']->strUserName; ?>
" style="width:180px;"/>
        </div>
        <span class="info">3-32个字符，允许英文、数子、下划线</span>
		<span class="ok">&nbsp;</span><span class="err">3-32个字符，允许英文、数子、下划线</span>
      <?php else: ?>
        <label>账号名： </label>
        <div class="inp">        
        <input class="contactName" type="hidden" valid="required accountName3" name="tbxUserName" id="tbxUserName" value="<?php echo $this->_tpl_vars['objUserInfo']->strUserName; ?>
" style="width:180px;"/>
        <?php echo $this->_tpl_vars['objUserInfo']->strUserName; ?>

        </div>
      <?php endif; ?>
      </div>
      <div <?php if ($this->_tpl_vars['objUserInfo']->iIsFinance == 1): ?> style="display:none" <?php endif; ?> class="tf">
        <label> <em class="require">*</em> 上级账号： </label>
        <div class="inp">
        <select name="cbPAccount" id="cbPAccount" style="width:180px" onchange="PAccountChange(this)">
        <?php $_from = $this->_tpl_vars['arryUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
        <option value="<?php echo $this->_tpl_vars['data']['user_no']; ?>
" <?php if ($this->_tpl_vars['pNo'] == $this->_tpl_vars['data']['user_no']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
        </select>
        </div>
        <span class="info">请输入上级账号</span> <span class="ok">&nbsp;</span><span class="err">请输入上级账号</span> 
      </div>
        <div class="tf">
          <label> <em class="require">*</em> 员工名： </label>
          <div class="inp">
            <input class="contactName" type="text" valid="required tbxEmpName" name="tbxEmpName" id="tbxEmpName" value="<?php echo $this->_tpl_vars['objUserInfo']->strEName; ?>
" style="width:180px;"/>
          </div>
          <span class="info">请输入员工名</span>
          <span class="ok">&nbsp;</span><span class="err">请输入员工名</span> </div>
      <div class="tf">
        <label>部门：</label>
        <div class="inp"><input class="contactName" type="text" name="tbxDeptName" id="tbxDeptName" value="<?php echo $this->_tpl_vars['objUserInfo']->strDeptName; ?>
" style="width:180px;"/></div>
        <span class="info">请输入所属部门</span>
        <span class="ok">&nbsp;</span><span class="err">请输入所属部门</span>
        </div>
        <div id="divRole" <?php if ($this->_tpl_vars['objUserInfo']->iIsFinance == 1): ?> style="display:none" <?php endif; ?> class="tf">
          <label><em class="require">*</em>角色：</label>
          <div class="inp" id="divRoleSelect">
          <select name="cbRole" id="cbRole"  style="width:180px;">
          <?php $_from = $this->_tpl_vars['arrayRole']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
          <option value="<?php echo $this->_tpl_vars['data']['role_id']; ?>
" <?php if ($this->_tpl_vars['data']['is_check'] == 1): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['data']['role_name']; ?>
</option>
          <?php endforeach; endif; unset($_from); ?>
          </select>                  
          </div>
        </div>
        <div class="tf">
          <label> <em class="require">*</em>手机：</label>
          <div class="inp">
            <input class="mPhone" type="text" valid="mPhone" name="tbxPhone" id="tbxPhone" value="<?php echo $this->_tpl_vars['objUserInfo']->strPhone; ?>
" style="width:180px;"/>
          </div>
          <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
          <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
        </div>
        <div class="tf">
          <label>电话：</label>
          <div class="inp">
            <input class="fPhone" type="text" valid="fPhone" name="tbxTel" id="tbxTel" value="<?php echo $this->_tpl_vars['objUserInfo']->strTel; ?>
" style="width:180px;"/>
          </div>
          <span class="info">手机号或固定电话必须输入一项&nbsp;&nbsp;固话格式:0571-8888888</span>
        	<span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号&nbsp;&nbsp;格式:0571-8888888</span>
        </div>
        <div <?php if ($this->_tpl_vars['objUserInfo']->strUserNo == '10'): ?> style="display:none" <?php endif; ?> class="tf">
          <label>停用：</label>
          <div class="inp"><input name="chkIsLock" class="checkInp" type="checkbox" id="chkIsLock" value="1" <?php if ($this->_tpl_vars['objUserInfo']->iIsLock == 1): ?> checked="checked" <?php endif; ?>/></div>
        </div>
        <?php if ($this->_tpl_vars['canToCRM'] == 1): ?>
        <div class="tf">
          <label>开通网盟客服：</label>
          <div class="inp"><input name="chkToCRM" class="checkInp" type="checkbox" id="chkToCRM" value="1" /></div><span class="info" style="display:inline">选中后该账号可登录CRM系统查看网盟消费数据</span>
          <span class="ok">&nbsp;</span><span class="err"></span>
        </div>
        <?php endif; ?>
        <div class="tf">
          <label>备注： </label>
          <div class="inp"><textarea name="tbxRemark" cols="60" style="height:100px;" id="tbxRemark"><?php echo $this->_tpl_vars['objUserInfo']->strUserRemark; ?>
</textarea></div>
        </div>
        <div class="tf tf_submit">
        <label>&nbsp;</label>
        <div class="inp">
            <div class="ui_button ui_button_confirm">
            <button id="btnSave" class="ui_button_inner" type="submit">确认</button>
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
<?php echo ' 
<script type="text/javascript" language="javascript">
'; ?>
 
var isFinance = "<?php echo $this->_tpl_vars['isFinance']; ?>
";
<?php echo ' 
function PAccountChange(obj)
{
    var postData = "userno="+$(obj).val()+"&roleid="+$("#cbRole").val();
    if(parseInt(isFinance) == 1)
        postData += "&isfinance=1";
    else
        postData += "&isfinance=0";
        
    var data = $PostData("/?d=System&c=AgentUser&a=PAccountChange",postData);
    var roleHTML = data;
    $("#cbRole").remove();
    $("#divRoleSelect").html(roleHTML);
}

    
var _InDealWith = false;
new Reg.vf($(\'#form1\'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
if(IM.checkPhone()){IM.tip.warn(\'手机或固话必填一项\');return false;}
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
		//提交数据
        '; ?>
 				
		var formValues = "id=<?php echo $this->_tpl_vars['id']; ?>
&roles="+$("#cbRole").val()+"&"+$('#form1').serialize(); 
        <?php echo ' 
        if(parseInt(isFinance) == 1)
            formValues += "&chkIsFinance=1";
            
		MM.ajax({
			url:\'/?d=System&c=AgentUser&a=AgentUserModifySubmit\',
			data:formValues,
			success:function(q){
				q=MM.json(q);
                _InDealWith = false;
				if(q.success){
					PageBack();
					IM.tip.show(q.msg);
				}else{
					IM.tip.warn(q.msg);
				}
			}
		});
}}); 

PAccountChange($DOM("cbPAccount"));
</script>
'; ?>