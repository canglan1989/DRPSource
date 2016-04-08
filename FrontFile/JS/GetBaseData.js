var BaseDataType = {
    payType :"paytype"
}

var GetBaseData = {
    payTypeData : null,
    PayType : function (cbPayType,addNullOption){
        if (addNullOption == undefined || addNullOption == null) {
            addNullOption = true;
        }
        
        while (cbPayType.options.length > 0) {
            cbPayType.options[0] = null;
        }

        if (addNullOption) {
            cbPayType.options[cbPayType.options.length] = new Option("请选择", "-100");
        }
        
        if(payTypeData == null){
            payTypeData = $PostData('/?d=Common&c=BaseData&d=GetPayType');
        }
         
        var jsonObj = eval("(" + GetBaseData.payTypeData + ")");
        var jsonObjLength = jsonObj.length;
        for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
            cbPayType.options[cbPayType.options.length] = new Option(jsonObj[cIndex].name, jsonObj[cIndex].value);
        }  
    }
    
}