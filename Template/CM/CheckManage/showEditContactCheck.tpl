<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->     
<form id="J_agentAddForm" action="" name="agentAddForm" class="agentAddForm" method="post" enctype="multipart/form-data">
    <!--S form_edit-->
    <div class="form_edit">
        <div class="form_hd">
            <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>联系人审核</h2></div></div></div>
        </div>            
        <div class="form_bd">
            <div class="form_block_bd" style="padding-bottom:0;"> 
                <div class="table_attention">
                    <label class="attention">提示：</label>客户信息如果有误请勾选 <input type="checkbox" checked="checked" class="checkInp" style="vertical-align:middle">，黄色区域为修改前的信息 
                </div>       
		</div> 
            <div class="form_block_bd">              
                <div class="list_table_main ">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">负责人信息</h4></div></div>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody class="ui_table_bd">
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">姓名</div></td>
                                    <td><div class="ui_table_tdcntr">
                                            <div class="inp">{if !empty($ContactInfo.contact_name)}{$ContactInfo.contact_name}{else}&nbsp;{/if}</div>
                                            {if isset($ContactInfo.contact_name_old)}
                                            <div class="inp_add">
                                                <input name="contact_name" id="contact_name" class="checkInp" value="{$ContactInfo.contact_name_old}" type="checkbox" />
                                                <em>{$ContactInfo.contact_name_old}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                    <td class="even"><div class="ui_table_tdcntr">角色</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr" >
                                            <div class="inp">{if $ContactInfo.isCharge =="1" }负责人{else}非负责人{/if}</div>
                                            {if isset($ContactInfo.isCharge_old)}
                                            <div class="inp_add">
                                                <input name="isCharge" id="isCharge"  class="checkInp" value="{$ContactInfo.isCharge_old}" type="checkbox" />
                                                <em>{if $ContactInfo.isCharge_old =="1" }负责人{else}非负责人{/if}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr">
                                            <div class="inp">{if !empty($ContactInfo.contact_mobile)}{$ContactInfo.contact_mobile}{else}&nbsp;{/if}</div>
                                            {if isset($ContactInfo.contact_mobile_old)}
                                            <div class="inp_add">
                                                <input name="contact_mobile" id="contact_mobile"  class="checkInp" value="{$ContactInfo.contact_mobile_old}" type="checkbox" />
                                                <em>{$ContactInfo.contact_mobile_old}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                    <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr" >
                                            <div class="inp">{if !empty($ContactInfo.contact_tel)}{$ContactInfo.contact_tel}{else}&nbsp;{/if}</div>
                                            {if isset($ContactInfo.contact_tel_old)}
                                            <div class="inp_add">
                                                <input name="contact_tel" id="contact_tel"  class="checkInp" value="{$ContactInfo.contact_tel_old}" type="checkbox" />
                                                <em>{$ContactInfo.contact_tel_old}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr" id="contact_fax">
                                            <div class="inp">{if !empty($ContactInfo.contact_fax)}{$ContactInfo.contact_fax}{else}&nbsp;{/if}</div>
                                            {if isset($ContactInfo.contact_fax_old)}
                                            <div class="inp_add">
                                                <input name="contact_fax" id="contact_fax"  class="checkInp" value="{$ContactInfo.contact_fax_old}" type="checkbox" />
                                                <em>{$ContactInfo.contact_fax_old}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                    <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr">
                                            <div class="inp">{if !empty($ContactInfo.contact_email)}{$ContactInfo.contact_email}{else}&nbsp;{/if}</div>
                                            {if isset($ContactInfo.contact_email_old)}
                                            <div class="inp_add">
                                                <input name="contact_email" id="contact_email"  class="checkInp" value="{$ContactInfo.contact_email_old}" type="checkbox" />
                                                <em>{$ContactInfo.contact_email_old}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">职位</div></td>
                                    <td><div class="ui_table_tdcntr" id="contact_position"><div class="inp">{$ContactInfo.contact_position}</div></div></td>
                                    <td class="even"><div class="ui_table_tdcntr">性别</div></td>
                                    <td><div class="ui_table_tdcntr" id="contact_remark"><div class="inp">{if $ContactInfo.contact_sex == 1}女{else}男{/if}</div></div></td>
                                </tr>
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">备注</div></td>
                                    <td colspan="3">
                                        <div class="ui_table_tdcntr" id="contact_remark"><div class="inp">{$ContactInfo.contact_remark}</div></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>   
                    </div>
                </div>                                   
            </div>
            <!--E form_block_bd-->     
            <!--S form_block_ft-->
            <div class="form_block_ft">
                <div class="agentAuditBlock">
                    <div class="tf">
                        <label>审核状态：</label>
                        <div class="inp">
                            <div class="ui_comboBox">
                                <input type="hidden" name="logid" value="{$LogId}" />
                                <input type="hidden" name="contactid" value="{$ContactInfo.contact_id}" />
                                <select name="check_status" id="check_status">
                                    <option value="1">审核通过</option>
                                    <option value="-1">审核不通过</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tf">
                        <label>审核备注：</label>
                        <div class="inp"><textarea id="check_remark" name="check_remark" class=""></textarea></div>
                    </div>
                </div>
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">
                        <div class="ui_button ui_button_confirm"><button id="btnSave" type="submit" class="ui_button_inner">确 认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack()">取消</a></div>
                    </div>
                </div>
            </div>
            <!--E form_block_ft-->
        </div>
        <!--E form_bd-->

    </div>
    <!--E form_edit-->
</form>
<script type="text/javascript">
    var SubmitUrl = "{au d="CM" c="CMVerify" a="EditContactCheck"}";
    {literal}
//显示被修改的信息
$(function(){
    new Reg.vf($('#J_agentAddForm'),{isEncode:false,
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式
                	var formValues = $('#J_agentAddForm').serialize();                
                 	$.ajax({
	                        type: "POST",
	                        dataType: "json",
	                        url: SubmitUrl,
	                        data: formValues,
	                        success: function (q) {
					if(q.success){
						IM.tip.show(q.msg);
                                                JumpPage(q.url);
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
});
    {/literal}
</script>