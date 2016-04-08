<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">
            <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">    		
                <div class="table_filter_main_row">
                <div class="ui_title">
                    订单号：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="order_no" style="vertical-align: top;" id="order_no"
                           type="text"></div>
                <div class="ui_title">
                    所属代理商：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="agent_name" style="vertical-align: top;" id="agent_name"
                           type="text"></div>
                <div class="ui_title">
                    客户名称：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="cus_name" style="vertical-align: top;" id="cus_name"
                           type="text"></div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">
                    产品：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="pro_type1" id="pro_type1">
                    </select>
                    <select name="pro_type2" id="pro_type2">
                    </select>
                </div>
                <div class="ui_title">
                    订单类型：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="ord_type">
                        <option value="-100">全部</option>
                        <option value="1">新签</option>
                        <option value="2">续签</option>
                    </select>
                </div>
                <div class="ui_button ui_button_search">
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
                <span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
            <th title="客户名称">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    客户名称</div>
            </div>
            </th>
            <th title="产品" width="120">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    产品</div>
            </div>
            </th>
            <th title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    代理商名称</div>
            </div>
            </th>
            <th title="订单类型" width="80">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单类型</div>
            </div>
            </th>
            <th title="订单状态" width="80">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单状态</div>
            </div>
            </th>
            <th title="提交时间" width="100" sort="sort_ord_create_time">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    提交时间</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="下单时间" width="100" sort="sort_last_check_time">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    下单时间</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="操作" width="100">
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
<div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal}
    <script type="text/javascript">
    $GetProduct.Select("pro_type1", "pro_type2",true);
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
    {/literal}
    pageList.sortField = "last_check_time desc";
    pageList.strUrl="{$strUrl}";
    {literal}
        pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.init();
    {/literal}
</script>