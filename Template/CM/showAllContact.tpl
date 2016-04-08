      <!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>客户管理<span>&gt;</span>客户商机管理<span>&gt;</span>联系小记</div>
        <!--E crumbs-->   
		<!--S table_filter-->
          <div class="form_bd">
              <div class="form_block_bd">
		<div class="list_filter marginBottom10">  
                <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
                <div class="table_filter_main" id="J_table_filter_main">  
	               <div class="table_filter_main_row">
                        <div class="ui_title">被联系人名称：</div>
                        <div class="ui_text"><input class="inpCommon" type="text" name="contactName" style="vertical-align:top;"/></div>
                        <div class="ui_title">网盟意向等级：</div>
                            {literal}
                                <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({'control':'IntentionRating',data:MM.A(this,'data')},this)" 
                                {/literal}
                                class="ui_comboBox ui_comboBox_def" key="{$rating_id}" value="{$rating_text}" control="IntentionRating" data="{$strIntentionRatingJson}" style="width:100px;">
                                <div class="ui_comboBox_text" style="width:80px;">
                                    {if $rating_id != ""}
                                        <nobr>{$rating_text}</nobr>
                                    {else}
                                        <nobr>全部</nobr>
                                    {/if}
                                </div>
                                <div class="ui_icon ui_icon_comboBox"></div>                        
                            </div>
                        <div class="ui_title">联系时间：</div>
                        <div class="ui_text">
                            {literal}
                            <input class="inpCommon inpDate" type="text" name="contactTimeS" id="J_editTimeS" onfocus="WdatePicker({onpicked:function(){($dp.$('J_editTimeE')).focus()},maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})"> 至
                            <input class="inpCommon inpDate" type="text" name="contactTimeE" id="J_editTimeE" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})">       
                            {/literal}                       
                        </div>
                        
                        <div class="ui_button ui_button_search"></span><button type="button" class="ui_button_inner" onclick="search();">搜索</button></div>	                                                                
                    </div>
                   </div>
                   </form>
			<a class="ui_button ui_button_dis" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showDetailFront"}&customer_id={$customer_id}')">
				<div class="ui_button_left"></div>
				   <div class="ui_button_inner">
					<div class="ui_icon ui_icon_return"></div>
					<div class="ui_text">返回</div>
				   </div>
			</a>
		
		
	</div>
        <!--E table_filter-->
        <!--S list_link-->
        <input id="customer_ids" name="customer_id" type="hidden" value="{$customer_id}"/>
		
        <!--E list_link-->
        <!--S list_table_head-->
		<div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$customer_name}</h4>
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
                                	<th title="操作人">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">操作人</div>
                                        </div>
                                    </th>
    								<th style="" title="被联系人">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">被联系人</div>
                                        </div>
                                    </th>             					
                                   <th title="联系电话">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">联系电话</div>
                                        </div>
                                    </th>
                                    </th>             					
                                   <th title="联系时间">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">联系时间</div>
                                        </div>
                                    </th>
                                   <th title="小记内容">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">小记内容</div>
                                        </div>
                                    </th>
                					<th title="意向等级" style="width:60px;">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">意向等级</div>
                                        </div>
                                    </th>   
                               </tr>
                           </thead>
                           <tbody class="ui_table_bd" id="pageListContent">
                            </tbody>
                       </table>
            </div>
            <!--E ui_table-->
        </div> </div> </div>
        <!--E list_table_main--> 
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
  <script type="text/javascript" src="{$JS}pageCommon.js"></script>
    <script language="javascript" type="text/javascript">
    {literal}
    $(function(){
       {/literal}
    	pageList.strUrl="{$strUrl}";
    	{literal}
    	pageList.init();
    });
        
function search(){
    var A = $("#J_editTimeS").val();
    var B = $("#J_editTimeE").val();
   
    if (A =="" && B !="") 	IM.tip.warn("请输入起始时间");
    if (A !="" && B =="") 	IM.tip.warn("请输入截止时间");
    pageList.param ='&'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.first();
            }
    {/literal}
    </script>
