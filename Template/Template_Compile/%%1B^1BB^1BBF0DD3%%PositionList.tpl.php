<?php /* Smarty version 2.6.26, created on 2012-11-16 16:13:54
         compiled from System/ModelManager/PositionList.tpl */ ?>
<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
  <!--E crumbs--> 
  <!--S table_filter-->  
  <div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
      <div id="J_table_filter_main" class="table_filter_main">
        <div class="table_filter_main_row">        
        <div class="ui_title"> 公司： </div>
        <div class="ui_text">
          <select name="cbCompanyName" id="cbCompanyName" style="width:130px;">
          </select>
        </div>
        <div class="ui_title"> 部门： </div>
        <div class="ui_text">
          <select name="cbDeptName" id="cbDeptName" style="width:220px;">
          </select>
        </div>
        <div class="ui_title">职位名称：</div>
        <div class="ui_text">
          <input name="tbxPosionName" type="text" id="tbxPosionName" size="10" style="width:180px;" maxlength="10" />
        </div>
        <div class="ui_button ui_button_search">
        <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>
        <!--
        <div class="ui_button"><span class="ui_button_left"></span>
          <button type="button" class="ui_button_inner" onclick="$Reset('J_table_filter_main')">重 置</button>
        </div>
        -->
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
          <tr>
            <th style="width:150px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">公司</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">部门</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">职位名</div></div></th>
            <th style="width:180px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">行政级别</div></div></th>
            <th style="width:100px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">添加日期</div></div></th> 
            <th style="width:100px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>	          
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
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>  
<?php echo ' 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    var cbCompanyName = $DOM("cbCompanyName");
    var cbDeptName = $DOM("cbDeptName");
    top.$Dept.Init(cbCompanyName,cbDeptName,true);
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
	<?php echo '
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();
	pageList.init();
});


function QueryData()
{
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();
	pageList.first();
}
</script>
'; ?>
 