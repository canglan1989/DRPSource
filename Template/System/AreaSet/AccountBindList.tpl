  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
    <!--S table_filter-->
	<div class="table_filter marginBottom10"> 
    <div id="J_table_filter_main" class="table_filter_main">
   <div class="table_filter_main_row">
    <div class="ui_title">账号名：</div>
    <div class="ui_text">
        <input class="ac_input" type="text" tabindex="1" maxlength="18"  id="txtaccountName" name="txtaccountName"/>
        
    </div>
    <div class="ui_button ui_button_search">
        <button class="ui_button_inner" type="button" onclick="QueryData({$id})">搜 索</button>
    </div>
</div>
   </div>
   </div>
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
        <a class="ui_button" onclick="addAccountBind({$id})"
         href="javascript:;" v="4" ispurview="true" m="AccountAreaList">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                <div class="ui_icon ui_icon_add"></div>
                <div class="ui_text">添加账号</div>
            </div>
        </a>
        <a class="ui_button" style="margin:0" onclick="Transfer({$id})" href="javascript:;" v="4" ispurview="true" m="AccountAreaList">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                <div class="ui_icon ui_icon_move"></div>
                <div class="ui_text">转移</div>
            </div>
        </a>
   </div>
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>账号组名称：{$strTitle}</h4>
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
                    	<th width="30"><div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                            
                            <input type="checkbox" class="checkInp" id="chkCheckAll" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');"/>
                            </div>
                          </div>
                        </th>
                        <th width="180" title="编号">
                        	<div class="ui_table_thcntr" sort="sort_product_no">
                            	<div class="ui_table_thtext">编号</div>
                            </div>
                        </th>
                        <th width="200" title="账号名">
                        	<div class="ui_table_thcntr" sort="sort_product_name">
                            	<div class="ui_table_thtext">账号名</div>
                            </div>
                        </th>
                        <th width="200" title="地区">
                        	<div class="ui_table_thcntr" sort="sort_product_name">
                            	<div class="ui_table_thtext">绑定的区域组</div>
                            </div>
                        </th>
                        <th width="120"  title="操作">
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
    <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
  </div>         
    <!--S list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
     {/literal}
	pageList.strUrl="{$AccountBindBody}"; 
   
    pageList.param = "&id="+{$id};
    {literal}
    
	pageList.init();
});
function RemoveBind(id){
    $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=System&c=AccountArea&a=RemoveBind&id="+id,//移除的用户ID
                    data: "",
                    success: function (q) {
                        q=MM.json(q);
                         if(q.success)
                    		{
              		            pageList.reflash();
				                IM.tip.show(q.msg);
                                IM.dialog.hide();
                                
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                                //IM.dialog.hide();
                                //pageList.reflash();
                            }                        
                    }
                });
}

function GetLowLevelArray(nowaccountid)//取得2级账号组————传id
{
    var id = $("#cbAccountGroupName1").val();//获取选中项内容
    var cbAccountGroupName2 = $DOM("cbAccountGroupName2");
    
    var lowJson = $PostData("/?d=System&c=AccountArea&a=GetLowLevelArray","id="+id+"&nowaccountid="+nowaccountid);
    //alert(lowJson);
    var jsonObj = eval("(" + lowJson + ")");
    var jsonObjLength = jsonObj.length;
    
    while(cbAccountGroupName2.options.length > 0)
        cbAccountGroupName2.options[0] = null;
    cbAccountGroupName2.options[0] = new Option("=二级账号组=", "-100");    
    for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {            
        cbAccountGroupName2.options[cbAccountGroupName2.options.length] = new Option(jsonObj[cIndex].Name, jsonObj[cIndex].id);
    }  
    
    GetLowLevel3Array(nowaccountid);      
}

function GetLowLevel3Array(nowaccountid)//取得3级账号组————id
{
    var id = $("#cbAccountGroupName2").val();//获取选中项内容
    //alert(id);
    var cbAccountGroupName3 = $DOM("cbAccountGroupName3");
    
    var lowJson = $PostData("/?d=System&c=AccountArea&a=GetLowLevelArray","id="+id+"&nowaccountid="+nowaccountid);
    //alert(lowJson+"aa");
    var jsonObj = eval("(" + lowJson + ")");
    var jsonObjLength = jsonObj.length;
    
    while(cbAccountGroupName3.options.length > 0)
        cbAccountGroupName3.options[0] = null;
    cbAccountGroupName3.options[0] = new Option("=三级账号组=", "-100");      
    for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {            
        cbAccountGroupName3.options[cbAccountGroupName3.options.length] = new Option(jsonObj[cIndex].Name, jsonObj[cIndex].id);
    }  
}

function Transfer(id){//转移绑定的账号
        IM.dialog.show({
            width: 600,
    	    height: null,
    	    title: "转移账号",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=System&c=AccountArea&a=ShowTransfer&id="+id, {}, function (backData) {
    		  
    		    $('.DCont')[0].innerHTML = backData;
                var chkarea = document.getElementsByName("chkCheck");
        		var area = "";      
        		for(var i = 0;i < chkarea.length;i++)
        		{
        			if(chkarea[i].checked)
                    {
        				area += "," + chkarea[i].value;
                        //alert(chkarea[i].value);
                    }
        		}
        		if(area.length > 1)
        			area = area.substring(1, area.length);
                GetLowLevelArray();
                
                new Reg.vf($('#J_AccountTransfer'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                var formValues = $('#J_AccountTransfer').serialize()+"&area="+area;
                //alert(formValues);
             $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=System&c=AccountArea&a=AccountTransferSubmit&id="+id,
                    data: formValues,
                    success: function (q) {
                        q=MM.json(q);
                        
                         if(q.success)
                    		{
              		            pageList.reflash();
				                IM.tip.show(q.msg);
                                IM.dialog.hide();
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                                //IM.dialog.hide();
                                //pageList.reflash();
                            }                       
                    }
                });

                
            }});
                
                });
          }
    });
    }
function addAccountBind(id){
        var _data = id;   
        IM.dialog.show({
            width: 500,
    	    height: null,
    	    title: "新增账号绑定",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=System&c=AccountArea&a=AccountBindNew&id="+id, {}, function (backData) {
    		    $('.DCont')[0].innerHTML = backData;
                //=================账户模糊匹配begin============//
               $('#accountName').autocomplete('/?d=System&c=AccountArea&a=CompleteUser&id='+id, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 15, //只显示15行
                width: 150, //下拉列表的宽
                parse: function (Data) {//q 返回的数据 JSON 格式，在这里解析成列表
                    /*
                    {"value":[{"id":"100","name":"\u9a6c\u6b63\u6770"},
                    {"id":"200","name":"\u9ebb\u5409"},{"id":"300","name":"Marshane"}]}
                    */
                    
                    var parsed = [];
                    if (Data == "" || Data.length == 0)
                        return parsed;
                    //alert(backData);
                    Data = MM.json(Data);
                    var value = Data.value;
                    //alert(value);
                    if (value == undefined)
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
                    //_id=item.id;
                    return "<div id='divUser" + item.id + "'>" + item.name + "</div>";
                }
            }).result(function (data, value) {//执行模糊匹配
                _id = value.id;
               
                $("#tbxEmpID").val(_id);
                var val = $(this).val();
            });
            //==================账户模糊匹配end=============//
                new Reg.vf($('#J_newAccount'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                
                //var formValues = $('#J_newAccount').serialize();
                //alert(formValues);
		
             $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=System&c=AccountArea&a=DoAccountBindNew&id="+id,//id为账号组id
                    data: formdata,
                    success: function (q) {
                        q=MM.json(q);
                        
                         if(q.success)
                    		{
              		            pageList.reflash();
				                IM.tip.show(q.msg);
                                IM.dialog.hide();
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                                //IM.dialog.hide();
                                //pageList.reflash();
                            }     
                                       
                    }
                });

                
            }});
                
                });
          }
    });
    }
  function  QueryData(id)
  {
    var txtaccountName = $('#txtaccountName').val();
    txtaccountName = encodeURIComponent(txtaccountName);
    pageList.param = "&txtaccountName="+txtaccountName+"&id="+id;//用GET接收
    pageList.first();
    
  }

  function SelectAreaGroup()
 {
    var level = $("#cbAreaGroupName1").val();//获取选中项内容
    var acc_uid = $("#acc_uid").val();
    var account_group_id = $("#account_group_id").val();
    var jsonObj = $PostData("/?d=System&c=AccountArea&a=GetGroupAreaJson&level="+level,"account_group_id="+account_group_id+"&acc_uid="+acc_uid);
    jsonObj = eval(jsonObj);
    var strHtml = "<label>区域组：</label><div class='inp'><ul class='allGroupBlock'>";
    var jsonObjLength = jsonObj.length;
    for (var d = 0; d < jsonObjLength; d++) {
        
        var id = jsonObj[d].id;
        var name = jsonObj[d].Name;
                strHtml += "<li><input class='checkInp' type='checkbox' name='chkCheck' "+
                (parseInt(jsonObj[d].is_check) == 1 ? "checked='checked'" : "")+" value='"
            + id +"'/>"+ name +"</li>";
      
        if((d+1)%4==0)
            strHtml += "</ul><ul class='allGroupBlock'>";
            
    }
    strHtml += "</div>";
    $("#divArea").html(strHtml);
    
 }
    </script>
{/literal}