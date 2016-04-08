<?php /* Smarty version 2.6.26, created on 2012-12-10 09:53:48
         compiled from CM/EstimateRpt.tpl */ ?>
<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>报表管理<span>&gt;</span>网盟预计到账统计</div>
        <!--E crumbs-->
        <div class="table_attention marginBottom10">
                <label>总计：</label>
                <span class="ui_link">预计到账总额：(<em><label id="income_total"></label></em>)</span>
                <span class="ui_link">预计到账总量：(<em><label id="order_num"></label></em>)</span>
                <span class="ui_link">实际转款总额：(<em><label id="charge_total"></label></em>)</span>
                <span class="ui_link">实际转款次数：(<em><label id="charge_num"></label></em>)</span>
        </div>
        <!--S table_filter-->
        <div class="table_filter marginBottom10">
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row">
                    <div class="ui_title">统计时间段：</div>
					<div class="ui_text"  id = "createTime">
            	            <select  name="rep_date" id="rep_date" >
                                <option value="1" >当前月</option>
                                <option value="2" >下个月</option>
                                <option value="3" >连续三个月</option>
                            </select>
					</div>
                    <div class="ui_title">代理商名称：</div>
					<div class="ui_text"><input type="text" class="inpCommon" id = "agent_name" name="agent_name"/></div>
                    <div class="ui_title">所属战区经理：</div>
					<div class="ui_text"><input type="text" class="inpCommon" id = "channel_user_name" name="channel_user_name"/></div>
                    
                    
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
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>预计到账统计列表</h4>
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
                                	
                                	<th style="width:100px;" title="代理商ID">
                                    	<div class="ui_table_thcntr" sort="sort_agent_id">
                                        	<div class="ui_table_thtext">代理商ID</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="" title="代理商名称">
                                    	<div class="ui_table_thcntr" sort="sort_agent_name">
                                        	<div class="ui_table_thtext">代理商名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:120px;" title="所属战区经理">
                                    	<div class="ui_table_thcntr" sort="sort_channel_uid">
                                        	<div class="ui_table_thtext">所属战区经理</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   
                                    <th style="width:120px;" title="预计到账总额">
                                    	<div class="ui_table_thcntr" sort="sort_income_money" >
                                        	<div class="ui_table_thtext">预计到账总额</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:120px;" title="预计到账总量">
                                    	<div class="ui_table_thcntr" sort="sort_order_count">
                                        	<div class="ui_table_thtext">预计到账总量</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:120px;" title="实际转款总额">
                                    	<div class="ui_table_thcntr" sort="sort_charge_money">
                                        	<div class="ui_table_thtext">实际转款总额</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:120px;" title="实际转款次数">
                                    	<div class="ui_table_thcntr" sort="sort_charge_count">
                                        	<div class="ui_table_thtext">实际转款次数</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:80px;" title="操作">
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
            <script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
	<script type="text/javascript">
	<?php echo '
	$(function(){
        '; ?>

    	pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
";
    	<?php echo '
    	pageList.param = "&"+$(\'#tableFilterForm\').serialize();
    	pageList.init();
        GetTotal();
	});
     function QueryData()
     {
    	pageList.param = \'&\'+$("#tableFilterForm").serialize();
    	pageList.first();
        GetTotal();
     }
     function GetTotal()
     {
        var data = $PostData("/?d=CM&c=CMReport&a=getEstimateTotalNum"+pageList.param);
        $("#income_total").html(data.split("|")[0]);
        $("#order_num").html(data.split("|")[1]);
        $("#charge_total").html(data.split("|")[2]);
        $("#charge_num").html(data.split("|")[3]);
        
        
     }
     function ShowDetail(agent_id)
     {
        JumpPage(\'/?d=CM&c=CMReport&a=showEstimateFroRpt&agent_id=\'+agent_id+\'&bdate=\'+$("#rep_date").val());
     }
     
     
     function ExportExcel()
     {
        window.open("/?d=CM&c=CMReport&a=excelExportEstimateRpt" + pageList.param + "&sortField=" + pageList.sortField);
     }
	'; ?>

	</script>