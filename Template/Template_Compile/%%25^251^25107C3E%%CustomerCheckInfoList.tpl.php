<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:20
         compiled from CM/CheckManage/CustomerCheckInfoList.tpl */ ?>
    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
        <!--E crumbs-->   
        <div class="table_attention marginBottom10">
                <label>审核状态提醒：</label>
                <span class="ui_link">新建：(<em><?php echo $this->_tpl_vars['newCount']; ?>
</em>)</span>
                <span class="ui_link">修改：(<em><?php echo $this->_tpl_vars['modifyCount']; ?>
</em>)</span>
                <span class="ui_link">删除：(<em><?php echo $this->_tpl_vars['delCount']; ?>
</em>)</span>
		</div>
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">        	
            <div class="table_filter_main" id="J_table_filter_main">
                <div class="table_filter_main_row"> 
                    <div class="ui_title">客户名称：</div>
                    <div class="ui_text"><input  type="text" name="customer_name" style="width:200px;"/></div>
                    <div class="ui_title">所属代理商：</div>
                    <div class="ui_text"><input type="text" class="" name="agent_name" style="width:200px;"/></div>
                    <div class="ui_title">录入/注册时间：</div>
                    <div class="ui_text"  id = "createTime">
                        <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="create_time_begin" onClick="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'})'; ?>
"/> 至
                        <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="create_time_end" onClick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\'})'; ?>
"/>
                    </div>
                    <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div> 
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
                                   <th title="客户ID" style="width:80px">
                                    	<div  class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户ID</div>
                                        </div>

                                    </th>
                                   <th title="客户名称" style="">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户名称</div>
                                        </div>
                                    </th>
                                    <th title="所属代理商">
                                    	<div class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">所属代理商</div>
                                        </div>
                                    </th>
                                   <th title="信息类型" style="width:80px">
                                    	<div sort="sort_cm_customer_log.check_type" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">信息类型</div>
                                            <div class="ui_table_thsort"></div>

                                        </div>
                                    </th>
                                   <th style="width:130px" title="提交时间">
                                    	<div sort="sort_cm_customer_log.create_time" class="ui_table_thcntr" >
                                            <div class="ui_table_thtext">提交时间</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>

                                    <th title="提交人" style="width:120px;">
                                    	<div sort="sort_cm_customer_log.create_user_name" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">提交人</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th title="操作" style="width:60px">
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
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
        
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
<script language="javascript" type="text/javascript">
<?php echo '
$(function(){
$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:true});
$("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
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
'; ?>

</script>