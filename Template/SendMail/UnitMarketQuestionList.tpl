<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
           <div class="ui_title">代理商名称：</div>
           <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:200px;"/></div>
                   
        <div class="ui_title">发送时间：</div>
        <div class="ui_text">
            <input id="tbxSSendDate" type="text" class="inpCommon inpDate" name="tbxSSendDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxESendDate\')}'}){/literal}"/>
            至
            <input id="tbxESendDate" type="text" class="inpCommon inpDate" name="tbxESendDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSSendDate\')}'}){/literal}"/>	
        </div>
        <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
		</div>
    </div>
    </form>
</div>
<!--E table_filter-->
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
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商名称</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">发送邮箱</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">收件邮箱</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">发送时间</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">发送结果</div></div></th>                  
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
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
<script language="javascript" type="text/javascript">
$(function(){    
        {/literal}  
	pageList.strUrl = "{$UnitMarketQuestionListBody}"; 
	{literal}
                
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