<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>认证任务管理</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title">
                    订单号：</div>
                <div class="ui_text">
                    <input type="text" name="order_no" class="inpCommon inputer"></div>
                <div class="ui_title">
                    产品：</div>
                <div class="ui_comboBox">
                    <select name="pro_type1" id="pro_type1">
                    </select>
                    <select name="pro_type2" id="pro_type2">
                    </select>
                </div>
                <div class="ui_title">
                    客户名称：</div>
                <div class="ui_text">
                    <input type="text" name="cus_name" class="inpCommon inputer"></div>
                <div class="ui_title">
                    任务状态：</div>
                <div class="ui_comboBox">
                    <select name="trust_task_state">
                        <option value="-1">全部</option>
                        <option value="1">已添加</option>
                        <option value="0">未添加</option>
                    </select>
                </div>
                <div class="ui_title">
                    提交人：</div>
                <div class="ui_text">
                    <input type="text" name="post_name" class="inpCommon inputer"></div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">
                    提交时间：</div>
                <div id="createTime" class="ui_text">
                    <input type="text" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}{/literal})"
                           name="post_time_begin" class="inpCommon inpDate" id="J_editTimeS">
                    至
                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}{/literal})"
                           name="post_time_end" class="inpCommon inpDate" id="J_editTimeE">
                </div>
                <div class="ui_title">
                    操作人：</div>
                <div class="ui_text">
                    <input type="text" name="trust_install_name" class="inpCommon inputer"></div>
                <div class="ui_title">
                    校验：</div>
                <div class="ui_comboBox">
                    <select name="trust_verify">
                        <option value="-1">全部</option>
                        <option value="1">已校验</option>
                        <option value="0">未校验</option>
                    </select>
                </div>
                <div class="ui_title">
                    下单时间：</div>
                <div id="createTime" class="ui_text">
                    <input type="text" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE0')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE0\')}'}{/literal})"
                           name="order_time_begin" class="inpCommon inpDate" id="J_editTimeS0">
                    至
                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS0\')}'}{/literal})"
                           name="order_time_end" class="inpCommon inpDate" id="J_editTimeE0">
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">
                    订单时间：</div>
                <div id="createTime" class="ui_text">
                    <input type="text" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE2')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE2\')}'}{/literal})"
                           name="order_sdate_begin" class="inpCommon inpDate" id="J_editTimeS2">
                    至
                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS2\')}'}{/literal})"
                           name="order_sdate_end" class="inpCommon inpDate" id="J_editTimeE2">
                </div>
                <div class="ui_title">
                    有效期：</div>
                <div id="createTime" class="ui_text">
                    <input type="text" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE3')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE3\')}'}{/literal})"
                           name="order_edate_begin" class="inpCommon inpDate" id="J_editTimeS3">
                    至
                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS3\')}'}{/literal})"
                           name="order_edate_end" class="inpCommon inpDate" id="J_editTimeE3">
                </div>
                <div class="ui_button ui_button_search">
                    </span>
                    <button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch"
                            onclick="QueryData()">
                        搜 索</button></div>
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title">
                <span class="ui_icon list_table_title_icon"></span>认证任务管理</h4>
        </div>
    </div>
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr class="">
                    <th title="订单号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单号</div>
            </div>
            </th>
            <th title="客户名称" style="width: 80px;" sort="sort_cus_name_id" >
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    客户名称</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="产品" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    产品</div>
            </div>
            </th>
            <th title="订单类型" style="width: 80px;" sort="sort_order_type">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单类型</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="订单状态">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单状态</div>
            </div>
            </th>
            <th title="提交人" style="width: 80px" sort="sort_user_name_id">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    提交人</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="提交时间" style="width: 80px;" sort="sort_create_time">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    提交时间</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="下单时间" style="width: 80px;" sort="sort_last_check_time">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    下单时间</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="任务状态" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    任务状态</div>
            </div>
            </th>
            <th title="网址" style="">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    网址</div>
            </div>
            </th>
            <th title="联系人/联系电话">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    联系人/联系电话</div>
            </div>
            </th>
            <th title="订单时间" >
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    订单时间</div>
            </div>
            </th>
            <th title="有效期" >
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    有效期</div>
            </div>
            </th>
            <th title="校验" style="width: 50px">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    校验</div>
            </div>
            </th>
            <th title="操作" style="width: 90px">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    操作</div>
            </div>
            </th>
            </tr>
            </thead>
            <tbody class="ui_table_bd" id="pageListContent">
            </tbody>
        </table>
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main-->
<!--S list_table_foot-->
<div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal}
    <script type="text/javascript">
    $GetProduct.Select("pro_type1", "pro_type2",true);
    $("select[name=pro_type1] option").each(function(){
            var v = $(this).val();
        if(v>0&&v!=3&&v!=7){
            $(this).remove();
        }
    });

    pageList.sortField = "last_check_time desc";
    {/literal}
    pageList.strUrl="{$strUrl}";
    {literal}
    pageList.init();
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
        
    IM.task.addTaskTag=function(data){
            var tplMain='<div class="DContInner tableFormCont">\
                                            <form id="J_addTaskTagForm">\
                                                <div class="bd">\
                                                            <div class="tfToggle">\
                                                                   是否校验通过？\
                                                            </div>\
                                                    </div>\
                                                    <div class="ft">\
                                                            <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">取消</a></div>\
                                                            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确定</button></div>\
                                                    </div>\
                                            </form></div>';
            data=data||{};
            IM.dialog.show({
                    width: 250,
                    title:'任务标记',
                    html:IM.STATIC.LOADING,
                    start:function(){
                            $('.DCont')[0].innerHTML=tplMain;
                            new Reg.vf($('#J_addTaskTagForm'),{callback:function(formData){
                                    MM.Extend(formData,data);
                                    MM.ajax({
                                            url:'/?d=TM&c=Trustworthy&a=setTaskFlag',
                                            data:formData,
                                            success:function(q){
                                                    //{"success":true,"msg":"\u6dfb\u52a0\u6210\u529f"}
                                                    q=MM.json(q);
                                                    IM.dialog.hide();
                                                    if(q.success){
                                                        QueryData();
                                                            IM.tip.show(q.msg);
                                                    }else{
                                                            IM.tip.warn(q.msg);
                                                    }
                                            }
                                    });
                            }});
                    }
        });
    };
    /**
     *任务管理 > 诚信认证任务管理  查看认证代码
     *param data
     */
    IM.task.checkRegCode=function(data){
            var tplMain='<div class="DContInner tableFormCont">\
                                    <div class="bd">\
                                        <h4>{0}</h4>\
                                                                            <div id="J_copyCode" class="commonTips" style="display:none"></div>\
                                    </div>\
                                    <div class="ft">\
                                        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>\
                                        {1}\
                                    </div>\                                                                                                                              \
                            </div>',
            tplCopy='<div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="button" onclick="IM.dialog.ok()">复制</button></div>';
            var tmpCode='';
            IM.dialog.show({
                    width: 400,
                    title:'查看认证代码',
                    html:IM.STATIC.LOADING,
                    start:function(){
                            MM.get('/?d=TM&c=Trustworthy&a=getComfirmCode',data,function(q){
                                    q=MM.json(q);
                                    if(q.success){
                                        var contentCode = '<textarea cols="40" rows="10" id="tComfirmCode" style="width:320px;height:200px;">'+q.msg+'</textarea>';
                                            $('.DCont')[0].innerHTML=_(tplMain,contentCode,tplCopy);
                                            tmpCode=$("#tComfirmCode").val();//q.msg;
                                    }	
                                    else{
                                        $('.DCont')[0].innerHTML=_(tplMain,'','');
                                        var a=MM.G('J_copyCode');				    
                                        a.innerHTML=q.msg;
                                        MM.show(a);
                                    }                                        
                            });			
                    },
                    ok:function(){
                            var a=MM.G('J_copyCode');
                            if (window.clipboardData) {
                                    window.clipboardData.setData("Text",tmpCode);
                                    a.innerHTML='复制成功！';
                            }else{
                                    a.innerHTML='由于您的浏览器安全限制，请手动复制代码！';
                            } 
                            MM.show(a);
                    }
        });	
    }
    {/literal}
</script>

