<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text">
          <input class="inpCommon" type="text" name="tbxAgentNo" style="vertical-align:top;" id="tbxAgentNo" value="{$agentNo}"/>
        </div>
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text">
          <input class="" style="width:200px;" type="text" name="tbxAgentName" id="tbxAgentName"/>
        </div>
        <div class="ui_title">预计到账类型：</div>
        <div class="ui_comboBox">
          <select id="cbExpectMoneyType" name="cbExpectMoneyType">
            <option value="-100">请选择</option>
            <option value="1">承诺</option>
            <option value="2">备份</option>
            <option value="0">空</option>
          </select>
        </div>
        <div class="ui_title">操作日期：</div>
        <div class="ui_text">
          <input id="tbxCreateSDate" type="text" class="inpCommon inpDate" name="tbxCreateSDate" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxCreateEDate\')}'}){/literal}"/>
          至
          <input id="tbxCreateEDate" type="text" class="inpCommon inpDate" name="tbxCreateEDate" onclick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxCreateSDate\')}'}){/literal}"/>
        </div>
      </div>
      <div class="table_filter_main_row">      
        <div class="ui_title">意向等级：</div>
        {literal}
            <div id="cbIntentionLevel" onclick="IM.comboBox.init({'control':'IntentionLevel',data:MM.A(this,'data')},this)" 
            {/literal}
            class="ui_comboBox ui_comboBox_def" key="{$rating_text}" value="{$rating_text}" control="IntentionLevel" data="{$strIntentionLevelJson}" style="width:100px;">
            <div class="ui_comboBox_text" style="width:80px;">
                {if $rating_text != ""}
                    <nobr>{$rating_text}</nobr>
                {else}
                    <nobr>全部</nobr>
                {/if}
            </div>
            <div class="ui_icon ui_icon_comboBox"></div>                        
        </div>
        <div class="ui_title">所属人：</div>
        <div class="ui_text">
          <input class="inpCommon" type="text" name="tbxChannelUserName" style="vertical-align:top;" id="tbxChannelUserName" value=""/>
        </div>
        <div class="ui_title">所属人所在组：</div>
        <div class="ui_comboBox">
          <select id="cbChannelUserGroup" name="cbChannelUserGroup">
            <option value="-100">请选择</option>            
                {foreach from=$arrayData item=data key=index}                
            <option value="{$data.account_no}">{$data.account_name}</option>            
                {/foreach}                
          </select>
        </div>
        <div class="ui_title">预计到帐日期：</div>
        <div class="ui_text">
          <input id="tbxExpectMoneySDate" type="text" class="inpCommon inpDate" name="tbxExpectMoneySDate" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxExpectMoneyEDate\')}'}){/literal}"/>
          至
          <input id="tbxExpectMoneyEDate" type="text" class="inpCommon inpDate" name="tbxExpectMoneyEDate" onclick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxExpectMoneySDate\')}'}){/literal}"/>
        </div>
        <div class="ui_button ui_button_search">
          <button type="button" class="ui_button_inner" onclick="QueryData();">搜索</button>
        </div>
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
      <a class="ui_button ui_link" href="javascript:;" onclick="pageList.reflash()"> <span class="ui_icon ui_icon_fresh"> </span> 刷新 </a> </div>
  </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
  <div id="J_ui_table" class="ui_table">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <thead class="ui_table_hd">
        <tr>
          <th style="width:90px;" title="代理商代码"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商代码</div>
            </div>
          </th>
          <th title="代理商名称"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">代理商名称</div>
            </div>
          </th>
          <th style="width:110px;"  title="所属人"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">所属人</div>
            </div>
          </th>
          <th title="所属人所在组"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">所属人所在组</div>
            </div>
          </th>
          <th style="width:60px;" title="意向等级"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">意向等级</div>
            </div>
          </th>
          <th style="width:88px;" class="TA_r" title="预计到账金额"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计到账金额</div>
            </div>
          </th>
          <th style="width:88px;" title="预计到账时间"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计到账时间</div>
            </div>
          </th>
          <th style="width:60px;" title="预计到账类型"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">到账类型</div>
            </div>
          </th>
          <th style="width:70px;" class="TA_r" title="预计达成率"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计达成率</div>
            </div>
          </th>
          <th title="操作人"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">操作人</div>
            </div>
          </th>
          <th title="操作时间"> <div class="ui_table_thcntr">
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
<div class="list_table_foot">
<div id="divPager" class="ui_pager"></div>

<!--E list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
<script type="text/javascript">
 {literal}
 $(function(){
	{/literal}
	pageList.strUrl="{$ExpectMoneyListBody}"; 
	{literal}
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&cbIntentionLevel="+encodeURIComponent($("#cbIntentionLevel").attr("key"));
	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&cbIntentionLevel="+encodeURIComponent($("#cbIntentionLevel").attr("key"));
	pageList.first();
 }
 {/literal}
 </script> 