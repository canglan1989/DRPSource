<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;">订单管理</a><span>&gt;</span>查看订单信息</div>
<!--E crumbs-->     
<!--S form_edit-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>开通账户</h2></div></div></div>
        <div class="ui_button ui_button_dis" style="float:right;" onclick="PageBack()">
            <div class="ui_button_left"></div>
            <div class="ui_button_inner">
                <div class="ui_icon ui_icon_return"></div>
                <div class="ui_text">返回</div>
            </div>
        </div>
    </div>
    <form id="J_openAccountForm">
        <input type="hidden" value="{$sso_info->mainOrderId}" name="sso_main_order_id">
        <input type="hidden" value="{$order_id}" name="orderId">
        <input type="hidden" value="{$sso_info->userId}" name="sso_userId">
        <input type="hidden" value="{$sso_info->customerId}" name="sso_customerId">
        <input type="hidden" value="{$CustomerInfo.0.product_type_id}" name="product_type_id">
        <div class="form_bd">
            <div class="form_block_hd"><h3 class="ui_title">客户信息</h3></div>
            <div class="form_block_bd">
                <div class="tf">
                    <label>客户名称/ID：</label>
                    <div class="inp">{$CustomerInfo.0.cus_name_id}</div>
                </div>
                <div class="tf">
                    <label>主账号/密码：</label>
                    <div class="inp">{$main_account.0.account_name_pwd}</div>
                </div>
                <div class="tf">
                    <label>客户法人：</label>
                    <div class="inp">{$CustomerInfo.0.legal_person_name}</div>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>联系人名称：</label>
                    <div class="inp"><input type="text" valid="required" name="contact_name" value="{$CustomerInfo.0.contact_name}"></div>
                    <span class="info">请正确输入联系人名称</span>
                    <span class="ok">&nbsp;</span><span class="err">请正确输入联系人名称</span>
                </div>
                <div class="tf">
                    <label>电子邮箱：</label>
                    <div class="inp"><input type="text" id="charge_email" valid="email" name="contact_email" class="email" value="{$CustomerInfo.0.contact_email}"></div>
                    <span class="info">请输入正确邮箱</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>手机号：</label>
                    <div class="inp"><input type="text" valid="mPhone" name="contact_mobile" value="{$CustomerInfo.0.contact_mobile}" class="mPhone"></div>
                    <span class="info" style="display:inline">固定电话与手机号一项必填</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>固定电话：</label>
                    <div class="inp"><input type="text" valid="fPhone" name="contact_tel" class="fPhone" value="{$CustomerInfo.0.contact_tel}"></div>
                    <span class="info">固话格式:0571-8888888</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号</span>
                </div>
            </div>
            <div class="form_block_hd"><h3 class="ui_title">已开通的账号</h3></div>
            <div class="form_block_bd">
                <div class="list_table_main">
                    <div class="ui_table" id="J_ui_table">                    	
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <thead class="ui_table_hd">
                                <tr>
                                    <th title="订单号"><div class="ui_table_thcntr"><div class="ui_table_thtext">订单号</div></div></th>
                            <th title="产品"><div class="ui_table_thcntr"><div class="ui_table_thtext">产品</div></div></th>
                            <th title="账号"><div class="ui_table_thcntr"><div class="ui_table_thtext">账号</div></div></th>
                            <th title="账号密码"><div class="ui_table_thcntr"><div class="ui_table_thtext">账号密码</div></div></th>
                            <th style="width:200px;" title="帐号有效期"><div class="ui_table_thcntr"><div class="ui_table_thtext">帐号有效期</div></div></th>
                            <th style="width:80px;" title="状态"><div class="ui_table_thcntr"><div class="ui_table_thtext">状态</div></div></th>
                            </tr>
                            </thead>
                            <tbody class="ui_table_bd">
                                {foreach from=$AccountInfo item=arr}
                                    <tr>
                                        <td title=""><div class="ui_table_tdcntr">{$arr.order_no}</div></td>
                                        <td title=""><div class="ui_table_tdcntr">{$arr.product_name}</div></td>
                                        <td title=""><div class="ui_table_tdcntr">{$arr.login_name}</div></td>
                                        <td title=""><div class="ui_table_tdcntr">{$arr.login_pwd}</div></td>
                                        <td title=""><div class="ui_table_tdcntr">{$arr.effect_date}</div></td>
                                        <td title=""><div class="ui_table_tdcntr">{$arr.login_state}</div></td>
                                    </tr>  
                                {/foreach}           
                            </tbody>
                        </table>     
                    </div>
                    <!--E ui_table-->
                </div>
            </div>
            <div class="form_block_hd"><h3 class="ui_title">新建账号</h3></div>
            <div class="form_block_bd">
                <div class="tf">
                    <label>产品：</label>
                    <div class="inp">{$CustomerInfo.0.product_name}</div>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>账号名：</label>
                    <div class="inp"><input readonly="true" type="text" valid="required " name="login_name"  value="{$sso_info->userLogin}" ></div>
                    <span class="info">请输入账号名</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入正确账号名</span>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>密码：</label>
                    <div class="inp"><input readonly="true" type="password" valid="required " name="login_pwd" value="{$sso_info->userPassword}" ></div>
                    <span class="info">请输入账号名</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入正确账号名</span>
                </div>
                <div class="tf">
                    <label>有效期：</label>
                    <div class="inp">{$CustomerInfo.0.order_sdate}至{$CustomerInfo.0.order_edate}</div>
                </div>
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">
                        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 认</button></div>
                        <div class="ui_button ui_button_cancel">
                            <a onclick="PageBack()" href="javascript:;" class="ui_button_inner">取消</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!--E sidenav_neighbour-->
{literal}
    <script type="text/javascript">
var _InDealWith = false;
new Reg.vf($('#J_openAccountForm'), {callback: function (formData) {
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
		if(!IM.IsSending(true)){return false;}
        _InDealWith = true;
        MM.ajax({
                url: '/?d=TM&c=SingleLogin&a=SaveAccount',
                data: formData,
                success: function (q) {
                    //alert(q);return false;
						IM.IsSending(false);
                        q=MM.json(q);
                        if (q.success) {
                                IM.tip.show(q.msg);
                                JumpPage('/?d=TM&c=SingleLogin&a=ShowWaitListBack');
		    _InDealWith = false;
        }else {
                                IM.tip.warn(q.msg);	
		    _InDealWith = false;
        }
                }
        });
}});
    </script>
{/literal}
