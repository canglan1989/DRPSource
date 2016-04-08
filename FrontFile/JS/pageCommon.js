//添加排序事件
$(function () {
    var $sortTDs=$('[sort^="sort_"]');
    $sortTDs.click(function () {
        var field = this.attributes["sort"].nodeValue.slice(5);
        field = field.toLowerCase();
        aFieldOrders = field.split(",");
        
        var order = "";
        if (this.order) {
            order = this.order == "asc" ? "desc" : "asc";
        }
        else {
            order = "asc";
        }
        this.order = order;
        var strSortField = "";
        
        for(var i=0;i<aFieldOrders.length;i++)
        {
            strSortField += aFieldOrders[i] + " " + order;
            if(i != aFieldOrders.length -1)
                strSortField += ",";
        }
        pageList.sortField = strSortField;
        
        pageList.first();
        $sortTDs.each(function(){
            $(this).removeClass("order_asc");
            $(this).removeClass("order_desc");
			$(this).removeClass('ui_table_thcntr_sort');
        });
        if (this.order == "asc") {
            $(this).addClass("order_asc");
        }
        else {
            $(this).addClass("order_desc");
        }
		$(this).addClass("ui_table_thcntr_sort");
    }).each(function () {
        this.style.cursor = "pointer";
    });
})
//分页
var pageList = {
    page: 1,
    totalPage: 1,
    recordCount: 0,
    strUrl: '',
    dataId: 'pageListContent',
    selecter: null,
    param: '',
    sortField: "", //排序字段
    pageSize: 15,
    init: function () {
        var pageHtml = "<div class=\"ui_pager_select\"><label class=\"ui_title\">每页显示条数：</label>";
        pageHtml += "<a id='ui_pager_select_a_15' class=\"ui_pager_select_a"+(this.pageSize == 15 ? " cur": "")
        +"\" href=\"javascript:;\">15</a> <a id='ui_pager_select_a_30' class=\"ui_pager_select_a"+(this.pageSize == 30 ? " cur": "")+"\" href=\"javascript:;\">30</a> ";
        pageHtml += "<a id='ui_pager_select_a_50' class=\"ui_pager_select_a"+(this.pageSize == 50 ? " cur": "")+"\" href=\"javascript:;\">50</a></div>";
        pageHtml += "<div class=\"ui_pager_cont\">";
        pageHtml += "<label class=\"ui_title\">共 <span id=\"recordCount\">0</span> 条</label>";
        pageHtml += "<label class=\"ui_title\">当前 <span id=\"curPageRecord\">0-0</span> 条</label>";
        pageHtml += "<label class=\"ui_title\">第 <span  style=\"color:red\" id=\"curPage\">1</span>/<span id=\"totalPage\">1</span> 页</label>";
        pageHtml += "<a class=\"ui_link\" id=\"firstPage\" href=\"javascript:pageList.first();\">首页</a>";
        pageHtml += "<a class=\"ui_link\" id=\"previewPage\" href=\"javascript:pageList.preview();\">上一页</a>";
        pageHtml += "<a class=\"ui_link\" id=\"nextPage\" href=\"javascript:pageList.next();\">下一页</a>";
        pageHtml += "<a class=\"ui_link\" style=\"margin-right:10px;\" id=\"lastPage\" href=\"javascript:pageList.last();\">尾页</a>";
        pageHtml += "<label class=\"ui_title\" style=\"margin-right:5px;\">跳转</label>";
        pageHtml += "<span class=\"ui_text\"><input class=\"inp\" type=\"text\" name=\"jumpPageIndex\" onkeydown='return pageList.numberOnly(event)' maxlength=\"5\" id=\"jumpPageIndex\"/></span>";
        pageHtml += "<a class=\"ui_link pageGO\"  href=\"javascript:pageList.goPage();\">GO</a></div>";

        $("#divPager").html(pageHtml);

        var structureWord = "getStructureList";
        var structureUrl = this.strUrl;
        
        $('.ui_pager_select_a').live('click', function (e) {
            var target = MM.E(e).target;
            $(".ui_pager_select_a").removeClass('cur');
            if (target && target.tagName == 'A') {
                var page = target.innerHTML;
                pageList.pageSize = page;
                MM.addClass(target, 'cur');
                //if (/^[1-9]\d*$/.test(page)) {
                pageList.first();
                //}
            }
            return false;
        });
        //end
        
        if(Config.recoverQuery == true)
        {            
            var oldPageListParams = aPageListParamsRemove(getPageID(pageList.strUrl));        
            if(oldPageListParams != null && oldPageListParams.strUrl != "" && oldPageListParams.strUrl == pageList.strUrl)
            {            
                try
                {
                    /*=========================还原搜索条件=====s==========*/         
                    var QeryPanel = $("#iframeStockData").contents().find("#"+oldPageListParams.pageID).find("#J_table_filter_main");
                    if(QeryPanel != undefined && QeryPanel != null && QeryPanel.html() != null)
                    {                    
                        /*=========================还原分页信息=====s==========*/
                        this.page = oldPageListParams.page;
                        this.totalPage = oldPageListParams.totalPage;
                        this.recordCount = oldPageListParams.recordCount;
                        
                        this.dataId = oldPageListParams.dataId;
                        this.selecter = oldPageListParams.selecter;
                        this.param = oldPageListParams.param;
                        this.sortField = oldPageListParams.sortField;
                        this.pageSize = oldPageListParams.pageSize;
                            
                        /*=========================还原分页信息=====e==========*/
                        $("#J_table_filter_main").remove();
                        try{
                            $("#tableFilterForm").append(QeryPanel);
                            $("#iframeStockData").contents().find("#"+oldPageListParams.pageID).remove();
                        }catch(e){
                        }               
                    }
                    
                    /*=========================还原搜索条件=====e==========*/
                    this.reflash();
                    return ;
                }
                catch(err)
                {}
            }
        }
            this.first();
        
    },
    goPage: function () {
        if($(".pageGO").hasClass('disabled'))return false;
        //判断是否为数字
        var jumpPageIndex = $('#jumpPageIndex').val();
        if (/^[1-9]\d*$/.test(jumpPageIndex)) {
            //判断数字范围
            jumpPageIndex = parseInt(jumpPageIndex);
            if (jumpPageIndex > pageList.totalPage) {
                //$('#jumpPageIndex').blur();
                IM.tip.warn('请输入正确的页号,页号不能大于' + pageList.totalPage + '！');
                $('#jumpPageIndex').focus();
                return;
            }
            pageList.page = jumpPageIndex;
            $("#curPage").html(pageList.page);
            pageList.setState();
            //alert("1");
            pageList.ajaxGetData();
        } else {
            IM.tip.warn('请输入正确的页号！');
            $('#jumpPageIndex').focus();
            return;
        }
    },
    setTotalPage: function () {
        $("#totalPage").html(this.totalPage);
    },
    setRecordCount: function () {
        $("#recordCount").html(this.recordCount);
    },
    setCurrentPage: function () {
        $("#curPage").html(this.page);
    },
    setState: function () {

        if (this.page > this.totalPage) {
            this.page = this.totalPage;
            $("#curPage").html(this.totalPage);
        }

        $("#firstPage").removeClass('disabled');
        $("#firstPage").attr('href', 'javascript:pageList.first();');
        $("#previewPage").removeClass('disabled');
        $("#previewPage").attr('href', 'javascript:pageList.preview();');
        $("#nextPage").removeClass('disabled');
        $("#nextPage").attr('href', 'javascript:pageList.next();');
        $("#lastPage").removeClass('disabled');
        $("#lastPage").attr('href', 'javascript:pageList.last();');
        if (this.page == 1) {
            $("#firstPage").addClass('disabled');
            $("#firstPage").attr('href', 'javascript:void(0);');
            $("#previewPage").addClass('disabled');
            $("#previewPage").attr('href', 'javascript:void(0);');
        }
        if (this.page == this.totalPage) {
            $("#nextPage").addClass('disabled');
            $("#nextPage").attr('href', 'javascript:void(0);');
            $("#lastPage").addClass('disabled');
            $("#lastPage").attr('href', 'javascript:void(0);');
        }
        if(this.totalPage==1) $(".pageGO").addClass('disabled')
        else $(".pageGO").removeClass('disabled')
    },
    //首页
    first: function () {
        this.page = 1;
        $("#curPage").html(this.page);
        
        this.setState();
        this.ajaxGetData();
    },
    //上一页
    preview: function () {
        this.page = this.page - 1;
        if (this.page < 1)
            this.page = 1;
        $("#curPage").html(this.page);
        this.setState();
        this.ajaxGetData();
    },
    //下一页
    next: function () {
        this.page = this.page + 1;
        if (this.page > this.totalPage)
            this.page = this.totalPage;
        $("#curPage").html(this.page);
        this.setState();
        this.ajaxGetData();
    },
    //尾页
    last: function () {
        this.page = this.totalPage;
        $("#curPage").html(this.page);
        this.setState();
        this.ajaxGetData();
    },
    //刷新
    reflash: function () {
        this.ajaxGetData();
    },
    numberOnly: function (event) {
        event = event ? event : (window.event ? window.event : null);
        ///0-9数字键输入
        if ((event.keyCode < 58 && event.keyCode > 0) || (event.keyCode < 106 && event.keyCode > 95) || event.keyCode == 100)
            return true;
        return false;
    },
    setCurPageRecord: function () {

        if (this.pageSize == undefined || this.pageSize == null)
            this.pageSize = 15;

        var curPageRecord = "";
        var perCount = parseInt(parseFloat(this.pageSize) * (parseFloat(this.page) - 1)) + 1;

        if (perCount > parseInt(pageList.recordCount))
            curPageRecord = pageList.recordCount + "-" + pageList.recordCount;
        else {
            curPageRecord = perCount + "-";
            perCount = parseInt(parseFloat(this.pageSize) + parseFloat(perCount)) - 1;
            if (perCount > parseInt(pageList.recordCount))
                perCount = pageList.recordCount;

            curPageRecord += perCount;
        }
        $("#curPageRecord").html(curPageRecord);
    },
    ExportExcel:function() {
        window.open(pageList.strUrl+ "&iExportExcel=1" + pageList.param + "&sortField=" + pageList.sortField);
    },
    //取数据
    ajaxGetData: function () {
        var structureDir = "corp";
        var structureWord = "getStructureList";
        var structureUrl = this.strUrl;
        if(this.strUrl == "")
        {
            IM.tip.warn("数据查询路径为空！");
            return ;
        }            
            
        if (this.pageSize == undefined || this.pageSize == null) {
            this.pageSize = 15;
        }
    
        var openWaitDlg = true;
        var isOpenWaitDlg = false;
        
        if(Config.evnFlag == 2)
        {
            setTimeout(function(){//如果0.5秒，数据没有加载完就显示等待对话框
                if(openWaitDlg)
                {              
                    isOpenWaitDlg = true;
                    IM.dialog.show({
                        width: 250, height: 0, title: '',
                        html: '<div class="loading2">数据加载中..</div>',
                        hasBg: false
                    });
                }  
            },500);
        }
                
        $.ajax({
            
            type: "GET",
            url: this.strUrl,
            data: "page=" + this.page + this.param + "&pageSize=" + this.pageSize + "&sortField=" + this.sortField,
            cache: false,
            success: function (msg) {
                
                $("#" + pageList.dataId).html(msg);
                
                if(Config.evnFlag == 2 && parseInt(pageList.recordCount) <= 0)
                {
                    var tableColCount = 3;
                    try{
                        tableColCount = $(".ui_table_hd:first-child")[0];
                        tableColCount = tableColCount.rows[0].cells.length;
                    }
                    catch(err){
                        tableColCount = 3;  
                    }
                    
                    $("#" + pageList.dataId).html("<tr class=\"\"><td colspan=\""+tableColCount+"\"><div style=\"text-align:center; padding:20px\" class=\"ui_table_tdcntr\">暂无数据</div></td></tr>");
                }
                
                pageList.setTotalPage();
                pageList.setRecordCount();
                pageList.setCurPageRecord();
                pageList.setState();
                pageList.setCurrentPage();
                
                $(".ui_pager_select_a").removeClass('cur');
                var ui_pager_select_a = $("#ui_pager_select_a_"+pageList.pageSize)[0];
                if(ui_pager_select_a) ui_pager_select_a.className += " cur";
                
                IM.table.init();
                //加权限验证
                $.setPurview();
                
                openWaitDlg = false;    
                if(isOpenWaitDlg)
                    IM.dialog.hide();
                    
            },
            complete: function () {
                
                openWaitDlg = false;    
                if(isOpenWaitDlg)
                    IM.dialog.hide();
            }
        });
        
    }
};