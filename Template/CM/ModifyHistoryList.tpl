        <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
            <input id="customer_id" name="customer_id" type="hidden" value="{$customer_id}"/>
            <input id="agentid" name="agentid" type="hidden" value="{$agentid}"/>
        </form>
    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}<span>&gt;</span>客户资料历史修改记录</div>
        <!--E crumbs-->
	<div class="list_link marginBottom10">
	<a class="ui_button ui_button_dis" onclick="PageBack()" href="javascript:;" style="margin:0;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
	</div>
        <!--E list_link-->
        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 客户资料历史修改记录</h4>
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
                                	<th title="修改前内容">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">修改前内容</div>
                                        </div>
                                    </th>
                                   <th style="" title="修改后内容">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">修改后内容</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:110px;" title="提交人">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">提交人</div>
                                        </div>
                                    </th>
                                   <th style="width:130px;" title="提交时间">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">提交时间</div>
                                        </div>
                                    </th>
                                   <th style="width:110px;" title="审核人">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核人</div>
                                        </div>
                                    </th>
                                    <th style="width:130px;" title="审核时间">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核时间</div>
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
        <!--E list_table_foot-->
            <script type="text/javascript" src="{$JS}pageCommon.js"></script>
	<script type="text/javascript">
	{literal}
	$(function(){
        {/literal}
    	pageList.strUrl="{$strUrl}"; 
    	{literal}
        pageList.sortField="create_time desc";
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
	});
    
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
    
	{/literal}
	</script>