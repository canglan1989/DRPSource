<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<!--E table_filter--> 
<div class="table_filter marginBottom10">
    <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
    <div class="table_filter_main" id="J_table_filter_main">
        <div class="table_filter_main_row">        
            <div class="ui_title">代理商代码：</div>
            <div class="ui_text"><input type="text" id="tbxAgentNo" name="tbxAgentNo" value="{$qAgentNo}" style="width:100px"/></div>
            <div class="ui_title">代理商名称：</div>
            <div class="ui_text"><input type="text" id="tbxAgentName" name="tbxAgentName" style="width:180px;"/></div>
        </div>
        <div class="table_filter_main_row">
          <!-- <div class="ui_title">款项状态：</div>           
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbMoneyState" name="cbMoneyState">
            <option value="-100">请选择</option>
            <option value="1">底单入款</option>
            <option value="2">到账</option>
            <option value="3">冲销</option>
            </select></div> -->
            <div class="ui_title">合同号：</div>
            <div class="ui_text"><input type="text" id="tbxContractNo" name="tbxContractNo" style="width:110px"/></div>
            <div class="ui_title">打款交易号：</div>
            <div class="ui_text"><input type="text" id="tbxPostMoneyNo" name="tbxPostMoneyNo" style="width:110px"/></div>
           <div class="ui_title">充值状态：</div>           
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbInAccountState" name="cbInAccountState">
            <option value="-100">请选择</option>
            <option value="0">未充值</option>
            <option value="1">已充值</option>
            <option value="-1">取消充值</option>
            </select></div> 
            <div class="ui_button ui_button_search"><button onclick="QueryData()" type="button" class="ui_button_inner">搜 索</button></div>
        </div>
    </div>
    </form>
</div>
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
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
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>  
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table">
    	<table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">
                    <th width="80">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">打款交易号</div>
                        </div>
                    </th>   
                    <th width="110" >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">代理商代码/名称</div>
                        </div>
                    </th>
                    <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款产品</div></div></th>
                    <th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">关联合同号</div>
                        </div>
                    </th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">打款信息</div></div></th>
                    <th width="70" class="TA_r">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">打款金额</div>
                        </div>
                    </th>
                    <th width="70" class="TA_r">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">收款金额</div>
                        </div>
                    </th>
                    <th width="60">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">款项状态</div>
                        </div>
                    </th>
                    <th width="60">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值状态</div>
                        </div>
                    </th>
                    <th width="70" class="TA_r">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值金额</div>
                        </div>
                    </th>
                    <th width="50">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值人</div>
                        </div>
                    </th>
                    <th width="80">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值时间</div>
                        </div>
                    </th>
                    <th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值备注</div>
                        </div>
                    </th>
                    <th width="40">
                    	<div class="ui_table_thcntr">
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
    <div class="ui_pager">
    	<div id="divPager" class="ui_pager"></div>
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script language="javascript" type="text/javascript">
 $(function(){
	{/literal}
    var agentNo = "{$qAgentNo}";
    
	pageList.strUrl = "{$MoneyInAccountListBody}"; 
	{literal}
    $("#tbxAgentNo").val(agentNo);
          
	pageList.param = '&'+$("#tableFilterForm").serialize();   
   	pageList.init();
    
 });

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
}

_InDealWith = false;   
function InMoney(id,postMoneyNo,agentName)
{
    IM.dialog.show({
        width: 760,
	    height: null,
	    title: '充值操作',
	    html: IM.STATIC.LOADING,
        start:function(){
            MM.get("/?d=FM&c=InMoney&a=InMoneyModify","id="+id+"&postMoneyNo="+postMoneyNo+"&&agentName="+encodeURIComponent(agentName),function(q){
                $('.DCont')[0].innerHTML= q;
                
                new Reg.vf($('#J_backForm'),{callback:function(formData){
                    
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    
                    formData = "id="+id+"&"+$("#J_backForm").serialize();
                    _InDealWith = true;                    
                    var backData = $PostData('/?d=FM&c=InMoney&a=InMoneyModifySubmit',formData);                    
                    if(parseInt(backData) == 0){
                        pageList.reflash();
    				    _InDealWith = false;
    			        IM.dialog.hide();	
                        IM.tip.show("充值成功！");
    				}else{
                        _InDealWith = false;
                        IM.tip.warn(backData);
    				}
                }});
            })
        }
    });
}

function DelInMoney(id)
{        
    //数据已提交，正在处理标识
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    
    if(confirm("你确定要取消充值吗？"))
    {        
        _InDealWith = true;
        var backData = $PostData('/?d=FM&c=InMoney&a=DelInMoneySubmit',"id="+id);                    
        if(parseInt(backData) == 0){
            pageList.reflash();
		    _InDealWith = false;
            IM.tip.show("取消成功！");
		}else{
            _InDealWith = false;
            IM.tip.warn(backData);
		}
    }
}

</script>
{/literal} 