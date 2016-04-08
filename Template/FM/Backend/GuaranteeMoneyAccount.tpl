<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
           <div class="ui_title">代理商代码：</div>
           <div class="ui_text"><input type="text" name="tbxAgentNo" id="tbxAgentNo" value="" style="width:100px;"/></div>	                
           <div class="ui_title">代理商名称：</div>
           <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:180px;"/></div>
           <div class="ui_title">产品：</div>
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType"></select></div>
           <!-- <div class="ui_title">代理等级：</div>
            <div class="ui_comboBox">
            	<select name="cbLevel">
                <option value="-100">请选择</option>
                <option value="1">金牌</option>
                <option value="2">银牌</option>
                </select>
           </div>-->
            <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
		</div>
    </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
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
                   <th width="130"><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商代码</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商名称</div></div></th>
                  <!--<th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">代理等级</div></div></th>-->                  
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">产品名称</div></div></th>                                   
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">入帐金额</div></div></th>          
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">出帐金额</div></div></th>           
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">账户余额</div></div></th>
                   <th width="300"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
    
	{/literal}
    var productTypeID = parseInt({$qProductTypeID});
	pageList.strUrl = "{$GuaranteeAccountListBody}"; 
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



var _InDealWith = false;
function ChargeMoney(agentID,accountType,productTypeID)
{
    IM.dialog.show({
        width: 560,
	    height: null,
	    title: '支出操作',
	    html: IM.STATIC.LOADING,
        start:function(){
                MM.get("/?d=FM&c=PreDeposits&a=InOutMoneyModify",
                "agentID="+agentID+"&accountType="+accountType+"&productTypeID="+productTypeID+"&isPre=0",function(q){
                $('.DCont')[0].innerHTML= q;
                
                var cbInOutType = $DOM("cbInOutType");
                if(cbInOutType.options.length == 2)
                {
                    cbInOutType.options[1].selected = true;
                }
                
                new Reg.vf($('#J_backForm'),{callback:function(formData){
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    var postData = $("#J_backForm").serialize();
                    
                    _InDealWith = true;   
                    MM.ajax({
                        url:'/?d=FM&c=PreDeposits&a=InOutMoneyModifySubmit',
                        data:postData,
                        success:function(backData){
                            if(parseInt(backData) == 0){
                                pageList.reflash();
            				    _InDealWith = false;
            			        IM.dialog.hide();	
                                IM.tip.show("操作成功！");
            				}else{
                                _InDealWith = false;
                                IM.tip.warn(backData);
            				}
                        }
                    });
                }});
            })
        }
    });
        
}

function MoveMoney(agentID,accountType,productTypeID)
{
    IM.dialog.show({
        width: 560,
	    height: null,
	    title: '帐户间转款操作',
	    html: IM.STATIC.LOADING,
        start:function(){
                MM.get("/?d=FM&c=PreDeposits&a=MoveMoneyModify",
                "agentID="+agentID+"&accountType="+accountType+"&productTypeID="+productTypeID+"&isPre=0",function(q){
                $('.DCont')[0].innerHTML= q;
                
                var cbInOutType = $DOM("cbAccountProductType");
                if(cbInOutType.options.length == 2)
                {
                    cbInOutType.options[1].selected = true;
                    ShowReMoney(cbInOutType);
                }
                
                new Reg.vf($('#J_backForm'),{callback:function(formData){
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    var postData = $("#J_backForm").serialize();
                    
                    _InDealWith = true;   
                    MM.ajax({
                        url:'/?d=FM&c=PreDeposits&a=MoveMoneyModifySubmit',
                        data:postData,
                        success:function(backData){
                            if(parseInt(backData) == 0){
                                pageList.reflash();
            				    _InDealWith = false;
            			        IM.dialog.hide();	
                                IM.tip.show("操作成功！");
            				}else{
                                _InDealWith = false;
                                IM.tip.warn(backData);
            				}
                        }
                    });
                }});
            })
        }
    });
        
}


function ShowReMoney(obj)
{
    if(obj.value == "7,4")
    {
        $DOM("divReMoney").style.display = "";   
        CalculateReMoney();     
    }
    else
    {
        $DOM("divReMoney").style.display = "none";        
    }
}


function CalculateReMoney()
{
    //$("#divReMoneyValue").html("0");
    var IsUnitPreDeposits = $DOM("IsUnitPreDeposits").value;    
    if(parseInt(IsUnitPreDeposits) == 1)
    {
        var reMoney = $PostData("/?d=FM&c=PreDeposits&a=UnitPreDepositsMoveMoney","agentID="+$("#tbxAgentID").val()+"&actMoney="+$("#tbxActMoney").val());
        if(parseInt(reMoney) >= 0)
        {
            $("#tSaleRewardMoney").val(reMoney);
            $("#divReMoneyValue").html(reMoney);
        }
        else
        {
            IM.tip.warn(reMoney);
        }
    }
    else if($DOM("cbAccountProductType").value == "7,4")
    {
        var reMoney = $PostData("/?d=FM&c=PreDeposits&a=GetUnitSaleRewardMoney","agentID="+$("#tbxAgentID").val()+"&actMoney="+$("#tbxActMoney").val());
        if(parseInt(reMoney) >= 0)
        {
            $("#tSaleRewardMoney").val(reMoney);
            $("#divReMoneyValue").html(reMoney);
        }
        else
        {
            IM.tip.warn(reMoney);
        }
    }
}
</script>
{/literal} 