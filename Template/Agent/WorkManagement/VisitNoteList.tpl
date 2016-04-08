<!--E crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text">
          <input type="hidden" value="{$agent_id}" name="agent_id" />
          <input id="agent_name" class="agent_name" type="text" name="agent_name" style="vertical-align:top;"/>
        </div>
        <div class="ui_title">质检状态：</div>
        <div class="ui_comboBox">
          <select id="qcheck_state" name="qcheck_state" >
            <option value="-100" selected="selected">全部</option>
            <option value="3">不质检</option>
            <option value="0" >未质检</option>
            <option value="1">通过</option>
            <option value="2">不通过</option>
          </select>
        </div>
        <div class="ui_title">拜访时间：</div>
        <div class="ui_text">
         
        <input id="create_time_start" type="text" class="inpCommon inpDate" name="create_timeb" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('create_time_end')).focus()},maxDate:'#F{$dp.$D(\'create_time_end\')}'}{/literal})"/> 至
        <input id="create_time_end" type="text" class="inpCommon inpDate" name="create_timee" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'create_time_start\')}'}{/literal})"/>
        </div>
        <div class="ui_title">操作人：</div>
        <div class="ui_comboBox">
          <select id="cre_people" name="cre_people" onchange="showLow()">
            <option value="-100" selected="selected">全部</option>
            <option value="0" >自己</option>
            <option value="1">下属</option>
          </select>
        </div>
        <div class="ui_title" id="low1" style="display:none">账号：</div>
        <div class="ui_text" id="low2" style="display:none">
          <input id="user_name" class="user_name" type="text" name="user_name" style="vertical-align:top;"/>
        </div>
      </div>
      <div class="table_filter_main_row">
        <div id="J_level">
          <div class="ui_title">意向评级：</div>
          <div style="width:100px;" id="agent_level" data="[{literal}{'key':'A','value':'A'},{'key':'B+','value':'B+'},{'key':'B-','value':'B-'},{'key':'C','value':'C'},{'key':'D','value':'D'},{'key':'E','value':'E'}{/literal}]" value="" key="" control="agentPro" class="ui_comboBox ui_comboBox_def" onclick="IM.comboBox.init({literal}{'control':MM.A(this,'control'),data:MM.A(this,'data')}{/literal},this)">
            <div style="width:80px;" class="ui_comboBox_text"> <nobr>全部</nobr> </div>
            <div class="ui_icon ui_icon_comboBox"></div>
          </div>
        </div>
        <div class="ui_title" style="margin-top:4px;margin-right:4px;">
          <input id="sign_agent" name="sign_agent" class="checkInp" type="checkbox" onClick="changeLevel()"/>
          <input type ="hidden" id ="is_sign" name="is_sign" value="0" />
        </div>
        <div class="ui_title" style="margin-right:4px;">签约代理商</div>
        <div class="ui_title">批示状态：</div>
        <div class="ui_comboBox">
          <select id="readState" name="readState">
            <option value="-100" selected="selected">全部</option>
            <option value="1">已批示</option>
            <option value="2">已阅</option>
            <option value="0">未批示</option>
          </select>
        </div>
        
        <div class="ui_button ui_button_search"></span>
          <button type="button" class="ui_button_inner" onclick="searchVisitNote()">查询</button>
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
          <th width="58" title="编号"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">编号</div>
              <div class="ui_table_thsort" sort="sort_visitnoteid"></div>
            </div>
          </th>
          <th width="110" title="代理商名称"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">代理商名称</div>
              <div class="ui_table_thsort" sort="sort_agent_name"></div>
            </div>
          </th>
          <th width="70" title="意向评级/签约产品"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">意向评级/签约产品</div>
            </div>
          </th>
          <th width="60" title="拜访类型"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">拜访类型</div>
            </div>
          </th>
          <th width="80" title="被访人"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">被访人</div>
              <div class="ui_table_thsort" sort="sort_visitor"></div>
            </div>
          </th>
          <th width="100" title="联系电话"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">联系电话</div>
            </div>
          </th>
          <th title="拜访时间"> <div class="ui_table_thcntr " >
              <div class="ui_table_thtext">拜访时间</div>
              <div class="ui_table_thsort" sort="sort_visit_timestart"></div>
            </div>
          </th>
          <th width="70" title="操作人"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">操作人</div>
              <div class="ui_table_thsort" sort="sort_create_user_name"></div>
            </div>
          </th>
          <th width="" title="操作时间"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">操作时间</div>
              <div class="ui_table_thsort" sort="sort_create_time"></div>
            </div>
          </th>
          <th title="拜访计划"> <div class="ui_table_thcntr " >
              <div class="ui_table_thtext">拜访计划</div>
            </div>
          </th>
          <th width="100" title="拜访结果"> <div class="ui_table_thcntr " >
              <div class="ui_table_thtext">拜访结果</div>
            </div>
          </th>
          <th title="下次拜访时间"> <div class="ui_table_thcntr " >
              <div class="ui_table_thtext">下次拜访时间</div>
            </div>
          </th>
          <th title="下次拜访计划"> <div class="ui_table_thcntr " >
              <div class="ui_table_thtext">下次拜访计划</div>
            </div>
          </th>
          <th title="批示内容"> <div class="ui_table_thcntr "  >
              <div class="ui_table_thtext">批示内容</div>
            </div>
          </th>
          <th width="60"  title="质检结果"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">质检结果</div>
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
  <div id="divPager" class="ui_pager"> </div>
</div>
<!--S list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    document.getElementById("low1").style.display='none';
    document.getElementById("low2").style.display='none';
    
    {/literal}
	pageList.strUrl="{$NoteListBody}"; 
    
	{literal}
        pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
        showLow();
       
});

function searchVisitNote()
{
    var agentLevel   = $('#agent_level').attr('key');
    pageList.page = 1;
    pageList.param = "&"+$('#tableFilterForm').serialize()+'&agentLevel='+encodeURIComponent(encodeURIComponent(agentLevel));//get 获取！      
    pageList.first();
}

function showLow()
{
    var cre_people = $("#cre_people").val();
    if(cre_people == 1||cre_people ==-100)
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
        document.getElementById("J_level").style.display='none';
        $("#is_sign").val(1);//签约代理商
    }
    else
    {
        document.getElementById("J_level").style.display='block';
        $("#is_sign").val(0);//
    }
}
    //质检结果卡片
function verfityDetail(noteId)
{
     IM.dialog.show({
            width:400,           
            title:'拜访小记质检信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=WorkM&c=VisitNote&a=showVerifyInfo&noteId="+noteId,""));
            }
         });
}
//批示内容卡片
function inDetail(noteId)
{
     IM.dialog.show({
            width:400,           
            title:'拜访小记领导批示信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=WorkM&c=VisitNote&a=showInstructionInfo&noteId="+noteId,""));
            }
         });
}
</script> 
{/literal}