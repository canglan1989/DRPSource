<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:53
         compiled from CM/ContactRecordFroRpt.tpl */ ?>
<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>报表管理<span>&gt;</span>联系量统计</div>
        <!--E crumbs-->
        <div class="table_attention marginBottom10">
            <label>温馨提示：</label><span class="ui_link">没有联系小记或者拜访小记的账号不进行统计。统计时间为联系时间</span><br />
                <label>总计：</label>
                <span class="ui_link">有效联系量：(<em><label id="valid_num"></label></em>)</span>
                <span class="ui_link">无效联系量：(<em><label id="invalid_num"></label></em>)</span>
                <span class="ui_link">总联系量：(<em><label id="total_num"></label></em>)</span>
                <span class="ui_link">平均有效联系占比：(<em><label id="avg_rate"></label></em>)</span>
                <span class="ui_link">拜访量：(<em><label id="visit_num"></label></em>)</span>
        </div>
        <!--S table_filter-->
        <div class="table_filter marginBottom10">
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row">
                    <input type="hidden" id = "agent_id" name="agent_id" value="<?php echo $this->_tpl_vars['agent_id']; ?>
"/>
					<div class="ui_title">统计时间段：</div>
					<div class="ui_text"  id = "createTime">
            	            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="rep_date_begin" value="<?php echo $this->_tpl_vars['rep_dateb']; ?>
" onClick="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'})'; ?>
"/> 至
            	            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="rep_date_end" value="<?php echo $this->_tpl_vars['rep_datee']; ?>
" onClick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\'})'; ?>
"/>
					</div>
                    <div class="ui_title">客户经理：</div>
					<div class="ui_text"><input type="text" class="inpCommon" id = "user_name" name="user_name"/></div>
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
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>联系量统计列表</h4>
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
                                    <th style="width:110px;" title="客户经理">
                                    	<div class="ui_table_thcntr" sort="sort_user_id">
                                        	<div class="ui_table_thtext">客户经理</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:100px;" title="有效联系量">
                                    	<div class="ui_table_thcntr" sort="sort_valid_count">
                                        	<div class="ui_table_thtext">有效联系量</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:100px;" title="无效联系量">
                                    	<div class="ui_table_thcntr" sort="sort_invalid_count">
                                        	<div class="ui_table_thtext">无效联系量</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:100px;" title="总联系量">
                                    	<div class="ui_table_thcntr" sort="sort_record_count" >
                                        	<div class="ui_table_thtext">总联系量</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:130px;" title="平均有效联系占比">
                                    	<div class="ui_table_thcntr" sort="sort_valid_rate" >
                                        	<div class="ui_table_thtext">平均有效联系占比</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:100px;" title="拜访量">
                                    	<div class="ui_table_thcntr" sort="sort_visit_count">
                                        	<div class="ui_table_thtext">拜访量</div><div class="ui_table_thsort"></div>
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
        var data = $PostData("/?d=CM&c=CMReport&a=getFroTotalNum"+pageList.param);
        $("#valid_num").html(data.split("|")[0]);
        $("#invalid_num").html(data.split("|")[1]);
        $("#total_num").html(data.split("|")[2]);
        $("#avg_rate").html(data.split("|")[3]);
        $("#visit_num").html(data.split("|")[4]);
        
        
     }
    
     function ShowValidDetail(user_id,tp)
     {
             JumpPage(\'/?d=CM&c=ContactRecord&a=ContactRecordList&tp=\'+tp+\'&user_id=\'+user_id+\'&bdate=\'+$("#J_editTimeS").val()+\'&edate=\'+$("#J_editTimeE").val());        
     }
     function ShowVisitDetail(user_id)
     {
        JumpPage(\'/?d=CM&c=ContactRecord&a=RevisitList&user_id=\'+user_id+\'&bdate=\'+$("#J_editTimeS").val()+\'&edate=\'+$("#J_editTimeE").val());
     }
     
     
     function ExportExcel()
     {
        window.open("/?d=CM&c=CMReport&a=excelExportContactRecordFroRpt" + pageList.param + "&sortField=" + pageList.sortField);
     }
	'; ?>

	</script>