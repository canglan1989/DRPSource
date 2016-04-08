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
           <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:200px;"/></div>
           <!--<div class="ui_title">代理等级：</div>
            <div class="ui_comboBox">
            	<select name="cbLevel">
                <option value="-100">请选择</option>
                <option value="1">金牌</option>
                <option value="2">银牌</option>
                </select>
           </div>
           <div class="ui_title">合同号：</div>
           <div class="ui_text"><input type="text" name="tbxPactNo" id="tbxPactNo" value="" style="width:150px;"/></div>-->
            <div class="ui_title">预存款类型：</div>
            <div class="ui_text">
                <select id="cbAccountType" name="cbAccountType">
                </select>
            </div>	
            <div class="ui_title">产品：</div>
            <div class="ui_text">
            <select id="cbProductType" name="cbProductType">
            </select></div>
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
            <a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
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
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">产品</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">预存款类型</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值总额</div></div></th>
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">冻结金额</div></div></th>
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">消费总额</div></div></th>
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">其他支出</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">可用金额</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">可用本金</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">可用返点/销奖</div></div></th>
                   <th width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
    cbDataBind.PreAccountTypes("cbAccountType");
	{/literal}
    var productTypeID = parseInt({$qProductTypeID});
    var accountTypeID = parseInt({$qAccountType});
	pageList.strUrl = "{$PreDepositsAccountBody}"; 
	{literal}
    
    if(accountTypeID > 0)
        $("#cbAccountType").val(accountTypeID);
        
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


function ExportExcel()
{
    
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
                "agentID="+agentID+"&accountType="+accountType+"&productTypeID="+productTypeID+"&isPre=1",function(q){
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


function AdhaiReturnMoney(agentID,agentName)
{    
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: '网盟退款操作',
	    html: IM.STATIC.LOADING,
        start:function(){
                MM.get("/?d=FM&c=UnitInMoney&a=AdhaiMoneyReturnModify",
                "agentID="+agentID+"&agentName="+encodeURIComponent(agentName),function(q){
                $('.DCont')[0].innerHTML= q;
                                
                $('#tbxCustomerUser').autocomplete('/?d=FM&c=UnitInMoney&a=UnitHaveChargeMoneyCustomerAccount&agentID='+agentID, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                    max: 8, //只显示8
                    width: 200, //下拉列表的宽
                    parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表                    
                        var parsed = [];
                        if(backData == "" || backData.length == 0)
                            return parsed;                                
                        backData = MM.json(backData);
                        var value = backData.value;
                        if(value == undefined)
                             return parsed;
                             
                        for (var i = 0; i < value.length; i++) {
                            parsed[parsed.length] = {
                                data: value[i],
                                value: value[i].id,
                                result: value[i].name
                            }
                        }
                        return parsed;
                    },
                    formatItem: function (item) {//内部方法生成列表
                        return "<div>"+item.name+"</div>";
                    }
                    }).result(function (data,value) {//执行模糊匹配
                        var id = value.id;
                        GetCanReturnMoney(id);
                });

                
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
                        url:'/?d=FM&c=UnitInMoney&a=AdhaiMoneyReturnModifySubmit',
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

function GetCanReturnMoney(accountName)
{
    $money = $PostData("/?d=FM&c=UnitInMoney&a=GetCustomerCanReturnMoney","accountName="+encodeURIComponent(accountName));
    $money = $money.split(",");
    $("#divCanReturnMoney").html($money[0]);
    $("#tbxActMoney").val($money[0]);
    
    $("#spanPre").html($money[1]);
    $("#spanRePre").html($money[2]);
    /*
    $("#tbxPreRate").val($money[1]);
    $("#tbxReRate").val($money[2]);
    
    CalculateReturnMoney($DOM("tbxActMoney"));*/
}
/*
function CalculateReturnMoney(obj)
{
    var reMoney = parseFloat(obj.value) / (parseFloat($DOM("tbxPreRate").value)+parseFloat($DOM("tbxReRate").value))*parseFloat($DOM("tbxPreRate").value);
    reMoney = reMoney.toFixed(2);
    $("#spanPre").html(reMoney);
    $("#spanRePre").html((parseFloat(obj.value)-reMoney).toFixed(2));
}
*/
function MoveMoney(agentID,accountType,productTypeID)
{
    IM.dialog.show({
        width: 600,
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