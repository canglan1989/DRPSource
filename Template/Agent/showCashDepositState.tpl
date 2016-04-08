<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置当前位置：代理商管理<span>&gt;</span>签约管理<span>&gt;</span>我的签约<span>&gt;</span>资金卡片信息--代理商打款</div>
        <!--E crumbs-->     
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
            	<div class="form_hd_left">
            	<div class="form_hd_right">
                	<div class="form_hd_mid">
                    	<h2>资金卡片信息--代理商打款</h2>                        
                    </div>
                </div>
                </div>    
                <div class="form_hd_oper">
                    <a href="javascript:;" onClick="PageBack();" class="ui_button ui_button_dis"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
                </div>            
            </div>
            <!--S form_bd-->
            <div class="form_bd">
            	<!--S form_block_bd-->
                <div class="form_block_bd"> 
                    	<div class="list_table_main marginBottom10 ">                        
                        	<div class="ui_table ui_table_nohead">
                            		<div class="ui_table_hd">
                                        <div class="ui_table_hd_inner">
                                            <h4 class="title">打款信息</h4>
                                        </div>
                                    </div>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">交易号</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.fr_no}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">打款底单</div></td>
                                                <td><div class="ui_table_tdcntr"><a target="_blank" href="./{$arrMoneyInfo.fr_rp_files}">查看底单</a></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">款项类型</div></td>
                                                <td>
                                                <div class="ui_table_tdcntr">
                                                {if $arrMoneyInfo.fr_type eq 1}
                                                保证金 
                                                {elseif $arrMoneyInfo.fr_type eq 2}
                                                预存款 
                                                {elseif $arrMoneyInfo.fr_type eq 3}
                                                保证金转预存款
                                                {elseif $arrMoneyInfo.fr_type eq 4}
                                                预存款转保证金
                                                {/if}
                                                </div>
                                                </td>
                                                <td class="even"><div class="ui_table_tdcntr">打款提交人</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.create_user_name}</div></td>
                                            </tr>
                                            <!--<tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">产品</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.c_product_name}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">打款提交时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.create_time}</div></td>
                                            </tr>-->
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">金额</div></td>
                                                <td><div class="ui_table_tdcntr"><b class="amountStyle">￥{$arrMoneyInfo.fr_rev_money}</b></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">打款代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.fr_object_name}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">打款信息</div></td>
                                                <td>
                                                <div class="ui_table_tdcntr">
                                                	<dl class="bankInfo">
                                                    	<dt>支付方</dt>
                                                        <dl><span>{$arrMoneyInfo.bank_name}</span><span>{$arrMoneyInfo.account_name}</span><span>{$arrMoneyInfo.account_no}</span></dl>
                                                    </dl>
                                                    <dl class="bankInfo">
                                                    	<dt>收款方</dt>
                                                        <dl><span>{$arrMoneyInfo.ba_account_name}</span><span></span><span>{$arrMoneyInfo.ba_account_no}</span></dl>
                                                    </dl>
                                                </div>
                                                </td>
                                                <td class="even"><div class="ui_table_tdcntr">打款备注</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.fr_remark}</div></td>
                                            </tr>                                                                                        
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">支付方式</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.fr_payment_name}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">打款时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrMoneyInfo.create_time}</div></td>
                                            </tr>
                                        </tbody>
                                   </table>   
                        	</div>                    
                    	</div>
						
                    	<div class="list_table_main">                        
                        	<div class="ui_table ui_table_nohead">
                            		<div class="ui_table_hd">
                                        <div class="ui_table_hd_inner">
                                            <h4 class="title">入款信息</h4>
                                        </div>
                                    </div>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">款项状态</div></td>
                                                <td>
                                                <div class="ui_table_tdcntr">
                                                {if $arrInMoneyInfo.fr_state == 0}
                                                    未到账
                                                {elseif $arrInMoneyInfo.fr_state == 1}
                                                    底单入款
                                                {elseif $arrInMoneyInfo.fr_state == 2}
                                                    到账
                                                {elseif $arrInMoneyInfo.fr_state == -1}
                                                    取消充值
                                                {elseif $arrInMoneyInfo.fr_state == 3}
                                                    已充值
                                                {else}
                                                    未知
                                                {/if}
                                                </div>
                                                </td>
                                                <td class="even"><div class="ui_table_tdcntr">到账时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrInMoneyInfo.income_time}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">入款金额</div></td>
                                                <td><div class="ui_table_tdcntr"><b class="amountStyle">￥{$arrInMoneyInfo.income_money}</b></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">到账操作人</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrInMoneyInfo.received_user_name}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">收款账户</div></td>
                                                <td><div class="ui_table_tdcntr"><dl class="bankInfo">
                                                        <dl><span>{$arrInMoneyInfo.bank_name}</span><span>{$arrInMoneyInfo.account_name}</span><span>{$arrMoneyInfo.account_no}</span></dl>
                                                    </dl></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">到账操作时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrInMoneyInfo.received_time}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">底单入款时间/操作人</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrInMoneyInfo.receivable_time}/{$arrMoneyInfo.receivable_user_name}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">入款备注</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrInMoneyInfo.received_remark}</div></td>
                                            </tr>
                                        </tbody>
                                   </table>   
                        	</div>                    
                    	</div>
                        
                </div>
            </div>
            <!--E form_bd--> 
        </div>