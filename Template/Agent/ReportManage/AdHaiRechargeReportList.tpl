<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：报表管理<span>&gt;</span>网盟订单内容</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">  
                <div class="ui_title">转款日期：</div>
                <div class="ui_text"><input type="text" value="{$BeginTime}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('create_timeE')).focus()},maxDate:'#F{$dp.$D(\'create_timeE\')}',dateFmt:'MM-dd'}{/literal})" name="create_timeS" id="create_timeS" class="inpCommon inpDate"> 
                     至 
                    <input type="text" value="{$EndTime}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'create_timeS\')}',dateFmt:'MM-dd'}{/literal})" name="create_timeE" id="create_timeE" class="inpCommon inpDate">
                    <input type="hidden" name="opertype" value="{$oprtype}" />
                    <input type="hidden" name="agent_id" value="{$AgentID}" /></div>                  
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
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$AgentName}{$Operate}网盟订单内容</h4>
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
                    <th title="客户名称">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">客户名称</div>
                        </div>
                    </th>
                    <th width="150" title="网盟账号名称">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">网盟账号名称</div>
                        </div>
                    </th>
            <th  width="150" title="订单添加时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">订单添加时间</div>
            </div>
            </th>
            <th width="80" title="转款金额">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">转款金额</div>
            </div>
            </th>
            <th width="150" title="转款操作人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">转款操作人</div>
            </div>
            </th>
            <th width="150"  title="转款操作时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">转款操作时间</div>
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
<div class="list_table_foot">
    <div id="divPager" class="ui_pager">

    </div>
</div>	
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
<script type="text/javascript">
    {literal}
$(function(){    
    {/literal}
	pageList.strUrl = "{$BodyUrl}"; 
    {literal}
        
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init(); 
    
}); 

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
    {/literal}
</script>
