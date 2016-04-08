<?php /* Smarty version 2.6.26, created on 2013-01-23 19:19:47
         compiled from System/AreaSet/AccountAreaList.tpl */ ?>
  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
    <!--S table_filter-->
<?php if ($this->_tpl_vars['strNote'] != ""): ?>
<div class="table_attention" style="margin:0 10px 10px;">
<span class="ui_link">账号不能在：“<?php echo $this->_tpl_vars['strNote']; ?>
”中重复绑定。</span>
</div>
<?php endif; ?>
   <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
                    <div class="table_filter_main_row">
                        <div class="ui_title" id="low1">账号组名称：</div>
                        <div class="ui_text" id="low2">
                        <input id="account_name" class="user_name" type="text" name="account_name" style="vertical-align:top;"/>
                        </div>                  
                        <div class="ui_title">账号组层级：</div>
                        <div class="ui_text">
                        <select id="level" name="level">
                                <option value="-100" selected="selected">请选择</option>
                                <option value="2" >1级</option>
                                <option value="4">2级</option>
                                <option value="6">3级</option>
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
        <a class="ui_button" style="margin:0" onclick="ModifyAccountGroup(0,0)" href="javascript:;" v="4" ispurview="true" m="AccountAreaList">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                <div class="ui_icon ui_icon_open"></div>
                <div class="ui_text">新增一级账号组</div>
            </div>
        </a>
   </div>
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
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
                    	<th width="100" title="账号组编号">
                        	<div class="ui_table_thcntr" sort="sort_account_no">
                            	<div class="ui_table_thtext">账号组编号</div>
                            </div>
                        </th>
                        <th  title="账号组名称">
                        	<div class="ui_table_thcntr" sort="sort_account_name">
                            	<div class="ui_table_thtext">账号组名称</div>
                            </div>
                        </th>
                        <th  title="绑定的账号">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">绑定的账号</div>
                            </div>
                        </th>
                        <th width="100" title="账号组层级">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">账号组层级</div>
                            </div>
                        </th>
                        <th width="210"  title="操作">
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
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
<?php echo ' 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['AccountAreaListBody']; ?>
"; 
	<?php echo '
    
	pageList.init();
});

function GetSupArray(id)//添加编辑账号组时，上级下拉列表
{
    var level = $("#cbAccountLevel").val();//获取选中项内容
    var cbSupAccount = $DOM("cbSupAccount");
    
    var supJson = $PostData("/?d=System&c=AccountArea&a=GetSupArray","level="+level+"&id="+id);
    //alert(supJson);
    var jsonObj = eval("(" + supJson + ")");
    //alert(jsonObj);
    var jsonObjLength = jsonObj.length;
    while(cbSupAccount.options.length > 0)
        cbSupAccount.options[0] = null;
    if(level == -100)
        cbSupAccount.options[0] = new Option("==请选择==", "-100");
           
    for (var cIndex = 0; cIndex < jsonObjLength; cIndex++) {            
        cbSupAccount.options[cbSupAccount.options.length] = new Option(jsonObj[cIndex].Name, jsonObj[cIndex].id);
    }   
    
}
function AreaBind(account_group_id,id)//account_group_user_id
{
    IM.dialog.show({
            width: 480,
    	    height: null,
    	    title: "绑定区域组",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=System&c=AccountArea&a=AccountAreaBind&id="+id+"&account_group_id="+account_group_id, {}, function (backData) {
    		    $(\'.DCont\')[0].innerHTML = backData;
                
                function v_isNull(e){return $.trim(e)!=\'\';}//
                new Reg.vf($(\'#J_accountAreaBind\'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                //====================
                var chkarea = document.getElementsByName("chkCheck");
            		var area = "";
            		for(var i = 0;i < chkarea.length;i++)
            		{
            			if(chkarea[i].checked)
                        {
            				area += "," + chkarea[i].value;
                            //alert(chkarea[i].value);
                        }
            		}
            		
            		if(area.length > 1)
            			area = area.substring(1, area.length);
                //===================
                var formValues = $(\'#J_accountAreaBind\').serialize();
            //alert(formValues);
             $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=System&c=AccountArea&a=AccountAreaBindSubmit&id="+id+"&area="+area,
                    data: formValues,
                    success: function (q) {
            			q=MM.json(q);
            			if(q.success){				
            				pageList.reflash();
            				IM.tip.show(q.msg);
                            IM.dialog.hide();
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
function ModifyAccountGroup(id,supid){//id-编辑时自己的账号组ID,supid-添加下级账号组时的上级账号组ID
        var _data = id;
        var title = "";
        if(parseInt(_data)>0)
            title = "账号组编辑";
        else title = "添加账号组";
        
        
        IM.dialog.show({
            width: 500,
    	    height: null,
    	    title: title,
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=System&c=AccountArea&a=AccountAreaModify&id="+id+"&supid="+supid, {}, function (backData) {
    		  
    		    $(\'.DCont\')[0].innerHTML = backData;
                
                new Reg.vf($(\'#J_newAccountAreaModify\'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                var formValues = $(\'#J_newAccountAreaModify\').serialize();
                //alert(formValues);
             $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "/?d=System&c=AccountArea&a=AccountAreaModifySubmit&id="+id+"&supid="+supid,
                    data: formValues,
                    success: function (q) {
                        q=MM.json(q);
                        
                         if(q.success)
                    		{
              		            pageList.reflash();
				                IM.tip.show(q.msg);
                                IM.dialog.hide();
                                //IM.dialog.hide();
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                                
                                //pageList.reflash();
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
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();//get 获取！      
	pageList.first();
}
    </script>
'; ?>