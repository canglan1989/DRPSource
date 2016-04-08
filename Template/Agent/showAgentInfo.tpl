    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$currentTitle}<span>&gt;</span>{$strTitle}</div>
        <!--E crumbs-->     
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>代理商信息</h2></div></div></div>
               <div class="form_hd_oper">
                    {if $objAgentInfo->iIsCheck eq 1 && $type eq 1}
                     <a class="ui_button" onclick="JumpPage('{au d='Agent' c='AgentMove' a='showSignInfo'}&agentId={$objAgentInfo->iAgentId}&&fromType=2');" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_submitAudit"></div><div class="ui_text">提交签约</div></div></a>
                     {/if}         	
                    <a class="ui_button ui_button_dis" onClick="PageBack();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
                </div>
            </div>
            <!--S form_bd-->
            
                <div class="form_bd">	
                <div class="form_block_bd"> 
                    <div class="list_table_main marginBottom10 ">
                        <div class="ui_table ui_table_nohead">
				<div class="ui_table_hd"><div class="ui_table_hd_inner">
                                {if $isPact eq 'no'}
	                             	<a class="ui_button ui_link" onclick="JumpPage('{au d='Agent' c='Agent' a='EditShow'}&agentId={$objAgentInfo->iAgentId}&checkStatus={$objAgentInfo->iIsCheck}&needCheck={$needCheck}&fromType=2');" style="cursor:pointer;"><span class="ui_icon ui_icon_edit">&nbsp;</span>修改信息</a>
	                            {/if}
				<h4 class="title">代理商基本信息</h4>
                            </div></div>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strAgentName}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strLegalPerson}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strAreaFullName}>{$objAgentInfo->strAddress} </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strPostcode}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">营业执照注册号</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strPermitRegNo}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strRevenueNo}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strRegAreaFullName}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strDirection}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr">
                                                	<b class="amountStyle">{$objAgentInfo->strRegCapital}</b>
													</div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
                                                <td><div class="ui_table_tdcntr">
													{if $objAgentInfo->strSalesNum eq 0}
                            
													{elseif $objAgentInfo->strSalesNum eq 1}
													10-50人
													{elseif $objAgentInfo->strSalesNum eq 2}
													50-100人
													{else}
													100人以上
													{/if}
													</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                                                <td><div class="inp"><div class="ui_table_tdcntr">{if $objAgentInfo->strRegDate eq 0000-00-00}{else}{$objAgentInfo->strRegDate}{/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">售前技术人数</div></td>
                                                <td><div class="ui_table_tdcntr">
													{if $objAgentInfo->strTechNum eq 0}
                            
													{elseif $objAgentInfo->strTechNum eq 1}
													1-5人
													{elseif $objAgentInfo->strTechNum eq 2}
													5-25人
													{elseif $objAgentInfo->strTechNum eq 3}
													25-60人
													{else}
													60人以上
													{/if}</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                                <td><div class="ui_table_tdcntr">
													{if $objAgentInfo->strCompanyScale eq 0}
                            
													{elseif $objAgentInfo->strCompanyScale eq 1}
													10-50人
													{elseif $objAgentInfo->strCompanyScale eq 2}
													50-100人
													{else}
													100人以上
													{/if}
													<div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
                                                <td><div class="ui_table_tdcntr">
													{if $objAgentInfo->strTelsalesNum eq 0}
                            
													{elseif $objAgentInfo->strTelsalesNum eq 1}
													10-50人
													{elseif $objAgentInfo->strTelsalesNum eq 2}
													50-100人
													{else}
													100人以上
													{/if}
													</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                                <td><div class="ui_table_tdcntr">
													{if $objAgentInfo->strAnnualSales eq 0}
													{elseif $objAgentInfo->strAnnualSales eq 1}
													50万以下
													{elseif $objAgentInfo->strAnnualSales eq 2}
													50-100万
													{elseif $objAgentInfo->strAnnualSales eq 3}
													100-500万
													{elseif $objAgentInfo->strAnnualSales eq 4}
													500-1000万
													{else}
													1000万以上
													{/if}
													</div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
                                                <td><div class="ui_table_tdcntr">
													{if $objAgentInfo->strServiceNum eq 0}
                            
													{elseif $objAgentInfo->strServiceNum eq 1}
													1-5人
													{elseif $objAgentInfo->strServiceNum eq 2}
													5-25人
													{elseif $objAgentInfo->strServiceNum eq 3}
													25-60人
													{else}
													60人以上
													{/if}
													</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                                <td><div class="ui_table_tdcntr">{$objAgentInfo->strWebSite}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">资质</div></td>
                                                <td><div class="ui_table_tdcntr">
									{if $objAgentInfo->strPermitPicture neq ''}
									{$objAgentInfo->strPermitName} 
										<a href="{$objAgentInfo->strPermitPicture}" target="_blank">查看</a>
									{/if}
						    </div>
						</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">意向产品</div></td>
                                                <td><div class="ui_table_tdcntr">暂无</div></td>
                                                <td class="even"><div class="ui_table_tdcntr"></div></td>
                                                <td><div class="ui_table_tdcntr"></div></td>
                                            </tr>
                                        </tbody>
                                   </table>   
                        </div>
                    </div>
            <!--E form_bd--> 
                
              <div class="list_table_head">
                        <div class="list_table_head_right">
                            <div class="list_table_head_mid">
                            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 联系人信息</h4>
                            <a class="ui_button ui_link" href="javascript:;" onClick="IM.agent.addContactInfo('{au d='Agent' c='Agent' a='showAddContacter'}','添加联系人信息',{$objAgentInfo->iAgentId},'{$isPact}')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系人</a>
                        </div>
                        </div>			           
                    </div>
                    <div class="list_table_main marginBottom10" id="ContacterInfo">
                        <div id="J_ui_table" class="ui_table">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <thead class="ui_table_hd">
                                           <tr class="">
                                               <th title="姓名" style="width:100px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">姓名</div>
                                                        <div class="ui_table_thsort"></div>
                                                    </div>
                                                </th>
                                                <th title="职务" style="width:80px;">
                                                    <div class="ui_table_thcntr">
                                                        <div class="ui_table_thtext">职务</div>
                                                    </div>
                                                </th>
                                                <th title="固定电话" style="width:120px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">固定电话</div>
                                                    </div>
                                                </th>
                                                <th title="手机号码" style="width:120px;">
                                                    <div class="ui_table_thcntr">
                                                        <div class="ui_table_thtext">手机号码</div>
                                                    </div>
                                                </th>
                                                <th title="传真号码" style="width:120px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">传真号码</div>
                                                        <div class="ui_table_thsort"></div>
                                                    </div>
                                                </th>
                                                <th title="电子邮箱">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">电子邮箱</div>
                                                    </div>
                                                </th>
                                                <th title="备注">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">备注</div>
                                                    </div>
                                                </th>
                                                <th title="操作" style="width:120px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">操作</div>
                                                    </div>
                                                </th>
                                           </tr>
					</thead>
                                   	<tbody class="ui_table_bd">
                                        {foreach from=$arrAllContacter item=ContactList}
                                            <tr class="">                                        
                                               <td title="{$ContactList.contact_name}" style="width:100px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">{$ContactList.contact_name}</div>
                                                    </div>
                                                </td>
                                                <td title="{$ContactList.position}" style="width:80px;">
                                                    <div class="ui_table_thcntr">
                                                        <div class="ui_table_thtext">{$ContactList.position}</div>
                                                    </div>
                                                </td>
                                                <td title="{$ContactList.tel}" style="width:120px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">{$ContactList.tel}</div>
                                                    </div>
                                                </td>
                                                <td title="{$ContactList.mobile}" style="width:120px;">
                                                    <div class="ui_table_thcntr">
                                                        <div class="ui_table_thtext">{$ContactList.mobile}</div>
                                                    </div>
                                                </td>
                                                <td title="{$ContactList.fax}" style="width:120px;">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">{$ContactList.fax}</div>
                                                    </div>
                                                </td>
                                                <td title="{$ContactList.email}">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">{$ContactList.email}</div>
                                                    </div>
                                                </td>
                                                <td title="{$ContactList.remark}">
                                                    <div class="ui_table_thcntr ">
                                                        <div class="ui_table_thtext">{$ContactList.remark|truncate:"20":"..."}</div>
                                                    </div>
                                                </td>
                                                <td title="操作" style="width:120px;">
                                                    <div class="ui_table_thcntr ">
                                                        <ul class="list_table_operation">
                                                             <li><a onClick="IM.agent.editContactInfo('{au d='Agent' c='Agent' a='showEditContacter'}&id={$ContactList.aid}','编辑联系人信息')" href="javascript:;">编辑</a></li>
                                                             <li><a onclick="IM.account.delOper('{au d='Agent' c='Agent' a='DelContacter'}',{literal}{{/literal}'listid':{$ContactList.aid}{literal}}{/literal},'删除联系人',this)" href="javascript:;">删除</a></li>
                                                         </ul>
                                                    </div>
                                                </td>
                                           </tr>
                                           {/foreach}
                                       </thead>
                                   </table>   
                        </div>
                    </div>
                    <!--<div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div> -->                                   
        </div>
        <!--E form_edit--> 
<!--<script type="text/javascript" src="{$JS}pageCommon.js"></script> -->
<script type="text/javascript">
{literal}
/*$(function(){
	$('#DelAgent').click(function(){
		var agentId = $('#agentId').val();
		$.ajax({
			type:'POST',
			data:'agentId='+agentId,
			{/literal}
			url:'{au d="Agent" c="Agent" a="DelAgent"}',
			{literal}
			success:function(data){
				switch(data)
				{
					case '1':
						alert('删除成功！');
						break;
					case '2':
						alert('非法参数，请检查！');
						break;
					default:
						alert('非法请求，请检查！');
						break;
				}
			}
		});
	});
});*/
{/literal}
</script>  