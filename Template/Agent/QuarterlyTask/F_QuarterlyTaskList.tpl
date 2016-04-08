<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：季度任务管理<span>&gt;</span>{$strTitle}</div>
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
            <div class="ui_title">代理等级：</div>
            <div class="ui_comboBox">
            	<select id="cbLevel" name="cbLevel">
                <option value="-100">请选择</option>
                <option value="1">金牌</option>
                <option value="2">银牌</option>
                </select>
           </div>
    </div>
    <div class="table_filter_main_row">    
           <div class="ui_title">年份：</div>
            <div class="ui_comboBox">
            	<select id="cbYear" name="cbYear">
                <option value="-100">请选择</option>
                {foreach from=$arrayYear item=data key=index}
                <option value="{$data.year}">{$data.year}</option>
                {/foreach}
                </select>
           </div>
           <div class="ui_title">季度时间：</div>
            <div class="ui_comboBox">
            	<select id="cbQuarterly" name="cbQuarterly">
                <option value="-100">请选择</option>
                <option value="1">第一季度(1-3月)</option>
                <option value="2">第二季度(4-6月)</option>
                <option value="3">第三季度(7-9月)</option>
                <option value="4">第四季度(10-12月)</option>
                </select>
           </div>
        <div class="ui_title">充值状态：</div>
        <div class="ui_comboBox">
        	<select id="cbAwardStatus" name="cbAwardStatus">
            <option value="-100">请选择</option>
            <option value="1">已充值</option>
            <option value="0">未充值</option>
            </select>
        </div>
            <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
		</div>
    </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div></a>
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
                   <th width="120"><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商代码/名称</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">代理等级</div></div></th>
                   <th width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">产品名称</div></div></th>                                    
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">季度时间</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">任务额</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">完成额</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">销奖</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值金额</div></div></th>
                   <th class="TA_r" width="75"><div class="ui_table_thcntr"><div class="ui_table_thtext">市场基金</div></div></th>
                   <th class="TA_r" width="75"><div class="ui_table_thcntr"><div class="ui_table_thtext">渠道基金</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">添加人/添加时间</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值人/充值时间</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">充值备注</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
	pageList.strUrl = "{$QuarterlyTaskListBody}"; 
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


function ExportExcel()
{
    window.open("/?d=Agent&c=QuarterlyTask&a=ExcelExportQuarterlyTaskList" + pageList.param + "&sortField=" + pageList.sortField);
}


var _InDealWith = false;
function AwardMoney(id)
{
    IM.dialog.show({
        width: 550,
	    height: null,
	    title: '销奖转预存充值',
	    html: IM.STATIC.LOADING,
        start:function(){
            MM.get("/?d=FM&c=QuarterlyTask&a=SaleReward2PreDepositsIn","id="+id,function(q){
                $('.DCont')[0].innerHTML= q;
                
                new Reg.vf($('#J_backForm'),{callback:function(formData){
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    var postData = $("#J_backForm").serialize()+"&id="+id;
                    
                    _InDealWith = true;   
                    MM.ajax({
                        url:'/?d=FM&c=QuarterlyTask&a=SaleReward2PreDepositsInSubmit',
                        data:postData,
                        success:function(backData){
                            if(parseInt(backData) == 0){
                                pageList.reflash();
            				    _InDealWith = false;
            			         IM.dialog.hide();	
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

function DropAwardMoney(id)
{
    if(confirm("你确认要取消充值吗？"))
    {
        //数据已提交，正在处理标识
    	if (_InDealWith) 
    	{
    		IM.tip.warn("数据已提交，正在处理中！");
    		return false;
    	}
        
        _InDealWith = true;   
        var backData = $PostData("/?d=FM&c=QuarterlyTask&a=DelSaleReward2PreDeposits&id="+id,"");
        if(parseInt(backData) == 0){
            pageList.reflash();
	        IM.dialog.hide();
		    _InDealWith = false;	
            IM.tip.show("取消充值成功！");
		}else{
            _InDealWith = false;
            IM.tip.warn(backData);
		}
    }
}



</script>
{/literal} 