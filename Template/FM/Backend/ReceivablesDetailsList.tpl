<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
           <div class="ui_title">代理商代码：</div>
           <div class="ui_text"><input type="text" name="tbxAgentNo" id="tbxAgentNo" value="{$agentNo}" style="width:110px;"/></div>	                
           <div class="ui_title">代理商名称：</div>
           <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:200px;"/></div>
           <div class="ui_title">合同号：</div>
           <div class="ui_text"><input type="text" name="tbxPactNo" id="tbxPactNo" value="" style="width:130px;"/></div>
            <div class="ui_title">打款交易号：</div>
            <div class="ui_text"><input type="text" id="tbxPostMoneyNo" name="tbxPostMoneyNo" style="width:110px"/></div>           
           
        </div>
        <div class="table_filter_main_row">        
        <div class="ui_title" title="打款时间">打款时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxPostSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxPostEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
        </div>
        <div class="ui_title">款项状态：</div>           
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbMoneyState" name="cbMoneyState">
            <option value="-100">请选择</option>
            <option value="-1">退回</option>
            <option value="0">未收款</option>
            <option value="1">底单入款</option>
            <option value="2">到账</option>
            </select></div> 
        <div class="ui_title">提交人：</div>
        <div class="ui_text"><input type="text" name="tbxPostUser" class="inpCommon" id="tbxPostUser" style="width:110px"/></div>
        <div class="ui_title" title="提交时间">提交时间：</div>
        <div class="ui_text">
            <input id="tbxSubmitSDate" type="text" class="inpCommon inpDate" name="tbxSubmitSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxSubmitEDate\')}'}){/literal}"/>
            至
            <input id="tbxSubmitEDate" type="text" class="inpCommon inpDate" name="tbxSubmitEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSubmitSDate\')}'}){/literal}"/>	
        </div>

		</div>
        <div class="table_filter_main_row">        
        <div class="ui_title" title="到帐日期">到帐日期：</div>
        <div class="ui_text">
            <input id="tbxReceivedSDate" type="text" class="inpCommon inpDate" name="tbxReceivedSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxReceivedEDate\')}'}){/literal}"/>
            至
            <input id="tbxReceivedEDate" type="text" class="inpCommon inpDate" name="tbxReceivedEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxReceivedSDate\')}'}){/literal}"/>	
        </div>
        <div class="ui_title">银行记录编号：</div>
        <div class="ui_text"><input type="text" name="tbxERPBankRecordID" class="inpCommon" id="tbxERPBankRecordID" style="width:100px"/></div>
        <div class="ui_title" title="认领状态">认领状态：</div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbIsCheckInAccount" name="cbIsCheckInAccount">
            <option value="-100">请选择</option>
            <option value="1">未认领</option>
            <option value="2">已认领</option>
            </select></div> 
        <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
		</div>
    </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
</a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
            <a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
            <a title="全屏显示表格" class="ui_button ui_link" href="javascript:;" id="maxA"><span class="ui_icon ui_icon_fullscreen">&nbsp;</span>全屏</a>
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
                   <th width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">交易号</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商代码/名称</div></div></th>
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款产品</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">打款信息</div></div></th>
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款底单</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款金额</div></div></th>
                   <th class="TA_r" width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">收款金额</div></div></th>                   
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">款项状态</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款时间</div></div></th>
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">战区</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">提交人/提交时间</div></div></th>                   
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">到账银行</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">到账日期</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">银行记录编号</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">认领状态</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
	$.addMax("maxA");
        {/literal}  
	pageList.strUrl = "{$ReceivablesDetailsListBody}"; 
	{literal}
                
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init(); 
    
}); 

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}

var _InDealWith = false;
function BackMoney(post_money_id)
{
    JumpPage("/?d=FM&c=PayMoney&a=BackMoney&id="+post_money_id);
}

function MoneyInAccount(post_money_id)
{
    JumpPage("/?d=FM&c=PayMoney&a=MoneyInAccount&id="+post_money_id);
}

var CheckMoneyInAccountTemplate = {
    step1:"<div class='bd'><div class='tf'><label><em class='require'>*</em>银行记录编号：</label>"
        +"<div class='inp'><input name='post_money_id' type='hidden' id='post_money_id' value='0'/><input name='tbxBankRecordNo' type='text' id='tbxBankRecordNo' value='' style='width:140px' onkeyup='return FloatNumber(this)' maxlength='20' valid='required'/>"
        +"</div><span class='info'></span><span class='err'>请输入ERP银行记录编号</span></div>"
        +"</div><div class='ft'>"                                                                             
        +"<div class='ui_button ui_button_cancel'><a onclick='IM.dialog.hide()' class='ui_button_inner' href='javascript:;'>关闭</a></div>"
        +"<div class='ui_button'><div class='ui_button_left'></div><button class='ui_button_inner' id='butNextStep' onclick='ShowERPInAccount()' type='button'>下一步</button></div>"           
        +"</div>",
                
    step2:"<div class='bd' id='divERPInAccount'></div><div class='ft'>"                                                                             
        +"<div class='ui_button ui_button_cancel'><a onclick='IM.dialog.hide()' class='ui_button_inner' href='javascript:;'>关闭</a></div>"
        +"<div class='ui_button'><div class='ui_button_left'></div><button class='ui_button_inner' id='butBackStep' onclick='BackStep1()' type='button'>上一步</button></div>"                    
        +"<div class='ui_button ui_button_confirm'><button class='ui_button_inner' id='butCheckMoney' onclick='CheckMoneyInAccountSubmit()' type='button'>确 定</button></div>"                    
        +"</div>"
}

function CheckMoneyInAccount(post_money_id,agent_name)
{   
    IM.dialog.show({
        width: 400,
	    height: null,
	    title: '款项认领',
	    html: IM.STATIC.LOADING,
        start:function(){
                $('.DCont')[0].innerHTML= "<div class='DContInner setPWDComfireCont'><form id='J_backForm' name='J_backForm'></form></div>";
                
                $('#J_backForm').html(CheckMoneyInAccountTemplate.step1);
                $("#post_money_id").val(post_money_id);
                
        }
    });
}

function BackStep1()
{
    var id = $("#tbxBankRecordNo").val();
    var post_money_id = $("#post_money_id").val();
    $('#J_backForm').html(CheckMoneyInAccountTemplate.step1);
    $("#tbxBankRecordNo").val(id);
    $("#post_money_id").val(post_money_id);
}

function ShowERPInAccount()
{        
    if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    
    if($("#tbxBankRecordNo").val() == "")
    {
		IM.tip.warn("请输入银行记录编号！");
        return false;
    }
    
    _InDealWith = true;   
    var jsonData = $PostData("/?d=FM&c=PayMoney&a=CheckMoneyShowERPInAccount",$("#J_backForm").serialize());

    _InDealWith = false;
	if(jsonData == "")
    {
		IM.tip.warn("银行记录不存在！");
        return false;
    }
    
    var jsonObj = eval("(" + jsonData + ")");
    if (jsonObj != undefined && jsonObj != null)
    {
        var post_money_id = $("#post_money_id").val();
        $('#J_backForm').html(CheckMoneyInAccountTemplate.step2);
        
        var html = "<div class='tf'><label>银行记录编号：</label><div class='inp'><input name='post_money_id' type='hidden' id='post_money_id' value='0'/><input name='tbxBankRecordNo' type='hidden' id='tbxBankRecordNo' value='"+jsonObj.ID
        +"' style='width:140px' valid='required'/>"+jsonObj.ID+"</div></div>";
        html += "<div class='tf'><label>到账银行账户：</label><div class='inp'>"+jsonObj.BA_ACCOUNT_NAME+"</div></div>";
        html += "<div class='tf'><label>打款单位：</label><div class='inp'>"+jsonObj.OBJECTNAME+"</div></div>";
        html += "<div class='tf'><label>到账日期：</label><div class='inp'>"+jsonObj.MONEYTOTIME+"</div></div>";
        html += "<div class='tf'><label>打款金额：</label><div class='inp'>"+jsonObj.A_MONEY+"</div></div>";
        html += "<div class='tf'><label>强制认领：</label><div class='inp'><input name='IsCoerce' class='checkInp' type='checkbox' id='IsCoerce' value='1' /></div></div>";        
        $("#divERPInAccount").html(html);
        $("#post_money_id").val(post_money_id);
    }
    
}


function CheckMoneyInAccountSubmit()
{    
    //数据已提交，正在处理标识
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    
    var postData = "&"+$("#J_backForm").serialize();    
    _InDealWith = true;   
    var backData = $PostData("/?d=FM&c=PayMoney&a=CheckMoneyInAccount",postData);
    
	if(backData == 0)
    {
        IM.dialog.hide();	
		IM.tip.show("认领成功！");
        _InDealWith = false;  
        pageList.reflash();
    }    
    else
    {
        IM.tip.warn(backData);
        _InDealWith = false;                    
    }                 
}

function PostMoneyConfirm(post_money_id)
{
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    
    if(!confirm("请确认该款项已到帐。"))
        return ;
        
    _InDealWith = true;  
    var nowTime = new Date();
    var nowDate = nowTime.getFullYear()+"-"+(nowTime.getMonth()>9?nowTime.getMonth().toString():'0' + nowTime.getMonth())+"-"+(nowTime.getDate()>9?nowTime.getDate().toString():'0' + nowTime.getDate());
    var backData = $PostData("/?d=FM&c=PayMoney&a=MoneyInAccountSubmit","id="+post_money_id+"&tbxInDate="+nowDate);
    
	if(backData == 0)
    {
		IM.tip.show("确认成功！");
        _InDealWith = false;  
        pageList.reflash();
    }    
    else
    {
        IM.tip.warn(backData);
        _InDealWith = false;                    
    } 
}

function ExportExcel()
{
    window.open("/?d=FM&c=InMoney&a=ReceivablesDetailsBody&exportExcel=1" + pageList.param + "&sortField=" + pageList.sortField);
}

function MoneyInAccountDetail(post_money_id)
{    
    IM.dialog.show({
        width: 400,
	    height: null,
	    title: '收款详情',
	    html: IM.STATIC.LOADING,
        start:function(){
            $('.DCont')[0].innerHTML= $PostData("/?d=FM&c=InMoney&a=MoneyInAccountDetail&id="+post_money_id);
        }
    });
}

function CheckMoneyInAccountDetail(post_money_id)
{    
    IM.dialog.show({
        width: 400,
	    height: null,
	    title: '认领详情',
	    html: IM.STATIC.LOADING,
        start:function(){
            $('.DCont')[0].innerHTML= $PostData("/?d=FM&c=InMoney&a=CheckMoneyInAccountDetail&id="+post_money_id);
        }
    });
}

</script>
{/literal} 