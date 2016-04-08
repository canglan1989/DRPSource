<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">   
		<div class="tf">
        	<label>代理商名称：</label>
            <div class="inp">{$strAgentName}</div>
        </div>       
        <div class="tf">
            <label><strong>款项分配：</strong></label>
            <div class="inp">
            <table cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">                                	
                   <th width="110"><div class="ui_table_thcntr"><div class="ui_table_thtext">产品名称</div></div></th>
                   <th width="110"><div class="ui_table_thcntr"><div class="ui_table_thtext">款项类型</div></div></th> 
                   <th width="160"><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款金额</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值金额</div></div></th>
               </tr>
           </thead>
           <tbody class="ui_table_bd">
           {foreach from=$arrayData item=data key=index}
            <tr class="{sdrclass rIndex=$index}">
            <td><div class="ui_table_tdcntr">{$data.c_product_name}</div></td> 
            <td><div class="ui_table_tdcntr">{$data.fr_type_text}</div></td> 
            <td><div class="ui_table_tdcntr">{$data.c_contract_no}</div></td> 
            <td class="TA_r"><div class="ui_table_tdcntr">{$data.fr_rev_money|string_format:"%.2f"}</div></td> 
            <td class="TA_r"><div class="ui_table_tdcntr">{$data.in_account_money|string_format:"%.2f"}</div></td> 
            </tr>    
            {/foreach} 
            </tbody>
         </table></div>
         </div>
        <div class="tf">                                    
            <label>备 注：</label>                             
            <div class="inp"><textarea name="tbxRemark" id="tbxRemark" cols="40" style="width:520px;height:80px"></textarea></div>
            <span class="info">请输入备注</span><span class="ok">&nbsp;</span><span class="err">限制100字以内</span>                 
        </div>                                                                                 
    </div>                                                                                      
    <div class="ft">                                                                             
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>                      
    </div>                                                                                                                              
</form>                                                                                                                                  
</div>