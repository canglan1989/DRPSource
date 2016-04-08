<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">   
    {if $type == 1}
		<div class="tf">
        	<label>到账日期：</label>
            <div class="inp">{$objReceivablePayStateInfo->strReceivedDate|date_format:"%Y-%m-%d"}</div>
        </div>     
		<div class="tf">
        	<label>到帐金额：</label>
            <div class="inp">{$objReceivablePayStateInfo->iFrMoney}</div>
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
    {elseif $type == 2}
		<div class="tf">
        	<label>银行记录编号：</label>
            <div class="inp">{$objReceivablePayStateInfo->strErpBanckRecordId}</div>
        </div>    
		<div class="tf">
        	<label>到账银行账户：</label>
            <div class="inp">{$objReceivablePayStateInfo->strBankName}</div>
        </div> 
		<div class="tf">
        	<label>打款单位：</label>
            <div class="inp">{$objReceivablePayStateInfo->strErpPostObject}</div>
        </div> 
		<div class="tf">
        	<label>到账日期：</label>
            <div class="inp">{$objReceivablePayStateInfo->strReceivedDate|date_format:"%Y-%m-%d"}</div>
        </div>     
		<div class="tf">
        	<label>认领金额：</label>
            <div class="inp">{$objReceivablePayStateInfo->iFrMoney}</div>
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
    </div>                                                                                      
    <div class="ft">                                                                             
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div> 
    </div>                                                                                                                              
</form>                                                                                                                                  
</div>