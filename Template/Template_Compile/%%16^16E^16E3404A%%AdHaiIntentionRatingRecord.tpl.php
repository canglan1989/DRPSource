<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:12
         compiled from CM/ContactRecord/AdHaiIntentionRatingRecord.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
    	<div class="table_filter_main_row">
            
            <div class="ui_title">客户名称：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="customer_name" style="vertical-align:top;"/>
            </div>
            
            <div class="ui_title">网盟意向等级：</div>
            <?php echo '
			<div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({\'control\':\'IntentionRating\',data:MM.A(this,\'data\')},this)" 
            '; ?>

             class="ui_comboBox ui_comboBox_def" key="<?php echo $this->_tpl_vars['rating_id']; ?>
" value="<?php echo $this->_tpl_vars['rating_text']; ?>
" control="IntentionRating" data="<?php echo $this->_tpl_vars['strIntentionRatingJson']; ?>
" style="width:240px;">
             <div class="ui_comboBox_text" style="width:220px;">
             <?php if ($this->_tpl_vars['rating_id'] != ""): ?>
             <nobr><?php echo $this->_tpl_vars['rating_text']; ?>
</nobr>
             <?php else: ?>
             <nobr>全部</nobr>
             <?php endif; ?>
             </div>
             <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>
                
            <div class="ui_title">添加人：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="create_user" value="<?php echo $this->_tpl_vars['user_name']; ?>
" style="vertical-align:top;"/>
            </div>
            
            <div class="ui_title">添加时间：</div>
            <div class="ui_text">
                 <input id="create_time_begin" type="text" class="inpCommon inpDate" name="create_time_begin" value="<?php echo $this->_tpl_vars['create_dateb']; ?>
" 
                 <?php echo '
                 onfocus="WdatePicker({onpicked:function(){($dp.$(\'create_time_end\')).focus()},maxDate:\'#F{$dp.$D(\\\'create_time_end\\\')}\'})"/> 至
    	         '; ?>

                 <input id="create_time_end" type="text" class="inpCommon inpDate" name="create_time_end" value="<?php echo $this->_tpl_vars['create_datee']; ?>
" 
                 <?php echo '
                 onfocus="WdatePicker({minDate:\'#F{$dp.$D(\\\'create_time_begin\\\')}\'})"/>
                 '; ?>

            </div>
        </div>
        <div class="table_filter_main_row">    
           <div class="ui_title">预计到账时间：</div>
            <div class="ui_text">
                 <input id="income_time_begin" type="text" class="inpCommon inpDate" name="income_time_begin" value="<?php echo $this->_tpl_vars['income_dateb']; ?>
" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'income_time_end\')).focus()},maxDate:\'#F{$dp.$D(\\\'income_time_end\\\')}\'}'; ?>
)"/> 至
    	         <input id="income_time_end" type="text" class="inpCommon inpDate" name="income_time_end" value="<?php echo $this->_tpl_vars['income_datee']; ?>
" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'income_time_begin\\\')}\'})"/>'; ?>

            </div>
           
           <div class="ui_title">联系类型：</div>
            <div class="ui_text">
                <select name="is_visit" >
                    <option value = "-1">全部</option>
                    <option value = "0">联系小记</option>
                    <option value = "1">拜访小记</option>
                </select>
            </div>
            <div class="ui_text">
            <label>
            <input class="checkInp" type="checkbox" style="vertical-align: middle;" value="1" name="chkLastIntention" id="chkLastIntention"/>
            最近一次意向
            </label>
            </div>
            <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>                   
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
                <tr>
            <th style="width:70px" title="客户ID">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户ID</div>
            </div>
            </th>
            <th style="" title="客户名称">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户名称</div>
            </div>
            </th>
            <th style="" title="联系类型">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系类型</div>
            </div>
            </th>
            <th style="width:250;" title="网盟意向等级">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">网盟意向等级</div>
            </div>
            </th>
            <th class="TA_r" style="width:100px;" title="预计到账金额">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">预计到账金额</div>
            </div>
            </th>

            <th style="width:150px;" title="预计到账时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">预计到账时间</div>
            </div>
            </th>

            <th style="width:150px;" title="添加人">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">添加人</div>
            </div>
            </th>
            <th style="width:150px;" title="添加时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">添加时间</div>
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
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['BodyUrl']; ?>
"; 
<?php echo '
	pageList.param = "&"+$(\'#tableFilterForm\').serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
	pageList.init();
});

function QueryData()
{
    pageList.param = \'&\'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.first();
} 
    

'; ?>

</script>