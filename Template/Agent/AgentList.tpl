    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：我的渠道</div>
        <!--E crumbs-->   
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">    		
            	<div class="table_filter_main_row">  
	                <div class="ui_title">单位：</div>
	                <div class="ui_text"><input class="inpCommon" type="text" name="companyName" style="vertical-align:top;"/></div>
					<div class="ui_title">地区：</div>
	                <div class="ui_comboBox" style="margin-right:5px;"><select class="pri" name="pri"></select></div>
	                <div class="ui_comboBox" style="margin-right:5px;"><select class="city" name="city"></select></div>
	                <div class="ui_comboBox"><select class="area" name="area"></select></div>
	                <div class="ui_title">审核状态：</div>
	                <div class="ui_comboBox"><select name="auditState"><option>全部</option></select></div>
                    <div class="ui_button ui_button_search"><button type="submit" class="ui_button_inner">搜 索</button></div>                     
                </div>
            </div>
            </form>
        </div>
        <!--E table_filter-->
        <!--S list_link-->
        <div class="list_link marginBottom10">        	
        	<a class="ui_button"  href="{au d='Agent' c='Agent' a='AddShow'}"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div><div class="ui_text">添加代理商</div></div></a>
            	<a class="ui_button ui_button_dis" href="javascript:;" onClick="{literal}IM.account.delOper('../chunk/delRoles.php',{},'删除代理商'){/literal}" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">批量删除</div></div></a>	
        </div>
        <!--E list_link-->
        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商列表</h4>
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
                    				<th title="全选/反选" style="width:30px">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">
            									<input onClick="{literal}IM.table.selectAll(this.checked);IM.table.checkAll('listid');{/literal}" class="checkInp" type="checkbox" />
            								</div>
                                        </div>
                                    </th>
                                	<th style="width:80px;" title="编号">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">编号</div>
                                        </div>
                                    </th>
    								<th style="" title="单位名称">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">单位名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                					<th title="地区">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">地区</div>
                                        </div>
                                    </th>                					
                                   <th style="width:65px;" title="意向评级">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">意向评级</div>
                                        </div>
                                    </th>
                                   <th style="width:80px;"title="客户来源">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户来源</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:95px;" title="渠道经理">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">渠道经理</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:65px" title="审核状态">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核状态</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:65px;" title="联系次数">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">联系次数</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:130px;" title="最后联系时间">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">最后联系时间</div>
                                        </div>
                                    </th>
                                    <th style="width:100px" title="操作">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">操作</div>
                                        </div>
                                    </th>
                               </tr>
                           </thead>
                           <tbody class="ui_table_bd">
                            </tbody>
                       </table>
            </div>
            <!--E ui_table-->
        </div>
        <!--E list_table_main-->           
        <!--S list_table_foot-->
        <div class="list_table_foot">
            <div class="ui_pager">
            	<div class="ui_pager_select">
                	<label class="ui_title">每页显示条数：</label>
                    <a class="cur" href="javascript:;">15</a>
                    <a href="javascript:;">30</a>
                    <a href="javascript:;">50</a>
                </div>
                <div class="ui_pager_cont">
                	<label class="ui_title">共100条</label><label class="ui_title">当前1-15条</label><label class="ui_title">第 3/20 页</label>
                    <a class="ui_link" href="javascript:;">首页</a>
                    <a class="ui_link" href="javascript:;">上一页</a>
                    <a class="ui_link" href="javascript:;">下一页</a>
                    <a class="ui_link" style="margin-right:10px;" href="javascript:;">尾页</a>
                    <label class="ui_title" style="margin-right:5px;">跳转</label>
                    <span class="ui_text"><input class="inp" type="text" name="pageNum"/></span>
                    <a class="ui_link pageGO" href="javascript:;">GO</a>
                </div>
            </div>
        </div>
        <!--E list_table_foot-->   