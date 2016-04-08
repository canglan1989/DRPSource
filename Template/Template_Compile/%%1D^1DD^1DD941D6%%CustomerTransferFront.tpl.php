<?php /* Smarty version 2.6.26, created on 2013-03-08 09:45:09
         compiled from CM/CustomerTransferFront.tpl */ ?>
 <!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
        <!--E crumbs-->   
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">    		
            	<div class="table_filter_main_row">
                    	<div class="ui_title">客户名称：</div>
                    <div class="ui_text"><input  type="text" name="customer_name" style="vertical-align:top;"/></div>
                    	<div class="ui_title">地区：</div>
					<div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" name="selProvince" class="pri" name="selProvince"></select></div>
					<div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="selCity" tabindex="3"></select></div>
                                        <div class="ui_comboBox"><select id="area_id" class="area" name="area_id"></select></div>
                    	<div class="ui_title">所属账号：</div>
						<div class="ui_text" style="margin-right:5px;">
							<input type="text" name="user_in_name">
						</div>
				</div>
                <div class="table_filter_main_row">
	                   <div class="ui_title">行业分类：</div>
					<div class="ui_comboBox" name = "industryId" id = "industryId">
                                            <select id="industry_pid" name="industry_pid"></select>
                                            <select id="industry_id" name="industry_id"></select>
					</div>
                        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="getSearch()">搜 索</button></div>	
                </div>
            </div>
            </form>
        </div>
        <!--E table_filter-->
        <!--S list_table_head-->
		<div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
                </div>
            </div>			           
        </div>
        <!--E list_table_head-->
        <!--S list_table_main-->
        <div class="list_table_main">
        	<div id="J_ui_table" class="ui_table">
                    	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                        	<thead class="ui_table_hd">
                            	<tr class="">
                                    <th style="" title="客户名称">
                                    	<div class="ui_table_thcntr" sort="sort_customer_name">
                                        	<div class="ui_table_thtext">客户名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:160px" title="行业">
                                    	<div class="ui_table_thcntr" sort="sort_industry_fullname">
                                        	<div class="ui_table_thtext">行业</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="" title="地区">
                                    	<div class="ui_table_thcntr" sort="sort_area_fullname">
                                        	<div class="ui_table_thtext">地区</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:130px;" title="转出帐号">
                                    	<div class="ui_table_thcntr" sort="sort_user_out_name">
                                        	<div class="ui_table_thtext">转出帐号</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:130px;" title="转入帐号">
                                    	<div class="ui_table_thcntr" sort="sort_user_in_name">
                                        	<div class="ui_table_thtext">转入帐号</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:130px;" title="转移时间">
                                    	<div class="ui_table_thcntr" sort="sort_create_time">
                                        	<div class="ui_table_thtext">转移时间</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:130px;" title="转移操作人">
                                    	<div class="ui_table_thcntr" sort="sort_user_name">
                                        	<div class="ui_table_thtext">转移操作人</div><div class="ui_table_thsort"></div>
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
  <script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
	<script type="text/javascript">
	<?php echo '
	$(function(){
        $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:true});
        $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
        '; ?>

    	pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
";
    	<?php echo '
    	pageList.param = "&"+$(\'#tableFilterForm\').serialize();
    	pageList.init();
	});
     function getSearch()
     {
    	pageList.param = \'&\'+$("#tableFilterForm").serialize();
    	pageList.first();
     }
    
 '; ?>

</script>