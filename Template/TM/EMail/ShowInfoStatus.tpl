<div class="DContInner">
    <form id="J_midifyInfoForm">
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>企业名称：</label>
                <div class="inp">{$data.0.customer_name}</div>
            </div>
            {foreach from=$data item=arr key=key}
                <div class="tf">
                    <label><em class="require">*</em>域名提供方：</label>
                    <div class="inp">
                        <select name="origin">
                            <option value="0">未指定
<!--                            <option value="1" {if $arr.website_provider eq '厂商提供'}selected{/if}>厂商提供</option>-->
                            <option value="2" {if $arr.website_provider eq '代理商提供'}selected{/if}>代理商提供</option>
                            <option value="3" {if $arr.website_provider eq '客户提供'}selected{/if}>客户提供</option>
                        </select>
                    </div>
                    <label style="width:70px">企业域名：</label>
                    <div class="inp"><input type="text" valid="required url" name="domain" value="{$arr.website_name}" class="url"></div>                    
                    <div class="inp">
                        <a style="margin:0 5px 0 0; float:left;" href="javascript:;" class="ui_button ui_link"  control="add"><div class="ui_icon ui_icon_add2">&nbsp;</div></a>
                        {if $key neq 0}
                            <a control="del" class="ui_button ui_link" href="javascript:;" style="margin: 0pt 5px 0pt 0pt; float:left;"><div class="ui_icon ui_icon_del2">&nbsp;</div></a>
                        {/if}                        
                    </div>
		    <span class="info">请输入企业域名</span>
                    <span class="ok">&nbsp;</span><span class="err">请正确输入企业域名</span>
                </div>
            {/foreach}
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
            <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div> 
        </div>
    </form>
</div>                

