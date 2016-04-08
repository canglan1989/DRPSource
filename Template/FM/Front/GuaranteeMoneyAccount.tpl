<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->  
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
</a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
            <a class="ui_button ui_link" onclick="JumpPage('/?d=FM&c=GuaranteeMoney&a=GuaranteeMoneyAccount')" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table" id="J_ui_table">                    	
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">                                	
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">产品</div></div></th>
               <th title=""><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号</div></div></th>
               <th title=""><div class="ui_table_thcntr"><div class="ui_table_thtext">合同时间</div></div></th>	
                   <th class="TA_r" width="120"><div class="ui_table_thcntr"><div class="ui_table_thtext">入账金额(元)</div></div></th>
                   <th class="TA_r" width="120"><div class="ui_table_thcntr"><div class="ui_table_thtext">出账金额(元)</div></div></th>
                   <th class="TA_r" width="120"><div class="ui_table_thcntr"><div class="ui_table_thtext">账户余额(元)</div></div></th>
                   <th width="250"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
               </tr>
           </thead>
           <tbody class="ui_table_bd" id="pageListContent">
           {foreach from=$arrPageList item=data key=index}
                <tr class="{sdrclass rIndex=$index}">
                    <td><div class="ui_table_tdcntr"></div></td>
            	<td ><div class="ui_table_tdcntr">--</div></td>
            	<td ><div class="ui_table_tdcntr">--</div></td>
                    <td style="width:120px;" class="TA_r"><div class="ui_table_tdcntr">{$data.in_money}</div></td>
                    <td style="width:120px;" class="TA_r"><div class="ui_table_tdcntr">{$data.out_money}</div></td>
                    <td style="width:120px;" class="TA_r"><div class="ui_table_tdcntr">{$data.balance_money}</div></td>
                    <td style="width:200px;">
                        <div class="ui_table_tdcntr">
                        	<ul class="list_table_operation">
                            	<li><a href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=PostMoneyDetailList&cbFrTypes=1')">打款明细</a></li>
                            	<li><a href="javascript:;" onClick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=1')">收支明细</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {/foreach}
           {foreach from=$arrayGuaranteeMoney item=data key=index}
                <tr class="{sdrclass rIndex=$index}">
                    <td><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
            	   <td ><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}')">{$data.pact_no}</a></div></td>
            	   <td ><div class="ui_table_tdcntr">{$data.pact_sdate|date_format:"%Y-%m-%d"} -- {$data.pact_edate|date_format:"%Y-%m-%d"}</div></td>
                    <td style="width:120px;" class="TA_r"><div class="ui_table_tdcntr">{$data.in_money}</div></td>
                    <td style="width:120px;" class="TA_r"><div class="ui_table_tdcntr">{$data.out_money}</div></td>
                    <td style="width:120px;" class="TA_r"><div class="ui_table_tdcntr">{$data.balance_money}</div></td>
                    <td style="width:200px;">
                        <div class="ui_table_tdcntr">
                        	<ul class="list_table_operation">
                            	<li><a href="javascript:;" m="PostMoneyDetailList" v="2" ispurview="true" onClick="JumpPage('/?d=FM&c=PayMoney&a=PostMoneyDetailList&cbFrTypes=1&productTypeID={$data.product_type_id}')">打款明细</a></li>
                            	<li><a href="javascript:;" m="AccountMoneyInOutList" v="2" ispurview="true" onClick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=1&productTypeID={$data.product_type_id}')">收支明细</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
       </table>     
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main-->   
{literal} 
<script type="text/javascript">
function ExportExcel()
{
    window.open("/?d=FM&c=GuaranteeMoney&a=ExcelExportGuaranteeMoneyAccount");
}

$(function(){
    var pageListContent = $DOM("pageListContent");
    
    if(pageListContent.rows.length < 1)
        pageListContent.innerHTML = "<tr class=\"\"><td colspan=\""+4+"\"><div style=\"text-align:center; padding:20px\" class=\"ui_table_tdcntr\">暂无数据</div></td></tr>";
});

</script>
{/literal} 