 <!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs--> 
  <!--S table_filter-->  
<div class="table_filter marginBottom10">  
    <form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
        <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
    <div class="ui_title">所属财务帐户：</div>
    <div class="ui_text">
        <select id="cbFinanceUser" name="cbFinanceUser"></select>
    </div> 
	<div class="ui_title">账号名称：</div>
        <div class="ui_text">
            <input style="width:150px" type="text" maxlength="32" style="vertical-align:top;" name="texAccountName" id="texAccountName"/>
            <input type="hidden" value="{$canToCRM}" id="tCanToCRM" name="tCanToCRM" />
        </div>
    <div class="ui_title">是否为财务账号：</div>
    <div class="ui_text">
        <select id="cbIsFinance" name="cbIsFinance">
        <option value="-100">请选择</option>
        <option value="0">否</option>
        <option value="1">是</option>
        </select>
    </div> 
        <div class="ui_button ui_button_search">
            <button class="ui_button_inner" type="button" onclick="QueryData()">搜 索</button>
        </div>
    </div>
    </div>
</form>
</div>
  <!--E table_filter--> 
  <!--S list_link-->
	<div class="list_link marginBottom10">
    <a class="ui_button" onclick="AddUser(0)" href="javascript:;" ispurview="true" v="4" m="AgentUserList"  style="">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
        <div class="ui_icon ui_icon_add"></div>
        <div class="ui_text">添加账号</div>
        </div>
    </a>
    <a class="ui_button" onclick="AddUser(1)" href="javascript:;" ispurview="true" v="4" m="AgentUserList"  style="">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
        <div class="ui_icon ui_icon_add"></div>
        <div class="ui_text">添加财务功能账号</div>
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
            <th><div class="ui_table_thcntr" sort="sort_user_name"><div class="ui_table_thtext" >账号名</div>
            <div class="ui_table_thsort"></div></div></th>
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">员工姓名 </div></div></th>
            <th style="width:50px"><div class="ui_table_thcntr"><div class="ui_table_thtext">状态</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">部门</div></div></th>
            <th style="width:90px"><div class="ui_table_thcntr"><div class="ui_table_thtext">财务功能帐户</div></div></th>      
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">所属财务帐户</div></div></th>
            <th style="width:70px"><div class="ui_table_thcntr"><div class="ui_table_thtext">账号层级</div></div></th>        
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">手机</div></div></th>        
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">电话</div></div></th>
            {if $canToCRM == 1}
            <th style="width:60px"><div class="ui_table_thcntr"><div class="ui_table_thtext">已同步到CRM</div></div></th>
            {/if}
	        <th style="width:80px"><div class="ui_table_thcntr"><div class="ui_table_thtext">添加日期</div></div></th>
            <th style="width:200px">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>               
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
    <div class="ui_pager" id="divPager"> </div>
  </div>  
  <!--E list_table_foot--> 
<!--E sidenav_neighbour--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    $FinanceUser.Bind("cbFinanceUser");
    {/literal}
	pageList.strUrl="{$agentUserListBody}"; 
	{literal}
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
});

function AddUser(isFinance)
{
    JumpPage("/?d=System&c=AgentUser&a=AgentUserModify&pno=0&isFinance=" + isFinance);
}

function QueryData()
{
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.first();
}

var _InDealWith = false;
function DelCRMUser(userID)
{
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    
    if(!confirm("你确定要删除CRM的用户吗？"))
        return false;
        
     var backData = $PostData("/?d=System&c=AgentUser&a=DelCRMAgentUser","userID="+userID);
    if(backData == 0)
    {
        _InDealWith = false;
        IM.tip.show("删除成功！");
        pageList.reflash();
    }
    else
    {
        IM.tip.warn(backData);
        _InDealWith = false;
    }              
}
</script>
{/literal} 