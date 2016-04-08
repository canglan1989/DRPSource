<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>代理商全国分布图</title>
        <link rel="stylesheet" href="/../FrontFile/CSS/map_base.css"/>
        <link href="/../FrontFile/JS/calendar/skin/WdatePicker.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/../FrontFile/JS/map.base.js"></script>
        <script src="/../FrontFile/JS/calendar/WdatePicker.js" type="text/javascript"></script>
    </head>
    <body style="padding: 10px;">
        <div id="j_side" class="side">
            <div class="hd">
                <h1>代理商信息录入</h1>
            </div>
            <div class="bd">
                <form id="j_agentForm">
                    <input type=hidden value="{$data->iId}" name='id'>
                    <div class="common_tf" onmousemove="this.style['background']='#FFF5F5'" onmouseout="this.style['background']='#fff'">
                        <div class="tf">
                            <label><em class="require">*</em>公司名称</label>
                            <div class="inp"><input type="text" valid="required" name="agent_name" value="{$data->strAgentName}"></div>
                            <span class="info">请输入公司名称</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入公司名称</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>代理区域</label>
                            <div class="inp"><input type="text" valid="required" name="area" value="{$data->strArea}"></div>
                            <span class="info">请输入代理区域</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入代理区域</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>代理产品</label>
                            <div class="inp"><input type="text" valid="required" name="product_name" value="{$data->strProductName}"></div>
                            <span class="info">请输入代理产品</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入代理产品</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>代理截止时间</label>
                            <div class="inp"><input type="text" valid="required" class="inpDate" name="deadline" value="{$data->strDeadline}" onfocus={literal}"WdatePicker({dateFmt:'yyyy-MM-dd'})"{/literal}></div>
                            <span class="info">请输入代理截止时间</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入代理截止时间</span>
                        </div>

                        <div class="tf">
                            <label><em class="require">*</em>保证金</label>
                            <div class="inp"><input type="text" valid="required" name="ensure_money" value="{$data->iEnsureMoney}"></div>
                            <span class="info">请输入保证金</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入保证金</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>预存款</label>
                            <div class="inp"><input type="text" valid="required" name="deposits" value="{$data->iDeposits}"></div>
                            <span class="info">请输入预存款</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入预存款</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>签单人员</label>
                            <div class="inp"><input type="text" valid="required" name="sign_name" value="{$data->strSignName}"></div>
                            <span class="info">请输入签单人员</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入签单人员</span>
                        </div>
                        <div class="tf noMargin">
                            <label><em class="require">*</em>到账情况</label>
                            <div class="inp"><input type="text" valid="required" name="status" value="{$data->strStatus}"></div>
                            <span class="info">请输入到账情况</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入盘到账情况</span>
                        </div>
                    </div>
                    <div class="common_tf" onmousemove="this.style['background']='#FFF5F5'" onmouseout="this.style['background']='#fff'">
                        <div class="tf">
                            <label><em class="require">*</em>外访达标率</label>
                            <div class="inp"><input type="text" valid="required" name="visit_rate" value="{$data->strVisitRate}"></div>
                            <span class="info">请输入外访达标率</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入外访达标率</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>应访数</label>
                            <div class="inp"><input type="text" valid="required" name="visit_num" value="{$data->iVisitNum}"></div>
                            <span class="info">请输入应访数</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入应访数</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>实防数</label>
                            <div class="inp"><input type="text" valid="required" name="real_visit" value="{$data->iRealVisit}"></div>
                            <span class="info">请输入实防数</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入实防数</span>
                        </div>
                        <div class="tf noMargin">
                            <label><em class="require">*</em>盘盟上线家数</label>
                            <div class="inp"><input type="text" valid="required" name="adhai_online_num" value="{$data->iAdhaiOnlineNum}"></div>
                            <span class="info">请输入盘盟上线家数</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入盘盟上线家数</span>
                        </div>
                    </div>
                    <div class="common_tf" onmousemove="this.style['background']='#FFF5F5'" onmouseout="this.style['background']='#fff'">
                        <div class="tf">
                            <label><em class="require">*</em>已签单客户</label>
                            <div class="inp"><input type="text" valid="required" name="signed_customer" value="{$data->strSignedCustomer}"></div>
                            <span class="info">请输入已签单客户</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入已签单客户</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>新开发客户</label>
                            <div class="inp"><input type="text" valid="required" name="new_customer" value="{$data->strNewCustomer}"></div>
                            <span class="info">请输入新开发客户</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入新开发客户</span>
                        </div>
                        <div class="tf noMargin">
                            <label><em class="require">*</em>跟进中客户</label>
                            <div class="inp"><input type="text" valid="required" name="follow_customer" value="{$data->strFollowCustomer}"></div>
                            <span class="info">请输入跟进中客户</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">请输入跟进中客户</span>
                        </div>
                    </div>
                    <div class="common_tf" onmousemove="this.style['background']='#FFF5F5'" onmouseout="this.style['background']='#fff'">
                        <div class="tf">
                            <label><em class="require">*</em>地图坐标</label>
                            <div class="inp"><input type="text" valid="required" name="coordinate" value="{$data->strCoordinate}"></div>
                            <span class="info" style="display: inline-block;">用来显示代理商在地图中位置 如：116.43244,40.043204</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">用来显示代理商在地图中位置 如：116.43244,40.043204</span>
                        </div>
			<div class="tf">
                            <label><em class="require">*</em>战区名</label>
                            <div class="inp"><input type="text" valid="required" name="group_name" value="{$data->strGroupName}"></div>
                            <span class="info" style="display: inline-block;">用来显示战区区域文本显示 如：东北战区</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">用来显示战区区域文本显示 如：东北战区</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>战区中心坐标</label>
                            <div class="inp"><input type="text" valid="required" name="group_center_coordinate" value="{$data->strGroupCenterCoordinate}"></div>
                            <span class="info" style="display: inline-block;">用来显示战区区域文本在地图中位置 如：116.43244,40.043204</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err">用来显示战区区域文本在地图中位置 如：116.43244,40.043204</span>
                        </div>
                        <div class="tf noMargin">
                            <label><em class="require">*</em>战区区域</label>
                            <div class="inp"><textarea valid="required" style="height: 80px;" name="group_coordinate" >{$data->strGroupCoordinate}</textarea></div>
                            <span class="info" style="display: inline-block; width: 350px;">用来绘制地图中战区区域，多个用“|”分隔，如：<br/>116.43244,40.043204|116.43244,40.043204|116.43244,40.043204</span>
                            <span class="ok">&nbsp;</span>
                            <span class="err" style=" width: 350px;">用来绘制地图中战区区域，多个用“|”分隔，如：<br/>116.43244,40.043204|116.43244,40.043204|116.43244,40.043204</span>
                        </div>
                    </div>
                    <div class="tf">
                        <label>&nbsp;</label>
                        <div class="inp">
                            <div class="ui_button ui_button_submit"><button class="ui_button_inner" type="submit">确认并提交</button></div>
                            <div class="ui_button ui_button_cancel" style="margin: 12px 0 0 20px;"><a class="ui_button_inner" href="/?d=Map&a=showList">返回</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {literal}
            <script type="text/javascript">
                new Reg.vf($('#j_agentForm'),{
                    callback:function(data){
                        MM.ajax({
                            url:'/?d=Map&a=SaveEdit',
                            data:data,
                            success:function(q){
                                q=MM.json(q);
                                if(q.success){
				    //location.href='/?d=Map&a=showList';      
            PageBack();
                                }else{IM.tip.warn('不给力哦，请重试~')}
                            }
                        })
                    }
                });
            </script>
        {/literal}
    </body>
</html>