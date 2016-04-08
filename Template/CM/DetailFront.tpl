<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>客户档案</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2>客户档案</h2>
                </div>
            </div>
        </div>
        <div class="form_hd_oper">
            <a href="javascript:;" onclick="PageBack()" class="ui_button ui_button_dis"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
            {if $canedit <6}
            <a href="javascript:;" onclick="showContactInfo({$customerFront.0.customer_id})" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div><div class="ui_text">添加联系人</div></div></a>
            {/if}
            {if $canedit == 0}
            <a href="javascript:;" onclick="showAddContactRecode({$customerFront.0.customer_id})" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div><div class="ui_text">添加联系小记</div></div></a>
            <a href="javascript:;" onclick="showAddVisitInvite({$customerFront.0.customer_id})" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div><div class="ui_text">添加拜访预约</div></div></a>
      {if $customerFront.0.history_check == "1" }
          {if $valueProduct == 1}
            <a href="javascript:;" onclick="JumpPage('{au d="OM" c="Order" a="UnitOrderPostStep1"}&customer_id={$customerFront.0.customer_id}')" class="ui_button">
                <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                    <div class="ui_icon ui_icon_open"></div>
                    <div class="ui_text">提交网盟订单</div>
                </div>
            </a>
                {/if}
                 {if $unitProduct == 1}
            <a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showCustomerOrderFront"}&customer_id={$customerFront.0.customer_id}')" class="ui_button">
                <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                    <div class="ui_icon ui_icon_open"></div>
                    <div class="ui_text">提交增值订单</div>
                </div>
            </a>
                {/if}
                {/if}
            {/if}
        </div>
    </div>
    <div class="form_bd">
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10">
                <div class="ui_table ui_table_nohead">
                    <div class="ui_table_hd"><div class="ui_table_hd_inner">
                            {if $canedit < 6 || $HasCheck == "0"}
                            <a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showModifyFront"}&customer_id={$customerFront.0.customer_id}')" class="ui_button ui_link"><span class="ui_icon ui_icon_edit">&nbsp;</span>修改客户基本信息</a>{/if}
                        <h4 class="title">客户基本信息</h4>
                        {if $HasCheck == 1}（该客户有信息在审核中，不能编辑）{/if}
                        </div></div>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody class="ui_table_bd">
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">客户名称</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.customer_name}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">行业</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.industry_name}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">法人姓名</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.legal_person_name}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">法人身份证号码</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.legal_person_id}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">详细地址</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.area_name}->{$customerFront.0.address}</div></td>

                                <td class="even"><div class="ui_table_tdcntr">公司营业执照注册号</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.business_license}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">来源</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.customer_resource_name}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">主营业务</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.main_business}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">经营模式</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.business_model}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">主要市场</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.major_markets}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.business_scope}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">规模(人数)</div></td>
                                <td><div class="ui_table_tdcntr">{if $customerFront.0.company_scope != ""}{$customerFront.0.company_scope} 人{/if}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                <td><div class="ui_table_tdcntr"><b class="amountStyle">{if $customerFront.0.reg_capital !=""}{$customerFront.0.reg_capital} 万元{/if}</b></div></td>
                                <td class="even"><div class="ui_table_tdcntr">网络推广情况</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.net_extension_about}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                                <td><div class="ui_table_tdcntr">{if $customerFront.0.reg_place != -1}{$customerFront.0.reg_place}{/if}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">年营业额</div></td>
                                <td><div class="ui_table_tdcntr"><b class="amountStyle">{if $customerFront.0.annual_sales != ""}{$customerFront.0.annual_sales} 万元{/if}</b></div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">注册状态</div></td>
                                <td>
                                    {if $customerFront.0.reg_status neq -1}
                                        <div class="ui_table_tdcntr">{$customerFront.0.reg_status}</div>
                                    {/if}
                                </td>
                                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.website}</div></td>
                                <!--
                                <td class="even"><div class="ui_table_tdcntr">详细地址</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.province_name}->{$customerFront.0.city_name}->{$customerFront.0.area_name}->{$customerFront.0.address}</div></td>
                                -->
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">注册日期</div></td>
                                <td><div class="ui_table_tdcntr">{if $customerFront.0.reg_date != '0000-00-00'}{$customerFront.0.reg_date}{/if}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">邮编</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.postcode}</div></td>
                            </tr>
                            <tr class="">
                                <td class="even"><div class="ui_table_tdcntr">公司简介</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.company_profile}</div></td>
                                <td class="even"><div class="ui_table_tdcntr">录入时间</div></td>
                                <td><div class="ui_table_tdcntr">{$customerFront.0.create_time}</div></td>
                                <!--
                                 <td class="even"><div class="ui_table_tdcntr">意向产品</div></td>
                                 <td><div class="ui_table_tdcntr">{$customerFront.0.intention_name}</div></td>
                                -->
                            </tr>
                        </tbody>
                    </table>             
                </div>
            </div>

            <div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title">
                            <span class="ui_icon list_table_title_icon"></span>
                            客户联系人信息
                        </h4>
                        {if $canedit < 6 }
                        <a class="ui_button ui_link" onclick="showContactInfo({$customerFront.0.customer_id})" href="javascript:;">
                                <span class="ui_icon ui_icon_add2">&nbsp;</span>
                                添加联系人
                            </a>
                                {/if}
                        </div>
                    </div>
                </div>
                <div class="list_table_main marginBottom10">
                    <div id="J_ui_table" class="ui_table">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <thead class="ui_table_hd">
                                <tr>
                                    <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">姓名</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">性别</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">职位</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">电话号码</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">手机号码</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">传真</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">备注</div>
                            </div>
                            </th>
                            <th>
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">操作</div>
                            </div>
                            </th>
                            </tr>
                            </thead>
                            <tbody class="ui_table_bd">
                                {foreach from=$customerContactFront item=data key=index}
                                    <tr>


                                        <!--联系人姓名【是否是负责人】  -->
                                        <td title="{$data.contact_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="showConatctCard({$data.contact_id})">{$data.contact_name}{$data.isCharge_name}</a></div></td>

                                        <!--性别 -->
                                        <td title="{$data.contact_sex_name}"><div class="ui_table_tdcntr">{$data.contact_sex_name}</div></td>

                                        <!--职位 -->
                                        <td title="{$data.contact_position}"><div class="ui_table_tdcntr">{$data.contact_position}</div></td>
                                        <!--固定电话 -->
                                        <td title="{$data.contact_tel}"><div class="ui_table_tdcntr">{$data.contact_tel}</div></td>
                                        <!--手机 -->
                                        <td title="{$data.contact_mobile}"><div class="ui_table_tdcntr">{$data.contact_mobile}</div></td>
                                        <!--传真 -->
                                        <td title="{$data.contact_fax}"><div class="ui_table_tdcntr">{$data.contact_fax}</div></td>
                                        <!--备注 -->
                                        <td title="{$data.contact_remark}"><div class="ui_table_tdcntr">{$data.contact_remark}</div></td>
                                        <!--操作 -->
                                        <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
                                                    {if $caneidt < 6 }
                                                        <li><a  href="javascript:;" onclick="showModifyContact({$data.contact_id})">编辑</a></li>
                                                        {if $data.isCharge_name eq ""}
                                                            <li><a  href="javascript:;" onclick="IM.account.delOper('{au d="CM" c="CMInfo" a="delContact"}&contact_id={$data.contact_id}',{literal}{{/literal}contact_id:{$data.contact_id}{literal}}{/literal},'删除联系人',this)">删除</a></li>

                                                        {/if}
                                                        {/if}
                                                </ul>
                                            </div>
                                        </td>  
                                    </tr>
                                 {foreachelse}
                                    <tr><td colspan="8" title="无联系小记"><div class="ui_table_tdcntr">无联系小记</div></td></tr>
                                {/foreach}  
                            </tbody>
                        </table>             
                    </div>
                </div>

                <div class="list_table_head">
                    <div class="list_table_head_right">
                        <div class="list_table_head_mid">
                            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>联系小记列表</h4>
                            {if $canedit == 0}
                                    <span class="declare"><a href="javascript:;" onclick="JumpPage('/?d=CM&c=ContactRecord&a=ContactRecordList&customerID={$customerFront.0.customer_id}')">更多>></a></span>
                                    <a onclick="showAddVisitInvite({$customerFront.0.customer_id})" href="javascript:;" class="ui_button ui_link"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加拜访预约</a>
                                    <a onclick="showAddContactRecode({$customerFront.0.customer_id})" href="javascript:;" class="ui_button ui_link"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系小记</a>
                                    {/if}
                        </div>
                    </div>
                </div>
                <div class="list_table_main marginBottom10">
                    <div id="J_ui_table" class="ui_table">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <thead class="ui_table_hd">
                                <tr>
                                    <th width="80" title="操作人">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">操作人</div>
                            </div>
                            </th>
                            <th width="80" style="" title="被联系人">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">被联系人</div>
                            </div>
                            </th>             					
                            <th width="185" title="联系电话">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">联系电话</div>
                            </div>
                            </th>
                            </th>             					
                            <th width="145" title="联系时间">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">联系时间</div>
                            </div>
                            </th>
                            <th width="90" title="是否有效联系">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">是否有效联系</div>
                            </div>
                            </th>
                            <th title="小记内容">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">小记内容</div>
                            </div>
                            </th>
                            <th width="75" title="回访状态">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">回访状态</div>
                            </div>
                            </th>
                            <th title="意向评级" width="60">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">意向评级</div>
                            </div>
                            </th>   
                            </tr>
                            </thead>
                            <tbody class="ui_table_bd">
                                {foreach from=$customerContactRecode item=data key=index} 
                                    <tr>
                                        <!--操作人姓名 --> 
                                        <td title="{$data.user_name}"><div class="ui_table_tdcntr">{$data.user_name}</div></td>
                                        <!--被联系人姓名 -->
                                        <td title="{$data.contact_name}"><div class="ui_table_tdcntr">{$data.contact_name}</div></td>
                                        <!--被联系人电话 -->
                                        <td title="{$data.contact_tel}"><div class="ui_table_tdcntr">{if $data.contact_mobile eq ''}
                                                {$data.contact_tel}
                                                {elseif $data.contact_tel eq ''}
                                                    {$data.contact_mobile}
                                                    {else}
                                                        {$data.contact_mobile}/{$data.contact_tel}
                                                        {/if}</div></td>
                                                    <!--联系时间 -->
                                                    <td title="{$data.contact_time}"><div class="ui_table_tdcntr">{$data.contact_time}</div></td>
                                                    
                                                    <td title="{if $data.not_valid_contact_id > 0}否{else}是{/if}"><div class="ui_table_tdcntr">
                                                            {if $data.not_valid_contact_id > 0}否{else}是{/if}
                                                        </div></td>
                                                        <td title="{if $data.not_valid_contact_id > 0}{$data.not_valid_contact_name}{else}{$data.contact_recode}{/if}"><div class="ui_table_tdcntr">
                                                            {if $data.not_valid_contact_id > 0}
                                                                {$data.not_valid_contact_name}
                                                            {else}
                                                                {$data.contact_recode}
                                                            {/if}
                                                        </div></td>
                                                        
                                                        <td title="{if $data.revisit_uid > 0}已回访{else}未回访{/if}"><div class="ui_table_tdcntr">
                                                            {if $data.revisit_uid > 0}<a href="javascript:void(0)" onclick="ShowRevisitCard({$data.recode_id})">已回访</a>{else}未回访{/if}
                                                        </div></td>
                                                        
                                                    <!--意向评级 -->
                                                    <td title="{$data.intention_rating_name}"><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
                                                </tr>
                                                {foreachelse}
                                                    <tr><td colspan="8" title="无联系小记"><div class="ui_table_tdcntr">无联系小记</div></td></tr>
                                                {/foreach}
                                                </tbody>
                                            </table>             
                                        </div>
                                    </div>
                                                    <div class="list_table_head">
                                                        <div class="list_table_head_right">
                                                            <div class="list_table_head_mid">
                                                                <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>订单明细</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list_table_main">
                                                        <div id="J_ui_table" class="ui_table">
                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                <thead class="ui_table_hd">
                                                                    <tr>
                                                                        <th title="操作人">
                                                                <div class="ui_table_thcntr">
                                                                    <div class="ui_table_thtext">订单号</div>
                                                                </div>
                                                                </th>
                                                                <th style="" title="被联系人">
                                                                <div class="ui_table_thcntr ">
                                                                    <div class="ui_table_thtext">产品名称</div>
                                                                </div>
                                                                </th>             					
                                                                <th title="联系电话">
                                                                <div class="ui_table_thcntr">
                                                                    <div class="ui_table_thtext">订单状态</div>
                                                                </div>
                                                                </th>
                                                                </th>             					
                                                                <th title="联系时间">
                                                                <div class="ui_table_thcntr">
                                                                    <div class="ui_table_thtext">订单提交人</div>
                                                                </div>
                                                                </th>
                                                                <th title="小记内容">
                                                                <div class="ui_table_thcntr">
                                                                    <div class="ui_table_thtext">订单提交时间</div>
                                                                </div>
                                                                </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="ui_table_bd">
                                                                {foreach from=$OrderList item=data key=key}
                                                                    <tr>
                                                                <td title="{$data.order_no}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="JumpPage('{au d="OM" c="Order" a="OrderDetail"}&id={$data.order_id}')">{$data.order_no}</a></div></td>
                                                                <td title="{$data.product_name}"><div class="ui_table_tdcntr">{$data.product_name}</div></td>
                                                                <td title="{$data.order_state_cn}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="OrderStatusInfo({$data.order_id})">{$data.order_state_cn}</a></div></td>
                                                                <td title="{$data.create_user_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a></div></td>
                                                                <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                                                                {foreachelse}
                                                                    <td colspan="5" title="无订单"><div class="ui_table_tdcntr">无订单</div></td>
                                                                {/foreach}
                                                                    </tr>
                                                                </tbody>
                                                            </table>             
                                                        </div>
                                                    </div>
                                                </div>  
                                     
</div>
</div>	
<script language="javascript" type="text/javascript">
                                                {literal}
function showContactInfo(customer_id){
         IM.dialog.show({
            width:500,
            height:null,
            title:'添加联系人',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showContactInfo&customer_id="+customer_id,""));
            }
         })
    }
function showModifyContact(contact_id){
         IM.dialog.show({
            width:550,
            title:'编辑联系人',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showModifyContact&contact_id="+contact_id,""));
            }
         })
    }
function showAddContactRecode(customer_id){
    JumpPage("/?d=CM&c=ContactRecord&a=ContactRecodeModify&customerID="+customer_id);
    /*
    */
}


function showAddVisitInvite(customer_id){
    
     IM.dialog.show({
        width: 600,
	    height: null,
	    title: "添加拜访预约",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=VisitRecord&a=VisitInviteModify&customerID="+customer_id, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
                                                                    
            $('#tbxInviteContactName').autocomplete('/?d=CM&c=CMInfo&a=getContactName_ID&customer_id='+$("#tbxCustomerID").val(), {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 5, //只显示5行
                width: 160, //下拉列表的宽
                parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
                    var parsed = [];
                    if(backData == "" || backData.length == 0)
                        return parsed;                                
                    backData = MM.json(backData);
                    var value = backData.value;
                    if(value == undefined)
                         return parsed;
                    for (var i = 0; i < value.length; i++) {
                        parsed[parsed.length] = {
                            data: value[i],
                            value: value[i].id,
                            result: value[i].name
                        }
                    }
                    return parsed;
                },
                formatItem: function (item) {//内部方法生成列表
                    return '<div>'+item.name + '</div>';
                }
            }).result(function (data,value) {//执行模糊匹配
            
                var contactID = value.id;
                var returnData = $PostData("/?d=CM&c=ContactRecord&a=GetContactInfo&contactID="+contactID+"&customerID="+$("#tbxCustomerID").val());
                if(returnData != "")
                {
                    var jsonObj = MM.json(returnData);
                    $("#tbxInviteContactName").val(jsonObj.contact_name);
                    $("#tbxInviteContactMobile").val(jsonObj.contact_mobile);
                    $("#tbxInviteContactTel").val(jsonObj.contact_tel);      
                }
                
            });                    
             
             
            new Reg.vf($('#J_VisitInviteModify'),{
		     callback:function(formdata){////formdata 表单提交数据 对象数组格式
                formdata = $("#J_VisitInviteModify").serialize();
                var backData = $PostData("/?d=CM&c=VisitRecord&a=VisitInviteModifySubmit",formdata);
                if(parseInt(backData) == 0)
                {
                    IM.dialog.hide();
                    IM.tip.show("添加成功！"); 
                }
                else
                {
                    IM.tip.warn(backData);
                }
          
	            }});
            
            });
      }
});

}

function showConatctCard(contact_id){
         IM.dialog.show({
            width:500,
            height:null,
            title:'联系人信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showConatctCard&contact_id="+contact_id,""));
            }
         })
    }

function MoreRecord(customerName)
{
    customerName = encodeURIComponent(customerName);
    JumpPage("/?d=CM&c=ContactRecord&a=ContactRecordList&customername="+customerName);
}

                                                {/literal}    
                                            </script>      