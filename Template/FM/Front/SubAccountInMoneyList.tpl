<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<!--E table_filter--> 
<div class="table_filter marginBottom10">
    <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
    <div class="table_filter_main" id="J_table_filter_main">
        <div class="table_filter_main_row">            
            <div class="ui_title">账户类型：</div>
            <div class="ui_text">
                <select id="cbAccountType" name="cbAccountType">
                </select>
            </div>  
           <div class="ui_title">产品：</div>
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType"></select></div>           
           <div class="ui_title">下级账户：</div>
            <div class="ui_comboBox" style="margin-right:5px;">
            <select id="cbSubAccount" name="cbSubAccount">
            <option value="-100">请选择</option>          
            {foreach from=$arraySubAccount item=data key=index}        
            <option value="{$data.user_id}">{$data.user_name} {$data.e_name}</option>          
            {/foreach}        
            </select></div>
            <div class="ui_button ui_button_search"><button onclick="QueryData()" type="button" class="ui_button_inner">搜 索</button></div>
        </div>
	
    </div>
    </form>
</div>
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="SubAccountInMoneyModify()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_text">给下级帐户转款</div>
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
                	<th style="width:80px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">编号</div>
                        </div>
                    </th>
                    <th style="width:200px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">合同号</div>
                        </div>
                    </th>  
                	<th style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">账户类型</div>
                        </div>
                    </th> 
                	<th style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">产品</div>
                        </div>
                    </th>
                    <th style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">下级财务帐户</div>
                        </div>
                    </th>
                    <th class="TA_r" style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">转款金额</div>
                        </div>
                    </th>
                	<th style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">操作人</div>
                        </div>
                    </th>
                	<th style="width:140px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">操作时间</div>
                        </div>
                    </th>
                    <th >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">备注</div>
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
    cbDataBind.AccountTypes("cbAccountType");
    $GetProduct.BindSignedProductType("cbProductType", true);  
    
	{/literal}
    $("#cbProductType").val({$iProductType});
    $("#cbAccountType").val({$iAccountType});
    $("#cbSubAccount").val({$iFinanceUid});
    
	pageList.strUrl = "{$ListBody}"; 
	{literal}                      
	pageList.param = '&'+$("#tableFilterForm").serialize();
   	pageList.init();
    
 });

 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 
_InDealWith = false;   
function SubAccountInMoneyModify()
{
    IM.dialog.show({
        width: 700,
	    height: null,
	    title: '给下级财务帐户转款操作',
	    html: IM.STATIC.LOADING,
        start:function(){
            $('.DCont')[0].innerHTML = $PostData('/?d=FM&c=AccountInOutMoney&a=SubAccountInMoneyModify');
            
            new Reg.vf($('#J_backForm'),{callback:function(formData){
                
                //数据已提交，正在处理标识
            	if (_InDealWith) 
            	{
            		IM.tip.warn("数据已提交，正在处理中！");
            		return false;
            	}
                
                formData = "cbAccountName="+$("#cbAccountName").val()+"&tbxRemark="+$("#tbxRemark").val();                
                var tbxGuaMoney = document.getElementsByName("tbxGuaMoney");
                var tbxPreMoney = document.getElementsByName("tbxPreMoney");
                var tbxRewMoney = document.getElementsByName("tbxRewMoney");
                
                for(var i=0;i<tbxGuaMoney.length;i++)
                {
                    if(parseInt(tbxGuaMoney[i].value) > parseInt($("#div"+tbxGuaMoney[i].id.substring(3)).html())
                        ||parseInt(tbxPreMoney[i].value) > parseInt($("#div"+tbxPreMoney[i].id.substring(3)).html())
                        ||parseInt(tbxRewMoney[i].value) > parseInt($("#div"+tbxRewMoney[i].id.substring(3)).html()))
                    {                        
                        IM.tip.warn("转款金额超出可用金额，请检查。");
                        return;
                    }
                    formData += "&"+tbxGuaMoney[i].id+"="+tbxGuaMoney[i].value+"&"+tbxPreMoney[i].id+"="+tbxPreMoney[i].value+"&"+tbxRewMoney[i].id+"="+tbxRewMoney[i].value;
                }
    
                _InDealWith = true;                    
                var backData = $PostData('/?d=FM&c=AccountInOutMoney&a=SubAccountInMoneyModifySubmit',formData);                    
                if(parseInt(backData) == 0){
    			    _InDealWith = false;
    		        IM.dialog.hide();	
                    IM.tip.show("转款成功！");
                    pageList.reflash();
    			}else{
                    _InDealWith = false;
                    IM.tip.warn(backData);
    			}
            }});
        }
    });
}

function CalculateMoneyAmount()
{    
    var tbxGuaMoney = document.getElementsByName("tbxGuaMoney");
    var tbxPreMoney = document.getElementsByName("tbxPreMoney");
    var tbxRewMoney = document.getElementsByName("tbxRewMoney");
    
    if(tbxGuaMoney.length <= 0)
        return;
    
    var postMoneyAmount = 0;
    for(var i=0;i<tbxGuaMoney.length;i++)
    {
        postMoneyAmount += parseFloat(tbxGuaMoney[i].value) + parseFloat(tbxPreMoney[i].value)+parseFloat(tbxRewMoney[i].value);
    }
    
    $("#spanMoneyAmount").html(parseFloat(postMoneyAmount).toFixed(2));
}

</script>
{/literal} 