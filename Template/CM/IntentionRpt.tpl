<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>报表管理<span>&gt;</span>网盟意向等级统计</div>
        <!--E crumbs-->
        <div class="table_attention marginBottom10">
                <label>总计：</label>
                <span class="ui_link">A+：(<em><label id="rpt_item1"></label></em>)</span>
                <span class="ui_link">A-：(<em><label id="rpt_item2"></label></em>)</span>
                <span class="ui_link">B+：(<em><label id="rpt_item3"></label></em>)</span>
                <span class="ui_link">B-：(<em><label id="rpt_item4"></label></em>)</span>
                <span class="ui_link">C：(<em><label id="rpt_item5"></label></em>)</span>
                <span class="ui_link">D：(<em><label id="rpt_item6"></label></em>)</span>
                <span class="ui_link">E：(<em><label id="rpt_item7"></label></em>)</span>
        </div>
        <!--S table_filter-->
        <div class="table_filter marginBottom10">
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row">
                    <div class="ui_title">代理商名称：</div>
					<div class="ui_text"><input type="text" class="inpCommon" id = "agent_name" name="agent_name"/></div>
                    <div class="ui_title">所属战区经理：</div>
					<div class="ui_text"><input type="text" class="inpCommon" id = "channel_user_name" name="channel_user_name"/></div>
                    <div class="ui_title">统计日期：</div>
					<div class="ui_text"  id = "createTime">
            	            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="rep_date" value="{$rep_date}" onClick="WdatePicker({literal}{isShowClear:false}){/literal}"/> 
					</div>
                    
                    <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
                </div>
                
            </div>
            </form>
        </div>
        <!--E table_filter-->
        <!--S list_link-->
        <div class="list_link marginBottom10">
            <a  class="ui_button" onclick="pageList.ExportExcel();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">EXCEL下载</div></div></a>
        </div>
        <!--E list_link-->
        <!--S list_table_head-->
        <div class="list_table_head">
            <div class="list_table_head_right">
                <div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>网盟意向等级统计列表</h4>
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
                                	
                                	<th width="100"  title="代理商ID">
                                    	<div class="ui_table_thcntr" sort="sort_agent_id">
                                        	<div class="ui_table_thtext">代理商ID</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th width="120" title="代理商名称">
                                    	<div class="ui_table_thcntr" sort="sort_agent_name">
                                        	<div class="ui_table_thtext">代理商名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th width="120" title="所属战区经理">
                                    	<div class="ui_table_thcntr" sort="sort_channel_uid">
                                        	<div class="ui_table_thtext">所属战区经理</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th  title="A+">
                                    	<div class="ui_table_thcntr" sort="sort_rating_1">
                                        	<div class="ui_table_thtext">A+</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th  title="A-">
                                    	<div class="ui_table_thcntr" sort="sort_rating_2">
                                        	<div class="ui_table_thtext">A-</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="B+">
                                    	<div class="ui_table_thcntr" sort="sort_rating_3" >
                                        	<div class="ui_table_thtext">B+</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="B-">
                                    	<div class="ui_table_thcntr" sort="sort_rating_4" >
                                        	<div class="ui_table_thtext">B-</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="C">
                                    	<div class="ui_table_thcntr" sort="sort_rating_5" >
                                        	<div class="ui_table_thtext">C</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="D">
                                    	<div class="ui_table_thcntr" sort="sort_rating_6" >
                                        	<div class="ui_table_thtext">D</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="E">
                                    	<div class="ui_table_thcntr" sort="sort_rating_7" >
                                        	<div class="ui_table_thtext">E</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="预计到账金额">
                                    	<div class="ui_table_thcntr" sort="sort_income_money" >
                                        	<div class="ui_table_thtext">预计到账金额</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th title="预计到账单量">
                                    	<div class="ui_table_thcntr" sort="sort_order_count">
                                        	<div class="ui_table_thtext">预计到账单量</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="转款金额">
                                    	<div class="ui_table_thcntr" sort="sort_charge_money">
                                        	<div class="ui_table_thtext">转款金额</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="转款次数">
                                    	<div class="ui_table_thcntr" sort="sort_charge_count">
                                        	<div class="ui_table_thtext">转款次数</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="操作">
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
		<div id="divPager" class="ui_pager"></div>
	</div>
	<!--E list_table_foot-->
            <script type="text/javascript" src="{$JS}pageCommon.js"></script>
	<script type="text/javascript">
	{literal}
	$(function(){
        {/literal}
    	pageList.strUrl="{$strUrl}";
    	{literal}
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
        GetTotal();
	});
     function QueryData()
     {
    	pageList.param = '&'+$("#tableFilterForm").serialize();
    	pageList.first();
        GetTotal();
     }
     function GetTotal()
     {
        var data = $PostData("/?d=CM&c=CMReport&a=getIntentionTotalNum"+pageList.param);
        $("#rpt_item1").html(data.split("|")[0]);
        $("#rpt_item2").html(data.split("|")[1]);
        $("#rpt_item3").html(data.split("|")[2]);
        $("#rpt_item4").html(data.split("|")[3]);
        $("#rpt_item5").html(data.split("|")[4]);
        $("#rpt_item6").html(data.split("|")[5]);
        $("#rpt_item7").html(data.split("|")[6]);
        
        
     }
     function ShowDetail(agent_id)
     {
        JumpPage('/?d=CM&c=CMReport&a=showIntentionFroRpt&agent_id='+agent_id+'&bdate='+$("#J_editTimeS").val());
     }
     function ShowValidDetail(agent_id,rating_id)
     {
        JumpPage('/?d=CM&c=ContactRecord&a=AgentContactRecordList&agent_id='+agent_id+'&rating_id='+rating_id+'&bdate='+$("#J_editTimeS").val()+'&edate='+$("#J_editTimeS").val());
     }
     
     function ExportExcel()
     {
        window.open("/?d=CM&c=CMReport&a=excelExportIntentionRpt" + pageList.param + "&sortField=" + pageList.sortField);
     }
	{/literal}
	</script>