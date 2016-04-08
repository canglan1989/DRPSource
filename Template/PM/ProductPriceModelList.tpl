<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">产品：</div>
        <div class="ui_comboBox" style="margin-right:5px;">
          <select id="cbProductType" name="cbProductType" style="width:120px">
          </select>
        </div>
        <div class="ui_comboBox" style="margin-right:5px;">
          <select id="cbProduct" name="cbProduct" style="width:160px">
          </select>
        </div>
        <div class="ui_title"> 模板名称： </div>
        <div class="ui_text">
          <input class="inpCommon accountName" type="text" name="modelName" id="modelName" style="width:300px;"/>
        </div>
        <div class="ui_title">模板类型：</div>
        <div class="ui_text">
          <select name="modelType" id="modelType" style="width:100px;">
            <option value="-100">全部</option>
            <option value="0">代理价模板</option>
            <option value="1">促销价模板</option>
          </select>
        </div>
        <div class="ui_button ui_button_search">
          <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>
      </div>
    </div>
  </form>
</div>

<!--E table_filter--> 

<!--S list_link-->
<div class="list_link marginBottom10"> <a class="ui_button" style="margin:0" onclick="addProductPrice(0)" href="javascript:;" >
  <div class="ui_button_left"></div>
  <div class="ui_button_inner">
    <div class="ui_icon ui_icon_open"></div>
    <div class="ui_text">价格模板添加</div>
  </div>
  </a> </div>
<!--E list_link--> 
<!--S list_table_head-->
<div class="list_table_head">
  <div class="list_table_head_right">
    <div class="list_table_head_mid">
      <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
      <a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> </div>
  </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
  <div id="J_ui_table" class="ui_table">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <thead class="ui_table_hd">
        <tr>
          <th > <div class="ui_table_thcntr">
              <div class="ui_table_thtext">产品</div>
            </div>
          </th>
          <th > <div class="ui_table_thcntr">
              <div class="ui_table_thtext">模板名称</div>
            </div>
          </th>
          <th style="width:100px;" > <div class="ui_table_thcntr">
              <div class="ui_table_thtext">模板类型</div>
            </div>
          </th>
          <th style="width:100px;" class="TA_r"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">价格</div>
            </div>
          </th>
          <th style="width:140px;"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">添加时间</div>
            </div>
          </th>
          <th style="width:80px;"> <div class="ui_table_thcntr ">
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
  <div id="divPager" class="ui_pager"> </div>
</div>
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
{literal} 
<script language="javascript" type="text/javascript">
$(function(){
    $GetProduct.Init("cbProductType", "cbProduct", true,"",ProductGroups.ValueIncrease);
	{/literal}
	pageList.strUrl = "{$ProductPriceModelListBody}"; 
	{literal}
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
});

function QueryData()
{
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
}

function setModelName(obj)
{
    if(obj.value > 0 && $("#mbName").val() == "")
    {
        $("#mbName").val(obj.options[obj.selectedIndex].text);
    }
}

function addProductPrice(price_model_id){
        var title = "";
        if(parseInt(price_model_id)>0)
            title = "模板编辑";
        else title = "模板添加";
        IM.dialog.show({
            width: 540,
    	    height: null,
    	    title: title,
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=PM&c=ProductPriceModel&a=ProductPriceModelModify&id="+price_model_id, {}, function (backData) {
                $('.DCont').html(backData);
                IM.AmountHandler($('#mbPriceRate')[0]);                
                new Reg.vf($('#J_newProductpPriceModel'),{
			extValid:{
				cbProductID:function(){return (MM.getVal(MM.G('cbProductTypeID')).text!='请选择') && (MM.getVal(MM.G('cbProductID')).text!='请选择')}
			},callback:function(formdata){////formdata 表单提交数据 对象数组格式
               
               if(price_model_id>0)
                title="模板编辑";
               else
                title="模板添加";
                
             $.ajax({              
                    url: "/?d=PM&c=ProductPriceModel&a=ProductPriceModelModifySubmit&id="+price_model_id,
                    data:  $('#J_newProductpPriceModel').serialize(),
                    type: "POST",
                    success: function (data) {  
                         if(parseInt(data) != 0)
                    		{
                                IM.tip.warn(data);
                    			//_InDealWith = false;
                    		}
                    		else
                            {
				pageList.reflash(); 
				IM.tip.show(title+'成功');
                                IM.dialog.hide();
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