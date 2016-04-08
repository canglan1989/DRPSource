<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">原订单号：</div>
                <div class="ui_text"><input class="" type="text" name="order_no" /></div>
                <div class="ui_title">新订单号：</div>
                <div class="ui_text"><input class="" type="text" name="new_order_no" /></div>
                
                <div class="ui_title">原代理商：</div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <input name="from_agent"  />   
                </div>
                <div class="ui_title">转入代理商：</div>
                <div class="ui_text"  id = "createTime">
                    <input name="to_agent"  />
                </div>
                
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">操作时间：</div>
                <div class="ui_comboBox" >
                    <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="create_time_begin" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/> 至
                    <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="create_time_end" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>
                </div>
                <div class="ui_title">网盟账号：</div>
                <div class="ui_comboBox" >
                     <input name="adhaiaccount" class="inpCommon" />
                </div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
            </div>
        </div>
    </form>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>                    
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
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th  title="原订单号">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">原订单号</div>
            </div>
            </th>
            <th  title="新订单号">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">新订单号</div>
            </div>
            </th>
            <th  title="客户名称">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户名称</div>
            </div>
            </th>
            <th  title="网盟账号">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">网盟账号</div>
            </div>
            </th>
            <!--客户来源来另外的一张表cm_customer_agent里面 -->
            <th title="原代理商">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">原代理商</div>
            </div>
            </th>

            <th  title="转入代理商">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">转入代理商</div>
            </div>
            </th>
             <th  title="操作人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">操作人</div>
            </div>
            </th>   
            <th  title="操作时间">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">操作时间</div>
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
<div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
<script type="text/javascript">
    {literal}
$(function(){
    {/literal}
	pageList.strUrl="{$BodyUrl}"; 
    {literal}
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
});

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
    
{/literal}
</script>