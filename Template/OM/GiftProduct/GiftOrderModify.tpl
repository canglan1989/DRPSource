<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：订单管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=OM&c=GiftOrder&a=MyGiftOrderList')">赠送产品订单库</a><span>&gt;</span>{$strTitle}</div>
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
        <form id="form1" class="newAccountForm" name="form1" action="" style="padding-top:10px;">
      
        <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">网营专家 以客户为单位，一个客户在订单的有效期内只能赠送一次网营专家； LINK 以域名为单位，在订单的有效期内，一个域名只可以赠送一次LINK。</span></div>
        <div class="form_block_bd">
            <div class="tf">
                <label style="width:120px;"><input type="hidden" name="tbxID" value="{$objOrder->iOrderId}" id="tbxID" />
                <input type="hidden" name="tbxSourceOrderID" value="{$objOrder->iSourceOrderId}" id="tbxSourceOrderID" /><em class="require">*</em>购买产品订单号：</label>
                <div class="inp"><input type="text" id="tbxSourceOrderNo" name="tbxSourceOrderNo" value="{$objOrder->strSourceOrderNo}" autocomplete="off" valid="required" style="width:250px;"/></div>
                <span class="info">请输入购买产品订单号。（网盟订单，需开户成功；增值订单，则需审核通过）</span>
            	<span class="ok">&nbsp;</span><span class="err">请输入购买产品订单号</span>
            </div>
            <div id="divCustomerName" {if $objOrder->iOrderId == 0} style="display:none" {/if} class="tf">
        	<label>客户名称：</label>
                <div class="inp">
                  <span id="spanCustomerName">{$objOrder->strCustomerName}</span>
                </div>
            </div>
            <div id="divProductName" {if $objOrder->iOrderId == 0} style="display:none" {/if} class="tf">
        	<label>产品：</label>
                <div class="inp">
                  <span id="spanProductName">{$objSourceOrderProductInfo->strProductName}</span>
                </div>
            </div>
            <div id="divOrderDate" {if $objOrder->iOrderId == 0 || $objOrder->strEffectSDate == $objOrder->strEffectEDate } style="display:none" {/if} class="tf">
        	<label>订单有效期：</label>
                <div class="inp">
                  <span id="spanOrderDate">{$objOrder->strEffectSDate|date_format:"%Y-%m-%d"} -- {$objOrder->strEffectEDate|date_format:"%Y-%m-%d"}</span> 
                </div>
            </div>
            <div class="tf">
        	<label><em class="require">*</em>赠送产品：</label>
                <div class="inp">
                  <select id="cbGiftProduct" style="width:150px" name="cbGiftProduct">
                  </select>
                </div>
                <span class="info">请选择赠送产品</span>
                <span class="ok">&nbsp;</span><span class="err">请选择赠送产品</span>
            </div>
            <div class="tf">
        	<label><em class="require">*</em>网站域名：</label>
                <div class="inp">
                    <input name="tbxWebSite" type="text" id="tbxWebSite" style="width:250px;" size="30" maxlength="50" value="{$objOrder->strOwnerDomainUrl}" valid="required url"/>
                </div>
                <span class="info">请输入客户网站域名</span>
                <span class="ok">&nbsp;</span><span class="err">请输入客户网站域名</span>
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
            </div>   
        <div class="tf">
           <label>备注：</label>
           <div class="inp"><textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark" valid="tbxRemark">{$objOrder->strOrderRemark}</textarea></div> 
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
<!--S Main--> 
{literal} 
<script type="text/javascript" language="javascript">
 $(function(){
{/literal} 
var sourceProductTypeID = "{$objSourceOrderProductInfo->iProductTypeId}";
var productID = "{$objOrder->iProductId}";
{literal} 
    sourceProductTypeID = parseInt(sourceProductTypeID);
    if(!isNaN(sourceProductTypeID))
    {
        UpdateGiftSelect(sourceProductTypeID);
        $("#cbGiftProduct").val(productID);
    }
 });
$('#tbxSourceOrderNo').autocomplete('/?d=OM&c=GiftOrder&a=AutoOrderJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
    max: 8, //只显示8
    width: 320, //下拉列表的宽
    parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
        $("#tbxSourceOrderID").val("-100");
        var parsed = [];
        if(backData == "" || backData.length == 0)
            return parsed;                                
        backData = MM.json(backData);
        var value = backData.value;
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
        return "<div>" + item.name+" "+item.customer_name +" "+ item.order_product_type_name + "</div>";
    }
}).result(function (data,value) {//执行模糊匹配
    var id = value.id;
    $("#tbxSourceOrderID").val(id);
    
    var jsonData = $PostData("/?d=OM&c=GiftOrder&a=GetOrderInfoJson","orderID="+id);
    var jsonObj = eval("(" + jsonData + ")");
    
    $DOM("divCustomerName").style.display = "";
    $DOM("divProductName").style.display = "";
    if(jsonObj.ordersdate == "2000-01-01" && jsonObj.orderedate == "2000-01-01")
    {
        $DOM("divOrderDate").style.display = "none";
    }
    else
    {
        $DOM("divOrderDate").style.display = "";
    }
    
    $("#spanCustomerName").html(jsonObj.customer_name);
    $("#spanProductName").html(value.order_product_type_name);
    $("#spanOrderDate").html(jsonObj.ordersdate+" -- "+jsonObj.orderedate);
    
    $("#tbxContactName").val(jsonObj.contact_name);
    $("#contact_mobile").val(jsonObj.contact_mobile);
    $("#ontact_tel").val(jsonObj.ontact_tel);
    $("#contact_fax").val(jsonObj.contact_fax);
    $("#contact_email").val(jsonObj.contact_email);
    $("#tbxWebSite").val(jsonObj.owner_domain_url);
    
    UpdateGiftSelect(value.order_product_type_id);
});


function UpdateGiftSelect(order_product_type_id)
{
    var backData = $PostData("/?d=OM&c=GiftOrder&a=UpdateGiftSelect","order_product_type_id="+order_product_type_id);    
    cbDataBind.dropDownListDataBind("cbGiftProduct",backData);
    var cbGiftProduct = $DOM("cbGiftProduct");
    if(cbGiftProduct.options.length == 2)
    {
        cbGiftProduct.options[1].selected = true;
    }
}

var _InDealWith = false;
new Reg.vf($('#form1'),{callback:function(data){
    //数据已提交，正在处理标识
    if (_InDealWith) 
    {
        IM.tip.warn("数据已提交，正在处理中！");
        return false;
    }
    
    _InDealWith = true;
    var backData = $PostData("/?d=OM&c=GiftOrder&a=GiftOrderModifySubmit",$('#form1').serialize());
    if(backData.indexOf("0,") == 0)
    {        
        id= backData.split(",");
		JumpPage("/?d=OM&c=Order&a=OrderDetail&id="+id[1],false);
	    _InDealWith = false;
        _InDealWith = false;
    }
    else
    {
        $('#tbxPost').val(0);
        IM.tip.warn(backData);
        _InDealWith = false;
    }
}});
                             
</script> 
{/literal} 
