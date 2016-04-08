  <!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs--> 
  <!--S table_filter-->  
  <!--E table_filter--> 
  <div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
	<div id="J_table_filter_main" class="table_filter_main">
		<div class="table_filter_main_row"> 	
	        <div class="ui_title">代理商名称：</div>
	        <div class="ui_text"><input name="tbxAgentName" type="text" id="tbxAgentName" size="10" style="width:180px;" maxlength="30" /></div>        
	        <div class="ui_title">账号名：</div>
	        <div class="ui_text"><input name="tbxUserName" type="text" id="tbxUserName" size="10" style="width:140px;" maxlength="10" /></div>
	        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" id="searchAgent" name="searchAgent" onclick="QueryData()">搜 索</button></div>
		</div>
	</div>
    </form>
  </div>
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
    <div id="J_ui_table" class="ui_table">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead class="ui_table_hd">
          <tr>
            <th style="width:90px"><div sort="sort_agent_no"  class="ui_table_thcntr"><div class="ui_table_thtext" >代理商代码</div></div></th>
            <th><div class="ui_table_thcntr" sort="sort_agent_name"><div class="ui_table_thtext">代理商名称</div></div></th> 
            <th><div class="ui_table_thcntr" sort="sort_agent_name"><div class="ui_table_thtext">代理产品</div></div></th> 
            <th><div class="ui_table_thcntr" sort="sort_agent_name"><div class="ui_table_thtext">账号有效期</div></div></th> 
            <th style="width:100px"><div class="ui_table_thcntr" sort="sort_user_name"><div class="ui_table_thtext">账号名</div></div></th>   
            <th style="width:100px"><div class="ui_table_thcntr" sort="sort_e_name"><div class="ui_table_thtext">联系人</div></div></th>           
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">手机</div></div></th>          
            <th style="width:110px"><div class="ui_table_thcntr"><div class="ui_table_thtext">电话</div></div></th>
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">状态 </div></div></th>             
            <th style="width:90px"><div class="ui_table_thcntr" sort="sort_create_time"><div class="ui_table_thtext">创建时间</div></div></th>        
            <th style="width:160px">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>               
              </div>
            </th>            
          </tr>
        </thead>
        <tbody class="ui_table_bd" id="pageListContent"></tbody>
      </table>
    </div>
    
    <!--E ui_table--> 
  </div>
  <!--E list_table_main-->  
  <div class="list_table_foot">
    <div class="ui_pager" id="divPager"> </div>
  </div>  
  <!--E list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script language="javascript" type="text/javascript">

$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$strUrl}"; 
	{literal}
	pageList.param = "&tbxUserName="+encodeURIComponent($("#tbxUserName").val())+"&tbxAgentName="+encodeURIComponent($("#tbxAgentName").val());
	pageList.init();
});


function QueryData()
{
	pageList.param = "&tbxUserName="+encodeURIComponent($("#tbxUserName").val())+"&tbxAgentName="+encodeURIComponent($("#tbxAgentName").val());
	pageList.first();
}
</script>
{/literal} 
