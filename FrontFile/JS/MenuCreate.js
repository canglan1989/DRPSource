/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：系统菜单创建
 * 创建人：wzx
 * 添加时间：2011-8-8 
 * 修改人：      修改时间：
 * 修改描述：
 **/
var MenuCreate = {
    RootMenu : null,
    MenuItem : null,
    CreateRootMenu : function(){
        if(MenuCreate.RootMenu == null)
            return ;
            
        var firstNo = "";
        if(MenuCreate.RootMenu.length > 0)
        {
            var strHtml = "";
            var jsonObj = eval("(" + MenuCreate.RootMenu + ")");
            var jsonObjLength = jsonObj.length;
            for(var i=0;i<jsonObjLength;i++)
            {
                if(i==0)
                    firstNo = jsonObj[i]["no"];
                strHtml += "<li class='li"+jsonObj[i]["css"]+"'><a id='rm_"+jsonObj[i]["no"]+"' href='javascript:;' onclick=\"MenuCreate.GetLeftMenu(this)\">"
                +jsonObj[i]["name"]+"</a></li>";
            }
            
            $("#ulNav").html(strHtml);      
        }
        
        return firstNo;
    },
    GetRootName : function(rno){
        var rootName = "";
        var jsonObj = eval("(" + MenuCreate.RootMenu + ")");
        var jsonObjLength = jsonObj.length;
        for(var i=0;i<jsonObjLength;i++)
        {
            if(rno == jsonObj[i]["no"])
            {
                rootName = jsonObj[i]["name"];
                break;
            }
        }
        
        return rootName;
    },
    CreateLeftMenu : function(){
        if(MenuCreate.MenuItem == null)
            return ;            
            
        if(MenuCreate.MenuItem.length > 0)
        {
            var jsonObj = eval("(" + MenuCreate.MenuItem + ")");
            var jsonObjLength = jsonObj.length;
            var strHtml = "";
            var oldMgroup_no = "";
            
            for (var d = 0; d < jsonObjLength; d++) {            
            
                if(oldMgroup_no != jsonObj[d].mgroup_no.substring(0,2))
                {          
                    if(d != 0)
                        strHtml += "</div>";                    
                    strHtml += "<h2 class=\"sidenav_hd\" id=\"hd_"+ jsonObj[d].mgroup_no +"\">"+ MenuCreate.GetRootName(jsonObj[d].mgroup_no.substring(0,2)) 
                    +"</h2><div class=\"sidenav_bd\" id=\"bd_"+ jsonObj[d].mgroup_no +"\">"; 
                }
                
                oldMgroup_no = jsonObj[d].mgroup_no.substring(0,2);
                                
                if(d == jsonObjLength-1)
                {                
                    strHtml += "<div class=\"layoutBox folderBox layoutBoxLast\">";
                }
                else
                {
                    if(d < jsonObjLength && oldMgroup_no != jsonObj[d+1].mgroup_no.substring(0,2))
                        strHtml += "<div class=\"layoutBox folderBox layoutBoxLast\">";
                    else
                        strHtml += "<div class=\"layoutBox folderBox\">";                    
                }
                
                //strHtml += "<div class=\"layoutBox folderBox layoutBoxLast\">";            
                strHtml += "<div class=\"hd\"><h3 class=\"hd_inner\"><span class=\"icon_folder\"></span>";
                strHtml += "<span>"+jsonObj[d].mgroup_name+"</span>";
                strHtml += "</h3></div><div class=\"bd\"><div class=\"bd_inner\"><ol>";
                
                var subJsonObj = jsonObj[d].model;
                var subJsonObjLength = subJsonObj.length;
                for (var j = 0; j < subJsonObjLength; j++) {                
                    strHtml += "<li><a id='"+oldMgroup_no+"$"+getPageID(subJsonObj[j].url)+"' onclick=\"MenuCreate.MenuClick('" + subJsonObj[j].url + "',this)\">";
                    strHtml += "<span>" + subJsonObj[j].model_name + "</span></a></li>";
                }
                
                strHtml += "</ol></div></div></div>";
                
                if(d == jsonObjLength-1)  
                    strHtml += "</div>";
            }
            
            $("#J_sidenav").html(strHtml);        
        }
    },
    GetLeftMenu : function(context){
        if(context == undefined || context == null )
            return ;
        pno = context.id.replace("rm_","");
        $("h2.sidenav_hd").each(function(){
            this.style.display = "none";
            if(this.id.indexOf("hd_"+pno) >= 0)
              this.style.display = "";
        });
        $("div.sidenav_bd").each(function(){
            this.style.display = "none";
             if(this.id.indexOf("bd_"+pno) >= 0)
                  this.style.display = "";
        });
        
        $(context).parents('ul').find('li').find('a').removeClass('cur');
        $(context).addClass('cur');
    },
    MenuClick: function(pUrl,obj){
        JumpPage(pUrl,true,true);
        ClearStockQueryData();
    	$('#J_sidenav a').removeClass('cur');
    	obj&&$(obj).addClass('cur');
		$('.ui_comboBox_layer').remove();
    },
    SelectMenu: function(pUrl)
    {
        var id = getPageID(pUrl);
        var rootNo = "";
        var ids = null;
        var obj = null;
        $("#J_sidenav a").each(
            function(){
                ids = this.id.split("$");
                if(ids != undefined && ids != null &&ids.length == 2 && ids[1] == id)
                {        
                    rootNo = ids[0];
                    obj = this;
                }
            }
        );
        
        if(rootNo != "")
        {
            $('#J_sidenav a').removeClass('cur');
            $("#rm_"+rootNo)[0].onclick();
            $(obj).addClass('cur');
        }
        
		$('.ui_comboBox_layer').remove();
    }
};