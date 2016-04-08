<?php /* Smarty version 2.6.26, created on 2013-03-08 09:47:11
         compiled from OM/OrderPost1.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：订单管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=MyOrderList')">增值产品订单库</a><span>&gt;</span><?php echo $this->_tpl_vars['strTitle']; ?>
</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2><?php echo $this->_tpl_vars['strTitle']; ?>
</h2>
            </div>
        </div>
    </div>
    <span class="declare">
    “<em class="require">*</em>”为必填信息
    </span>
</div>
<div class="form_bd">
	<form id="J_addOrder" action="" name="newOrderModifyForm" class="newOrderModifyForm">
        <div class="tf" style="padding-top:20px;">
        	<label><em class="require">*</em>产品：</label>
            <div class="inp">
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType" style="width:120px"></select></div>
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProduct" name="cbProduct" style="width:160px"></select></div>
            </div>
        </div> 
        <div class="tf">
        	<label><input name="tbxProudctPrice" id="tbxProudctPrice" type="hidden" valid="" value="0" />产品价格：</label>
            <div class="inp">
            <div id="divProudctPrice">￥0.00</div>
            </div>
        </div>
        <div class="tf">
        	<label><em class="require">*</em>客户名称：</label>
            <div class="inp"><input name="tbxCustomerID" id="tbxCustomerID" type="hidden" value="-100" />
            <input name="tbxCustomerName" type="text" id="tbxCustomerName" style="width:280px;" size="30" maxlength="32" value=""  valid="required isNull"/>
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
    </form>                             
</div> 
</div>
<!--E sidenav_neighbour--> 

<?php echo '
<script language="javascript" type="text/javascript">
var _InDealWith = false;
$(function(){
    '; ?>

    var agentID = parseInt(<?php echo $this->_tpl_vars['iAgentId']; ?>
);
    <?php echo '
  
    $GetProduct.Init("cbProductType", "cbProduct", true, "divProudctPrice",ProductGroups.ValueIncrease,ProductDataTypes.CurrentSignedProductType);
    
	function v_isNull(e){return $.trim(e)!=\'\';}                                       
	new Reg.vf($(\'#J_addOrder\'),{extValid:{isNull:v_isNull},callback:function(data){
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
        
        var cbProductType = $DOM("cbProductType");
        var cbProduct  = $DOM("cbProduct");
        var productID = parseInt(cbProduct.value);
        if(productID <= 0)
        {
             IM.tip.warn("请选择产品！");
             return ;
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
        
        var notPostOrderCount = $PostData("/?d=OM&c=Order&a=OrderIsNotPost","productID="+productID+"&customerID="+customerID);
        
        if(isNaN(notPostOrderCount))
        {
            IM.tip.warn(notPostOrderCount);                
            return ;
        }
        
        if(parseInt(notPostOrderCount) >=1 )
        {
            if(!confirm("当前客户已有"+notPostOrderCount+"个相同的订单在“增值产品订单库”中，您确定需要再次提交该产品订单吗？"))
                return ;            
        }
        
        $("#tbxProudctPrice").val($DOM("divProudctPrice").innerHTML);
        $price = $("#tbxProudctPrice").val();
        $price = $price.replace(/￥/g,"");
        $price = $price.replace(/,/g,"");
        $price = parseFloat($price);
        
        if($price <= 0)
        {
            IM.tip.warn("请联系盘石客服设置产品价格！");
            return ;
        }
        
        var productText = cbProductType.options[cbProductType.selectedIndex].text + ">" + cbProduct.options[cbProduct.selectedIndex].text;
        _InDealWith = true;
    	$.ajax({
    	    url:\'/?d=OM&c=Order&a=OrderPost1Submit\',
    	    data:$(\'#J_addOrder\').serialize(),
    	    type:"post",
    	    success:function(backData){
    	    	if(backData.indexOf("0,") == 0)
                {
                    _InDealWith = false; 
                    var url = backData.substring(2)+"&"+$(\'#J_addOrder\').serialize()+"&productText="+encodeURIComponent(productText);

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

$("#cbProduct").change(function () {//取得产品价格
    var price = $PostData("/?d=OM&c=Order&a=AgentProductPrice","productID="+$("#cbProduct").val())
    $("#divProudctPrice").html(price);
});

$(\'#tbxCustomerName\').autocomplete(\'/?d=OM&c=Order&a=AutoCustomerJson\', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
'; ?>
