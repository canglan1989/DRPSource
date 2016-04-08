<!--E crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>回访列表</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">  
</div>
<!--E table_filter-->
<!--S list_link-->
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>回访列表</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>     
        </div>
    </div>
</div>
<!--E list_table_head-->        
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th width="50" title="编号">
            <div class="ui_table_thcntr" sort="sort_visitnoteid">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th width="70" title="添加人">
            <div class="ui_table_thcntr" sort="sort_e_name">
                <div class="ui_table_thtext">添加人</div>
            </div>
            </th>
            <th width="" title="添加时间">
            <div class="ui_table_thcntr" sort="sort_create_time">
                <div class="ui_table_thtext">添加时间</div>
            </div>
            </th>
            <th title="回访内容">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">回访内容</div>
            </div>
            </th>
            <th title="回访时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">回访时间</div>
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
<div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
</div>         
<!--S list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
    <script language="javascript" type="text/javascript">
    $(document).ready(function () {
    {/literal}
        pageList.strUrl="{$strUrl}";
        pageList.param="&id="+{$visitnoteid};
    {literal}
        pageList.init();
    });

    </script>
{/literal}