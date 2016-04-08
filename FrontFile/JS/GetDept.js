/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司下拉列表数据绑定 部门下拉列表数据绑定 
 * 公司下拉列表Value 用 dept_no
 * 部门下拉列表Value 用 dept_id
 * data_type 0-部门 1-公司 2-中心 3-大区 5-组
 * 创建人：wzx
 * 添加时间：2011-7-15 
 * 修改人：      修改时间：
 * 修改描述：
 **/
var $Dept = {
    //公司数据json格式{dept_id: dept_no: dept_name: dept_type: data_type: dept_no:}
    CashData : null,
    CompanyOnly : function(cbCompany,companyAddNullOption){
         if (arguments.length == 0) {
            alert("参数有误！");
            return;            
        }
        
        if (companyAddNullOption == undefined || companyAddNullOption == null) {
            companyAddNullOption = true;
        }
        
        while (cbCompany.options.length > 0) {
            cbCompany.options[0] = null;
        }

        if (companyAddNullOption) {
            cbCompany.options[cbCompany.options.length] = new Option("请选择", "-100");
        }
        
        
        if ($Dept.CashData == null || String($Dept.CashData).length == 0) {
            $.ajax({
                async: false, //true 异步 默认true
                type: "POST",
                dataType: "text",
                url: "/?d=Common&c=Common&a=GetDepartment",
                data: "",
                success: function (data) {
                    $Dept.CashData = new String(data);
                }
            });
        }

        var jsonObj = eval("(" + $Dept.CashData + ")");
        var jsonObjLength = jsonObj.length;
        for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
            if (parseInt(jsonObj[cIndex].data_type) == 1)
                cbCompany.options[cbCompany.options.length] = new Option(jsonObj[cIndex].dept_name, jsonObj[cIndex].dept_no);
        }        
    },
    //cbCompany 公司下拉列表对象 cbDepartment部门下拉列表对象 addNullOption 是否添加请选择 includeGroup 是否包含组
    Init: function (cbCompany, cbDepartment, companyAddNullOption, deptAddNullOption, includeGroup) {
        if (arguments.length < 2) {
            alert("参数有误！");
            return;
        }

        if (companyAddNullOption == undefined || companyAddNullOption == null) {
            companyAddNullOption = true;
        }

        if (deptAddNullOption == undefined || deptAddNullOption == null) {
            deptAddNullOption = true;
        }

        if (includeGroup == undefined || includeGroup == null) {
            includeGroup = false;
        }

        while (cbCompany.options.length > 0) {
            cbCompany.options[0] = null;
        }

        while (cbDepartment.options.length > 0) {
            cbDepartment.options[0] = null;
        }

        if (companyAddNullOption) {
            cbCompany.options[cbCompany.options.length] = new Option("请选择", "-100");
        }
        
        if(deptAddNullOption) {
            cbDepartment.options[cbDepartment.options.length] = new Option("请选择", "-100");            
        }
        
        if ($Dept.CashData == null || String($Dept.CashData).length == 0) {
            $.ajax({
                async: false, //true 异步 默认true
                type: "POST",
                dataType: "text",
                url: "/?d=Common&c=Common&a=GetDepartment",
                data: "",
                success: function (data) {
                    $Dept.CashData = new String(data);
                }
            });
            //alert($Dept.CashData);
        }

        var jsonObj = eval("(" + $Dept.CashData + ")");
        var jsonObjLength = jsonObj.length;
        for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
            if (parseInt(jsonObj[cIndex].data_type) == 1)
                cbCompany.options[cbCompany.options.length] = new Option(jsonObj[cIndex].dept_name, jsonObj[cIndex].dept_no);
        }

        $(cbCompany).change(function () {//公司选择更改事件

            while (cbDepartment.options.length > 0) {
                cbDepartment.options[0] = null;
            }

            if (deptAddNullOption) {
                cbDepartment.options[cbDepartment.options.length] = new Option("请选择", "-100");
            }

            var companyNo = cbCompany.value;
            if (companyNo != "-100") {

                var jsonObj = eval("(" + $Dept.CashData + ")");
                var jsonObjLength = jsonObj.length;
                var div = document.createElement("div");
                var isIE = document.all ? true : false;
                for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
                    var deptType = parseInt(jsonObj[cIndex].dept_type);

                    if (jsonObj[cIndex].dept_no.indexOf(companyNo) == 0 && deptType != 1) {
                        if (includeGroup == false && deptType == 5)
                            continue;

                        div.innerHTML = getSpace(jsonObj[cIndex].dept_no) + jsonObj[cIndex].dept_name;
                        cbDepartment.options[cbDepartment.options.length] = new Option((isIE ? div.innerText : div.textContent), jsonObj[cIndex].dept_id);
                    }
                }
            }
        });

        function getSpace(deptPath) {
            var len = deptPath.length - 4;
            var tempL = 0;
            var strSpace = "";
            while (tempL < len) {
                strSpace += "&nbsp;&nbsp;";
                tempL += 2;
            }

            return strSpace;
        }
    }
}
