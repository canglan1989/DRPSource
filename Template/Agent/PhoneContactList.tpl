 <!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
                
        <!--S form_bd-->
    <div class="form_bd">
        <div class="form_block_bd">
            <!--S table_filter-->
            <div class="table_filter marginBottom10">  
                <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                    <div class="table_filter_main_row">
                        <div class="ui_title">代理商名称：</div>
                        <div class="ui_text"><input style="width:200px;" type="text" name="agent_name" value="{$agentId}" id="agent_name" style="vertical-align:top;"/></div>
                        <div class="ui_title">质检状态：</div>
                        <div class="ui_comboBox">
                            <select id="qcheck_state" name="qcheck_state" >
                            <option value="-100" selected="selected">全部</option>
                            <option value="3">不质检</option>
                            <option value="2" >未质检</option>
                            <option value="1">通过</option>
                            <option value="0">不通过</option>
                            </select>
                        </div>
                            				
                        <div class="ui_title">操作人：</div>
                        <div class="ui_comboBox">
                            <select id="cre_people" name="cre_people" onchange="showLow()">
                            <option value="-100">全部</option>
                            <option value="0" selected="selected">自己</option>
                            <option value="1">下属</option>
                            </select>
                        </div>
                        <div class="ui_title" id="low1" style="display:none">账号：</div>
                        <div class="ui_text" id="low2" style="display:none">
                        <input id="user_name" class="user_name" type="text" name="user_name"  style="vertical-align:top;"/>
                        </div>
                  </div>
                  <div class="table_filter_main_row"> 
                        <div id="J_level1" class="ui_title">意向评级：</div>
                        <div  style="width:100px;" id="agent_level" data="[{literal}{'key':'A','value':'A'},{'key':'B+','value':'B+'},{'key':'B-','value':'B-'},{'key':'C','value':'C'},{'key':'D','value':'D'},{'key':'E','value':'E'}{/literal}]" value="" key="" control="agentPro" class="ui_comboBox ui_comboBox_def" onclick="IM.comboBox.init({literal}{'control':MM.A(this,'control'),data:MM.A(this,'data')}{/literal},this)">
                        <div style="width:80px;" class="ui_comboBox_text">
                        	<nobr>全部</nobr>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>   
                        </div>
                        <div class="ui_text">
                        <label>
                        <input id="sign_agent" class="checkInp" style="vertical-align: middle;" type="checkbox" onClick="changeLevel()"/>
                            <input type ="hidden" id ="is_sign" name="is_sign" value="0" />签约代理商</label>                            
                         </div>
			<div class="ui_title">联系时间：</div>
			<div class="ui_text">
			    <input id="contactSTime" type="text" class="inpCommon inpDate" name="contactSTime" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('contactETime')).focus()},maxDate:'#F{$dp.$D(\'contactETime\')}'}{/literal})"/> 至
                            <input id="contactETime" type="text" class="inpCommon inpDate" name="contactETime" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'contactSTime\')}'}{/literal})"/>
			</div>  	  
                        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="searchPactAgentContact()">搜索</button></div>
                                             	                                                                
                    </div>
                   </div>
                </form>
            </div>
            <!--E table_filter-->            
<div class="list_link marginBottom10">
    <a  m="pactAgentContact" v="2" ispurview="true" class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
</a>
</div>
            <!--S list_table_head-->
            <div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
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
                                        <th title="代理商编号" style="width:90px;">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">代理商编号</div>
                                            </div>
                                        </th>
                                        <th title="代理商名称" style="width:100px;">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">代理商名称</div>
                                            </div>
                                        </th>
                                        <th title="意向等级或签约产品" style="width:80px;">
                                            <div class="ui_table_thcntr ">
                                                <div class="ui_table_thtext">意向等级或<br />签约产品</div>
                                            </div>
                                        </th>
                                        <th title="被联系人" style="width:70px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">被联系人</div>
                                            </div>
                                        </th>           
                                        <th  title="联系电话" style="width:100px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">联系电话</div>
                                            </div>
                                        </th>  
                                        <th title="联系时间" style="width:120px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">联系时间</div>
                                            </div>
                                        </th>
                                       <th title="操作人" style="width:80px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">操作人</div>
                                            </div>
                                        </th> 
                                       
                                        <th title="添加时间" style="width:100px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">添加时间</div>
                                            </div>
                                        </th>               					
                                        <th title="联系小记" style="width:250px;">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">联系小记</div>
                                            </div>
                                        </th>  
                                        <th title="行业动态" width="120">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">行业动态</div>
                                            </div>
                                        </th> 
                                        <th width="80" title="质检结果">
                                            <div class="ui_table_thcntr">
                                                <div class="ui_table_thtext">质检结果</div>
                                            </div>
                                        </th>
                                   </tr>
                               </thead>
                                <tbody class="ui_table_bd" id="pageListContent"></tbody>
                           </table>
                  </div>
        </div>
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div>
 </div></div>
<!--E form_bd--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
 <script type="text/javascript">
 {literal}
 $(function(){
    document.getElementById("low1").style.display='none';
    document.getElementById("low2").style.display='none';
    
	{/literal}
	pageList.strUrl = "{$strUrl}"; 
	{literal}
        pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
 });
 function searchPactAgentContact()
 {	
        var agentLevel   = $('#agent_level').attr('key');     	
        pageList.page = 1;
	pageList.param = '&'+$('#tableFilterForm').serialize()+'&agentLevel='+encodeURIComponent(agentLevel);//get 获取！      
	pageList.first();
 }
function showLow()
{
    
    var cre_people = $("#cre_people").val();
    if(cre_people == 1||cre_people == -100)
    {
        document.getElementById("low1").style.display='block';
        document.getElementById("low2").style.display='block';
    }
    else
    {
        document.getElementById("low1").style.display='none';
        document.getElementById("low2").style.display='none';
    }

}
function changeLevel()
{
    if(document.getElementById("sign_agent").checked ==true)
    {
        document.getElementById("J_level1").style.display='none';
        document.getElementById("agent_level").style.display='none';
        $("#is_sign").val(1);//签约代理商
    }
    else
    {
        document.getElementById("J_level1").style.display='block';
        document.getElementById("agent_level").style.display='block';
        $("#is_sign").val(0);//签约代理商
    }
}
    //质检结果卡片
function verfityDetail(noteId,type)
{    
     IM.dialog.show({
            width:400,           
            title:'联系小记质检信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=WorkM&c=VisitNote&a=showVerifyInfo&noteId="+noteId+"&type="+type,""));
            }
         });
}
 {/literal}
 </script> 