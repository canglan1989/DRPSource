<?php /* Smarty version 2.6.26, created on 2012-11-22 10:48:48
         compiled from System/ModelManager/Dev_ModelCreate_Tables.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代码自动生成</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">表名：</div>
        <div class="ui_text"><input id="tbxTableName" type="text" name="tbxTableName" value="" style="width:200px;" /></div>        
        <div class="ui_button ui_button_search">
        <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>        
    </div>
    </div>
    </form>
</div>
<!--E table_filter-->
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
        	   <tr class="">                                	
                   <th width="200px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">表名</div></div></th>
                   <th width="100px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">生成</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">备注</div></div></th>
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
<!--E list_table_foot-->
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>  
<?php echo ' 
<script language="javascript" type="text/javascript">
 $(function(){
   	'; ?>

	var strUrl = "/?d=System&c=Dev_ModelCreate&a=TablesListBody"; 
	<?php echo '
    
	pageList.strUrl = strUrl; 
	pageList.param = \'&\'+$("#tableFilterForm").serialize();   
    pageList.pageSize = 50;
   	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 
 
 function CreateCode(tableName,table_comment)
 {
    var data = $PostData(\'/?d=System&c=Dev_ModelCreate&a=CreateModel&table_name=\'+encodeURIComponent(tableName)+"&table_comment="+encodeURIComponent(table_comment),"");
    if(data.indexOf("0,") == 0)
    {
        IM.tip.show("文件已经生成在：DRP_SOURCE/FrontFile/download/modelCode 文件夹中");
        //data = data.split(",");
        //window.open("/Action/Common/Download.php?filename="+encodeURIComponent(data[1]));
        //window.open("/Action/Common/Download.php?filename="+encodeURIComponent(data[2]));
    }
    else
    {
        IM.tip.warn(data);
    }
 }

</script>
'; ?>
 