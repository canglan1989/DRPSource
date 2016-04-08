    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="{au d='Agent' c='Agent' a='showChannelPager'}">我的渠道</a><span>&gt;</span>联系小记</div>
        <!--E crumbs--> 
        <div class="table_filter marginBottom10">  
            <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
            <div class="table_filter_main" id="J_table_filter_main">
                <div class="table_filter_main_row">                	
                    <div class="ui_title">联系时间：</div>
                    <div class="ui_text"><input type="text" onfocus="WdatePicker()" name="contactTime" class="inpCommon inpDate" id="J_editTimeE"></div>
                    <div class="ui_title">联系人：</div>
                    <div class="ui_text"><input type="text" id="J_contact_name" name="contactName"/></div>
                    <div class="ui_button ui_button_search"><button onclick="searchContactInfo();" class="ui_button_inner" type="button">搜 索</button></div>	 
                </div>        
            </div>
            </form>
            
        </div>
	<div class="list_link marginBottom10">
        <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;" style="margin:0;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
                  </div>
		<div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>联系小记列表</h4>
                    </div>
                </div>
		</div>
                               <input type="hidden" name="agentId" id="agentId" value="{$agentId}" />
		<!--S list_table_main-->
		<div class="list_table_main">
                <div class="ui_table" id="J_ui_table">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead class="ui_table_hd">
                                    <tr class="">
                                        
                                       <th title="操作人" style="width:120px;">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">操作人</div>
                                            </div>
                                        </th>
                                        <th title="被联系人" style="width:80px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">被联系人</div>
                                            </div>
                                        </th>
                                        <th style="width:200px;" title="手机固话">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">手机固话</div>
                                            </div>
                                        </th>
                                        <th style="width:130px;" title="联系时间">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">联系时间</div>
                                            </div>
                                        </th>
                                        <th title="联系记录">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">联系记录</div>
                                            </div>
                                        </th>
                                        <th style="width:80px;" title="意向评级">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">意向评级</div>
                                            </div>
                                        </th>
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
                <div id="divPager" class="ui_pager"></div>
			</div>
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
	function searchContactInfo()
	{
		var agentId = $('#agentId').val();
		var contactName = $.trim($('#J_contact_name').val());
		var contactTime = $('#J_editTimeE').val();
		pageList.page = 1;
		pageList.param = '&contactName='+encodeURIComponent(contactName)+'&contactTime='+contactTime+'&agentId='+agentId;
		pageList.init();
	}
{/literal}
</script>