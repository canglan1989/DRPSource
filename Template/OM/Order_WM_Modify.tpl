<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：订单管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=OM&c=UnitOrder&a=MyUnitOrderList')">网盟订单库</a><span>&gt;</span>{$strTitle}</div>
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
        	<label>账户金额：</label>
            <div class="inp">
            预存款：{$iPreDepositsAccountMoney} &nbsp;&nbsp;&nbsp; 保证金：{$iSaleAccountMoney}
            </div>
        </div>          
        </div>
        <div class="form_block_hd"><h3 class="ui_title">开户信息</h3></div>
        <div class="form_block_bd">
        <div class="tf">
        	<label><em class="require">*</em>客户账户：</label>
            <div class="inp">
                <input name="tbxAccountName" type="text" id="tbxAccountName" style="width:200px;" size="50" maxlength="36" value="{$objOrder->strOwnerAccountName}" valid="required accountName3"/>
            </div>
            <span class="info">请输入客户账户名称</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户账户名称</span>
        </div> 
        <div class="tf">
        	<label><em class="require">*</em>密码：</label>
            <div class="inp">
                <input name="tbxPwd" type="hidden" id="tbxOldPwd" style="width:200px;" size="50" maxlength="30" value="{$objOrder->strOwnerLoginPwd}" valid=""/>
                <input name="tbxPwd" type="password" id="tbxPwd" style="width:200px;" size="50" maxlength="30" value="{$objOrder->strOwnerLoginPwd}" valid="required"/>
            </div>
            <span class="info">请输入客户账户密码</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户账户密码</span>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>确认密码：</label>
            <div class="inp">
                <input name="tbxPwdCheck" type="password" id="tbxPwdCheck" style="width:200px;" size="50" maxlength="30" value="{$objOrder->strOwnerLoginPwd}" valid="required"/>
            </div>
            <span class="info">请输入确认密码</span>
            <span class="ok">&nbsp;</span><span class="err">请输入确认密码</span>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>网站名称：</label>
            <div class="inp">
            <input name="tbxWebSiteName" type="text" id="tbxWebSiteName" style="width:200px;" size="30" maxlength="50" value="{$objOrder->strOwnerWebsiteName}" valid="required"/>
            </div>
            <span class="info">请输入客户推广网站名称</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户推广网站名称</span>
        </div> 
        <div class="tf">
        	<label><em class="require">*</em>网站域名：</label>
            <div class="inp">
            <input name="tbxWebSite" type="text" id="tbxWebSite" style="width:300px;" size="30" maxlength="128" value="{$objOrder->strOwnerDomainUrl}" valid="required "/>
            </div>
            <span class="info">请输入客户推广网站地址</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户推广网站地址且保证格式正确</span>
        </div>                   
        </div>
        <div class="form_block_hd"><h3 class="ui_title">客户基本信息</h3></div>
        <div class="form_block_bd">
        <div class="tf">
        	<label><input name="tbxCustomerID" id="tbxCustomerID" type="hidden" value="{$objOrder->iCustomerId}" />
            <input name="tbxCustomerName" id="tbxCustomerName" type="hidden" value="{$objOrder->strCustomerName}" />
            客户名称：</label>
            <div class="inp">
           {$objOrder->strCustomerName}
            </div>
        </div>  
        <div class="tf">
        	<label><em class="require">*</em>法人姓名：</label>
            <div class="inp">
                <input name="tbxLegalPersonName" type="text" id="tbxLegalPersonName" style="width:100px;" size="30" maxlength="10" value="{$objCustomerInfo->strLegalPersonName}" valid="required"/>
            </div>
            <span class="info">请输入法人姓名。若为个人用户，请填写联系人姓名。</span>
            <span class="ok">&nbsp;</span><span class="err">请输入法人姓名。若为个人用户，请填写联系人姓名。</span>
        </div>
        <div class="tf">
        	<label>法人身份证号：</label>
            <div class="inp">
                <input name="tbxLegalPersonID" valid="idCard" type="text" id="tbxLegalPersonID" style="width:200px;" size="30" maxlength="20" value="{$objOrder->strLegalPersonId}"/>
            </div>
            <span class="info">请输入法人身份证号</span>
            <span class="ok">&nbsp;</span><span class="err">请输入核实正确的法人身份证号</span>
        </div>
        <div class="tf">
        	<label>营业执照号：</label>
            <div class="inp">
                <input name="tbxPermit" type="text" id="tbxPermit" style="width:200px;" size="30" maxlength="40" value="{$objOrder->strBusinessLicense}"/>
            </div>
            <span class="info">请输入客户营业执照号</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户营业执照号</span>
        </div> 
        <!--
        <div class="tf">
        	<label>公司网站：</label>
            <div class="inp">
            <input name="tbxComWebSite" type="text" id="tbxComWebSite" style="width:300px;" size="30" maxlength="50" value="{$objCustomerInfo->strWebsite}" valid="url"/>
            </div>
            <span class="info">请输入公司网址</span>
            <span class="ok">&nbsp;</span><span class="err">请输入公司网址</span>
        </div> -->
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
            <input value="{$objOrder->strContactMobile}" class="mPhone" valid="mPhone" type="text" id="contact_mobile"  name="contact_mobile" style="width:180px;" maxlength="20" />
          </div>
          <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
			<span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
    	</div>
    	<div class="tf">
          <label>固定电话：</label>
          <div class="inp">
            <input value="{$objOrder->strContactTel}" class="fPhone" type="text" valid="fPhone" id="contact_tel"  name="contact_tel" style="width:180px;" maxlength="20"/>
          </div>
          <span class="info">固话格式:0571-8888888</span>
	  <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号</span>
	 </div>
        <div class="tf">
          <label><em class="require">*</em>传真号码：</label>
          <div class="inp">
            <input value="{$objOrder->strContactFax}" class="faxPhone"  valid="faxPhone" type="text" id="contact_fax" name="contact_fax" valid="required" style="width:180px;" maxlength="20"/>
          </div>
          <span class="info">格式:0571-8888888</span>
          <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span> 
        </div>
        <div class="tf">
          <label><em class="require">*</em>电子邮箱：</label>
          <div class="inp">
            <input value="{$objOrder->strContactEmail}" class="email" type="text" id="contact_email" name="contact_email" valid="required" style="width:180px;" maxlength="50"/>
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
        <div class="tf">
        	<label>邮政编码：</label>
            <div class="inp">
            <input name="tbxPostCode" type="text" id="tbxPostCode" style="width:100px;" valid="postcode" size="30" maxlength="10" value="{$objCustomerInfo->strPostcode}"/>
            </div>
            <span class="info">请输入邮政编码</span>
            <span class="ok">&nbsp;</span><span class="err">请输入邮政编码</span>
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
    
    $("#selProvince1").BindProvince({iAll:"true",selCityID:"selCity1",selAreaID:"area_id1",iAddPleaseSelect:false,area_id:area_id1,city_id:selCity1,province_id:selProvince1,iAddPleaseSelect:true});                                   
	new Reg.vf($('#J_addOrder'),{extValid:{tbxRemark:function(e){return e.length<128}},callback:function(data){
	   
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
        if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
        
        _InDealWith = true;
        var backMsg = $PostData("/?d=OM&c=UnitOrder&a=OrderModifySubmit",$('#J_addOrder').serialize()+"&id="+id);
    
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
    }});
    
});

</script>
{/literal}
