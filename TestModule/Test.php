<?php

$str ="%E6%9C%AC%E6%AC%A1%E4%B8%BB%E8%A6%81%E8%B7%9F%E7%8E%8B%E6%80%BB%E4%BB%8B%E7%BB%8D%E4%BA%86%E7%9B%98%E7%9F%B3%E5%85%AC%E5%8F%B8%E9%83%91%E5%B7%9E%E8%BF%9B%E8%A1%8C%E7%9A%84%E6%9C%AA%E6%9D%A5%E9%A2%86%E8%A2%96%E5%9F%B9%E8%AE%AD%E5%8F%8A%E4%BB%8A%E5%90%8E%E7%9A%84%E6%89%B6%E6%8C%81%E8%AE%A1%E5%88%92%EF";
$str = urldecode("单元测试");
exit($str);


$arrUpdateData = array("a"=>"aa",
"b"=>"bb",
"c"=>"cc",
"d"=>"dd"
);
            exit(implode(',', $arrUpdateData));
$arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            exit($strSetField);


$msg = '\u5bc6\u7801\u592a\u7b80\u5355\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165\u3002\u8bd5\u8bd5\u5b57\u6bcd\uff0c\u6570\u5b57\u548c\u6807\u70b9\u6df7\u5408\u3002';



/*
    字符串GBK转码为UTF-8，数字转换为数字。
*/
function ct2($s){
    if(is_numeric($s)) {
        return intval($s);
    } else {
        return iconv("GBK","UTF-8",$s);
    }
}
/*
    批量处理gbk->utf-8
*/
function icon_to_utf8($s) {

  if(is_array($s)) {
    foreach($s as $key => $val) {
      $s[$key] = icon_to_utf8($val);
    }
  } else {
      $s = ct2($s);
  }
  return $s;

}

$str= preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $msg);
echo $str;
exit();
/*
exit(substr("123456",-1,1));

$time = date('Y|m|d|H',time());
$s = date("i",time());
echo $s;
echo "<br/>";
$s = floor($s/5)*5;
if($s<10)
    $s = "0".$s;
echo $s;
echo "<br/>";
$time = md5($time."|".$s."|"."oAccount");
echo $time;
echo "<br/>";

$time = strrev(substr($time,0,4)).strrev(substr($time,4));
 
echo $time;
echo "<br/>";

        $time = date('Y|m|d|H',time());
        $s = date("i",time());
        $s = floor($s/5)*5;
        if($s<10)
            $s = "0".$s;
            
        $md5Code = md5($time."|".$s."|"."oAccount");
        echo strrev(substr($md5Code,0,4)).strrev(substr($md5Code,4));
    exit(); 
exit("");*/
/**
 * @fnuctional: 单元测试
 * @copyright:  盘石
 * @author:     linxishengjiong@163.com
 * @date:       2011-10-14
 */
require_once __DIR__ . '/../Class/BLL/TMEMailBLL.php';
require_once __DIR__ . '/../Class/BLL/TMNetOpeBLL.php';
require_once __DIR__ . '/../Class/BLL/AgentPactBLL.php';
require_once __DIR__ . '/../Run/PactEffective.php';
if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
//测试代码
$test = new Test();
$test->JCLtest();

class Test
{   
    public function TestShowArray()
    {
        $ary = array("name" => "林希胜", "sex" => "男人", "age" => "26");
        $rtn = "";
        foreach ($ary as $key => $value) {
            $rtn .= $key . ":" . $value . "|";
        }
        $rtn = rtrim($rtn, "|");
        var_dump($rtn);
    }
    //创建代理商子管理员账号
    public function CreateSubAccount()
    {
        $agentID = "24";
        $tMNetOpeBLL = new TMNetOpeBLL();
        $rtn = $tMNetOpeBLL->CreateSubAccount($agentID);
        var_dump($rtn); 
        exit;
    }
    public function GetModelManageUrl()
    {
        $agentID = "9";
        $account = "submanage_9616";
        $tMNetOpeBLL = new TMNetOpeBLL();
        $url = $tMNetOpeBLL->GetModelManageUrl($agentID, $account);
        var_dump($url);
        exit;
    }
    public function getThis()
    {
        $a = date('g:i:s a');
        $b = 15*15;
        $c = date('g:i:s a');
        $d = $c-$a;
        echo($d);
    }
    public function ConfirmInfo()
    {
        $tMEMailBLL = new TMEMailBLL();
        $tMEMailBLL->ConfirmInfo(61, 20590, "www.baidu.com.com.com01");
    }
    public function JCLtest()
    {
        $PactEffective = new PactEffective();
        $PactEffective->PactEffectiveFail();
    }
    public function JCLtest1()
    {
    $objAgentPact = new AgentPactBLL();
    $pact_number = 'JP2011123029544';
    $aid = '2';
    $objAgentPact->changePactStatus($pact_number,$aid);
    }
}
?>
