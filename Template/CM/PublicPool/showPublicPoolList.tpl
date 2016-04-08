<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">  		
            <div class="table_filter_main_row">
                <div class="ui_title">客户名称：</div>
                <div class="ui_text">
                    <input type="text" value="" name="customerName" />
                </div>
                <div class="ui_title">地区：</div>
                <div class="ui_comboBox"><select id="selProvince" class="pri" name="pri"><option value="-1">省份</option></select>
<select id="selCity" class="city" name="city"><option value="-1">市</option></select>
<select id="area_id" class="area" name="area"><option value="-1">区/县</option></select></div>
                <div class="ui_title">来源：</div>
                <div class="ui_comboBox">
                    <select name="source">
                        <option value="-1">请选择</option>
                        <option value="6">导入</option>
                        <option value="5">录入</option>
                        <option value="4">厂商分配</option>
                    </select>
                </div>
                <div class="ui_title">行业：</div>
                <div class="ui_comboBox" name = "industryId" id = "industryId">
<select id="industry_pid" name="industry_pid"></select>
<select id="industry_id" name="industry_id"></select></div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">购买的产品：</div>
            {literal}
			<div id="ui_comboBox_agentPro" onclick="IM.comboBox.init({'control':'Pro',data:MM.A(this,'data')},this)" 
            {/literal}
             class="ui_comboBox ui_comboBox_def" key="{$qProductTypeIDs}" value="{$qProductTypeNames}" control="Pro" data="{$strProductTypeJson}" style="width:100px;">
             <div class="ui_comboBox_text" style="width:80px;">
                    {if $qProductTypeNames == ""}
                	<nobr>请选择</nobr>
                    {else}
                	<nobr>{$qProductTypeNames}</nobr>
                    {/if}
                </div>
                <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>
                <div class="ui_title">是否购买产品：</div>
                <div class="ui_comboBox"><select name="is_buy">
                        <option value="0">请选择</option>
                        <option value="1">是</option>
                        <option value="2">否</option>
                    </select></div>
                <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="search();">搜 索</button></div>	
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button " m="PublicPoolManager" ispurview="true" v="8"  href="javascript:;" onClick="DefendCustomer(0)"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">批量拉取</div></div></a>	
<!--    <a class="ui_button " m="PublicPoolManager" ispurview="true" v="4" href="javascript:;" onClick='JumpPage("{au d="CM" c="CMPublicPool" a="showExcelAdd"}")'><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div><div class="ui_text">导入客户</div></div></a>-->
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
                    <th style="width:30px" title="全选/反选">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    <input type="checkbox" class="checkInp" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" />
                </div>
            </div>
            </th>
            <th title="客户ID" style="width:50px;">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">客户ID</div>
            </div>
            </th>
            <th title="客户名称" style="">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">客户名称</div>
                <!--                <div class="ui_table_thsort"></div>-->
            </div>
            </th>
            <th title="行业">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">行业</div>
            </div>
            </th>                					
            <th title="地区">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">地区</div>
            </div>
            </th>
            <th title="录入时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">来源</div>
            </div>
            </th>
            <th title="来源">
            <div class="ui_table_thcntr" sort="sort_cm_customer.create_time">
                <div class="ui_table_thtext">录入时间</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th title="联系小记次数">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.record_count">
                <div class="ui_table_thtext">联系小记次数</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th title="最后联系时间">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.last_record_time">
                <div class="ui_table_thtext">最后联系时间</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th title="最后踢出时间">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.last_to_sea_time">
                <div class="ui_table_thtext">最后踢出时间</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th title="购买的产品">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">购买的产品</div>
            </div>
            </th>
            <th title="操作">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>
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
    <div id="divPager" class="ui_pager">

    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
<script>
    var DefendUrl = '{au d="CM" c="CMPublicPool" a="DefendCustomer"}';
    {literal}
$(document).ready(function(){
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:false,iAddPleaseSelect:true});
     $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
    pageList.strUrl={/literal}"{$BodyUrl}"{literal};    
    pageList.param = "&"+$("#tableFilterForm").serialize()+"&productTypeIDs="+$("#ui_comboBox_agentPro").attr("key");
    pageList.init();    
});
    
function search(){
    pageList.param = "&"+$("#tableFilterForm").serialize()+"&productTypeIDs="+$("#ui_comboBox_agentPro").attr("key");
    pageList.first();
}
    
function DefendCustomer(CustomerID){
if(CustomerID == 0){
var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择批量拉取的数据");
            return false;
    }
      CustomerID =CustomerIDs.join(',');
          }

    $.ajax({
        url:DefendUrl,
        type:"post",
        dataType:"json",
        data:{
            customerid:CustomerID
        },
        success:function(data){
            if(data.success){
                IM.tip.show(data.msg);
                pageList.reflash();
            }else{
                IM.tip.warn(data.msg);
            }
        },
        error:function(){
            IM.tip.warn("系统出错");
        }
});
}
    
    {/literal}
</script>