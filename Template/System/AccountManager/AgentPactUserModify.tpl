<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
        <span class="declare">"<em class="require">*</em>"为必填信息</span>
    </div>
    <!--S form_bd-->
    <div class="form_bd">
        <!--S form_block_bd-->
        <form id="form1" class="newAccountForm" name="form1" action="">
            <div class="tf" style="padding-top:20px;">
                <label> 所属公司：</label>
                <div class="inp"> {$strAgentName} </div>
            </div>

            <div class="tf">
                <label><em class="require">*</em>账号名： </label>
                <div class="inp">
                {if $objUserInfo->iUserId > 0}
                <input class="contactName" type="hidden" name="tbxUserName" id="tbxUserName" value="{$objUserInfo->strUserName}" style="width:180px;"/>
                {$objUserInfo->strUserName}
                {else}
                    <input class="contactName" type="text" valid="required accountName3" name="tbxUserName" id="tbxUserName" value="{$objUserInfo->strUserName}" style="width:180px;"/>
                    <span class="info">3-32个字符，允许中英文、数字、下划线</span> <span class="ok">&nbsp;</span><span class="err">3-32个字符，允许中英文、数字、下划线</span> </div>
                {/if}
                </div>
            <div class="tf">
                <label><em class="require">*</em>姓名： </label>
                <div class="inp">
                    <input class="contactName" type="text" valid="required tbxEmpName" name="tbxEmpName" id="tbxEmpName" value="{$objUserInfo->strEName}" style="width:180px;"/>
                </div>
                <span class="info">请输入姓名</span> <span class="ok">&nbsp;</span><span class="err">请输入姓名</span> </div>
<!--            <div class="tf">
                <label><em class="require">*</em>部门： </label>
                <div class="inp">
                    <input class="contactName" type="text" valid="required tbxDept" name="tbxDept" id="tbxDept" value="{$objUserInfo->strDeptName}" style="width:180px;"/>
                </div>
                <span class="info">请输入部门</span> <span class="ok">&nbsp;</span><span class="err">请输入部门</span> </div>-->
            <div class="tf">
                <label>手机：</label>
                <div class="inp">
                    <input class="mPhone" type="text" valid="mPhone" name="tbxPhone" id="tbxPhone" value="{$objUserInfo->strPhone}" style="width:180px;"/>
                </div>
                <span class="info" style="display:inline">手机号或固定电话必须输入一项</span> 
                <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span> 
                </div>
            <div class="tf">
                <label> 电话： </label>
                <div class="inp">
                    <input class="fPhone" type="text" valid="fPhone" name="tbxTel" id="tbxTel" value="{$objUserInfo->strTel}" style="width:180px;"/></div>
                <span class="info">手机号或固定电话必须输入一项&nbsp;&nbsp;固话格式:0571-8888888</span> 
                <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号&nbsp;&nbsp;格式:0571-8888888</span> 
            </div>
            <div class="tf">
                <label> 停用：</label>
                <div class="inp">
                    <input class="checkInp" name="chkIsLock" id="chkIsLock" type="checkbox" value="1" {if $objUserInfo->iIsLock == 1} checked="checked" {/if} /> </div>
            </div>
            <div class="tf tf_submit">
                <label>&nbsp;</label>
                <div class="inp">
                    <div class="ui_button ui_button_confirm"><button id="aSubmit" name="submit" type="submit" class="ui_button_inner" tabindex="7">确 定</button></div>
                    <div class="ui_button ui_button_cancel"><button id="aSubmit" name="submit" type="button" class="ui_button_inner" tabindex="7" onclick="PageBack()">取消</button></div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--S Main--> 
{literal} 
    <script type="text/javascript" language="javascript">
               var _InDealWith = false;
                    new Reg.vf($('#form1'),{callback:function(data){
            //数据已提交，正在处理标识
                    if (_InDealWith) 
                    {
                            IM.tip.warn("数据已提交，正在处理中！");
                            return false;
                    }
        
        if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}

    {/literal} 		
            var formValues = "&agentid={$agentID}"; 		
		
    {literal} 
            _InDealWith = true;
            $.ajax({
               url:'/?d=System&c=AgentUser&a=addAccount'+formValues,
                data:$('#form1').serialize(),///+"&isLock="+($("#chkIsLock")[0].checked? "1","0")
                type:"post",
                success:function(q){
                        q=MM.json(q);
                        //q = eval("("+q+")");
                        if(q.success){
                            _InDealWith = false;
                            PageBack();
                            IM.tip.show(q.msg);
                        }else{
                            IM.tip.warn(q.msg);
                            _InDealWith = false;
                        }
                }					
            });
    }});
                                 
    </script> 
{/literal} 
