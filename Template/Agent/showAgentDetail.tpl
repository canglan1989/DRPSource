    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentCheckPager'}')">代理商资料审核</a><span>&gt;</span>{$strTitle}</div>
        <!--E crumbs-->     
        <form id="J_agentAddForm" name="agentAddForm" class="agentAddForm">
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>            
            <!--S form_bd-->
            <div class="form_bd">  
		<div class="form_block_bd" style="padding-bottom:0;"> 
                <div class="table_attention">
                    <label class="attention">提示：</label>客户信息如果有误请勾选 <input type="checkbox" checked="checked" class="checkInp" style="vertical-align:middle">，黄色区域为修改前的信息 
                </div>       
		</div>   
            <input type="hidden" id="agentId" name="agentId" value="{$objAgentInfo->iAgentId}" />
            <input type="hidden" id="operate_type" name="operate_type" value="{$objAgentInfo->iOperateType}" />
            <input type="hidden" id="checkId" name="checkId" value="{$checkId}" />
                <!--S form_block_bd--> 
                <div class="form_block_bd">
                    <!----------------------------->                    
                    <div class="list_table_main marginBottom10 ">
                        <div class="ui_table ui_table_nohead">
                       		<div class="ui_table_hd"><div class="ui_table_hd_inner">
<!--                       		<a class="ui_button ui_link" onclick="JumpPage('{au d='Agent' c='Agent' a='EditShow'}&agentId={$objAgentInfo->iAgentId}&needCheck=no&fromType=3');" style="cursor:pointer;"><span class="ui_icon ui_icon_edit">&nbsp;</span>编辑</a>-->
                       		<h4 class="title">企业信息</h4></div></div>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strAgentName}</div>
                            {if $arrOld.agent_name neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_agent_name" id="chk_agent_name" class="checkInp" value="{$arrOld.agent_name}">
                            <em>{$arrOld.agent_name}</em>
                            </div>
                            {/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strAreaFullName}>{$objAgentInfo->strAddress} </div>
                            {if $arrOld.address neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_address" id="chk_address" class="checkInp" value="{$arrOld.address}">
                            <em>{$arrOld.address}</em>
                            </div>
                            {/if}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strPostcode}</div>
                            {if $arrOld.postcode neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_postcode" id="chk_postcode" class="checkInp" value="{$arrOld.postcode}">
                            <em>{$arrOld.postcode}</em>
                            </div>
                            {/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">法人姓名</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strLegalPerson}</div>
                            {if $arrOld.legal_person neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_legal_person" id="chk_legal_person" class="checkInp" value="{$arrOld.legal_person}">
                            <em>{$arrOld.legal_person}</em>
                            </div>
                            {/if}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                                                    <b class="amountStyle">{$objAgentInfo->strRegCapital}</b>
                            </div>
                            {if $arrOld.reg_capital neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_reg_capital" id="chk_reg_capital" class="checkInp" value="{$arrOld.reg_capital}">
                            <em>
                                <b class="amountStyle">{$arrOld.reg_capital}</b>
                            </em>
                            </div>
                            {/if}
                            </div>
                            </td>
                                       <td class="even"><div class="ui_table_tdcntr">公司注册时间</div></td>
                                       <td><div class="ui_table_tdcntr"><div class="inp">{if $objAgentInfo->strRegDate neq '0000-00-00'}{$objAgentInfo->strRegDate}{/if}</div>
                            {if $arrOld.reg_date neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_reg_date" id="chk_reg_date" class="checkInp" value="{$arrOld.reg_date}">
                            <em>{$arrOld.reg_date}</em>
                            </div>
                            {/if}
                            </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            {if $objAgentInfo->strCompanyScale eq 0}
                            
                            {elseif $objAgentInfo->strCompanyScale eq 1}
                            10-50人
                            {elseif $objAgentInfo->strCompanyScale eq 2}
                            50-100人
                            {else}
                            100人以上
                            {/if}
                            </div>
                            {if $arrOld.company_scale neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_company_scale" id="chk_company_scale" class="checkInp" value="{$arrOld.company_scale}">
                            <em>
                            {if $arrOld.company_scale eq 0}
                            
                            {elseif $arrOld.company_scale eq 1}
                            10-50人
                            {elseif $arrOld.company_scale eq 2}
                            50-100人
                            {else}
                            100人以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            {if $objAgentInfo->strSalesNum eq 0}
                            
                            {elseif $objAgentInfo->strSalesNum eq 1}
                            10-50人
                            {elseif $objAgentInfo->strSalesNum eq 2}
                            50-100人
                            {elseif $objAgentInfo->strSalesNum eq 3}
                            100-300人
                            {elseif $objAgentInfo->strSalesNum eq 4}
                            300-600人
                            {elseif $objAgentInfo->strSalesNum eq 5}
                            600-1000人
                            {elseif $objAgentInfo->strSalesNum eq 6}
                            1000人以上
                            {/if}
                            </div>
                            {if $arrOld.sales_num neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_sales_num" id="chk_sales_num" class="checkInp" value="{$arrOld.sales_num}">
                            <em>
                            {if $arrOld.sales_num eq 0}
                            
                            {elseif $arrOld.sales_num eq 1}
                            10-50人
                            {elseif $arrOld.sales_num eq 2}
                            50-100人
                            {elseif $arrOld.sales_num eq 3}
                            100-300人
                            {elseif $arrOld.sales_num eq 4}
                            300-600人
                            {elseif $arrOld.sales_num eq 5}
                            600-1000人
                            {elseif $arrOld.sales_num eq 6}
                            1000人以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            {if $objAgentInfo->strTelsalesNum eq 0}
                            
                            {elseif $objAgentInfo->strTelsalesNum eq 1}
                            10-50人
                            {elseif $objAgentInfo->strTelsalesNum eq 2}
                            50-100人
                            {elseif $objAgentInfo->strTelsalesNum eq 3}
                            100-300人
                            {elseif $objAgentInfo->strTelsalesNum eq 4}
                            300-600人
                            {elseif $objAgentInfo->strTelsalesNum eq 5}
                            600-1000人
                            {elseif $objAgentInfo->strTelsalesNum eq 6}
                            1000人以上
                            {/if}
                            </div>
                            {if $arrOld.telsales_num neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_telsales_num" id="chk_telsales_num" class="checkInp" value="{$arrOld.telsales_num}">
                            <em>
                            {if $arrOld.telsales_num eq 0}
                            
                            {elseif $arrOld.telsales_num eq 1}
                            10-50人
                            {elseif $arrOld.telsales_num eq 2}
                            50-100人
                            {elseif $arrOld.telsales_num eq 3}
                            100-300人
                            {elseif $arrOld.telsales_num eq 4}
                            300-600人
                            {elseif $arrOld.telsales_num eq 5}
                            600-1000人
                            {elseif $arrOld.telsales_num eq 6}
                            1000人以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">售前技术支持</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            {if $objAgentInfo->strTechNum eq 0}
                            
                            {elseif $objAgentInfo->strTechNum eq 1}
                            1-5人
                            {elseif $objAgentInfo->strTechNum eq 2}
                            5-25人
                            {elseif $objAgentInfo->strTechNum eq 3}
                            25-60人
                            {else}
                            60人以上
                            {/if}
                            </div>
                            {if $arrOld.tech_num neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_tech_num" id="chk_tech_num" class="checkInp" value="{$arrOld.tech_num}">
                            <em>
                            {if $arrOld.tech_num eq 0}
                            
                            {elseif $arrOld.tech_num eq 1}
                             1-5人
                            {elseif $arrOld.tech_num eq 2}
                            5-25人
                            {elseif $arrOld.tech_num eq 3}
                            25-60人
                            {else}
                            60人以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            {if $objAgentInfo->strServiceNum eq 0}
                            
                            {elseif $objAgentInfo->strServiceNum eq 1}
                            1-5人
                            {elseif $objAgentInfo->strServiceNum eq 2}
                            5-25人
                            {elseif $objAgentInfo->strServiceNum eq 3}
                            25-60人
                            {elseif $objAgentInfo->strServiceNum eq 4}
                            60-120人
                            {elseif $objAgentInfo->strServiceNum eq 5}
                            120-200人
                            {elseif $objAgentInfo->strServiceNum eq 6}
                            200-400人
                            {elseif $objAgentInfo->strServiceNum eq 7}
                            400人以上
                            {/if}
                            </div>
                            {if $arrOld.service_num neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_service_num" id="chk_service_num" class="checkInp" value="{$arrOld.service_num}">
                            <em>
                            {if $arrOld.service_num eq 0}
                            
                            {elseif $arrOld.service_num eq 1}
                             1-5人
                            {elseif $arrOld.service_num eq 2}
                            5-25人
                            {elseif $arrOld.service_num eq 3}
                            25-60人
                            {elseif $arrOld.service_num eq 4}
                            60-120人
                            {elseif $arrOld.service_num eq 5}
                            120-200人
                            {elseif $arrOld.service_num eq 6}
                            200-400人
                            {elseif $arrOld.service_num eq 7}
                            400人以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">企业客户数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            {if $objAgentInfo->strCustomerNum eq 0}
                            {elseif $objAgentInfo->strCustomerNum eq 1}
                            100人以下
                            {elseif $objAgentInfo->strCustomerNum eq 2}
                            100-300人
                            {elseif $objAgentInfo->strCustomerNum eq 3}
                            300-600人
                            {elseif $objAgentInfo->strCustomerNum eq 4}
                            600-1000人
                            {elseif $objAgentInfo->strCustomerNum eq 5}
                            1000-1500人
                            {elseif $objAgentInfo->strCustomerNum eq 6}
                            1500-2000人
                            {elseif $objAgentInfo->strCustomerNum eq 7}
                            2000-3000人
                            {else}
                            3000以上
                            {/if}
                            </div>
                            {if $arrOld.customer_num neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_customer_num" id="chk_customer_num" class="checkInp" value="{$arrOld.customer_num}">
                            <em>
                            {if $arrOld.customer_num eq 0}
                            
                            {elseif $arrOld.customer_num eq 1}
                            100人以下
                            {elseif $arrOld.customer_num eq 2}
                            100-300人
                            {elseif $arrOld.customer_num eq 3}
                            300-600人
                            {elseif $arrOld.customer_num eq 4}
                            600-1000人
                            {elseif $arrOld.customer_num eq 5}
                            1000-1500人
                            {elseif $arrOld.customer_num eq 6}
                            1500-2000人
                            {elseif $arrOld.customer_num eq 7}
                            2000-3000人
                            {else}
                            3000以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
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
                            {if $arrOld.annual_sales neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_annual_sales" id="chk_annual_sales" class="checkInp" value="{$arrOld.annual_sales}">
                            <em>
                            {if $arrOld.annual_sales eq 0}
                            
                            {elseif $arrOld.annual_sales eq 1}
                            50万以下
                            {elseif $arrOld.annual_sales eq 2}
                            50-100万
                            {elseif $arrOld.annual_sales eq 3}
                            100-500万
                            {elseif $arrOld.annual_sales eq 4}
                            500-1000万
                            {else}
                            1000万以上
                            {/if}
                            </em>
                            </div>
                            {/if}</div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">网站地址</div></td>
                                                <td><div class="ui_table_tdcntr"> <div class="inp">
                            	{$objAgentInfo->strWebSite}
                            </div>
                            {if $arrOld.website neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_website" id="chk_website" class="checkInp" value="{$arrOld.website}">
                            <em>{$arrOld.website}</em>
                            </div>
                            {/if}</div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            	{$objAgentInfo->strDirection}
                            </div>
                            {if $arrOld.direction neq ''}
                            <div class="inp_add">
                            <input type="checkbox" name="chk_direction" id="chk_direction" class="checkInp" value="{$arrOld.direction}">
                            <em>{$arrOld.direction}</em>
                            </div>
                            {/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">资质上传</div></td>
                                                <td><div class="ui_table_tdcntr">{if $objAgentInfo->strPermitPicture neq ''}
                                 {$objAgentInfo->strPermitName} 
                                	<a href="{$objAgentInfo->strPermitPicture}" target="_blank">查看</a>
                                {/if} </div>
						</td>
                                            </tr>
                                        </tbody>
                                   </table>   
                    	</div>
                    </div>
                    <!------------------------------------>
                    <div class="list_table_main">
                            <div class="ui_table ui_table_nohead">
                                <div class="ui_table_hd"><div class="ui_table_hd_inner">                       		
                                <h4 class="title">联系人信息</h4></div></div>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                           <tbody class="ui_table_bd">
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">负责人姓名</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargePerson}</div>
                                {if $arrOld.charge_person neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_person" id="chk_charge_person" class="checkInp" value="{$arrOld.charge_person}">
                                <em>{$arrOld.charge_person}</em>
                                </div>
                                {/if}</div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargePhone}</div>
                                {if $arrOld.charge_phone neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_phone" id="chk_charge_phone" class="checkInp" value="{$arrOld.charge_phone}">
                                <em>{$arrOld.charge_phone}</em>
                                </div>
                                {/if}</div></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargeTel}</div>
                                {if $arrOld.charge_tel neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_tel" id="chk_charge_tel" class="checkInp" value="{$arrOld.charge_tel}">
                                <em>{$arrOld.charge_tel}</em>
                                </div>
                                {/if}</div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargeFax}</div> 
                                {if $arrOld.charge_fax neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_fax" id="chk_charge_fax" class="checkInp" value="{$arrOld.charge_fax}">
                                <em>{$arrOld.charge_fax}</em>
                                </div>
                                {/if}</div></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">电子邮件</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargeEmail}</div>
                                {if $arrOld.charge_email neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_email" id="chk_charge_email" class="checkInp" value="{$arrOld.charge_email}">
                                <em>{$arrOld.charge_email}</em>
                                </div>
                                {/if}</div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">QQ</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{if $objAgentInfo->iChargeQq eq 0}{else}{$objAgentInfo->iChargeQq}{/if}</div>
                                {if $arrOld.charge_qq neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_qq" id="chk_charge_qq" class="checkInp" value="{$arrOld.charge_qq}">
                                <em>{$arrOld.charge_qq}</em>
                                </div>
                                {/if}</div></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">MSN</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargeMsn}</div>
                                {if $arrOld.charge_msn neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_msn" id="chk_charge_msn" class="checkInp" value="{$arrOld.charge_msn}">
                                <em>{$arrOld.charge_msn}</em>
                                </div>
                                {/if}</div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">职务</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp">{$objAgentInfo->strChargePositon}</div>
                                {if $arrOld.charge_positon neq ''}
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_positon" id="chk_charge_positon" class="checkInp" value="{$arrOld.charge_positon}">
                                <em>{$arrOld.charge_positon}</em>
                                </div>
                                {/if}</div></td>
                                                </tr>
                                            </tbody>
                                       </table> 
                            </div>
                    </div>
                	<!------------------------------------>      
                </div>
		<!--S form_block_ft-->  
	            <div class="form_block_ft">
	                <div class="agentAuditBlock">
	                    <div class="tf">
	                            <label>审核状态：</label>
	                            <div class="inp">
	                                <div class="ui_comboBox">
	                                    <select name="auditState" id="auditState">
	                                        <!--<option value="请选择审核状态">请选择审核状态</option>
	                                        <option value="0">未审核</option>-->
	                                        <option value="1">{if $operaType eq 2}彻底删除{else}审核通过{/if}</option>
	                                        <option value="2">{if $operaType eq 2}放入回收库{else}审核不通过{/if}</option>
	                                    </select>
	                                </div>
	                            </div>
	                    </div>
	                    <div class="tf">
	                            <label>审核信息：</label>
	                            <div class="inp"><textarea name="check_remark" class="" id="check_remark"></textarea></div>
	                    </div>
	                </div>
	                <div class="tf tf_submit">
	                        <label>&nbsp;</label>
	                        <div class="inp">
	                            <div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" id="checkAgent">确 认</button></div>
	                            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack();">取消</a></div>
	                        </div>
	                </div>
	            </div>      
	            <!--E form_block_ft--> 
            </div>
            <!--E form_bd--> 
        </div>
        <!--E form_edit-->
         </form>
<script language="javascript" type="text/javascript">
{literal}
$(function(){
	$('#checkAgent').click(function(){
		var agentId = $.trim($('#agentId').val());
		var checkId = $.trim($('#checkId').val());
		var operateType = $('#operate_type').val();
		var auditState = $.trim($('#auditState').val());
		var check_remark = $.trim($('#check_remark').val());
		var objVal = '';
		$('input[type="checkbox"][name^="chk_"]:checked').each(function(){
			objVal += $(this).attr('name')+'='+$(this).attr('value')+'&';
		});
		var objVal = objVal.slice(0,-1);
		var strData = '';
		if(objVal!='')
		{
			strData = 'auditState='+auditState+'&check_remark='+check_remark+'&agentId='+agentId+'&operate_type='+operateType+'&checkId='+checkId+'&'+objVal;
		}
		else
		{
			strData = 'auditState='+auditState+'&check_remark='+check_remark+'&agentId='+agentId+'&operate_type='+operateType+'&checkId='+checkId;
		}
		//alert(strData);return false;
		$.ajax({
			type:'POST',
			data:strData,
			{/literal}
			url:'{au d="Agent" c="Agent" a="checkAgent"}',
			{literal}
			success:function(data)
			{
				switch(data)
				{
					case '1':
						IM.tip.show('审核成功！');
                        PageBack();
						break;
					case '2':
						IM.tip.warn('审核失败！');
						break;
					default:
						IM.tip.warn('请不要非法操作！');
						break;
				}
			}
		});
	});
});
{/literal}
</script>