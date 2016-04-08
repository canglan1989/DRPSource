<?php /* Smarty version 2.6.26, created on 2013-01-11 15:33:23
         compiled from CM/TransferList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/TransferList.tpl', 2, false),)), $this); ?>
<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showBackInfoList'), $this);?>
')">客户管理</a><span>&gt;</span>客户资料转移记录</div>
        <!--E crumbs-->   
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">	
            	<div class="table_filter_main_row">  
                    <div class="ui_title">客户名称：</div>
                    <div class="ui_text"><input class="" type="text" name="customer_name" style="vertical-align:top;"/></div>
                    <div class="ui_title">地区：</div>
					<div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" name="selProvince" class="pri" name="selProvince"></select></div>
					<div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="selCity" tabindex="3"></select></div>
					<div class="ui_comboBox"><select id="area_id" class="area" name="area_id"></select></div>
                    <div class="ui_title">所属代理商：</div>
                    <div class="ui_text"><input type="text" class="" id = "agent_name" name="agent_name"/></div>
                    <div class="ui_title">所属帐号： </div>
                    <div class="ui_text"><input type="text" class="inpCommon inputer" id = "user_name" name="user_name"/></div>
                </div>
                <div class="table_filter_main_row">
                    <div class="ui_title">行业分类：</div>
					<div class="ui_comboBox" name = "industryId" id = "industryId">
						<select id="industry_pid" name="industry_pid"></select>
                        <select id="industry_id" name="industry_id"></select>
					</div>
					<div class="ui_title">客户ID：</div>
					<div class="ui_text"><input type="text" class="inpCommon idNum" id = "customer_no" name="customer_no"/></div>
                    <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>                             
              	</div>
            </div>
            </form>
        </div>
        <!--E list_link-->
        <!--S list_table_head-->
		<div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 客户资料转移列表</h4>
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
                                	<th style="width:80px;" title="客户ID">
                                    	<div class="ui_table_thcntr" sort="sort_customer_id">
                                        	<div class="ui_table_thtext">客户ID</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
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
                                    <th style="" title="意向产品">
                                    	<div class="ui_table_thcntr" sort="sort_product_name">
                                        	<div class="ui_table_thtext">意向产品</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:90px;" title="转出代理商">
                                    	<div class="ui_table_thcntr" sort="sort_ag_out_name">
                                        	<div class="ui_table_thtext">转出代理商</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="转出代理商帐号">
                                    	<div class="ui_table_thcntr" sort="sort_user_out_name">
                                        	<div class="ui_table_thtext">转出代理商帐号</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:100px;" title="转入代理商">
                                    	<div class="ui_table_thcntr" sort="sort_ag_in_name">
                                        	<div class="ui_table_thtext">转入代理商</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:115px;"  title="转入代理商帐号">
                                    	<div class="ui_table_thcntr" sort="sort_user_in_name">
                                        	<div class="ui_table_thtext">转入代理商帐号</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:110px"  title="转移操作人">
                                    	<div class="ui_table_thcntr" sort="sort_user_name">
                                        	<div class="ui_table_thtext">转移操作人</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="转移时间">
                                    	<div class="ui_table_thcntr" sort="sort_create_time">
                                        	<div class="ui_table_thtext">转移时间</div>
                                            <div class="ui_table_thsort"></div>
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
        <!--S list_table_foot-->
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
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
        pageList.sortField="create_time desc";
    	pageList.param = "&"+$(\'#tableFilterForm\').serialize()+"&strOrder=cm_move.create_time desc";
    	pageList.init();
	});
    function QueryData()
    {
    	pageList.param = "&"+$(\'#tableFilterForm\').serialize()+"&strOrder=cm_move.create_time desc";
    	pageList.first();
    }
	'; ?>

	</script>  