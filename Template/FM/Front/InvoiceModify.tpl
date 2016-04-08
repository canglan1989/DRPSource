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
    <span class="declare">
    “<em class="require">*</em>”为必填信息
    </span>
</div>
<div class="form_bd">
	<form id="J_addInvoice" action="" name="newModifyForm" class="newModifyForm">
        <div class="tf" style="padding-top:20px;">
          <label> <input type="hidden" value="-100" name="tbxID" id="tbxID" /> 发票抬头： </label>
          <div class="inp">
          {$agentName}
          </div>
        </div>  
        <div class="tf">
          <label title="网盟只可申请终端客户本金消费"> <em class="require">*</em> 产品： </label>
          <div title="网盟只可申请终端客户本金消费" class="inp">
            <select id="cbProductType" name="cbProductType" onchange="ChangeCanApplyPrice(this)">
            <option value="-100">请选择</option>
            {foreach from=$arrayProductType item=data key=index}
            <option value="{$data.aid}">{$data.product_type_name}</option>
            {/foreach}            
            </select>
          </div>
          <span id="spanNode" style="display:none" class="c_info">网盟只可申请终端客户本金消费</span> 
        </div>
        <div class="tf">
          <label>一般纳税人：</label>
          <div class="inp" style="vertical-align:middle">
              {if $permitPath == ""}
                <input class="checkInp" type="checkbox" name="chkGeneralTaxpayer" id="chkGeneralTaxpayer" onclick="gtOnClick(this)" value="1" />
              {else}
              <span style="display:none">
                 <input class="checkInp" type="checkbox" name="chkGeneralTaxpayer" id="chkGeneralTaxpayer" checked="checked" value="1" />
              </span>
              {/if}       
          </div>
          <div class="inp" id="upload_picture">
            <input type="hidden" value="{$permitPath}" id="tbxOldPermitPath" name="tbxOldPermitPath"/>
            <input id="permitJ_upload0" type="hidden" value="{$permitPath}" name="permitJ_upload0"/>
                {if $permitPath != ""}
                <div id="J_uploadImg0" class="img" style="display:block">
                    <img id="imgPermit" src='{$permitPath}' width="200px"/>
                </div>
                {else}
                <div id="J_uploadImg0" class="img" style="display:none">
                </div>
                {/if}
          </div>
        </div> 
        <div id="divQFUp" style="display:none" class="tf">
        	<label><em class="require">*</em>资格证上传： </label>
            <div class="inp qua_upload">
                <div class="fileBtn">
                	<input id="J_upload0" class="qualifications" type="file" name="qualifications" style="width:250px;"/>
                </div>           
            </div>
            <span class="c_info">请上传一般纳税人资格证。支持的格式为JPG、JPEG、BMP、GIF，文件大小限制为3M</span>
            <span class="ok">&nbsp;</span><span class="err">请上传一般纳税人资格证。支持的格式为JPG、JPEG，文件大小限制为3M</span>
        </div>
        <div class="tf">
          <label> <em class="require">*</em> 发票种类： </label>
          <div class="inp">
            <select id="cbInvoiceType" name="cbInvoiceType">
            <option value="-100">请选择</option>
            </select>
          </div>
          <span class="info">请选择发票种类</span> <span class="ok">&nbsp;</span><span class="err">请选择发票种类</span> 
        </div>    
        <div class="tf">
          <label> 可申请金额： </label>
          <div class="inp">
            <b class="amountStyle"><span id="spanCanApplyPrice">￥0.00</span></b>
          </div>          
        </div>   
        <div class="tf">
          <label> <em class="require">*</em>申请金额：</label>
          <div class="inp">
            <input id="tbxApplyPrice" type="text" maxlength="9" valid="required amount" onkeyup='return FloatNumber(this)' class="inpCommon" name="tbxApplyPrice" style="float:left; width:100px; text-align:right" value="0" />
          </div>
          <span class="info">请输入申请金额</span> <span class="ok">&nbsp;</span><span class="err">请输入申请金额</span> 
        </div>      
        <div class="tf">
           <label>备注：</label>
           <div class="inp">
            <textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark">{$objOrder->strOrderRemark}</textarea>
            <span class="c_info">限制128字以内</span><span class="ok">&nbsp;</span><span class="err">限制128字以内</span> 
           </div> 
        </div> 
        <div class="tf tf_submit">
           <label>&nbsp;</label>
            <div class="inp">
            <div class="ui_button ui_button_confirm">
                <button id="butOk" class="ui_button_inner" type="submit">提 交</button>
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
var _InDealWith = false;
$(function(){
    
	function v_isNull(e){return $.trim(e)!='';}                                       
	new Reg.vf($('#J_addInvoice'),{extValid:{isNull:v_isNull},callback:function(data){
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
                
        _InDealWith = true;
    	$.ajax({
    	    url:'/?d=FM&c=Invoice&a=InvoiceModifySubmit',
    	    data:$('#J_addInvoice').serialize(),
    	    type:"post",
    	    success:function(backData){
    	    	if(backData.indexOf("seccess,") == 0)
                {
                    _InDealWith = false;
                    id = backData.split(",");
                    id = id[1];
                    JumpPage("/?d=FM&c=Invoice&a=InvoiceDetail&id="+id,false);
                }    
                else
                {
                    _InDealWith = false;    
                    IM.tip.warn(backData);                
                } 
    	    }					
    	});
    }});
    
});

new IM.upload({id:'J_upload0',noticeId:'J_uploadImg0',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir=nsrzgz'{literal}});

function gtOnClick(obj)
{
    //没上传才展开
    if(obj.checked)
    {
        $DOM("divQFUp").style.display = "";
        $DOM("upload_picture").style.display = "";          
    }
    else
    {        
        $DOM("J_upload0").value = "";
        var imgPermit = $("#J_uploadImg0")[0].children[0];
        
        if(imgPermit != undefined && imgPermit != null)
        {
            imgPermit.src = "";
            imgPermit.parentNode.removeChild(imgPermit);
            $("#permitJ_upload0").val("");
        }
        
        $DOM("divQFUp").style.display = "none";
        $DOM("upload_picture").style.display = "none";
        
    }
    GetInvoiceType();
}


function ChangeCanApplyPrice(obj)
{
    var price ="￥0.00";
    
    if(parseInt(obj.value) > 0)
    {
        price = $PostData("/?d=FM&c=Invoice&a=CanApplyMoney","productType="+obj.value);
        price = "￥"+ parseFloat(price).toFixed(2);        
    }
    
    $("#spanCanApplyPrice").html(price);
    GetInvoiceType();
}

function GetInvoiceType()
{
    var cbProductType = $DOM("cbProductType");
    var chkGeneralTaxpayer = $DOM("chkGeneralTaxpayer");
     
    var cbInvoiceType = $DOM("cbInvoiceType");
    while (cbInvoiceType.options.length > 1) {
        cbInvoiceType.options[1] = null;
    }
    $DOM("spanNode").style.display = "none";
    cbProductTypeText = cbProductType.options[cbProductType.selectedIndex].text;
    if(chkGeneralTaxpayer.checked == true)
    {
        cbInvoiceType.options[cbInvoiceType.options.length] = new Option("增值税专用发票", "1");
    }
    else
    {
        cbInvoiceType.options[cbInvoiceType.options.length] = new Option("增值税普通发票", "3");
    }
    
    if(cbInvoiceType.options.length == 2)
    {
        cbInvoiceType.options[1].selected = true;
    }
}
</script>
{/literal}
