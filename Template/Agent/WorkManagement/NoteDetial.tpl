               
<div class="bd">					
<div class="list_table_main">
                        <div class="ui_table ui_table_nohead">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">编号</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.visitnoteid}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">制定人</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.e_name}</div></td>
                                                
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">预约制定时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.app_create_time}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">小记制定时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.create_time}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.agent_name}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">拜访主题</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.title}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">需求支持</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.support}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">预约时的意向评级/签约产品</div></td>
                                                <td><div class="ui_table_tdcntr">{if $arrayData.0.be_product_name != ""}{$arrayData.0.be_product_name}{else}{$arrayData.0.be_inten_level}{/if}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">拜访后的意向评级/签约产品</div></td>
                                                <td><div class="ui_table_tdcntr">{if $arrayData.0.product_name !=""}{$arrayData.0.product_name}{else}{$arrayData.0.afterlevel}{/if}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">被访人</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.visitor}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">联系电话</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.mobile}/{$arrayData.0.tel}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">预约时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.sappoint_time}/{$arrayData.0.eappoint_time}</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">拜访时间</div></td>
                                                <td><div class="ui_table_tdcntr">{$arrayData.0.visit_timestart}/{$arrayData.0.visit_timeend}</div></td>
                                                <td class="even"><div class="ui_table_tdcntr"></div></td>
                                                <td><div class="ui_table_tdcntr"></div></td>
                                                
                                            </tr>
                                        </tbody>
                                   </table>   
                        </div>
                    </div></div>