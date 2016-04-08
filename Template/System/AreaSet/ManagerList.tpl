  <!--S crumbs-->
	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
    <!--E crumbs-->
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
    	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div id="J_table_filter_main" class="table_filter_main">
            <div class="table_filter_main_row">	
    			<div class="ui_title">账号名：</div>
                <div class="ui_text"><input class="inpCommon accountName" type="text" name="accountName" style="vertical-align:top;" maxlength="32"/></div>
                <div class="ui_title">地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="pri"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="city"></select></div>
                <div class="ui_comboBox"><select id="selArea" class="area" name="area"></select></div>	                
                <div class="ui_button ui_button_search">
                <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
                </div>
                <!--
                <div class="ui_button"><span class="ui_button_left"></span>
                <button type="button" class="ui_button_inner" onclick="$Reset('J_table_filter_main')">重 置</button>
                </div>
                -->				                	                
	       </div>
      </div>
        </form>
    </div>
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
        <a class="ui_button"onclick="accountGroup('')"  href="javascript:;" m="AreaManagerList" v="4" ispurview="true" style="color: rgb(204, 204, 255);">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                    <div class="ui_icon ui_icon_add"></div>
                    <div class="ui_text">账号区域组绑定</div>
                </div>
        </a>
        <a m="AreaManagerList" v="8" ispurview="true" onClick="IM.account.delOper('/?d=System&c=AreaSet&a=DelManagers',{literal}{}{/literal},'账号绑定删除')"  class="ui_button ui_button_dis" href="javascript:;" style="margin:0;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">批量删除</div></div></a>
    </div>
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
  <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
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
                    	<th style="width:30px" title="全选/反选">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">
									<input type="checkbox" class="checkInp" id="chkCheckAll" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');"/>
								</div>
                            </div>
                        </th>
                    	<th style="width:100px" title="账号">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">账号</div>
                            </div>
                        </th>
                       <th style="width:100px" style="" title="联系人">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">联系人</div>
                            </div>
                        </th>
                        <th style="width:120px" style="" title="联系电话">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">联系电话</div>
                            </div>
                        </th>
                        <th style="width:120px" style="" title="手机">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">手机</div>
                            </div>
                        </th>
                        <th style="" title="绑定区域">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">绑定区域组</div>
                            </div>
                        </th>
                        <th style="width:80px" title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
               </thead>
               <tbody class="ui_table_bd" id="pageListContent"></tbody>
           </table>   
        </div>
        <!--E ui_table-->
    </div>
    <!--E list_table_main-->           
    <!--S list_table_foot-->
  <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
  </div>
    <!--E list_table_foot-->
 <script type="text/javascript" src="{$JS}pageCommon.js"></script> 
 <script type="text/javascript">
 {literal}
 $(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
	{/literal}
	pageList.strUrl="{$groupListBody}"; 
	{literal}
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 function accountGroup(data) {
	(data == null || data == '') ? data = {} : data = data;
	MM.Extend(data, {
	    r: MM.Random(1000)
	});
    
	IM.dialog.show({
	    width: 550,
	    title: '账号区域组绑定',
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get('/?d=System&c=AreaSet&a=ManagerModify', data, function (modifyHtml) {
		    $('.DCont').html(modifyHtml);
            
		    $('#accountName').autocomplete('/?d=System&c=AreaSet&a=AutoUser', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
			max: 5, //只显示5行
			width: 150, //下拉列表的宽
			parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
			    /*
                {"value":[{"id":"100","name":"\u9a6c\u6b63\u6770"},
                {"id":"200","name":"\u9ebb\u5409"},{"id":"300","name":"Marshane"}]}
                */
			    var parsed = [];                            
			    if(backData == "" || backData.length == 0)
				return parsed;
                                
			    backData = MM.json(backData);
			    var value = backData.value;

			    if(value == undefined)
				    return parsed;
                                     
			    for (var i = 0; i < value.length; i++) {
				parsed[parsed.length] = {
				    data: value[i],
				    value: value[i].id,
				    result: value[i].name
				}
			    }

			    return parsed;
			},
			formatItem: function (item) {//内部方法生成列表
			    //_id=item.id;
			    return "<div id='divUser"+item.id+"' >" + item.name + '</div>';
			}
		    }).result(function (data,value) {//执行模糊匹配
                _id = value.id;
    			$('#tbxAccountID').val("-100");
    			var val = $(this).val();
    			if (val != '') 
    			{
    			    $('#tbxAccountID').val(_id);
    			}
		    });            
            
		    new Reg.vf($('#J_accountGroup'), {
			extValid: {}, 
			callback: function (postData) {
			    var groupIDs = "";
			    var chkGroups = document.getElementsByName("chkGroup");

			    for (var i = 0; i < chkGroups.length; i++) {
				if(chkGroups[i].checked)
				{
				    groupIDs += ","+chkGroups[i].value;
				}
			    }
			    if(groupIDs.length == 0)
			    {                    
    				IM.tip.warn("请选择区域！");
    				return;
			    }
			    else
			    {
				    groupIDs = groupIDs.substring(1);
			    }
                
			    postData = "&id="+$("#tbxID").val()+"&tbxAccountID="+$("#tbxAccountID").val()+"&groupIDs="+groupIDs;
			    MM.Extend(postData, {
				'r': MM.Random(1000)
			    });
			    MM.ajax({
				url: '/?d=System&c=AreaSet&a=ManagerModifySubmit',
				data: postData,
				success: function (q) {
					q=MM.json(q);					
					if(q.success){	
						IM.dialog.hide();			
						pageList.reflash();						
						IM.tip.show(q.msg||'划分成功');
					}else{
						IM.tip.warn(q.msg);
					}                                      
                    		}
			    })
			}
		    });
            
		});
	    }
	});
    }
 {/literal}
  </script> 