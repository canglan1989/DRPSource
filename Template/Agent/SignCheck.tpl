<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置当前位置：代理商管理<span>&gt;</span>签约管理<span>&gt;</span>部门签约审核</div>
<!--E crumbs-->   
<div class="form_edit">
<form id="J_agentAuditForm" class="agentAuditForm" enctype="multipart/form-data" method="post" name="agentAuditForm" action="">
<div class="form_hd">
    <ul>
        <li class="cur">
            <a href="javascript:;"><div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>签约审核</h2></div></div></div></a>
        </li>
    </ul>
    <div class="form_hd_oper">
            <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
    </div>
</div>
<!--S form_bd-->
<div class="form_bd">
<div class="form_block_bd">           
<!---------------------------------------------->            
<!--S list_table_main-->
<div class="list_table_main marginBottom10">
<div class="ui_table ui_table_nohead">
<div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">合同基本信息</h4>
    &nbsp;&nbsp;&nbsp;&nbsp;
    {if $strPactFile != ""}<a href="/{$strPactFile}" target="_blank">合同扫描件</a>
    {/if}
</div></div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tbody class="ui_table_bd ">
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">代理商的产品</div></td>
            <td><div class="ui_table_tdcntr">{$arrPact.product_type_name}</div></td>
            <td class="even"><div class="ui_table_tdcntr">代理商等级</div></td>
            <td><div class="ui_table_tdcntr">{if $arrPact.agent_level eq 0}无等级{elseif $arrPact.agent_level eq 1}金牌{else}银牌{/if}</div></td>
        </tr>
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">代理地区范围</div></td>
            <td>
            <div class="ui_table_tdcntr"  style="line-height:20px; overflow-y:auto; max-height:200px;">
            	{foreach from=$arrAreaName item=areaName}
                	{$areaName}<br />
                {/foreach}
            </div>
            </td>
            <td class="even"><div class="ui_table_tdcntr">合作模式</div></td>
            <td><div class="ui_table_tdcntr">{if $arrPact.agent_mode eq 0}渠道代理{elseif $arrPact.agent_mode eq 1}渠道商务{/if}</div></td>
        </tr>
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">保证金</div></td>
            <td><div class="ui_table_tdcntr"><b class="amountStyle">{$arrPact.cash_deposit}元</b></div></td>
            <td class="even"><div class="ui_table_tdcntr">预存款</div></td>
            <td><div class="ui_table_tdcntr"><b class="amountStyle">{if $arrPact.pre_deposit neq '0.00'}{$arrPact.pre_deposit}元{/if}</b></div></td>
        </tr>
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">合同有效期限</div></td>
            <td><div class="ui_table_tdcntr">{$arrPact.pact_sdate}至{$arrPact.pact_edate}</div></td>
            <td class="even"><div class="ui_table_tdcntr">提交人/提交时间</div></td>
            <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arrPact.user_id});">{$arrPact.user_name}({$arrPact.e_name})</a>&nbsp;&nbsp;{$arrPact.create_time}</div></td>
        </tr>
        <!--<tr class="">
            <td class="even"><div class="ui_table_tdcntr">提交人</div></td>
            <td><div class="ui_table_tdcntr"><a href="javascript:;">王五psho3022</a></div></td>
            <td class="even"><div class="ui_table_tdcntr">提交时间</div></td>
            <td><div class="ui_table_tdcntr"></div></td>
        </tr>-->
    </tbody>
</table>   
</div>
<!--E ui_table-->
</div>
<!--E list_table_main-->

<div class="list_table_main marginBottom10">
<div class="ui_table ui_table_nohead">
<div class="ui_table_hd">
        <div class="ui_table_hd_inner">
            <h4 class="title">签约考察小记</h4>
        </div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tbody class="ui_table_bd ">
      <tr class="">
          <td class="even"><div class="ui_table_tdcntr">考察小记</div></td>
          <td><div class="ui_table_tdcntr">{$arrPact.pact_remark}</div></td>
      </tr>
  </tbody>
</table>   
</div>
<!--E ui_table-->
</div>


<!--S list_table_main-->
<div class="list_table_main marginBottom10">
<div class="ui_table ui_table_nohead">
<div class="ui_table_hd">
        <div class="ui_table_hd_inner">
            <h4 class="title">代理商资质</h4>
        </div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tbody class="ui_table_bd ">
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">营业执照</div></td>
            <td><div class="ui_table_tdcntr">
            {if $arrAllPermit.0 != ""}<a href="/FrontFile/upload/{$arrBasicInfo->iAgentId}/{$arrAllPermit.0}" target="_blank">点击查看</a>
            {else}未上传
            {/if}
            </div></td>
            <td class="even"><div class="ui_table_tdcntr">一般纳税人资格证书</div></td>
            <td><div class="ui_table_tdcntr">
            {if $arrAllPermit.4 != ""}<a href="/FrontFile/upload/{$arrBasicInfo->iAgentId}/{$arrAllPermit.4}" target="_blank">点击查看</a>
            {else}未上传
            {/if}
            </div></td>
        </tr>
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">税务登记证</div></td>
            <td><div class="ui_table_tdcntr">
            {if $arrAllPermit.1 != ""}
            <a href="/FrontFile/upload/{$arrBasicInfo->iAgentId}/{$arrAllPermit.1}" target="_blank">点击查看</a>
            {else}未上传
            {/if}
            </div></td>
            <td class="even"><div class="ui_table_tdcntr">法人身份证</div></td>
            <td><div class="ui_table_tdcntr">
            {if $arrAllPermit.2 != ""}
            <a href="/FrontFile/upload/{$arrBasicInfo->iAgentId}/{$arrAllPermit.2}" target="_blank">点击查看</a>
            {else}未上传
            {/if}
            </div></td>
        </tr>
        <tr class="">
            <td class="even"><div class="ui_table_tdcntr">组织机构代码证</div></td>
            <td><div class="ui_table_tdcntr">
            {if $arrAllPermit.3 != ""}
            <a href="/FrontFile/upload/{$arrBasicInfo->iAgentId}/{$arrAllPermit.3}" target="_blank">点击查看</a>
            {else}未上传
            {/if}
            </div></td>
            <td class="even"><div class="ui_table_tdcntr"></div></td>
            <td><div class="ui_table_tdcntr"></div></td>
        </tr>
    </tbody>
</table>   
</div>
<!--E ui_table-->
</div>
<!--E list_table_main-->

<div class="list_table_main marginBottom10">
<div class="ui_table ui_table_nohead">
<div class="ui_table_hd"><div class="ui_table_hd_inner">
    <!--<a class="ui_button ui_link" href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='EditShow'}&agentId={$arrBasicInfo->iAgentId}&checkStatus={$arrBasicInfo->iIsCheck}&needCheck=yes&fromType=4')"><span class="ui_icon ui_icon_edit">&nbsp;</span>修改信息</a>-->
    <h4 class="title">代理商基本信息</h4>
</div></div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody class="ui_table_bd">
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
        <td><div class="ui_table_tdcntr">
        {if $arrNewInfo.agent_name neq ''}{$arrNewInfo.agent_name}{else}{$arrBasicInfo->strAgentName} {/if}
        </div></td>
        <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
        <td><div class="ui_table_tdcntr">                                      
        {if $arrNewInfo.legal_person neq ''}{$arrNewInfo.legal_person}{else}{$arrBasicInfo->strLegalPerson}{/if}
        </div></td>
    </tr>
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
        <td><div class="ui_table_tdcntr">
        {$arrBasicInfo->strAreaFullName} {$arrBasicInfo->strAddress}
        </div></td>
        <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
        <td><div class="ui_table_tdcntr">{if $arrNewInfo.postcode neq ''}{$arrNewInfo.postcode} {else}{$arrBasicInfo->strPostcode}{/if}</div></td>
    </tr>
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
        <td><div class="ui_table_tdcntr">{$arrBasicInfo->strRegAreaFullName}</div></td>
        <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
        <td><div class="ui_table_tdcntr">{$arrBasicInfo->strDirection}</div></td>
    </tr>
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
        <td>
        <div class="ui_table_tdcntr">
        <b class="amountStyle">{if $arrNewInfo.reg_capital neq ''}{$arrNewInfo.reg_capital}{else}{$arrBasicInfo->strRegCapital}{/if}</b>
        </div>
        </td>
        <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arrBasicInfo->strSalesNum eq 0}

        {elseif $arrBasicInfo->strSalesNum eq 1}
        10-50人
        {elseif $arrBasicInfo->strSalesNum eq 2}
        50-100人
        {elseif $arrBasicInfo->strSalesNum eq 3}
        100-300人
        {elseif $arrBasicInfo->strSalesNum eq 4}
        300-600人
        {elseif $arrBasicInfo->strSalesNum eq 5}
        600-1000人
        {elseif $arrBasicInfo->strSalesNum eq 6}
        1000人以上
        {/if}
        </div>
        </td>
    </tr>
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">营业执照注册号</div></td>
        <td><div class="ui_table_tdcntr">{if $arrNewInfo.permit_reg_no neq ''}{$arrNewInfo.permit_reg_no}{else}{$arrBasicInfo->strPermitRegNo}{/if}</div></td>
        <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
        <td><div class="ui_table_tdcntr">{if $arrNewInfo.revenue_no neq ''}{$arrNewInfo.revenue_no}{else}{$arrBasicInfo->strRevenueNo}{/if}</div></td>
    </tr>                                                                                        
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
        <td><div class="ui_table_tdcntr">{if $arrBasicInfo->strRegDate eq '0000-00-00'}{else}{$arrBasicInfo->strRegDate}{/if}</div></td>
        <td class="even"><div class="ui_table_tdcntr">售前技术人数</div></td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arrBasicInfo->strTechNum eq 0}

        {elseif $arrBasicInfo->strTechNum eq 1}
        1-5人
        {elseif $arrBasicInfo->strTechNum eq 2}
        5-25人
        {elseif $arrBasicInfo->strTechNum eq 3}
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
        {if $arrBasicInfo->strCompanyScale eq 0}

        {elseif $arrBasicInfo->strCompanyScale eq 1}
        10-50人
        {elseif $arrBasicInfo->strCompanyScale eq 2}
        50-100人
        {else}
        100人以上
        {/if}
        </div>
        </td>
        <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arrBasicInfo->strTelsalesNum eq 0}

        {elseif $arrBasicInfo->strTelsalesNum eq 1}
        10-50人
        {elseif $arrBasicInfo->strTelsalesNum eq 2}
        50-100人
        {elseif $arrBasicInfo->strTelsalesNum eq 3}
        100-300人
        {elseif $arrBasicInfo->strTelsalesNum eq 4}
        300-600人
        {elseif $arrBasicInfo->strTelsalesNum eq 5}
        600-1000人
        {elseif $arrBasicInfo->strTelsalesNum eq 6}
        1000人以上
        {/if}
        </div>
        </td>
    </tr>
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arrBasicInfo->strAnnualSales eq 0}
        {elseif $arrBasicInfo->strAnnualSales eq 1}
        50万以下
        {elseif $arrBasicInfo->strAnnualSales eq 2}
        50-100万
        {elseif $arrBasicInfo->strAnnualSales eq 3}
        100-500万
        {elseif $arrBasicInfo->strAnnualSales eq 4}
        500-1000万
        {else}
        1000万以上
        {/if}
        </div>
        </td>
        <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arrBasicInfo->strServiceNum eq 0}

        {elseif $arrBasicInfo->strServiceNum eq 1}
        1-5人
        {elseif $arrBasicInfo->strServiceNum eq 2}
        5-25人
        {elseif $arrBasicInfo->strServiceNum eq 3}
        25-60人
        {elseif $arrBasicInfo->strServiceNum eq 4}
        60-120人
        {elseif $arrBasicInfo->strServiceNum eq 5}
        120-200人
        {elseif $arrBasicInfo->strServiceNum eq 6}
        200-400人
        {elseif $arrBasicInfo->strServiceNum eq 7}
        400人以上
        {/if}
        </div>
        </td>
    </tr>
    <tr class="">
        <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
        <td><div class="ui_table_tdcntr">{$arrBasicInfo->strWebSite}</div></td>
        <td class="even"><div class="ui_table_tdcntr">营业执照</div></td>
        <td>
        <div class="ui_table_tdcntr">
        	<div class="inp qua_upload">
            {if $arrBasicInfo->strPermitPicture neq ''}
                {$arrBasicInfo->strPermitName} 
                    <a href="{$arrBasicInfo->strPermitPicture}" target="_blank">查看</a>
                
            {/if}
            </div>
        </div>
        </td>
    </tr>
    <!--<tr class="">
        <td class="even"><div class="ui_table_tdcntr">意向产品</div></td>
        <td><div class="ui_table_tdcntr"></div></td>
        <td class="even"><div class="ui_table_tdcntr"></div></td>
        <td><div class="ui_table_tdcntr"></div></td>
    </tr>-->
</tbody>
</table>   
</div>
</div>
<div class="list_table_main">
<div class="ui_table ui_table_nohead">
    <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">负责人信息</h4></div></div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody class="ui_table_bd">
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">负责人</div></td>
                <td><div class="ui_table_tdcntr">{if $arrNewInfo.charge_person neq ''}{$arrNewInfo.charge_person}{else}{$arrBasicInfo->strChargePerson}{/if}</div></td>
                <td class="even"><div class="ui_table_tdcntr">职务</div></td>
                <td><div class="ui_table_tdcntr">{$arrBasicInfo->strChargePositon}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                <td><div class="ui_table_tdcntr">{if $arrNewInfo.charge_phone neq ''}{$arrNewInfo.charge_phone}{else}{$arrBasicInfo->strChargePhone}{/if}</div></td>
                <td class="even"><div class="ui_table_tdcntr">MSN</div></td>
                <td><div class="ui_table_tdcntr">{$arrBasicInfo->strChargeMsn}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                <td><div class="ui_table_tdcntr">{if $arrNewInfo.charge_tel neq ''}{$arrNewInfo.charge_tel}{else}{$arrBasicInfo->strChargeTel}{/if}</div></td>
                <td class="even"><div class="ui_table_tdcntr">QQ</div></td>
                <td><div class="ui_table_tdcntr">{if $arrBasicInfo->iChargeQq neq 0}{$arrBasicInfo->iChargeQq}{/if}</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                <td><div class="ui_table_tdcntr">{$arrBasicInfo->strChargeFax}</div></td>
                <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                <td><div class="ui_table_tdcntr">{$arrBasicInfo->strChargeEmail}</div></td>
            </tr>
        </tbody>
   </table>   
</div>
</div>
<!----------------------------------------------------------------------------->                    	
</div>
<!--<div class="form_block_hd">
<h3 class="ui_title">框架合同状态：审核中</h3>
<!--
<a class="ui_button ui_link marginBottom10" href="javascript:;"><div class="ui_text" onClick="IM.Toggle('.agentInfoToggle',this,'显示框架合同业务流程▼','收起框架合同业务流程▲')">显示框架合同业务流程▼</div></a>

</div>-->
<!--<div class="form_block_bd agentInfoToggle">      
<!--S form_block_ft-->  
<div class="form_block_ft">
<div class="agentAuditBlock" style="margin:0;">
{if $strPactFile == ""}
<div class="tf">
        <label style="width:130px;">合同扫描件：</label>
        <div class="inp qua_upload">
            <div class="fileBtn"><input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload5">
            <input type="hidden" id="permitJ_upload5" name="permitJ_upload5" {if $pactFile neq ''} value="{$pactFile}" {/if} />
            </div> 
            <div style="display:block" class="img" id="J_uploadImg5">
            {if $pactFile neq ''}
             <img width="200" src="{$pactFile}"/>
            {/if}
            </div>
        </div>
    <span class="info" style="display:inline">支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
    <span class="ok">&nbsp;</span><span class="err">请上传合同扫描件</span>
</div>
{/if}
<div class="tf">
    <label style="width:130px;"><em class="require">*</em>审核备注：</label>
    <div class="inp"><textarea name="check_remark" class="" id="check_remark" valid="businessPosition"></textarea></div>
</div>
<div class="tf">
<label style="width:130px;">&nbsp;</label>
<div class="inp">
	<input type="hidden" name="checkStatus" id="checkStatus" value="0" />
    <input type="hidden" name="pactId" id="pactId" value="{$arrPact.aid}" />
    <input type="hidden" name="agentId" id="agentId" value="{$arrPact.agent_id}" />
    <input type="hidden" name="checkStep" id="checkStep" value="{$checkStep}" />
    <input type="hidden" name="pactType" id="pactType" value="{$pactType}" />
    <div class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"><button type="submit" name="pass" id="passChcek" onclick="$('#checkStatus').val(1);"> 通 过 </button></div></div></div>
    <div class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">
    	<button type="submit" name="nopass" id="noPassCheck" onclick="$('#checkStatus').val(2);"> 不通过 </button>
    </div></div></div>
    <a href="javascript:;" onClick="PageBack()" class="ui_button ui_button_dis"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"> 取 消 </div></div></a>
</div>
</div>
</div>
</div>
<!--E form_block_ft-->

</div>

<!--E form_bd-->
</form>
</div>
<script type="text/javascript">
{literal}
new Reg.vf($('#J_agentAuditForm'),{callback:function(data){   
	if($.trim($('#check_remark').val()) == ''){IM.tip.warn('审核备注不能为空！');return false;}	
	$.ajax({
		type:'POST',
		url:'/?d=Agent&c=AgentMove&a=signCheck',
		data:$('#J_agentAuditForm').serialize(),
		dataType:'json',
		success:function(data)
		{
			if(data.success == true)
			{
				IM.tip.show(data.msg);
				//JumpPage(data.url);
                PageBack();
			}
			else
			{
				IM.tip.show(data.msg);
				return false;
			}
		}
	});
}});
new IM.upload({id:'J_upload5',noticeId:'J_uploadImg5',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir={$arrAgentSourceInfo.agent_id}'{literal}});
{/literal} 
</script>