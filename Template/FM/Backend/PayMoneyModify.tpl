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
    <div class="form_block_hd"><h3 class="ui_title">打款信息</h3></div>
    <div class="tf">
    	<label>代理商：</label>
        <div class="inp">
        <input id="tbxAgentID" name="tbxAgentID"  type="hidden" value="{$objPostMoneyInfo->iAgentId}"/>
        {$objPostMoneyInfo->strAgentName}
        </div>
    </div>
    <div class="tf">
    	<label><em class="require">*</em>打款日期：</label>
        <div class="inp">
        <input id="tbxPostDate" class="inpCommon inpDate" type="text" onfocus="WdatePicker()" name="tbxPostDate" 
         value="{$objPostMoneyInfo->strPostDate|date_format:"%Y-%m-%d"}"/>
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
    <div class="tf wy">
    	<label><em class="require">*</em>打款账号：</label>
        <div class="inp">
        
    </div>
    <div class="tf" >
        <label>开户行</label>
        <div class="inp"><input type="text" tabindex="1" valid="required" name="bankName" id="bankName" value="{$strBankName}"/></div>
        <span class="info">请输入开户行</span>
        <span class="ok">&nbsp;</span><span class="err">请输入开户行</span>
    </div>
    <div class="tf">
        <label>开户名</label>
        <div class="inp"><input type="text" tabindex="1" valid="required" name="AccountName" id="AccountName" value="{$strAccountName}"/></div>
        <span class="info">请输入开户名</span>
        <span class="ok">&nbsp;</span><span class="err">请输入开户名</span>
    </div>
    <div class="tf">
        <label>帐 号</label>
        <div class="inp"><input type="text" tabindex="1" valid="required" name="AccountNo" id="AccountNo" value="{$strAccountNo}"/></div>
        <span class="info">请输入帐号</span>
        <span class="ok">&nbsp;</span><span class="err">请输入帐号</span>
    </div>
    </div>
    <div class="tf wy">
    	<label><em class="require">*</em>收款账户：</label>
        <div class="inp">
            <select name="cbAcceptAccountName" id="cbAcceptAccountName">
            <option value="-100">请选择</option>
            {foreach from=$arrayAccount item=data key=index}
            <option value="{$data.ba_account_id}" {if $objPostMoneyInfo->iBankId == 0 && $index == 0} selected="selected" {else} {if $objPostMoneyInfo->iBankId == $data.ba_account_id} selected="selected"{/if}{/if}>{$data.ba_account_name} {$data.ba_account_no}</option>  
            {/foreach}
            </select>
        </div>
        <span class="info">请选择收款账户</span>
        <span class="err">请选择收款账户</span>
    </div> 
    <div class="tf kq" style="display:none">
    	<label><em class="require">*</em>打款账户名称：</label>
        <div class="inp">
            <input name="tbxPostAccountName" type="text" id="tbxPostAccountName" size="30" maxlength="50" value="{$objPostMoneyInfo->strAgentBankName}" />
        </div>
        <span class="c_info">如果为本公司对公账户支付，请完整填写本公司企业名称，<br/>如果为非本公司对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写实际需付款的企业名称。</span>
        <span class="err">如果为本公司对公账户支付，请完整填写本公司企业名称，<br/>如果为非本公司对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写实际需付款的企业名称。</span>
    </div>            
    <div class="tf">
    	<label><em id="emFrRpFile" style="display:none" class="require">*</em>底单扫描件：</label>
   	 	<div class="inp qua_upload">
        {if $objPostMoneyInfo->strRpFiles == ""}
            <div class="fileBtn">
	        	<input id="J_upload0" style="width:250px;" type="file" name="J_upload0"/>
	        	<input name="permitJ_upload0" id="permitJ_upload0" type="hidden" valid="required" value="" />
	        	<input name="tbxOldReprintPath" id="tbxOldReprintPath" type="hidden" value="" />   
	        </div>
	        <div id="J_uploadImg0" class="img" style="display:none">
	        	<img src='' width="200px"/>
	        </div>
        {else}
            <div class="fileBtn">
	        	<input id="J_upload0" style="width:250px;" type="file" name="J_upload0"/>
	        	<input name="permitJ_upload0" id="permitJ_upload0" type="hidden" valid="required" value="/?d=FM&c=PayMoney&a=ViewImage&id={$objPostMoneyInfo->iPostMoneyId}" />
	        	<input name="tbxOldReprintPath" id="tbxOldReprintPath" type="hidden" value="/?d=FM&c=PayMoney&a=ViewImage&id={$objPostMoneyInfo->iPostMoneyId}" />   
	        </div>
	        <div id="J_uploadImg0" class="img" style="display:block">
	        	<img src='/?d=FM&c=PayMoney&a=ViewImage&id={$objPostMoneyInfo->iPostMoneyId}' width="200px"/>
	        </div>
        {/if}
	        
	    </div>
	    <span class="c_info">请上传底单扫描件。支持的格式为JPG、JPEG，文件大小限制为3M</span>
	    <span class="err">请上传底单扫描件。支持的格式为JPG、JPEG，文件大小限制为3M</span><span class="ok">&nbsp;</span>
    </div>
    <div class="form_block_hd"><h3 class="ui_title">款项分配</h3></div>
      <div class="tf">
            <label><strong>产品名称：</strong></label>
            <div class="inp">
            <label style="text-align:right;width:100px;"><strong>保证金</strong></label>
            <label style="text-align:right;width:100px;"><strong>预存款</strong></label>
            </div>
      </div>
      {foreach from=$arrayProduct item=data key=index}
      <div class="tf">
            <label><input type="hidden" id="tbxProductID_{$data.aid}" name="tbxProductID_{$data.aid}" value="{$data.aid}" />
            {$data.product_type_name}</label>
            <div class="inp">            
            <label style="width:100px;"><input name="tbxGuaMoney" onblur="CalculatePostMoneyAmount()" type="text" id="tbxGuaMoney_{$data.aid}" onkeyup='return FloatNumber(this)' value="{$data.gua_money}" class="inpCommon" style="text-align:right;width:100px;" maxlength="8" valid="required amount"/></label>
            <label style="width:100px;"><input name="tbxPreMoney" onblur="CalculatePostMoneyAmount()" type="text" id="tbxPreMoney_{$data.aid}" onkeyup='return FloatNumber(this)' value="{$data.pre_money}" class="inpCommon" style="text-align:right;width:100px;" maxlength="8" valid="required amount"/></label>
            </div>
            <span class="info">请输入{$data.product_type_name}打款金额</span>
            <span class="ok">&nbsp;</span><span class="err">请输入{$data.product_type_name}打款金额</span>
        </div>      
      {/foreach} 
    <div class="tf">
    	<label>合计金额：</label>
        <div class="inp">
            <label id="divPostMoneyAmount" style="text-align:right;width:100px;">{$objPostMoneyInfo->iPostMoneyAmount}</label>
        </div>
    </div>
    <div class="tf">
       <label>备注：</label>
       <div class="inp">
        <textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark">{$objPostMoneyInfo->strPostRemark}</textarea>
        <span class="c_info">限制128字以内</span><span class="ok">&nbsp;</span><span class="err">限制128字以内</span> 
       </div> 
    </div> 
    {$strBackRemark}
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
//IM.AmountHandler($('#tbxPrice')[0]);

new IM.upload({id:'J_upload0',noticeId:'J_uploadImg0',url: '/?d=FM&c=GuaranteeMoney&a=UpReprint'});

function PayTypeChanged(obj)
{
    //$(".wy").hide();
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
        {       /*    
           $(".wy").each(function(){
            this.style.display = "";
           }); */
        }
    }
    
    $("#emFrRpFile").hide();
    if(v == PayTypes.BankTransfer || v == PayTypes.OnlineBankingPayment)
    {
        $("#emFrRpFile")[0].style.display = "";
    }
}

var _InDealWith = false;
$(function(){
    {/literal}
    var id = parseInt({$id}); 
    var payTypeID = parseInt({$objPostMoneyInfo->iPaymentId}); 
    {literal}
    
    cbDataBind.PayTypes("cbPayTypes");
    if(payTypeID > 0)
    {
        $("#cbPayTypes").val(payTypeID); 
    }
    
            
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
        
        var cbPayTypes = $DOM("cbPayTypes");        
        var payTypeName = cbPayTypes.options[cbPayTypes.selectedIndex].text;
        
        var cbAcceptAccountName = $DOM("cbAcceptAccountName");        
        var acceptAccountName = cbAcceptAccountName.options[cbAcceptAccountName.selectedIndex].text;
        
        var moneys = "";
        var tbxGuaMoney = document.getElementsByName("tbxGuaMoney");
        var tbxPreMoney = document.getElementsByName("tbxPreMoney");
        
        if(tbxGuaMoney.length <= 0)
        {            
            IM.tip.warn("没有找到款项分配内容！");
			return false;
        }
        
        var postMoneyAmount = 0;
        for(var i=0;i<tbxGuaMoney.length;i++)
        {
            moneys +="&"+tbxGuaMoney[i].id+"="+tbxGuaMoney[i].value+"&"+tbxPreMoney[i].id+"="+tbxPreMoney[i].value;
        }
        
        _InDealWith = true;
        {/literal}
        var submitUrl = "/?d=FM&c=PayMoney&a=PayMoneyModifySubmit&id="+id;
        {literal}    
    	$.ajax({
    	    url:submitUrl,
    	    data:$('#J_Guarantee').serialize()+moneys+"&payTypeName="+encodeURIComponent(payTypeName)+"&acceptAccountName="+encodeURIComponent(acceptAccountName),
    	    type:"post",
    	    success:function(backData){
    	    	if(backData.indexOf("seccess") == 0)
                {
                    id = backData.split(",");
                    id = id[1];
                    {/literal}
                    JumpPage("/?d=FM&c=PayMoney&a=SignedPayMoneyDetail&id="+id,false);
                    {literal}
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


function CalculatePostMoneyAmount()
{
    var tbxGuaMoney = document.getElementsByName("tbxGuaMoney");
    var tbxPreMoney = document.getElementsByName("tbxPreMoney");
    
    if(tbxGuaMoney.length <= 0)
        return;
    
    var postMoneyAmount = 0;
    for(var i=0;i<tbxGuaMoney.length;i++)
    {
        postMoneyAmount += parseFloat(tbxGuaMoney[i].value) + parseFloat(tbxPreMoney[i].value);
    }
    
    $("#divPostMoneyAmount").html(parseFloat(postMoneyAmount).toFixed(2));
}

</script>
{/literal}
