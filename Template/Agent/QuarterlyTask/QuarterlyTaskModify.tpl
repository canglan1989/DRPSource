<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：季度任务查询<span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
        <span class="declare">"<em class="require">*</em>"为必填信息</span>
    </div>
    <!--S form_bd-->
    <div class="form_bd">
        <!--S form_block_bd-->
        <form id="form1" class="newAccountForm" name="form1" action="">
            <div class="tf" style="padding-top:20px;">
                <label style="width:120px;">
                <input type="hidden" name="tbxID" value="{$objQuarterlyTaskInfo->iQuarterlyTaskId}" id="tbxID" />
                <input type="hidden" name="tbxAgentID" value="{$objQuarterlyTaskInfo->iAgentId}" id="tbxAgentID" /><em class="require">*</em>代理商名称：</label>
                <div class="inp"><input type="text" id="tbxAgentName" name="tbxAgentName" value="{$strAgentName}" autocomplete="off" valid="required" style="width:280px;"/></div>
                <span class="info">请输入代理商名称</span>
            	<span class="ok">&nbsp;</span><span class="err">请输入代理商名称</span>
            </div>
            <div class="tf">
    	<label style="width:120px;"><em class="require">*</em>代理产品：</label>
        <div class="inp">
            <select id="cbProductType" name="cbProductType">
            <option value="-100">请选择</option>
            {foreach from=$arrayProductType item=data key=index}
            <option {if $objQuarterlyTaskInfo->iProductTypeId == $data.product_type_id} selected="selected" {/if} value="{$data.product_type_id}">{$data.product_type_name}</option>
            {/foreach}
            </select>
        </div>
        </div>
        <div class="tf">
        	<label style="width:120px;"><em class="require">*</em>季度时间：</label>
            <div class="inp">
            	<select id="cbYear" name="cbYear">
                <option value="-100">请选择</option>
                {foreach from=$arrayYear item=data key=index}
                <option {if $objQuarterlyTaskInfo->iTaskYear == $data} selected="selected" {/if} value="{$data}">{$data}</option>
                {/foreach}
                </select>
                <select id="cbQuarterly" name="cbQuarterly">
                <option value="-100">请选择</option>
                <option {if $objQuarterlyTaskInfo->iTaskQuarterly == 1} selected="selected" {/if} value="1">第一季度(1-3月)</option>
                <option {if $objQuarterlyTaskInfo->iTaskQuarterly == 2} selected="selected" {/if} value="2">第二季度(4-6月)</option>
                <option {if $objQuarterlyTaskInfo->iTaskQuarterly == 3} selected="selected" {/if} value="3">第三季度(7-9月)</option>
                <option {if $objQuarterlyTaskInfo->iTaskQuarterly == 4} selected="selected" {/if} value="4">第四季度(10-12月)</option>
                </select>
            </div>
        </div>
        <div class="tf">
        	<label style="width:120px;"><em class="require">*</em>任务额：</label>
            <div class="inp"><input class="inpCommon" type="text" name="tbxTaskMoney" id="tbxTaskMoney" value="{$objQuarterlyTaskInfo->iTaskMoney}" valid="required" maxlength="9" onkeyup='return FloatNumber(this)' style="float:left; width:100px; text-align:right" /></div>
            <span class="info">请输入任务额</span>
        	<span class="ok">&nbsp;</span><span class="err">请输入任务额</span>
        </div>
        <div class="tf">
        	<label style="width:120px;"><em class="require">*</em>完成额：</label>
            <div class="inp"><input class="inpCommon" type="text" name="tbxFinishMoney" id="tbxFinishMoney" value="{$objQuarterlyTaskInfo->iFinishMoney}" valid="required" maxlength="9" onkeyup='return FloatNumber(this)' style="float:left; width:100px; text-align:right" /></div>
            <span class="info">请输入完成额</span>
        	<span class="ok">&nbsp;</span><span class="err">请输入完成额</span>
        </div>
        <div class="tf">
        	<label style="width:120px;">销奖：</label>
            <div class="inp"><input class="inpCommon" type="text" name="tbxSaleAwardMoney" id="tbxSaleAwardMoney" value="{$objQuarterlyTaskInfo->iSaleAwardMoney}" maxlength="9" valid="required amount" onkeyup='return FloatNumber(this)' style="float:left; width:100px; text-align:right" /></div>
            <span class="info">请输入销奖</span>
        	<span class="ok">&nbsp;</span><span class="err">请输入销奖</span>
        </div>
        <div class="tf">
        	<label style="width:120px;">市场基金：</label>
            <div class="inp"><input class="inpCommon" type="text" name="tbxMarketFunds" id="tbxMarketFunds" value="{$objQuarterlyTaskInfo->iMarketFunds}" maxlength="9" valid="required amount" onkeyup='return FloatNumber(this)' style="float:left; width:100px; text-align:right" /></div>
            <span class="info">请输入市场基金</span>
        	<span class="ok">&nbsp;</span><span class="err">请输入市场基金</span>
        </div>
        <div class="tf">
        	<label style="width:120px;">渠道基金：</label>
            <div class="inp"><input class="inpCommon" type="text" name="tbxDistributionFunds" id="tbxDistributionFunds" value="{$objQuarterlyTaskInfo->iDistributionFunds}" maxlength="9" valid="required amount" onkeyup='return FloatNumber(this)' style="float:left; width:100px; text-align:right" /></div>
            <span class="info">请输入渠道基金</span>
        	<span class="ok">&nbsp;</span><span class="err">请输入渠道基金</span>
        </div>
        <div class="tf">
           <label>备注：</label>
           <div class="inp"><textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark" valid="tbxRemark">{$objQuarterlyTaskInfo->strQuarterlyTaskRemark}</textarea></div> 
           <span class="info">请输入备注，最多128个文字</span>
            <span class="ok">&nbsp;</span>
            <span class="err">请输入备注，最多128个文字</span>
        </div> 
        <div class="tf tf_submit">
            <label>&nbsp;</label>
            <div class="inp">
                <div class="ui_button ui_button_confirm">
                <button id="btnSave" class="ui_button_inner" type="submit">确定</button>
                </div>
                <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返回</a>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<!--S Main--> 
{literal} 
<script type="text/javascript" language="javascript">
$(function(){   
   	var agentID = $("#tbxAgentID").val();
    agentID = parseInt(agentID);
    if(agentID > 0)
    {
        GetProductTypes(agentID);
        {/literal} 
        var productTypeID = parseInt({$objQuarterlyTaskInfo->iProductTypeId});
        {literal} 
        if(productTypeID > 0)
            $("#cbProductType").val(productTypeID);
    }
    
 });

var _InDealWith = false;
new Reg.vf($('#form1'),{callback:function(data){
    //数据已提交，正在处理标识
    if (_InDealWith) 
    {
            IM.tip.warn("数据已提交，正在处理中！");
            return false;
    }

    _InDealWith = true;
    $.ajax({
       url:'/?d=Agent&c=QuarterlyTask&a=QuarterlyTaskModifySubmit',
        data:$('#form1').serialize(),
        type:"post",
        success:function(backData){
            if(parseInt(backData) == 0){
                PageBack();  
                _InDealWith = false;
            }else{
                IM.tip.warn(backData);
                _InDealWith = false;
            }
        }					
    });
}});
    

$('#tbxAgentName').autocomplete('/?d=Agent&c=QuarterlyTask&a=AutoAgentJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
    max: 8, //只显示8
    width: 280, //下拉列表的宽
    parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
        $("#tbxAgentID").val("-100");
        
        var parsed = [];
        if(backData == "" || backData.length == 0)
            return parsed;                                
        backData = MM.json(backData);
        var value = backData;
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
        return "<div>" + item.no +" "+item.name +""+ "</div>";
    }
}).result(function (data,value) {//执行模糊匹配
    var id = value.id;
    $("#tbxAgentID").val(id);
    GetProductTypes(id);    
});

function GetProductTypes(agentID)
{
    var cbProductType = $DOM("cbProductType");
    while (cbProductType.options.length > 1) {
        cbProductType.options[1] = null;
    }
    
    cbProductType.options[0].selected = true;
    
    var jsonData = $PostData("/?d=Agent&c=QuarterlyTask&a=GetAgentPactProduct","agentID="+agentID);
    var jsonObj = eval("("+ jsonData +")");
    var jsonObjLength = jsonObj.length;
    for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
        cbProductType.options[cbProductType.options.length] = new Option(jsonObj[cIndex].name, jsonObj[cIndex].id);
    }  
        
}
</script> 
{/literal} 
