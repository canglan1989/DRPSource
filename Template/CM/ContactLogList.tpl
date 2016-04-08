{foreach from=$arrayData item=arr}
    <tr>
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{$arr.customer_id}</div></td>
        <td title=""><div class="ui_table_tdcntr"><a onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ','id={$arr.customer_id}','客户基本信息',700);" href="javascript:void(0)">{$arr.customer_name}</a></div></td>
        <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.create_uid});">{$arr.e_name}</a></div></td>
        <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" onclick="showConatctCard({$arr.contact_id})" >{$arr.contact_name}</a></div></td>                                   
        <td title=""><div class="ui_table_tdcntr">{if $arr.contact_mobile eq ''}
                                                                            {$arr.contact_tel}
                                                                        {elseif $arr.contact_tel eq ''}
                                                                            {$arr.contact_mobile}
                                                                        {else}
                                                                            {$arr.contact_mobile}/{$arr.contact_tel}
                                                                        {/if}
        
        
      </div></td>                                    
        <td title=""><div class="ui_table_tdcntr">{$arr.contact_time}</div></td>
        <td title="{$arr.contact_recode}" class="TA_l"><div class="ui_table_tdcntr">{$arr.contact_recode}</div></td> 
        <td title=""><div class="ui_table_tdcntr">
        {if $arr.intention_rating eq 0}A
        {elseif $arr.intention_rating eq 1}B
        {elseif $arr.intention_rating eq 2}C
        {elseif $arr.intention_rating eq 3}D
        {elseif $arr.intention_rating eq 4}E        
        {/if}
        </div></td>                                    
    </tr>
{/foreach}
<script language="javascript" type="text/javascript">
{literal}
function showConatctCard(contact_id){
         IM.dialog.show({
            width:500,
            height:null,
            title:'联系人信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showConatctCard&contact_id="+contact_id,""));
            }
         })
    }
{/literal}    
</script>   