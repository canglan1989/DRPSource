<div class="DContInner">
<form id="J_newLXXiaoJi" class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="">
<div class="bd">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <thead class="ui_table_hd">
                                        	<tr>
                                            	<th width="50" title="编号">
                                                	<div class="ui_table_thcntr" >
                                                    	<div class="ui_table_thtext">编号</div>
                                                    </div>
                                                </th>
                                                <th width="" title="审查人">
                                                	<div class="ui_table_thcntr">
                                                    	<div class="ui_table_thtext">审查人</div>
                                                    </div>
                                                </th>
                                                <th width="" title="审查时间">
                                                	<div class="ui_table_thcntr">
                                                    	<div class="ui_table_thtext">审查时间</div>
                                                    </div>
                                                </th>
                                                <th width="" title="审查结果">
                                                	<div class="ui_table_thcntr">
                                                    	<div class="ui_table_thtext">审查结果</div>
                                                    </div>
                                                </th>
                                                <th width="" title="审查备注">
                                                	<div class="ui_table_thcntr">
                                                    	<div class="ui_table_thtext">审查备注</div>
                                                    </div>
                                                </th>
                                                </tr>
                                       </thead>
                                       <tbody class="ui_table_bd">
                                       
                                       {foreach from=$arrayCheckDetial item=data key=index}
                                            <tr class="">
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$data.id}</div>
                                                </div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$data.e_name} </div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$data.check_time} </div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{if $data.check_statu == 1}审查通过{else}审查未通过{/if} </div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$data.detial} </div></div></td>                                                
                                            </tr>
                                       {/foreach}
                                        </tbody>
                                   </table>   
                        </div>
<div class="ft"><div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div></div>
</form> 
</div>