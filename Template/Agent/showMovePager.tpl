    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
    <!--E crumbs-->   
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
        	<div class="table_filter_main_row">     		
                <div class="ui_title">代理商代码：</div>
		          <div class="ui_text"><input class="inpCommon" type="text" name="tbxAgentNo" style="vertical-align:top;" id="tbxAgentNo" value="{$agentNo}"/></div>  
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input class="" style="width:200px;" type="text" name="tbxAgentName" id="tbxAgentName"/></div>  
                <div class="ui_title">操作类型：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="cbMoveType" name="cbMoveType">
                <option value="-100">请选择</option>
                {foreach from=$arrayMoveType item=data key=index}
                <option value="{$index}">{$data}</option> 
                {/foreach}
                </select></div>                  
                <div class="ui_title">注册地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="cbProvince"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="cbCity"></select></div>
                <div class="ui_comboBox"><select id="selArea" class="area" name="cbArea"></select></div>   
                           
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onClick="QueryData();">搜索</button></div>   
            </div>                             
        </div>
        </form>
    </div>
    <!--E table_filter-->
    <!--S list_table_head-->
    <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
                    <a class="ui_button ui_link" href="javascript:;" onclick="pageList.reflash()">
                    <span class="ui_icon ui_icon_fresh"> </span>
                    刷新
                    </a>
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
                                <th style="width:90px;" title="代理商代码">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">代理商代码</div>
                                    </div>
                                </th>
                                <th style="width:190px;" title="代理商名称">
                                    <div class="ui_table_thcntr ">
                                        <div class="ui_table_thtext">代理商名称</div>
                                    </div>
                                </th>
                                <th style="width:190px;"  title="注册地区">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">注册地区</div>
                                    </div>
                                </th>
                                <th style="width:70px;" title="操作类型">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">操作类型</div>
                                    </div>
                                </th>  
                                <th title="原所在库">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">原所在库</div>
                                    </div>
                                </th>  
                                <th title="操作后所在库">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">操作后所在库</div>
                                    </div>
                                </th>           
                               <th style="width:120px;" title="操作人">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">操作人</div>
                                    </div>
                                </th>   					
                               <th style="width:140px;" title="操作时间">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">操作时间</div>
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
    <div class="list_table_foot"><div id="divPager" class="ui_pager"></div>
    
    <!--E list_table_foot-->  
 <script type="text/javascript" src="{$JS}pageCommon.js"></script> 
 <script type="text/javascript">
 {literal}
 $(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
	{/literal}
	pageList.strUrl="{$strUrl}"; 
	{literal}
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 {/literal}
 </script> 