 <!--S crumbs-->
    	<div class="crumbs marginBottom10"><s class="icon_crumbs"></s>当前位置：<a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showBackInfoList"}')">客户管理</a><span>&gt;</span>注册客户管理</div>
        <!--E crumbs-->   
        <div class="table_attention marginBottom10">
                <label>审核状态提醒：</label>
                <span class="ui_link"><a href="javascript:;">未转移：</a>(<em>{$notTransfer}</em>)</span>
		</div>
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">        	
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row">	                
                	<div class="ui_title">转移状态：</div>
                    <div class="ui_comboBox" name="transstat" id="transstat">
                        <select name="transstat" id="transstat">
                        <option selected="selected" value="-1">全部</option>
                        <option value="已转移">已转移</option>
                        <option value="未转移">未转移</option>
                        </select>
                    </div> 
	            	<div class="ui_title">客户名称：</div>
	           		<div class="ui_text"><input class="inpCommon" id="customer_name" name="customer_name" type="text"></div>
                        <div class="ui_title">意向产品：</div>
                    <!--获取 key 值 -->
                    {literal}
	                <div id="ui_comboBox_intentionPro" onclick="IM.comboBox.init({'control':MM.A(this,'control'),data:MM.A(this,'data')},this)" class="ui_comboBox ui_comboBox_def" control="intentionPro" key="" value="" data={/literal}'{$arrJsonType}'{literal} style="width:120px;">
                    {/literal}
                        <div class="ui_comboBox_text" style="width:100px;">
                        	<nobr>全部</nobr>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>                        
                    </div>                    
                    <div class="ui_title">录入/注册时间：</div>
	                <div class="ui_text" id="createTime">
                            {literal}
	                    <input id="J_editTimeS" class="inpCommon inpDate" name="create_time_begin" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})" type="text"> 至
	                    <input id="J_editTimeE" class="inpCommon inpDate" name="create_time_end" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})" type="text">	
                            {/literal}
                        </div>            
	            	<div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>             
               </div>                     
            </div>
            </form>
        </div>
        <!--E table_filter-->
        <div class="list_link marginBottom10">           
            <div m='showCustomerLoginInfoList' v="512" ispurview="true" class="ui_button" style="margin:0;" onClick="showTransfers()"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">客户转移</div></div></div>
        </div>
        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 注册客户列表</h4>
                </div>
            </div>			           
        </div>
        <!--E list_table_head-->        
        <!--S list_table_main-->       
        <div class="list_table_main">
        	<div id="J_ui_table" class="ui_table">                    	
              <table width="100%" cellspacing="0" cellpadding="0" border="0" >
                        	<thead class="ui_table_hd">
                            	<tr class="">
                                	<th style="width:30px" title="全选/反选">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">
												<input type="checkbox" class="checkInp" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');">
											</div>
                                        </div>
                                    </th>
                                	<th title="客户ID" style="width:80px;">
                                    	<div sort="sort_customer_id" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户ID</div>
                                        </div>
                                    </th>
                                   <th title="客户名称" style="">
                                    	<div sort="sort_customer_name" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">客户名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th title="行业" style="width:130px">
                                    	<div sort="sort_industry_fullname" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">行业</div>
                                        </div>
                                    </th>
                                   <th title="地区" style="">
                                    	<div sort="sort_area_fullname" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">地区</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th title="意向产品" >
                                    	<div sort="sort_area_fullname" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">意向产品</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th title="转移状态" style="width:80px;">
                                    	<div sort="sort_area_fullname" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">转移状态</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th title="所属代理商" style="width:100px">
                                    	<div sort="sort_agent_name" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">所属代理商</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th title="审核状态" style="width:70px;">
                                    	<div sort="sort_check_status_name" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核状态</div>
                                        </div>
                                    </th>
                                    <th title="注册时间" style="width:130px;">
                                    	<div sort="sort_create_time" class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">注册时间</div>
                                        </div>
                                    </th>
                               </tr>
                           </thead>
                           <tbody id="pageListContent" class="ui_table_bd">
                            </tbody>
                       </table>     
            </div>
            <!--E ui_table-->
        </div>
        <!--E list_table_main-->           
        <!--S list_table_foot-->
        <div class="list_table_foot">
            <div id="divPager" class="ui_pager"></div>
        </div>
        <!--E list_table_foot-->
            <script type="text/javascript" src="{$JS}pageCommon.js"></script>
	<script type="text/javascript">
	{literal}
	$(function(){
        $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:true});
        $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
        {/literal}
    	pageList.strUrl="{$strUrl}";
    	{literal}
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
	});
     function QueryData()
     {
             var inten_product = $.trim(MM.A(MM.G('ui_comboBox_intentionPro'),'key'));
             //console.log(MM.G('ui_comboBox_intentionPro'));
    	pageList.param = '&'+$("#tableFilterForm").serialize()+'&inten_product='+inten_product;
    	pageList.first();
     }
    function showTransfers()
    {
        var listid = IM.table.getListID();
        if(listid.length > 0)
        {               
             JumpPage('/?d=CM&c=CMLogin&a=showCustomerTransfer&customer_ids='+listid.join(","));     
        }
        else
        {
            IM.tip.warn('请选择要转移的客户');
        }
    }
	{/literal}
	</script>