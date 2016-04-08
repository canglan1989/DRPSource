<?php
/**
 * @fnuctional: 单元测试
 * @copyright:  盘石
 * @author:     wzx
 * @date:       2012-3-7
 */
require_once __DIR__ . '/../Action/Common/Utility.php';
require_once __DIR__ . '/../Action/Common/ExportExcel.php';
/*
$objExcelCell = new ExcelCell("A","Num:CREATE TABLE `customer_day_temp` (`date_index` int(10) NOT NULL DEFAULT '0' COMMENT '数据日期序号',`date_text` varchar(20) NOT NULL DEFAULT '' COMMENT '数据对应日期'");
  
  $objExcelCell->iHeight = 200;
  $objExcelCell->iCrossCols = 3;
  
  $objExcelCell2 = new ExcelCell("A", "D:/My Documents/图片/1.jpg",ExcelDataTypes::Img);
    $topRemark = array(
    array(),//没有内容表示空一行    
    array($objExcelCell),
    array($objExcelCell2),
    array()//没有内容表示空一行
    );
    
    $buttomRemark = array(
    array(),
    array(new ExcelCell("F",date("Y-m-d H:i:s")."",ExcelDataTypes::Date))
    );
        
    $arrayData = array(array("a"=>"aaa","b"=>"111","c"=>"CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC","d"=>"2001-01-01"));
    $objDataToExcel = new DataToExcel();
    $objExcelTopColumns = new ExcelTopColumns();
    $objExcelTopColumns->Add(new ExcelTopColumn("合并列1",1,2));
    $objExcelBottomColumns = new ExcelBottomColumns();
    $objExcelBottomColumns->Add(new ExcelBottomColumn("列1","a",ExcelDataTypes::String,25));
    $objExcelBottomColumns->Add(new ExcelBottomColumn("列2","b",ExcelDataTypes::Double));                
    //$objExcelBottomColumn = new ExcelBottomColumn("列3","c");        
    //$objExcelBottomColumn->bSetWrapText = true;
    //$objExcelBottomColumns->Add($objExcelBottomColumn);        
    $objExcelBottomColumns->Add(new ExcelBottomColumn("列4","d",ExcelDataTypes::Date));
    $objDataToExcel->Init("导出文件名",$arrayData,$objExcelTopColumns,$objExcelBottomColumns,$topRemark,$buttomRemark);
    //$objDataToExcel->SetDataRowHeight(50);
    $objDataToExcel->Export(__DIR__ . "/../FrontFile/download");*/
    $objExcelCell = new ExcelCell("A","Num:CREATE TABLE `customer_day_temp` (
        `date_index` int(10) NOT NULL DEFAULT '0' COMMENT '数据日期序号',
        `date_text` varchar(20) NOT NULL DEFAULT '' COMMENT '数据对应日期'");
        
        $objExcelCell->iHeight = 200;
        $objExcelCell->iCrossCols = 3;
        
        $topRemark = array(
        array(),//没有内容表示空一行
        array(new ExcelCell("A", "http://jingyan.baidu.com/z/2012qixi/images/logo.gif",ExcelDataTypes::Img)),
        array(new ExcelCell("B","Num:",ExcelDataTypes::String,true),new ExcelCell("C","1300",ExcelDataTypes::Double)),
        array($objExcelCell),array()
        );
        
        $buttomRemark = array(
        array(),
        array(new ExcelCell("F",date("Y-m-d H:i:s")."",ExcelDataTypes::Date))
        );
        
        $arrayData = array(array("a"=>"aaa","b"=>"111","c"=>"CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC","d"=>"2001-01-01"));
        $objDataToExcel = new DataToExcel();
        $objExcelTopColumns = new ExcelTopColumns();
        $objExcelTopColumns->Add(new ExcelTopColumn("合并列1",1,2));
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("列1","a",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("列2","b",ExcelDataTypes::Double));                
        //$objExcelBottomColumn = new ExcelBottomColumn("列3","c");        
        //$objExcelBottomColumn->bSetWrapText = true;
        //$objExcelBottomColumns->Add($objExcelBottomColumn);        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("列4","d",ExcelDataTypes::Date));
        $objDataToExcel->Init("导出文件名2",$arrayData,$objExcelTopColumns,$objExcelBottomColumns,$topRemark,$buttomRemark);
        //$objDataToExcel->SetDataRowHeight(50);
        //$objDataToExcel->Export();
        $objDataToExcel->Export(__DIR__ . "/../FrontFile/download");
?>