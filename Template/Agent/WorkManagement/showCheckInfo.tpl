<div class="bd">					
<div class="list_table_main">
                        <div class="ui_table ui_table_nohead">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">编号</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.visitnoteid}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">制定人</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.e_name} </div>
                                                </div></td>                                                
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">预约制定时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.app_create_time}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">小记制定时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.create_time}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.agent_name}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">拜访主题</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.title}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">需求支持</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.support}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">预约时的意向评级/签约产品</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{if $arrayData.0.be_product_name != ""}{$arrayData.0.be_product_name}{else}{$arrayData.0.be_inten_level}{/if}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">拜访后的意向评级/签约产品</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{if $arrayData.0.product_name != ""}{$arrayData.0.product_name}{else}{$arrayData.0.afterlevel}{/if}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">被访人</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.visitor}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">联系电话</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.mobile}/{$arrayData.0.tel}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">预约时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.sappoint_time}/{$arrayData.0.eappoint_time}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">拜访时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.visit_timestart}/{$arrayData.0.visit_timeend}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">审核人</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.check_name}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">审查状态</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                                                {if $arrayData.0.check_status == 1}审查通过{/if}{if $arrayData.0.check_status == 2}审查不通过{/if}
                                                </a></div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">审查时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.check_time}</div>
                                                </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">审查信息</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">{$arrayData.0.check_remark}</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr"></div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"></div>
                                                </div></td>
                                            </tr>
                                        </tbody>
                                   </table>   
                        </div>
                    </div></div>