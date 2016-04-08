<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>联系小记记录</div>
<!--E crumbs-->   
<!--S form_bd-->
<div class="form_bd">
    <div class="form_block_bd">
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">   		
                    <div class="table_filter_main_row">
                        <div class="ui_title">客户名称：</div>
                        <div class="ui_text"><input class="inpCommon" type="text" name="customerName" style="vertical-align:top;"/></div>
                        <div class="ui_title">意向评级：</div>
                        <div class="ui_comboBox">
                            <select id="intentRating" name="intentRating">
                                <option value="-1" selected="">全部</option>
                                <option value="0">A</option>
                                <option value="1">B</option>
                                <option value="2">C</option>
                                <option value="3">D</option>
                                <option value="4">E</option>
                            </select>
                        </div> 
                        <div class="ui_title">联系时间：</div>
                        <div class="ui_text">
                            {literal}
                            <input class="inpCommon inpDate" type="text" name="contactTimeS" id="J_editTimeS" onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})"> 至
                            <input class="inpCommon inpDate" type="text" name="contactTimeE" id="J_editTimeE" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})">       
                            {/literal}                       
                        </div>
                        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="search();">搜索</button></div>	                                                                
                    </div>
                </div>
            </form>
        </div>
        <!--E table_filter-->
        <!--S list_table_head-->
        <div class="list_table_head">
            <div class="list_table_head_right">
                <div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 联系小记记录列表</h4>
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
                            <th title="编号" style="width:80px;">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">编号</div>
                    </div>
                    </th>
                    <th title="客户名称">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">客户名称</div>
                    </div>
                    </th>
                    <th title="操作人">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">操作人</div>
                    </div>
                    </th>
                    <th style="" title="联系人">
                    <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系人</div>
                    </div>
                    </th>             					
                    <th title="联系电话">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">联系电话</div>
                    </div>
                    </th>
                    </th>             					
                    <th title="联系时间">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">联系时间</div>
                    </div>
                    </th>
                    <th title="小记内容">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">小记内容</div>
                    </div>
                    </th>
                    <th title="意向评级" style="width:80px;">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">意向评级</div>
                    </div>
                    </th>   
                    </tr>
                    </thead>
                    <tbody class="ui_table_bd" id='pageListContent'>

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
    </div>
    <!--E form_bd-->  
</div>
<script>
    {literal}
$(document).ready(function(){
    pageList.strUrl={/literal}"{$strUrl}"{literal};
    pageList.init();
});

function search(){
    var A = $("#J_editTimeS").val();
    var B = $("#J_editTimeE").val();
    
    if (A =="" && B !="") 	IM.tip.warn("请输入起始时间");
    if (A !="" && B =="") 	IM.tip.warn("请输入截止时间");
    pageList.page = 1;
    pageList.param ='&'+$("#tableFilterForm").serialize();
    pageList.first();
}
    {/literal}
</script>