<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
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
                <input type="hidden" name="tbxAgentID" value="{$agentID}" id="tbxAgentID" /><em class="require">*</em>代理商名称：</label>
                <div class="inp"><input type="text" id="tbxAgentName" name="tbxAgentName" value="{$strAgentName}" autocomplete="off" valid="required" style="width:280px;"/></div>
                <span class="info">请输入代理商名称</span>
            	<span class="ok">&nbsp;</span><span class="err">请输入代理商名称</span>
            </div>
            <div class="tf">            
        	<label><em class="require">*</em></label>
            <div class="inp">
            <label style="width:150px;text-align:left">签约产品</label><label style="width:200px;text-align:left">赠品</label>
            </div>
            </div>
            <div id="divProductList">
            </div>
        <!--<div class="tf">
           <label>备注：</label>
           <div class="inp"><textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark" valid="tbxRemark">{$objOrderGiftSetInfo->strRemark}</textarea></div> 
           <span class="info">请输入备注，最多128个文字</span>
            <span class="ok">&nbsp;</span>
            <span class="err">请输入备注，最多128个文字</span>
        </div>-->
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
<script type="text/javascript" language="javascript">
var strGiftProductHTML = "{$strGiftProductHTML}";
{literal} 
$(document).ready(function () {
	var agentID = parseInt($DOM("tbxAgentID").value);
	if(agentID > 0)
        GetProductTypes(agentID);
});
function GetProductTypes(agentID)
{
    var html = $PostData("/?d=OM&c=GiftProduct&a=GetCurrentSignedProductType","agentID="+agentID);
    $("#divProductList").html(html);
}

$('#tbxAgentName').autocomplete('/?d=OM&c=GiftProduct&a=AutoAgentJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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

var _InDealWith = false;
new Reg.vf($('#form1'),{callback:function(data){
    //数据已提交，正在处理标识
    if (_InDealWith) 
    {
        IM.tip.warn("数据已提交，正在处理中！");
        return false;
    }
    
    var data = "";
    var giftChecks = "";
    var tbxProductType = document.getElementsByName("tbxProductType");
    for(var i=0;i<tbxProductType.length;i++)
    {
        data += tbxProductType[i].value+":";
        var chkGifts = document.getElementsByName("tbxGift"+tbxProductType[i].value);
        giftChecks = "";
        for(var g=0;g<chkGifts.length;g++)
        {
            if(chkGifts[g].checked == true)
                giftChecks += chkGifts[g].value+",";
        }
        
        if(giftChecks.length > 0)
            giftChecks = giftChecks.substring(0, giftChecks.length-1);
        
        data += giftChecks+"|";
    }

    if(data.length > 0)
        data = data.substring(0, data.length-1);
        
    _InDealWith = true;
    var backData = $PostData("/?d=OM&c=GiftProduct&a=AddAgentModifySubmit","tbxAgentID="+$DOM("tbxAgentID").value+"&data="+data);
    if(parseInt(backData) == 0)
    {        
        JumpPage("/?d=OM&c=GiftProduct&a=AgentList&agentName="+encodeURIComponent($DOM("tbxAgentName").value));  
        _InDealWith = false;
        IM.tip.show("编辑成功！");
    }
    else
    {
        IM.tip.warn(backData);
        _InDealWith = false;        
    }
}});
                             
</script> 
{/literal} 
