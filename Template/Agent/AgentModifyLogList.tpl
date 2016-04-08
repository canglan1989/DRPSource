    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商修改记录</div>
    <!--E crumbs-->   

    <!--S list_table_head-->
    <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商修改记录</h4>
                </div>
            </div>
	</div>
    <!--E list_table_head-->        
    <!--S list_table_main-->       
    <div class="list_table_main">
        <div id="J_ui_table" class="ui_table">
<input type="hidden" name="agentId" id="agentId" value="{$agentId}" />
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
                                <th style="width:130px;" title="提交人">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">提交人</div>
                                    </div>
                                </th>
                                <th style="width:130px;" title="提交时间">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">提交时间</div>
                                    </div>
                                </th>
                                <th style="width:130px;" title="审核人">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">审核人</div>
                                    </div>
                                </th>
                                <th style="width:130px;" title="审核时间">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">审核时间</div>
                                    </div>
                                </th>
                                <th style="width:130px;" title="审核备注">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">审核备注</div>
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
		pageList.page = 1;
		pageList.param = '&agentId='+$('#agentId').val();
		pageList.strUrl="{$strUrl}"; 
		{literal}
		pageList.init();
	});
{/literal}
</script>  