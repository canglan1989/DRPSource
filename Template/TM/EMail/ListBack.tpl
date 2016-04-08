<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>邮箱任务查询</div>
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
                    产品：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="pro_type1" id="pro_type1" style="display:none">
                    </select>
                    <select name="pro_type2" id="pro_type2">
                    </select>
                </div>
                <div class="ui_title">
                    客户名称：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="cus_name" style="vertical-align: top;" id="cus_name"
                           type="text"></div>
                <div class="ui_title">
                    所属代理商：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="agent_name" style="vertical-align: top;" id="agent_name"
                           type="text"></div>
                <div class="ui_title">
                    域名：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="web_site" style="vertical-align: top;" id="web_site"
                           type="text"></div>
            </div>
            <div class="table_filter_main_row">
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
                    信息状态：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="mail_info_state">
                        <option value="-1">全部</option>
                        <option value="1">已确认</option>
                        <option value="0">未确认</option>
                    </select>
                </div>
                <div class="ui_title">
                    解析状态：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="mail_analy_state">
                        <option value="-1">全部</option>
                        <option value="1">已解析</option>
                        <option value="0">未解析</option>
                    </select>
                </div>
                <div class="ui_title">
                    邮箱状态：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="mail_state">
                        <option value="-1">全部</option>
                        <option value="1">已开通</option>
                        <option value="0">未开通</option>
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
                <span class="ui_icon list_table_title_icon"></span>邮箱任务列表</h4>
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
            <th title="客户名称/ID" >
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    客户名称/ID</div>
            </div>
            </th>
            <th title="所属代理商/代码">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    所属代理商/代码</div>
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
            <th title="产品" width="80">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    产品</div>
            </div>
            </th>
            <th title="域名">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    域名</div>
            </div>
            </th>
            <th title="用户数" style="width: 50px;">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">
                        用户数</div>
                </div>
            </th>
            <th title="信息状态" width="80">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    信息状态</div>
            </div>
            </th>
            <th title="解析状态" width="80">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    解析状态</div>
            </div>
            </th>
            <th title="邮箱状态" width="80">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    邮箱状态</div>
            </div>
            </th>
            <th title="订单时间" sort="sort_order_date">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    订单时间</div>
                <div class="ui_table_thsort" >
                </div>
            </div>
            </th>
            <th title="订单有效期" sort="sort_effect_date">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    订单有效期</div>
                <div class="ui_table_thsort" >
                </div>
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
    $GetProduct.Select("pro_type1", "pro_type2",true,1,-1);
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
        
    pageList.sortField = "order_state asc";
    {/literal}
    pageList.strUrl="{$strUrl}";
    {literal}
    pageList.init();
    {/literal}
</script>
