    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a onclick="JumpPage('{au d='WorkM' c='VisitAppoint' a='AppointList'}')" href="javascript:";>拜访小记管理</a><span>&gt;</span>添加拜访小记</div>
    <!--E crumbs-->     
    <!--S form_edit-->                  
    <div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>添加拜访小记</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
	<!--S form_bd-->
	<div class="form_bd">
		<form id="J_noteAddForm" name="agentAddForm" class="agentAddForm">
		<div class="form_block_hd"><h3 class="ui_title">小记信息</h3></div>		
		<!--S form_block_bd--> 
		<div class="form_block_bd">
		    <div class="tf">
			 <label>代理商名称：
		    <input type="hidden" id="id" value="{$arrayData.0.id}" name="id" /></label>
    			     <div class="inp">
                        {$arrayData.0.agent_name}                        
                        <input type="hidden" id="agentId" value="{$arrayData.0.agent_id}" name="agentId" />
                        <input type="hidden" id="appoint_id" value="{$appoint_id}" name="appoint_id" />
    				</div>
		    </div>
    		<div class="tf">
    			<label>拜访主题：</label>
    			<div class="inp">
                {$arrayData.0.title}
    			</div>
		    </div>
		    <div class="tf">
    			 <label><em class="require">*</em>实际拜访时间：</label>
    			<div class="inp">
    			<input type="text" class="registeredTime inpDate" name="note_timeb" {literal}onfocus="WdatePicker({onpicked:function(){($dp.$('note_timee')).focus()},dateFmt:'yyyy-MM-dd HH:mm:ss'})"{/literal} id="note_timeb" value="{$arrayData.0.visit_timestart}{$arrayData.0.sappoint_time}"> 
    			至 
    			<input type="text" class="registeredTime inpDate" name="note_timee" {literal}onfocus="WdatePicker({minDate:'#F{$dp.$D(\'note_timeb\')}',dateFmt:'yyyy-MM-dd HH:mm:ss'})"{/literal} id="note_timee" value="{$arrayData.0.visit_timeend}{$arrayData.0.eappoint_time}" valid="required">
    			</div>
                <span class="info">请输入实际拜访时间</span>
        		<span class="ok">&nbsp;</span>
        		<span class="err">请输入实际拜访时间</span>
		    </div>
            
            <div class="tf">
    			 <label><em class="require">*</em>被访人：</label>
        			<div class="inp"><input class="LegalPersonName" type="text" name="visitor" maxlength="10" id="visitor" valid="required" value="{$arrayData.0.visitor}" autocomplete="off" tabindex="6"/>
                    </div>
                    <span class="info">请输入被访人名称</span>
            		<span class="ok">&nbsp;</span>
            		<span class="err">请输入被访人名称</span>
		    </div>
		    <div class="tf">
			 <label>手机：</label>
    			<div class="inp"><input class="LegalPersonName" type="text" name="mobile" tabindex="7" value="{$arrayData.0.mobile}" id="mobile" autocomplete="off" />
                </div>
		    </div>
		    <div class="tf">
    			<label>固定电话：</label>
    			<div class="inp"><input class="LegalPersonName" type="text" name="tel" tabindex="7" id="tel" value="{$arrayData.0.tel}"/>
    			</div>
		    </div>
            <div class="tf">
			 <label><em class="require">*</em>拜访结果：</label>
    			<div class="inp">
                <textarea id="result" name="result" valid="required" style="width:500px;height:80px;"  maxlength="450">{$arrayData.0.result}</textarea>
    			</div>
                <span class="info">请输入拜访结果</span>
        		<span class="ok">&nbsp;</span>
        		<span class="err">请输入拜访结果</span>
		    </div>
            
            {if $arrayData.0.product_name == ""}
            <div class="tf">
                <label><em class="require">*</em>意向评级：</label>
                <div class="inp">
                    <select tabindex="8" name="inten_level" id="inten_level">                                
                        <option  value="0">未评级</option>
                        <option value="A" {if $arrayData.0.afterlevel=="A"}selected="selected"{/if} >A</option>
                        <option value="B+" {if $arrayData.0.afterlevel=="B+"}selected="selected"{/if}>B+</option>
                        <option value="B-" {if $arrayData.0.afterlevel=="B-"}selected="selected"{/if}>B-</option>
                        <option value="C" {if $arrayData.0.afterlevel=="C"}selected="selected"{/if}>C</option>
                        <option value="D" {if $arrayData.0.afterlevel=="D"}selected="selected"{/if}>D</option>
                        <option value="E" {if $arrayData.0.afterlevel=="E"}selected="selected"{/if}>E</option>
                    </select>
                </div>
            </div>
            {else}
            <div class="tf">
		<label>拜访后签约产品：</label>
    		<div class="inp">             
                    {$arrayData.0.product_name}
                    <input type="hidden" id="product_name" name="product_name" value="{$arrayData.0.product_name}" />               
                </div>       
	    </div>
            {/if}
        <div class="tf">
            <label>预计到账金额：</label>
            <div class="inp"><input type="text"  name="expectMoney" id="expectMoney" value="{$arrExpect.expect_money}" valid="amount"></div>
            <span class="info">请输入金额</span>
            <span class="ok">&nbsp;</span><span class="err">请输入金额</span>
        </div>
        <div class="tf">
            <label>预计到账时间：</label>
            <div class="inp"><input type="text" onfocus="WdatePicker()" name="expectTime" class="inpDate"  value="{$arrExpect.expect_time}"></div>
            <span class="info">请输入时间</span>
            <span class="ok">&nbsp;</span><span class="err">请输入时间</span>
        </div>
        <div class="tf">
            <label>预计到账概率：</label>
            <div class="inp"><input type="text"  name="expectPercent" id="expectPercent" value="{$arrExpect.charge_percentage}" style="width:50px;" valid="amount"><span>%</span></div>
            <span class="info">请输入概率</span>
            <span class="ok">&nbsp;</span><span class="err">请输入概率</span>
        </div>
        <div class="tf">
            <label>预计到账类型：</label>
            <div class="inp">
                <select tabindex="8" name="type" id="type">                                
                    <option  value="0"></option>
                    <option value="1" {if $arrExpect.type==1} selected="selected" {/if} >承诺</option>
                    <option value="2" {if $arrExpect.type==2} selected="selected" {/if}>备份</option>                  
                </select>
            </div>
        </div>
            <div class="tf">
			 <label>需求支持：</label> 
    			<div class="inp">
                <textarea id="support" name="support" style="width:500px;height:80px;" maxlength="200">{$arrayData.0.support}</textarea>
                </div>
		    </div>
                </div>
                <!--E form_block_bd-->		
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">   
						<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
						<div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
					</div>
                </div>
			</div>
			<!--E form_block_bd--> 
	    </form>
	</div>
	<!--E form_bd--> 
    {literal} 
    <style>.tf label{width:160px;}</style>
<script language="javascript" type="text/javascript">
 new Reg.vf($('#J_noteAddForm'),{
            callback:function(data){
                var agentlevel = $('#inten_level').val();               
		if(agentlevel == "0")
		{
			IM.tip.warn("请选择意向评级！");
			return false;
		}               
                if(!IM.IsSending(true)){return false;};
                MM.ajax({
                    url:'/?d=WorkM&c=VisitNote&a=NoteModifySubmit',
                    data:data,
                    success:function(q){
                        IM.IsSending(false);
                       
                        if(q == 0){
                            JumpPage("/?d=WorkM&c=VisitNote&a=NoteList");
                            var id = $DOM("id").value;
                            if(id == "")
                                id = 0;
                            if(id > 0)
                                IM.tip.show("编辑成功");
                            else
                                IM.tip.show("添加成功");
                                
                        }else{
                            IM.tip.warn(q);
                        }
                    }
                });
            }
    });
{/literal} 
     $('#visitor').autocomplete('/?d=WorkM&c=VisitNote&a=CompleteVisiterJson&appoint_id={$appoint_id}',
     {literal} 
     {                                                             //页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 15, //只显示15行
                width: 150, //下拉列表的宽
                parse: function (Data) {//q 返回的数据 JSON 格式，在这里解析成列表
                                       
                    var parsed = [];
                    if (Data == "" || Data.length == 0)
                        return parsed;
                    //alert(backData);
                    Data = MM.json(Data);
                    var value = Data.value;
                    //alert(value);
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
                formatItem: function (item) {//内部方法生成列表
                    //_id=item.id;
                    return "<div id='divUser" + item.id + "'>" + item.name + "</div>";
                }
            }).result(function (data, value) {//执行模糊匹配
                _id = value.id;
               
               _name = value.name;
                $("#mobile").val(_id);
                var val = $(this).val();
                if (val != '') 
                    GetTel(_name);
               
            });
    function GetTel(_name)
    {
        var tel = $PostData("/?d=WorkM&c=VisitAppoint&a=GetTel","contact_name="+_name)//_name=agentName
        $("#tel").val(tel);
    }
    
    </script>
{/literal}