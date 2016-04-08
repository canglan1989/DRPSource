<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text">
          <input type="text" maxlength="32" style="vertical-align:top;width150px;" name="tbxAgentNo" id="tbxAgentNo"/>
        </div>
        <div class="ui_title">代理商名称：</div>
        <div class="ui_comboBox">
          <input type="text" maxlength="32" style="vertical-align:top;width:220px;" name="tbxAgentName" id="tbxAgentName"/>
        </div>
        <!--<div class="ui_title">模板类型：</div>
        <div class="ui_text">
          <div class="ui_comboBox" style="margin-right:5px;">
            <select id="mtype" class="pri" name="mtype">
              <option value="-100" selected="selected">全部</option>
              <option value="0">代理价模板</option>
              <option value="1">促销价模板</option>
            </select>
          </div>
        </div>
      </div>
      <div class="table_filter_main_row">
        <div class="ui_title">模板名称：</div>
        <div class="ui_text">
          <input class="inpCommon accountName" type="text" maxlength="32" style="vertical-align:top;" name="texmodelName" id="texmodelName"/>
        </div>-->
        <div class="ui_button ui_button_search">
          <button class="ui_button_inner" type="button" onclick="QueryData()">搜 索</button>
        </div>
      </div>
    </div>
  </form>
</div>
<!--E list_link--> 
<!--S list_table_head-->
<div class="list_table_head">
  <div class="list_table_head_right">
    <div class="list_table_head_mid">
      <h4 class="list_table_title"> <span class="ui_icon list_table_title_icon"></span> {$strTitle} </h4>
      <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> </div>
  </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
  <div id="J_ui_table" class="ui_table">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <thead class="ui_table_hd">
        <tr>
          <th width="90" class="TA_l"><div class="ui_table_thcntr" sort="sort_agent_no">
              <div class="ui_table_thtext">代理商代码</div>
            </div></th>
          <th width="190" class="TA_l"><div class="ui_table_thcntr" sort="sort_convert(agent_name using gb2312)">
              <div class="ui_table_thtext">代理商名称</div>
            </div></th>
          <th class="TA_l"><div class="ui_table_thcntr">
              <div class="ui_table_thtext">返点百分比 </div>
            </div></th>
          <th width="130"> <div class="ui_table_thcntr ">
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
  <div class="ui_pager" id="divPager"> </div>
</div>
<!--E list_table_foot--> 
<!--E sidenav_neighbour--> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
{literal} 
<script language="javascript" type="text/javascript">
 $(function(){
    {/literal}
	pageList.strUrl="{$UnitSaleRewardModelListBody}"; 
	{literal}
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
});

function QueryData()
{
    pageList.page = 1;
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.first();
}

function modifyAgentModel(id,agent_id,product_id)//agent_model_id
{
    IM.dialog.show({
         width: 700,
    	    height: null,
    	    title: '设置价格',
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    	       MM.get("/?d=System&c=AgentModelQuery&a=ShowModifyAgentModel&id="+id+"&agent_id="+agent_id+"&product_id="+product_id, {}, function (backData) {
    	       
    	       $('.DCont')[0].innerHTML = backData;
               
               CheckModelName(document.getElementById("txtmodel_name"));                    
               CheckModelName(document.getElementById("txtpromModel")); 
               //=================代理商模板模糊匹配begin============//
		try{
                	IM.AmountHandler($('#txtprom_price')[0]);
			IM.AmountHandler($('#txtagent_price')[0]);
		}catch(e){}
               $('#txtmodel_name').autocomplete('/?d=System&c=AgentModelQuery&a=CompleteModel&id='+id+'&aorp=0&product_id='+product_id, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 15, //只显示15行
                width: 150, //下拉列表的宽
                parse: function (Data) {//q 返回的数据 JSON 格式，在这里解析成列表
                    /*
                    {"value":[{"id":"100","name":"\u9a6c\u6b63\u6770"},
                    {"id":"200","name":"\u9ebb\u5409"},{"id":"300","name":"Marshane"}]}
                    */
                    $("#agent_price_model_id").val("-100");
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
                $("#txtmodel_name")[0].title = value.name;
                $("#agent_price_model_id").val(_id);
                                    
                var val = $(this).val();
                if (val != '') 
                    AgentModelsearchById(_id);
            });
            //==================代理商模板模糊匹配end=============//
             //------------------促销模板模糊匹配begin-------------//
            
            $('#txtpromModel').autocomplete('/?d=System&c=AgentModelQuery&a=CompleteModel&id='+id+'&aorp=1&product_id='+product_id, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 15, //只显示15行
                width: 150, //下拉列表的宽
                parse: function (Data) {//q 返回的数据 JSON 格式，在这里解析成列表
                   
                    $("#prom_price_model_id").val("-100");
                    //$("#txtprom_price").val("-100");
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
                 $("#txtpromModel")[0].title = value.name;
                 $("#prom_price_model_id").val(_id);
                 
                var val = $(this).val();
                if (val != '') 
                    PromModelsearchById(_id);
            });
            
            //-------------------促销模板模糊匹配 end--------------//
            new Reg.vf($('#J_newLAgentModel'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
            if($("#txtpromModel").val() == "")
                $("#prom_price_model_id").val("-100");
                
            if($("#txtmodel_name").val() == "")
                $("#agent_price_model_id").val("-100");    
            var formValues = $('#J_newLAgentModel').serialize();
            
            $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=System&c=AgentModelQuery&a=ModifyAgentModelSubmit&id="+id+"&agentid="+agent_id+"&product_id="+product_id,
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
                                //alert(q.msg);
                                IM.tip.warn(q.msg);
                                //IM.dialog.hide();
                                //pageList.reflash();
                            }            
                            
                    }
                });
                
            }});
          }
                )}
          })
}
function AgentModelsearchById(_id) {    
    var strJson = $PostData("/?d=System&c=AgentModelQuery&a=GetPromPrice","id="+_id);
    if(strJson != "")
    {
        var jsonObj = eval("(" + strJson + ")");
        agentprice = parseFloat(jsonObj.price).toFixed(2);    
        $("#txtagent_price").val(agentprice);
        $("#txtdeduction_pes").val(jsonObj.deduction_pes);
        $("#txtsale_bonus_pes").val(jsonObj.sale_bonus_pes);
        
        document.getElementById("txtagent_price").disabled=true;
        document.getElementById("txtdeduction_pes").disabled=true;
        document.getElementById("txtsale_bonus_pes").disabled=true;
                
    }    
}
function PromModelsearchById(_id) {   
    var strJson = $PostData("/?d=System&c=AgentModelQuery&a=GetPromPrice","id="+_id);
    if(strJson != "")
    {
        var jsonObj = eval("(" + strJson + ")");
        promptprice = parseFloat(jsonObj.price).toFixed(2);//两位小数点    
        $("#txtprom_price").val(promptprice);
        $("#pro_store_pes").val(jsonObj.deduction_pes);
        $("#pro_sale_bonus_pes").val(jsonObj.sale_bonus_pes);
        
        document.getElementById("txtprom_price").disabled=true;
        document.getElementById("pro_store_pes").disabled=true;
        document.getElementById("pro_sale_bonus_pes").disabled=true;
    }    
}

function CheckModelName(obj)
{
    if(obj.value != obj.title)
    {
        if(obj.id == "txtmodel_name")
        {
            $("#agent_price_model_id").val("0");
            document.getElementById("txtagent_price").disabled=false;
            document.getElementById("txtdeduction_pes").disabled=false;
            document.getElementById("txtsale_bonus_pes").disabled=false;
        }
        else
        {            
            $("#prom_price_model_id").val("0");
            document.getElementById("txtprom_price").disabled=false;
            document.getElementById("pro_store_pes").disabled=true;
            document.getElementById("pro_sale_bonus_pes").disabled=true;
        }
    }
    else if(obj.value != "")
    {
        if(obj.id == "txtmodel_name")
        {    
            document.getElementById("txtagent_price").disabled=true;
            document.getElementById("txtdeduction_pes").disabled=true;
            document.getElementById("txtsale_bonus_pes").disabled=true;
        }
        else
        {            
            document.getElementById("txtprom_price").disabled=true;
            document.getElementById("pro_store_pes").disabled=true;
            document.getElementById("pro_sale_bonus_pes").disabled=true;
        }
    }
}
</script> 
{/literal}