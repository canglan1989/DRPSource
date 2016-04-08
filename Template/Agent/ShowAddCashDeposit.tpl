<div class="DContInner">
        <form id="J_TiJiaoBaoZhengJinForm">
            <div class="bd">
                <div class="tf">
                    <!--<label>产品：</label>-->
                    <!--<div class="inp">{$arrProduct.product_type_name}</div>-->
                    <input type="hidden" id="pactId" name="pactId" value="{$pactId}" />
                    <input type="hidden" id="productId" name="productId" value="{$arrProduct.product_id}" />
                    <!--<input type="hidden" id="productId" name="productId" value="0" />-->
                    <input type="hidden" id="productNo" name="productNo" value="{$arrProduct.product_type_no}" />
                    <input type="hidden" id="productName" name="productName" value="{$arrProduct.product_type_name}" />
                    <!--<input type="hidden" id="productName" name="productName" value="" />-->
                    <input type="hidden" id="agentId" name="agentId" value="{$arrProduct.agent_id}" />
                </div>
                <div class="tf">
                    <label><em class="require">*</em>金额(￥)：</label>
                    <div class="inp"><input type="text" valid="required number" name="amount" class="amount" value="{$arrProduct.cash_deposit}"></div>
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
                    <span class="info" style="display:inline;">支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
                    <span class="ok">&nbsp;</span><span class="err">请上传打款底单</span>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>打款时间：</label>
                    <div class="inp"><input type="text" valid="required" onfocus="WdatePicker()" name="registeredTime" class="registeredTime inpDate"></div>
                    <span class="info"></span>
                    <span class="ok">&nbsp;</span><span class="err">请输入打款时间</span>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>支付方式：</label>
                    <div class="inp">
                        <select name="payment" id="J_payment">
                            <option selected="selected" value="8">银行汇款</option>
                            <option value="7">网银支付</option>
                            <option value="1">现金</option>
                            <option value="11">快钱</option>
                            <option value="15">其他</option>
                        </select>
                    </div>
                </div>              
                <div id="J_paymentResult">	                
                	<div class="tf" style="margin:0">
	                    <label><em class="require">*</em>打款账号：</label>
			</div>
	                <div class="tf" style="margin-left:20px;">
	                    <label>开户行：</label>
	                    <div class="inp"><input type="text" tabindex="1" valid="required" name="bankName"/></div>
	                    <span class="info">请输入开户行</span>
	                    <span class="ok">&nbsp;</span><span class="err">请输入开户行</span>
	                </div>
	                <div class="tf" style="margin-left:20px;">
	                    <label>开户名：</label>
	                    <div class="inp"><input type="text" tabindex="1" valid="required" name="AccountName"/></div>
	                    <span class="info">请输入开户名</span>
	                    <span class="ok">&nbsp;</span><span class="err">请输入开户名</span>
	                </div>
	                <div class="tf" style="margin-left:20px;">
	                    <label>帐 号：</label>
	                    <div class="inp"><input type="text" tabindex="1" valid="required" name="AccountNo"/></div>
	                    <span class="info">请输入帐号</span>
	                    <span class="ok">&nbsp;</span><span class="err">请输入帐号</span>
	                </div>
	                <div class="tf">
	                      <label><em class="require">*</em>收款账户：</label>
	                      <div class="inp">
	                      		<select id="payAccount" name="payAccount" valid="required payAccount">
			                      	<option value="-100">请选择</option>
			                        {foreach item=bank from=$arrayAccount}
			                        <option value="{$bank.ba_account_id}@{$bank.ba_account_name}@{$bank.ba_account_no}">{$bank.ba_account_name}&nbsp;&nbsp;&nbsp;&nbsp;{$bank.ba_account_no}</option>
			                        {/foreach}
		                      	</select>
	                      </div>
	                      <span class="info">请选择收款账户</span>
	                      <span class="ok">&nbsp;</span><span class="err">请选择收款账户</span>
	                </div>
                </div>
                <div class="tf">
                    <label>备注：</label>                            
                    <div class="inp"><textarea valid="businessPosition" id="direction" cols="40" name="direction"></textarea></div>
                    <span class="info">限制100字以内</span>
                    <span class="ok">&nbsp;</span><span class="err">限制100字以内</span>
                </div>
            </div>
            <div class="ft">
                <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
                <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">下一步</button></div> 
            </div>
        </form>
        </div> 