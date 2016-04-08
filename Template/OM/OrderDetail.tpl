<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：订单管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('{$strListPath}',true,true)">{$strSupTitle}</a><span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2>{$strTitle}</h2>
            </div>
        </div>
    </div>
    <div class="form_hd_oper">
            <a href="javascript:;" onclick="PageBack()" class="ui_button ui_button_dis"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
    </div>
</div>
<div class="form_bd">
	<form id="J_addOrder">
    <div class="form_block_bd">
		<div class="list_table_main marginBottom10">
			<div class="ui_table ui_table_nohead">
			    <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">订单信息</h4></div></div>
			    <table width="100%" cellspacing="0" cellpadding="0" border="0">
			       <tbody class="ui_table_bd">		            
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">订单号</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strOrderNo}</div></td>
			                <td class="even"><div class="ui_table_tdcntr">订单类型</div></td>
			                <td><div class="ui_table_tdcntr">{$orderTypeText}</div></td>
			            </tr>
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">产品名称</div></td>
			                <td><div class="ui_table_tdcntr">{$strProductName}</td>
			                <td class="even"><div class="ui_table_tdcntr">产品价格</div></td>
			                <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="OrderPriceStatus({$objOrder->iOrderId})"><b class="amountStyle">{$objOrder->iActPrice}</b></a></div></td>
			            </tr>                                                                                        
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">订单时间</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strOrderSdate|date_format:"%Y-%m-%d"}
            	            至
            	            {$objOrder->strOrderEdate|date_format:"%Y-%m-%d"}</div></td>
			                <td class="even"><div class="ui_table_tdcntr">订单状态</div></td>
			                <td><div class="ui_table_tdcntr"><a onclick="OrderStatusInfo({$objOrder->iOrderId})" href="javascript:;">{$checkStatusText}</a></div></td>
			            </tr>
                        {if $objOrder->strEffectSdate != $objOrder->strEffectEdate}
                        <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">订单有效期</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strEffectSdate|date_format:"%Y-%m-%d"}
            	            至
            	            {$objOrder->strEffectEdate|date_format:"%Y-%m-%d"}</div></td>
			                <td class="even"><div class="ui_table_tdcntr">{if $objOrder->strServiceTel != ""}客服电话{/if}</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strServiceTel}</div></td>
			            </tr>
                        {/if}
                        {$strWebSiteHTML}
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">订单备注</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strOrderRemark}</div></td>
			                <td class="even"><div class="ui_table_tdcntr"></div></td>
			                <td><div class="ui_table_tdcntr"></div></td>
			            </tr>
			            {if $objOrder->iCheckStatus != -2}
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">提交人</div></td>
			                <td><div class="ui_table_tdcntr"><a onclick="UserDetial({$objOrder->iPostUid})" href="javascript:;">{$strPostEmpName}</a></div></td>
			                <td class="even"><div class="ui_table_tdcntr">提交时间</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strPostDate}</div></td>
			            </tr>
			            {/if} 
			        </tbody>
			   </table>   
			</div>
		</div>
        {$giftHTML}
		<div class="list_table_main marginBottom10">
			<div class="ui_table ui_table_nohead">
			    <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">客户基本信息</h4></div></div>
			    <table width="100%" cellspacing="0" cellpadding="0" border="0">
			       <tbody class="ui_table_bd">		            
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">公司名称</div></td>
			                <td><div class="ui_table_tdcntr">
                            <a onclick="ShowCustomerCard({$objOrder->iCustomerId})" href="javascript:;">{$objOrder->strCustomerName}</a></div></td>
			                <td class="even"><div class="ui_table_tdcntr">法人姓名</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strLegalPersonName}</div></td>
			            </tr>
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">法人身份证号</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strLegalPersonId} 
                            <a  href="javascript:;" onclick="ViewPic('/?d=OM|c=CustomerPermit|a=ShowCorporatePhoto|customerID={$objOrder->iCustomerId}')">查看</a></div></td>
			                <td class="even"><div class="ui_table_tdcntr">营业执照号</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strBusinessLicense} 
                            <a  href="javascript:;" onclick="ViewPic('/?d=OM|c=CustomerPermit|a=ShowBusinessLicense|customerID={$objOrder->iCustomerId}')">查看</a></div></td>
			            </tr> 
			            <tr class="" {if $isNet != 1}style="display:none"{/if}>
			                <td class="even"><div class="ui_table_tdcntr">域名提供方</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strDomainProvider}</div></td>
			                <td class="even"><div class="ui_table_tdcntr"></div></td>
			                <td><div class="ui_table_tdcntr"></div></td>
			            </tr>
			        </tbody>
			   </table>   
			</div>
		</div>

		<div class="list_table_main marginBottom10">
			<div class="ui_table ui_table_nohead">
			    <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">联系人信息</h4></div></div>
			    <table width="100%" cellspacing="0" cellpadding="0" border="0">
			       <tbody class="ui_table_bd">		            
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">姓名</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strContactName}</div></td>
			                <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strContactMobile}</div></td>
			            </tr>
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strContactTel}</div></td>
			                <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strContactFax}</div></td>
			            </tr> 
			            <tr class="">
			                <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
			                <td><div class="ui_table_tdcntr">{$objOrder->strContactEmail}</div></td>
			                <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
			                <td><div class="ui_table_tdcntr">{$areaFullName}&nbsp;：&nbsp;{$strAddress}</div></td>
			            </tr>
			        </tbody>
			   </table>
			</div>
		</div>
        {if $checkFlag > 0}
        {$checkHTML}
        {/if}
     </div>        
    </form>                             
</div> 
</div>
<!--E sidenav_neighbour--> 
<script type="text/javascript" src="{$JS}Auditting.js"></script>
<script language="javascript" type="text/javascript">
Auditting.passAction = "{$passAction}";
Auditting.notPassAction = "{$notPassAction}";
Auditting.jumpPage = "{$jumpPage}";
{literal}
function OrderPriceStatus(orderID)
{
    IM.dialog.show({
         width: 400,
    	    height: null,
    	    title: '订单款项状态信息',
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    	       $('.DCont').html($PostData("/?d=OM&c=Order&a=OrderPriceStatus&id="+orderID,""));
        }
    });    
}
</script>
{/literal}
