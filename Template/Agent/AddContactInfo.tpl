<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=showChannelPager')">我的渠道</a><span>&gt;</span>代理商信息</div>
<!--E crumbs--> 
<!--S form_edit-->
<div class="form_edit">
  <div class="form_hd">
    <ul>
      <li class="cur">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>代理商信息</h2>
            </div>
          </div>
        </div>
      </li>
      <li> <a href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentDetailInfo'}&agentId={$objAgentInfo->iAgentId}');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>联系信息</h2>
            </div>
          </div>
        </div>
        </a> </li>
      {if $objAgentInfo->iAgentId != $objAgentInfo->strAgentNo}
      <li> <a href="javascript:;" onclick="JumpPage('{au d='Agent' c='AgentDoc' a='Detail'}&id={$objAgentInfo->iAgentId}');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>附件信息</h2>
            </div>
          </div>
        </div>
        </a> </li>
        {/if}
    </ul>
    <div class="form_hd_oper"> <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;">
      <div class="ui_button_left"></div>
      <div class="ui_button_inner">
        <div class="ui_icon ui_icon_return"></div>
        <div class="ui_text">返回</div>
      </div>
      </a> {if $objAgentInfo->iIsCheck eq 1 and $showbutton eq 1} <a class="ui_button" onclick="JumpPage('{au d='Agent' c='AgentMove' a='showSignInfo'}&agentId={$objAgentInfo->iAgentId}&fromType=1&isPact={$isPact}');" style="cursor:pointer;">
      <div class="ui_button_left"></div>
      <div class="ui_button_inner">
        <div class="ui_icon ui_icon_submitAudit"></div>
        <div class="ui_text">提交补签</div>
      </div>
      </a> {/if}
      {if !($addNum neq 0 and $objAgentInfo->iIsCheck eq 2)} <a class="ui_button" onclick="JumpPage('{au d='Agent' c='AgentMove' a='showSignInfo'}&agentId={$objAgentInfo->iAgentId}&fromType=1&isPact={$isPact}');" style="cursor:pointer;">
      <div class="ui_button_left"></div>
      <div class="ui_button_inner">
        <div class="ui_icon ui_icon_submitAudit"></div>
        <div class="ui_text">提交签约</div>
      </div>
      </a> {/if} </div>
  </div>
</div>
<!--S form_bd-->
<div class="form_bd"> 
  <!--S form_block_bd-->
  <div class="form_block_bd"> {if $isPact eq 'yes'} 
    <!--        	
				<a class="ui_button ui_link" href="javascript:;" style="margin-bottom:5px;"><div class="ui_text" onClick="IM.Toggle('.agentInfoToggle',this,'查看代理商信息▼','收起代理商信息▲')">查看代理商信息▼</div></a>
				--> 
    {/if} 
    <!--E list_link-->
    <div class="list_table_main marginBottom10 agentInfoToggle">
      <div class="ui_table ui_table_nohead">
        <div class="ui_table_hd">
          <div class="ui_table_hd_inner"> 
           {if $isPact eq 'no'}
               <a class="ui_button ui_link" onclick="JumpPage('{au d='Agent' c='Agent' a='showModifyPager'}&agentId={$objAgentInfo->iAgentId}&checkStatus={$objAgentInfo->iIsCheck}&needCheck={$needCheck}&fromType=1')">资料修改记录</a> 
               <a class="ui_button ui_link" onclick="JumpPage('{au d='Agent' c='Agent' a='EditShow'}&agentId={$objAgentInfo->iAgentId}&checkStatus={$objAgentInfo->iIsCheck}&needCheck={$needCheck}&fromType=1')"><span class="ui_icon ui_icon_edit">&nbsp;</span>修改代理商资料</a> 
           {/if}
            <h4 class="title">代理商基本信息</h4>
            <span style = "margin-left:10px;"> 创建时间：{$create_time}</span> </div>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody class="ui_table_bd">
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strAgentName}</div></td>
              <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
              <td><div class="ui_table_tdcntr"> <b class="amountStyle">{$objAgentInfo->strRegCapital}</b> </div></td>
              <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
              <td><div class="ui_table_tdcntr"> {if $objAgentInfo->strCustomerNum eq 0}
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
                  {/if} </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strAreaFullName}>{$objAgentInfo->strAddress}</div></td>
              <td class="even"><div class="ui_table_tdcntr">注册日期</div></td>
              <td><div class="ui_table_tdcntr">{if $objAgentInfo->strRegDate eq '0000-00-00'}{else}{$objAgentInfo->strRegDate}{/if}</div></td>
              <td class="even"><div class="ui_table_tdcntr">企业客户数</div></td>
              <td><div class="ui_table_tdcntr"> {if $objAgentInfo->strCustomerNum eq 0}
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
                  3000人以上   
                  {/if} </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">注册地址</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strRegAreaFullName}</div></td>
              <td class="even"><div class="ui_table_tdcntr">营业执照号</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strPermitRegNo}</div></td>
              <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
              <td><div class="ui_table_tdcntr"> {if $objAgentInfo->strAnnualSales eq 0}
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
                  {/if} </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strPostcode}</div></td>
              <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strRevenueNo}</div></td>
              <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strWebSite}</div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">所属行业</div></td>
              <td><div class="ui_table_tdcntr"> {if $objAgentInfo->iIndustry eq 1}
                  IT硬件
                  {elseif $objAgentInfo->iIndustry eq 2}
                  传媒
                  {elseif $objAgentInfo->iIndustry eq 3}
                  网络
                  {elseif $objAgentInfo->iIndustry eq 4}
                  广告
                  {elseif $objAgentInfo->iIndustry eq 5}
                  其他
                  {/if} </div></td>
              <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
              <td><div class="ui_table_tdcntr"> {if $objAgentInfo->strCompanyScale eq 0}
                  {elseif $objAgentInfo->strCompanyScale eq 1}
                  10-50人
                  {elseif $objAgentInfo->strCompanyScale eq 2}
                  50-100人
                  {else}
                  100人以上
                  {/if} </div></td>
              <td class="even" rowspan = "2"><div class="ui_table_tdcntr">经营范围</div></td>
              <td rowspan = "2"><div class="ui_table_tdcntr"> {$objAgentInfo->strDirection} </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
              <td><div class="ui_table_tdcntr">{$objAgentInfo->strLegalPerson}</div></td>
              <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
              <td><div class="ui_table_tdcntr"> {if $objAgentInfo->strSalesNum eq 0}
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
                  {/if} </div></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    {if $objAgentInfo->iAgentId != $objAgentInfo->strAgentNo} 
    <!--S list_table_main-->
    <div class="list_table_main marginBottom10">
      <div class="ui_table ui_table_nohead">
        <div class="ui_table_hd">
          <div class="ui_table_hd_inner">
            <h4 class="title">合同基本信息</h4>
          </div>
        </div>
        {foreach from=$arrAllPact item=arrPact}
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
              <td><div class="ui_table_tdcntr" style="line-height:20px; overflow-y:auto; max-height:200px;"> {foreach from=$arrPact.areaName item=strArea key=key}
                  {if $key mod 2 eq 0}<br />
                  {/if}{$strArea}&nbsp;&nbsp;&nbsp;&nbsp;
                  {/foreach} </div></td>
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
          </tbody>
        </table>
        {/foreach} </div>
      <!--E ui_table--> 
    </div>
    <!--E list_table_main-->    
    {/if} 
    <!--S list_table_head-->
    <div class="list_table_head">
      <div class="list_table_head_right">
        <div class="list_table_head_mid">
          <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 联系人信息</h4>
          <a class="ui_button ui_link" href="javascript:;"   onClick="IM.agent.addContactInfo('{au d='Agent' c='Agent' a='showAddContacter'}','添加联系人信息','{$objAgentInfo->iAgentId}','{$isPact}')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系人</a> </div>
      </div>
    </div>
    <!--E list_table_head--> 
    <!--S list_table_main-->
    <div class="list_table_main marginBottom10" id="ContacterInfo">
      <div class="ui_table" id="J_ui_table">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <thead class="ui_table_hd">
            <tr class="">
              <th style="width:100px;" title="姓名"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">姓名</div>
                </div>
              </th>
              <th style="width:80px;" title="职务"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">职务</div>
                </div>
              </th>
              <th style="width:120px;" title="手机号码"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">手机号码</div>
                </div>
              </th>
              <th style="width:120px;" title="固定电话"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">固定电话</div>
                </div>
              </th>
              <th style="width:120px;" title="微博"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">微博</div>
                </div>
              </th>
              <th style="width:120px;" title="传真号码"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">传真号码</div>
                </div>
              </th>
              <th title="电子邮箱"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">电子邮箱</div>
                </div>
              </th>
              <th style="width:120px;" title="QQ"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">QQ</div>
                </div>
              </th>
              <th style="width:120px;" title="MSN"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">MSN</div>
                </div>
              </th>
              <th title="备注"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">备注</div>
                </div>
              </th>
              <th style="width:120px;" title="操作"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">操作</div>
                </div>
              </th>
            </tr>
          </thead>
          <tbody class="ui_table_bd">
          
          {foreach from=$arrAllContacter item=Contacter}
          <tr class="">
            <td title="{$Contacter.contact_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onClick="IM.agent.getContactInfo({literal}{{/literal}'id':{$Contacter.aid}{literal}}{/literal})"> {if $Contacter.isCharge eq 0} {$Contacter.contact_name}(是负责人)
                { else }{$Contacter.contact_name}
                {/if}</a></div></td>
            <td title="{$Contacter.position}"><div class="ui_table_tdcntr">{$Contacter.position}</div></td>
            <td title="{$Contacter.mobile}"><div class="ui_table_tdcntr">{$Contacter.mobile} </div></td>
            <td title="{$Contacter.tel}"><div class="ui_table_tdcntr">{$Contacter.tel}</div></td>
            <td title="{$Contacter.tel}"><div class="ui_table_tdcntr">{$Contacter.twitter}</div></td>
            <td title="{$Contacter.fax}"><div class="ui_table_tdcntr">{$Contacter.fax}</div></td>
            <td title="{$Contacter.email}"><div class="ui_table_tdcntr">{$Contacter.email}</div></td>
            <td title="{$Contacter.tel}"><div class="ui_table_tdcntr">{if $Contacter.qq neq 0}{$Contacter.qq}{/if}</div></td>
            <td title="{$Contacter.tel}"><div class="ui_table_tdcntr">{$Contacter.msn}</div></td>
            <td title="{$Contacter.remark}"><div class="ui_table_tdcntr">{$Contacter.remark|truncate:"18":"..."}</div></td>
            <td><div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                  <li><a onClick="IM.agent.addContactInfo('{au d='Agent' c='Agent' a='showAddContacter'}&id={$Contacter.aid}','编辑联系人信息','{$objAgentInfo->iAgentId}','{$isPact}')" href="javascript:;">编辑</a></li>
                  {if $Contacter.isCharge == 1}
                  <li><a onclick="IM.account.delOper('{au d='Agent' c='Agent' a='DelContacter'}',{literal}{{/literal}'listid':{$Contacter.aid}{literal}}{/literal},'删除联系人',this)" href="javascript:;">删除</a></li>
                  {/if}
                </ul>
              </div></td>
          </tr>
          {/foreach}
            </tbody>
          
        </table>
      </div>
      <!--E ui_table--> 
    </div>
    <!--E list_table_main--> 
    
  </div>
</div>
<script language="javascript" type="text/javascript">
{literal}
new Reg.vf($('#J_newLXXiaoJi'),{callback:function(data){
	if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
	if(!IM.IsSending(true)){return false;};
		$.ajax({
			type:'POST',
			data:$('#J_newLXXiaoJi').serialize(),
			{/literal}
			url:'{au d="Agent" c="Agent" a="AddContactInfo"}',
			{literal}
			success:function(data){
			IM.IsSending(false);
				switch(data)
				{
					case '1':
						IM.tip.show('代理商联系小记添加成功！');
						window.location.reload();
						break;
					case '2':
						IM.tip.warn('非法参数，请检查！');
						break;
					case '3':
						IM.tip.warn('联系人信息不能为空！');
						break;
					case '4':
						IM.tip.warn('手机号码不能为空！');
						break;
					default:
						IM.tip.warn('代理商联系小记添加失败！');
						break;
				}
			}
		});
	}
});
function showAddContactInfo(agent_id,isPact){
    IM.dialog.show({
            width:650,
            height:null,
            title:'添加联系小记',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=Agent&c=Agent&a=showAddContactInfo&agent_id="+agent_id+"&isPact="+isPact));
            }
         })
}
{/literal}
</script>