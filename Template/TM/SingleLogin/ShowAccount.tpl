<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>订单管理<span>&gt;</span>查看订单信息</div>
<!--E crumbs-->     
<!--S form_edit-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>查看账户</h2></div></div></div>
        <div class="ui_button ui_button_dis" style="float:right;" onclick="PageBack()">
            <div class="ui_button_left"></div>
            <div class="ui_button_inner">
                <div class="ui_icon ui_icon_return"></div>
                <div class="ui_text">返回</div>
            </div>
        </div>
    </div>
    <form id="J_openAccountForm">
        <div class="form_bd">
            <div class="form_block_hd"><h3 class="ui_title">客户信息</h3></div>
            <div class="form_block_bd">
                <div class="tf">
                    <label>客户名称/ID：</label>
                    <div class="inp">{$CustomerInfo.0.cus_name_id}</div>
                </div>
                <div class="tf">
                    <label>主账号/密码：</label>
                    <div class="inp">{$CustomerInfo.0.account_name_pwd}</div>
                </div>
                <div class="tf">
                    <label>客户法人：</label>
                    <div class="inp">{$CustomerInfo.0.legal_person_name}</div>
                </div>
                <div class="tf">
                    <label>联系人名称：</label>
                    <div class="inp">{$CustomerInfo.0.contact_name}</div>
                </div>
                <div class="tf">
                    <label>电子邮箱：</label>
                    <div class="inp">{$CustomerInfo.0.contact_email}</div>
                </div>
                <div class="tf">
                    <label>手机号：</label>
                    <div class="inp">{$CustomerInfo.0.contact_mobile}</div>
                </div>
                <div class="tf">
                    <label>固定电话：</label>
                    <div class="inp">{$CustomerInfo.0.contact_tel}</div>
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
           {if !empty($CloseAccount)}
              <div class="form_block_hd"><h3 class="ui_title">需关闭账户</h3></div>
            <div class="form_block_bd">
                {if empty($NeedCloseList)}
                    <div class="tf">无可关闭账户</div>
                        {else}
                {foreach from=$NeedCloseList item=data}
                <div class="tf">
                    <div class="inp">{$data.product_name} 账号名：{$data.login_name} 有效期 {$data.effect_sdate|date_format:"%Y-%m-%d"} 至 
                    <input id="close_date_{$data.aid}" class="inpDate" name="close_date_{$data.aid}" value="{if $data.account_close_time == '0000-00-00 00:00:00'}{$smarty.now|date_format:"%Y-%m-%d"}{else}{$data.account_close_time|date_format:"%Y-%m-%d"}{/if}" onfocus="WdatePicker({literal}{minDate:'%y-%M-%d'}){/literal}" type="text"/>
                    <input type="hidden" name="accountid[]" value="{$data.aid}" />
                    </div>
                </div>
                {/foreach}
                {/if}
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确 认</button></div>
                        <div class="ui_button ui_button_cancel">
                            <a class="ui_button_inner" href="javascript:;" onclick="PageBack()">取消</a>
                        </div>
                    </div>
                </div>
            </div>
                {/if}
        </div> 
    </form>
</div>	
       {if !empty($CloseAccount)} 
<script type="text/javascript">
        var SubmitUrl = '{au d="TM" c="SingleLogin" a="goCloseAccount"}';
         {literal}
new Reg.vf($('#J_openAccountForm'), {callback: function (formData) {    
        $.ajax({
                url: SubmitUrl,
                data: formData,
                dataType:"json",
                type:'post',
                success: function (q) {
                        if (q.success) {
                                IM.tip.show(q.msg);
                                JumpPage('/?d=TM&c=SingleLogin&a=ShowDoneListBack');
                        }else {
                                IM.tip.warn(q.msg);	
                    }
                }
        });
}});
    </script>
{/literal}
{/if}
