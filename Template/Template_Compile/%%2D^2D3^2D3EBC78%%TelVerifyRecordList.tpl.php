<?php /* Smarty version 2.6.26, created on 2013-01-29 11:09:52
         compiled from Agent/WorkManagement/TelVerifyRecordList.tpl */ ?>
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text">
                    <input id="agent_name"  name="agent_name" type="text" style="width:200px;"/>
                </div>                        
                <div class="ui_title">质检状态：</div>
                <div class="ui_comboBox">
                    <select id="qcheck_state" name="qcheck_state" >
                        <option value="-100" selected="selected">全部</option>
                        <option value="1">通过</option>
                        <option value="0">不通过</option>
                    </select>
                </div>
                <div class="ui_title">联系小记编号：</div>
                <div class="ui_text">
                    <input id="record_no"  name="record_no" type="text" style="width:100px;"/>
                </div>
                <div class="ui_title">质检通过项：</div>
                <?php echo '
                <div id="cbVertifyTtem" onclick="IM.comboBox.init({\'control\':\'vertify_item\',data:MM.A(this,\'data\')},this)" 
                    '; ?>

                     class="ui_comboBox ui_comboBox_def" key="" value="" control="vertify_item" data="<?php echo $this->_tpl_vars['vertifyJson']; ?>
" style="width:180px;">
                  <div class="ui_comboBox_text" style="width:160px;"> <nobr>全部</nobr> </div>
                  <div class="ui_icon ui_icon_comboBox"></div>
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">提交人：</div>
                <div class="ui_text">
                    <input id="create_user"  name="create_user" type="text" />
                </div>  
                <div class="ui_title">提交时间：</div>
                <div class="ui_text">
                    <input id="create_time_start" type="text" class="inpCommon inpDate" name="create_time_start" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'create_time_end\')).focus()},maxDate:\'#F{$dp.$D(\\\'create_time_end\\\')}\'}'; ?>
)"/> 至
                    <input id="create_time_end" type="text" class="inpCommon inpDate" name="create_time_end" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'create_time_start\\\')}\'}'; ?>
)"/>
                </div> 
                <div class="ui_title">联系时间：</div>
                <div class="ui_text">
                    <input id="contact_time_start" type="text" class="inpCommon inpDate" name="contact_time_start" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'create_time_end\')).focus()},maxDate:\'#F{$dp.$D(\\\'create_time_end\\\')}\'}'; ?>
)"/> 至
                    <input id="contact_time_end" type="text" class="inpCommon inpDate" name="contact_time_end" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'create_time_start\\\')}\'}'; ?>
)"/>
                </div> 
                <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="searchVertify()">查询</button></div>     
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" m="TelVerifyRecord" v="2" ispurview="true" onclick="pageList.ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
</a>
</div>
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
                    <th title="编号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商名称</div>
            </div>
            </th>
            <th title="联系小记编号">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">联系小记编号</div>
            </div>
            </th>
             <th title="联系时间">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">联系时间</div>
            </div>
            </th>           
            <th  title="提交人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">提交人</div>
            </div>
            </th>
            <th  title="提交时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">提交时间</div>
            </div>
            </th>
            <th  title="录音编号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">录音编号</div>
            </div>
            </th>
            <th title="本次质检操作通过的项">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">本次质检操作通过的项</div>
            </div>
            </th>
            <th title="质检结果">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">质检结果</div>
            </div>
            </th>
            <th title="质检评语">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">质检评语</div>
            </div>
            </th>
            <th title="质检人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">质检人</div>
            </div>
            </th>
            <th title="质检操作时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">质检操作时间</div>
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
'; ?>

        pageList.strUrl="<?php echo $this->_tpl_vars['BodyUrl']; ?>
"; 
    pageList.param = "&"+$('#tableFilterForm').serialize()+"&cbVertifyTtem="+encodeURIComponent($("#cbVertifyTtem").attr("value"));//get 获取！      
<?php echo '
        pageList.init();
});

function searchVertify()
{
        pageList.param = "&"+$(\'#tableFilterForm\').serialize()+"&cbVertifyTtem="+encodeURIComponent($("#cbVertifyTtem").attr("value"));//get 获取！      
        pageList.first();
}

</script>
'; ?>