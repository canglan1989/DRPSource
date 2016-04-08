<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：创建 csv 文件
 * 创建人：wzx
 * 添加时间：2011-12-09
 * 修改人：      修改时间：
 * 修改描述：
 *      $objCreateCSV = new CreateCSV();      
        $objCreateCSV->SetFileName($this->objCustomerDataDownloadInfo->strDownloadName);
        $objCreateCSV->SetContent($aHead,$this->arrayCMData);
        //$objCreateCSV->WriteFileTo(__DIR__."\..\..\FrontFile\download\customerinfo\\");
        $objCreateCSV->ExportCSV();// js window.open()
 **/
 
require_once __DIR__ . '/FileOperate.php';

class CreateCSV
{    
    var $mFileName; //文件名  
    var $mSpace = ','; //分隔字符
    var $mContent; //内容

    public function __construct()
    {
        $this->mFileName = time()."".rand(1,2000).".csv";
        $this->mContent = array();
    }

    /**
    *  @param $name 文件名
    */
    public function SetFileName($name)
    {
        $this->mFileName = mb_convert_encoding($name,"gbk","UTF-8");
    } 

    /**
    * @param   array $head   头 一维 （内容数组下标 => 列名）
    * @param   array  $body   内容 二维
    */
    public function SetContent($head,$body)
    { 
        $mHead = array();
        foreach($head as $key => $value)
        {
            array_push($mHead,mb_convert_encoding($value,"gbk","UTF-8"));
        }   
        
        array_push($this->mContent,$mHead);        
        $mHead = null;
        
        $mBody = null;
        foreach ($body as $k => $v)
        { 
            $mBody = array();
            foreach($head as $key => $value)
            {
                array_push($mBody,mb_convert_encoding($v[$key],"gbk","UTF-8"));
            }
            
            array_push($this->mContent,$mBody);  
            $mBody = null;
        }
        
    }
        
    /**
     * @function 保存文件
     * @param $path 文件保存路径
     * @return 返回0  失败
     */
    public function WriteFileTo($path)
    {   
        $objFileOperate = new FileOperate();
        
        $mPath = "";
        if($objFileOperate->createFolder($path) == true)
            $mPath = $objFileOperate->formatFolder($path);
            
        $mFp = fopen($mPath . "/" . $this->mFileName . ".csv",'w');        
        if($mFp)
        {                 
            foreach($this->mContent as $key => $value)
            {
                fputcsv($mFp, $value);
            }
        
            $objclose = fclose($mFp);
            chmod($mPath . "/" . $this->mFileName . ".csv",0777);
            return $objclose;
        }
            
        return 0;
    }
    
    /**
     * @function 从页面中导出
    */
    public function ExportCSV()
    {
        header('Content-Type: application/vnd.ms-excel');
       	header('Content-Disposition: attachment;filename="'.$this->mFileName.'.csv"');
        header('Cache-Control: max-age=0');
        $mFp = fopen('php://output', 'w');    
        foreach($this->mContent as $key => $value)
        {
            fputcsv($mFp, $value);
        }
        fclose($mFp);
        exit();
    }    
}
?>