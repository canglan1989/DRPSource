<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title">
                    客户名称/ID：</div>
                <div class="ui_text">
                    <input class="inpCommon" name="custimer_info" style="vertical-align: top;" id="custimer_info"
                           type="text" /></div>
                <div class="ui_button ui_button_search">
                    <button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch"
                            onclick="QueryData()">
                        搜 索</button></div>
            </div>
        </div>
    </form>
</div>
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
            <th title="客户名称/ID" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    客户名称/ID</div>
            </div>
            </th>
                    <th title="产品名称" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    产品名称</div>
            </div>
            </th>
            <th title="账号名称">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    账号名称</div>
            </div>
            </th>
            <th title="账号有效期">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    账号有效期</div>
            </div>
            </th>
            <th title="账号关闭日期">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    账号关闭日期</div>
            </div>
            </th>
            <th title="账号关闭设置人">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    账号关闭设置人</div>
            </div>
            </th>
            <th title="账号状态">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    账号状态</div>
            </div>
            </th>
<!--            <th title="操作" width="70">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    操作</div>
            </div>
            </th>-->
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
    pageList.strUrl="{$BodyUrl}";
    {literal}
    pageList.init();
        
function CloseAccount(aid){
    IM.dialog.show({
			width: 300,
			title: "关闭账号",
			html: '<div class="loading">数据加载中...</div>',
                start: function(){
                    MM.get("/?d=TM&c=SingleLogin&a=showCloseAccount&accountid="+aid,{},
                    function(backHTML){
                     $('.DCont').html(backHTML);    
                    new Reg.vf($('#J_handleAudit'),{callback:function(formData){
                            MM.ajax({
                                url:"/?d=TM&c=SingleLogin&a=CloseAccount",
                                data:$('#J_handleAudit').serialize(),//POST提交
                                success:function(q){
                                    q=MM.json(q);
                                    if(q.success){                             
                                        IM.tip.show(q.msg);
                                        IM.dialog.hide();
                                        pageList.reflash();
                                    }else{
                                        IM.tip.warn(q.msg);
                                    }
                                }
                            })
                    }});
                });
            }
    });
}
        
    {/literal}
</script>
