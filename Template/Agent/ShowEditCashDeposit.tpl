	<div class="DContInner">
                <form id="J_TiJiaoBaoZhengJinForm">
                	<div class="bd">
                    	<div style="float:left; width:59%">
                        <div class="table_attention marginBottom10"><label>您的保证金被退回，请重新核对并提交</label></div>
                        <!--<div class="tf">
                        	<label>产品：</label>
                            <div class="inp">{$arrCashDeposit.product_type_name}</div>
                        </div>-->
                        <input type="hidden" id="fr_id" name="fr_id" value="{$arrCashDeposit.fr_id}" />
                        <input type="hidden" id="pactId" name="pactId" value="{$pactId}" />
                        <input type="hidden" id="productId" name="productId" value="{$arrProduct.product_id}" />
                        <!--<input type="hidden" id="productId" name="productId" value="0" />-->
                        <input type="hidden" id="productNo" name="productNo" value="{$arrProduct.product_type_no}" />
                        <input type="hidden" id="productName" name="productName" value="{$arrProduct.product_type_name}" />
                        <!--<input type="hidden" id="productName" name="productName" value="" />-->
                        <input type="hidden" id="agentId" name="agentId" value="{$arrProduct.agent_id}" />
                        <div class="tf">
                        	<label><em class="require">*</em>金额(￥)：</label>
                            <div class="inp"><input type="text" valid="required number" name="amount" class="amount" value="{$arrCashDeposit.fr_rev_money}"></div>
                            <span class="info">请输入金额</span>
                            <span class="ok">&nbsp;</span><span class="err">请正确输入金额</span>
                        </div>
                        <div class="tf">
                        	<label>打款底单：</label>
                            <div class="inp qua_upload">
                            	<div class="fileBtn">
                                	<input width="50px;" type="file" size="8" name="qualifications" id="J_upload1">
                                    <input type="hidden" id="permitJ_upload1" name="permitJ_upload1"/>
                                </div>			
                                <div style="display:none" class="img" id="J_uploadImg"></div>					
                            </div>
                            <span class="info" style="display:inline;">支持的可是为JGP、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>打款时间：</label>
				<div class="inp"><input type="text" valid="required" onfocus="WdatePicker()" name="registeredTime" class="registeredTime inpDate" value="{$fr_peer_date}"></div>
				<span class="info"></span>
				<span class="ok">&nbsp;</span><span class="err">请输入打款时间</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>支付方式：</label>
                            <div class="inp">
                                <select name="payment" id="J_payment">
                                    <option {if $arrCashDeposit.fr_payment_id eq 8} selected="selected" {/if} value="8">银行汇款</option>
                                    <option {if $arrCashDeposit.fr_payment_id eq 7} selected="selected" {/if} value="7">网银支付</option>
                                    <option {if $arrCashDeposit.fr_payment_id eq 1} selected="selected" {/if} value="1">现金</option>
                                    <option {if $arrCashDeposit.fr_payment_id eq 11} selected="selected" {/if} value="11">快钱</option>
                                    <option {if $arrCashDeposit.fr_payment_id eq 15} selected="selected" {/if} value="15">其他</option>
                        		</select>
                            </div>
                        </div>                        
                        <div id="J_paymentResult">
                        {if $arrCashDeposit.fr_payment_id eq 11}
                        <div class="tf">
                          <label><em class="require">*</em>交易号：</label>
                          <div class="inp"><input type="text"  valid="required" name="trans_code" value="{$arrCashDeposit.fr_rp_num}"/></div>
                          <span class="info">请输入交易号</span>                                                            
                          <span class="err">请输入交易号</span>                                                              
                   	</div>                                                                                              
                        <div class="tf">                                                                                     
                              <label><em class="require">*</em>打款账户名称：</label>                                                
                              <div class="inp"><input type="text"  valid="required" name="payAccountName" value="{$arrCashDeposit.fr_peer_bank_name}"/></div> 
                              <span class="info">如果为签约代理商对公账户支付，请完整填写代理商企业名称，如果非签约代理商对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写签约代理商的企业名称。</span>                                                               
                              <span class="err">如果为签约代理商对公账户支付，请完整填写代理商企业名称，如果非签约代理商对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写签约代理商的企业名称。</span>                                                                 
                        </div>
                        {elseif $arrCashDeposit.fr_payment_id eq 7 || $arrCashDeposit.fr_payment_id eq 8 || $arrCashDeposit.fr_payment_id eq 15}
			<div class="tf" style="margin:0">
			<label><em class="require">*</em>打款账号：</label>
			</div>
			<div class="tf" style="margin-left:20px;">
				<label>开户行：</label>
				<div class="inp"><input type="text"  valid="required" name="bankName" value="{$arrCashDeposit.bank_name}"/></div>
				<span class="info">请输入开户行</span>
				<span class="ok">&nbsp;</span><span class="err">请输入开户行</span>
			</div>
			<div class="tf" style="margin-left:20px;">
				<label>开户名：</label>
				<div class="inp"><input type="text"  valid="required" name="AccountName" value="{$arrCashDeposit.account_name}"/></div>
				<span class="info">请输入开户名</span>
				<span class="ok">&nbsp;</span><span class="err">请输入开户名</span>
			</div>
			<div class="tf" style="margin-left:20px;">
				<label>帐 号：</label>
				<div class="inp"><input type="text"  valid="required" name="AccountNo" value="{$arrCashDeposit.account_no}"/></div>
				<span class="info">请输入帐号</span>
				<span class="ok">&nbsp;</span><span class="err">请输入帐号</span>
			</div>                        
			<div class="tf">
				<label><em class="require">*</em>收款账户：</label>
				<div class="inp">
					<select id="payAccount" name="payAccount" valid="required payAccount">
				              	<option value="-100">请选择</option>
				                {foreach item=bank from=$arrayAccount}
				                <option {if $bank.ba_account_id eq $arrCashDeposit.fr_bank_id} selected="selected" {/if} value="{$bank.ba_account_id}@{$bank.ba_account_name}@{$bank.ba_account_no}">{$bank.ba_account_name}&nbsp;&nbsp;&nbsp;&nbsp;{$bank.ba_account_no}</option>
				                {/foreach}
				      	</select>
				</div>
				<span class="info">请选择收款账户</span>
				<span class="ok">&nbsp;</span><span class="err">请选择收款账户</span>
			</div>
                        {/if}
                        </div>                        
                        </div>
                        <div style="float:right; width:40%;">
                        	<div class="table_attention marginBottom10"><label>原信息</label></div>
                        	<!--<div class="tf">
                                <label>产品：</label>
                                <div class="inp">{$arrCashDeposit.product_type_name}</div>
                            </div> -->                       
                            <div class="tf">
                                <label><em class="require">*</em>金额：</label>
                                <div class="inp">￥{$arrCashDeposit.fr_rev_money}</div>
                            </div>
                            <div class="tf">
                                <label>打款底单：</label>
                                <div class="inp"><a href="{$arrCashDeposit.fr_rp_files}" target="_blank">{$arrCashDeposit.fr_rp_files}</a></div>
                            </div>
                            <div class="tf">
                                <label><em class="require">*</em>打款时间：</label>
                                <div class="inp">{$fr_peer_date}</div>
                            </div>
                            <div class="tf">
                                <label><em class="require">*</em>支付方式：</label>
                                <div class="inp">
                                {if $arrCashDeposit.fr_payment_id eq 1}
                                现金
                                {elseif $arrCashDeposit.fr_payment_id eq 7}
                                网银支付
                                {elseif $arrCashDeposit.fr_payment_id eq 8}
                                银行汇款
                                {elseif $arrCashDeposit.fr_payment_id eq 11}
                                快钱
                                {elseif $arrCashDeposit.fr_payment_id eq 15}
                                其他
                                {/if}
                                </div>
                            </div>
                            {if $arrCashDeposit.fr_payment_id eq 11}
                            <div class="tf">
                                <label><em class="require">*</em>交易号：</label>
                                <div class="inp">{$arrCashDeposit.fr_rp_num}</div>
                            </div>
                            <div class="tf">
                                <label><em class="require">*</em>打款账户名称：</label>
                                <div class="inp">{$arrCashDeposit.fr_peer_bank_name}</div>
                            </div>
                            {else}
                            <div class="tf">
                                <label><em class="require">*</em>支付银行：</label>
                                <div class="inp">{$arrCashDeposit.bank_name}</div>
                            </div>
                            <div class="tf">
                                <label><em class="require">*</em>打款账号：</label>
                                <div class="inp">{$arrCashDeposit.account_no}</div>
                            </div>
                            <div class="tf">
                                <label><em class="require">*</em>打款账户：</label>
                                <div class="inp">{$arrCashDeposit.account_name}</div>
                            </div>
                            <div class="tf">
                                <label><em class="require">*</em>收款账号：</label>
                                <div class="inp">{$arrCashDeposit.ba_account_name}{$arrCashDeposit.ba_account_no}</div>
                            </div>
                            {/if}
                        </div>
                    </div>
                    <div class="ft">
                        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">下一步</button></div> 
                    </div>
                </form>
	</div>                
                
                        