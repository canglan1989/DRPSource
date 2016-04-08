<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>上线网站查询</div>
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
                客户名称：</div>
            <div class="ui_text">
                <input type="text" name="cus_name" class="inpCommon inputer"></div>
            <div class="ui_title">
                产品：</div>
            <div class="ui_comboBox">
                <select name="pro_type1" id="pro_type1" style="display:none">
                </select>
                <select name="pro_type2" id="pro_type2">
                </select>
            </div>
            <div class="ui_title">
                订单类型：</div>
            <div class="ui_comboBox">
                <select name="ord_type">
                    <option value="-100">全部</option>
                    <option value="1">新签</option>
                    <option value="2">续签</option>
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
                <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}{/literal})"
                    name="post_time_begin" class="inpCommon inpDate" id="J_editTimeS">
                至
                <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}{/literal})"
                    name="post_time_end" class="inpCommon inpDate" id="J_editTimeE">
            </div>
            <div class="ui_title">
                下单时间：</div>
            <div id="createTime" class="ui_text">
                <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE1\')}'}{/literal})"
                    name="order_time_begin" class="inpCommon inpDate" id="J_editTimeS1">
                至
                <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS1\')}'}{/literal})"
                    name="order_time_end" class="inpCommon inpDate" id="J_editTimeE1">
            </div>
            <div class="ui_title">
                上线时间：</div>
            <div id="createTime" class="ui_text">
                <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE2\')}'}{/literal})"
                    name="net_online_time_begin" class="inpCommon inpDate" id="J_editTimeS2">
                至
                <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS2\')}'}{/literal})"
                    name="net_online_time_end" class="inpCommon inpDate" id="J_editTimeE2">
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
                <span class="ui_icon list_table_title_icon"></span>上线网站列表</h4>
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
                    <th title="客户名称" style="" sort="sort_cus_name_id">
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
                    <th title="订单类型" style="width: 100px;" sort="sort_order_type">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单类型</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="订单状态" style="width: 80px;" sort="sort_order_state">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单状态</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="提交人/公司" style="width: 120px" sort="sort_post_user_name_id">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                提交人/公司</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="提交时间" style="width: 80px;" sort="sort_post_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                提交时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="下单时间" style="width: 130px;" sort="sort_last_check_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                下单时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="上线时间" style="width: 130px;" sort="sort_onLine_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                上线时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="操作" style="width: 50px">
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
pageList.sortField = "onLine_time desc";
pageList.strUrl="{$strUrl}";
{literal}
pageList.init();
{/literal}
</script>