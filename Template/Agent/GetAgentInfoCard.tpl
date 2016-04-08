<div class="bd">
<div class="list_table_main marginBottom10">
<div class="ui_table ui_table_nohead">
    <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">代理商基本信息</h4></div></div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody class="ui_table_bd">
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strAgentName}</div></td>
                <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strLegalPerson}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strAreaFullName} {$arrAgentInfoCard->strAddress}</div></td>
                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strPostcode}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strRegAreaFullName}</div></td>
                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strDirection}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                <td>
                <div class="ui_table_tdcntr"><b class="amountStyle">{$arrAgentInfoCard->strRegCapital}</b>
                </div>
                </td>
                <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strSalesNum eq 0}
                            
                    {elseif $arrAgentInfoCard->strSalesNum eq 1}
                    10-50人
                    {elseif $arrAgentInfoCard->strSalesNum eq 2}
                    50-100人
                    {elseif $arrAgentInfoCard->strSalesNum eq 3}
                    100-300人
                    {elseif $arrAgentInfoCard->strSalesNum eq 4}
                    300-600人
                    {elseif $arrAgentInfoCard->strSalesNum eq 5}
                    600-1000人
                    {elseif $arrAgentInfoCard->strSalesNum eq 6}
                    1000人以上
                    {/if}
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">营业执照注册号</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strPermitRegNo}</div></td>
                <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strRevenueNo}</div></td>
            </tr>                                                                                        
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                <td><div class="ui_table_tdcntr">{if $arrAgentInfoCard->strRegDate neq '0000-00-00'}{$arrAgentInfoCard->strRegDate}{/if}</div></td>
                <td class="even"><div class="ui_table_tdcntr">售前技术人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strTechNum eq 0}
                            
                    {elseif $arrAgentInfoCard->strTechNum eq 1}
                    1-5人
                    {elseif $arrAgentInfoCard->strTechNum eq 2}
                    5-25人
                    {elseif $arrAgentInfoCard->strTechNum eq 3}
                    25-60人
                    {else}
                    60人以上
                    {/if}
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strCompanyScale eq 0}
                            
                    {elseif $arrAgentInfoCard->strCompanyScale eq 1}
                    10-50人
                    {elseif $arrAgentInfoCard->strCompanyScale eq 2}
                    50-100人
                    {else}
                    100人以上
                    {/if}
                </div>
                </td>
                <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strTelsalesNum eq 0}
                            
                    {elseif $arrAgentInfoCard->strTelsalesNum eq 1}
                    10-50人
                    {elseif $arrAgentInfoCard->strTelsalesNum eq 2}
                    50-100人
                    {elseif $arrAgentInfoCard->strTelsalesNum eq 3}
                    100-300人
                    {elseif $arrAgentInfoCard->strTelsalesNum eq 4}
                    300-600人
                    {elseif $arrAgentInfoCard->strTelsalesNum eq 5}
                    600-1000人
                    {elseif $arrAgentInfoCard->strTelsalesNum eq 6}
                    1000人以上
                    {/if}
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strAnnualSales eq 0}
                    {elseif $arrAgentInfoCard->strAnnualSales eq 1}
                    50万以下
                    {elseif $arrAgentInfoCard->strAnnualSales eq 2}
                    50-100万
                    {elseif $arrAgentInfoCard->strAnnualSales eq 3}
                    100-500万
                    {elseif $arrAgentInfoCard->strAnnualSales eq 4}
                    500-1000万
                    {else}
                    1000万以上
                    {/if}
                </div>
                </td>
                <td class="even"><div class="ui_table_tdcntr">企业客户数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strCustomerNum eq 0}
                            
                    {elseif $arrAgentInfoCard->strCustomerNum eq 1}
                    100人以下
                    {elseif $arrAgentInfoCard->strCustomerNum eq 2}
                    100-300人
                    {elseif $arrAgentInfoCard->strCustomerNum eq 3}
                    300-600人
                    {elseif $arrAgentInfoCard->strCustomerNum eq 4}
                    600-1000人
                    {elseif $arrAgentInfoCard->strCustomerNum eq 5}
                   1000-1500人
                    {elseif $arrAgentInfoCard->strCustomerNum eq 6}
                    1500-2000人
                    {elseif $arrAgentInfoCard->strCustomerNum eq 7}
                    2000-3000人
                    {else}
                    3000人以上
                    {/if}
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strWebSite}</div></td>
                <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	{if $arrAgentInfoCard->strServiceNum eq 0}
                            
                    {elseif $arrAgentInfoCard->strServiceNum eq 1}
                    1-5人
                    {elseif $arrAgentInfoCard->strServiceNum eq 2}
                    5-25人
                    {elseif $arrAgentInfoCard->strServiceNum eq 3}
                    25-60人
                    {elseif $arrAgentInfoCard->strServiceNum eq 4}
                    60-120人
                    {elseif $arrAgentInfoCard->strServiceNum eq 5}
                    120-200人
                    {elseif $arrAgentInfoCard->strServiceNum eq 6}
                    200-400人
                    {elseif $arrAgentInfoCard->strServiceNum eq 7}
                    400人以上
                    {/if}
                </div>
                </td>
            </tr>
        </tbody>
   </table>   
</div>
</div>
<div class="list_table_main">
<div class="ui_table ui_table_nohead">
    <div class="ui_table_hd"><div class="ui_table_hd_inner">
      <h4 class="title">负责人信息</h4></div></div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody class="ui_table_bd">
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">负责人姓名</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargePerson}</div></td>
                <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargeEmail}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargePhone}</div></td>
                <td class="even"><div class="ui_table_tdcntr">职务</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargePositon}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargeTel}</div></td>
                <td class="even"><div class="ui_table_tdcntr">QQ</div></td>
                <td><div class="ui_table_tdcntr">{if $arrAgentInfoCard->iChargeQq neq 0}{$arrAgentInfoCard->iChargeQq}{/if}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargeFax}</div></td>
                <td class="even"><div class="ui_table_tdcntr">MSN</div></td>
                <td><div class="ui_table_tdcntr">{$arrAgentInfoCard->strChargeMsn}</div></td>
            </tr>
        </tbody>
     </table>
</div>
</div>
</div>