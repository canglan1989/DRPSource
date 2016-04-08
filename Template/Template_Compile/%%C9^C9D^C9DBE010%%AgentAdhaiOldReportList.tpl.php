<?php /* Smarty version 2.6.26, created on 2012-11-21 14:42:40
         compiled from Agent/ReportManage/AgentAdhaiOldReportList.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->   
<div class="table_attention marginBottom10">
    <label>统计信息：</label>
    <span class="ui_link">累计新开：(<em><?php echo $this->_tpl_vars['NewCount']; ?>
</em>)</span>
    <span class="ui_link">累计新开金额：(<em><?php echo $this->_tpl_vars['NewMoney']; ?>
</em>)</span>
    <span class="ui_link">累计续费：(<em><?php echo $this->_tpl_vars['OldCount']; ?>
</em>)</span>
    <span class="ui_link">累计续费金额：(<em><?php echo $this->_tpl_vars['OldMoney']; ?>
</em>)</span>
</div> 
<!--S table_filter-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">统计月份：</div>
                <div class="ui_text"><input type="text" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'create_timeE\')).focus()},maxDate:\'#F{$dp.$D(\\\'create_timeE\\\')}\',dateFmt:\'yyyy-MM\'}'; ?>
)" name="create_timeS" id="create_timeS" class="inpCommon inpDate"> 
                    至 
                    <input type="text" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'create_timeS\\\')}\',dateFmt:\'yyyy-MM\'}'; ?>
)" name="create_timeE" id="create_timeE" class="inpCommon inpDate"></div>   
                <div class="ui_title">代理商名称：</div>                    
                <div class="ui_text"><input id="agent_name" class="companyName" type="text" name="agent_name"/></div>
                <div class="ui_title">战区经理：</div>                    
                <div class="ui_text"><input id="channel_name" class="inpCommon" type="text" name="channel_name"/></div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a href="javascript:;" onclick="ExportExcel()" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
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
                    <th width="100" title="区域">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">区域</div>
            </div>
            </th>
            <th width="135" title="战区经理">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">战区经理</div>
            </div>
            </th>
            <th title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商名称</div>
            </div>
            </th>
            
            <th width="75" title="起始时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">起始时间</div>
            </div>
            </th>
            <th width="75" title="结束时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">结束时间</div>
            </div>
            </th>
           
            <th width="80" title="累计新开" sort="sort_`mn`.`month_new_count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">累计新开</div>
                <div class="ui_table_thsort"  ></div>
            </div>
            </th>
            <th width="100" title="累计新开金额" sort="sort_`mn`.`month_new_money`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">累计新开金额</div>
                <div class="ui_table_thsort"  ></div>
            </div>
            </th>
            <th width="80" title="累计续费"  sort="sort_`mo`.`month_old_count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">累计续费</div>
                <div class="ui_table_thsort"  ></div>
            </div>
            </th>
            <th width="100" title="累计续费金额"  sort="sort_`mo`.`month_old_money`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">累计续费金额</div>
                <div class="ui_table_thsort" ></div>
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
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<script type="text/javascript">
    <?php echo '
$(function(){    
    '; ?>

	pageList.strUrl = "<?php echo $this->_tpl_vars['BodyUrl']; ?>
"; 
    <?php echo '
        
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.init(); 
    
}); 

function QueryData()
{
    pageList.param = \'&\'+$("#tableFilterForm").serialize();
    pageList.first();
}
    
        function ExportExcel()
{
    window.open("/?d=Agent&c=ReportManage&a=DownLoad_AgentAdhaiOldReportBody" + pageList.param + "&sortField=" + pageList.sortField);
}
    
function showMoneyDialog(agentid,begintime,endtime,type){        
        IM.dialog.show({
        width: 500,
        height: null,
        title: \'金额详细\',
        html: IM.STATIC.LOADING,
        start: function () {
            $(\'.DCont\').html($PostData("/?d=Agent&c=ReportManage&a=MoneyDetail&agentid=" + agentid +"&begintime="+begintime+"&endtime="+endtime+"&type="+type, ""));
        }
    });
}

    '; ?>

</script>