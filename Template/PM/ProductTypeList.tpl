  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：系统管理<span>&gt;</span>产品管理<span>&gt;</span>产品类别列表</div>
    <!--S table_filter-->
   
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
        <a class="ui_button" style="margin:0" onclick="addProduct(0)" href="javascript:;" v="4" ispurview="true" m="ProductTypeList">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                <div class="ui_icon ui_icon_open"></div>
                <div class="ui_text">产品类别添加</div>
            </div>
        </a>
   </div>
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
<a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>  
    </div>
    </div>
    </div>
    <!--E list_table_head-->        
    <!--S list_table_main-->
    <div class="list_table_main">
    	<div id="J_ui_table" class="ui_table">
        	<table width="100%" cellspacing="0" cellpadding="0" border="0">
            	<thead class="ui_table_hd">
                	<tr>
                        <th width="200" title="所属分类">
                        	<div class="ui_table_thcntr" sort="sort_data_type">
                            	<div class="ui_table_thtext">所属分类</div>
                            </div>
                        </th>
                        <th width="200" title="类别编号">
                        	<div class="ui_table_thcntr" sort="sort_product_type_no">
                            	<div class="ui_table_thtext">类别编号</div>
                            </div>
                        </th>
                        <th width="220" title="产品类别名称">
                        	<div class="ui_table_thcntr" sort="sort_product_type_name">
                            	<div class="ui_table_thtext">产品类别名称</div>
                            </div>
                        </th>
                        <th title="备注">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">备注</div>
                            </div>
                        </th>
                        <th width="120" title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
               </thead>
               <tbody class="ui_table_bd" id="pageListContent">
               </tbody>
           </table>   
        </div>
        <!--E ui_table-->
    </div>
    <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
  </div> 
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$productTypeListBody}"; 
	{literal}
	pageList.init();
});
function addProduct(id){
        var _data = id;
        var title = "";
        if(parseInt(_data)>0)
            title = "类别编辑";
        else title = "类别添加";
        IM.dialog.show({
            width: 500,
    	    height: null,
    	    title: title,
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=PM&c=ProductType&a=ProductTypeModify&id="+id, {}, function (backData) {
    		    $('.DCont')[0].innerHTML = backData;
                new Reg.vf($('#J_newProductType'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                var formValues = $('#J_newProductType').serialize();
                //alert(formValues);
             $.ajax({
                    type: "POST",
                    dataType: "text", 
                    url: "/?d=PM&c=ProductType&a=ProductTypeModifySubmit&id="+id,
                    data: formValues,
                    success: function (q) {
                        q=MM.json(q);
                         if(q.success)
                    		{
              		            pageList.reflash();
				                IM.tip.show(q.msg);                                
                                IM.dialog.hide();
                                $GetProduct.ProductTypes = null;
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                            }    
                                        
                    }
                });
            }});
                });
          }
    });
    }
    </script>
{/literal}
