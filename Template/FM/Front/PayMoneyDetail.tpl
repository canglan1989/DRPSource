<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：财务管理<span>&gt;</span>打款明细<span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
    <div class="form_hd_oper">
    	<a class="ui_button ui_button_dis" onclick="PageBack()" href="javascript:;">
    		<div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div>
    	</a>
    </div>
</div>
<div class="form_bd">
    <div class="form_block_hd"><h3 class="ui_title">打款信息</h3></div>
	<div class="form_block_bd">
    {if $isBackend == 1}
	    <div class="tf">
	    	<label>代理商：</label>
	        <div class="inp">
	        {$objPostMoneyInfo->strAgentNo} {$objPostMoneyInfo->strAgentName}
	        </div>
	    </div>
     {/if}
	    <div class="tf">
	    	<label>打款交易号：</label>
	        <div class="inp">
	        {$objPostMoneyInfo->strPostMoneyNo}
	        </div>
	    </div>
	    <div class="tf">
	    	<label>打款日期：</label>
	        <div class="inp">
	        {$objPostMoneyInfo->strPostDate|date_format:"%Y-%m-%d"}
	        </div>
	    </div> 
	    <div class="tf">
	    	<label>支付方式：</label>
	        <div class="inp">
	        {$objPostMoneyInfo->strPaymentName}
	        </div>
	    </div>     
	    <div class="tf wy" style="display:none">
	    	<label>打款账号：</label>
	        <div class="inp">
	        {$objPostMoneyInfo->strAgentBankName}
	        </div>
	    </div>
	    <div class="tf wy" style="display:none">
	    	<label>收款账户：</label>
	        <div class="inp">
	        {$objPostMoneyInfo->strBankName}
	        </div>
	    </div> 
	    <div class="tf kq" style="display:none">
	    	<label>快钱交易号：</label>
	        <div class="inp">
	            {$objPostMoneyInfo->strRpNum}
	        </div>
	    </div> 
	    <div class="tf kq" style="display:none">
	    	<label>打款账户名称：</label>
	        <div class="inp">
	            {$objPostMoneyInfo->strPeerBankName}
	        </div>
	    </div>      
	    <div class="tf">
	    <label>底单扫描件：</label>
	    <div class="inp qua_upload">
	      {if $objPostMoneyInfo->strRpFiles != ""}
	        <a href="javascript:;" title="点击看大图" onclick="ViewPic('/?d=FM|c=PayMoney|a=ViewImage|id={$objPostMoneyInfo->iPostMoneyId}')"><img src='/?d=FM&c=PayMoney&a=ViewImage&id={$objPostMoneyInfo->iPostMoneyId}' style="width:200px;" /></a>
	      {else}
	        无
	      {/if}
	    </div>
	    </div>
     </div>
    <div class="form_block_hd"><h3 class="ui_title">款项分配</h3></div>
	<div class="form_block_bd">
      <div class="tf">
            <label><strong>产品名称：</strong></label>
            <div class="inp">
            <label style="text-align:left;width:200px;"><strong>合同号</strong></label>
            <label style="text-align:right;width:100px;"><strong>保证金</strong></label>
            <label style="text-align:right;width:100px;"><strong>预存款</strong></label>
            </div>
      </div>
      {foreach from=$arrayProduct item=data key=index}
      <div class="tf">
            <label>{$data.product_type_name}</label>
            <div class="inp">
            <label style="text-align:left;width:200px;">{$data.contract_no}</label>
            <label style="text-align:right;width:100px;">{$data.gua_money}</label>
            <label style="text-align:right;width:100px;">{$data.pre_money}</label>
            </div>
        </div>      
      {/foreach} 
        <div class="tf">
        	<label>合计金额：</label>
            <div class="inp">
                <label id="divPostMoneyAmount" style="text-align:left;width:200px;">{$objPostMoneyInfo->iPostMoneyAmount}</label>
            </div>
        </div>
	    <div class="tf">
	       <label>备注：</label>
	       <div class="inp">
	        {$objPostMoneyInfo->strPostRemark}
	       </div> 
	    </div> 
    </div>
    {if $isBackMoney == 1}
	<form id="J_backForm" action="" name="J_backForm" class="GuaranteeForm">
	    <div class="tf">
	       <label>退回备注：</label>
	       <div class="inp">
            <textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark"></textarea>
            <span class="c_info">限制128字以内</span><span class="ok">&nbsp;</span><span class="err">限制128字以内</span> 
           </div>  
	    </div>
        <div class="tf tf_submit">
       <label>&nbsp;</label>
        <div class="inp">
        <div class="ui_button ui_button_confirm">
            <button id="butOk" class="ui_button_inner" type="submit">退 回</button>
        </div>
        <div class="ui_button ui_button_cancel">
            <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
        </div>
        </div>
      </div>      
{literal} 
<script language="javascript" type="text/javascript">
var _InDealWith = false;
$(function(){
    {/literal}
    var id = parseInt({$objPostMoneyInfo->iPostMoneyId}); 
{literal} 
    new Reg.vf($('#J_backForm'),{callback:function(formData){
        
        //数据已提交，正在处理标识
    	if (_InDealWith) 
    	{
    		IM.tip.warn("数据已提交，正在处理中！");
    		return false;
    	}
        
        formData = "id="+id+"&"+$("#J_backForm").serialize();
        _InDealWith = true;                    
        var backData = $PostData('/?d=FM&c=PayMoney&a=BackMoneySubmit',formData);                    
        if(parseInt(backData) == 0){
		    _InDealWith = false;
            IM.tip.show("操作成功！");
            PageBack();
		}else{
            _InDealWith = false;
            IM.tip.warn(backData);
		}
    }});
    
});
</script>
{/literal} 
     </form>
    {/if}
{if $isBackend == 1}
    {if $isMoneyInAccount == 1}        
	<form id="J_backForm" action="" name="J_backForm" class="GuaranteeForm">
        <div class="tf">
        	<label><em class="require">*</em>到账日期：</label>
            <div class="inp">
            <input id="tbxInDate" class="inpCommon inpDate" type="text" onfocus="WdatePicker()" name="tbxInDate" value="{$smarty.now|date_format:"%Y-%m-%d"}"/>
            &nbsp;&nbsp;<input name="chkOnTheWay" class="checkInp" type="checkbox" id="chkOnTheWay" value="1" checked="checked" /><span style="color:red">在途资金</span>
            </div>
        </div>
	    <div class="tf">
	       <label>收款备注：</label>
	       <div class="inp">
            <textarea name="tbxRemark" cols="50" style="width:500px;height:80px;" id="tbxRemark"></textarea>
            <span class="c_info">限制128字以内</span><span class="ok">&nbsp;</span><span class="err">限制128字以内</span> 
           </div>  
	    </div>
        <div class="tf tf_submit">
       <label>&nbsp;</label>
        <div class="inp">
        <div class="ui_button ui_button_confirm">
            <button id="butOk" class="ui_button_inner" type="submit">收  款</button>
        </div>
        <div class="ui_button ui_button_cancel">
            <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
        </div>
        </div>
      </div>      
{literal} 
<script language="javascript" type="text/javascript">
var _InDealWith = false;
$(function(){
    {/literal}
    var id = parseInt({$objPostMoneyInfo->iPostMoneyId}); 
{literal} 
    new Reg.vf($('#J_backForm'),{callback:function(formData){
        
        //数据已提交，正在处理标识
    	if (_InDealWith) 
    	{
    		IM.tip.warn("数据已提交，正在处理中！");
    		return false;
    	}
        
        formData = "id="+id+"&"+$("#J_backForm").serialize();
        _InDealWith = true;                    
        var backData = $PostData('/?d=FM&c=PayMoney&a=MoneyInAccountSubmit',formData);                    
        if(parseInt(backData) == 0){
		    _InDealWith = false;
            IM.tip.show("操作成功！");
            PageBack();
		}else{
            _InDealWith = false;
            IM.tip.warn(backData);
		}
    }});
    
});
</script>
{/literal} 
     </form>
    {/if}
    {if $objPostMoneyInfo->iPostMoneyState >= 1}
    <div class="form_block_hd"><h3 class="ui_title">收款详情</h3></div>
    <div class="tf">
    	<label>到账日期：</label>
        <div class="inp">
        {$objReceivablePayStateInfo->strReceivedDate|date_format:"%Y-%m-%d"}{if $objPostMoneyInfo->iPostMoneyState==1}
        &nbsp;&nbsp;<span style="color:red">在途资金</span>{/if}
        </div>
    </div>
    {if $objReceivablePayStateInfo->iReceivableUid > 0}
	<div class="tf">
    	<label>收款备注：</label>
        <div class="inp">{$objReceivablePayStateInfo->strReceivableRemark}</div>
    </div>
	<div class="tf">
    	<label>收款操作人：</label>
        <div class="inp">{$objReceivablePayStateInfo->strReceivableUserName}</div>
    </div>
	<div class="tf">
    	<label>收款操作时间：</label>
        <div class="inp">{$objReceivablePayStateInfo->strReceivableTime}</div>
    </div>  
    {else}
	<div class="tf">
    	<label>到帐备注：</label>
        <div class="inp">{$objReceivablePayStateInfo->strReceivedRemark}</div>
    </div>      
    {/if}
	<div class="tf">
    	<label>到帐操作人：</label>
        <div class="inp">{$objReceivablePayStateInfo->strReceivedUserName}</div>
    </div>
	<div class="tf">
    	<label>到帐操作时间：</label>
        <div class="inp">{$objReceivablePayStateInfo->strReceivedTime}</div>
    </div>
    {if $objReceivablePayStateInfo->iCheckInAccountUid >0}
    <div class="form_block_hd"><h3 class="ui_title">认领详情</h3></div>
		<div class="tf">
        	<label>银行记录编号：</label>
            <div class="inp">{$objReceivablePayStateInfo->strErpBanckRecordId}</div>
        </div>    
		<div class="tf">
        	<label>打款单位：</label>
            <div class="inp">{$objReceivablePayStateInfo->strErpPostObject}</div>
        </div>    
		<div class="tf">
        	<label>操作人：</label>
            <div class="inp">{$objReceivablePayStateInfo->strCheckInAccountUserName}</div>
        </div>
		<div class="tf">
        	<label>操作时间：</label>
            <div class="inp">{$objReceivablePayStateInfo->strCheckInAccountTime}</div>
        </div>
    {/if}
    {/if}
{/if}
</div> 
</div>
{literal} 
<script language="javascript" type="text/javascript">
$(function(){    
    {/literal}
    var payTypeID = parseInt({$objPostMoneyInfo->iPaymentId}); 
    {literal}
    $(".wy").hide();
    $(".kq").hide();
    
    if( payTypeID != -100 && payTypeID != PayTypes.Cash)
    {
        if(payTypeID == PayTypes.QuickMoney)
        {
           $(".kq").each(function(){
            this.style.display = "";
           }); 
        }
        else
        {           
           $(".wy").each(function(){
            this.style.display = "";
           }); 
        }
    }
});
</script>
{/literal} 
<!--E sidenav_neighbour--> 