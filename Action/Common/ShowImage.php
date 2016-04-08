<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：显示图片
 * 创建人：wzx
 * 添加时间：2012-3-20 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/Utility.php';
class ShowImage
{    
    public function __construct()
    {
    }
    
    public static function Show($fileName)
    {   /*             
        if(!defined("SYS_CONFIG"))
        {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
        */
        $arrSysConfig = unserialize(SYS_CONFIG);
        $arrayServerDoamin = $arrSysConfig["ServerDomain".$arrSysConfig['SYS_EVN']];
        
        $b = false;
        foreach($arrayServerDoamin as $value)
        {
            if($value == "" || preg_match($value, $_SERVER['HTTP_HOST']))//
            {        
                $b = true;
                break;
            }
        }
        
        $filePath = "";
        //$filePath = Utility::GetForm("filePath", $_GET);
        //$fileName = Utility::GetForm("fileName", $_GET);
        if($b == false || $fileName == "")
        {
            $fileName = "FrontFile/img/fzyj_pic.jpg";//如果不是允许的域名,则返回盗链提示图片.    
        }
        /*
        if($filePath != "")
        {
            $filePath = strtoupper($filePath);
            $filePath = $arrSysConfig[$filePath];
        }
        */
        $filePath = __DIR__."/../../".$filePath;
        
        // 输入文件标签   
        $file = fopen($filePath . $fileName,"r");   
        Header("Content-type: application/octet-stream");   
        Header("Accept-Ranges: bytes");   
        Header("Accept-Length: ".filesize($filePath . $fileName));   
        $ext = array_pop(explode(".",$fileName)); 
        Header("Content-Disposition: attachment; filename=img." . $ext);   
        // 输出文件内容   
        echo fread($file,filesize($filePath . $fileName));   
        fclose($file);
        exit;
    }
    
}
