<div class="ui_table" id="J_ui_table">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <thead class="ui_table_hd">
        <tr class="">                                        
           <th style="width:125px;" title="操作人">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">操作人</div>
                </div>
            </th>
            <th style="width:100px;" title="被联系人">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">被联系人</div>
                </div>
            </th>
            <th style="width:200px;" title="手机固话">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">手机固话</div>
                </div>
            </th>
            <th style="width:130px;" title="联系时间">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">联系时间</div>
                </div>
            </th>
            <th title="联系记录">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">联系记录</div>
                </div>
            </th>
            <th style="width:100px;" title="产品">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">产品</div>
                </div>
            </th>
            <th style="width:80px;" title="等级">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">等级</div>
                </div>
            </th>
            <th style="width:80px;" title="类型">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">类型</div>
                </div>
            </th>
            <th style="width:80px;" title="意向评级">
                <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">意向评级</div>
                </div>
            </th>
       </tr>
   </thead>
   <tbody class="ui_table_bd">
        {foreach from=$arrContactRecord item=arrContactList}
        <tr class="">
            <td title="{$arrContactList.user_name}({$arrContactList.e_name})"><div class="ui_table_tdcntr">{$arrContactList.user_name}{if $arrContactList.e_name neq ''}({$arrContactList.e_name}){/if}</div></td>
            <td title="{$arrContactList.contact_name}"><div class="ui_table_tdcntr">{$arrContactList.contact_name}</div></td>
            <td title="{$arrContactList.mobile}({$arrContactList.tel})"><div class="ui_table_tdcntr">{$arrContactList.mobile}{if $arrContactList.tel neq ''}({$arrContactList.tel}){/if}</div></td>
            <td title="{$arrContactList.contact_time}"><div class="ui_table_tdcntr">{$arrContactList.contact_time}</div></td>
            <td title="{$arrContactList.remark}"><div class="ui_table_tdcntr">{$arrContactList.remark|truncate:"18":"..."}</div></td>
            <td title="{$arrContactList.product_type_name}"><div class="ui_table_tdcntr">{$arrContactList.product_type_name}</div></td>
            <td title="{if $arrContactList.agent_level eq ''}{elseif $arrContactList.agent_level eq 0}
无等级{elseif $arrContactList.agent_level eq 1}金牌{else}银牌{/if}">
            <div class="ui_table_tdcntr">
            {if $arrContactList.agent_level eq ''}
            {elseif $arrContactList.agent_level eq 0}
            无等级
            {elseif $arrContactList.agent_level eq 1}
            金牌
            {else}
            银牌
            {/if}
            </div></td>
            <td title="{if $arrContactList.contact_type eq ''}{elseif $arrContactList.contact_type eq 0}签约前
{elseif $arrContactList.contact_type eq 1}签约后{/if}"><div class="ui_table_tdcntr">
            {if $arrContactList.contact_type eq ''}
            {elseif $arrContactList.contact_type eq 0}
            签约前
            {elseif $arrContactList.contact_type eq 1}
            签约后
            {else}
            {/if}
            </div></td>
            <td title="{$arrContactList.leval}"><div class="ui_table_tdcntr">{$arrContactList.leval}</div></td>
        </tr>
        {/foreach}
    </tbody>
</table>   
</div>