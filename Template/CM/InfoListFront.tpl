<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<div class="table_attention marginBottom10">
    <label>温馨提示：
        电话客户可保留{$ProtectTel}天；
        未添加联系的自录客户可保留{$ProtectSelfNo}天；
        未添加联系的保护客户可保留{$ProtectDefendNo}天；<br />
        距离上一次添加联系小记的自录客户可保留{$ProtectSelfHas}天；
        距离上一次添加联系小记的保护客户可保留{$ProtextDefendHas}天；
        正式客户可保留{$ProtectFormat}天</label>
</div>  
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">客户名称：</div>
                <div class="ui_text"><input class="" type="text" name="customer_name" style="vertical-align:top;width:200px;"/></div>
                <div class="ui_title">网盟意向等级：</div>
                {literal}
                    <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({'control':'IntentionRating',data:MM.A(this,'data')},this)" 
                    {/literal}
                    class="ui_comboBox ui_comboBox_def" key="{$rating_id}" value="{$rating_text}" control="IntentionRating" data="{$strIntentionRatingJson}" style="width:100px;">
                    <div class="ui_comboBox_text" style="width:80px;">
                        {if $rating_id != ""}
                            <nobr>{$rating_text}</nobr>
                        {else}
                            <nobr>全部</nobr>
                        {/if}
                    </div>
                    <div class="ui_icon ui_icon_comboBox"></div>                        
                </div>
                <div class="ui_title">审核状态：</div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select id="selcheck_status" name="check_status">
                        <option value="99">全部</option>
                        <option value='0'>审核中</option>
                        <option value="1">审核通过</option>
                        <option value="-1">审核不通过</option>
                    </select>    
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">最近联系时间：</div>
                <div class="ui_text"  id = "createTime">{literal}
                    <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="create_time_begin" onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})"/> 至
                    <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="create_time_end" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})"/>{/literal}
                </div>
                <div class="ui_title">行业分类：</div>
                <div class="ui_comboBox" name = "industryId" id = "industryId">
                    <select id="industry_pid" name="industry_pid"></select>
                    <select id="industry_id" name="industry_id"></select>
                </div>
                <div class="ui_title">来源：</div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select id="selcheck_resource" name="person_resource">
                        <option value="0">全部</option>
                        <option value='1'>上级分配</option>
                        <option value="2">录入</option>
                        <option value="3">拉取</option>
                    </select>    
                </div>
            </div>
            <div class="table_filter_main_row">    
                <div class="ui_title">地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" name="selProvince" class="pri" name="selProvince"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="selCity" tabindex="3"></select></div>
                <div class="ui_comboBox"><select id="area_id" class="area" name="area_id"></select></div>

                <div class="ui_title">保护类型：</div>
                <div class="ui_text">
                    <select name="defend_state" >
                        <option value="0">全部</option>
                        <option value="1">电话客户</option>
                        <option value="2">保护客户</option>
                        <option value="3">自录客户</option>
                        <option value="4">正式客户</option>
                    </select>
                </div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>                   
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="JumpPage('/?d=CM&c=CMInfo&a=showInsertFront')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">客户录入</div></div></a>
    <!--    <a class="ui_button" onClick="IM.customer.customerMove2()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">客户转移</div></div></a>-->
    <a class="ui_button" onClick="ToSea()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">踢入公海</div></div></a>
    <a class="ui_button" onClick="SetProtect()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">设为保护</div></div></a>
    <a class="ui_button ui_button_dis" href="javascript:;" onClick="DelCustomer()"  style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">删除</div></div></a>  
<!--     <a class="ui_button ui_button_dis" href="javascript:;" onClick="IM.account.delOper('{au d='CM' c='CMInfo' a='delFrontClient'}',{literal}{}{/literal},'客户删除',null,250,null,false)"  style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">删除</div></div></a>  -->
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
                <tr>
                    <th title="全选/反选" style="width:30px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    <input onClick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" class="checkInp" type="checkbox"/>
                </div>
            </div>
            </th>
            <th style="width:50px;" title="客户ID">
            <div class="ui_table_thcntr" sort="sort_customer_id">
                <div class="ui_table_thtext">客户ID</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th  title="客户名称">
            <div class="ui_table_thcntr" sort="sort_customer_name">
                <div class="ui_table_thtext">客户名称</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th  title="行业">
            <div class="ui_table_thcntr" sort="sort_industry_name">
                <div class="ui_table_thtext">行业</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th  title="地区">
            <div class="ui_table_thcntr" sort="sort_area_name">
                <div class="ui_table_thtext">地区</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <!--客户来源来另外的一张表cm_customer_agent里面 -->
            <th style="width:40px;" title="来源">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">来源</div>
            </div>
            </th>

            <th style="width:50px;" title="审核状态">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">审核状态</div>
            </div>
            </th>
             <th style="width:40px;" title="联系小记次数">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系次数</div>
            </div>
            </th>   
            <th style="width:60px;"  title="保护剩余时间(单位：分)">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.to_sea_time">
                <div class="ui_table_thtext">保护剩余时长</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:60px;" title="保护类型">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.defend_state">
                <div class="ui_table_thtext">保护类型</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:50px;" title="网盟意向评级">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.intention_rating">
                <div class="ui_table_thtext">网盟意向评级</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th style="width:80px;" title="最近联系时间">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.last_record_time">
                <div class="ui_table_thtext">最近联系时间</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th  title="最近联系内容">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">最近联系内容</div>
            </div>
            </th>

            <th width="106" title="操作">
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
<div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
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
	pageList.param = "&"+$('#tableFilterForm').serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
	pageList.init();
});

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.first();
}
    
function ToSea(){
    var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择客户");
            return false;
    }
    CustomerID =CustomerIDs.join(',');
    IM.dialog.show({
            width: 400,
    	    height: null,
    	    title: "踢入公海",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=CM&c=CMPublicPool&a=showToSeaPage", {}, function (backData) {
    			$('.DCont')[0].innerHTML = backData;
                	new Reg.vf($('#J_newBankAccount'),{isEncode:false,
                            extValid:{
                                selected:function(){
                                    return MM.getVal(MM.G('sheldtime')).text!='请选择';
                                }
                            },
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式
                	var formValues = $('#J_newBankAccount').serialize();                
                 	$.ajax({
	                        type: "POST",
	                        dataType: "text",
	                        url: "/?d=CM&c=CMPublicPool&a=ToSeaPage&customerlist="+CustomerID,
	                        data: formValues,
	                        success: function (q) {
					q=MM.json(q);
					if(q.success){
						IM.tip.show(q.msg);
                                                IM.dialog.hide();
                                                pageList.reflash();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
            });
      
       }});
}
    
function DelCustomer(){
    var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择客户");
            return false;
    }
    CustomerID =CustomerIDs.join(',');
    IM.dialog.show({
            width: 600,
    	    height: null,
    	    title: "删除客户",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=CM&c=CMInfo&a=showDelFrontClient", {}, function (backData) {
    			$('.DCont')[0].innerHTML = backData;
                	new Reg.vf($('#J_newBankAccount'),{
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式              
                 	$.ajax({
	                        type: "POST",
	                        dataType: "text",
	                        url: "/?d=CM&c=CMInfo&a=delFrontClient",
	                        data: {
                                    'customerids':CustomerID,
                                    'delreason':$("#del_reason").val()
                                },
	                        success: function (q) {
					q=MM.json(q);
					if(q.success){
						IM.tip.show(q.msg);
                                                IM.dialog.hide();
                                                pageList.reflash();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
            });
      
       }});
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
        
function SetProtect(){
   var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择客户");
            return false;
    }
    $.ajax({
        url:"/?d=CM&c=CMInfo&a=setProtect",
        data:{
            'customerid':CustomerIDs.join(',')
        },
        dataType:"json",
        type:"post",
        success:function(data){
            if(data.success){
                IM.tip.show(data.msg);
                                                IM.dialog.hide();
                                                pageList.reflash();
					}else{
						IM.tip.warn(data.msg);
					}
        },
        error:function(){
            IM.tip.warn("设置保护出错");
        }
});
}

function showAddContactRecode(customer_id){
    JumpPage("/?d=CM&c=ContactRecord&a=ContactRecodeModify&customerID="+customer_id);
}


function showAddVisitInvite(customer_id){
     IM.dialog.show({
        width: 600,
	    height: null,
	    title: "添加拜访预约",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=VisitRecord&a=VisitInviteModify&customerID="+customer_id, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
                                                                    
            $('#tbxInviteContactName').autocomplete('/?d=CM&c=CMInfo&a=getContactName_ID&customer_id='+$("#tbxCustomerID").val(), {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 5, //只显示5行
                width: 160, //下拉列表的宽
                parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
                    var parsed = [];
                    if(backData == "" || backData.length == 0)
                        return parsed;                                
                    backData = MM.json(backData);
                    var value = backData.value;
                    if(value == undefined)
                         return parsed;
                    for (var i = 0; i < value.length; i++) {
                        parsed[parsed.length] = {
                            data: value[i],
                            value: value[i].id,
                            result: value[i].name
                        }
                    }
                    return parsed;
                },
                formatItem: function (item) {//内部方法生成列表
                    return '<div>'+item.name + '</div>';
                }
            }).result(function (data,value) {//执行模糊匹配
            
                var contactID = value.id;
                var returnData = $PostData("/?d=CM&c=ContactRecord&a=GetContactInfo&contactID="+contactID+"&customerID="+$("#tbxCustomerID").val());
                if(returnData != "")
                {
                    var jsonObj = MM.json(returnData);
                    $("#tbxInviteContactName").val(jsonObj.contact_name);
                    $("#tbxInviteContactMobile").val(jsonObj.contact_mobile);
                    $("#tbxInviteContactTel").val(jsonObj.contact_tel);      
                }
                
            });                    
             
             
            new Reg.vf($('#J_VisitInviteModify'),{
		     callback:function(formdata){////formdata 表单提交数据 对象数组格式
                formdata = $("#J_VisitInviteModify").serialize();
                var backData = $PostData("/?d=CM&c=VisitRecord&a=VisitInviteModifySubmit",formdata);
                if(parseInt(backData) == 0)
                {
                    IM.dialog.hide();
                    IM.tip.show("添加成功！"); 
                }
                else
                {
                    IM.tip.warn(backData);
                }
          
	            }});
            
            });
      }
});

}

    {/literal}
</script>