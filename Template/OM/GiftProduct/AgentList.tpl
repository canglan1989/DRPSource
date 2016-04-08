<!--S crumbs-->

<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div id="J_table_filter_main" class="table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text">
          <input id="tbxAgentNo" type="text" name="tbxAgentNo"  value="" maxlength="48" />
        </div>
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text">
          <input id="tbxAgentName" type="text" name="tbxAgentName" value="{$strAgentName}" maxlength="48" />
        </div>
        <div class="ui_title">赠送产品：</div>
        <div class="ui_comboBox">
          <select id="cbGiftProduct" name="cbGiftProduct">
          </select>
        </div>
        <div class="ui_button ui_button_search">
          <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="list_link marginBottom10">
<a class="ui_button" m="GiftAgentList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=OM&c=GiftProduct&a=AddAgentModify')">
<div class="ui_button_left"></div>
<div class="ui_button_inner">
<div class="ui_icon ui_icon_add"></div>
<div class="ui_text">添代理商</div>
</div>
</a>
<div class="ui_button ui_button_dis" style="margin:0;" ispurview="true" v="8" m="GiftAgentList" onclick="return DelAgents()">
<div class="ui_button_left"></div>
<div class="ui_button_inner">
<div class="ui_icon ui_icon_del"></div>
<div class="ui_text">批量删除</div>
</div>
</div>
</div>
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
        <tr>
          <th style="width:30px;"> <div class="ui_table_thcntr">
            <div class="ui_table_thtext">
            <input class="checkInp" type="checkbox" name="chkCheckAll" id="chkCheckAll" onclick="CheckAll(this);" value="0" />
            </div>
            </div>
          </th>
          <th style="width:120px" > <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商代码</div>
              <div class="ui_table_thsort" sort="sort_convert(t.agent_no using gb2312)"></div>
            </div>
          </th>
          <th > <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商名称</div>
              <div class="ui_table_thsort" sort="sort_convert(t.agent_name using gb2312)"></div>
            </div>
          </th>
          <th style="width:100px"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">订单产品</div>
            </div>
          </th>
          <th title="赠送产品"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">赠送产品</div>
            </div>
          </th>
          <th style="width:150px;" title="操作人"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">操作人</div>
            </div>
          </th>
          <th style="width:150px;" title="操作时间"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">操作时间</div>
            </div>
          </th>
          <th style="width:100px;" title="操作"> <div class="ui_table_thcntr ">
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
<!--S list_table_foot-->
<div class="list_table_foot">
  <div id="divPager" class="ui_pager"> </div>
</div>
<!--E list_table_foot--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
{literal} 
<script language="javascript" type="text/javascript">
 $(function(){
  $GetProduct.BindGiftProduct("cbGiftProduct");
{/literal}
    var strUrl = "{$AgentListBody}";     
{literal}

    pageList.strUrl = strUrl;
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.init(); 
});

function QueryData()
{
    $DOM("chkCheckAll").checked = false;
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}

function CheckAll(obj)
{
    $("input[name='chkCheck']").each(function() { 
        $(this).attr("checked", obj.checked);
    }); 
}

var _InDealWith = false;
function DelAgent(agent_id,order_product_type_id)
{
     if(!confirm("您确定要删除吗？"))
        return ;
        
    _InDealWith = true;
     var backData = $PostData('/?d=OM&c=GiftProduct&a=DelAgent',"agent_ids="+agent_id+"&order_product_type_ids="+order_product_type_id);
     if(parseInt(backData) == 0)
     {
        _InDealWith = false;
        QueryData();
        IM.tip.show("删除成功！");
     }
     else
     {
        _InDealWith = false;
        IM.tip.warn(backData);
     }
}

function DelAgents()
{
    var ids = "";
    var agent_ids = "";
    var order_product_type_ids = "";
    $("input[name='chkCheck']").each(function() { 
        if(this.checked == true)
        {
            ids = this.value.split(",");
            agent_ids += ","+ids[0];
            order_product_type_ids += ","+ids[1];
        }            
    }); 
    
    if(agent_ids == "")
    {
        IM.tip.warn("请选择要删除的赠送对象！");
        return ;
    }        
    
    agent_ids = agent_ids.substring(1);   
    order_product_type_ids = order_product_type_ids.substring(1);
    DelAgent(agent_ids,order_product_type_ids);
}

</script> 
{/literal} 