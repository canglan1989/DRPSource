<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>ICP备案管理</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title">
                    订单号：</div>
                <div class="ui_text">
                    <input class="inpCommon" type="text" name="order_no" style="vertical-align: top;" /></div>
                <div class="ui_title">
                    客户名称：</div>
                <div class="ui_text">
                    <input class="inpCommon" type="text" name="cus_name" style="vertical-align: top;" /></div>
                <div class="ui_title">
                    产品：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="pro_type1" id="pro_type1" style="display:none">
                    </select>
                    <select name="pro_type2" id="pro_type2">
                    </select>
                </div>
                <div class="ui_title">
                    域名：</div>
                <div class="ui_text">
                    <input class="inpCommon" type="text" name="web_site" style="vertical-align: top;" /></div>
                <div class="ui_title">
                    备案号：</div>
                <div class="ui_text">
                    <input class="inpCommon" type="text" name="icp_no" style="vertical-align: top;" /></div>
                <div class="ui_title">
                    备案状态：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select class="pri" name="backUp_state">
                        <option value="-1">全部</option>
                        <option value="0">未备案</option>
                        <!--                        <option value="1">备案中</option>-->
                        <option value="2">备案完成</option>
                        <!--                        <option value="3">备案失败</option>-->
                    </select>
                </div>
            </div>
            <div class="table_filter_main_row">
                <!--                <div class="ui_title">
                                    所属代理商/代码：</div>
                                <div class="ui_text">
                                    <input class="inpCommon" type="text" name="agent_name" style="vertical-align: top;" /></div>
                                <div class="ui_title">
                                    备案开始时间：</div>
                                <div class="ui_text">
                                    <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE3\')}'}{/literal})"
                                           name="begin_backUp_time_begin" class="inpCommon inpDate" id="J_editTimeS3">
                                    至
                                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS3\')}'}{/literal})"
                                           name="begin_backUp_time_end" class="inpCommon inpDate" id="J_editTimeE3">
                                </div>-->
                <div class="ui_title">
                    备案完成时间：</div>
                <div class="ui_text">
                    <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE3\')}'}{/literal})"
                           name="end_backUp_time_begin" class="inpCommon inpDate" id="J_editTimeS3">
                    至
                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS3\')}'}{/literal})"
                           name="end_backUp_time_end" class="inpCommon inpDate" id="J_editTimeE3">
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
<!--S list_link-->
<!--  
<div class="list_link marginBottom10">
    <a class="ui_button " href="javascript:;">
        <div class="ui_button_left">
        </div>
        <div class="ui_button_inner">
            <div class="ui_text">
                开始备案</div>
        </div>
    </a><a class="ui_button " href="javascript:;">
        <div class="ui_button_left">
        </div>
        <div class="ui_button_inner">
            <div class="ui_text">
                取消备案</div>
        </div>
    </a><a class="ui_button " href="javascript:;" onclick="IM.task.BAFinish()" style="margin:0;">
        <div class="ui_button_left">
        </div>
        <div class="ui_button_inner">
            <div class="ui_text">
                备案完成</div>
        </div>
    </a>
</div>
-->
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title">
                <span class="ui_icon list_table_title_icon"></span>ICP备案列表</h4>
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
<!--            <th title="所属代理商" sort="sort_agent_name_id">
        <div class="ui_table_thcntr ">
            <div class="ui_table_thtext">
                所属代理商</div>
            <div class="ui_table_thsort">
            </div>
        </div>
        </th>-->
            <th title="产品" sort="sort_product_name">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    产品</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="订单状态" style="width: 100px;" sort="sort_order_state">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单状态</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="客户名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    客户名称</div>
            </div>
            </th>
            <th title="备案联系人姓名/联系方式">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    备案联系人姓名/联系方式</div>
            </div>
            </th>
            <th title="域名" style="width: 80px;" sort="sort_web_site">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    域名</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="备案状态" width="80" sort="sort_backUp_state">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    备案状态</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="备案号" style="width: 70px" sort="sort_bakcUp_code">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    备案号</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
<!--                    <th title="备案开始时间/操作人" style="width: 130px">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">
                        备案开始时间/操作人</div>
                </div>
            </th>-->
            <th title="备案完成时间/操作人" style="width: 130px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    备案完成时间/操作人</div>
            </div>
            </th>
            <th title="操作" width="80">
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
        
    $GetProduct.Select("pro_type1", "pro_type2",true,2,-1);
        
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
    {/literal}
    pageList.sortField = "backUp_state desc";
    pageList.strUrl="{$strUrl}";
    {literal}
    pageList.init();
    /**
     * 备案完成 操作
     */
    IM.task.BAFinish=function(order_id){
            var tplMain='<div class="DContInner setPWDComfireCont">\
                                            <form id="J_BAFForm" class="setPWDComfireForm">\
                        <div class="bd">\
                                    <div class="tf">\
                            <label><em class="require">*</em>备案号：</label>\
                            <div class="inp"><input type="text" name="BA_num" valid="required" maxlength="64"></div>\
                            <span class="info">请输入备案号</span><span class="ok">&nbsp;</span><span class="err">请输入备案号</span>\
                                            </div></div>\
                                            <div class="ft">\
                                                    <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>\
                                                    <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确 定</button></div>\
                       </div>\
                                       </form>\
                                     </div>';	
            IM.dialog.show({
                    width: 450,
                    title:'完成',
                    html:tplMain,
                    start:function(){
                            var J_BAFForm=$('#J_BAFForm');
                            function cb(formData){
                                    MM.ajax({
                                            url:'/?d=TM&c=NetOpe&a=FinishBackUp',
                                            data:J_BAFForm.serialize()+"&order_id="+order_id,
                                            success:function(q){
                                                    q=MM.json(q);
                                                    if(q.success){
                                                            IM.dialog.hide();
                                                            IM.tip.show(q.msg);
                                QueryData();
                                                    }else{
                                                            IM.tip.warn(q.msg);
                                                    }
                                            }
                                    });
                             };
                            function regForm(){
                                    new Reg.vf(J_BAFForm,{callback:cb});
                            };
                            regForm();
                    }
            });
    }
    /**
     * 修改联系人
     * @param data
     */
    function contact_modify(){
        var order_id = document.getElementById("order_id").value;
        MM.ajax({
                    url:'/?d=TM&c=NetOpe&a=ModifyContact',
                    data:$('#J_taskDistForm').serialize()+"&order_id="+order_id,
                    success:function(q){
                            q=MM.json(q);
                            if(q.success){
                                    IM.dialog.hide();
                                    IM.tip.show(q.msg);
                    QueryData();
                            }else{
                                    IM.tip.warn(q.msg);
                            }
                    }
        });
    }
    {/literal}
</script>
