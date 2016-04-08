<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>网站评审</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>
        提醒信息：</label>
    <span class="ui_link">新建未评审：(<em>{$headData.add_un_verify}</em>)</span>
    <span class="ui_link">修改未评审：(<em>{$headData.edit_un_verify}</em>)</span>
    <span class="ui_link">审核通过：(<em>{$headData.verify_pass}</em>)</span>
    <span class="ui_link">审核未通过：(<em>{$headData.verify_un_pass}</em>)</span>
</div>
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
                产品：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select name="pro_type1" id="pro_type1" style="display:none">
                </select>
                <select name="pro_type2" id="pro_type2">
                </select>
            </div>
            <div class="ui_title">
                制作类型：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select name="net_make_state">
                    <option selected="selected" value="-1">全部</option>
                    <option value="1">新建</option>
                    <option value="2">修改</option>
                </select>
            </div>
            <div class="ui_title">
                评审状态：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select name="net_verify_state">
                    <option selected="selected" value="-1">全部</option>
                    <option value="1">审核通过</option>
                    <option value="2">审核不通过</option>
                    <option value="0">未审核</option>
                </select>
            </div>
        </div>
        <div class="table_filter_main_row">
            <div class="ui_title">
                客户名称：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="cus_name" style="vertical-align: top;" /></div>
            <div class="ui_title">
                所属代理商/代码：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="agent_name" style="vertical-align: top;" /></div>
            <div class="ui_title">
                订单类型：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select name="ord_type">
                    <option value="-100">全部</option>
                    <option value="1">新签</option>
                    <option value="2">续签</option>
                </select>
            </div>
            <div class="ui_title">
                备案状态：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select class="pri" name="i_backUp">
                    <option value="-100">全部</option>
                    <option value="-2">未备案</option>
                    <option value="2">备案完成</option>
                </select>
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
                <span class="ui_icon list_table_title_icon"></span>网站评审表</h4>
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
                    <th title="所属代理商" sort=sort_agent_name_id>
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                所属代理商</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="订单类型" width="80">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单类型</div>
                        </div>
                    </th>
                    <th title="客户名称">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                客户名称</div>
                        </div>
                    </th>
                    <th title="产品" style="width: 80px;" sort=sort_product_name>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                产品</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="制作类型" width="80px" sort=sort_make_type>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                制作类型</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="订单状态" style="width: 80px" sort=sort_verify_state>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单状态</div>
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
                    <th title="备案状态" style="width: 70px" sort="sort_i_backUp">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">
                            备案状态</div>
                        <div class="ui_table_thsort">
                        </div>
                    </div>
                    </th>
                    <th title="评审备注" sort=sort_verify_remark>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                评审备注</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="操作人/操作时间" style="width: 130px" sort=sort_verify_time>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                操作人/操作时间</div>
                            <div class="ui_table_thsort">
                            </div>
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
function verify(){
    var state = $("#d_i_pass input:checked").val();
    var un_pass_reason = $("#d_un_pass_reason input:checked").map(function () {
                return this.value;
            }).get();
    if(state=="2"&&un_pass_reason=="")
    {
        IM.tip.warn("请选择不通过原因");
        return false;
    }
    var remark = $("#verify_remark").val();
    if(remark.length>128){
    	IM.tip.warn("评审备注最长128个字符！");
        return false;
    }
    var order_id = document.getElementById("order_id").value;
    var _data = "verify_remark="+remark+"&order_id="+order_id+"&verify_state="+state+"&un_pass_reason="+un_pass_reason;
    MM.ajax({
        url:'/?d=TM&c=NetOpe&a=SaveSiteVerify',
        data:_data,
        success:function(q){
            //alert(q);return false;
            q=MM.json(q);
            if(q.success){
                IM.tip.show(q.msg);
                QueryData();
            }else{
                IM.tip.warn(q.msg);
            }
            IM.dialog.hide();
        }
    });
}
//选择通过/不通过切换
function change_pass(a)
{
    if(a.value=="2")
    {
        document.getElementById("d_un_pass_reason").style.display="";
    }
    else
    {
        document.getElementById("d_un_pass_reason").style.display="none";
    }
}
{/literal}
pageList.strUrl="{$strUrl}";
{literal}
pageList.init();
{/literal}
</script>