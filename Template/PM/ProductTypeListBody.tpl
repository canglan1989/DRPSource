{foreach from=$arrProductTypeInfo item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td  title="{$data.product_group_text}"><div class="ui_table_tdcntr">{$data.product_group_text}</div></td>
	<td  title="{$data.product_type_no}"><div class="ui_table_tdcntr">{$data.product_type_no}</div></td>
	<td  title="{$data.product_type_name}"><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
	<td title="{$data.type_remark}"><div class="ui_table_tdcntr"><nobr>{$data.type_remark}</nobr></div></td>
	<td title="">
		<div class="ui_table_tdcntr">
			<nobr>
			<ul class="list_table_operation">
				<li><a m="ProductTypeList" v="4" ispurview="true" href="javascript:;" 
				onclick="addProduct({$data.aid})">编辑</a></li>
				
				<li><a m="ProductTypeList" v="8" ispurview="true" href="javascript:;" 
                onclick="IM.account.delOper('/?d=PM&c=ProductType&a=DelProductType&id={$data.aid}',{literal}{{/literal}id:{$data.aid}{literal}}{/literal},'删除产品类别',this)">删除</a></li>
			
			</ul>
			</nobr>
		</div>
	</td>
</tr>
{/foreach}