<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2>{$strTitle}</h2>
            </div>
        </div>
    </div>
    <span class="declare">“<em class="require">*</em>”为必填信息</span>
</div>
<div class="form_bd">
	<form id="J_Guarantee" action="" name="newGuaranteeForm" class="GuaranteeForm">
    <div class="tf" style="padding-top:20px;">
    	<label><em class="require">*</em>退款类型：</label>
        <div class="inp">
        <select name="cbBackAccount" id="cbBackAccount" valid="required cbBackAccount">
        </select>
        <span class="info">请选择退款类型</span>
        <span class="err">请选择退款类型</span>
        </div>
    </div>
    <div class="tf">
        <label style="width:120px;">
        <input type="hidden" name="tbxID" value="0" id="tbxID" />
        <input type="hidden" name="tbxAgentID" value="0" id="tbxAgentID" /><em class="require">*</em>代理商名称：</label>
        <div class="inp"><input type="text" id="tbxAgentName" name="tbxAgentName" value="{$strAgentName}" autocomplete="off" valid="required" style="width:280px;"/></div>
        <span class="info">请输入代理商名称</span>
    	<span class="ok">&nbsp;</span><span class="err">请输入代理商名称</span>
    </div>
    <div class="tf">
    	<label style="width:120px;"><em class="require">*</em>代理产品：</label>
        <div class="inp">
            <select id="cbProductType" name="cbProductType" valid="required cbProductType">
            <option value="-100">请选择</option>
            {foreach from=$arrayProductType item=data key=index}
            <option {if $objQuarterlyTaskInfo->iProductTypeId == $data.product_type_id} selected="selected" {/if} value="{$data.product_type_id}">{$data.product_type_name}</option>
            {/foreach}
            </select>
        </div>
    </div>
    <div class="tf">
    	<label><em class="require">*</em>退款日期：</label>
        <div class="inp">
        {literal} 
        <input id="tbxPostDate" class="inpCommon inpDate" type="text" onfocus="WdatePicker()" name="tbxPostDate" 
        {/literal} 
         value="{$objReceivablePayInfo->strFrPeerDate|date_format:"%Y-%m-%d"}"/>
        </div>
    </div> 
    <div class="tf">
    	<label><em class="require">*</em>支付方式：</label>
        <div class="inp">
            <select id="cbPayTypes" name="cbPayTypes" onchange="PayTypeChanged(this)" valid="required cbPayTypes"></select>
        </div>
        <span class="info">请选择支付方式</span>
        <span class="err">请选择支付方式</span>
    </div>     
    <div class="tf wy" style="display:none">
    	<label><em class="require">*</em>打款账号：</label>
        <div class="inp">
        <select name="cbPostAccount" id="cbPostAccount">
        <option value="-100">请选择</option>
        {foreach from=$arrayAccount item=data key=index}
        <option value="{$data.ba_account_id}" {if $objReceivablePayInfo->iFrBankId == 0 && $index == 0} selected="selected" {else} {if $objReceivablePayInfo->iFrBankId == $data.ba_account_id} selected="selected"{/if}{/if}>{$data.ba_account_name} {$data.ba_account_no}</option>  
        {/foreach}
        </select>
        </div>
        <span class="info">请选择打款账号</span>
        <span class="err">请选择打款账号</span>
    </div>
    <div class="tf wy" style="display:none">
    	<label><em class="require">*</em>收款账户：</label>
        <div class="inp">
            <select name="cbAcceptAccountName" id="cbAcceptAccountName">
            <option value="-100">请选择</option>
            {foreach from=$arrayAgentAccount item=data key=index}
            <option value="{$data.agent_bank_id}" {if $objReceivablePayInfo->iFrPeerBankId == $data.agent_bank_id} selected="selected"{/if} >{$data.bank_name} {$data.account_name} {$data.account_no}</option>  
            {/foreach}
            </select>
        </div>
        <span class="info">请选择收款账户</span>
        <span class="err">请选择收款账户</span>
    </div>
    <div class="tf kq" style="display:none">
    	<label><em class="require">*</em>快钱交易号：</label>
        <div class="inp">
            <input name="tbxTransactionNo" type="text" id="tbxTransactionNo" size="30" maxlength="50" value="{$objReceivablePayInfo->strFrRpNum}" />
        </div>
        <span class="c_info">请输入快钱交易号</span>
        <span class="err">请输入快钱交易号</span>
    </div> 
    <div class="tf kq" style="display:none">
    	<label><em class="require">*</em>打款账户名称：</label>
        <div class="inp">
            <input name="tbxPostAccountName" type="text" id="tbxPostAccountName" size="30" maxlength="50" value="{$objReceivablePayInfo->strFrPeerBankName}" />
        </div>
        <span class="c_info">请输入打款账户名称</span>
        <span class="err">请输入打款账户名称</span>
    </div>        
    <div class="tf">
    	<label><em class="require">*</em>退款金额：</label>
        <div class="inp">
            <input name="tbxPrice" type="text" id="tbxPrice" value="{$objReceivablePayInfo->iFrPayMoney}" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
        </div>
        <span class="info">请输入金额</span>
        <span class="err">请输入金额</span>
    </div>        
    <div class="tf">
       <label>备注：</label>
       <div class="inp">
        <textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark">{$objReceivablePayInfo->strFrRemark}</textarea>
       </div> 
    </div> 
    <div class="tf tf_submit">
       <label>&nbsp;</label>
        <div class="inp">
        <div class="ui_button ui_button_confirm">
            <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
        </div>
        <div class="ui_button ui_button_cancel">
            <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
        </div>
        </div>
      </div>
    </form>                             
</div> 
</div>
<!--E sidenav_neighbour--> 

{literal}
<script language="javascript" type="text/javascript">
$(function(){   
    cbDataBind.AccountTypes("cbAccountType");
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
 
IM.AmountHandler($('#tbxPrice')[0]);

function PayTypeChanged(obj)
{
    $(".wy").hide();
    $(".kq").hide();
    var v = parseInt(obj.value);
    if( v != -100 && v != PayTypes.Cash)
    {
        if(v == PayTypes.QuickMoney)
        {
           $(".kq").each(function(){
            this.style.display = "";
           }); 
        }
        else
        {           
           $(".wy").each(function(){
            this.style.display = "";
           }); 
        }
    }    
}

var _InDealWith = false;
$(function(){
    {/literal}
    var id = parseInt({$id}); 
    var payTypeID = parseInt({$objReceivablePayInfo->iFrPaymentId});    
    {literal}
    
    cbDataBind.PayTypes("cbPayTypes");
    if(payTypeID > 0)
    {
        $("#cbPayTypes").val(payTypeID); 
    }
    
    PayTypeChanged($DOM("cbPayTypes"));
            
    new Reg.vf($('#J_Guarantee'),{
    	extValid:{
    		cbPayTypes:function(){return MM.getVal(MM.G('cbPayTypes')).text!='请选择'}
    	},
    	callback:function(data){
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
        var agentID = $("#tbxAgentID").val();
        var tbxAgentName = $("#tbxAgentName").val();
        
        agentID = parseInt(agentID);
        if(agentID <= 0 && tbxAgentName != "")
        {
            IM.tip.warn("请输入有效代理商！");
            return ;
        }    
        
        var cbPayTypes = $DOM("cbPayTypes");        
        var payTypeName = cbPayTypes.options[cbPayTypes.selectedIndex].text;
        var cbPostAccount = $DOM("cbPostAccount");
        var postAccountName = cbPostAccount.options[cbPostAccount.selectedIndex].text;
        var cbAcceptAccountName = $DOM("cbAcceptAccountName");        
        var acceptAccountName = cbAcceptAccountName.options[cbAcceptAccountName.selectedIndex].text;
        
        _InDealWith = true;  
    	$.ajax({
    	    url:"/?d=FM&c=BackMoney&a=BackMoneyModifySubmit&id="+id,
    	    data:$('#J_Guarantee').serialize()+"&payTypeName="+encodeURIComponent(payTypeName)
            +"&postAccountName="+encodeURIComponent(postAccountName)+"&acceptAccountName="+encodeURIComponent(acceptAccountName),
    	    type:"post",
    	    success:function(backData){
    	    	if(parseInt(backData) == 0)
                {
                    JumpPage("/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList");
                    _InDealWith = false;  
                    IM.tip.show("退款成功！");
                }    
                else
                {
                    IM.tip.warn(backData);
                    _InDealWith = false;                    
                } 
    	    }					
    	});
    }});
    
});

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
    
    var cbAcceptAccount = $DOM("cbAcceptAccountName");
    while (cbAcceptAccount.options.length > 1) {
        cbAcceptAccount.options[1] = null;
    }
    
    var jsonData = $PostData("/?d=FM&c=BackMoney&a=GetAgentBackAccount","agentID="+agentID);
    var jsonObj = eval("("+ jsonData +")");
    var jsonObjLength = jsonObj.length;
    for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
        cbAcceptAccount.options[cbAcceptAccount.options.length] = new Option(jsonObj[cIndex].name, jsonObj[cIndex].id);
    }  
    
}

</script>
{/literal}
