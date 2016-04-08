<div class="DContInner tableFormCont">
    <div class="bd">
        <div class="table_attention table_flow_attention">
            <span class="ui_link">提交人：{$arrDeptName.e_name}</span>
            <span class="ui_link">所属部门：{$arrDeptName.dept_fullname}</span>
            <span class="ui_link">提交时间：{$arrDeptName.create_time}</span>
        </div>
        <div class="list_table_main marginTop10">
            <div class="ui_table" id="J_ui_table">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">
                                <th style="width:70px"><div class="ui_table_thcntr"><div class="ui_table_thtext">审核步骤</div></div></th>
                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">所属部门</div></div></th>
                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">审核结果</div></div></th>
                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">审核时间</div></div></th>
                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">审核备注</div></div></th>
                            </tr>
                        </thead>
                        <tbody class="ui_table_bd">
                        	{foreach item=arrCheck from=$pactCheck key=key}
								<tr class="">
                                	<td><div class="ui_table_tdcntr">{$key+1}</div></td>
                                	<td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arrCheck.user_id});">{$arrCheck.e_name}</a></div></td>
                                    <td><div class="ui_table_tdcntr">{$arrCheck.dept_fullname}</div></td>
                                    <td><div class="ui_table_tdcntr">{if $arrCheck.check_status eq 1}审核通过{elseif $arrCheck.check_status eq 2}审核退回{else}未审核{/if}</div></td>
                                    <td><div class="ui_table_tdcntr">{$arrCheck.check_time}</div></td>
                                    <td><div class="ui_table_tdcntr">{$arrCheck.check_remark}</div></td>
                            	</tr>
                                {/foreach}
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
        <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">确定</a></div>
        </div>
        </div>                        
</div>                