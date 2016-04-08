<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<div class="table_filter marginBottom10">  
	<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">预约被联系人：</div>
            <div class="ui_text"><input type="text" name="tbxContactName" id="tbxContactName" value="" style="width:100px;"/></div>	                
            <div class="ui_title">客户名称：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerName" id="tbxCustomerName" value="" style="width:200px;"/></div>	                         	        	
    </div>
	<div class="table_filter_main_row">
            <div class="ui_title">预约联系时间：</div>
            <div class="ui_text">
                <input id="tbxSInviteCreateTime" type="text" class="inpCommon inpDate" name="tbxSInviteCreateTime" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxEInviteCreateTime\')}'}){/literal}"/>
                至
                <input id="tbxEInviteCreateTime" type="text" class="inpCommon inpDate" name="tbxEInviteCreateTime" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSInviteCreateTime\')}'}){/literal}"/>	
            </div>
            <div class="ui_title">联系状态：</div>
            <div class="ui_comboBox">
                <select id="cbInviteStatus" name="cbInviteStatus">
                <option value="-100">请选择</option>
                <option value="1">已完成</option>
                <option value="0">未完成</option>
                <option value="-1">作废</option>
                </select>
            </div>	
            <div class="ui_title">回访状态：</div>
            <div class="ui_comboBox">
                <select id="cbRevisitStatus" name="cbRevisitStatus">
                <option value="-100">请选择</option>
                <option value="1">已回访</option>
                <option value="0">未回访</option>
                </select>
            </div>	                                
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
</div>
<div class="list_link marginBottom10">
    <a class="ui_button " m="ContactInviteList" ispurview="true" v="4" onclick="DropInvite('')" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_text"> 作 废 </div>
    </div>
    </a>
    <a class="ui_button ui_button_dis" m="ContactInviteList" ispurview="true" v="8" onclick="DeleteInvite()" style="margin:0;" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_del"></div>
    <div class="ui_text">删除预约</div>
    </div>
    </a>

</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table" id="J_ui_table">                    	
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">
				<th style="width:30px" title="全选/反选">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">
							<input id="chkSelectAll" type="checkbox" class="checkInp" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');"/>
						</div>
                    </div>
                </th>
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">客户ID</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">预约被联系人</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系手机</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">预约联系时间</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系状态</div></div></th>   
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">制定时间</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访状态</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
    <div class="ui_pager" id="divPager">    	
    </div>
</div>
<script language="javascript" type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal}
<script language="javascript" type="text/javascript">
function ChangeIsManager()
{
    $DOM("chkIsManager").checked = !$DOM("chkIsManager").checked;
}

$(function(){    
    $.setPurview();
	{/literal}
	pageList.strUrl = "{$ContactInviteListBody}"; 
	{literal}    
	pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.init();
});


function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
    $DOM("chkSelectAll").checked = false;
}

function DeleteInvite()
{
    var chkID = document.getElementsByName("listid");
    var ids = "";
	for(var i = 0;i < chkID.length;i++)
	{
		if(chkID[i].checked == true && chkID[i].disabled == false)
        {
			ids += "," + chkID[i].value;
        }
	}
            
	if(ids.length > 1)
        ids = ids.substring(1, ids.length);
    else
    {
        IM.tip.warn("请选择预约记录！");
        return ;
    }

    if(!confirm("您确定要删除所选的预约记录吗？"))
		return false;
        
    var backData = $PostData("/?d=CM&c=ContactRecord&a=ContactInviteDel&ids="+ids);
    if(parseInt(backData) == 0)
    {
        pageList.first();
        IM.tip.show("删除成功！");
        $DOM("chkSelectAll").checked = false; 
    }
    else
    {
        IM.tip.warn(backData);
    }
}


function DropInvite(ids)
{
    if(ids == "")
    {
        var chkID = document.getElementsByName("listid");
        for(var i = 0;i < chkID.length;i++)
    	{
    		if(chkID[i].checked == true && chkID[i].disabled == false)
            {
    			ids += "," + chkID[i].value;
            }
    	}
                
    	if(ids.length > 1)
            ids = ids.substring(1, ids.length);
        else
        {
            IM.tip.warn("请选择预约记录！");
            return ;
        }
    }
    
    if(!confirm("您确定要作废所选的预约记录吗？"))
		return false;
        
    var backData = $PostData("/?d=CM&c=ContactRecord&a=ContactInviteDrop&ids="+ids);
    if(parseInt(backData) == 0)
    {
        pageList.reflash();
        IM.tip.show("操作成功！"); 
        $DOM("chkSelectAll").checked = false;
    }
    else
    {
        IM.tip.warn(backData);
    }
}

function EditInvite(id)
{
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "编辑联系预约",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=ContactInviteModify&inviteID="+id, {}, function (backData) {
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
             
             
            new Reg.vf($('#J_ContactInviteModify'),{
		     callback:function(formdata){////formdata 表单提交数据 对象数组格式
                formdata = $("#J_ContactInviteModify").serialize();
                var backData = $PostData("/?d=CM&c=ContactRecord&a=ContactInviteModifySubmit",formdata);
                if(parseInt(backData) == 0)
                {
                    IM.dialog.hide();
                    pageList.reflash();
                    IM.tip.show("编辑成功！"); 
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

</script>
{/literal}