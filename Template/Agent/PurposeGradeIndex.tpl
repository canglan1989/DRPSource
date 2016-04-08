<!--S crumbs-->
<div class="crumbs marginBottom10"><s class="icon_crumbs"></s>当前位置：意向评级统计</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">        	
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">	    			                        		                        		
                <div class="ui_title">员工号/姓名：</div>
                <div class="ui_text"><input class="inpCommon" name="worker_name" id="worker_name" type="text"></div>
                <div class="ui_title">时间：</div>
                <div class="ui_text"><input class="registeredTime inpDate" type="text" name="STime" id="STime" onfocus="WdatePicker()"></div>  
                <!--<div class="ui_text"><input class="registeredTime inpDate" type="text" name="ETime" id="ETime" onfocus="WdatePicker()"></div> -->  
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" id="searchAgent" name="searchAgent">搜索</button></div>                              
            </div>
        </div>
    </form>
</div>
<div class="list_link marginBottom10">
<a class="ui_button" onclick="ExportExcel()" href="javascript:;" m="showPurposeGrade" v="16" ispurview="true"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 意向评级统计列表</h4>
        </div>
    </div>			           
</div>
<!--E list_table_head-->        
<!--S list_table_main-->       
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table ui_intent_rating_table">                    	
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr class="">
                    <th style="width:80px;" class="first">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">意向评级</div>
            </div>
            </th>
            <th>
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">A</div>
<!--                <div class="ui_table_thsort"></div>-->
            </div>
            </th>
            <th>
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">B</div>
<!--                <div class="ui_table_thsort"></div>-->
            </div>
            </th>
            <th>
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">C</div>
            </div>
            </th>                				
            <th>
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">D</div>
            </div>
            </th>
            <th>
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">E</div>
            </div>
            </th>
            <th>
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">签约后</div>
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
    <div id="divPager" class="ui_pager">

    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal}
    <script type="text/javascript">
    //分页    
    pageList.strUrl={/literal}"{$strUrl}"{literal};
    pageList.init();

    var J_auditerName=$('#worker_name');
    J_auditerName.autocomplete('/?d=Agent&c=TaskAssign&a=AutoComplete',{
        max:5,
        width:J_auditerName.width()+2,
        parse:function(q){
            var parsed=[];
            q=MM.json(q);
            q=q.value;
            for(var i=0;i<q.length;i++){
                parsed[parsed.length]={
                    data:q[i],
                    value:q[i].user_id,
                    result:q[i].name
                }
            }
            return parsed;
        },
        formatItem:function(item){
            return '<em>'+item.name+'</em>';
        }
    });
        
    $("#searchAgent").click(function(){
        var workno=$("#worker_name").val();
        var STime=$("#STime").val();
        //var ETime=$("#ETime").val();
        pageList.page = 1;
        pageList.param = '&sTime='+STime+"&search=1"+"&workno="+workno;
        pageList.first();
    });
function ExportExcel()
{
    window.open("/?d=Agent&c=Agent&a=ExcelExportExpectInfo");
}
    </script>

{/literal}