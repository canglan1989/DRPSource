  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
    <!--S table_filter-->
          <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                  
                    <div class="table_filter_main_row">   
                        <div class="ui_title">时间：</div>
						<div class="ui_text">
                            <input id="J_editTimeS" class="inpDate" name="create_timeb" value="{$create_timeb}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE')).focus()},dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}" type="text"/> 至
    						<input id="J_editTimeE" class="inpDate" name="create_timee" value="{$create_timee}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}',dateFmt:'yyyy-MM-dd'}{/literal})" type="text"/>	
                        </div> 
                        <div class="ui_title">渠道经理：</div>
						<div class="ui_comboBox">
							<input id="u_name" class="inpCommon" type="text" name="u_name" style="vertical-align:top;" value="{$u_name}"/>
						</div>
                        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="searchVisitCount()">查询</button></div>	                                                                
                    </div>
                    
                </div>
                </form>
            </div>  
    <!--E table_filter-->
    <!--S list_link-->
    
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
                        <th width="" title="姓名">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">姓名</div>
                            </div>
                        </th>
                        <th width="" title="联系客户数">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">联系客户数</div>
                            </div>
                        </th>
                        <th width="" title="联系小记数">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">联系小记数</div>
                            </div>
                        </th>
                        <th width="150" title="拜访预约数">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">拜访预约数</div>
                            </div>
                        </th>
                        <th width="150" title="拜访小计数">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">拜访小计数</div>
                            </div>
                        </th>
                   </tr>
               </thead>
               <tbody class="ui_table_bd" id="pageListContent">
               {foreach from=$arrayData item=data key=index}
                    <tr class="{sdrclass rIndex=$index}">
                    	<td title="{$data.create_user_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a></div></td>
                    	<td title="{$data.c_agent_count}"><div class="ui_table_tdcntr">{$data.c_agent_count}</div></td>
                        <td title="{$data.c_appoint_count}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=phoneAgentContactList&eName={$data.create_user_name|escape:'url'}&counttimeb={$create_timeb}&counttimee={$create_timee}',true,true)" title="查看">{$data.c_appoint_count}</a></div></td>
                        <td title="{$data.av_appoint_count}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=WorkM&c=VisitAppoint&a=showVisitTaskManageList&countname={$data.create_user_name|escape:'url'}&counttimeb={$create_timeb}&counttimee={$create_timee}',true,true)" title="查看">{$data.av_appoint_count}</a></div></td>
                        <td title="{$data.v_appoint_count}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=WorkM&c=VisitNote&a=NoteList&countname={$data.create_user_name|escape:'url'}&counttimeb={$create_timeb}&counttimee={$create_timee}',true,true)" title="查看">{$data.v_appoint_count}</a></div></td>
                    </tr>
                {/foreach}
               </tbody>
           </table>   
        </div>
        <!--E ui_table-->
    </div>
    <!--E list_table_main-->  
    <div class="list_table_foot">
    <!--<div id="divPager" class="ui_pager">
    </div>-->
  </div>         
    <!--S list_table_foot-->
{literal} 
<script language="javascript" type="text/javascript">
function searchVisitCount()
{
    var url = "/?d=WorkM&c=VisitCount&a=VisitCountList&"+$('#tableFilterForm').serialize();
    JumpPage(url,false);
}

</script>
{/literal}