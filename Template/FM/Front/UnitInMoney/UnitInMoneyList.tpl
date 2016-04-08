<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<div class="table_filter marginBottom10">  
	<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">转款交易号：</div>
            <div class="ui_text"><input type="text" name="tbxNo" id="tbxNo" value="" style="width:100px;"/></div>	                
            <div class="ui_title">客户名称：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerName"  id="tbxCustomerName" value="" style="width:200px;"/></div>	                         	        	
            <div class="ui_title">操作时间：</div>
            <div class="ui_text">
                <input id="J_editTimeS" type="text" value="{$CreateTimeBegin}" class="inpCommon inpDate" name="tbxOptSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
                至
                <input id="J_editTimeE" type="text" value="{$CreateTimeEnd}" class="inpCommon inpDate" name="tbxOptEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
            </div>
            <div class="ui_title">操作人：</div>
            <div class="ui_text">
                <input id="opername" type="text" value="{$OperName}" class="inpCommon" name="opername" />
            </div>
            </div>
            <div class="table_filter_main_row">
            <div class="ui_title">仅扣预存款：</div>
            <div class="ui_text"><select id="cbOnlyChargePre" name="cbOnlyChargePre">
            <option value="-100">请选择</option>
            <option {if $iOnlyChargePre == 1} selected="selected" {/if} value="1">是</option>
            <option {if $iOnlyChargePre == 0} selected="selected" {/if} value="0">否</option>
            </select></div>		                                
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
</div>
<div class="list_link marginBottom10">
    <a m="UnitInMoneyList" ispurview="true" v="4" class="ui_button" 
    onclick="InMoney()" href="javascript:;" style="margin:0">
    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div>
    <div class="ui_text"> 转 款 </div></div></a>
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
                   <th width="110"><div class="ui_table_thcntr"><div class="ui_table_thtext">转款交易号</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">订单号</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
                   <th width="120"><div class="ui_table_thcntr"><div class="ui_table_thtext">帐户名</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">转款金额</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">预存款</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">返点</div></div></th>   
                   <th width="150"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                   <th width="150"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
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
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal}
<script type="text/javascript">
$(function(){    
	{/literal}
	pageList.strUrl = "{$UnitInMoneyListBody}"; 
	{literal}
    
	pageList.param = '&'+$("#tableFilterForm").serialize();//+"&productTypeIDs="+$("#ui_comboBox_agentPro").attr("key")+"&priceStatus="+$("#ui_comboBox_priceStatus").attr("key");
	pageList.init();
});


function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();//+"&productTypeIDs="+$("#ui_comboBox_agentPro").attr("key")+"&priceStatus="+$("#ui_comboBox_priceStatus").attr("key");
    pageList.first();
}


_InDealWith = false;   
function InMoney()
{
    IM.dialog.show({
        width: 560,
	    height: null,
	    title: '转款操作',
	    html: IM.STATIC.LOADING,
        start:function(){
            MM.get("/?d=FM&c=UnitInMoney&a=InMoneyModify","",function(q){
                $('.DCont')[0].innerHTML= q;
                
                $('#tbxCustomerUser').autocomplete('/?d=FM&c=UnitInMoney&a=AutoCustomerAccountJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
                });

                new Reg.vf($('#J_backForm'),{callback:function(formData){
                    
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    
                    _InDealWith = true;                    
                    var backData = $PostData('/?d=FM&c=UnitInMoney&a=InMoneyModifySubmit',$("#J_backForm").serialize());                    
                    if(parseInt(backData) == 0){
                        pageList.reflash();
    				    _InDealWith = false;
    			        IM.dialog.hide();	
                        IM.tip.show("转款提交成功！");
    				}else{
                        _InDealWith = false;
                        IM.tip.warn(backData);
    				}
                }});
            })
        }
    });
}

function CalculatePreReMoney()
{
    var actMoney = parseFloat($DOM("tbxActMoney").value);
    var backData = $PostData("/?d=FM&c=UnitInMoney&a=GetUnitChargeMoney","actMoney="+actMoney);
    var aMoney = backData.split(",");
    $DOM("spanPreMoney").innerHTML = aMoney[0];
    $DOM("spanReMoney").innerHTML = aMoney[1];
}

</script>
{/literal}