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
    {if $iPactNotEffect == 1}
    <div class="tf" style="padding-top:20px;">
        	<label>&nbsp;</label>
            <div class="inp">
            您好，因您的网盟合同到期，提交订单入口已关闭。
            </div>
        </div> 
    {else}
    <div class="tf" style="padding-top:20px;">
        	<label><input type="hidden" value="{$iProductID}" id="cbProduct"  name="cbProduct"/>产品：</label>
            <div class="inp">
            网盟
            </div>
        </div> 
        <div class="tf">
        	<label><em class="require">*</em>客户名称：</label>
            <div class="inp"><input name="tbxCustomerID" id="tbxCustomerID" type="hidden" value="{$customer_id}" />
            <input name="tbxCustomerName" type="text" id="tbxCustomerName" style="width:280px;" size="30" maxlength="32" value="{$customer_name}"  valid="required isNull"/>
            </div>
            <span class="info">请输入客户名称</span>
            <span class="ok">&nbsp;</span><span class="err">请输入客户名称</span>
        </div>  
        <div class="tf tf_submit" style="padding:20px 0;">
           <label>&nbsp;</label>
            <div class="inp">
	    <div class="ui_button"><div class="ui_button_left"></div><button class="ui_button_inner" type="submit">下一步</button></div>
            <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
            </div>
            </div>
        </div>
     {/if}
    </form>                             
</div> 
</div>
<!--E sidenav_neighbour--> 

{literal}
<script language="javascript" type="text/javascript">
var _InDealWith = false;
$(function(){
  
	function v_isNull(e){return $.trim(e)!='';}                                       
	new Reg.vf($('#J_addOrder'),{extValid:{isNull:v_isNull},callback:function(data){
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
        var customerID = parseInt($("#tbxCustomerID").val());
        if(customerID <= 0)
        {
            if($("#tbxCustomerName").val() != "")
                IM.tip.warn("该客户不属于你的有效客户！");
            else
                IM.tip.warn("请选择客户！");
                
             return ;
        }
        productID = parseInt($("#cbProduct").val());        
        var notPostOrderCount = $PostData("/?d=OM&c=Order&a=OrderIsNotPost","productID="+productID+"&customerID="+customerID);        
        if(isNaN(notPostOrderCount))
        {
            IM.tip.warn(notPostOrderCount);                
            return ;
        }
        
        if(parseInt(notPostOrderCount) >=1 )
        {
            if(!confirm("当前客户已有"+notPostOrderCount+"个相同的订单在“网盟订单库”中，您确定需要再次提交该产品订单吗？"))
                return ;            
        }
                
        var productText = "网盟";
        _InDealWith = true;
    	$.ajax({
    	    url:'/?d=OM&c=Order&a=UnitOrderPost1Submit',
    	    data:$('#J_addOrder').serialize(),
    	    type:"post",
    	    success:function(backData){
    	    	if(backData.indexOf("0,") == 0)
                {
                    _InDealWith = false; 
                    var url = backData.substring(2)+"&"+$('#J_addOrder').serialize()+"&productText="+encodeURIComponent(productText);

                    JumpPage(url,false);
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

$('#tbxCustomerName').autocomplete('/?d=OM&c=Order&a=AutoCustomerJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
    max: 8, //只显示8
    width: 280, //下拉列表的宽
    parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
        $("#tbxCustomerID").val("-100");
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
        return "<div>" + item.no +" "+item.name +""+ "</div>";
    }
}).result(function (data,value) {//执行模糊匹配
    var id = value.id;
    $("#tbxCustomerID").val(id);    
});

</script>
{/literal}
