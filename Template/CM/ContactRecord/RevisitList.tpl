<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<div class="table_filter marginBottom10">  
	<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">客户ID：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerID" id="tbxCustomerID" value="{$CustomerID}" style="width:60px;" /></div>                         	        	
        	<div class="ui_title">客户名称：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerName" id="tbxCustomerName" value="" style="width:200px;"/></div>	              	        
            <div class="ui_title">网盟意向等级：</div>
            {literal}
			<div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({'control':'IntentionRating',data:MM.A(this,'data')},this)" 
            {/literal}
             class="ui_comboBox ui_comboBox_def" key="" value="" control="IntentionRating" data="{$strIntentionRatingJson}" style="width:100px;">
             <div class="ui_comboBox_text" style="width:80px;">
                	<nobr>全部</nobr>
             </div>
             <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>           	        	
        	<div class="ui_title">制定人：</div>            
            <div class="ui_comboBox">
            <select onchange="UserLevelChange(this)" id="cbUserLevel" name="cbUserLevel">
                <option value="-100">全部</option>
                <option value="1">自己</option>
                <option value="2">下级</option>
            </select>
            </div>
            <div id="divUserName" class="ui_text"><input type="text" name="CreateName" id="CreateName" value="{$CreateUserName}" value="" style="width:100px;"/></div>
        </div>
            <div class="table_filter_main_row">
                <div class="ui_title">回访时间：</div>
            <div class="ui_text">
                <input id="tbxSRevisitTime" type="text" class="inpCommon inpDate" name="tbxSRevisitTime"  onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxERevisitTime\')}'}){/literal}"/>
                至
                <input id="tbxERevisitTime" type="text" class="inpCommon inpDate" name="tbxERevisitTime"  onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSRevisitTime\')}'}){/literal}"/>	
            </div> 
                <div class="ui_title">拜访时间：</div>
            <div class="ui_text">
                <input id="tbxSContactTime" type="text" class="inpCommon inpDate" name="tbxSContactTime" value="{$bdate}" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxEContactTime\')}'}){/literal}"/>
                至
                <input id="tbxEContactTime" type="text" class="inpCommon inpDate" name="tbxEContactTime" value="{$edate}" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxSContactTime\')}'}){/literal}"/>	
            </div>
            </div>
	   <div class="table_filter_main_row">
            <div class="ui_title">回访状态：</div>
            <div class="ui_comboBox">
                <select id="cbRevisitStatus" name="cbRevisitStatus">
                <option value="-100">请选择</option>
                <option value="1">已回访</option>
                <option value="0">未回访</option>
                </select>
            </div>
            <div class="ui_title">回访人：</div>
            <div class="ui_text"><input type="text" name="tbxRevisitUserName" id="tbxRevisitUserName" value="" style="width:100px;"/></div>	    
            
            <div class="ui_title">小记类型：</div>
            <div class="ui_comboBox">
                <select id="cbIsVisit" name="cbIsVisit">
                <option value="-100">请选择</option>
                <option value="1" {if $selVisit == "1"}selected{/if}>拜访小记</option>
                <option value="0" {if $selVisit == "0"}selected{/if}>联系小记</option>
                </select>
            </div>
            		                                
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
</div>

<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
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
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">客户ID</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">网盟意向等级</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">小记类型</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">被拜访/联系人</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">拜访/联系时间</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">制定人</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">拜访/联系内容</div></div></th>  
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访状态</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访人</div></div></th> 
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访时间</div></div></th>  
                   <th width="84"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal}
<script type="text/javascript">
$(function(){    
	{/literal}
	pageList.strUrl = "{$RevisitListBody}"; 
	{literal}    
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.init();
});


function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.first();
}


function RevisitModify(id)
{
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "回访操作",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=ReVisitModify&id="+id, {"isReVisit":1}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
                                                
            new Reg.vf($('#J_ReVisitModify'),{
		     callback:function(formdata){////formdata 表单提交数据 对象数组格式
                formdata = $("#J_ReVisitModify").serialize();
                var backData = $PostData("/?d=CM&c=ContactRecord&a=ReVisitModifySubmit",formdata);
                if(parseInt(backData) == 0)
                {
                    IM.dialog.hide();
                    pageList.reflash();
                    IM.tip.show("添加成功！"); 
                }
                else
                {
                    IM.tip.warn(backData);
                }
          
	            }});
            
            });
      }
});
}


function GetRecordDetail(id)
{
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "小记明细",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=GetContactRecordDetail&id="+id, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
            
        });
      }
    });
}


function EditPredictIncome(id)
{    
    IM.dialog.show({
        width: 460,
	    height: null,
	    title: "修改预计到帐操作",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=EditPredictIncome&id="+id, {}, function (backData) {
		    $('.DCont')[0].innerHTML = backData;
                                                
            new Reg.vf($('#J_EditPredictIncome'),{
		     callback:function(formdata){////formdata 表单提交数据 对象数组格式
                formdata = $("#J_EditPredictIncome").serialize();
                var backData = $PostData("/?d=CM&c=ContactRecord&a=EditPredictIncomeSubmit",formdata);
                if(parseInt(backData) == 0)
                {
                    IM.dialog.hide();
                    pageList.reflash();
                    IM.tip.show("修改成功！"); 
                }
                else
                {
                    IM.tip.warn(backData);
                }
          
	            }});
            
            });
      }
    });
}

function UserLevelChange(obj)
{
    if(parseInt(obj.value)!=1)
    {
        $("#divUserName").show();
    }
    else
    {
        $("#divUserName").hide();
    }
}

</script>
{/literal}