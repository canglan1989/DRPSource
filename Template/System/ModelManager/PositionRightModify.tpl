<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs-->
  <div class="table_filter marginBottom10">
    <div class="table_filter_main" id="J_table_filter_main">
    <div class="table_filter_main_row">
      <div class="ui_title"> 根模块组：</div>
      <div class="ui_text">
        <select name="cbModelGroup" id="cbModelGroup" onchange="ChangeData(this)" style="width:150px;" >          
          {foreach from=$arryModelGroup item=data key=index}
          <option value="{$data.mgroup_no}" >{$data.mgroup_name}</option>          
          {/foreach}        
        </select>
      </div>  
    {foreach from=$arrayPosition item=data key=index}
      <div class="ui_title">职位名：</div>
      <div class="ui_text"> <a href="javascript:;" onclick="PageBack()">{$data.post_name}</a> </div>      
      <div class="ui_title">公司：</div>
      <div class="ui_text"> {$data.company_name}</div>
      <div class="ui_title">部门：</div>
      <div class="ui_text"> {$data.dept_name}</div>
      <div class="ui_title">行政级别：</div>
      <div class="ui_text"> {$data.level_name}</div>
      {/foreach}
    </div>
    </div>
  </div>
  <!--S list_link-->
  <div class="list_link marginBottom10">
    <a m="PositionRightList" v="4" ispurview="true" class="ui_button" onclick="return SubmitData()" href="javascript:;">
    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_dist"></div>
    <div class="ui_text">批量分配</div></div></a>
    <div m="PositionRightList" v="4" ispurview="true" class="ui_button ui_button_dis" style="margin:0;">
    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div>
    <div class="ui_text" onClick="return DelPostRight()">批量取消</div></div></div>    
  </div>
  <!--E list_link--> 
  <!--S list_table_head-->
  <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
<a href="javascript:;" onclick="ChangeData($DOM('cbModelGroup'))" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
    </div>
    </div>
    </div>
  <!--E list_table_head--> 
  <!--S list_table_main-->
  <div class="list_table_main">
    <div id="J_ui_table" class="ui_table">          
    </div>
    <!--E ui_table--> 
  </div>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    if("undefined" != typeof pageList)
	   pageList.strUrl = "";
});

function ChangeData(obj)
{
    {/literal}
    var formValues="modelGroup="+obj.value+"&id={$id}";      
    {literal}      
    var returnData = $PostData("/?d=System&c=Position&a=PositionRightModifyBody",formValues);
    $("#J_ui_table").html(returnData+""); 
}
ChangeData($("#cbModelGroup")[0]);//$("#cbModelGroup")[0]js格式改为表单格式


function CheckAll(obj)
{
    $("input[name='chkGroupCheck']").each(function() { 
        $(this).attr("checked", obj.checked);
        IM.table.selectSub(this.checked,this);
    }); 
}

function CheckRight(obj)
{
    var id = obj.id;
    id = id.replace("a_","");
    var chkObj = $DOM("chk_"+id);
    var tbxObj = $DOM("tbx_"+id);
    {/literal} 
    var url = '{au d="System" c="Position" a="PositionRightClick"}';
    var pData = "id={$id}&rightID="+chkObj.value+"&add="+(parseInt(tbxObj.value) == 0? true :false);
    {literal} 
    
    var retValue = $PostData(url,pData);
    if(parseInt(retValue) != 0)//开通失败
    {
        //alert(retValue);
		IM.tip.warn(retValue); 
    }
    else//添加或删除成功
    {
        if(parseInt(tbxObj.value) == 0)//原-未分配
        {
            tbxObj.value = "1";
            
            //chkObj.checked = true;
            $DOM("div_flag_"+id).children[0].innerHTML = "<span style='color:#028100'>已分配</span>";
            obj.innerHTML = "取消";
            IM.tip.show('分配成功'); 
        }
        else//原-分配
        {
            tbxObj.value = "0";
            //chkObj.checked = false;
            $DOM("div_flag_"+id).children[0].innerHTML = "<span style='color:#EE5F00;'>未分配</span>";
            obj.innerHTML = "分配";
            IM.tip.show('取消成功');             
        }
    }
}



//数据已提交，正在处理标识
var _InDealWith = false;
//批量添加
function SubmitData()
{
	if (_InDealWith) 
    {
//		alert("数据已提交，正在处理中！");
		IM.tip.show('数据已提交，正在处理中！');
		return false;
	}
    
    //提交数据
    var chkObj = document.getElementsByName("chkCheck");
    var tbxObj = document.getElementsByName("tbxIsCheck");
    var addRightIDs = "";
    
    for(var i=0;i<chkObj.length;i++)
    {
        if(chkObj[i].checked && parseInt(tbxObj[i].value) == 0)
        {
            addRightIDs += "," + chkObj[i].value;
        }
    }
    
    if(addRightIDs.length > 0)
        addRightIDs = addRightIDs.substring(1, addRightIDs.length);
    else
    {
		IM.tip.warn('请选择未分配的权限！');
        return ;
    }
        
    {/literal}
    var formValues = "id={$id}&addRightIDs="+addRightIDs;
    {literal}
    _InDealWith = true;
    var data = $PostData("/?d=System&c=Position&a=PositionRightSubmit",formValues);
    
	if(parseInt(data) != 0)
    {
		//alert(data);
		IM.tip.warn(data);
        _InDealWith = false;
    }
    else
    {
        _InDealWith = false;
        ChangeData($("#cbModelGroup")[0]);
        IM.tip.show("批量添加成功");  
    }
}

//批量删除
function DelPostRight()
{
	if (_InDealWith) 
    {
		//alert("数据已提交，正在处理中！");
		IM.tip.show("数据已提交，正在处理中！");
		return false;
	}
    
    //提交数据
    var chkObj = document.getElementsByName("chkCheck");
    var tbxObj = document.getElementsByName("tbxIsCheck");

    var delRightIDs = "";
    for(var i=0;i<chkObj.length;i++)
    {
        if(chkObj[i].checked && (parseInt(tbxObj[i].value) == 1))
        {
            delRightIDs += "," + chkObj[i].value;
        }
    }
    
    if(delRightIDs.length > 0)
        delRightIDs = delRightIDs.substring(1, delRightIDs.length);
    else
    {
		IM.tip.warn("请选择已分配的权限！");
        return ;
    }
    
    {/literal}
    var formValues = "id={$id}&delRightIDs="+delRightIDs;
    {literal}
    _InDealWith = true;
    
    var data = $PostData("/?d=System&c=Position&a=DelPostRight",formValues);
    
	if(parseInt(data) != 0)
    {
		//alert(data);
		IM.tip.show(data);
        _InDealWith = false;
    }
    else
    {
        _InDealWith = false;
        ChangeData($("#cbModelGroup")[0]);
        IM.tip.show("批量删除成功");
    }
        
}
</script> 
{/literal} 