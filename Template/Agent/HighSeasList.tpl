<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">代理商类型：</div>
        <div class="ui_comboBox">
        <select id="cbAgentType" name="cbAgentType">
        <option value="-100">请选择</option>
        <option value="1">潜在</option>
        <option value="2">签约</option>
        </select>        
        </div> 
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text"><input id="tbxAgentNo" type="text" name="tbxAgentNo" style="width:120px;" value="" maxlength="30" /></div>
        
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text"><input id="tbxAgentName" type="text" name="tbxAgentName" value="" maxlength="48" style="width:200px;" /></div>
        
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
        <div class="ui_title">联系号码：</div>
        <div class="ui_text">
          <input style="width:100px" type="text" name="contact_no" id="contact_no"/>
        </div>
    </div>
    <div class="table_filter_main_row">
        <div class="ui_title">行业：</div>
        <div class="ui_comboBox">
        <select name="cbIindustry" id="cbIindustry">
        <option value="-100">请选择</option>
        <option value="1">IT硬件</option>
        <option value="2">传媒</option>
        <option value="3">网络</option>
        <option value="4">广告</option>
        <option value="5">其他</option>
        </select>
        </div>
        <div class="ui_title">最后联系类型：</div>
        <div class="ui_comboBox">
        <select name="cbContantType" id="cbContantType">
        <option value="-100">请选择</option>
        <option value="1">拜访</option>
        <option value="2">电话</option>
        </select>
        </div>
        <div class="ui_title">踢入时间：</div>
        <div class="ui_text">
            <input id="tbxInSDate" type="text" class="inpCommon inpDate" name="tbxInSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxInEDate\')}'}){/literal}"/>
            至
            <input id="tbxInEDate" type="text" class="inpCommon inpDate" name="tbxInEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxInSDate\')}'}){/literal}"/>	
        </div>
        <div class="ui_title">注册地区：</div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProvince" class="pri" name="cbProvince"></select></div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbCity" class="city" name="cbCity"></select></div>
        <div class="ui_comboBox"><select id="cbArea" class="area" name="cbArea"></select></div>
        <div class="ui_button ui_button_search">
        <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>
    </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a m="HighSeasList" ispurview="true" v="4" class="ui_button" onclick="GetAgent(0)" href="javascript:;">
    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div>
    <div class="ui_text">拉取</div></div></a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
<div class="list_table_head_right">
<div class="list_table_head_mid">
	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
<a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>   
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
                <th title="全选/反选" style="width:30px">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">
                        <input class="checkInp" type="checkbox" onClick="{literal}IM.table.selectAll(this.checked);IM.table.checkAll('listid');{/literal}"/>
                        </div>
                    </div>
                </th>                	
                <th style="width:90px;">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">代理商代码</div>
                </div>
                </th>
                <th>
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">代理商名称</div>
                </div>
                </th>
                <th title="意向等级/签约产品" style="width:80px;">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">意向等级/签约产品</div>
                </div>
                </th>
                <th style="width:80px;" title="行业">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">行业</div>
                </div>
                </th>
                <th title="注册地区">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">注册地区</div>
                </div>
                </th>    
                <th style="width:70px;" title="联系次数">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">联系次数</div>
                </div>
                </th>   
                <th style="width:70px;" title="拜访次数">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">拜访次数</div>
                </div>
                </th>
                <th style="width:90px;" title="联系电话">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">联系电话</div>
                </div>
                </th>
                <th style="width:90px;" title="最后联系时间和类型">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">最后联系时间和类型</div>
                </div>
                </th> 
                <th style="width:80px;" title="录入时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">录入时间</div>
                    </div>
                </th>           					
                <th style="width:80px;" title="踢入时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">踢入时间</div>
                    </div>
                </th>
                <th style="width:60px;" title="操作">
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
<div class="list_table_foot">
<div id="divPager" class="ui_pager">
</div>
</div>
<!--E list_table_foot-->
<script language="javascript" type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script language="javascript" type="text/javascript">
 $(function(){
    
 	$("#cbProvince").BindProvinceChannel({selCityID:"cbCity",selAreaID:"cbArea",iAddPleaseSelect:true});
   	{/literal}
	pageList.strUrl = "{$HighSeasListBody}"; 
	{literal}
    
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&cbIntentionLevel="+encodeURIComponent($("#cbIntentionLevel").attr("key"));   
   	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&cbIntentionLevel="+encodeURIComponent($("#cbIntentionLevel").attr("key"));
	pageList.first();
 }
 
 
_InDealWith = false; 
function GetAgent(agentID)
{
    if(agentID == 0)
    {
        var chkID = document.getElementsByName("listid");
        var ids = "";
    	for(var i = 0;i < chkID.length;i++)
    	{
    		if(chkID[i].checked && chkID[i].disabled == false)
            {
    			ids += "," + chkID[i].value;
            }
    	}
            
    	if(ids.length > 1)
            agentID = ids.substring(1, ids.length);
        else
        {
            IM.tip.warn("请选择代理商！");
            return ;
        }
    }
     
    if (_InDealWith) 
    {
    	IM.tip.warn("数据已提交，正在处理中！");
    	return false;
    }

    _InDealWith = true;
    var backData = $PostData('/?d=Agent&c=HighSeas&a=OutSea&ids='+agentID); 
    if(parseInt(backData) == 0){
        pageList.reflash();
	    _InDealWith = false;
        IM.tip.show("拉取成功！");
	}else{
        _InDealWith = false;
        IM.tip.warn(backData);
	}
}

</script>
{/literal} 