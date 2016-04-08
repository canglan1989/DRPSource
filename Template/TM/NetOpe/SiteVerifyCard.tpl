<div class="DContInner tableFormCont">
    <div class="bd">
        <div class="list_table_head">
            <div class="list_table_head_right">
                <div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 评审历史记录</h4>
                </div>
            </div>
        </div>
        <div class="list_table_main marginBottom10">
            <input id="order_id" value="{$order_id}" type="hidden"></input>
            <div class="ui_table" id="J_ui_table">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead class="ui_table_hd">
                        <tr class="">
                            <th style="width:70px"><div class="ui_table_thcntr"><div class="ui_table_thtext">序号</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">评审结果</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">评审备注</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
                    </tr>
                    </thead>
                    <tbody class="ui_table_bd">
                    {foreach from=$arrayData item=data key=index}
                        <tr class="">
                            <td><div class="ui_table_tdcntr">{$index}</div></td>
                            <td><div class="ui_table_tdcntr">{$data.verify_state}</div></td>
                            <td><div class="ui_table_tdcntr">{$data.verify_remark}</div></td>
                            <td><div class="ui_table_tdcntr">{$data.ope_name}</div></td>
                            <td><div class="ui_table_tdcntr">{$data.ope_time}</div></td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>   
            </div>
        </div>
        <div id="d_i_pass" class="tf">
	        <label>&nbsp;</label>
	        <div class="inp"><input name="i_pass" type="radio" value="1" onclick="change_pass(this)" checked="checked" class="checkInp"/> 通过</div>
	        <label style="width:40px;">&nbsp;</label>
	        <div class="inp"><input name="i_pass" type="radio" value="2" onclick="change_pass(this)" class="checkInp"/> 不通过</div>
    	</div>
    	<div id="d_un_pass_reason" style="display:none; margin-bottom:10px;" class="tf">
	        <label>不通过原因：</label>
	        <div class="inp">
	        	<input type="checkbox" name="chk_un_pass_reason" value="site"  class="checkInp"/> 网站制作问题&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		<input type="checkbox" name="chk_un_pass_reason" value="icp"  class="checkInp"/> ICP备案问题
    		</div>
    	</div>
	    <div class="tf">
	        <label>评审备注：</label>
	        <div class="inp"><textarea id="verify_remark" cols="50" rows="12"></textarea></div>
	    </div>
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide();">取消</a></div>
        <!--这块小马你改下
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="button" onclick="choose_un_pass_reason();">不通过</button></div>
        -->
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="button" onclick="verify();">确定</button></div>
    </div>
</div>
</div>