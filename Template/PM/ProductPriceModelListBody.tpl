{foreach from=$arrProductPriceModelInfo item=data key=index}
    <tr>
        <td title="{$data.product_name}>{$data.product_series}"><div class="ui_table_tdcntr"><nobr>{$data.product_name}>{$data.product_series}</nobr></div></td>
        <td title="{$data.model_name}"><div class="ui_table_tdcntr"><nobr>{$data.model_name}</nobr></div></td>
        <td title="{if $data.model_type==0}代理模板{else}促销模板 {/if}"><div class="ui_table_tdcntr"><nobr>{if $data.model_type==0}代理模板{else}促销模板 {/if}</nobr></div></td>
        <td  class="TA_r" title="{$data.price_or_rate}"><div class="ui_table_tdcntr"><nobr>{$data.price_or_rate}</nobr></div></td>
        <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
        <td>
        	<div class="ui_table_tdcntr">
            	<nobr>
                <ul class="list_table_operation">
                    <li><a  m="ProductPriceModelList" v="4" ispurview="true" href="javascript:;" onclick="addProductPrice({$data.price_model_id})">编辑</a></li>
                    {if $data.cant_del == 1}
                    <li>删除</li>
                    {else}
                    <li><a href="javascript:;" onclick="IM.account.delOper('/?d=PM&c=ProductPriceModel&a=DelProductPriceModel&id={$data.price_model_id}',{literal}{{/literal}id:{$data.price_model_id}{literal}}{/literal},'删除产品价格模板',this)">删除</a></li>
                    {/if}
                </ul>
                </nobr>
            </div>
        </td>
    </tr>
{/foreach}