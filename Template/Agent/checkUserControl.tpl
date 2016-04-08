 <!--S crumbs-->
    	<div class="crumbs marginBottom10"><s class="icon_crumbs"></s>当前位置：代理商资料管理<span>&gt;</span>审核用户管理</div>
        <!--E crumbs-->   
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">        	
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row">	    			                        		                        		
	                <div class="ui_title">帐户名：</div>
	                <div class="ui_text"><input class="inpCommon" name="agent_name" style="vertical-align:top;" id="agent_name" type="text"></div>
					<div class="ui_title">状态：</div>
	                <div class="ui_comboBox" style="margin-right:5px;">
	                	<select id="audit_status" name="audit_status">
							<option value="1" selected="">全部</option>
							<option value="2">允许分配</option>
							<option value="3">暂停分配</option>
	 					</select>
	 				</div>
	                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" id="searchAgent" name="searchAgent" onclick="searchAgentCheck()">搜 索</button></div>                              
                 </div>
            </div>
            </form>
        </div>
        <!--E table_filter-->
	<div class="list_link marginBottom10">
		<a m="checkUserControl" v="4" ispurview="true" class="ui_button" href="javascript:;" onclick="IM.agent.addCheckUser('{au d='Agent' c='Agent' a='showAddCheckUser'}','添加审核人')" style="margin:0;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">添加审核人</div></div></a>   	
        </div>
        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 审核用户管理列表</h4>
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
                                	<th title="全选/反选" style="width:30px;border-right:1px solid #cbcbcb;" rowspan="2">
                                        <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext"><input type="checkbox" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" class="checkInp"></div>
                                        </div>
                                    </th>
                                	<th title="审核人" style="width:84px;border-right:1px solid #cbcbcb;" rowspan="2">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核人</div>
                                        </div>
                                    </th>
    								<th title="分配状况" style="border-right:1px solid #cbcbcb;" rowspan="2">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">分配状况</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
    								<th title="分配数" style="border-right:1px solid #cbcbcb;" colspan="2">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">分配数</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                					<th title="已审核" colspan="2" style="border-right:1px solid #cbcbcb;">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">已审核</div>
                                        </div>
                                    </th>                				
                                   <th title="未审核" colspan="2" style="border-right:1px solid #cbcbcb;">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">未审核</div>
                                        </div>
                                    </th>
    								<th title="合计" style="width:100px;border-right:1px solid #cbcbcb;" rowspan="2">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">合计</div>
                                        </div>
                                    </th>
                                   <th style="width:80px" title="操作" rowspan="2">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">操作</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                               </tr>
                               <tr>
                                   <th style="border-right:1px solid #cbcbcb;">
                                   	<div class="ui_table_thcntr ">
                                   		<div class="ui_table_thtext">新添</div>
                                   	</div>
                                   </th>
                                   <th style="border-right:1px solid #cbcbcb;">
                                   	<div class="ui_table_thcntr ">
                                   		<div class="ui_table_thtext">其他</div>
                                   	</div>
                                   </th style="border-right:1px solid #cbcbcb;">
                                   <th style="border-right:1px solid #cbcbcb;">
                                   	<div class="ui_table_thcntr ">
                                   		<div class="ui_table_thtext">新添</div>
                                   	</div>
                                   </th>
                                   <th style="border-right:1px solid #cbcbcb;">
                                   	<div class="ui_table_thcntr ">
                                   		<div class="ui_table_thtext">其他</div>
                                   	</div>
                                   </th>
                                   <th style="border-right:1px solid #cbcbcb;">
                                   	<div class="ui_table_thcntr ">
                                   		<div class="ui_table_thtext">新添</div>
                                   	</div>
                                   </th>
                                   <th style="border-right:1px solid #cbcbcb;">
                                   	<div class="ui_table_thcntr ">
                                   		<div class="ui_table_thtext">其他</div>
                                   	</div>
                                   </th>
                               </tr>
                           </thead>
                            <tbody class="ui_table_bd" id="pageListContent"></tbody>
                       </table>
            </div>
            <!--E ui_table-->
            <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
        </div>
        <!--E list_table_main-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
 <script type="text/javascript">
 {literal}
 $(function(){
	{/literal}
	pageList.page = 1;
	pageList.strUrl = "{$strUrl}"; 
	{literal}
	pageList.init();
 });
 function searchAgentCheck()
 {
	var agentName = $.trim($('#agent_name').val());
    var auditStatus = $('#audit_status').val();
	pageList.page  = 1;
	pageList.param = '&agentName='+encodeURIComponent(agentName)+'&auditStatus='+auditStatus;
	pageList.init();
 }
 {/literal}
 </script>            