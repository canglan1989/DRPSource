<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" name="tableFilterForm" id="tableFilterForm">
        <div id="J_table_filter_main" class="table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">代理商代码：</div>
                <div class="ui_text">
                    <input id="tbxAgentNo" type="text" maxlength="30" style="width:120px;" name="tbxAgentNo" value="{$agentNo}"/>
                </div>
                <label class="ui_title" style=" margin-right:20px">
                <input type="checkbox" value="1" {if $agentNo != "" } checked="checked" {/if} name="chkExactMatch" id="chkExactMatch" class="checkInp" style="vertical-align:middle" /><span title="精确匹配">精确匹配</span>
                </label>
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text">
                <input id="tbxAgentName" type="text" style="width:200px;" maxlength="48" value="" name="tbxAgentName"/>
                </div>
                <div class="ui_title">文件名称：</div>
                <div class="ui_text">
                    <input id="tbxFileName" type="text" style="width:200px;" maxlength="48" value="" name="tbxFileName"/>
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">附件类型：</div>
                <div class="ui_comboBox">
                    <select name="cbFileType" id="cbFileType">
                        <option value="-100">请选择</option>
                        {foreach from=$arrayAgentDocType item=value key=key}
                            <option value="{$key}">{$value}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="ui_title">作者：</div>
                <div class="ui_text">
                    <input id="tbxAuthor" class="inpCommon" type="text" name="tbxAuthor" value=""/>
                </div>
                <div class="ui_title">添加人：</div>
                <div class="ui_text">
                    <input id="tbxCreateUser" class="inpCommon" type="text" name="tbxCreateUser" value=""/>
                </div>
                <div class="ui_title">添加日期：</div>
                <div class="ui_text">      
                    {literal}
                        <input id="J_editTimeS" value="{/literal}{$BeginTime}{literal}" class="inpCommon inpDate" name="tbxCreateSTime" onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})" type="text"/> 至
                        <input id="J_editTimeE" value="{/literal}{$EndTime}{literal}" class="inpCommon inpDate" name="tbxCreateETime" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})" type="text"/>
                    {/literal}
                </div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜索</button></div>	
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
            	<th title="附件名称">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">附件名称</div>
                    </div>
                </th>
            	<th title="所属代理商">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">所属代理商</div>
                    </div>
                </th>
            	<th style="width:120px;" title="附件类型">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">附件类型</div>
                    </div>
                </th>
            	<th style="width:120px;" title="作者">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">作者</div>
                    </div>
                </th>
                <th style="width:140px;" title="添加人">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">添加人</div>
                    </div>
                </th>
                <th style="width:150px;" title="添加时间">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">添加时间</div>
                    </div>
                </th>
                <th style="width:100px;" title="操作">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">操作</div>
                    </div>
                </th>
           </tr>
           </thead>
            <tbody id="pageListContent" class="ui_table_bd">
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
<script language="javascript" type="text/javascript">

$(document).ready(function(){
    pageList.strUrl={/literal}"{$ListBody}"{literal};
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.init();
})

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}

function DownLoad(filepath,filename){
    window.open("/Action/Common/download.php?ft=agentdoc&fp="+filepath+"&pn="+encodeURIComponent(filename));
}

</script>
{/literal}