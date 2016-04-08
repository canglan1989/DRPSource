<?php /* Smarty version 2.6.26, created on 2013-01-28 10:44:51
         compiled from Agent/WorkManagement/VisitTaskManageList.tpl */ ?>
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
        <div class="ui_title">任务审核状态：</div>
        <div class="ui_comboBox">
            <select id="checkstatus" name="checkstatus">
                    <option value="-9">全部</option>
                    <option value="0">未审核</option>
                    <option value="1">审核通过</option>
                    <option value="2">审核不通过</option>
                </select>
        </div>
         <?php if ($this->_tpl_vars['ViewType'] != 3): ?>
        <div class="ui_title">任务制定人：</div>
        <div class="ui_text">
            <select name="view_type">
                <option value="0">全部</option>
                <option value="1">下属</option>
                <option value="2">自己</option>
            </select>
        </div>
        <?php endif; ?> 
        </div>
      <div class="table_filter_main_row">  
        <div class="ui_title">计划联系日期：</div>
        <div class="ui_text">
            <input name="appointtime" class="inpDate" onfocus="WdatePicker(<?php echo '{dateFmt:\'yyyy-MM-dd\'}'; ?>
)" />
        </div>
        <div class="ui_title">预约状态：</div>
        <div class="ui_text">
            <select name="note_state">
                <option value="-100">全部</option>
                <option value="1">已生成小记</option>
                <option value="0" selected >未生成小记</option>
            </select>
        </div>
        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="searchAppoint()">查询</button></div>     
    </div>
</div>
</form>
</div>
<!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
    <a class="ui_button" m="VisitAppoint" v="2" ispurview="true" onclick="pageList.ExportExcel()" href="javascript:;">
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
                	<th title="任务编号">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">任务编号</div>
                        </div>
                    </th>
                    <th title="代理商名称">
                    	<div class="ui_table_thcntr" >
                        	<div class="ui_table_thtext">代理商名称</div>
                        </div>
                    </th><th title="意向评级/签约产品">
                    	<div class="ui_table_thcntr" >
                        	<div class="ui_table_thtext">意向评级/签约产品</div>
                        </div>
                    </th>
                    
                    <th  title="被访人">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">被访人</div>
                        </div>
                    </th>
                    <th  title="职位">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">职位</div>
                        </div>
                    </th>
                    <th  title="角色">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">角色</div>
                        </div>
                    </th>
                    <th title="联系电话">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">联系电话</div>
                        </div>
                    </th>
                    <th title="计划联系日期">
                    	<div class="ui_table_thcntr" >
                        	<div class="ui_table_thtext">计划联系日期</div>
                        </div>
                    </th>
                    <th title="拜访计划">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">拜访计划</div>
                        </div>
                    </th>
                    <th title="拜访任务制定人">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">拜访任务制定人</div>
                        </div>
                    </th>
                    <th title="拜访任务制定时间">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">拜访任务制定时间</div>
                        </div>
                    </th>
                    <th title="审核状态">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">审核状态</div>
                        </div>
                    </th>
                    <th title="操作">
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
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['BodyUrl']; ?>
"; 
    pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！      
	<?php echo '
	pageList.init();
});
function searchAppoint()
{
    pageList.page = 1;
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();//get 获取！      
	pageList.first();
}
    
function CheckDetail(AppointID){
        IM.dialog.show({
            width:500,           
            title:\'审核状态查询\',
            html:IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\').html($PostData("/?d=WorkM&c=TelWork&a=getCheckDetail&appid="+AppointID,""));
            }
         })
}
    
function delTask(appointid){
                var html=\'<div class="DContInner delAccountCont">\' +
                    \'<div class="bd"><h4>您确定要删除所选项码？</h4></div>\' +
                    \'<div class="ft">\' +
                    \'<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>\' +
                    \'<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok()">确定</button></div>\' +
                    \'</div></div>\';
                IM.dialog.show({
                    width:400,
                    title:\'拜访预约删除\',
                    html:html,
                    ok:function(){
                        $.ajax({
                            url: \'/?d=WorkM&c=TelWork&a=DelAppointTask\',
                            type:\'post\',
                            data:{
                                \'appointid\':appointid
                            },
                            dataType:\'json\',
                            success: function (q) {
                                if(q.success) {                                    
                                    IM.tip.show(q.msg);
                                        IM.dialog.hide();
                                         pageList.reflash();   
                                }else{IM.tip.warn(q.msg);}
                            },
                            error:function(){
                                IM.tip.warn("系统出错");
                            }
                        });
                    }
                });
            }
                
                
</script>
'; ?>