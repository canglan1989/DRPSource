<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">客户名称：</div>
                <div class="ui_text"><input class="" type="text" name="customer_name" style="vertical-align:top;width:200px;"/></div>
                <div class="ui_title">录入人：</div>
                <div class="ui_text"><input type="text" class="inpCommon inputer" id = "user_name" name="user_name"/></div>

                <div class="ui_title">录入/注册时间：</div>
                <div class="ui_text"  id = "createTime">
                    <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="create_time_begin" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/> 至
                    <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="create_time_end" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>
                </div>
                <div class="ui_title">行业分类：</div>
                <div class="ui_comboBox" name = "industryId" id = "industryId">
                    <select id="industry_pid" name="industry_pid"></select>
                    <select id="industry_id" name="industry_id"></select>
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">来源：</div>
                <div class="ui_comboBox" >
                    <select name="customer_resource" id="customer_resource">
                        <option value="0" selected="">全部</option>
                        <option value="1">注册</option>
                        <option value="2">录入</option>
                    </select>
                </div>  
                <div class="ui_title">地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" name="selProvince" class="pri" name="selProvince"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="selCity" tabindex="3"></select></div>
                <div class="ui_comboBox"><select id="area_id" class="area" name="area_id"></select></div>
                <div class="ui_title">所属代理商：</div>
                <div class="ui_text"><input type="text" class="inpCommon" id = "agent_name" name="agent_name"/></div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a m='showBackInfoList' v="4" ispurview="true" class="ui_button" onclick="JumpPage('{au d="CM" c="CMInfo" a="showInsertBack"}')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">客户录入</div></div></a>
<!--    <a m='showBackInfoList' v="512" ispurview="true" class="ui_button" href="javascript:;" onClick="showTransfer()" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">客户转移</div></div></a>-->
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
<!--                    <th title="全选/反选" style="width:30px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    <input onClick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" class="checkInp" type="checkbox" />
                </div>
            </div>
            </th>-->
            <th style="width:80px;" title="客户ID">
            <div class="ui_table_thcntr" sort="sort_customer_id">
                <div class="ui_table_thtext">客户ID</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="" title="客户名称">
            <div class="ui_table_thcntr" sort="sort_customer_name">
                <div class="ui_table_thtext">客户名称</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th title="行业">
            <div class="ui_table_thcntr" sort="sort_industry_fullname">
                <div class="ui_table_thtext">行业</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="" title="地区">
            <div class="ui_table_thcntr" sort="sort_area_fullname">
                <div class="ui_table_thtext">地区</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:90px" title="所属代理商">
            <div class="ui_table_thcntr" sort="sort_agent_name">
                <div class="ui_table_thtext">所属代理商</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:40px" title="来源">
            <div class="ui_table_thcntr" sort="sort_customer_resource">
                <div class="ui_table_thtext">来源</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:80px;" title="审核状态">
            <div class="ui_table_thcntr" sort="sort_check_status_name">
                <div class="ui_table_thtext">审核状态</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:130px;" title="录入时间">
            <div class="ui_table_thcntr" sort="sort_create_time">
                <div class="ui_table_thtext">录入时间</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:120px" title="录入人">
            <div class="ui_table_thcntr" sort="sort_user_name">
                <div class="ui_table_thtext">录入人</div><div class="ui_table_thsort"></div>
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
    <div id="divPager" class="ui_pager"></div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
<script type="text/javascript">
    {literal}
	$(function(){
        $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:true});
        $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
    {/literal}
    	pageList.strUrl="{$strUrl}";
    {literal}
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
	});
     function QueryData()
     {
    	pageList.param = '&'+$("#tableFilterForm").serialize();
    	pageList.first();
     }
    function showTransfer(customerid)
    {
      //  var listid = IM.table.getListID();
//        if(listid.length > 0)listid.join(",")
//        {
             JumpPage('/?d=CM&c=CMTransfer&a=showTransfer&customer_ids='+customerid);     
//        }
//        else
//        {
//            IM.tip.warn('请选择要转移的客户');
//        }
    }
        
     function showCheckStatus(customerid){
         IM.dialog.show({
            width:500,           
            title:'审核状态查询',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMVerify&a=showCustomerCheckPageByCustomerID&customerid="+customerid,""));
            }
         })
    }
    {/literal}
</script>