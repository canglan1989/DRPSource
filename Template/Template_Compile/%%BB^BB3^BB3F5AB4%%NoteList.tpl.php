<?php /* Smarty version 2.6.26, created on 2012-11-22 09:54:44
         compiled from Agent/WorkManagement/NoteList.tpl */ ?>
  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
    <!--S table_filter-->
            <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                    <div class="table_filter_main_row">
                        <div class="ui_title">制定人：</div>
                            <div class="ui_comboBox">
                                <select id="cre_people" name="cre_people" onchange="showLow()">
                                <option value="-100">全部</option>
                                <option value="0" selected="selected">自己</option>
                                <option value="1">下属</option>
                                </select>
                            </div>
                            <div class="ui_title" id="low1">下属：</div>
                            <div class="ui_text" id="low2">
                            <input id="user_name" class="user_name" type="text" name="user_name" style="vertical-align:top;"/>
                            </div>
                        <div class="ui_title">小记制定时间：</div>
						<div class="ui_text">
                        <input id="J_editTimeS" class="inpDate" name="create_timeb" value="<?php echo $this->_tpl_vars['arrayData']['0']['sappoint_time']; ?>
" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_editTimeE\')).focus()},dateFmt:\'yyyy-MM-dd HH:mm:ss\',maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'})'; ?>
" type="text"/> 至
						<input id="J_editTimeE" class="inpDate" name="create_timee" value="<?php echo $this->_tpl_vars['arrayData']['0']['eappoint_time']; ?>
" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\',dateFmt:\'yyyy-MM-dd HH:mm:ss\'}'; ?>
)" type="text"/>	
                        
                        </div>                        
                    </div>
                    <div class="table_filter_main_row">                         
                        <div class="ui_title">代理商：</div>
                        <div class="ui_text">
                        <input type="hidden" value="<?php echo $this->_tpl_vars['agent_id']; ?>
" name="agent_id" />
                        <input id="agent_name" class="agent_name" type="text" name="agent_name" style="vertical-align:top;"/>
                        </div>                       						
                        <div class="ui_title">审查状态：</div>
                            <div class="ui_comboBox">
                                <select id="auditState" name="auditState">
                                    <option value="-100" selected="selected">全部</option>
                                    <option value="0">未审查</option>
                                    <option value="1">审查通过</option>
                                    <option value="2">审查不通过</option>
                                </select>
                        </div>
                        <div class="ui_title">编号：</div>
                        <div class="ui_comboBox">
							<input id="visitnoteid" class="inpCommon" type="text" name="visitnoteid" style="vertical-align:top;"/>
						</div>
						<div class="ui_title">联系人：</div>
						<div class="ui_comboBox">
							<input id="contact_name" class="inpCommon" type="text" name="contact_name" style="vertical-align:top;"/>
						</div>
                        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="searchVisitNote()">查询</button></div>	                                                                
                    </div>
                    
                </div>
                </form>
            </div>
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
   <a class="ui_button" onclick="ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
    </a>
    </div>
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
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
                        	<div class="ui_table_thcntr" sort="sort_visitnoteid">
                            	<div class="ui_table_thtext">编号</div>
                            </div>
                        </th>
                        <th width="70" title="制定人">
                        	<div class="ui_table_thcntr" sort="sort_e_name">
                            	<div class="ui_table_thtext">制定人</div>
                            </div>
                        </th>
                        <th width="" title="制定时间">
                        	<div class="ui_table_thcntr" sort="sort_create_time">
                            	<div class="ui_table_thtext">制定时间</div>
                            </div>
                        </th>
                        <th title="被访人">
                        	<div class="ui_table_thcntr" sort="sort_visitor">
                            	<div class="ui_table_thtext">被访人</div>
                            </div>
                        </th>
                        <th title="代理商">
                        	<div class="ui_table_thcntr" sort="sort_agent_name">
                            	<div class="ui_table_thtext">代理商</div>
                            </div>
                        </th>
                        <th title="联系电话">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">联系电话</div>
                            </div>
                        </th>
                        <th title="拜访主题">
                        	<div class="ui_table_thcntr " sort="sort_title">
                            	<div class="ui_table_thtext">拜访主题</div>
                            </div>
                        </th>
                        <th title="拜访结果">
                        	<div class="ui_table_thcntr " sort="sort_result">
                            	<div class="ui_table_thtext">拜访结果</div>
                            </div>
                        </th>
                        <th title="意向评级/签约产品">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">意向评级/签约产品</div>
                            </div>
                        </th>
                        <th title="拜访时间">
                        	<div class="ui_table_thcntr " sort="sort_visit_timestart">
                            	<div class="ui_table_thtext">拜访时间</div>
                            </div>
                        </th>
                        <th title="审查结果">
                        	<div class="ui_table_thcntr " sort="sort_check_status" >
                            	<div class="ui_table_thtext">审查结果</div>
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
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
<?php echo ' 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    document.getElementById("low1").style.display=\'none\';
    document.getElementById("low2").style.display=\'none\';
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['NoteListBody']; ?>
"; 
    
	<?php echo '
	pageList.init();
});

function searchVisitNote()
{
    pageList.page = 1;
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();//get 获取！      
	pageList.first();
}
function ExportExcel()
{
    var formdata = $(\'#tableFilterForm\').serialize();
    window.open("/?d=WorkM&c=VisitNote&a=ExcelExportVisitNoteList&"+formdata);
}
function showLow()
{
    var cre_people = $("#cre_people").val();
    if(cre_people == 1)
    {
        document.getElementById("low1").style.display=\'block\';
        document.getElementById("low2").style.display=\'block\';
    }
    else
    {
        document.getElementById("low1").style.display=\'none\';
        document.getElementById("low2").style.display=\'none\';
    }

}
</script>
'; ?>