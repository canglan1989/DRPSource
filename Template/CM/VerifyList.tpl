    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showBackInfoList"}')">客户管理</a><span>&gt;</span>资料审核</div>
        <!--E crumbs-->   
        <div class="table_attention marginBottom10">
                <label>审核状态提醒：</label>
                <span class="ui_link"><a href="javascript:;">新建：</a>(<em>{$newCount}</em>)</span>
                <span class="ui_link"><a href="javascript:;">修改：</a>(<em>{$modifyCount}</em>)</span>
                <span class="ui_link"><a href="javascript:;">删除：</a>(<em>{$delCount}</em>)</span>
		</div>
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">        	
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row"> 
                		<div class="ui_title">客户名称：</div>
                		<div class="ui_text"><input class="inpCommon" type="text" name="customer_name" style="vertical-align:top;"/></div>
                    	<div class="ui_title">行业分类：</div>
                        <div class="ui_comboBox">
                            <select id="industry_pid" name="industry_pid"></select>
                            <select id="industry_id" name="industry_id"></select>
                        </div>                        
                        <div class="ui_title">地区：</div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" name="selProvince" class="pri"></select></div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="selCity" tabindex="3"></select></div>
                        <div class="ui_comboBox"><select id="area_id" class="area" name="area_id"></select></div>
                </div>
                <div class="table_filter_main_row">
                        <div class="ui_title">客户ID：</div>
                        <div class="ui_text"><input type="text" class="inpCommon idNum" name="customer_no"/></div>
                        <div class="ui_title">所属代理商：</div>
                        <div class="ui_text"><input type="text" class="inpCommon" name="agent_name"/></div>
                        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div> 
				</div>           
            </div>
            </form>
        </div>
        <!--E table_filter-->
        <!--S list_link-->
{literal}
        <div class="list_link marginBottom10">	
            <a m="showVerifyList" v="512" ispurview="true" class="ui_button" href="javascript:;" onClick="IM.customer.showVerifyAssign();" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_dist"></div><div class="ui_text">审核任务分配</div></div></a>
        </div>
{/literal}

        <!--E list_link-->
        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 客户资料审核列表</h4>
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
                                	<th style="width:30px" title="全选/反选">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">
            									<input type="checkbox" class="checkInp" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');">
            								</div>
                                        </div>
                                    </th>
                                   <th title="客户ID" style="width:80px">
                                    	<div sort="sort_customer_id" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户ID</div><div class="ui_table_thsort"></div>
                                        </div>

                                    </th>
                                   <th title="客户名称" style="">
                                    	<div sort="sort_customer_name" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th title="所属代理商">

                                    	<div sort="sort_agent_name" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">所属代理商</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th title="信息类型" style="width:80px">
                                    	<div sort="sort_info_type" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">信息类型</div>
                                            <div class="ui_table_thsort"></div>

                                        </div>
                                    </th>
                                   <th style="width:130px" title="录入时间">
                                    	<div sort="sort_create_time" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">提交时间</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>

                                    <th title="录入人" style="width:120px;">
                                    	<div sort="sort_user_name" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">提交人</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th title="审核人" style="width:120px;">
                                    	<div sort="sort_check_name" class="ui_table_thcntr" >
                                        	<div class="ui_table_thtext">审核人</div>

                                            <div class="ui_table_thsort"></div>
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
            <script type="text/javascript" src="{$JS}pageCommon.js"></script>
    <script language="javascript" type="text/javascript">
    {literal}
    $(function(){
        $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:true});
        $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
        {/literal}
    	pageList.strUrl="{$strUrl}";
    	{literal}
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
    });
    function QueryData()
    {
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.first();
    }
    {/literal}
    </script>