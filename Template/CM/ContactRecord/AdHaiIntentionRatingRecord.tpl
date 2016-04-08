<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
    	<div class="table_filter_main_row">
            <div class="ui_title">客户名称：</div>
            <div class="ui_text">
                <input type="text" name="customer_name" style="vertical-align:top;width:200px"/>
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
            <div class="ui_title">添加人：</div>
            <div class="ui_comboBox">
            <select onchange="UserLevelChange(this)" id="cbUserLevel" name="cbUserLevel">
                <option value="-100">全部</option>
                <option value="1">自己</option>
                <option value="2">下级</option>
            </select>
            </div>
            <div id="divUserName" class="ui_text">
                <input class="inpCommon" type="text" name="create_user" value="{$user_name}" style="vertical-align:top;"/>
            </div>
            
        </div>
        <div class="table_filter_main_row">    
            <div class="ui_title">添加时间：</div>
            <div class="ui_text">
                 <input id="create_time_begin" type="text" class="inpCommon inpDate" name="create_time_begin" value="{$create_dateb}" 
                 {literal}
                 onfocus="WdatePicker({onpicked:function(){($dp.$('create_time_end')).focus()},maxDate:'#F{$dp.$D(\'create_time_end\')}'})"/> 至
    	         {/literal}
                 <input id="create_time_end" type="text" class="inpCommon inpDate" name="create_time_end" value="{$create_datee}" 
                 {literal}
                 onfocus="WdatePicker({minDate:'#F{$dp.$D(\'create_time_begin\')}'})"/>
                 {/literal}
            </div>
           <div class="ui_title">预计到账：</div>
            <div class="ui_text">
                 <input id="income_time_begin" type="text" class="inpCommon inpDate" name="income_time_begin" value="{$income_dateb}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('income_time_end')).focus()},maxDate:'#F{$dp.$D(\'income_time_end\')}'}{/literal})"/> 至
    	         <input id="income_time_end" type="text" class="inpCommon inpDate" name="income_time_end" value="{$income_datee}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'income_time_begin\')}'})"/>{/literal}
            </div>           
           <div class="ui_title">联系类型：</div>
            <div class="ui_text">
                <select name="is_visit" >
                    <option value = "-1">全部</option>
                    <option value = "0">联系小记</option>
                    <option value = "1">拜访小记</option>
                </select>
            </div>
            <div class="ui_text">
            <label>
            <input class="checkInp" type="checkbox" style="vertical-align: middle;" value="1" name="chkLastIntention" id="chkLastIntention"/>
            最近一次意向
            </label>
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
            <th style="width:70px" title="客户ID">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户ID</div>
            </div>
            </th>
            <th style="" title="客户名称">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户名称</div>
            </div>
            </th>
            <th style="" title="联系类型">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系类型</div>
            </div>
            </th>
            <th style="width:250;" title="网盟意向等级">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">网盟意向等级</div>
            </div>
            </th>
            <th class="TA_r" style="width:100px;" title="预计到账金额">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">预计到账金额</div>
            </div>
            </th>

            <th style="width:150px;" title="预计到账时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">预计到账时间</div>
            </div>
            </th>

            <th style="width:150px;" title="添加人">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">添加人</div>
            </div>
            </th>
            <th style="width:150px;" title="添加时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">添加时间</div>
            </div>
            </th>
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
{/literal}
</script>