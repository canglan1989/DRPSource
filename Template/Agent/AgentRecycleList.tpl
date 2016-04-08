<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商资料管理<span>&gt;</span>回收库</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">   		
            <div class="table_filter_main_row">   		
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input class="inpCommon" type="text" name="agent_name" id="agent_name" style="vertical-align:top;"/></div>
                <div class="ui_title">注册地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="pri"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="city"></select></div>
                <div class="ui_comboBox"><select id="selArea" class="area" name="area"></select></div>	  
                <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="searchAgent('-1')" type="button">搜索</button></div>              
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button" href="javascript:;" m="showRecyclePager" v="8" ispurview="true"  onClick="IM.agent.recyAgentMove('{au d=Agent c=AgentMove a=recyMoveShow}',{literal}{}{/literal},'转移代理商')" ><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">转移代理商</div></div></a>
    <a m="showRecyclePager" ispurview="true" v="1024" class="ui_button" onclick="ToSea(0)" href="javascript:;">
                    <div class="ui_button_left"></div><div class="ui_button_inner">
                        <div class="ui_text">踢入公海</div></div></a>
    <a class="ui_button ui_button_dis" href="javascript:;" m="showRecyclePager" v="4" ispurview="true"  onClick="IM.account.delOper('{au d='Agent' c='Agent' a='mulitDelAgent'}',{literal}{}{/literal},'批量删除代理商')" style="margin:0;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">批量删除</div></div></a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>代理商列表</h4>
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
                    <th style="width:30px" title="全选/反选">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext"><input class="checkInp" type="checkbox" onClick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');"></div>
            </div>
            </th>
            <th style="width:80px;" title="编号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th style="" title="单位名称">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">单位名称</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th title="地区">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">地区</div>
            </div>
            </th>                				
            <th style="width:100px;" title="负责人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">负责人</div>
            </div>
            </th>
            <th style="width:100px;" title="联系方式">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系方式</div>
            </div>
            </th>
            <th style="width:130px;" title="审核时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">审核时间</div>
            </div>
            </th>

            <th style="width:130px" title="录入\编辑时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">录入\编辑时间</div>
            </div>
            </th>
            <th style="width:60px;" title="操作">
            <div class="ui_table_thcntr ">
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
    <div id="divPager" class="ui_pager">
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
<script type="text/javascript">
    {literal}
 $(document).ready(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
    {/literal}
	pageList.strUrl="{$strUrl}"; 
    {literal}
	pageList.init();
 });
 function searchAgent(type)
 {
	var agentName = $.trim($('#agent_name').val());
	var provinceId = $('#selProvince').val();
	var cityId = $('#selCity').val();
	var areaId = $('#selArea').val();
	pageList.page = 1;
	pageList.param = '&agentName='+encodeURIComponent(agentName)+'&provinceId='+provinceId+'&cityId='+cityId+'&areaId='+areaId+'&type='+type;
	pageList.first();
 }
 
 
_InDealWith = false;
 function ToSea(agentID)
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

    if(!confirm("你确定要将代理商踢入公海吗？"))
		return false;
        
    if (_InDealWith) 
    {
    	IM.tip.warn("数据已提交，正在处理中！");
    	return false;
    }

    _InDealWith = true;
    var backData = $PostData('/?d=Agent&c=HighSeas&a=InSea&ids='+agentID); 
    if(parseInt(backData) == 0){
        pageList.reflash();
	    _InDealWith = false;
        IM.tip.show("操作成功！");
	}else{
        _InDealWith = false;
        IM.tip.warn(backData);
	}
 }
    {/literal}
</script>    