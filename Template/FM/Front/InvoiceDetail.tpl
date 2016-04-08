<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2>{$strTitle}</h2>
            </div>
        </div>
    </div>
</div>
<div class="form_bd">
	<form id="J_addInvoice" action="" name="newModifyForm" class="newModifyForm">
        <div class="tf" style="padding-top:20px;">
          <label> <input type="hidden" value="-100" name="tbxID" id="tbxID" /> 发票抬头： </label>
          <div class="inp">
          {$agentName}
          </div>
        </div>  
        <div class="tf">
          <label>产品： </label>
          <div class="inp">
          {foreach from=$arrayInvoice item=data key=index}
          {$data.c_product_name}
          {/foreach}
          </div>
        </div>
        {if $permitPath != ""}
        <div class="tf">
          <label>一般纳税人：</label>
          <div class="inp">
            <input type="hidden" value="{$permitPath}" name="tbxOldPermitPath"/>
                <div id="J_uploadImg0" class="img" style="display:block">
                    <img src='{$permitPath}' width="200px"/>
                </div>                
          </div>
        </div> 
        {/if}        
        {foreach from=$arrayInvoice item=data key=index}
        <div class="tf">
          <label>发票种类： </label>
          <div class="inp">
          {$data.invoice_type_name}
          </div>
        </div>    
        <div class="tf">
          <label>申请金额： </label>
          <div class="inp">
          {$data.f_invoice_apply_money}
          </div>
        </div>      
        <div class="tf">
           <label>备注：</label>
           <div class="inp">
            {$data.f_remark}
           </div> 
        </div> 
          {/foreach}
        <div class="tf tf_submit">
           <label>&nbsp;</label>
            <div class="inp">
            <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
            </div>
            </div>
          </div>
    </form>                             
</div> 
</div>
<!--E sidenav_neighbour--> 

{literal}
<script language="javascript" type="text/javascript">

</script>
{/literal}
