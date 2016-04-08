<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：订单管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=MyOrderList')">增值产品订单库</a><span>&gt;</span>{$strTitle}</div>
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
	<form id="J_addOrder" action="" name="newOrderModifyForm" class="newOrderModifyForm">
    <div class="form_block_hd"><h3 class="ui_title">订单信息</h3></div>
    <div class="form_block_bd">
        <div class="tf">
        	<label>
            订单类型：</label>
            <div class="inp">
            {$orderTypeText}
            </div>
        </div> 
        <div class="tf">
        	<label><input name="tbxProductID" id="tbxProductID" type="hidden" value="{$objOrder->iProductId}" />
            产品名称：</label>
            <div class="inp">
            {$productText}
            </div>
        </div> 
        <div class="tf">
        	<label>产品价格：</label>
            <div class="inp">
            {$objOrder->iActPrice}
            </div>
        </div>
        <div class="tf">
        	<label>预存款账户金额：</label>
            <div class="inp">
            预存款：{$iPreDepositsAccountMoney} &nbsp;&nbsp;&nbsp; 销奖：{$iSaleAccountMoney}
            </div>
        </div>
        <div class="tf">
        	<label>实际扣款：</label>
            <div class="inp">
            预存款：{$iPreDepositsChargeMoney} &nbsp;&nbsp;&nbsp; 销奖：{$iSaleChargeMoney}
            </div>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>订单时间：</label>
            <div class="inp">
            {literal} 
            <input id="J_editTimeS" class="inpCommon inpDate" type="text" onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})" name="tbxSData" 
            {/literal} 
             value="{$objOrder->strOrderSdate|date_format:"%Y-%m-%d"}" valid="required"/>
                至
            {literal}     
            <input id="J_editTimeE" class="inpCommon inpDate" type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})" name="tbxEData" 
            {/literal} 
            value="{$objOrder->strOrderEdate|date_format:"%Y-%m-%d"}"  valid="required"/>            
            </div>
            <span class="info">请输入订单时间</span>
			<span class="ok">&nbsp;</span><span class="err">请输入订单时间</span>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>网址：</label>
            <div class="inp">
            {if $id > 0 }
                {foreach from=$arrayOrderWebsite item=data key=index}
                    <input name="tbxWebSite" type="text" id="tbxWebSite" style="width:300px;" size="30" maxlength="50" value="{$data.website_name}" valid="required url"/>
                {/foreach}
            {else}
                <input name="tbxWebSite" type="text" id="tbxWebSite" style="width:300px;" size="30" maxlength="50" value="{$strLastWebSite}" valid="required url"/>
            {/if}
            </div>
            <span class="info">请输入客户网址</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户网址</span>
        </div>    
        </div>
        <div class="form_block_hd"><h3 class="ui_title">客户基本信息</h3></div>
        <div class="form_block_bd">
        <div class="tf">
        	<label><input name="tbxCustomerID" id="tbxCustomerID" type="hidden" value="{$objOrder->iCustomerId}" />
            客户名称：</label>
            <div class="inp">
           {$objOrder->strCustomerName}
            </div>
        </div>  
        <div class="tf">
        	<label><em class="require">*</em>法人姓名：</label>
            <div class="inp">
                <input name="tbxLegalPersonName" type="text" id="tbxLegalPersonName" style="width:100px;" size="30" maxlength="10" value="{$objCustomerInfo->strLegalPersonName}" valid="required isNull"/>
            </div>
            <span class="info">请输入法人姓名</span>
            <span class="ok">&nbsp;</span><span class="err">请输入法人姓名</span>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>法人身份证号：</label>
            <div class="inp">
                <input name="tbxLegalPersonID" type="text" id="tbxLegalPersonID" style="width:200px;" size="30" maxlength="20" value="{$objOrder->strLegalPersonId}" valid="required isNull"/>
            </div>
            <span class="info">请输入法人身份证号</span>
            <span class="ok">&nbsp;</span><span class="err">请输入法人身份证号</span>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>营业执照号：</label>
            <div class="inp">
                <input name="tbxPermit" type="text" id="tbxPermit" style="width:200px;" size="30" maxlength="40" value="{$objOrder->strBusinessLicense}" valid="required isNull"/>
            </div>
            <span class="info">请输入客户营业执照号</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户营业执照号</span>
        </div>  
        </div>
        <div class="form_block_hd"><h3 class="ui_title">联系人信息</h3></div>
        <div class="form_block_bd"> 
        <div class="tf">
        	<label><em class="require">*</em>姓名：</label>
            <div class="inp">
                <input name="tbxContactName" type="text" id="tbxContactName" style="width:180px;" size="30" maxlength="10" value="{$objOrder->strContactName}" valid="required isNull"/>
            </div>
            <span class="info">请输入联系人姓名</span>
            <span class="ok">&nbsp;</span><span class="err">请输入联系人姓名</span>
        </div>        
        <div class="tf">
          <label><em class="require">*</em>手机号：</label>
          <div class="inp">
            <input value="{$objOrder->strContactMobile}" class="mPhone" type="text" id="contact_mobile"  name="contact_mobile" style="width:180px;" maxlength="20" />
          </div>
          <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
			<span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
    	</div>
    	<div class="tf">
          <label>固定电话：</label>
          <div class="inp">
            <input value="{$objOrder->strContactTel}" class="fPhone" type="text" id="contact_tel"  name="contact_tel" style="width:180px;" maxlength="20"/>
          </div>
          <span class="info">固话格式:0571-8888888</span>
	  <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号</span>
	 </div>
        <div class="tf">
          <label>传真号码：</label>
          <div class="inp">
            <input value="{$objOrder->strContactFax}" class="faxPhone" type="text" id="contact_fax" name="contact_fax" style="width:180px;" maxlength="20"/>
          </div>
          <span class="info">格式:0571-8888888</span>
          <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span> 
        </div>
        <div class="tf">
          <label>电子邮箱：</label>
          <div class="inp">
            <input value="{$objOrder->strContactEmail}" class="email" type="text" id="contact_email" name="contact_email" style="width:180px;" maxlength="50"/>
          </div>
          <span class="info">请输入正确邮箱</span>
          <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
        </div>
        <div class="tf">
		<label><em class="require">*</em>联系地址：</label>
		<div class="inp">
		    <select id="selProvince1"  class="pri" name="pri" tabindex="2"></select>
            <select id="selCity1" class="city" name="city" tabindex="3"></select>
            <select id="area_id1" class="area" name="area" tabindex="4"></select>
            <input class="detailAddress" value="{$objCustomerInfo->strAddress}" type="text" name="contact_address" valid="required detailAddress" style="width:180px;" maxlength="50" id="contact_address"/>
		</div>
		<span class="info">请输入详细街道地址</span>
		<span class="ok">&nbsp;</span><span class="err">请输入详细街道地址</span>
	    </div>
        </div>        
        <div class="form_block_hd"><h3 class="ui_title">资质上传</h3></div>
        <div class="form_block_bd">
        <div class="tf">
        	<label> <em class="require">*</em>法人身份证：</label>
            <div class="inp qua_upload">
                <div class="fileBtn">
                	<input id="J_upload0" class="tbxLegalPersonID" style="width:250px;" type="file" name="J_upload0"/>
                	<input name="tbxOldLegalPersonIDPath" id="tbxOldLegalPersonIDPath" type="hidden" value="{$objOrder->strLegalPersonIdPath}" />
                    <input name="permitJ_upload0" id="permitJ_upload0" type="hidden" value="{$objOrder->strLegalPersonIdPath}"  /> 
                </div>
                <div id="J_uploadImg0" class="img" {if $objOrder->strLegalPersonIdPath == ""}style="display:none"{else}style="display:block"{/if}>
                {if $objOrder->strLegalPersonIdPath != ""}
                <img src='{$objOrder->strLegalPersonIdPath}' width="200px"/>               
                {/if}
                </div>                
            </div>
            <span class="c_info">请上传法人身份证。支持的格式为JPG、JPEG，文件大小限制为3M</span>
            <span class="ok">&nbsp;</span><span class="err">请上传法人身份证。支持的格式为JPG、JPEG，文件大小限制为3M</span>
        </div>
        <div class="tf">
        	<label> <em class="require">*</em>客户营业执照：</label>
            <div class="inp qua_upload">
                <div class="fileBtn">
                	<input id="J_upload1" class="tbxPermit" style="width:250px;" type="file" name="J_upload1"/>
                	<input name="tbxOldPermitPath" id="tbxOldPermitPath" type="hidden" value="{$objOrder->strBusinessLicensePath}" />
                    <input name="permitJ_upload1" id="permitJ_upload1" type="hidden" value="{$objOrder->strBusinessLicensePath}" />  
                </div>
                <div id="J_uploadImg1" class="img" {if $objOrder->strBusinessLicensePath == ""}style="display:none"{else}style="display:block"{/if}>
                {if $objOrder->strBusinessLicensePath != ""}
                <img src='{$objOrder->strBusinessLicensePath}' width="200px"/>              
                {/if}
                </div>                
            </div>
            <span class="c_info">请上传营业执照。支持的格式为JPG、JPEG，文件大小限制为3M</span>
            <span class="ok">&nbsp;</span><span class="err">请上传营业执照。支持的格式为JPG、JPEG，文件大小限制为3M</span>
        </div>  
        <div class="tf">
           <label>备注：</label>
           <div class="inp">
            <textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark" valid="tbxRemark">{$objOrder->strOrderRemark}</textarea>
           </div> 
           <span class="info">请输入备注，最多128个文字</span>
            <span class="ok">&nbsp;</span>
            <span class="err">请输入备注，最多128个文字</span>
        </div> 
        <div class="tf tf_submit">
           <label><input id="tbxPost" name="tbxPost" type="hidden" value="0" />&nbsp;</label>
            <div class="inp">
                        <div class="ui_button" style="margin-right:10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"><button type="submit" name="butOk" style="background:none; color:#fff;" onclick="$('#tbxPost').val(1);">提 交</button></div></div></div>
            <div class="ui_button" style="margin-right:10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"><button type="submit" name="butSave"  style="background:none; color:#fff;" onclick="$('#tbxPost').val(0);">保 存</button></div></div></div>
            <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
            </div>
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
    {/literal}
    var selProvince1 = "{$selProvince1}";//alert(selProvince1);
    var selCity1 = "{$selCity1}";//alert(selCity1);
    var area_id1 = "{$selarea1}";

    var id = parseInt({$id});
    var areaID = parseInt({$objCustomerInfo->iAreaId}); 
    var cityID = parseInt({$cityID}); 
    var provinceID = parseInt({$provinceID}); 
    var agentID = parseInt({$objOrder->iAgentId});
    {literal}
    
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:false, area_id:areaID,city_id:cityID,province_id:provinceID,iAddPleaseSelect:true}); 
    $("#selProvince1").BindProvince({iAll:"true",selCityID:"selCity1",selAreaID:"area_id1",iAddPleaseSelect:false,area_id:area_id1,city_id:selCity1,province_id:selProvince1,iAddPleaseSelect:true});                                   
	new Reg.vf($('#J_addOrder'),{extValid:{
			tbxRemark:function(e){return e.length<128}
		},callback:function(data){
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
        if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
        var productNo = $GetProduct.GetProductNo($("#cbProductType").val(),$("#cbProduct").val());
        
        _InDealWith = true;
     
    	$.ajax({
    	    url:'/?d=OM&c=Order&a=OrderModifySubmit',
    	    data:$('#J_addOrder').serialize()+"&productNo="+productNo+"&id="+id,
    	    type:"post",
   	    	success:function(backMsg){							
				if(backMsg.indexOf("0,") == 0){
                    id = backMsg.split(",");
                    id = id[1];
					JumpPage("/?d=OM&c=Order&a=OrderDetail&id="+id,false);
				    _InDealWith = false;
				}else{
                    _InDealWith = false;
                    $('#tbxPost').val(0);
                    IM.tip.warn(backMsg);
				}
			}
    	});  
    }});
    
});
new IM.upload({id:'J_upload0',noticeId:'J_uploadImg0',{/literal} url: '/?d=CM&c=CMInfo&a=FileUpload&upControl=J_upload0'{literal}});
new IM.upload({id:'J_upload1',noticeId:'J_uploadImg1',{/literal} url: '/?d=CM&c=CMInfo&a=FileUpload&upControl=J_upload1'{literal}});

</script>
{/literal}
