<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>运营管理<span>&gt;</span>{$strTitle}</div>
<!--E crumbs-->     
<!--S form_edit-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <!--S form_bd-->
    <div class="form_bd">
        <form enctype="multipart/form-data" method="post" name="agentDocForm" action="" id="agentDocForm">              
            <!--S form_block_bd--> 
            <div class="form_block_bd" style="padding-top:10px;">
            <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">温馨提示：文件格式必须是<span id="spanNote" style="color:red">文档</span>。文件大小限制：10M。</span></div>
                <div class="tf">
                    <label><em class="require">*</em>代理商名称：</label>
                    <div class="inp">
                        <input id="tbxAgent" name="tbxAgent" value="{$agentName}" type="text" autocomplete="off"  style="width:200px;"/>
                        <input name="tbxAgentID" id="tbxAgentID"  type="hidden" value="{$agentID}" />
                    </div>
                    <span class="info">请输入相关代理商</span><span class="ok">&nbsp;</span><span class="err">请输入相关代理商</span><span class="err2">对不起，您输入的代理商不存在！</span><span class="state">&nbsp;</span>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>附件类型：</label>
                    <div class="inp">
                        <select onchange="DocTypeChanged()" name="cbDocType" id="cbDocType" valid="filetypeselect" style="width:165px;" >
                            <option value="0">请选择</option>
                            {foreach from=$arrayAgentDocType item=value key=key}
                                <option value="{$key}">{$value}</option>
                            {/foreach}
                        </select>
                    </div>
                    <span class="info">请选择附件类型</span><span class="ok">&nbsp;</span><span class="err"></span>
                </div>
                <div class="tf" id="divType_c">
                    <label>作者：</label>
                    <div class="inp"><input name="tbxAuthor" type="text" id="tbxAuthor" style="width:165px;" size="30" maxlength="20"/></div>
                </div>
                <div class="tf" id="divType_q">
                    <label><em class="require">*</em>资质类型：</label>
                    <div class="inp">
                    <select name="cbPermitType" id="cbPermitType" style="width:165px;" >
                    <option selected="selected" value="-100">请选择</option>
                    <option value="1">营业执照</option>
                    <option value="2">税务登记证</option>
                    <option value="3">法人身份证</option>
                    <option value="4">组织机构代码证</option>
                    <option value="5">般纳税人资格证</option>
                    </select>
                    </div>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>上传文件：</label>
                    <div class="inp">
                        <input type="file"  name="fileUpload" id="fileUpload"  style="width:550px;"  />
                        <input type="hidden" name="tbxUploadFilePath" id="tbxUploadFilePath" /><br />
                    </div>
                    <span class="info">请上传文件</span><span class="ok">&nbsp;</span><span class="err">请上传文件</span>
                </div>
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">
                        <div class="ui_button ui_button_confirm"><button id="btnSave" type="submit" class="ui_button_inner" >确定</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack()">取消</a> </div>
                    </div>
                </div>
            </div>
            <!--E form_block_bd-->                 
        </form>
    </div>
    <!--E form_bd--> 
</div>
<!--E form_edit-->  

{literal}
<script language="javascript" type="text/javascript">
function DocTypeChanged()
{
    var obj = $DOM("cbDocType");
    $("#divType_c").hide();
    $("#divType_q").hide();
    if(obj.value == 3)
    {
        $("#spanNote").html("图片");
        $("#divType_q").show();
    }
    else
    {
        $("#spanNote").html("文档");
        $("#divType_c").show();
    }
        
}



$('#tbxAgent').autocomplete('/?d=WorkM&c=VisitAppoint&a=CompleteAgentJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
    max: 5, //只显示5行
    width: 200, //下拉列表的宽
    parse: function (Data) {
        var parsed = [];
        if (Data == "" || Data.length == 0)
            return parsed;
        Data = MM.json(Data);
        var value = Data.value;
        if (value == undefined)
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
    formatItem: function (item){
        return "<div id='" + item.id + "'>" + item.name + "</div>";
    }
}).result(function (data,value) {//执行模糊匹配
    var id = value.id;
    $("#tbxAgentID").val(id);
});
                           
new Reg.vf($('#agentDocForm'),{
extValid:{
    filetypeselect:function(){return $('#cbDocType').val()!=0;}
    },
    callback:function(){
        
        if($("#cbDocType").val() == 3 && $("#cbPermitType").val()<=0)
        {
            IM.tip.warn("请选择资质类型");
            return;
        }
        
        var filename = GetUploadFileName();
        var backData = $PostData("/?d=Agent&c=AgentDoc&a=IsExistFile","filename="+filename+"&"+$('#agentDocForm').serialize());
        if(parseInt(backData) == 0)
        {
            UploadFile();
        }
        else if(parseInt(backData) == 1)
        {
            IM.dialog.show({
                width: 250,
                title: "提示",
                html: '数据加载中..',
                start: function () {
                    $('.DCont')[0].innerHTML = '<div class="DContInner delAccountCont">' +
                        '<div class="bd"><h4>文件已经存在，是否覆盖？</h4></div>' +
                        '<div class="ft">' +
                        '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
                        '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok();">确 定</button></div>' +
                        '</div></div>';
                },
                ok:function (){
                    IM.dialog.hide(); 
                    UploadFile();   
                }
            });
        }
        else
        {
            IM.tip.warn(backData);
        }
    }
}); 

var _InDealWith = false;
function UploadFile(){ 
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    var filename = GetUploadFileName();
    _InDealWith = true;
    $.ajaxFileUpload({
    	url:"/?d=Agent&c=AgentDoc&a=UploadFile&"+$('#agentDocForm').serialize(),
    	secureuri:false,
    	fileElementId:"fileUpload",
    	dataType: 'text',
    	success: function (data){
            if(data.substring(0,1) != "{")
            {
    	       _InDealWith = false;
                IM.tip.warn(data);
                return;
            }
	    
            data = eval("("+data+")");

            if(data.success == false)
            {
    	       _InDealWith = false;
                IM.tip.warn(data.msg);
                return;
            }
            
            $("#tbxUploadFilePath").val(data.msg);
            UploadSubmit(filename);
    	}
    });
    _InDealWith = false;
}  

function UploadSubmit(filename){
    var backData = $PostData("/?d=Agent&c=AgentDoc&a=UploadSubmit","filename="+filename+"&"+$('#agentDocForm').serialize());
    
    _InDealWith = false;
    if(parseInt(backData) == 0)
    {
        IM.tip.show("操作成功！");
        PageBack();
    }
    else
    {
        IM.tip.warn(backData);
    }
}

function GetUploadFileName()
{
    var filepath = $("#fileUpload").val();
    var arrayfilename = filepath.split('\\');
    return encodeURIComponent(arrayfilename[arrayfilename.length - 1]);
}

DocTypeChanged();
</script>
{/literal}