
function $DOM(elementName) {
    return $("#" + elementName)[0];
}

/*取得数据----------------------------b---------------------*/
/*
AJAX 取得数据 (非异步 会有等待)
Depart=$PostData("*.php","id=1"); 
*/
function $PostData(pUrl, pData) {
    var strReturn = "";
    $.ajax({
        async: false, //true 异步 默认true
        type: "POST",
        dataType: "text",
        url: pUrl,
        data: pData,
        success: function (data) {
            strReturn = data + "";
        }
    });

    return strReturn;
}

/*取得数据----------------------------e---------------------*/
/*******页面跳转*****begin******/

function PageListParams()
{
    this.pageID = "";
    this.values = "";
    this.page = 1;
    this.totalPage = 1;
    this.recordCount = 0;
    this.strUrl = "";
    this.dataId = 'pageListContent';
    this.selecter = null;
    this.param = "";
    this.sortField = "";//排序字段
    this.pageSize = 15;
}

var _aPageListParams = new Array();
function getPageID(pUrl)
{
    var divID = pUrl.replace(/\//g, "");
    divID = divID.replace(/\?/g, "");
    divID = divID.replace(/&/g, "");
    divID = divID.replace(/\=/g, "");
    divID = divID.replace(/;/g, "");
    return divID;
}

function aPageListParamsRemove(pageID)
{
    var index = -1;
    for(var i=0;i<_aPageListParams.length;i++)
    {
        if(_aPageListParams[i].pageID == pageID)
        {
            index = i;
            break;
        }
    }
    
    if(index > -1)
    {
        return _aPageListParams.splice(index,1)[0];
    }
    
    return null;
}

var historyManager = new HistoryManager();

historyManager.addListener(function() {
	var url = arguments[0];
    if(url != "")
    {
        url = "/?" + url;
        Config.recoverQuery = true;
        JumpPage(url,false);
        MenuCreate.SelectMenu(url);
        Config.recoverQuery = false;
    }
});


/*
pUrl要跳转的 地址
bStockUrlHistory 保存历史记录 true
bClearStockQueryData 是返回 false
*/
function JumpPage(pUrl, bStockUrlHistory, bClearStockQueryData) {
    if (bStockUrlHistory == undefined || bStockUrlHistory == null)
        bStockUrlHistory = true;

    if (bClearStockQueryData == undefined || bClearStockQueryData == null)
        bClearStockQueryData = false;

    var newPageListParams = new PageListParams(); 
    if (bClearStockQueryData == false && "undefined" != typeof pageList && pageList.strUrl != "") {
        /*=========================保存分页信息=====s==========*/
        try {
            newPageListParams.page = pageList.page;
            newPageListParams.totalPage = pageList.totalPage;
            newPageListParams.recordCount = pageList.recordCount;
            newPageListParams.strUrl = pageList.strUrl;
            newPageListParams.dataId = pageList.dataId;
            newPageListParams.selecter = pageList.selecter;
            newPageListParams.param = pageList.param;
            newPageListParams.sortField = pageList.sortField;
            newPageListParams.pageSize = pageList.pageSize;
        }
        catch (err) {

        }
        var QeryPanel = $("#J_table_filter_main");
        if (QeryPanel != undefined && QeryPanel != null && QeryPanel.html() != null) {
            //$("#iframeStockData").contents().find("#J_table_filter_main").remove();
            try {
                var stockPageDiv = document.createElement("div");
                var divID = getPageID(newPageListParams.strUrl);
                newPageListParams.pageID = divID;
                stockPageDiv.id = newPageListParams.pageID;
                stockPageDiv = $(stockPageDiv);
                stockPageDiv.append(QeryPanel);
                
                $("#iframeStockData").contents().find("#divQueryData").find("#"+newPageListParams.pageID).remove();
                $("#iframeStockData").contents().find("#divQueryData").append(stockPageDiv);
                
                aPageListParamsRemove(newPageListParams.pageID);
                _aPageListParams.push(newPageListParams);
            } catch (e) {
            }
        }
        /*=========================保存分页信息=====e==========*/
    }
    /*
    if(bClearStockQueryData == true)
        ClearStockQueryData();
    */
    RequestPageData(pUrl); 
    if (bStockUrlHistory == true) {
        historyManager.add(pUrl.replace("/?", ""));
    }
    
    IM.table.init();
    window.scrollTo(0,0);
}

function RequestPageData(pUrl)
{
    var ac_results = $(".ac_results");//没选的下拉菜单
    if (ac_results != undefined && ac_results != null)
    {
        ac_results.remove();
    }
    ac_results =  $(".ui_comboBox_layer");
    if (ac_results != undefined && ac_results != null)
    {
        ac_results.remove();
    }
    
    var openWaitDlg = true;
    var isOpenWaitDlg = false;

    setTimeout(function () {//如果0.4秒，数据没有加载完就显示等待对话框
        if (openWaitDlg) {
            isOpenWaitDlg = true;
            IM.dialog.show({
                width: 250,
                title: '',
                html: '<div class="loading2">页面加载中..</div>',
                hasBg: false
            });
        }
    }, 400);

    $("#mainContent").html($PostData(pUrl, ""));
    openWaitDlg = false;

    if (isOpenWaitDlg)
        IM.dialog.hide();
}

function ClearStockQueryData() {
    _aPageListParams.splice(0,_aPageListParams.length);
    $("#iframeStockData").contents().find("#divQueryData").children().remove();
}

/*--------------页面返回---------*/
function PageBack() {
    window.history.go(-1);
}
/*******页面跳转*****end******/

//重置表单值----------------------------b---------------------*/
function $Reset(divID) {

    $("#" + divID).find("input").each(function () {
        if (this.type == "text") {
            this.value = "";
        }
        else if (this.type == "hidden") {
            this.value = "-100";
        }
        else if (this.type == "checkbox") {
            this.checked = false;
        }
    });

    $("#" + divID).find("select").each(function () {
        if (this.options.length > 0) {
            this.options[0].selected = true;
            if (this.id == "cbDeptName" || this.id == "selCity" ||
            this.id == "selArea" || this.id == "cbProduct") {
                while (this.options.length > 1)
                    this.options[this.options.length - 1] = null;

                if (parseInt(this.options[0].value) > 0)
                    this.options[0] = null;
            }
        }

    });
}

//重置表单值----------------------------e---------------------*/
/*---------------------删除数据通用方法--------e------------*/
function ReMoveRow(obj, tableID) {
    var trCount = $("#" + tableID).find("tr").length;
    if (trCount == 2) {
        IM.tip.warn("最后一行不能删除！");
        return;
    }
    var tr = $(obj).parents('tr');
    tr.remove();
}

/*---------------------下拉列表数据绑定--------b------------*/
/**
* 下拉列表数据绑定 
*/
var cbDataBind = {
    dropDownListDataBind: function (dropDownListID, jsonData) {
        var dropDownListObj = $DOM(dropDownListID);
        while (dropDownListObj.options.length > 0) {
            dropDownListObj.options[0] = null;
        }
        dropDownListObj.options[dropDownListObj.options.length] = new Option("请选择", "-100");
        var jsonObj = eval("(" + jsonData + ")");
        var jsonObjLength = jsonObj.length;
        for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {
            dropDownListObj.options[dropDownListObj.options.length] = new Option(jsonObj[cIndex].text, jsonObj[cIndex].value);
        }
    },
    /**
    * 审核状态下拉列表 
    */
    CheckStatus: function (cbCheckStatusID) {
        cbDataBind.dropDownListDataBind(cbCheckStatusID, "[{'text':'未提交','value':'-2'},{'text':'审核未通过','value':'-1'},{'text':'审核中','value':'0'},{'text':'审核通过','value':'1'}]");
    },
    /**
    * 审核状态下拉列表 
    */
    AuditStatus: function (cbAuditStatusID) {
        cbDataBind.dropDownListDataBind(cbAuditStatusID, "[{'text':'未审核','value':'0'},{'text':'审核未通过','value':'-1'},{'text':'审核通过','value':'1'}]");
    },
    /**
    * 订单状态下拉列表 
    */
    OrderStatus: function (cbOrderStatusID) {
        cbDataBind.dropDownListDataBind(cbOrderStatusID, "[{'text':'未提交','value':'-2'},{'text':'审核未通过','value':'-1'},{'text':'审核中','value':'0'},{'text':'审核通过','value':'1'},{'text':'订单未处理','value':'2'},{'text':'订单处理中','value':'3'},{'text':'订单处理完毕','value':'50'},{'text':'已退单','value':'60'}]");
    },
    /**
    * 支付方式下拉列表 
    */
    PayTypes: function (cbPayTypesID) {
        cbDataBind.dropDownListDataBind(cbPayTypesID, "[{'text':'银行汇款','value':'8'},{'text':'网银支付','value':'7'},{'text':'其他','value':'15'}]");
    },
    /**
    * 客户订单列表 
    */
    OrderTypes: function (cbOrderTypesID) {
        cbDataBind.dropDownListDataBind(cbOrderTypesID, "[{'text':'新签','value':'1'},{'text':'续签','value':'2'},{'text':'赠品','value':'3'},{'text':'退单','value':'-1'}]");
    },
    /**
    * 订单款项状态
    */
    ValueProductPriceStatus: function (cbPriceStateID) {
        cbDataBind.dropDownListDataBind(cbPriceStateID, "[{'text':'已冻结','value':'1'},{'text':'已扣款','value':'2'},{'text':'未扣款','value':'-1'}]");
    },
    /**
    * 订单款项状态
    */
    AllianceProductPriceStatus: function (cbPriceStateID) {
        cbDataBind.dropDownListDataBind(cbPriceStateID, "[{'text':'已转款','value':'1'},{'text':'取消转款','value':'-1'}]");
    },
    /**
    * 发票类型
    */
    InvoiceTypes: function (cbInvoiceTypeID) {
        cbDataBind.dropDownListDataBind(cbInvoiceTypeID, "[{'text':'增值税专用发票','value':'1'},{'text':'服务业发票','value':'2'},{'text':'增值税普票','value':'3'},{'text':'电信增值服务业发票','value':'4'},{'text':'其他服务业发票','value':'6'}]"); //5是常规收据 
    },
    /**
    * 账户类型
    */
    AccountTypes: function (cbAccountTypeID) {
        cbDataBind.dropDownListDataBind(cbAccountTypeID, "[{'text':'保证金','value':'1'},{'text':'增值产品预存款','value':'2'},{'text':'网盟预存款','value':'7'}]"); 
    },
    /**
    * 账户类型
    */
    AccountDetailTypes: function (cbAccountTypeID) {
        cbDataBind.dropDownListDataBind(cbAccountTypeID, "[{'text':'保证金','value':'1'},{'text':'增值产品预存款','value':'2'},{'text':'销奖转预存账户','value':'6'},{'text':'网盟预存款','value':'7'},{'text':'网盟返点账户','value':'8'}]"); 
    },
    /**
    * 预存款账户类型
    */
    PreAccountTypes: function (cbAccountTypeID) {
        cbDataBind.dropDownListDataBind(cbAccountTypeID, "[{'text':'增值产品预存款','value':'2'},{'text':'网盟预存款','value':'7'}]"); 
    },
    /**
    * 打款数据类型
    */
    PostMoneyDataTypes: function (cbPostMoneyDataTypeID) {
        cbDataBind.dropDownListDataBind(cbPostMoneyDataTypeID, "[{'text':'保证金','value':'1'},{'text':'增值产品预存款','value':'2'},{'text':'网盟预存款','value':'17'}]"); 
    }
};
var PayTypes = {//支付方式
    BankTransfer: 8, //银行汇款
    OnlineBankingPayment: 7, //网银支付
    Cash: 1, //现金
    QuickMoney: 11//快钱
}
/*---------------------下拉列表数据绑定--------e------------*/

function UserDetial(uid) {
    if (uid == undefined || uid == null)
        uid = 0;

    if (uid == "" || parseInt(uid) <= 0)
        IM.tip.warn("未传入用户ID！");

    IM.dialog.show({
        width: 500,
        height: null,
        title: '账号信息',
        html: IM.STATIC.LOADING,
        start: function () {
            $('.DCont').html($PostData("/?d=System&c=User&a=UserDetial&id=" + uid, ""));
        }
    });
}

function UserSupDetial(eid) {
    $('.DCont').html($PostData("/?d=System&c=User&a=UserSupDetialEmpl&eid=" + eid, ""));
}
/**
* 代理商用户信息的弹窗显示
*/
function AgentUserSupDetial(id) {
    $('.DCont').html($PostData("/?d=System&c=User&a=UserDetialAgentInter&id=" + id, ""));
}
/**
* 订单审核信息的弹窗显示
*/
function GetOrderAuditList(orderID) {
    IM.agent.getTableList('/?d=OM&c=Order&a=AuditList', "id=" + orderID, '审核信息', 700);
}

/**
* 订单状态信息的弹窗显示
*/
function OrderStatusInfo(orderID) {
    var jsonData = $PostData("/?d=OM&c=Order&a=AuditInfo&id=" + orderID, "");
    var jsonObj = eval("(" + jsonData + ")");
    if (jsonObj["success"] == true)
        IM.agent.getTableList(jsonObj["msg"], "id=" + orderID, '产品订单流程', 900);
    else
        IM.tip.warn(jsonObj["msg"]);
}

function ClearText(obj, length) {
    if (arguments.length != 2)
        length = 500;

    if (length <= 0)
        length = 50000;

    var v = obj.value.replace(/'/g, '’');
    v = v.replace(/,/g, '，');
    obj.value = v;

    if (obj.value.length > length) {
        IM.tip.warn("超过" + length + "字符限制，已将字符串截取");
        obj.value = obj.value.substring(0, length);
        if (obj.type == "text" && obj.readOnly == false && obj.style.display != "none")
            obj.focus();
    }
}

///数字
function NumberOnly(event) {
    event = event ? event : (window.event ? window.event : null);
    ///0-9数字键输入
    if ((event.keyCode < 58 && event.keyCode > 0) || (event.keyCode < 106 && event.keyCode > 95) || event.keyCode == 100)
        return true;
    return false;
}

function FloatNumber(obj) {
    if ('' != obj.value.replace(/\d{1,}\.{0,1}\d{0,}/, '')) {
        obj.value = obj.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' : obj.value.match(/\d{1,}\.{0,1}\d{0,}/);
    }
}
/*
*显示客户信息卡片
*/
function ShowCustomerCard(id) {
    IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ', { 'id': id }, '客户基本信息', 700);
}

/*
*显示代理商信息卡片
*/
function ShowAgentCard(id) {
    IM.agent.getAgentInfoCard({ 'id': id });
}


function ViewPic(path,windowName)
{
    if (windowName == undefined || windowName == null)
        windowName = "";
        
    if(path.indexOf("|") < 0)
       window.open(path, windowName);
    else 
       window.open("/?a=ViewImage&filePath="+path, windowName);
}

function ShowRevisitCard(RecordID){
    if (RecordID == undefined || RecordID == null)
        RecordID = 0;

    if (RecordID == "" || parseInt(RecordID) <= 0)
    {
        IM.tip.warn("未传入小记ID！");
        return ;
    }
        
    IM.dialog.show({
        width: 500,
        height: null,
        title: '回访信息',
        html: IM.STATIC.LOADING,
        start: function () {
            $('.DCont').html($PostData("/?d=CM&c=ContactRecord&a=getRevisitCard&id=" + RecordID, ""));
        }
    });
}

function showConatctCard(contact_id){
         IM.dialog.show({
            width:500,
            height:null,
            title:'联系人信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showConatctCard&contact_id="+contact_id,""));
            }
         })
    }
    
    function GetRecordDetail(id)
{
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "小记明细",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=GetContactRecordDetail&id="+id, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
            
        });
      }
    });
}

//预计到账信息卡片

function getAgentIncomeInfoFromNote($iNoteId){
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "预计到账信息",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=WorkM&c=TelWork&a=getIncomeInfoFromNote&noteId="+$iNoteId, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
            
        });
      }
    });
}
//电话小记信息卡片
function getTelNoteDetail($iNoteId){
       IM.dialog.show({
        width: 900,
	    height: null,
	    title: "电话小记信息",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=WorkM&c=TelWork&a=getTelNoteDetail&noteId="+$iNoteId, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
            
        });
      }
    });
}

//拜访小记信息卡片

function getVisitNoteDetail($iNoteId){
       IM.dialog.show({
        width: 900,
	    height: null,
	    title: "拜访小记信息",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=WorkM&c=VisitAppoint&a=getVisitNoteDetail&noteId="+$iNoteId, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
            
        });
      }
    });
}

var $FinanceUser = {
    CashData : null,
    SpaceLength : 2,
    //cbFinanceUserID 下拉列表对象ID onlySub只显示下级 addNullOption 是否添加请选择
    Bind: function (cbFinanceUserID,onlySub, addNullOption) {
        if (arguments.length < 1) {
            alert("参数有误！");
            return;
        }

        if (onlySub == undefined || onlySub == null) {
            onlySub = false;
        }
        
        if (addNullOption == undefined || addNullOption == null) {
            addNullOption = true;
        }
        cbFinanceUser = $DOM(cbFinanceUserID);
        while (cbFinanceUser.options.length > 0) {
            cbFinanceUser.options[0] = null;
        }

        if(addNullOption) {
            cbFinanceUser.options[cbFinanceUser.options.length] = new Option("请选择", "-100");            
        }
        
        if ($FinanceUser.CashData == null) {
            $.ajax({
                async: false, //true 异步 默认true
                type: "POST",
                dataType: "text",
                url: "/?d=System&c=AgentUser&a=GetFinanceUser",
                data: "",
                success: function (data) {
                    data = data.split("##");
                    $FinanceUser.CashData = new String(data[0]);
                    $FinanceUser.SpaceLength = data[1];
                }
            });
            //alert($FinanceUser.CashData);
        }

        var jsonObj = eval("(" + $FinanceUser.CashData + ")");
        var jsonObjLength = jsonObj.length;
        var div = document.createElement("div");
        var isIE = document.all ? true : false;
        for (var cIndex = (onlySub?1:0); cIndex < jsonObjLength; cIndex++) {
            div.innerHTML = getSpace(jsonObj[cIndex].f_no,onlySub) + jsonObj[cIndex].user_name;
            cbFinanceUser.options[cbFinanceUser.options.length] = new Option((isIE ? div.innerText : div.textContent), jsonObj[cIndex].user_id);
        }
        
        function getSpace(path,onlySub) {
            var len = path.length - $FinanceUser.SpaceLength - (onlySub?2:0);
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