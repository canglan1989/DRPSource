/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：取得产品
 * 创建人：wzx
 * 添加时间：2011-8-8 
 * 修改人：      修改时间：
 * 修改描述：
 **/
var ProductGroups = {
    /**
     * 所有
    */
    All : -1,
    /**
     * 增值
    */
    ValueIncrease : 0,
    /**
     * 网盟
    */
    NetworkAlliance : 1
};
var ProductDataTypes = {
    /**
     * 所有
    */
    All : -1,
    /**
     * 签过约的 
    */
    SignedProductType : 0,
    /**
     * 当前有效的
    */
    CurrentSignedProductType : 1
};

var $GetProduct = {    
    CashData : null,
    ProductTypes : null,
    SignedProductTypes : null,  
    CurrentSignedProductTypes : null, 
    GiftProducts : null,  
    BindGiftProduct : function(cbProductID){//赠品 用的是产品表的ID
         if (arguments.length == 0) {
            alert("参数有误！");
            return;            
        }        
        var cbProduct = $DOM(cbProductID);
        cbProduct.options[cbProduct.options.length] = new Option("请选择", "-100");
        if ($GetProduct.GiftProducts == null || String($GetProduct.GiftProducts).length == 0) {
            $GetProduct.GiftProducts = $PostData("/?d=PM&c=Product&a=GetGiftProductJson","");
        }
    
        var jsonObj = eval("(" + $GetProduct.GiftProducts + ")");
        var jsonObjLength = jsonObj.length;
               
        for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
            var subJsonObj = jsonObj[cIndex].products;
            var subJsonObjLength = subJsonObj.length;
            
            for (var sIndex = 0; sIndex < subJsonObjLength; sIndex++) {
                cbProduct.options[cbProduct.options.length] = new Option(subJsonObj[sIndex].Name, subJsonObj[sIndex].ID);
            }
        }
    },
    BindProductType : function(cbProductTypeID,addNullOption,produdtGroup){//产品类型，如果是代理商的则显示所有签单产品和赠品
         if (arguments.length == 0) {
            alert("参数有误！");
            return;            
        }        
        
        if (addNullOption == undefined || addNullOption == null) {
            addNullOption = true;
        } 
        
        if (produdtGroup == undefined || produdtGroup == null) {
            produdtGroup = ProductGroups.All;
        }
                        
        if ($GetProduct.ProductTypes == null || String($GetProduct.ProductTypes).length == 0) {
            $GetProduct.ProductTypes = $PostData("/?d=PM&c=ProductType&a=GetProductTypeJson","");
        }
        
        $GetProduct._bindProductType(cbProductTypeID,addNullOption,produdtGroup,$GetProduct.ProductTypes);
    },
    BindSignedProductType : function(cbProductTypeID,addNullOption,produdtGroup){//代理商 所有签单产品 不包括赠品
         if (arguments.length == 0) {
            alert("参数有误！");
            return;            
        }        
        if (addNullOption == undefined || addNullOption == null) {
            addNullOption = true;
        } 
        
        if (produdtGroup == undefined || produdtGroup == null) {
            produdtGroup = ProductGroups.All;
        }
        
        if ($GetProduct.SignedProductTypes == null || String($GetProduct.SignedProductTypes).length == 0) {
            $GetProduct.SignedProductTypes = $PostData("/?d=PM&c=ProductType&a=GetSignedProductTypeJson","");
        }
        
        $GetProduct._bindProductType(cbProductTypeID,addNullOption,produdtGroup,$GetProduct.SignedProductTypes);
    },
    BindCurrentSignedProductType : function(cbProductTypeID,addNullOption,produdtGroup){//代理商 当前有效的签单产品 不包括赠品
         if (arguments.length == 0) {
            alert("参数有误！");
            return;            
        }        
        if (addNullOption == undefined || addNullOption == null) {
            addNullOption = true;
        } 
        
        if (produdtGroup == undefined || produdtGroup == null) {
            produdtGroup = ProductGroups.All;
        }
        
        if ($GetProduct.CurrentSignedProductTypes == null || String($GetProduct.CurrentSignedProductTypes).length == 0) {
            $GetProduct.CurrentSignedProductTypes = $PostData("/?d=PM&c=ProductType&a=GetCurrentSignedProductTypeJson","");
        }
        
        $GetProduct._bindProductType(cbProductTypeID,addNullOption,produdtGroup,$GetProduct.CurrentSignedProductTypes);
    },
    _bindProductType : function(cbProductTypeID,addNullOption,produdtGroup,productTypesJson)
    {
        var cbProductType = $DOM(cbProductTypeID);
        while (cbProductType.options.length > 0) {
            cbProductType.options[0] = null;
        }

        if (addNullOption) {
            cbProductType.options[cbProductType.options.length] = new Option("请选择", "-100");
        }
                
        var jsonObj = eval("(" + productTypesJson + ")");
        var jsonObjLength = jsonObj.length;
        if(produdtGroup != ProductGroups.All)
        {
            for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) { 
                if(parseInt(jsonObj[cIndex].typeGroup) == produdtGroup) //0增值产品 1网盟产品
                    cbProductType.options[cbProductType.options.length] = new Option(jsonObj[cIndex].typeName, jsonObj[cIndex].typeID);
            }
        }
        else
        {            
            for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {            
                cbProductType.options[cbProductType.options.length] = new Option(jsonObj[cIndex].typeName, jsonObj[cIndex].typeID);
            }
        } 
    },
    Init: function (cbProductTypeID, cbProductID, addNullOption,priceDiv,produdtGroup, productDataType) {
        if (arguments.length < 2) {
            alert("参数有误！");
            return;
        }        
        
        if (addNullOption == undefined || addNullOption == null) {
            addNullOption = true;
        }
        
        if (priceDiv == undefined || priceDiv == null) {
            priceDiv = "";
        }
        
        if (produdtGroup == undefined || produdtGroup == null) {
            produdtGroup = ProductGroups.All;
        }
        
        if (productDataType == undefined || productDataType == null) {
            productDataType = ProductDataTypes.All;
        }
        
        var cbProduct = $DOM(cbProductID);
        while (cbProduct.options.length > 0) {
            cbProduct.options[0] = null;
        }

        if (addNullOption) {
            cbProduct.options[cbProduct.options.length] = new Option("请选择", "-100");       
        }
        
        if ($GetProduct.CashData == null || String($GetProduct.CashData).length == 0) {
            $GetProduct.CashData = $PostData("/?d=PM&c=Product&a=GetProductJson","");
        }
        
        if(productDataType == ProductDataTypes.All)
            $GetProduct.BindProductType(cbProductTypeID,addNullOption,produdtGroup);
        else if(productDataType == ProductDataTypes.CurrentSignedProductType)
            $GetProduct.BindCurrentSignedProductType(cbProductTypeID,addNullOption,produdtGroup);
        else 
            $GetProduct.BindSignedProductType(cbProductTypeID,addNullOption,produdtGroup);
        
        /*----------------cbProductType   change--------------------begin---------------------*/
        var cbProductType = $DOM(cbProductTypeID);
        $(cbProductType).change(function () {
            $GetProduct._productTypeChange(cbProductType, cbProduct, addNullOption, priceDiv);
        });      
    },
    _productTypeChange : function (cbProductType, cbProduct,addNullOption ,priceDiv){
    
        if (priceDiv == undefined || priceDiv == null) {
            priceDiv = "";
        }
        
        while (cbProduct.options.length > 0) {
            cbProduct.options[0] = null;
        }

        if (addNullOption) {
            cbProduct.options[cbProduct.options.length] = new Option("请选择", "-100");
        }
        
        if(priceDiv != "")
            $("#"+priceDiv).html("￥0.00");
            
        var typeID = parseInt(cbProductType.value);
        if (typeID != -100) {

            var jsonObj = eval("(" + $GetProduct.CashData + ")");
            var jsonObjLength = jsonObj.length;
           
            for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
                var proTypeID = parseInt(jsonObj[cIndex].typeID);

                if (proTypeID == typeID) {
                    var subJsonObj = jsonObj[cIndex].products;
                    var subJsonObjLength = subJsonObj.length;
                    
                    for (var sIndex = 0; sIndex < subJsonObjLength; sIndex++) {
                        cbProduct.options[cbProduct.options.length] = new Option(subJsonObj[sIndex].Name, subJsonObj[sIndex].ID);
                    }
                }
            }
        }
    },
        /*----------------cbProductType   change--------------------end---------------------*/  
    GetProductNo : function(typeID , productID){
        typeID = parseInt(typeID);
        productID = parseInt(productID);
        if (productID > 0) {

            var jsonObj = eval("(" + $GetProduct.CashData + ")");
            var jsonObjLength = jsonObj.length;
           
            for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
                var proTypeID = parseInt(jsonObj[cIndex].typeID);

                if (proTypeID == typeID) {
                    var subJsonObj = jsonObj[cIndex].products;
                    var subJsonObjLength = subJsonObj.length;
                    for (var sIndex = 0; sIndex < subJsonObjLength; sIndex++) {
                        if(parseInt(subJsonObj[sIndex].ID) == productID)
                            return subJsonObj[sIndex].No;
                    }
                }
            }
        }
        
        return "";
    },    
    Select: function (cbProductTypeID, cbProductID, addNullOption, typeID, productID, priceDiv, produdtGroup, productDataType) {
      
        $GetProduct.Init(cbProductTypeID, cbProductID, addNullOption,priceDiv,produdtGroup, productDataType);
        $("#"+cbProductTypeID).val(typeID);
        $GetProduct._productTypeChange($DOM(cbProductTypeID), $DOM(cbProductID), addNullOption ,"");
        $("#"+cbProductID).val(productID);
    }
}