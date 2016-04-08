 <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs-->
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
    	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
        <div id="J_table_filter_main" class="table_filter_main">
        <div class="table_filter_main_row">
            <div class="ui_title">区域名称：</div>
            <div class="ui_text"><input id="tbxAreaName" type="text" name="tbxAreaName" style="width:250px;" value="" maxlength="20" /></div>               
            <div class="ui_button ui_button_search">
            <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
            </div>
            <!--
            <div class="ui_button"><span class="ui_button_left"></span>
              <button type="button" class="ui_button_inner" onclick="$Reset('J_table_filter_main')">重 置</button>
            </div>
            -->
        </div>
        </div>
        </form>
    </div>
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
    	<a class="ui_button" onclick="JumpPage('/?d=System&c=AreaSet&a=GroupModify')" href="javascript:;" m="AreaGroupList" ispurview="true" v="4" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">新增区域</div></div></a>
    </div>     
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
                    	<th style="width:200px;" title="区域名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">区域名称</div>
                            </div>
                        </th>
                        <th style="" title="区域范围">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">区域范围</div>
                            </div>
                        </th>
                        <th style="width:150px;" title="操作">
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
    <!--S list_table_foot-->
  <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
    </div>
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$groupListBody}"; 
	{literal}
    var tbxAreaName = $('#tbxAreaName').val();
    if(tbxAreaName == "请输入区域名称搜索")
        tbxAreaName = "";
        
    tbxAreaName = encodeURIComponent(tbxAreaName);
	pageList.param = "&tbxAreaName="+tbxAreaName;
	pageList.init();
});

function QueryData()
{
    var tbxAreaName = $('#tbxAreaName').val();
    if(tbxAreaName == "请输入区域名称搜索")
        tbxAreaName = "";        
    tbxAreaName = encodeURIComponent(tbxAreaName);
	pageList.param = "&tbxAreaName="+tbxAreaName;
	pageList.first();
}

</script>
{/literal} 