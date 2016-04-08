{foreach from=$arrayData item=arrModifyLogList}
<tr class="">
    <td>
<div class="ui_table_tdcntr">
    {if $arrModifyLogList.old_values.agent_name neq ''}
        代理商名称：{$arrModifyLogList.old_values.agent_name}<br />
    {/if}
    {if $arrModifyLogList.old_values.address neq ''}
        注册地址：{$arrModifyLogList.old_values.address}<br />
    {/if}
    {if $arrModifyLogList.old_values.reg_date neq ''}
        注册日期：{$arrModifyLogList.old_values.reg_date}<br />
    {/if}
    {if $arrModifyLogList.old_values.legal_person neq ''}
        企业法人：{$arrModifyLogList.old_values.legal_person}<br />
    {/if}
    {if $arrModifyLogList.old_values.postcode neq ''}
        邮政编码：{$arrModifyLogList.old_values.postcode}<br />
    {/if}
    {if $arrModifyLogList.old_values.direction neq ''}
        业务方向：{$arrModifyLogList.old_values.direction}<br />
    {/if}
    {if $arrModifyLogList.old_values.website neq ''}
        网站地址：{$arrModifyLogList.old_values.website}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_person neq ''}
        企业负责人：{$arrModifyLogList.old_values.charge_person}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_phone neq ''}
        负责人手机：{$arrModifyLogList.old_values.charge_phone}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_tel neq ''}
        负责人电话：{$arrModifyLogList.old_values.charge_tel}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_email neq ''}
        电子邮件：{$arrModifyLogList.old_values.charge_email}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_fax neq ''}
        负责人传真：{$arrModifyLogList.old_values.charge_fax}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_positon neq ''}
        负责人职务：{$arrModifyLogList.old_values.charge_positon}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_qq neq ''}
        负责人QQ：{$arrModifyLogList.old_values.charge_qq}<br />
    {/if}
    {if $arrModifyLogList.old_values.charge_msn neq ''}
        负责人MSN：{$arrModifyLogList.old_values.charge_msn}<br />
    {/if}
    {if $arrModifyLogList.old_values.permit_reg_no neq ''}
        营业执照注册号：{$arrModifyLogList.old_values.permit_reg_no}<br />
    {/if}
    {if $arrModifyLogList.old_values.revenue_no neq ''}
        企业税号：{$arrModifyLogList.old_values.revenue_no}<br />
    {/if}
    {if $arrModifyLogList.old_values.legal_person_ID neq ''}
        法人身份证号：{$arrModifyLogList.old_values.legal_person_ID}<br />
    {/if}
    {if $arrModifyLogList.old_values.reg_capital neq ''}
        注册资金：
        {$arrModifyLogList.old_values.reg_capital}<br />
    {/if}
    {if $arrModifyLogList.old_values.company_scale neq ''}
        公司规模：
        {if $arrModifyLogList.old_values.company_scale eq 0}
        
        {elseif $arrModifyLogList.old_values.company_scale eq 1}
        10-50人
        {elseif $arrModifyLogList.old_values.company_scale eq 2}
        50-100人
        {else}
        100人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.old_values.sales_num neq ''}
        公司销售人数：
        {if $arrModifyLogList.old_values.sales_num eq 0}
        
        {elseif $arrModifyLogList.old_values.sales_num eq 1}
        10-50人
        {elseif $arrModifyLogList.old_values.sales_num eq 2}
        50-100人
        {elseif $arrModifyLogList.old_values.sales_num eq 3}
        100-300人
        {elseif $arrModifyLogList.old_values.sales_num eq 4}
        300-600人
        {elseif $arrModifyLogList.old_values.sales_num eq 5}
        600-1000人
        {elseif $arrModifyLogList.old_values.sales_num eq 6}
        1000人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.old_values.telsales_num neq ''}
        电话营销：
        {if $arrModifyLogList.old_values.telsales_num eq 0}
        
        {elseif $arrModifyLogList.old_values.telsales_num eq 1}
        10-50人
        {elseif $arrModifyLogList.old_values.telsales_num eq 2}
        50-100人
        {elseif $arrModifyLogList.old_values.telsales_num eq 3}
        100-300人
        {elseif $arrModifyLogList.old_values.telsales_num eq 4}
        300-600人
        {elseif $arrModifyLogList.old_values.telsales_num eq 5}
        600-1000人
        {elseif $arrModifyLogList.old_values.telsales_num eq 6}
		1000人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.old_values.tech_num neq ''}
        售前技术支持：
        {if $arrModifyLogList.old_values.tech_num eq 0}
        
        {elseif $arrModifyLogList.old_values.tech_num eq 1}
        1-5人
        {elseif $arrModifyLogList.old_values.tech_num eq 2}
        5-25人
        {elseif $arrModifyLogList.old_values.tech_num eq 3}
        25-60人
        {else}
        60人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.old_values.service_num neq ''}
        客服人数：
        {if $arrModifyLogList.old_values.service_num eq 0}
        
        {elseif $arrModifyLogList.old_values.service_num eq 1}
        1-5人
        {elseif $arrModifyLogList.old_values.service_num eq 2}
        5-25人
        {elseif $arrModifyLogList.old_values.service_num eq 3}
        25-60人
        {elseif $arrModifyLogList.old_values.service_num eq 4}
        60-120人
        {elseif $arrModifyLogList.old_values.service_num eq 5}
        120-200人
        {elseif $arrModifyLogList.old_values.service_num eq 6}
        200-400人
        {elseif $arrModifyLogList.old_values.service_num eq 7}
        400人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.old_values.customer_num neq ''}
        企业客户数：
        {if $arrModifyLogList.old_values.customer_num eq 0}
        
        {elseif $arrModifyLogList.old_values.customer_num eq 1}
        500人以下
        {elseif $arrModifyLogList.old_values.customer_num eq 2}
        100-300人
        {elseif $arrModifyLogList.old_values.customer_num eq 3}
        300-600人
        {elseif $arrModifyLogList.old_values.customer_num eq 4}
        600-1000人
        {elseif $arrModifyLogList.old_values.customer_num eq 5}
        1000-1500人
        {elseif $arrModifyLogList.old_values.customer_num eq 6}
        1500-2000人
        {elseif $arrModifyLogList.old_values.customer_num eq 7}
        2000-3000人
        {elseif $arrModifyLogList.old_values.customer_num eq 8}
		3000以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.old_values.annual_sales neq ''}
        年销售额：
        {if $arrModifyLogList.old_values.annual_sales eq 0}
        
        {elseif $arrModifyLogList.old_values.annual_sales eq 1}
        50万以下
        {elseif $arrModifyLogList.old_values.annual_sales eq 2}
        50-100万
        {elseif $arrModifyLogList.old_values.annual_sales eq 3}
        100-500万
        {elseif $arrModifyLogList.old_values.annual_sales eq 4}
        500-1000万
        {else}
        1000万以上
        {/if}<br />
    {/if}
</div>
    </td>
    <td>
<div class="ui_table_tdcntr">
    {if $arrModifyLogList.new_values.agent_name neq ''}
    	代理商名称：{$arrModifyLogList.new_values.agent_name}<br />
	{/if}
    {if $arrModifyLogList.new_values.address neq ''}
        注册地址：{$arrModifyLogList.new_values.address}<br />
    {/if}
    {if $arrModifyLogList.new_values.reg_date neq ''}
        注册日期：{$arrModifyLogList.new_values.reg_date}<br />
    {/if}
    {if $arrModifyLogList.new_values.legal_person neq ''}
        企业法人：{$arrModifyLogList.new_values.legal_person}<br />
    {/if}
    {if $arrModifyLogList.new_values.postcode neq ''}
        邮政编码：{$arrModifyLogList.new_values.postcode}<br />
    {/if}
    {if $arrModifyLogList.new_values.direction neq ''}
        业务方向：{$arrModifyLogList.new_values.direction}<br />
    {/if}
    {if $arrModifyLogList.new_values.website neq ''}
        网站地址：{$arrModifyLogList.new_values.website}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_person neq ''}
        企业负责人：{$arrModifyLogList.new_values.charge_person}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_phone neq ''}
        负责人手机：{$arrModifyLogList.new_values.charge_phone}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_tel neq ''}
        负责人电话：{$arrModifyLogList.new_values.charge_tel}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_email neq ''}
        电子邮件：{$arrModifyLogList.new_values.charge_email}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_fax neq ''}
        负责人传真：{$arrModifyLogList.new_values.charge_fax}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_positon neq ''}
        负责人职务：{$arrModifyLogList.new_values.charge_positon}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_qq neq ''}
        负责人QQ：{$arrModifyLogList.new_values.charge_qq}<br />
    {/if}
    {if $arrModifyLogList.new_values.charge_msn neq ''}
        负责人MSN：{$arrModifyLogList.new_values.charge_msn}<br />
    {/if}
    {if $arrModifyLogList.new_values.permit_reg_no neq ''}
        营业执照注册号：{$arrModifyLogList.new_values.permit_reg_no}<br />
    {/if}
    {if $arrModifyLogList.new_values.revenue_no neq ''}
        企业税号：{$arrModifyLogList.new_values.revenue_no}<br />
    {/if}
    {if $arrModifyLogList.new_values.legal_person_ID neq ''}
        法人身份证号：{$arrModifyLogList.new_values.legal_person_ID}<br />
    {/if}
    {if $arrModifyLogList.new_values.reg_capital neq ''}
        注册资金：
        {$arrModifyLogList.new_values.reg_capital}
        <br />
    {/if}
    {if $arrModifyLogList.new_values.company_scale neq ''}
        公司规模：
        {if $arrModifyLogList.new_values.company_scale eq 0}
        
        {elseif $arrModifyLogList.new_values.company_scale eq 1}
        10-50人
        {elseif $arrModifyLogList.new_values.company_scale eq 2}
        50-100人
        {else}
        100人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.new_values.sales_num neq ''}
        公司销售人数：
        {if $arrModifyLogList.new_values.sales_num eq 0}
        
        {elseif $arrModifyLogList.new_values.sales_num eq 1}
        10-50人
        {elseif $arrModifyLogList.new_values.sales_num eq 2}
        50-100人
        {elseif $arrModifyLogList.new_values.sales_num eq 3}
        100-300人
        {elseif $arrModifyLogList.new_values.sales_num eq 4}
        300-600人
        {elseif $arrModifyLogList.new_values.sales_num eq 5}
        600-1000人
        {elseif $arrModifyLogList.new_values.sales_num eq 6}
        1000人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.new_values.telsales_num neq ''}
        电话营销：
        {if $arrModifyLogList.new_values.telsales_num eq 0}
        
        {elseif $arrModifyLogList.new_values.telsales_num eq 1}
        10-50人
        {elseif $arrModifyLogList.new_values.telsales_num eq 2}
        50-100人
        {elseif $arrModifyLogList.new_values.telsales_num eq 3}
        100-300人
        {elseif $arrModifyLogList.new_values.telsales_num eq 4}
        300-600人
        {elseif $arrModifyLogList.new_values.telsales_num eq 5}
        600-1000人
        {elseif $arrModifyLogList.new_values.telsales_num eq 6}
		1000人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.new_values.tech_num neq ''}
        售前技术支持：
        {if $arrModifyLogList.new_values.tech_num eq 0}
        
        {elseif $arrModifyLogList.new_values.tech_num eq 1}
        1-5人
        {elseif $arrModifyLogList.new_values.tech_num eq 2}
        5-25人
        {elseif $arrModifyLogList.new_values.tech_num eq 3}
        25-60人
        {else}
        60人以上
        {/if}<br />
    {/if}
    {if $arrModifyLogList.new_values.service_num neq ''}
        客服人数：
        {if $arrModifyLogList.new_values.service_num eq 0}
        
        {elseif $arrModifyLogList.new_values.service_num eq 1}
        1-5人
        {elseif $arrModifyLogList.new_values.service_num eq 2}
        5-25人
        {elseif $arrModifyLogList.new_values.service_num eq 3}
        25-60人
        {elseif $arrModifyLogList.new_values.service_num eq 4}
        60-120人
        {elseif $arrModifyLogList.new_values.service_num eq 5}
        120-200人
        {elseif $arrModifyLogList.new_values.service_num eq 6}
        200-400人
        {elseif $arrModifyLogList.new_values.service_num eq 7}
        400人以上
        {/if}<br />
    {/if}
    
    {if $arrModifyLogList.new_values.customer_num neq ''}
        企业客户数：
        {if $arrModifyLogList.new_values.customer_num eq 0}
        
        {elseif $arrModifyLogList.new_values.customer_num eq 1}
        500人以下
        {elseif $arrModifyLogList.new_values.customer_num eq 2}
        100-300人
        {elseif $arrModifyLogList.new_values.customer_num eq 3}
        300-600人
        {elseif $arrModifyLogList.new_values.customer_num eq 4}
        600-1000人
        {elseif $arrModifyLogList.new_values.customer_num eq 5}
        1000-1500人
        {elseif $arrModifyLogList.new_values.customer_num eq 6}
        1500-2000人
        {elseif $arrModifyLogList.new_values.customer_num eq 7}
        2000-3000人
        {elseif $arrModifyLogList.new_values.customer_num eq 8}
		3000以上
        {/if}<br />
    {/if}
    
    {if $arrModifyLogList.new_values.annual_sales neq ''}
        年销售额：
        {if $arrModifyLogList.new_values.annual_sales eq 0}
        
        {elseif $arrModifyLogList.new_values.annual_sales eq 1}
        50万以下
        {elseif $arrModifyLogList.new_values.annual_sales eq 2}
        50-100万
        {elseif $arrModifyLogList.new_values.annual_sales eq 3}
        100-500万
        {elseif $arrModifyLogList.new_values.annual_sales eq 4}
        500-1000万
        {else}
        1000万以上
        {/if}<br />
    {/if}
</div>
    </td>      
    <td title="{$arrModifyLogList.create_e_name}({$arrModifyLogList.create_user_name})"><div class="ui_table_tdcntr">
            {if !empty($arrModifyLogList.create_e_name)}
            {$arrModifyLogList.create_e_name}({$arrModifyLogList.create_user_name})
            {/if}
    </div></td>
    <td title="{$arrModifyLogList.create_time}"><div class="ui_table_tdcntr">{$arrModifyLogList.create_time}</div></td>
    <td title="{$arrModifyLogList.check_e_name}({$arrModifyLogList.check_user_name})"><div class="ui_table_tdcntr">
            {if !empty($arrModifyLogList.check_e_name)}
    {$arrModifyLogList.check_e_name}({$arrModifyLogList.check_user_name})
    {/if}
    </div></td>
    <td title="{$arrModifyLogList.check_time}"><div class="ui_table_tdcntr">
    {if $arrModifyLogList.check_time neq '0000-00-00 00:00:00'}
    {$arrModifyLogList.check_time}
    {/if}
    </div></td>
    <td title="{$arrModifyLogList.check_remark}"><div class="ui_table_tdcntr">{$arrModifyLogList.check_remark|truncate:"8":"..."}
    </div></td>
</tr>
{/foreach}