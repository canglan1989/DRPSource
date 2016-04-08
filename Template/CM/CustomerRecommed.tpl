<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">  		
            <div class="table_filter_main_row">
                <div class="ui_title">客户名称：</div>
                <div class="ui_text">
                    <input type="text" value="" name="customerName">
                </div>
                <div class="ui_title">录入时间：</div>
                {literal}<div class="ui_text">
                        <input id="J_editTimeS" class="inpCommon inpDate" type="text" name="editTimeS" onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})">
                        至
                        <input id="J_editTimeE" class="inpCommon inpDate" type="text" name="editTimeE" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})">
                    </div>{/literal}
                    <div class="ui_title">行业分类：</div>
                    <div id="industryId" name="industryId" class="ui_comboBox">
                        <select name="industry_pid" id="industry_pid"><option value="-1">一级分类</option></select>
                        <select name="industry_id" id="industry_id"><option value="-1">二级分类</option></select>
                    </div>
                </div>
                <div class="table_filter_main_row">
                    <div class="ui_title">地区：</div>
                    <div class="ui_comboBox"><select id="selProvince1" class="pri" name="pri"><option value="-1">省份</option></select></div>
                    <div class="ui_comboBox"><select id="selCity1" class="city" name="city"><option value="-1">市</option></select></div>
                    <div class="ui_comboBox"><select id="area_id1" class="area" name="area"><option value="-1">区/县</option></select></div>
                  
                   <div class="ui_title">意向产品：</div>
                    <!--获取 key 值 -->
                    {literal}
	                <div id="ui_comboBox_intentionPro" onclick="IM.comboBox.init({'control':MM.A(this,'control'),data:MM.A(this,'data')},this)" class="ui_comboBox ui_comboBox_def" control="intentionPro" key="" value="" data={/literal}'{$arrJsonType}'{literal} style="width:120px;">
                    {/literal}
                        <div class="ui_comboBox_text" style="width:100px;">
                        	<nobr>请选择</nobr>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>                        
                    </div>         
                <div class="ui_title">来源：</div>
                <div class="ui_comboBox">
                    <select class="pri" name="source">
                        <option value="0">全部</option>
                        <option value="3">自动注册</option>
                        <option value="4">厂商推荐</option>
                    </select>
                </div>
                <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="search();">搜 索</button></div>	
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button " href="javascript:;" onClick="IM.customer.customerMove3('','','客户转移')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">客户转移</div></div></a>
    <a class="ui_button ui_button_dis" href="javascript:;" style="margin:0;" onclick="IM.account.delOper('{au d=CM c=CMInfo a=delFrontClient1}','','批量删除客户')">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_del"></div>
            <div class="ui_text">删除</div>
        </div>
    </a>		
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
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
                    <input type="checkbox" class="checkInp" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');">
                </div>
            </div>
            </th>
            <th title="客户ID" style="width:80px;">
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
                <div class="ui_table_thtext">录入时间</div>
            </div>
            </th>
            <th title="来源">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">来源</div>
            </div>
            </th>
            <th title="产品">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">意向产品</div>
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
<script>
var area_id="{$area_id}";//地区
var city_id="{$city_id}";//城市
var province_id="{$province_id}";//省市
    {literal}
$(document).ready(function(){
   /* $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
    */
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:false,area_id:area_id,city_id:city_id,province_id:province_id,iAddPleaseSelect:true});
    $("#selProvince1").BindProvince({iAll:"true",selCityID:"selCity1",selAreaID:"area_id1",iAddPleaseSelect:false,area_id:area_id,city_id:city_id,province_id:province_id,iAddPleaseSelect:true});
    $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
    
    pageList.strUrl={/literal}"{$strUrl}"{literal};
    var product = $.trim(MM.A(MM.G('ui_comboBox_intentionPro'),'value'));
    
    pageList.param = "&"+$("#tableFilterForm").serialize()+'&pro='+product;
    pageList.init();
    
});
    
function search(){
    var A = $("#J_editTimeS").val();
    var B = $("#J_editTimeE").val();
    
    if (A !="" && B ==""){
    	IM.tip.warn("请输入截止时间");
    	return;
    }
    if (A =="" && B !=""){
    	IM.tip.warn("请输入起始时间");
    	return;
    }
    
    var product = $.trim(MM.A(MM.G('ui_comboBox_intentionPro'),'key'));
    pageList.param = "&"+$("#tableFilterForm").serialize()+'&pro='+product;
    pageList.first();
}
/*
function ()
{
    
    
    if (A =="" && B !="") 	IM.tip.show("sasdasdasd");
    $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=CM&c=CMInfo&a=showCustomerRecommendBody",
                    data: formValues,
                    success: function (q) {
            			q=MM.json(q);
            			if(q.success){				
            				pageList.reflash();
            				IM.tip.show(q.msg);
                            IM.dialog.hide();
            			}else{
            				IM.tip.warn(q.msg);
                            }  
                                }
                            });
}*/
    {/literal}
</script>