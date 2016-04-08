<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<div class="table_filter marginBottom10">  
    <form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
        <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
    <div class="ui_title">所属财务帐户：</div>
    <div class="ui_text">
        <select id="cbFinanceUser" name="cbFinanceUser"></select>
    </div> 
	<div class="ui_title">角色名称：</div>
        <div class="ui_text">
            <input style="width:150px" type="text" maxlength="32" style="vertical-align:top;" name="tRoleName" id="tRoleName"/>
        </div>
        <div class="ui_button ui_button_search">
            <button class="ui_button_inner" type="button" onclick="QueryData()">搜 索</button>
        </div>
    </div>
    </div>
</form>
</div>
  <!--E crumbs--> 
  <!--S list_link-->
<div class="list_link marginBottom10">
<a class="ui_button" onclick="AddRole()" href="javascript:;" m="RoleManager" v="4" ispurview="true" style="margin:0;">
<div class="ui_button_left"></div>
<div class="ui_button_inner">
<div class="ui_icon ui_icon_add"></div>
<div class="ui_text">添加角色</div>
</div>
</a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
<div class="list_table_head_right">
<div class="list_table_head_mid">
<h4 class="list_table_title">
<span class="ui_icon list_table_title_icon"></span>
{$strTitle}

</h4>
<a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
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
        <th style="width:150px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">角色名</div></div></th>
        <th style="width:90px"><div class="ui_table_thcntr"><div class="ui_table_thtext">财务功能角色</div></div></th>      
        <th style="width:150px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">所属财务帐户</div></div></th>
        <th><div class="ui_table_thcntr"><div class="ui_table_thtext">用户</div></div></th>
        <th style="width:100px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">添加人</div></div></th>
        <th style="width:140px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">添加日期</div></div></th>
        <th style="width:120px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>            
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
<div class="ui_pager" id="divPager"> </div>
</div>
<!--E list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    $FinanceUser.Bind("cbFinanceUser");
    {/literal}
	pageList.strUrl="{$ListBody}"; 
	{literal}
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
});

function AddRole(){
    {/literal} 
    var url = '{au d="System" c="Role" a="RoleModify"}';
    {literal} 
    JumpPage(url);
}
function DelRole(id)
{
    if(!confirm("您确定要删除吗？"))
        return ;
    {/literal} 
    var url = '{au d="System" c="Role" a="RoleDel"}';
    {literal} 
    url += "&id="+id;
    
    var retValue = $PostData(url,"id="+id);
    if(parseInt(retValue) == 0)
    {
        pageList.reflash();
    }
    else
    {
			IM.tip.warn(retValue); 
    }
}

function QueryData()
{
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.first();
}

</script>
{/literal} 