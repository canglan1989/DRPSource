<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：运营管理<span>&gt;</span> 共享申请审核</div>
<!--E crumbs-->   
<div class="form_edit">   
    <!--S form_bd-->
    <div class="form_bd">
        <div class="form_block_bd">
            <!--S table_filter-->
            <div class="table_filter marginBottom10">  
                <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
                    <div class="table_filter_main" id="J_table_filter_main">
                        <div class="table_filter_main_row"> 		
                            <div class="ui_title">代理商名称：</div>
                            <div class="ui_text"><input style="width:200px" type="text" name="agent_name" id="agent_name"/></div>                                                      
                            <div class="ui_title">共享操作时间：</div>
                            <div class="ui_text">
                                <input id="J_contactTimeS2" type="text" class="inpCommon inpDate" name="J_contactTimeS" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_contactTimeE2')).focus()},maxDate:'#F{$dp.$D(\'J_contactTimeE2\')}'}{/literal})"/> 至
                                <input id="J_contactTimeE2" type="text" class="inpCommon inpDate" name="J_contactTimeE" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_contactTimeS2\')}'}{/literal})"/>
                            </div>

                        </div>
                        <div class="table_filter_main_row">
                            <div class="ui_title">共享人：</div>
                            <div class="ui_text"><input style="width:200px" type="text" name="share_person" id="share_person"/agent></div>
                            <div class="ui_title">共享操作人：</div>
                            <div class="ui_text"><input style="width:200px" type="text" name="share_create" id="share_create"/></div>
                            <div class="ui_title">审核状态：</div>
                            <div class="ui_comboBox">
                                <select id="status" name="status">
                                    <option value="-100">全部</option>
                                    <option value="0">未审核</option>
                                    <option value="1">通过</option>
                                    <option value="2">不通过</option>                                   
                                </select>
                            </div>	
                            
                             <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData();">搜 索</button></div>	                       
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
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>共享申请审核</h4>
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
                               
                        <th style="width:70px;" title="编号">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">编号</div>
                            <div class="ui_table_thsort"></div>
                        </div>
                        </th>
                        <th title="代理商名称">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">代理商名称</div>
                            
                        </div>
                        </th>
                        <th style="width:150px;" title="原所属人">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">原所属人</div>
                            
                        </div>
                        </th>
                        <th style="width:150px;" title="共享人">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">共享人</div>
                        </div>
                        </th>              					
                        <th style="width:150px;" title="共享后所属人">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">共享后所属人</div>
                        </div>
                        </th>
                                                
                        <th style="width:120px" title="共享操作备注">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">共享操作备注</div>
                        </div>
                        </th>
                        <th style="width:150px;" title="共享操作人">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">共享操作人</div>
                            
                        </div>
                        </th>
                        <th style="width:150px;" title="共享操作时间">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">共享操作时间</div>
                            <div class="ui_table_thsort"></div>
                        </div>
                        </th>
                        <th  title="审核状态">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">审核状态</div>
                        </div>
                        </th>
                       
                        <th style="width:70px" title="操作">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">操作</div>
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
            <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
            <!--E list_table_foot-->
        </div>
    </div>
    <!--E form_bd-->    
    <script type="text/javascript" src="{$JS}pageCommon.js"></script> 
    <script type="text/javascript">
        {literal}
        $(function(){ 	
        {/literal}
	pageList.strUrl = "{$strUrl}"; 
        {literal}
        pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
 });

 function QueryData()
 {
        var agentName  = $.trim($('#agent_name').val());
        
	var sTime      = $('#J_contactTimeS2').val();
	var eTime      = $('#J_contactTimeE2').val();
        var sharePerson  = $.trim($('#share_person').val());
	var shareCreate  = $.trim($('#share_create').val());
	var status = $('#status').val();	
        pageList.page = 1;
	pageList.param = '&agentName='+encodeURIComponent(agentName)+'&sharePerson='+sharePerson+'&shareCreate='+shareCreate+'&status='+status+'&sTime='+sTime+'&eTime='+eTime;
	pageList.first();
 }
function check(checkId)
{      
     IM.dialog.show({
            width: 450,
            title: '共享申请审核操作',
            html: IM.STATIC.LOADING,
            start:function(){
                $('.DCont')[0].innerHTML= $PostData("/?d=Agent&c=Agent&a=showShareCheck","checkId="+checkId);          
		                            
            new Reg.vf($('#J_shareCheck'),{callback:function(formData){                                              
                    var postData = $("#J_shareCheck").serialize();                                           
                    var backData = $PostData("/?d=Agent&c=Agent&a=submitShareCheck",postData);
                    
                    if(backData == 0)
                    {
                        IM.dialog.hide();	
                	IM.tip.show("审核成功！");                       
                        pageList.reflash();
                    }    
                    else
                    {
                        IM.tip.warn(backData);
                                           
                    } 
                }});
          }
            
        });
}
function showCheckPage(logid){
        IM.dialog.show({
        width: 500,
        height: null,
        title: '审核信息',
        html: IM.STATIC.LOADING,
        start: function () {
            $('.DCont').html($PostData("/?d=Agent&c=Agent&a=shareCheckInfo&logid="+ logid, ""));
        }
    });
    }
{/literal}
    </script> 