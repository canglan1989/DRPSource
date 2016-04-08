<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">客户名称：</div>
                <div class="ui_text"><input type="text" name="tbxCustomerName" id="tbxCustomerName" value="" style="width:180px;"/></div>	                         	        	
                <div class="ui_title">制定人：</div>
                <div class="ui_text"><input type="text" name="tbxCreateUserName" id="tbxCreateUserName" value="" style="width:100px;"/></div>	    
                <div class="ui_title">回访时间：</div>
                <div class="ui_text">
                    <input id="tbxSRevisitTime" type="text" class="inpCommon inpDate" name="tbxSRevisitTime" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxERevisitTime\')}'}){/literal}"/>
                    至
                    <input id="tbxERevisitTime" type="text" class="inpCommon inpDate" name="tbxERevisitTime" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSRevisitTime\')}'}){/literal}"/>	
                </div> 
                <div class="ui_title">战区经理：</div>
                <div class="ui_text"><input type="text" name="channeluser" id="channeluser" value="" style="width:100px;"/></div>	                

            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">回访状态：</div>
                <div class="ui_comboBox">
                    <select id="cbRevisitStatus" name="cbRevisitStatus">
                        <option value="-100">请选择</option>
                        <option value="1">已回访</option>
                        <option value="0">未回访</option>
                    </select>
                </div>
                <div class="ui_title">回访人：</div>
                <div class="ui_text"><input type="text" name="tbxRevisitUserName" id="tbxRevisitUserName" value="" style="width:100px;"/></div>	      
                <div class="ui_title">小记类型：</div>
                <div class="ui_comboBox">
                    <select id="cbIsVisit" name="cbIsVisit">
                        <option value="-100">请选择</option>
                        <option value="1" {$tp_sel1}>拜访小记</option>
                        <option value="0" {$tp_sel0}>联系小记</option>
                    </select>
                </div>
                <div class="ui_title">网盟意向等级：</div>
                {literal}
                    <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({'control':'IntentionRating',data:MM.A(this,'data')},this)" 
                    {/literal}
                    class="ui_comboBox ui_comboBox_def" key="{$rating_id}" value="{$rating_text}" control="IntentionRating" data="{$strIntentionRatingJson}" style="width:240px;">
                    <div class="ui_comboBox_text" style="width:220px;">
                        {if $rating_id != ""}
                            <nobr>{$rating_text}</nobr>
                        {else}
                            <nobr>全部</nobr>
                        {/if}
                    </div>
                    <div class="ui_icon ui_icon_comboBox"></div>                        
                </div>


            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input type="text" name="agentname" id="agentname" value="{$agentName}" style="width:100px;"/></div>	
                <div class="ui_title">是否有效联系：</div>
                <div class="ui_comboBox">
                    <select  name="IsVaildContact">
                        <option value="-100">全部</option>
                        <option value="1" {$tp_sel0}>是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="ui_title">拜访/联系时间：</div>
                <div class="ui_text">
                    <input id="ContactTimeBegin" type="text" class="inpCommon inpDate" name="ContactTimeBegin" value="{$contact_dateb}" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'ContactTimeEnd\')}'}){/literal}"/>
                    至
                    <input id="ContactTimeEnd" type="text" class="inpCommon inpDate" name="ContactTimeEnd" value="{$contact_datee}" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'ContactTimeBegin\')}'}){/literal}"/>	
                </div>  
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>                   
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>                    
        </div>
    </div>
</div>                        
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">客户ID</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
            <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">小记类型</div></div></th>
            <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">网盟意向等级</div></div></th>
            <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">被拜访/联系人</div></div></th>
            <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>
            <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">拜访/联系时间</div></div></th>
            <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">制定人</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">拜访/联系内容</div></div></th>  
            <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访状态</div></div></th>
            <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访人</div></div></th> 
            <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访时间</div></div></th> 
            <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">是否有效联系</div></div></th> 
            <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">所属战区经理</div></div></th> 
            <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">所属代理商</div></div></th> 
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
<div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
<script type="text/javascript">
    {literal}
$(function(){
    {/literal}
	pageList.strUrl="{$BodyUrl}"; 
    {literal}
	pageList.param = "&"+$('#tableFilterForm').serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
	pageList.init();
});

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.first();
} 
    
function GetRecordDetail(id)
{
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "小记明细",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=GetContactRecordDetail&id="+id, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
            
        });
      }
    });
}
    {/literal}
</script>