  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：系统管理<span>&gt;</span>产品管理<span>&gt;</span>产品列表</div>
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                    <div class="table_filter_main_row">
                        <div class="ui_title" >产品名称：</div>
                        <div class="ui_text" >
                        <input id="p_name" class="user_name" type="text" name="p_name" style="vertical-align:top;"/>
                        </div>     
                        <div class="ui_title" id="low1">产品编号：</div>
                        <div class="ui_text" id="low2">
                        <input id="p_no" class="user_name" type="text" name="p_no" style="vertical-align:top;"/>
                        </div>  
                        <div class="ui_title" id="low1">产品类别：</div>
                        <div class="ui_text" id="low2">
                        <input id="type_name" class="user_name" type="text" name="type_name" style="vertical-align:top;"/>
                        </div> 
                        <div class="ui_title">赠品：</div>
                        <div class="ui_text">
                        <select id="cbIsGift" name="cbIsGift">
                        <option value="-100" selected="selected">请选择</option>
                        <option value="1">是</option>
                        <option value="0">否</option>
                        </select>
                        </div> 
                    <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="QueryData()">查询</button></div>
                    </div>
                </form>
            </div>
            </div>
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
        <a class="ui_button" style="margin:0" onclick="addProduct(0)" href="javascript:;" v="4" ispurview="true" m="ProductList">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                <div class="ui_icon ui_icon_open"></div>
                <div class="ui_text">产品添加</div>
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
                    	<th width="180" title="产品编号">
                        	<div class="ui_table_thcntr" sort="sort_product_no">
                            	<div class="ui_table_thtext">产品编号</div>
                            </div>
                        </th>
                        <th width="200" title="产品类别">
                        	<div class="ui_table_thcntr" sort="sort_convert(product_name using gb2312)">
                            	<div class="ui_table_thtext">产品类别</div>
                            </div>
                        </th>
                        <th width="220" title="产品名称">
                        	<div class="ui_table_thcntr" sort="sort_convert(product_series using gb2312)">
                            	<div class="ui_table_thtext">产品名称</div>
                            </div>
                        </th>
                        <th width="60" title="赠品">
                        	<div class="ui_table_thcntr" sort="sort_is_gift">
                            	<div class="ui_table_thtext">赠品</div>
                            </div>
                        </th>
                        <th title="备注">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">备注</div>
                            </div>
                        </th>
                        <th width="120"  title="操作">
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
    <!--E list_table_main-->  
    <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
  </div>         
    <!--S list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$ProductListBody}"; 
	{literal}
	pageList.init();
});
          
function addProduct(id){
        var _data = id;
        var title = "";
        if(parseInt(_data)>0)
            title = "产品编辑";
        else title = "产品添加";
        
        IM.dialog.show({
            width: 500,
    	    height: null,
    	    title: title,
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=PM&c=Product&a=ProductModify&id="+id, {}, function (backData) {
    		    $('.DCont')[0].innerHTML = backData;
                $GetProduct.BindProductType("cbProductType",false);
                var oldProductTypeID = parseInt($("#tbxOldProductTypeID").val());
               if(oldProductTypeID == 1) // 为磐邮
                    document.getElementById("tbxUserNumber").style.display='block';
               else 
                    document.getElementById("tbxUserNumber").style.display='none';
                if(oldProductTypeID > 0)
                    $("#cbProductType").val(oldProductTypeID);
                var divProductTypeText = $DOM("divProductTypeText");
                if(divProductTypeText != undefined && divProductTypeText != null)
                {
                    var cbProductType = $DOM("cbProductType");
                    $("#divProductTypeText").html(cbProductType.options[cbProductType.selectedIndex].text);
                }
                
                new Reg.vf($('#J_newProduct'),{
			     callback:function(formdata){////formdata 表单提交数据 对象数组格式
		                var cbProductType = $("#cbProductType")[0];//获取选中项内容
		                var cbProductTypeName =  cbProductType.options[cbProductType.selectedIndex].text;  
		                var formValues = $('#J_newProduct').serialize()+"&cbProductTypeName="+cbProductTypeName;
                        
		             	$.ajax({
		                    type: "POST",
		                    dataType: "text",
		                    url: "/?d=PM&c=Product&a=ProductModifySubmit&id="+id,
		                    data: formValues,
                            success: function (q) {
                			q=MM.json(q);
                			if(q.success){			
                				IM.tip.show(q.msg);
                			     IM.dialog.hide();	
                				pageList.reflash();
                                 $GetProduct.CashData = null;
                                
                			}else{
                				IM.tip.warn(q.msg);
                			}  
                            
                                                  
		                    }
		                });	              
		            }});
                
                });
          }
    });
    }
  function QueryData()
{
    pageList.page = 1;
	pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！      
	pageList.first();
}              
  
  function selectProduct()
  {
        var cbProductType = $("#cbProductType").val();//获取选中项内容
        if(cbProductType == 1)
            document.getElementById("tbxUserNumber").style.display='block';
        else document.getElementById("tbxUserNumber").style.display='none';
  }             
    </script>
{/literal}