  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>拜访预约审查</div>
    <!--S table_filter-->
   <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                    <div class="table_filter_main_row">
                        <div class="ui_title">制定人：</div>
                        <div class="ui_text">
                        <input id="create_name" class="agent_name" type="text" name="create_name" value="{$countname}" style="vertical-align:top;"/>
                        </div>
                        <div class="ui_title">预约制定时间：</div>
						<div class="ui_text">
						 <input id="J_editTimeS" class="inpDate" name="create_timeb" value="{$counttimeb}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE')).focus()},dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}" type="text"/> 至
                           <input id="J_editTimeE" class="inpDate" name="create_timee" value="{$counttimee}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}',dateFmt:'yyyy-MM-dd HH:mm:ss'}{/literal})" type="text"/>	
                            <input type="hidden" id="countname" name="countname" value="{$countname}" />
                            <input type="hidden" id="counttimeb" name="counttimeb" value="{$counttimeb}" />
                            <input type="hidden" id="counttimee" name="counttimee" value="{$counttimee}" />
                        </div>              
                        <div class="ui_title">代理商：</div>
                        <div class="ui_text">
                        <input id="agent_name" class="agent_name" type="text" name="agent_name" style="vertical-align:top;"/>
                        </div>
                    </div>
                    <div class="table_filter_main_row">	
                        <div class="ui_title">是否生成小记：</div>
                        <div class="ui_text">
                            <select id="haveNote" name="haveNote">
                                    <option value="-100" selected="selected">===请选择====</option>
                                    <option value="1">是</option>
                                    <option value="0">否</option>
                                </select>
                        </div>
                        {if $countname == ""}
                        <div class="ui_title">审查状态：</div>
                            <div class="ui_comboBox">
                                <select id="auditState" name="auditState">
                                    <option value="-100" selected="selected">全部</option>
                                    <option value="0">未审查</option>
                                    <option value="1">审查通过</option>
                                    <option value="2">审查不通过</option>
                                </select>
                        </div>
                        {/if}
                     <div class="ui_title">被访人：</div>
						<div class="ui_comboBox">
							<input id="contact_name" class="inpCommon" type="text" name="contact_name" style="vertical-align:top;"/>
						</div>
                        <div class="ui_title">编号：</div>
                        <div class="ui_comboBox">
							<input id="appoint_id" class="inpCommon" type="text" name="appoint_id" style="vertical-align:top;"/>
						</div>
                        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="searchAppoint()">查询</button></div>
                        {if $countname != ""}
                        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="JumpPage('/?d=WorkM&c=VisitCount&a=VisitCountList')">返回</button></div>	                                                                
                        {/if}
                     </div>
                </form>
            </div>
            </div>
    <!--E table_filter-->
    <!--S list_link-->
   {if $countname == ""}  
   <div class="list_link marginBottom10">
   <a class="ui_button" onclick="ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
    </a>
    </div>
    {/if}
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
                    	<th width="50" title="编号">
                        	<div class="ui_table_thcntr" sort="sort_appoint_id">
                            	<div class="ui_table_thtext">编号</div>
                            </div>
                        </th>
                        <th width="" title="制定人">
                        	<div class="ui_table_thcntr" sort="sort_e_name">
                            	<div class="ui_table_thtext">制定人</div>
                            </div>
                        </th>
                        <th width="" title="制定时间" sort="sort_create_time">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">制定时间</div>
                            </div>
                        </th>
                        <th title="代理商">
                        	<div class="ui_table_thcntr" sort="sort_e_name">
                            	<div class="ui_table_thtext">代理商</div>
                            </div>
                        </th>
                        <th title="拜访主题">
                        	<div class="ui_table_thcntr" sort="sort_title">
                            	<div class="ui_table_thtext">拜访主题</div>
                            </div>
                        </th>
                        <th title="意向评级/签约产品">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">意向评级/签约产品</div>
                            </div>
                        </th>
                        <th title="被访人">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">被访人</div>
                            </div>
                        </th>
                        <th title="联系电话">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">联系电话</div>
                            </div>
                        </th>
                        <th title="预约时间">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">预约时间</div>
                            </div>
                        </th>
                        <th title="是否生成小记">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">是否生成小记</div>
                            </div>
                        </th>
                        <th title="审查状态">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">审查状态</div>
                            </div>
                        </th>
                        <th width="100"  title="操作">
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
    <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
  </div>         
    <!--S list_table_foot-->
    <script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$AppCheckListBody}"; 
    pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！   
	{literal}
	pageList.init();
});
function searchAppoint()
{
    pageList.page = 1;
	pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！      
	pageList.first();
}
function ExportExcel()
{
    var formdata = $('#tableFilterForm').serialize();
    window.open("/?d=WorkM&c=VisitAppoint&a=ExcelExportVisitAppointList&is_all=1&"+formdata);
}

    </script>
{/literal}