<?php /* Smarty version 2.6.26, created on 2012-12-11 15:05:27
         compiled from System/AreaSet/AreaGroupList.tpl */ ?>
  <!--E crumbs-->
    <!--S table_filter-->
   <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
    <!--E table_filter-->
    <!--S list_link-->
    
   <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                    <div class="table_filter_main_row">
                        <div class="ui_title" id="low1">区域组名称：</div>
                        <div class="ui_text" id="low2">
                        <input id="area_name" class="user_name" type="text" name="area_name" style="vertical-align:top;"/>
                        </div>                  
                        <div class="ui_title">区域组层级：</div>
                        <div class="ui_text">
                        <select id="level" name="level">
                                <option value="-100" selected="selected">请选择</option>
                                <option value="2" >1级</option>
                                <option value="4">2级</option>
                                <option value="6">3级</option>
                        </select>
                        </div>
                    <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="QueryData()">查询</button></div>
                    </div>
                    </div>
                </form>
            
            </div>
    <div class="list_link marginBottom10">
    	<a class="ui_button" onclick="JumpPage('/?d=System&c=AreaGroupSet&a=AreaGroupModify')" href="javascript:;" m="AreaGroupManagement" ispurview="true" v="4" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">新增一级区域组</div></div></a>
    </div>    
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>区域组列表</h4>
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
                    	<th style="width:120px;" title="区域组名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">区域组名称</div>
                            </div>
                        </th>
                        <th style="width:120px" title="区域组层级">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">区域组层级</div>
                            </div>
                        </th>
                        <th style="width:60%" title="区域组范围">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">区域组范围</div>
                            </div>
                        </th>
                        <th style="width:30%" title="区域组描述">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">区域组描述</div>
                            </div>
                        </th>
                        <th style="width:190px;" title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
               </thead>
               <tbody class="ui_table_bd" id="pageListContent"></tbody>
           </table>   
        </div>
        <!--E ui_table-->
    </div>
    <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
    </div>
    <!--E list_table_main-->           
    <!--S list_table_foot-->
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>  
<?php echo ' 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['groupListBody']; ?>
"; 
	<?php echo '
    var tbxAreaName = $(\'#tbxAreaName\').val();
    if(tbxAreaName == "请输入区域名称搜索")
        tbxAreaName = "";
        
    tbxAreaName = encodeURIComponent(tbxAreaName);
	pageList.param = "&tbxAreaName="+tbxAreaName;
	pageList.init();
});

function QueryData()
{
    pageList.page = 1;
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();//get 获取！      
	pageList.first();
}
function ShowArea(agroup_id)
{
    IM.dialog.show({
            width: 250,
    	    height: null,
    	    title: \'区域组范围\',
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=System&c=AreaGroupSet&a=ShowAreaDetial&id="+agroup_id, {}, function (backData) {
    		  
    		    $(\'.DCont\')[0].innerHTML = backData;});}
                });
}

function addTreeEventHandler(){
	var J_allArea=$(".treeview2");
	J_allArea.treeview2();
	J_allArea.unbind(\'click\').bind(\'click\',function(e){
                        var target=MM.E(e).target;
                        if(target.tagName==\'A\'){
                            $(target).parents("#J_allArea").find(\'a\').removeClass(\'cur\');
							$(target).addClass(\'cur\');
                        }
	}).unbind(\'dblclick\').bind(\'dblclick\',function(e){
		var target=MM.E(e).target;
		if(target.tagName==\'A\') IM.setArea.add(\'.treeview2\',target);
	});
}
addTreeEventHandler();
</script>
'; ?>
 