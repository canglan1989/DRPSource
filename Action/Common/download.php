<?php
header("Content-Type:text/html;charset=utf-8");
require_once 'Utility.php';

$filePath = Utility::GetForm("fp",$_GET);
if($filePath == "")
    exit("文件名为空！");
    
$filePath = str_replace("\\","/",$filePath);
$aFilePame = explode("/",$filePath);
$fLength = count($aFilePame);
$filePath = "";
for($i = 0;$i<$fLength-1;$i++)
{
    if($aFilePame[$i] != "")
        $filePath .= $aFilePame[$i]."/";
}
$filePath = iconv('utf-8','gb2312',$filePath);

$fileType = Utility::GetForm("ft",$_GET);
if($fileType == "agentdoc")
{
    $filePath = "FrontFile/upload/AgentFile/".$filePath;
}

$filename = $aFilePame[$fLength-1];
$filename = iconv('utf-8','gb2312',$filename);
$portFileName = Utility::GetForm("pn",$_GET);
if($portFileName == "")
    $portFileName = $filename;
else
    $portFileName = iconv('utf-8','gb2312',$portFileName);

$arrayExt = array(
        'bmp','jpg', 'jpeg', 'bmp', 'png', 'gif',
        'xls','xlsx','docx','doc','pdf','ppt','pptx','rar','zip','csv'
);

$arrTemp = explode('.', $filename);
$strExt = strtolower(array_pop($arrTemp));
if(!in_array($strExt, $arrayExt)){
    exit("文件格式受限制");
}

$filePath = __DIR__."/../../{$filePath}{$filename}";
if (!is_file($filePath))
    exit("文件不存在");
    
$file_size=filesize($filePath);

header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
Header("Accept-Length:".$file_size);
header('Content-Disposition: attachment; filename="' . $portFileName . '"');

$file = fopen($filePath,"r");
$buffer = 1024;
$file_count = (int)($file_size/$buffer);
if($file_size%$buffer > 0)
    $file_count++;

$count = 1;
//向浏览器返回数据 
while(!feof($file)){
    $file_con = fread($file,($count == $file_count)? ($file_size%$buffer):$buffer);
    echo $file_con;
    $count++;
}
fclose($file);
?>