{foreach from=$arrProductPriceModelInfo item=data key=index}
    <tr>
        <td title="{$data.model_name}"><div class="ui_table_tdcntr">{$data.model_name}</div></td>
        <td title="{$data.model_remark}"><div class="ui_table_tdcntr">{$data.model_remark}</div></td>
        <td title="{$data.create_user_name}"><div class="ui_table_tdcntr">{$data.create_user_name}</div></td>
        <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
        <td>
        	<div class="ui_table_tdcntr">            	
                <ul class="list_table_operation">
                    <li><a href="javascript:;" onclick="JumpPage('/?d=PM&c=ProductPriceModel&a=UnitSaleRewardRateModelModify&id={$data.salereward_rate_model_id}')">编辑</a></li>
                    <li><a href="javascript:;" onclick="DelModel({$data.salereward_rate_model_id})">删除</a></li>
                </ul>
            </div>
        </td>
    </tr>
{/foreach}