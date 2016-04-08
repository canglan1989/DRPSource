<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>域名解析</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>
        提示信息：请在网营门户建站系统：“网站设置”-->“域名绑定”中绑定域名，否则将影响网站发布。</label>
    <span class="ui_link"><a href="javascript:;">未解析：</a>(<em>{$headData.un_analy}</em>)</span>
    <span class="ui_link"><a href="javascript:;">已解析：</a>(<em>{$headData.analy}</em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title">
                    订单号：</div>
                <div class="ui_text">
                    <input type="text" name="order_no" class="inputer"></div>
                <div class="ui_title">
                    域名：</div>
                <div class="ui_text">
                    <input type="text" name="web_site" class="inputer"></div>
                <div class="ui_title">
                    客户名称：</div>
                <div class="ui_text">
                    <input type="text" name="cus_name" class="inputer"></div>
                <div class="ui_title">
                    解析状态：</div>
                <div class="ui_comboBox">
                    <select name="net_analy_state">
                        <option selected="selected" value="-1">全部</option>
                        <option value="1">已解析</option>
                        <option value="0">未解析</option>
                    </select>
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">
                    操作时间：</div>
                <div id="createTime" class="ui_text">
                    <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}{/literal})"
                           name="net_analy_time_begin" class="inpCommon inpDate" id="J_editTimeS">
                    至
                    <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}{/literal})"
                           name="net_analy_time_end" class="inpCommon inpDate" id="J_editTimeE">
                </div>
                <div class="ui_title">
                    产品：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="pro_type1" id="pro_type1">
                    </select>
                    <select name="pro_type2" id="pro_type2">
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
                <span class="ui_icon list_table_title_icon"></span>网站域名列表</h4>
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
                    <th title="订单号" >
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
            <th title="域名" style="width: 100px;" sort="sort_web_site">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    域名</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="解析状态" style="width: 80px;" sort="sort_is_analy">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    解析状态</div>
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
            <th title="操作时间" style="width: 130px;" sort="sort_analy_time">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    操作时间</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="操作人" style="width: 120px" sort="sort_analy_name">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    操作人</div>
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
    $GetProduct.Init("pro_type1", "pro_type2", true, "",ProductGroups.ValueIncrease);
        
    $("select[name=pro_type1] option").each(function(){
            var v = $(this).val();
        if(v>0&&v!=1&&v!=2){
            $(this).remove();
        }
    });
        
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
    
    pageList.sortField = "is_analy desc,last_check_time asc";
    {/literal}
    pageList.strUrl="{$strUrl}";
    {literal}
    pageList.init();
    {/literal}
</script>