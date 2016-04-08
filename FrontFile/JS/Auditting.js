/*审核*/
var Auditting = {
    _InAuditDealWith : false, 
    passAction : "",
    notPassAction : "",
    jumpPage : "",
    Pass : function(){
        if(Auditting.passAction == "")
        {
            alert("未添加后台执行代码！");
            return;
        }
        
        Auditting.Act(Auditting.passAction);
    },    
    NotPass : function () {
        var remark = $("#tbxAuditRemark").val();
        if(remark == "" || remark == "同意")
        {
            alert("请输入审核备注！");
            $("#tbxAuditRemark").val("");
            return ;
        }
        
        if(Auditting.notPassAction == "")
        {
            alert("未添加后台执行代码！");
            return;
        }
        Auditting.Act(Auditting.notPassAction);
    },
    Act: function (actionPath){
        
        //数据已提交，正在处理标识
        if (Auditting._InAuditDealWith) 
        {
            IM.tip.warn("数据已提交，正在处理中！");
            return false;
        }
    
        Auditting._InAuditDealWith = true; 
        $.ajax({
    	    url: actionPath,
    	    data:"remark="+encodeURIComponent($("#tbxAuditRemark").val()),
    	    type:"post",
    	    success:function(backData){
    	    	if(parseInt(backData) == 0)
                {
                    Auditting._InAuditDealWith = false;  
                    JumpPage(Auditting.jumpPage);
                }    
                else
                {
                    IM.tip.warn(backData);
                    Auditting._InAuditDealWith = false;                    
                } 
    	    }					
    	});
    }
}