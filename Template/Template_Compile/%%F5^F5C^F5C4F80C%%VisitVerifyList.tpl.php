<?php /* Smarty version 2.6.26, created on 2013-01-29 10:02:21
         compiled from Agent/WorkManagement/VisitVerifyList.tpl */ ?>
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--S table_filter-->

<div class="table_filter marginBottom10">  
    <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text">
                    <input id="agent_name"  name="agent_name" type="text" style="width:200px;"/>
                </div>            
                <div class="ui_title">质检状态：</div>
                <div class="ui_text">
                    <select name="vertify_status">
                        <option value="0" >全部</option>
                        <option value="1" >未质检</option>
                        <option value="2" >通过</option>
                        <option value="3" >不通过</option>
                    </select>
                </div>
                <div class="ui_title">&nbsp;</div>
                <div class="ui_text">
                    <input name="hasPect" type="checkbox" value="1" id="hasPect" />签约代理商
                </div>
                <span id="IntentionRatingDiv">
                    <div class="ui_title">网盟意向等级：</div>
                    <?php echo '
                        <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({\'control\':\'IntentionRating\',data:MM.A(this,\'data\')},this)" 
                        '; ?>

                        class="ui_comboBox ui_comboBox_def" key="<?php echo $this->_tpl_vars['rating_id']; ?>
" value="<?php echo $this->_tpl_vars['rating_text']; ?>
" control="IntentionRating" data="<?php echo $this->_tpl_vars['strIntentionRatingJson']; ?>
" style="width:100px;">
                        <div class="ui_comboBox_text" style="width:80px;">
                            <?php if ($this->_tpl_vars['rating_id'] != ""): ?>
                                <nobr><?php echo $this->_tpl_vars['rating_text']; ?>
</nobr>
                            <?php else: ?>
                                <nobr>全部</nobr>
                            <?php endif; ?>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>                        
                    </div>
                </span>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">小记添加人：</div>
                <div class="ui_text">
                    <input id="create_user"  name="create_user" type="text" />
                </div>  
                <div class="ui_title">小记添加时间：</div>
                <div class="ui_text">
                    <input id="create_time_start" type="text" class="inpCommon inpDate" name="create_time_start" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'create_time_end\')).focus()},maxDate:\'#F{$dp.$D(\\\'create_time_end\\\')}\'}'; ?>
)"/> 至
                    <input id="create_time_end" type="text" class="inpCommon inpDate" name="create_time_end" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'create_time_start\\\')}\'}'; ?>
)"/>
                </div> 
                
                <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="searchVertify()">查询</button></div>     
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" m="VisitManagementCheck" v="2" ispurview="true" onclick="pageList.ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
</a>
</div>
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
                    <th title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商名称</div>
            </div>
            </th>
            <th title="意向等级/签约产品">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">意向等级/签约产品</div>
            </div>
            </th>
            <th title="拜访类型">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">拜访类型</div>
            </div>
            </th>
            <th  title="被访人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">被访人</div>
            </div>
            </th>
            <th title="联系电话">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系电话</div>
            </div>
            </th>
            <th title="拜访时间">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">拜访时间</div>
            </div>
            </th>
            <th title="小记添加人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">小记添加人</div>
            </div>
            </th>
            <th title="小记添加时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">小记添加时间</div>
            </div>
            </th>
            <th title="拜访计划">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">拜访计划</div>
            </div>
            </th>
            <th title="拜访结果">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">拜访结果</div>
            </div>
            </th>
            <th title="质检状态">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">质检状态</div>
            </div>
            </th>
            <th title="操作">
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

            pageList.strUrl="<?php echo $this->_tpl_vars['BodyUrl']; ?>
"; 
        pageList.param = "&"+$('#tableFilterForm').serialize()+"&IntentionRating="+encodeURIComponent($("#ui_comboBox_IntentionRating").attr("key"));//get 获取！      
    <?php echo '
            pageList.init();
            
            $("#hasPect").change(function(){
                $("#IntentionRatingDiv").toggle();
            });
    });
    
    function searchVertify()
    {
        pageList.page = 1;
            pageList.param = "&"+$(\'#tableFilterForm\').serialize()+"&IntentionRating="+encodeURIComponent($("#ui_comboBox_IntentionRating").attr("key"));//get 获取！      
            pageList.first();
                
    }
    
    var FlagReviewVertify = function(noteId){
        if(noteId > 0){
            $.ajax({
                url:"/?d=WorkM&c=VisitVerify&a=VertifyReview&id="+noteId,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        IM.tip.show(data.msg);
                        pageList.reflash();
                    }else{
                        IM.tip.warn(data.msg);
                    }
                        return false;
                },
                error:function(){
                    IM.tip.warn("系统错误");
                        return false;
                }
            });
        }else{
            IM.tip.warn("获取数据出错");
        }
            return false;
    }
    
    </script>
'; ?>