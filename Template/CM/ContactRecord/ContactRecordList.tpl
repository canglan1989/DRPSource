<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<div class="table_filter marginBottom10">  
	<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">客户ID：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerID" id="tbxCustomerID" value="{$CustomerID}" style="width:60px;" /></div>                         	        	

        	<div class="ui_title">客户名称：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerName" id="tbxCustomerName" value="{$CustomerName}" style="width:200px;"/></div>	                         	        	

            <div class="ui_title">网盟意向等级：</div>
                {literal}
                    <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({'control':'IntentionRating',data:MM.A(this,'data')},this)" 
                    {/literal}
                    class="ui_comboBox ui_comboBox_def" key="{$rating_id}" value="{$rating_text}" control="IntentionRating" data="{$strIntentionRatingJson}" style="width:100px;">
                    <div class="ui_comboBox_text" style="width:80px;">
                        {if $rating_id != ""}
                            <nobr>{$rating_text}</nobr>
                        {else}
                            <nobr>全部</nobr>
                        {/if}
                    </div>
                    <div class="ui_icon ui_icon_comboBox"></div>                        
                </div>
            <div class="ui_title">联系时间：</div>
            <div class="ui_text">
                <input id="tbxSContactTime" type="text" class="inpCommon inpDate" name="tbxSContactTime" value="{$bdate}" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxEContactTime\')}'}){/literal}"/>
                至
                <input id="tbxEContactTime" type="text" class="inpCommon inpDate" name="tbxEContactTime"  value="{$edate}" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSContactTime\')}'}){/literal}"/>	
            </div> 
        </div>
	   <div class="table_filter_main_row">	
            <div class="ui_title">联系人：</div>
            <div class="ui_comboBox">
            <select onchange="UserLevelChange(this)" id="cbUserLevel" name="cbUserLevel">
                <option value="-100">全部</option>
                <option value="1">自己</option>
                <option value="2">下级</option>
            </select>
            </div>
            <div id="divUserName" class="ui_text"><input type="text" name="CreateName" class="inpCommon" value="{$CreateUserName}" /></div>
            <div class="ui_title">有效联系：</div>
            <div class="ui_comboBox">
                <select id="cbIsvalidContact" name="cbIsvalidContact">
                <option value="-100" {if $IsVaileContact == "3"}selected{/if}>请选择</option>
                <option value="0" {if $IsVaileContact == "1"}selected{/if}>是</option>
                <option value="1" {if $IsVaileContact == "2"}selected{/if}>否</option>
                </select>
            </div>
            <div class="ui_title">回访状态：</div>
            <div class="ui_comboBox">
                <select id="cbRevisitStatus" name="cbRevisitStatus">
                <option value="-100">请选择</option>
                <option value="1">已回访</option>
                <option value="0">未回访</option>
                </select>
            </div>
            	                         	        	
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
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
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">客户ID</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">网盟意向等级</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系人</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">被联系人</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系手机</div></div></th>
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">有效联系</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">联系内容</div></div></th>  
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系时间</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访状态</div></div></th> 
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
	pageList.strUrl = "{$ContactRecordListBody}"; 
	{literal}    
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
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

function UserLevelChange(obj)
{
    if(parseInt(obj.value)!=1)
    {
        $("#divUserName").show();
    }
    else
    {
        $("#divUserName").hide();
    }
}
</script>
{/literal}