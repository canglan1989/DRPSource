<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：<a href="javascript:;">任务管理</a><span>&gt;</span>网营帐号管理</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
            <div class="ui_title">
                网营帐号：</div>
            <div class="ui_text">
                <input class="inpCommon" name="net_u_name" style="vertical-align: top;" id="agent_name"
                    type="text"></div>
            <div class="ui_title">
                所属代理商：</div>
            <div class="ui_text">
                <input class="inpCommon" name="agent_name" style="vertical-align: top;" id="agent_name"
                    type="text"></div>
            <div class="ui_title">
                所属代理商编号：</div>
            <div class="ui_text">
                <input class="inpCommon" name="agent_id" style="vertical-align: top;" id="agent_name"
                    type="text"></div>
            <div class="ui_title">
                帐号状态：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select name="net_user_state">
                    <option value="-1">全部</option>
                    <option value="0">正常</option>
                    <option value="1">关闭</option>
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
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button" href="/?d=Agent&c=Agent&a=AddShow&isCheck=1" onclick="">
        <div class="ui_button_left">
        </div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_add">
            </div>
            <div class="ui_text">
                添加帐号</div>
        </div>
    </a><a class="ui_button ui_button_dis" href="javascript:;" onclick="IM.account.delOper('../chunk/delRoles.php',{literal}{}{/literal},'批量删除资料')"
        style="margin: 0;">
        <div class="ui_button_left">
        </div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_del">
            </div>
            <div class="ui_text">
                删除</div>
        </div>
    </a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title">
                <span class="ui_icon list_table_title_icon"></span>网营帐号列表</h4>
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
                    <th style="width: 30px" title="全选/反选">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                <input type="checkbox" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');"
                                    class="checkInp">
                            </div>
                        </div>
                    </th>
                    <th title="网营帐号名" width="120">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                网营帐号名</div>
                        </div>
                    </th>
                    <th title="代理商名称">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                代理商名称</div>
                        </div>
                    </th>
                    <th title="代理商编号" width="120">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                代理商编号</div>
                        </div>
                    </th>
                    <th title="帐号状态" style="width: 80px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                帐号状态</div>
                        </div>
                    </th>
                    <th title="审核时间" style="width: 130px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                绑定时间</div>
                        </div>
                    </th>
                    <th title="绑定操作人" style="width: 120px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                绑定操作人</div>
                        </div>
                    </th>
                    <th style="width:250px;" title="操作">
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
function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
{/literal}
pageList.strUrl="{$strUrl}";
{literal}
pageList.init();
{/literal}
</script>