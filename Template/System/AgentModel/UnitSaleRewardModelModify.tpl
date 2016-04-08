<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：系统管理<span>&gt;</span>代理商代理模板<span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<!--S list_table_head-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2>{$strTitle}</h2>
                </div>
            </div>
        </div>
        <span class="declare">
        “<em class="require">*</em>”为必填信息
        </span>
    </div>
<!--E list_table_head--> 
<!--S list_table_main-->
  <div class="form_bd">
    <form id="J_UnitSaleRewardModelModify">
      <div class="tf" style="padding-top:20px;">
        <label>代理商代码：</label>
        <div class="inp">{$strAgentNo}</div>
        <input type="hidden" value="{$agentID}" id="tbxAgentID" name="tbxAgentID" />
      </div>
      <div class="tf">
        <label>代理商名称：</label>
        <div class="inp">{$strAgentName}</div>
      </div>      
        <div class="tf">
        <label><em class="require">*</em>返点设置：</label>
        <div style="vertical-align:middle" class="inp">
        比例模板：<input id="tbxAutoModel" type="text" tabindex="1" maxlength="32" name="tbxAutoModel" style="width:200px;" autocomplete="off"/>
        <span class="c_info">使用模板快速设置</span>
        <span class="ok">&nbsp;</span><span class="err"></span> 
        </div>
      </div>
      {foreach from=$arrayData item=data key=index}
      {assign var="step" value=$index-1}
      {if $index == $rateCount-1} 
       <div id="divLastRate" class="tf">
        <label>&nbsp;</label>
        <div class="inp">
        {if $index == 0 }
          	<label style="width:50px; text-align:right" id="labelLastMoney">0</label>
			<label style="width:30px; text-align:left" id="labelLstRange"><</label>
        {else}
            <label style="width:50px; text-align:right" id="labelLastMoney">{$arrayData[$step].money}</label>
			<label style="width:30px; text-align:left" id="labelLstRange">{if $arrayData[$step].range == 1}<{else}<={/if}</label>
        {/if}
            <label style="width:30px; text-align:center">本金</label>
            <label style="width:50px; text-align:left"><</label>
            <label style="width:100px; text-align:left">无穷大</label>
            <label style="width:100px; text-align:left"><input name="tbxRate" id="tbxRate100" value="{$data.rate}" style="width:80px;text-align:right" size="8" maxlength="3" onkeydown="return NumberOnly(event)"/>%</label>
        
        {if $index == 0 }
        <label style="width:100px; text-align:left">
            <div class="ui_button ui_button_confirm">
            <a id="butAddRate" class="ui_button_inner" onclick="AddRate()" href="javascript:;"> + </a>
            </div>
        </label>
        {else}
        <label style="width:100px; text-align:left"><div class="ui_button ui_button_cancel">
        <a class="ui_button_inner" onclick="RemoveRate(this)" href="javascript:;"> - </a>
        </div>
        </label>
        {/if}
        </div>
      </div>
      {else}
      <div class="tf"><label>&nbsp;</label>
      <div class="inp">
        {if $index == 0 }
          	<label style="width:50px; text-align:right">0</label>
			<label style="width:30px; text-align:left"><</label>
        {else}
            <label style="width:50px; text-align:right">{$arrayData[$step].money}</label>
			<label style="width:30px; text-align:left">{if $arrayData[$step].range == 1}<{else}<={/if}</label>
        {/if}
        <label style="width:30px; text-align:center">本金</label>
        <label style="width:50px; text-align:left"><select name="chkRange" onchange="RangeChange(this)">
        <option {if $data.range == 0}selected="selected"{/if} value="0"><</option>
        <option {if $data.range == 1}selected="selected"{/if} value="1"><=</option>
        </select></label>
        <label style="width:100px; text-align:left"><input name="tbxMoney" value="{$data.money}" size="10" style="width:80px;text-align:right" maxlength="8" onblur="MoneyChange(this)" onkeydown="return NumberOnly(event)"/></label>
        <label style="width:100px; text-align:left"><input name="tbxRate" value="{$data.rate}" style="width:80px;text-align:right" size="8" maxlength="3" onkeydown="return NumberOnly(event)"/>%</label>
        {if $index == 0 }
        <label style="width:100px; text-align:left">
            <div class="ui_button ui_button_confirm">
            <a id="butAddRate" class="ui_button_inner" onclick="AddRate()" href="javascript:;"> + </a>
            </div>
        </label>
        {else}
        <label style="width:100px; text-align:left"><div class="ui_button ui_button_cancel">
        <a class="ui_button_inner" onclick="RemoveRate(this)" href="javascript:;"> - </a>
        </div>
        </label>
        {/if}
      </div>
      </div>
      {/if}
      {/foreach}
      <div class="tf tf_submit" style="padding-top:40px;">
        <label>&nbsp;</label>
        <div class="inp">
            <div class="ui_button ui_button_confirm">
            <button id="btnSave" class="ui_button_inner" type="submit">确定</button>
            </div>
            <div class="ui_button ui_button_cancel">
            <a id="bCancel" class="ui_button_inner" onclick="PageBack()" href="javascript:;">返回</a>
            </div>
        </div>  
      </div>
    </form>
  </div>
</div>
<!--E list_table_main--> 
<!--S Main--> 
{literal} 
<script language="javascript" type="text/javascript">
$('#tbxAutoModel').autocomplete('/?d=PM&c=ProductPriceModel&a=GetUnitSaleRewardRateModelJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
    max: 5, //只显示5行
    width: 200, //下拉列表的宽
    parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
        /*
        {"value":[{"id":"100","name":"\u9a6c\u6b63\u6770"},
        {"id":"200","name":"\u9ebb\u5409"},{"id":"300","name":"Marshane"}]}
        */
        var parsed = [];
        if (backData == "" || backData.length == 0)
            return parsed;

        backData = MM.json(backData);
        var value = backData.value;
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
    var val = $(this).val();
    if (val != '') 
        GetModel(_id);
});


function GetModel(id)
{
    if(id <= 0)
        return ;
    
    var backData = $PostData("/?d=PM&c=ProductPriceModel&a=GetUnitSaleRewardRateModelDetailJson&modelID="+id);
    var jsonObj = MM.json(backData);
    var jsonObjLength = jsonObj.length;
    
    $(".ui_button_cancel").each(function(){
        if(this.children[0].id != "bCancel")
            RemoveRate(this.children[0]);
    });
    
    for (var i = 0; i < jsonObjLength; i++) 
    {
        if(i == jsonObjLength-1)
        {
            $("#divLastRate").find("input")[0].value = jsonObj[i].rate;
        }
        else
        {
            AddRateRow();
            $("#divLastRate").prev().find("select").val(jsonObj[i].range);
            RangeChange($("#divLastRate").prev().find("select")[0]);
            $("#divLastRate").prev().find("input")[0].value = jsonObj[i].money;
            $("#divLastRate").prev().find("input")[1].value = jsonObj[i].rate;
        }
    }
}

function AddRateRow()
{
    var money = "0";
    var cbValue = "1";
    var tbxRate = document.getElementsByName("tbxRate");    
    var rateCount = tbxRate.length;
    if(rateCount != 1)
    {        
        cbValue = $('#divLastRate').prev().find("select").val();
        money = $('#divLastRate').prev().find("input").eq(0).val();
    }
        
    var insertHTML = "<div class='tf'><label>&nbsp;</label><div class='inp'><label style='width:50px; text-align:right'>"
    +money+"</label><label style='width:30px; text-align:left'>";
    if(cbValue == "0")
        insertHTML += "<=";
    else
        insertHTML += "<";
        
    money = parseInt(money)+10000;
    insertHTML += "</label><label style='width:30px; text-align:center'>本金</label>";
    insertHTML += "<label style='width:50px; text-align:left'><select name='chkRange' onchange='RangeChange(this)'><option value='0'><</option><option value='1'><=</option></select></label>";
    insertHTML += "<label style='width:100px; text-align:left'><input name='tbxMoney' value='"+money+"' size='10' style='width:80px;text-align:right' maxlength='8' onblur='MoneyChange(this)' onkeydown='return NumberOnly(event)'/></label>";
    insertHTML += "<label style='width:100px; text-align:left'><input name='tbxRate' value='0' style='width:80px;text-align:right' size='8' maxlength='3' onkeydown='return NumberOnly(event)'/>%</label>";
    
    if(rateCount == 1)
    {
        insertHTML += "<label style='width:100px; text-align:left'><div class='ui_button ui_button_confirm'><a class='ui_button_inner' onclick='AddRate()' href='javascript:;'> + </a></div></label>";
    }
    else
    {
        insertHTML += "<label style='width:100px; text-align:left'><div class='ui_button ui_button_cancel'><a class='ui_button_inner' onclick='RemoveRate(this)' href='javascript:;'> - </a></div></label>";
    }
    
    insertHTML += "</div></div>";
    $(insertHTML).insertBefore("#divLastRate");
    $("#labelLastMoney").html(money);
    $("#labelLstRange").html("<=");
    
    if(rateCount == 1)
    {
        $('#divLastRate').find("label").eq(7).children().remove();
        $('#divLastRate').find("label").eq(7).html("<div class='ui_button ui_button_cancel'><a class='ui_button_inner' onclick='RemoveRate(this)' href='javascript:;'> - </a></div>");
    }
}

function AddRate()
{   
    var tbxRate = document.getElementsByName("tbxRate");    
    var rateCount = tbxRate.length;
    if(rateCount >= 8)
    {
        IM.tip.warn("最多只能有8个层级！");
        return  ;
    }
    
    AddRateRow();            
}

function RemoveRate(obj)
{
    var pDiv = $(obj).parent().parent().parent().parent();
    var v = "0";
    if(pDiv[0].id == "divLastRate")
    {
        pDiv = pDiv.prev();
    }
    
    var tbxRate = document.getElementsByName("tbxRate");
    var rateCount = tbxRate.length;
    if(rateCount != 2)
    {
        v = pDiv.prev().find("input").eq(0).val();
    }    
    
    pDiv.next().find(".inp").children().eq(0).html(v);
    if(rateCount == 2)
    {
        $('#divLastRate').find("label").eq(7).children().remove();
        $('#divLastRate').find("label").eq(7).html("<div class='ui_button ui_button_confirm'><a class='ui_button_inner' onclick='AddRate()' href='javascript:;'> + </a></div>");
    }
    pDiv.remove();
    pDiv = null;
}


function RangeChange(obj)
{
    var v = "<";
    if($(obj).val() == "0")
        v = "<=";
        
    $(obj).parent().parent().parent().next().find(".inp").children().eq(1).html(v);
    
}

function MoneyChange(obj)
{
    if(obj.value == "")
        obj.value = "0";
        
    var v = obj.value;        
    $(obj).parent().parent().parent().next().find(".inp").children().eq(0).html(v);
}

new Reg.vf($('#J_UnitSaleRewardModelModify'),{callback:function(formData){
    formData = "tbxAgentID="+$("#tbxAgentID").val();
    var chkRange = document.getElementsByName("chkRange"); 
    var tbxMoney = document.getElementsByName("tbxMoney"); 
    var tbxRate = document.getElementsByName("tbxRate"); 
    
    var range = "";
    var money = "";
    var rate = "";
    for(var i=0;i<chkRange.length;i++)
    {
        range += ","+ chkRange[i].value;
    }
    
    for(var i=0;i<tbxMoney.length;i++)
    {
        money += ","+ tbxMoney[i].value;
    }
    
    for(var i=0;i<tbxRate.length;i++)
    {
        rate += ","+ tbxRate[i].value;
    }
    
    range = range.substring(1);
    money = money.substring(1);
    rate = rate.substring(1);
    formData += "&chkRange="+range;
    formData += "&tbxMoney="+money;
    formData += "&tbxRate="+rate;
    
    MM.ajax({
		data:formData,
		url: "/?d=System&c=AgentModelQuery&a=UnitSaleRewardModelModifySubmit",
		success:function(backData){            
			if(parseInt(backData) == 0){
			     IM.tip.show("设置成功！");
                 PageBack();
			}else{
                 IM.tip.warn(backData);
            }
		}
	});
}});
</script> 
{/literal}