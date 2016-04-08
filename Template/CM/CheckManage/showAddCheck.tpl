<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->     
<form id="J_agentAddForm" action="" name="agentAddForm" class="agentAddForm" method="post" enctype="multipart/form-data">
    <!--S form_edit-->
    <div class="form_edit">
        <div class="form_hd">
            <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{if $CheckType =="2"}修改客户审核{else}新增客户审核{/if}</h2></div></div></div>
        </div>            
        <div class="form_bd">
            <div class="form_block_bd">
                {if $CheckType == "2"}<div class="table_attention marginBottom10"><label class="attention">提示：</label>客户信息如果有误请勾选 <input type="checkbox" checked="checked" class="checkInp" style="vertical-align:middle">，黄色区域为修改前的信息 </div>{else}
                    <div class="table_attention marginBottom10"><label class="attention">提示：</label>添加审核不通过，则该客户不会入代理商个人客户库</div>
                {/if}
                <div class="list_table_main marginBottom10 ">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd">
                            <div class="ui_table_hd_inner">
                                <!--调好了在上
                           <a class="ui_button ui_link" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showVerifyModifyBack"}&customer_id={$customer_id}')"><span class="ui_icon ui_icon_edit">&nbsp;</span>编辑11</a>
                                -->
                                <h4 class="title">企业信息</h4>
                            </div>
                        </div>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody class="ui_table_bd">
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">客户名</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr" id="customer_name" >
                                            <div class="inp">
                                                {$CustomerInfo.customer_name}
                                            </div>
                                            {if isset($CustomerInfo.customer_name_old)}
                                            <div class="inp_add">
                                                <input name="customer_name" id="customer_name" class="checkInp" value="{$CustomerInfo.customer_name_old}" type="checkbox" />
                                                <em>{$CustomerInfo.customer_name_old}</em>
                                            </div>
                                            {/if}
                                        </div>
                                    </td>
                                    <td class="even"><div class="ui_table_tdcntr">地区</div></td>
                                    <td><div class="ui_table_tdcntr" id="area_id"><div class="inp">{$CustomerInfo.area_name}</div></div></td>
                                        </tr>
                                        <tr>
                                            <td class="even"><div class="ui_table_tdcntr">行业</div></td>
                                            <td><div class="ui_table_tdcntr" id="industry_id"><div class="inp">{$CustomerInfo.industry_name}</div></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">经营模式</div></td>
                                                    <td><div class="ui_table_tdcntr" id="business_model"><div class="inp">{$CustomerInfo.business_model}</div></div></td>
                                                </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">主营业务</div></td>
                                                <td><div class="ui_table_tdcntr" id="main_business"><div class="inp">{$CustomerInfo.main_business}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">主要市场</div></td>
                                                <td><div class="ui_table_tdcntr" id="major_markets"><div class="inp">{$CustomerInfo.major_markets}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">公司简介</div></td>
                                                <td><div class="ui_table_tdcntr" id="company_profile"><div class="inp">{$CustomerInfo.company_profile}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                                <td><div class="ui_table_tdcntr" id="company_scope"><div class="inp">{$CustomerInfo.company_scope}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">注册状态</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_status"><div class="inp">{$CustomerInfo.reg_status}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_date"><div class="inp">{if $CustomerInfo.reg_date != '0000-00-00'}{$CustomerInfo.reg_date}{/if}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                                <td><div class="ui_table_tdcntr" id="website"><div class="inp">{$CustomerInfo.website}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_place"><div class="inp">{$CustomerInfo.reg_full_place}</div></div></td>

                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                                <td><div class="ui_table_tdcntr" id="postcode"><div class="inp">{$CustomerInfo.postcode}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">客户来源</div></td>
                                                <td><div class="ui_table_tdcntr" id="customer_from"><div class="inp">{$CustomerInfo.customer_from}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">网络推广情况</div></td>
                                                <td><div class="ui_table_tdcntr" id="net_extension_about"><div class="inp">{$CustomerInfo.net_extension_about}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr" id="business_scope"><div class="inp">{$CustomerInfo.business_scope}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                                <td><div class="ui_table_tdcntr" id="annual_sales"><div class="inp"><b class="amountStyle">{$CustomerInfo.annual_sales}</b></div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_capital"><div class="inp"><b class="amountStyle">{$CustomerInfo.reg_capital}</b></div></div></td>
                                            </tr>
                                            </tbody>
                                        </table>   
                                    </div>
                                </div>                  
                               {if $CheckType == 1}
                                <div class="list_table_main ">
                                    <div class="ui_table ui_table_nohead">
                                        <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">负责人信息</h4></div></div>
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="ui_table_bd">
                                                <tr>
                                                    <td class="even"><div class="ui_table_tdcntr">姓名</div></td>
                                                    <td><div class="ui_table_tdcntr" id="contact_name"><div class="inp">{$ContantInfo->strContactName}</div> 
                                                        </div>
                                                    </td>
                                                    <td class="even"><div class="ui_table_tdcntr">性别</div></td>
                                                    <td><div class="ui_table_tdcntr" id="contact_sex"><div class="inp">{if $ContantInfo->iContactSex eq 0}
                                                                男
                                                                {elseif $contact_sex eq 1}
                                                                    女
                                                                    {/if}</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_mobile"><div class="inp">{$ContantInfo->strContactMobile}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_tel"><div class="inp">{$ContantInfo->strContactTel}</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_fax"><div class="inp">{$ContantInfo->strContactFax}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_email"><div class="inp">{$ContantInfo->strContactEmail}</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">职位</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_position"><div class="inp">{$ContantInfo->strContactPosition}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">备注</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_remark"><div class="inp">{$ContantInfo->strContactRemark}</div></div></td>

                                                        </tr>
                                                    </tbody>
                                                </table>   
                                            </div>
                                        </div>                                   
                                    </div>
                                        {/if}
                                    <!--E form_block_bd-->     
                                    <!--S form_block_ft-->
                                    <div class="form_block_ft">
                                        <div class="agentAuditBlock">
                                            <div class="tf">
                                                <label>审核状态：</label>
                                                <div class="inp">
                                                    <div class="ui_comboBox">
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
{if $CheckType == "2"}
    var SubmitUrl = '{au d="CM" c="CMVerify" a="EditCheckInfo"}&logid={$smarty.get.aid}';
 {else}
      var SubmitUrl = '{au d="CM" c="CMVerify" a="AddCheckInfo"}&logid={$smarty.get.aid}';
     {/if}

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
                                                PageBack();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
//    $("#check_status").change(function(){
//        var checked=$(this).val()=="-1"?true:false;
//        $("form input:checkbox").each(function(){
//            this.checked=checked;
//        });
//    });
});
                            {/literal}
                        </script>