<?php /* Smarty version 2.6.26, created on 2012-11-28 17:53:17
         compiled from Agent/ReportManage/AgentKpiExport.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->   
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a href="javascript:;" onclick="ExportExcel()" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
 (表头示例)</h4>
        </div>
    </div>
</div>
<!--E list_table_head-->        
<!--S list_table_main-->       
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
    <img src="<?php echo $this->_tpl_vars['img']; ?>
kpi_t1.jpg" /><br/><br/><br/>
    <img src="<?php echo $this->_tpl_vars['img']; ?>
kpi_t2.jpg" />
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main-->           
<!--S list_table_foot-->
<!--E list_table_foot-->
<?php echo '
<script language="javascript" type="text/javascript">
function ExportExcel()
{
    window.open("/?d=Agent&c=ReportManage&a=AgentKpiExport&iExportExcel=1");
}
    
'; ?>

</script>