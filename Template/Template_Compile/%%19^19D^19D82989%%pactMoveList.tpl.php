<?php /* Smarty version 2.6.26, created on 2012-11-16 16:37:12
         compiled from Agent/pactMoveList.tpl */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<div class="crumbs marginBottom10"><s class="icon_crumbs"></s>当前位置当前位置：代理商管理<span>&gt;</span>签约管理<span>&gt;</span>合同转移记录列表</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">        	
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">	    			
                
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input id="agent_name" name="agent_name" type="text" style="width:160px;"/></div>
                <div class="ui_title">合同号：</div>
                <div class="ui_text"><input id="pact_number" name="pact_number" type="text" style="width:120px;"/></div>
                <div class="ui_title">提交时间：</div>
                <div class="ui_text"><input type="text" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'create_timeE\')).focus()},maxDate:\'#F{$dp.$D(\\\'create_timeE\\\')}\'}'; ?>
)" name="create_timeS" id="create_timeS" class="inpCommon inpDate"> 
                至 
                <input type="text" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'create_timeS\\\')}\'}'; ?>
)" name="create_timeE" id="create_timeE" class="inpCommon inpDate"></div>       
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="search()">搜 索</button></div> 
            </div>   
                                   
        </div>

</form>
</div>

<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 合同转移记录列表</h4>
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
            <tr class="">
              
            <th title="合同号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">合同号</div>
            </div>
            </th>
            <th title="代理商名称" style="">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商名称</div>
            </div>
            </th>
            <th title="合同转移前所属账号">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">合同转移前所属账号</div>
                
            </div>
            </th>
            <th title="合同转移后所属账号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">合同转移后所属账号</div>
            </div>
            </th> 
           
            
            <th title="操作人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">操作人</div>
            </div>
            </th>
           
            <th title="操作时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">操作时间</div>
            </div>
            </th>   
           
            </tr>
            </thead>
            <tbody id="pageListContent" class="ui_table_bd">

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
<script>
    <?php echo '
$(document).ready(function(){
   
    pageList.strUrl='; ?>
"<?php echo $this->_tpl_vars['strUrl']; ?>
"<?php echo ';
    pageList.param = "&"+$("#tableFilterForm").serialize();
    pageList.init();
    
});

function search(){
    
    pageList.page = 1;
    pageList.param = "&"+$("#tableFilterForm").serialize();
    pageList.first();
}
function ExportExcel()
{
    window.open("/?d=Agent&c=AgentMove&a=SignDetailExport" + pageList.param + "&sortField=" + pageList.sortField);
}
    '; ?>

</script>