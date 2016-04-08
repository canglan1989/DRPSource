<div class="crumbs marginBottom10"><s class="icon_crumbs"></s>当前位置当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text">
          <input id="agent_code" name="agent_code" type="text" style="width:120px;"/>
        </div>
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text">
          <input id="agent_name" name="agent_name" type="text" style="width:160px;"/>
        </div>
        <div class="ui_title">合同号：</div>
        <div class="ui_text">
          <input id="pact_no" name="pact_no" type="text" style="width:120px;"/>
        </div>
        <div class="ui_title">签约类型：</div>
        <div class="ui_comboBox">
          <select name="pact_type">
            <option value="-9" >请选择</option>
            <option value="0" {if $pacttype == "0"}selected{/if} >未签约</option>
            <option value="1" {if $pacttype == "1"}selected{/if} >新签</option>
            <option value="2" {if $pacttype == "2"}selected{/if} >续签</option>
            <option value="3" {if $pacttype == "3"}selected{/if} >解除签约</option>
            <option value="4" {if $pacttype == "4"}selected{/if} >失效</option>
          </select>
        </div>
        <div class="ui_title">款项状态：</div>
        <div class="ui_comboBox">
          <select name="money_received">
            <option value="-100">请选择</option>
            <option value="3">全部到账</option>
            <option value="2">部分到账</option>
            <option value="1">未到账</option>
          </select>
        </div>
      </div>
      <div class="table_filter_main_row">
        <div class="ui_title">签约次数：</div>
        <div class="ui_text">
          <input id="pact_count" name="pact_count_S" type="text" style="width:40px;"/>
          <span>至</span>
          <input id="pact_count" name="pact_count_E" type="text" style="width:40px;"/>
        </div>
        <div class="ui_title">签约状态：</div>
        <div class="ui_comboBox">
          <select name="pact_status" id="pact_status">
            <option selected="selected" value="0">全部</option>
            <option value="1">已签约</option>
            <option value="2">已解除签约</option>
            <option value="3">流程中</option>
            <option value="4">已失效</option>
          </select>
        </div>
        <div class="ui_title">注册地区：</div>
        <div class="ui_comboBox">
          <select class="pri" name="pri" id="selProvince">
            <option value="-1">省份</option>
          </select>
          <select class="city" name="city" id="selCity">
            <option value="-1">市</option>
          </select>
          <select class="area" name="area" id="selArea">
            <option value="-1">区/县</option>
          </select>
        </div>
        <div class="ui_title">代理商等级</div>
        <div class="ui_comboBox">
          <select name="agent_level" id="agent_level">
            <option selected="selected" value="">全部</option>
            <option value="0">无等级</option>
            <option value="1">金牌</option>
            <option value="2">银牌</option>
          </select>
        </div>
        <div class="ui_title">代理商类型：</div>
        <div class="ui_comboBox">
          <select id="agent_type" name="agent_type">
            <option value="-100">全部</option>
            <option value="1">核心</option>
            <option value="2">非核心</option>
          </select>
        </div>
      </div>
      <div class="table_filter_main_row">
        <div class="ui_title">签约产品：</div>
        {literal}
        <div id="ui_comboBox_agentPro" onClick="IM.comboBox.init({'control':'agentPro',data:MM.A(this,'data')},this)" {/literal}class="ui_comboBox ui_comboBox_def" key="{$productid}" value="{$productname}" data='{$arrProductType}' style="width:100px;">
          <div class="ui_comboBox_text" style="width:80px;"> {if $productid > 0} <nobr>{$productname}</nobr> {else} <nobr>全部</nobr> {/if} </div>
          <div class="ui_icon ui_icon_comboBox"></div>
        </div>
        <div class="ui_title">提交人：</div>
        <div class="ui_text">
          <input id="create_user" value="{$createuser}" class="inpCommon" name="create_user" type="text"/>
        </div>
        <div class="ui_title">提交时间：</div>
        <div class="ui_text">
          <input type="text" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('create_timeE')).focus()},maxDate:'#F{$dp.$D(\'create_timeE\')}'}{/literal})" name="create_timeS" id="create_timeS" class="inpCommon inpDate">
          至
          <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'create_timeS\')}'}{/literal})" name="create_timeE" id="create_timeE" class="inpCommon inpDate">
        </div>
        <div class="ui_button ui_button_search">
          <button type="button" class="ui_button_inner" onclick="search()">搜 索</button>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="list_link marginBottom10"> <a m="SignDetail" v="32" ispurview="true" href="javascript:;" onClick="IM.agent.contractMove('{au d=Agent c=AgentMove a=contractMoveshow}',{literal}{}{/literal},'转移代理商合同')" class="ui_button" >
  <div class="ui_button_left"></div>
  <div class="ui_button_inner">
    <div class="ui_icon ui_icon_move"></div>
    <div class="ui_text">转移代理商合同</div>
  </div>
  </a> <a href="javascript:;" onclick="pageList.ExportExcel()" class="ui_button">
  <div class="ui_button_left"></div>
  <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
  </div>
  </a> </div>
<!--E table_filter--> 
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
        <tr class="">
          <th title="全选/反选" style="width:30px"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">
                <input class="checkInp" type="checkbox" onClick="{literal}IM.table.selectAll(this.checked);IM.table.checkAll('listid');{/literal}"/>
              </div>
            </div>
          </th>
          <th width="85" title="代理商代码"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商代码</div>
            </div>
          </th>
          <th title="代理商名称" style=""> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商名称</div>
            </div>
          </th>
          <th title="虚拟合同号"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">虚拟合同号</div>
              <!--                <div class="ui_table_thsort"></div>--> 
            </div>
          <th title="签约类型"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">签约类型</div>
            </div>
          </th>
            </th>
          <th title="注册地区" style=""> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">注册地区</div>
            </div>
          </th>
          <th title="代理产品"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理产品</div>
              <!--                <div class="ui_table_thsort"></div>--> 
            </div>
          </th>
          <th width="50" title="代理商类型"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商类型</div>
            </div>
          </th>
          <th width="50" title="代理产品等级"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商等级</div>
            </div>
          </th>
          <th width="88" title="合同有效期"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">合同有效期</div>
              <!--                <div class="ui_table_thsort"></div>--> 
            </div>
          </th>
          <th width="65" title="签约状态"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">签约状态</div>
            </div>
          </th>
          <th title="业务流程及状态"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">业务流程及状态</div>
            </div>
          </th>
          <th width="60" title="款项到账状态"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">款项到账状态</div>
            </div>
          </th>
          <th title="所属人"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">所属人</div>
            </div>
          </th>
          <th title="战区名称"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">战区名称</div>
            </div>
          </th>
          <th title="提交人"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">提交人</div>
            </div>
          </th>
          <th title="提交时间"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">提交时间</div>
            </div>
          </th>
          <th width="80" title="操作"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">操作</div>
              <!--                <div class="ui_table_thsort"></div>--> 
            </div>
          </th>
        </tr>
      </thead>
      <tbody id="pageListContent" class="ui_table_bd">
      </tbody>
    </table>
  </div>
  <!--E ui_table--> 
</div>
<!--E list_table_main--> 
<!--S list_table_foot-->
<div class="list_table_foot">
  <div id="divPager" class="ui_pager"> </div>
</div>
<!--E list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
<script language="javascript" type="text/javascript">
    {literal}
$(document).ready(function(){
    $.setPurview();
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
    var productIds = $.trim(MM.A(MM.G('ui_comboBox_agentPro'),'key'));
    pageList.strUrl={/literal}"{$strUrl}"{literal};
    pageList.param = "&"+$("#tableFilterForm").serialize()+'&proIds='+productIds;
    pageList.init();
});

function search(){
    var productIds = $.trim(MM.A(MM.G('ui_comboBox_agentPro'),'key'));    
    pageList.param = "&"+$("#tableFilterForm").serialize()+'&proIds='+productIds;
    pageList.first();
}

    {/literal}
</script> 
