<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showBackInfoList"}')">客户管理</a><span>&gt;</span><a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMVerify" a="showVerifyList"}')">客户资料审核</a><span>&gt;</span>客户资料审核</div>
<!--E crumbs-->     
<form id="J_agentAddForm" action="" id="agentAddForm" name="agentAddForm" class="agentAddForm" method="post" enctype="multipart/form-data">
    <!--S form_edit-->
    <div class="form_edit">
        <div class="form_hd">
            <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>客户资料审核</h2></div></div></div>
            <span class="declare">"<em class="require">*</em>"为必填信息</span>
        </div>            

        <!--S form_bd-->
        <div class="form_bd">
            <div class="form_block_bd" style="padding-bottom:0;">
                <div class="table_attention marginBottom10"><label class="attention">提示：</label>客户信息如果有误请勾选 <input class="checkInp" type="checkbox" checked="checked" style="vertical-align:middle"/>，黄色区域为修改前的信息 </div>
                <div style="padding-left:18px; overflow:hidden;">
                    <div class="form_addition_inner">
                        <div class="ui_title">代理商修改类型为：</div>
                        <div class="ui_text"><b>资料审核</b></div>
                    </div>
                </div>
            </div>
            <input id="agent_customer_id" type="hidden" value="{$agent_customer_id}" name="agent_customer_id" />
            <input id="agent_id" name="agent_id" type="hidden" value="{$agent_id}"/>
            <input id="customer_id" name="customer_id" type="hidden" value="{$customer_id}"/>
            <input id="is_del" type="hidden" value="{$is_del}" name="is_del" />
            <!--S form_block_bd-->
            <div class="form_block_bd">
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
                                    <td><div class="ui_table_tdcntr" id="customer_name" name="customer_name"><div class="inp">{$customer_name}</div></div></td>
                                    <td class="even"><div class="ui_table_tdcntr">地区</div></td>
                                    <td><div class="ui_table_tdcntr" id="area_id"><div class="inp">{if $area_N neq ''}{$area_N}
                                                {else}   {$province_name}->{$city_name}->{$area_name}
                                                    {/if}  :{$address}

                                                    </div></div></td>
                                        </tr>
                                        <tr>
                                            <td class="even"><div class="ui_table_tdcntr">行业</div></td>
                                            <td><div class="ui_table_tdcntr" id="industry_id"><div class="inp">{if $check_uid eq 0}
                                                        {$industry_fullname}
                                                        {else}
                                                            {$industryFullname}
                                                            {/if}</div></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">经营模式</div></td>
                                                    <td><div class="ui_table_tdcntr" id="business_model"><div class="inp">{$business_model}</div></div></td>
                                                </tr>
                                            <input type="hidden" id = "aid" name="aid" value={$aid} />
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">主营业务</div></td>
                                                <td><div class="ui_table_tdcntr" id="main_business"><div class="inp">{$main_business}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">主要市场</div></td>
                                                <td><div class="ui_table_tdcntr" id="major_markets"><div class="inp">{$major_markets}</div></div></td>
                                            </tr>
                                            <input type="hidden" id="keyValue" name="keyValue" value={$keyValue}>
                                            <input type="hidden" id="is_contact" name="is_contact" value="">
                                            <input id="contact_id" name="contact_id" type="hidden" value="{$contact_id}" />
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">公司简介</div></td>
                                                <td><div class="ui_table_tdcntr" id="company_profile"><div class="inp">{$company_profile}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                                <td><div class="ui_table_tdcntr" id="company_scope"><div class="inp">{$company_scope}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">注册状态</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_status"><div class="inp">{if $reg_status eq -1}   {else} {$reg_status}{/if}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_date"><div class="inp">{$reg_date}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                                <td><div class="ui_table_tdcntr" id="website"><div class="inp">{$website}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>

                                                <td><div class="ui_table_tdcntr" id="reg_place"><div class="inp">{$reg_place2}</div></div></td>

                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                                <td><div class="ui_table_tdcntr" id="postcode"><div class="inp">{$postcode}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">客户来源</div></td>
                                                <td><div class="ui_table_tdcntr" id="customer_from"><div class="inp">{if $customer_from eq -1}   {else} {$customer_from}{/if}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">网络推广情况</div></td>
                                                <td><div class="ui_table_tdcntr" id="net_extension_about"><div class="inp">{$net_extension_about}</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr" id="business_scope"><div class="inp">{$business_scope}</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                                <td><div class="ui_table_tdcntr" id="annual_sales"><div class="inp">{$annual_sales}元</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_capital"><div class="inp">{$reg_capital}元</div></div></td>
                                            </tr>
                                            </tbody>
                                        </table>   
                                    </div>
                                </div>                    
                                <div class="list_table_main ">
                                    <div class="ui_table ui_table_nohead">
                                        <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">负责人信息</h4></div></div>
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="ui_table_bd">
                                                <tr>
                                                    <td class="even"><div class="ui_table_tdcntr">姓名</div></td>
                                                    <td><div class="ui_table_tdcntr" id="contact_name"><div class="inp">{$contact_name}</div> 
                                                            {if $isCharge1 eq 1}
                                                                <input type="checkbox" class="checkInp"  name="isCharge" value="1" 
                                                                       style="margin-top:3px; vertical-align:middle" checked="checked" />负责人改为"{$contactName1}"
                                                            {/if}

                                                        </div>
                                                    </td>
                                                    <td class="even"><div class="ui_table_tdcntr">性别</div></td>
                                                    <td><div class="ui_table_tdcntr" id="contact_sex"><div class="inp">{if $contact_sex eq 0}
                                                                男
                                                                {elseif $contact_sex eq 1}
                                                                    女
                                                                    {/if}</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_mobile"><div class="inp">{$contact_mobile}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_tel"><div class="inp">{$contact_tel}</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_fax"><div class="inp">{$contact_fax}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_email"><div class="inp">{$contact_email}</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">职位</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_position"><div class="inp">{$contact_position}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">备注</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_remark"><div class="inp">{$contact_remark}</div></div></td>

                                                        </tr>
                                                        <!--<tr>
                                                            <td class="even"><div class="ui_table_tdcntr">网络意识</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_net_awareness"><div class="inp">{if $contact_net_awareness eq -1}   {else} {$contact_net_awareness}{/if}</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">重要程度</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_importance"><div class="inp">{if $contact_importance eq -1}   {else} {$contact_importance}{/if}</div></div></td>
                                                        </tr>-->
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
                                                <div class="ui_button ui_button_confirm"><button id="btnSave" type="button" class="ui_button_inner">确 认</button></div>
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
var change_values={$change_values};//被修改的信息

                            {literal}
//显示被修改的信息
$(function(){
    if(change_values){
        $.addModifiedCustomerInfo(change_values);//输出被修改的项
    }
    $('#btnSave').click(function(){
        if($("#to_anget_id").val()=="-1")
        {
            IM.tip.warn('请选择代理商');
            return false;
        }
        var s = $('#agent_customer_id').val();
        
        $.ajax({
            type:'POST',
            dataType: "text",
            url:$.currentBasePathGet() + "?c=CMVerify&d=CM&a=verify&agent_customer_id="+s,
            data:$.setChangedPostData(),
    		success:function(data)
    		{
    			if($.trim(data)== 1)
    			{
                            IM.tip.show('审核成功！');
                            JumpPage("/?c=CMVerify&d=CM&a=showVerifyList");
    			}
    			if($.trim(data)== -1)
    			{
                            IM.tip.show('审核不通过！');
                            JumpPage("/?c=CMVerify&d=CM&a=showVerifyList");
    			}
    		}
    	});
    });
    $("#check_status").change(function(){
        var checked=$(this).val()=="-1"?true:false;
        $("form input:checkbox").each(function(){
            this.checked=checked;
        });
    });
});
                            {/literal}
                        </script>