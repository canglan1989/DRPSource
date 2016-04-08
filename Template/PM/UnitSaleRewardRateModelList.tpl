<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<!--E table_filter--> 

<!--S list_link-->
<div class="list_link marginBottom10"> <a class="ui_button" style="margin:0" onclick="JumpPage('/?d=PM&c=ProductPriceModel&a=UnitSaleRewardRateModelModify')" href="javascript:;" >
  <div class="ui_button_left"></div>
  <div class="ui_button_inner">
    <div class="ui_icon ui_icon_open"></div>
    <div class="ui_text">添加模板</div>
  </div>
  </a> </div>
<!--E list_link--> 
<!--S list_table_head-->
<div class="list_table_head">
  <div class="list_table_head_right">
    <div class="list_table_head_mid">
      <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
      <a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> </div>
  </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
  <div id="J_ui_table" class="ui_table">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <thead class="ui_table_hd">
        <tr>
          <th style="width:140px;"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">模板名称</div>
            </div>
          </th>
          <th > <div class="ui_table_thcntr">
              <div class="ui_table_thtext">返点百分比</div>
            </div>
          </th>
          <th style="width:140px;"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">添加人</div>
            </div>
          </th>
          <th style="width:140px;"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">添加时间</div>
            </div>
          </th>
          <th style="width:80px;"> <div class="ui_table_thcntr ">
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
<div class="list_table_foot">
  <div id="divPager" class="ui_pager"> </div>
</div>
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
{literal} 
<script language="javascript" type="text/javascript">
$(function(){
	{/literal}
	pageList.strUrl = "{$UnitSaleRewardRateModelListBody}"; 
	{literal}
    pageList.param = "";
	//pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
});

function QueryData()
{
    pageList.param = "";
	pageList.first();
}


function DelModel(id)
{    
     if(!confirm("您确定要删除此模板吗？"))
        return ;
        
        
    var backData = $PostData("/?d=PM&c=ProductPriceModel&a=UnitSaleRewardRateModelDel&id="+id);
    
    if(parseInt(backData) == 0)
    {			
        IM.tip.show("删除成功！");
        pageList.reflash();
    }
    else
    {
        IM.tip.warn(backData);
    } 
}

</script> 
{/literal} 