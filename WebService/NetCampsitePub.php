<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网营门户 - 网站生成</title>
</head>
<body>
<div class="fixed" id="divNote"></div>
<?php 
if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
require_once __DIR__.'/../Action/Common/Utility.php';
require_once __DIR__ . '/../Class/BLL/TMNetOpeBLL.php';

$site_published = Utility::GetFormInt("site_published",$_GET);//发布成功后页面刷新过来的状态
        
$orderID = Utility::GetFormInt("orderID",$_GET);
if($orderID <= 0)
    exit("订单ID不正确！");
    
$siteId = 0;
$tMNetOpeBLL = new TMNetOpeBLL();
if($site_published > 0)//1 成功 3 4 失败 
{
    if($site_published == 1)
    {
        $rtn = $tMNetOpeBLL->SitePublished($orderID,1,"");
        if($rtn == 1)
		  exit("哈哈，站点发布成功！");
        else
		  exit("网站生成成功，但扣款可能失败");
    }
    else
    {
        $rtn = $tMNetOpeBLL->SitePublished($orderID,0,"");
        exit("网站生成失败");
    }
}
else
{
    $arrayData = $tMNetOpeBLL->GetSiteIDAndPublishState($orderID);
    if(isset($arrayData) &&count($arrayData) > 0)
    {
            if($arrayData[0]["publish_state"] == 2 )//发布状态 0--未发布 1--发布中 2--发布成功 3--发布失败
		      exit("该站点已发布！");
          
        $siteId = $arrayData[0]["site_id"];
    }
    else
	  exit("未找到订单数据！");
}

if($siteId <= 0)//设置要生成的站点号
    exit("站点ID不正确！");
    
$arrSysConfig = unserialize(SYS_CONFIG);
$sys_evn = $arrSysConfig["SYS_EVN"];
            
$url = "http://buildtest.epanshi.com:8080/";//站点域名最后加 /
if($sys_evn == 2)
{
    $url = "http://b5.epanshi.com/";
}        
?>
<div class="fixed" id="divProcess"></div>
<script src="http://style3.epanshi.com/script/jquery-1.4.2.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function submitFormSome(){

	var siteId=<?php echo $siteId;?>;
    siteId = parseInt(siteId);
    
    if(!isNaN(siteId) && siteId > 0)
    {
        $("#divNote").html("网营门户正在发布中，请不要关闭页面。");
        submitPartial(siteId, 1, 0);	
    }
}
/**
 * 		异步请求调用和处理函数
 *      siteId：需要生成的网站的站点id
 *		reqpage：当前请求页
 *    	total：总计生成的页面数
 */
function submitPartial(siteId, reqpage, total){
	$.ajax({
		type: "GET",
		url: "<?php echo $url;?>"+siteId+"/action/generatesitefordrp/create",
		cache:false,
		data: "publishType=publishSome&ss=generate&siteId="+siteId+"&reqpage="+reqpage+"&total="+total+
		"&validatecode="+'<?php 
		//生成验证码
        $wsEncrypt = array("suffixStr"=>"|".date('Y-m-d',time()),"subLen"=>32);
        $suffixStr = $wsEncrypt["suffixStr"];
        $subLen = $wsEncrypt["subLen"];

        $str=$siteId . $suffixStr;
		$returnValue = md5($str);
        if ($subLen > 0)
        {
            $returnValue = substr($returnValue, 0, $subLen);
        }
        echo $returnValue;?>',
		dataType:"jsonp",
		success: function(d){
			if(d.validate==0)
			{
				$("#divNote").html("验证失败");
			}
			else
			{
				if(!d ){//生成失败（生成过程出错或异常）
		              location.href = location.href+"&site_published=4&rand=" + Math.random();
                    //$("#divNote").html("生成过程出错或异常");
				}
				else{                  //当前请求成功返回（包括success状态为false的请求）
					
					if(d.code != 2){    //请求结束（生成成功，或生成失败）
						if(d.code==1)
						{
						  location.href = location.href+"&site_published=1&rand=" + Math.random();
						}
						else
						{
						  location.href = location.href+"&site_published=3&rand=" + Math.random();
							//$("#divNote").html("生成失败");
						}
					}
					else{
					   var now = new Date(); 
                       $("#divProcess").html(now.getHours()+":"+now.getMinutes()+":"+now.getSeconds()+" 我还在努力的发布中 "+(d.reqpage-1));
                       //继续请求
						submitPartial(siteId, d.reqpage, d.total);
					}
				}
			}
		},
		complete:function(){
			//alert(2);
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			$("#divNote").html(textStatus);
			$("#divNote").html(errorThrown);
		}
	});
}

submitFormSome();
</script>
</body>
</html>