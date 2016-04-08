<div class="ui_table" id="J_ui_table">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <thead class="ui_table_hd">
                                        <tr class="">                                        
                                           <th style="width:100px;" title="姓名">
                                                <div class="ui_table_thcntr ">
                                                    <div class="ui_table_thtext">姓名</div>
                                                </div>
                                            </th>
                                            <th style="width:80px;" title="职务">
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">职务</div>
                                                </div>
                                            </th>
                                            <th style="width:120px;" title="固定电话">
                                                <div class="ui_table_thcntr ">
                                                    <div class="ui_table_thtext">固定电话</div>
                                                </div>
                                            </th>
                                            <th style="width:120px;" title="手机号码">
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">手机号码</div>
                                                 </div>
                                            </th>
                                            <th style="width:120px;" title="传真号码">
                                                <div class="ui_table_thcntr ">
                                                    <div class="ui_table_thtext">传真号码</div>
                                                </div>
                                            </th>
                                            <th title="电子邮箱">
                                                <div class="ui_table_thcntr ">
                                                    <div class="ui_table_thtext">电子邮箱</div>
                                                </div>
                                            </th>
                                            <th title="备注">
                                                <div class="ui_table_thcntr ">
                                                    <div class="ui_table_thtext">备注</div>
                                                </div>
                                            </th>
                                            <th style="width:120px;" title="操作">
                                                <div class="ui_table_thcntr ">
                                                    <div class="ui_table_thtext">操作</div>
                                                </div>
                                            </th>
                                       </tr>
                                   </thead>
                                   <tbody class="ui_table_bd">
                                   {foreach from=$arrAllContacter item=Contacter}
                                        <tr class="">
                                            <td title="{$Contacter.contact_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onClick="IM.agent.getContactInfo({literal}{{/literal}'id':{$Contacter.aid}{literal}}{/literal})">{$Contacter.contact_name}</a></div></td>
                                            <td title="{$Contacter.position}"><div class="ui_table_tdcntr">{$Contacter.position}</div></td>
                                            <td title="{$Contacter.tel}"><div class="ui_table_tdcntr">{$Contacter.tel}</div></td>
                                            <td title="{$Contacter.mobile}"><div class="ui_table_tdcntr">{$Contacter.mobile} </div></td>
                                            <td title="{$Contacter.fax}"><div class="ui_table_tdcntr">{$Contacter.fax}</div></td>
                                            <td title="{$Contacter.email}"><div class="ui_table_tdcntr">{$Contacter.email}</div></td>
                                            <td title="{$Contacter.remark}"><div class="ui_table_tdcntr">{$Contacter.remark|truncate:"18":"..."}</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                                <ul class="list_table_operation">
                                                    <li><a onClick="IM.agent.editContactInfo('{au d='Agent' c='Agent' a='showEditContacter'}&id={$Contacter.aid}','编辑联系人信息',{$Contacter.agent_id})" href="javascript:;">编辑</a></li>
                                                    <li><a onclick="IM.account.delOper('{au d='Agent' c='Agent' a='DelContacter'}',{literal}{{/literal}'listid':{$Contacter.aid}{literal}}{/literal},'删除联系人',this)" href="javascript:;">删除</a></li>
                                                </ul>
                                            </div>
                                            </td>
                                        </tr>
                                       {/foreach}
                                    </tbody>
                               </table>   
                    </div>