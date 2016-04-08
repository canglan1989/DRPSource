<?php /* Smarty version 2.6.26, created on 2012-11-16 16:14:44
         compiled from System/ModelManager/UserRightModify.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'System/ModelManager/UserRightModify.tpl', 99, false),)), $this); ?>
<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：用户管理<span>&gt;</span><a href="javascript:;" onclick="PageBack()" >用户列表</a><span>&gt;</span><?php echo $this->_tpl_vars['strTitle']; ?>
</div>
  <!--E crumbs-->
  <div class="table_filter marginBottom10">
<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
<div id="J_table_filter_main" class="table_filter_main">      
<div class="table_filter_main_row">  
    <div class="ui_title"> &nbsp;&nbsp;&nbsp;&nbsp;根模块组： </div>
    <div class="ui_text">
    <select name="cbModelGroup" id="cbModelGroup" onchange="ChangeData(this)" style="width:150px;" >          
      <?php $_from = $this->_tpl_vars['arryModelGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
      <option value="<?php echo $this->_tpl_vars['data']['mgroup_no']; ?>
" ><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</option>          
      <?php endforeach; endif; unset($_from); ?>        
    </select>
    </div>
    <?php $_from = $this->_tpl_vars['arrayUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
      <div class="ui_title">用户名：</div>
      <div class="ui_text"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</div>
      <div class="ui_title"> 工号： </div>
      <div class="ui_text"><?php echo $this->_tpl_vars['data']['e_workno']; ?>
</div>
      <div class="ui_title"> 员工名： </div>
      <div class="ui_text"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</div>
      <div class="ui_title"> 部门： </div>
      <div class="ui_text"><?php echo $this->_tpl_vars['data']['dept_fullname']; ?>
</div>
      <div class="ui_title"> 职位： </div>
      <div class="ui_text"><?php echo $this->_tpl_vars['data']['post_name']; ?>
</div>
      <?php endforeach; endif; unset($_from); ?>
    </div>
  </div>
</form>
  </div>
  <!--S list_link-->
<div class="list_link marginBottom10">
<a class="ui_button" m="UserRightList" v="4" ispurview="true" href="javascript:;" onclick="return AddUserRight()">
<div class="ui_button_left"></div>
<div class="ui_button_inner">
<div class="ui_icon ui_icon_add"></div>
<div class="ui_text">批量分配</div>
</div>
</a>
<div class="ui_button ui_button_dis" style="margin:0;" ispurview="true" v="8" m="AreaManagerList">
<div class="ui_button_left"></div>
<div class="ui_button_inner">
<div class="ui_icon ui_icon_del"></div>
<div class="ui_text" m="UserRightList" v="4" ispurview="true" href="javascript:;" onclick="return DelUserRight()">批量取消</div>
</div>
</div>
</div>
  <!--E list_link--> 
  <!--S list_table_head--> 
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>        
	<a href="javascript:;" onclick="ChangeData($DOM('cbModelGroup'))" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
</div>
</div>
</div>
  <!--E list_table_head--> 
  <!--S list_table_main-->
  <div class="list_table_main" >
    <div id="J_ui_table" class="ui_table">      
    </div>
    <!--E ui_table--> 
  </div>
<?php echo ' 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    if("undefined" != typeof pageList)
	   pageList.strUrl = "";
});
function ChangeData(obj)
{    
    '; ?>
   
    var formValues="modelGroup="+obj.value+"&id=<?php echo $this->_tpl_vars['id']; ?>
";  
    <?php echo '
    var returnData = $PostData("/?d=System&c=User&a=UserRightListBody",formValues);    
    $("#J_ui_table").html(returnData+"");
       
}
ChangeData($("#cbModelGroup")[0]);

function CheckAll(obj)
{
    $("input[name=\'chkGroupCheck\']").each(function() { 
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
    '; ?>
 
    var url = '<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'User','a' => 'UserRightClick'), $this);?>
';
    var pData = "id=<?php echo $this->_tpl_vars['id']; ?>
&rightID="+chkObj.value+"&add="+(parseInt(tbxObj.value) == 0? true :false);
    <?php echo ' 
    
    var retValue = $PostData(url,pData);
    
    if(parseInt(retValue) != 0)
    {
		IM.tip.warn(retValue); 
    }
    else
    {
        if(parseInt(tbxObj.value) == 0)
        {
            tbxObj.value = "1";
            $DOM("div_flag_"+id).children[0].innerHTML = "<span style=\'color:#028100\'>已分配</span>";
            obj.innerHTML = "取消";
            IM.tip.show(\'分配成功\'); 
        }
        else
        {
            tbxObj.value = "0";
            $DOM("div_flag_"+id).children[0].innerHTML = "<span style=\'color:#EE5F00;\'>未分配</span>";
            obj.innerHTML = "分配";
            IM.tip.show(\'取消成功\');           
        }
    }
}



//数据已提交，正在处理标识
var _InDealWith = false;
//批量添加
function AddUserRight()
{
	if (_InDealWith) 
    {
		IM.tip.show("数据已提交，正在处理中！");  
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
		IM.tip.warn("请选择未分配的权限！");  
        return ;
    }
        
    '; ?>

    var formValues = "id=<?php echo $this->_tpl_vars['id']; ?>
&addRightIDs="+addRightIDs;
    <?php echo '
    _InDealWith = true;
    var data = $PostData("/?d=System&c=User&a=AddUserRight",formValues);
    
	if(parseInt(data) != 0)
    {
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
function DelUserRight()
{
	if (_InDealWith) 
    {
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
    
    '; ?>

    var formValues = "id=<?php echo $this->_tpl_vars['id']; ?>
&delRightIDs="+delRightIDs;
    <?php echo '
    _InDealWith = true;
    
    var data = $PostData("/?d=System&c=User&a=DelUserRight",formValues);
    
	if(parseInt(data) != 0)
    {
		IM.tip.warn(data);  
        _InDealWith = false;
    }
    else
    {
        _InDealWith = false;
       ChangeData($("#cbModelGroup")[0]);
       IM.tip.show("批量删除成功");
    }
}
    '; ?>

</script> 