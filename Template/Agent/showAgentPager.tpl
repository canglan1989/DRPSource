    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
    <!--E crumbs-->       
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">
                <div class="table_filter_main_row">  
                        <div class="ui_title">代理商代码：</div>
                        <div class="ui_text"><input type="text" name="tbxAgentNo" style="vertical-align:top;width:100px" id="tbxAgentNo"/></div>  		
                        <div class="ui_title">代理商名称：</div>
                        <div class="ui_text"><input type="text" name="tbxAgentName" style="vertical-align:top;width:200px" id="tbxAgentName"/></div>
                        <div class="ui_title">渠道经理姓名/工号：</div>
                        <div class="ui_text"><input class="inpCommon" type="text" name="tbxChannelName" style="vertical-align:top;" id="tbxChannelName"/></div>
                        <div class="ui_title">意向评级：</div>
                        <div style="width:100px;" id="cbIntentionLevel" data="[{literal}{'key':'A','value':'A'},{'key':'B+','value':'B+'},{'key':'B-','value':'B-'},{'key':'C','value':'C'},{'key':'D','value':'D'},{'key':'E','value':'E'}{/literal}]" value="" key="" control="agentPro" class="ui_comboBox ui_comboBox_def" onclick="IM.comboBox.init({literal}{'control':MM.A(this,'control'),data:MM.A(this,'data')}{/literal},this)">
                        <div style="width:80px;" class="ui_comboBox_text">
                        	<nobr>全部</nobr>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>                        
                    </div>
                   </div>
                   <div class="table_filter_main_row">
                        <label class="ui_title">所属行业：</label>
                        <div class="ui_comboBox" >
                            <select name="cbIndustry"  id="cbIndustry">
                            <option value="-100">请选择</option>
                            <option value="1">IT硬件</option>
                            <option value="2">传媒</option>
                            <option value="3">网络</option>
                            <option value="4">广告</option>
                            <option value="5">其他</option>
                            </select>
                        </div>
                        <div class="ui_title">注册地区：</div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="cbProvince"></select></div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="cbCity"></select></div>
                        <div class="ui_comboBox"><select id="selArea" class="area" name="cbArea"></select></div>    
                        <div class="ui_title">联系号码：</div>
                        <div class="ui_text">
                          <input style="width:100px" type="text" name="contact_no" id="contact_no"/>
                        </div>    
                        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch" onclick="QueryData()">搜索</button></div>        
                  </div>
            </div>
        </form>
        </div>
        <!--E table_filter-->
        <!--S list_link-->
        <div class="list_link marginBottom10">
            <a class="ui_button" href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='AddCheckShow'}')"  m="showAgentPager" v="4" ispurview="true"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">添加代理商</div></div></a>       
            <a m="HighSeasList" ispurview="true" v="4" class="ui_button" onclick="ToSea(0)" href="javascript:;">
                    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">踢入公海</div></div></a>                       
            <a href="javascript:;" class="ui_button" onClick="mulitPhysicsDel()" ><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">放入回收库</div></div></a>            
            <a m="showAgentPager" v="32" ispurview="true" class="ui_button ui_button_dis" href="javascript:;" onClick="IM.account.delOper('{au d='Agent' c='Agent' a='mulitDelAgent'}',{literal}{}{/literal},'彻底删除')" ><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">彻底删除</div></div></a>
            <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
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
            <th style="width:90px;" title="代理商代码">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商代码</div>
            </div>
            </th>
            <th title="代理商名称">
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
            <th style="width:150px;" title="地区">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">注册地区</div>
            </div>
            </th>              					
            <th style="width:70px;" title="负责人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">负责人</div>
            </div>
            </th>
            <th style="width:100px;" title="负责人联系方式">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">负责人联系方式</div>
            </div>
            </th> 
            <th style="width:60px;" title="电话联系次数">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系次数</div>
            </div>
            <th style="width:90px;" title="联系电话">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系电话</div>
            </div>
            <th style="width:130px;" title="渠道经理">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">渠道经理</div>
            </div>
            </th>                                  
            <th style="width:116px;"title="操作">
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
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div>
        <!--E list_table_foot-->

    
<script type="text/javascript" src="{$JS}pageCommon.js" language="javascript"></script> 
<script type="text/javascript" language="javascript">
    {literal}
 $(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
    {/literal}
	pageList.strUrl="{$strUrl}"; 
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
//放入回收库
function mulitPhysicsDel()
{    
    agentID = 0;
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

    if(!confirm("你确定要将代理商放入回收库吗？"))
		return false;
        
    if (_InDealWith) 
    {
    	IM.tip.warn("数据已提交，正在处理中！");
    	return false;
    }

    _InDealWith = true;
    var backData = $PostData('/?d=Agent&c=Agent&a=mulitPhysicsDel&listid='+agentID); 
    if(parseInt(backData) == 0){
	    _InDealWith = false;
        IM.tip.show("操作成功！");
        pageList.reflash();
	}else{
        _InDealWith = false;
        IM.tip.warn(backData);
	}
}

{/literal}
</script>    