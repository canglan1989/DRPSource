<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
           <div class="ui_title">代理商代码：</div>
           <div class="ui_text"><input type="text" name="tbxAgentNo" id="tbxAgentNo" value="" style="width:100px;"/></div>	                
           <div class="ui_title">代理商名称：</div>
           <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:200px;"/></div>
           <div class="ui_title">款项状态：</div>           
            <div class="ui_comboBox" style="margin-right:5px;">
                <select id="cbMoneyState" name="cbMoneyState">
                    <option value="-100">请选择</option>
                    <option value="-1">退回</option>
                    <option value="0">未收款</option>
                    <option value="1">底单入款</option>
                    <option value="2">到账</option>
                </select>
            </div> 
        </div>
        <div class="table_filter_main_row">        
        <div class="ui_title">打款交易号：</div>
        <div class="ui_text"><input type="text" id="tbxPostMoneyNo" name="tbxPostMoneyNo" style="width:110px"/></div>                    
        
        <div class="ui_title" title="打款时间">打款时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxPostSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxPostEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
        </div>
        </div>
        <div class="table_filter_main_row"> 
        <div class="ui_title">提交人：</div>
        <div class="ui_text"><input type="text" name="tbxPostUser" class="inpCommon" id="tbxPostUser"/></div>
        <div class="ui_title" title="提交时间">提交时间：</div>
        <div class="ui_text">
            <input id="tbxSubmitSDate" type="text" class="inpCommon inpDate" name="tbxSubmitSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxSubmitEDate\')}'}){/literal}"/>
            至
            <input id="tbxSubmitEDate" type="text" class="inpCommon inpDate" name="tbxSubmitEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSubmitSDate\')}'}){/literal}"/>	
        </div>
        <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
        <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
		</div>
    </div>
    </form>
</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
            <a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table" id="J_ui_table">                    	
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">                                	
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">款项类型</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">交易号</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号</div></div></th>
                   <!--<th><div class="ui_table_thcntr"><div class="ui_table_thtext">合同平台</div></div></th>-->
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商代码/名称</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">代理产品</div></div></th>
                   <!--<th ><div class="ui_table_thcntr"><div class="ui_table_thtext">收款平台</div></div></th>-->
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">打款信息</div></div></th>
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款底单</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">应收金额</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">已收金额</div></div></th>                   
                   <th  width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">状态</div></div></th>
                   <th  width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款时间</div></div></th>
                   <!--<th  width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">战区</div></div></th>-->
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">提交人/提交时间</div></div></th>
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
    <div class="ui_pager" id="divPager">    	
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script type="text/javascript">
$(function(){    
	{/literal}
	pageList.strUrl = "{$strUrl}"; 
	{literal}
        
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init(); 
    
}); 

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
</script>
{/literal} 