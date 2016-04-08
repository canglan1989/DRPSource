<!--E crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" name="tableFilterForm" id="tableFilterForm">
        <div id="J_table_filter_main" class="table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">代理商：</div>
                <div class="ui_text">
                    <input id="tbxAgentName" class="agent_name" type="text" name="tbxAgentName" style="vertical-align:top;"/>
                </div>
                <div class="ui_title">陪访时间：</div>
                <div class="ui_comboBox">
                    <input id="tbxVisitTimeS" class="inpCommon inpDate" type="text" name="tbxVisitTimeS" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('tbxVisitTimeE')).focus()},dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'tbxVisitTimeE\')}'}){/literal}"  />&nbsp;至&nbsp;
                    <input id="tbxVisitTimeE" class="inpCommon inpDate" type="text" name="tbxVisitTimeE" onfocus="WdatePicker({literal}{dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'tbxVisitTimeS\')}'}){/literal}"  />
                </div>
                <div class="ui_title">邀请人：</div>
                <div class="ui_comboBox">
                    <input id="tbxInviter" class="inpCommon" type="text" name="tbxInviter" style="vertical-align:top;" />
                </div>
                <div class="ui_title">被访人：</div>
                <div class="ui_comboBox">
                    <input id="tbxVisitor" class="inpCommon" type="text" name="tbxVisitor" style="vertical-align:top;"/>
                </div>                
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">制定时间：</div>
                <div class="ui_text">
                    <input id="tbxCreateTimeS" class="inpCommon inpDate" name="tbxCreateTimeS" value="{$arrayData.0.sappoint_time}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('tbxCreateTimeE')).focus()},dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'tbxCreateTimeE\')}'}){/literal}" type="text"/>
                    至
                    <input id="tbxCreateTimeE" class="inpCommon inpDate" name="tbxCreateTimeE" value="{$arrayData.0.eappoint_time}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxCreateTimeS\')}',dateFmt:'yyyy-MM-dd'}{/literal})" type="text"/>
                </div>
                <div class="ui_title" id="divCreateUserTitle">制定人：</div>
                <div class="ui_text" id="divCreateUserText">
                    <input id="tbxCreateName" class="inpCommon user_name" type="text" name="tbxCreateName" style="vertical-align:top;" />
                </div>
                <div class="ui_button ui_button_search">
                    <button type="button" class="ui_button_inner" onclick="QueryData()">查询</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--E table_filter--> 
<!--S list_link-->
<div class="list_link marginBottom10"> <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_export"></div>
            <div class="ui_text">导出Excel</div>
        </div>
    </a> </div>
<!--E list_link--> 
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> </div>
    </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th width="50" title="编号"> <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">编号</div>
                <div class="ui_table_thsort" sort="sort_id"></div>
            </div>
            </th>
            <th width="70" title="制定人"> <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">制定人</div>
                <div class="ui_table_thsort" sort="sort_create_user_name"></div>
            </div>
            </th>
            <th width="100" title="制定时间"> <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">制定时间</div>
                <div class="ui_table_thsort" sort="sort_create_time"></div>
            </div>
            </th>
            <th width="70" title="邀请人"> <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">邀请人</div>
                <div class="ui_table_thsort" sort="sort_invaited_user_name"></div>
            </div>
            </th>
            <th width="100" title="陪访时间"> <div class="ui_table_thcntr">
                <div class="ui_table_thtext">陪访时间</div>
            </div>
            </th>
            <th title="代理商名称"> <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">代理商名称</div>
                <div class="ui_table_thsort" sort="sort_agent_name"></div>
            </div>
            </th>
            <th width="70" title="被访人姓名"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">被访人姓名</div>
            </div>
            </th>
            <th width="100" title="被访人联系电话"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">被访人联系电话</div>
            </div>
            </th>
            <th width="350" title="陪访内容"> <div class="ui_table_thcntr " >
                <div class="ui_table_thtext">陪访内容</div>
            </div>
            </th>
            <th width="80" title="操作"> <div class="ui_table_thcntr ">
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
<div class="list_table_foot">
    <div id="divPager" class="ui_pager"></div>
</div>
<!--S list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    {/literal}
    pageList.strUrl="{$AccompanyVisitVerifyListBody}"; 
    pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！     
    {literal}
    pageList.init();
});

function QueryData()
{
    pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！      
    pageList.first();
}
    
var FlagNoteUnVertify = function(noteId){
        if(noteId > 0){
            $.ajax({
                url:"/?d=WorkM&c=AccompanyVisit&a=UnNeedCheck&id="+noteId,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        IM.tip.show(data.msg);
                        pageList.reflash();
                    }else{
                        IM.tip.warn(data.msg);
                    }
                        return false;
                },
                error:function(){
                    IM.tip.warn("系统错误");
                        return false;
                }
            });
        }else{
            IM.tip.warn("获取数据出错");
        }
            return false;
    }
</script>
{/literal}