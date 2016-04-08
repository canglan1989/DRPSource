<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<div class="table_attention marginBottom10">
    <label>余额提醒设置(0表示不提醒)：</label>
    {foreach from=$arrayAccountBalanceWarning item=data key=index}    
    <span class="ui_link">{$data.product_type_name}：保证金(<em>{$data.gua_balance_warning}</em>)&nbsp;预存款(<em>{$data.pre_balance_warning}</em>)</span>
    {if $index > 0 && ($index+1) % 3 == 0}
    <br />
    {/if}
    {/foreach}
</div>  
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
           <div class="ui_title"><input type="hidden" value="{$iGuaMoney}" id="tbxGuaMoney" name="tbxGuaMoney" />
           <input type="hidden" value="{$iUnitGuaMoney}" id="tbxUnitGuaMoney" name="tbxUnitGuaMoney" />
           <input type="hidden" value="{$iPreMoney}" id="tbxPreMoney" name="tbxPreMoney" />
           <input type="hidden" value="{$iUnitPreMoney}" id="tbxUnitPreMoney" name="tbxUnitPreMoney" />
           代理商代码：</div>
           <div class="ui_text"><input type="text" name="tbxAgentNo" id="tbxAgentNo" value="" style="width:100px;"/></div>	                
           <div class="ui_title">代理商名称：</div>
           <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:180px;"/></div>
           <div class="ui_title">账户类型：</div>
            <div class="ui_text">
                <select id="cbAccountType" name="cbAccountType">
                </select>
            </div>  
            <div class="ui_title">产品：</div>
            <div class="ui_text">
            <select id="cbProductType" name="cbProductType">
            </select></div>

		</div>
           <div class="table_filter_main_row">
                          <div class="ui_title">可用余额：</div>
           <div class="ui_text"><input type="text" name="tbxSBalanceMoney" id="tbxSBalanceMoney" value="" style="width:80px;text-align:right;" onkeyup='return FloatNumber(this)'/></div>
           <div class="ui_text">--</div>
           <div class="ui_text"><input type="text" name="tbxEBalanceMoney" id="tbxEBalanceMoney" value="" style="width:80px;text-align:right;" onkeyup='return FloatNumber(this)'/></div>	  
           <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
           </div>
    </div>
    </form>
</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
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
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商代码</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商名称</div></div></th>      
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">账户类型</div></div></th>   
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">产品</div></div></th>                
                   <th class="TA_r"><div class="ui_table_thcntr"><div class="ui_table_thtext">账户余额</div></div></th>             
                   <th class="TA_r"><div class="ui_table_thcntr"><div class="ui_table_thtext">可用金额</div></div></th>
               </tr>
           </thead>
           <tbody class="ui_table_bd" id="pageListContent">               
           </tbody>
       </table>     
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main-->           
<!--S list_table_foot-->
<div class="list_table_foot">
    <div class="ui_pager" id="divPager">    	
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script type="text/javascript">
$(function(){    
    $GetProduct.BindProductType("cbProductType", true);
    cbDataBind.AccountTypes("cbAccountType");
	{/literal}
    var productTypeID = parseInt({$qProductTypeID});
	pageList.strUrl = "{$AgentPostMoneyNoticeListBody}"; 
	{literal}        
    
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
        
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
}); 

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}

</script>
{/literal} 