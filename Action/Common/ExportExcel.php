<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：Excel导出类封装
 * 创建人：wzx
 * 添加时间：2011-10-31 
 * 修改人：      修改时间：
 * 修改描述：
 * 示例：
        
        $objExcelCell = new ExcelCell("A","Num:CREATE TABLE `customer_day_temp` (
        `date_index` int(10) NOT NULL DEFAULT '0' COMMENT '数据日期序号',
        `date_text` varchar(20) NOT NULL DEFAULT '' COMMENT '数据对应日期'");
        
        $objExcelCell->iHeight = 200;
        $objExcelCell->iCrossCols = 3;
        
        $topRemark = array(
        array(),//没有内容表示空一行
        array(new ExcelCell("A", "D:/My Documents/图片/1.jpg",ExcelDataTypes::Img)),
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
        $objDataToExcel->Init("导出文件名",$arrayData,$objExcelTopColumns,$objExcelBottomColumns,$topRemark,$buttomRemark);
        //$objDataToExcel->SetDataRowHeight(50);
        $objDataToExcel->Export();
        //$objDataToExcel->Export(__DIR__ . "/../FrontFile/download");
 **/

require_once __DIR__ .'/PHPExcel.php';
require_once __DIR__ .'/PHPExcel/IOFactory.php';
require_once __DIR__ .'/PHPExcel/Writer/Excel5.php';

/**
 * Excel 中的数据类型
*/
class ExcelDataTypes
{
    /**
     * 字符
    */
    const String = 1;
    /**
     * 数字
    */
    const Double = 2;
    /**
     * 整数
    */
    const Int = 3;
    /**
     * 日期
    */
    const Date = 4;    
    /**
     * 日期时间
    */
    const DateTime = 5;
    /**
     * 图片
    */
    const Img = 6;
}

/**
 * 上表头
*/
class ExcelTopColumn
{
    public $strColumnText;
    /**
     * 以0开始
    */
    public $iStartColumn;
    
    /**
     * 上表头跨几列
    */
    public $iCrossCols;
        
    /**
     * @functional 上表头跨几列
     * @param 名称
     * @param 开始列 以0开始
     * @param 上表头跨几列
    */
    public function __construct($strColumnText, $iStartColumn, $iCrossCols)
    {
        $this->strColumnText = $strColumnText;
        $this->iStartColumn = $iStartColumn;
        $this->iCrossCols = $iCrossCols;
    }
}

/**
 * Excel 下表头（双表头时它是 下表头）
*/
class ExcelBottomColumn
{
    public $strHeaderText;
    public $strArrayIndexName;
    public $iColWidth;
    public $objColumnDataType;
    public $bSetWrapText;
    /**
     * @functional
     * @param $strHeaderText 列名
     * @param $strArrayIndexName 对应数据数组名
     * @param $objColumnDataType 数据类型
     * @param $iColWidth 列宽
    */
    public function __construct($strHeaderText,$strArrayIndexName,$objColumnDataType = ExcelDataTypes::String,$iColWidth = 0)
    {
        $this->bSetWrapText = false;
        $this->strHeaderText = $strHeaderText;
        $this->strArrayIndexName = $strArrayIndexName;
        $this->objColumnDataType = $objColumnDataType;
        $this->iColWidth = $iColWidth;
        if($this->iColWidth == 0)
        {
             switch($this->objColumnDataType)     
            {
                case ExcelDataTypes::Double:
                case ExcelDataTypes::Int:                    
                    $this->iColWidth = 12;
                break;
                case ExcelDataTypes::Date:              
                    $this->iColWidth = 15;
                break;                
                default:              
                    $this->iColWidth = 20;
                break;
            }      
        }
    }
}


/**
 * 上表头的集合
*/
class ExcelTopColumns
{
    public $objTopColumns = null;
    public function __construct()
    {
        $this->objTopColumns = array();
    }

    public function Add(ExcelTopColumn $objExcelTopColumn)
    {
        return array_push($this->objTopColumns,$objExcelTopColumn);
    }
    
    public function Column($iIndex)
    {
        return $this->objTopColumns[$iIndex];
    }
    
    public function ColumnCount()
    {
        return count($this->objTopColumns);
    }
}

/**
 * 单元格数据
*/
class ExcelCell
{
    public $strColIndex,$cellData, $objDataType,$bBold;
    /**
     * @functional
     * @param $strColIndex Excel列号  A、B、C、D、E……
     * @param $cellData 单元格中数据
     * @param $objDataType 数据类型
    */
    public function __construct($strColIndex,$cellData,$objDataType = ExcelDataTypes::String,$bBold = false)
    {        
        $this->strColIndex = strtoupper($strColIndex);
        $this->objDataType = $objDataType;
        if($objDataType == ExcelDataTypes::Date)
        {
            if(Utility::is_time($cellData))
                $cellData = Utility::getShortDate($cellData);
        }
        $this->cellData = $cellData;
        $this->bBold = $bBold;       
         
        $this->iHeight = 0;
        $this->iCrossCols = 0;
    }
    
    public $iHeight, $iCrossCols;
    
}

/**
 * 下表头的集合
*/
class ExcelBottomColumns
{
    public $objBottomColumns = null;
    public function __construct()
    {
        $this->objBottomColumns = array();
    }

    public function Add(ExcelBottomColumn $objExcelBottomColumn)
    {
        return array_push($this->objBottomColumns,$objExcelBottomColumn);
    }
    
    public function Column($iIndex)
    {
        return $this->objBottomColumns[$iIndex];
    }
    
    public function ColumnCount()
    {
        return count($this->objBottomColumns);
    }
}


/**
 * 将数据导出为Excel
*/
class DataToExcel
{
    /**
     * Excel导出 最大记录数
    */
    const max_record_count = 10000;
    
    private function GetExcelIndexTitle($iColIndex)
    {
        $strTitle = "A";
        if ($iColIndex < 0 || $iColIndex > 701)
        {
            $iColIndex = 0;
        }

        if ($iColIndex < 26)
        {
            $strTitle = chr($iColIndex + 65);
        }
        else
        {
            $iL = $iColIndex / 26 - 1;
            $iR = $iColIndex % 26;
            $strTitle = $this->GetExcelIndexTitle($iL).$this->GetExcelIndexTitle($iR);
        }

        return $strTitle;
    }

    /**
     * 导出文件名
    */
    private $strFileName;
    
    /**
     * 要导出数据的数据数组
    */
    private $arrayData;
    
    /**
     * 上表头
    */
    private $objTopColumns;
    
    /**
     * 下表头
    */
    private $objButtonColumns;
        
    /**
     * 当前行号
    */
    private $curRowIndex;
    
    /**
     * 表格上面的备注信息
    */
    private $arrayTopRemark;
    /**
     * 表格下面的备注信息
    */
    private $arrayButtomRemark;
    
    /**
     * 数据行高  0 默认高度
    */
    private $iDataRowHeight;
    /**
     * @functional 初始化
     * @param 导出表名
     * @param 表格数据
     * @param 上表头
     * @param 下表头
     * @param 表格上面的备注信息
     * @param 表格下面的备注信息
    */
    public function Init($strFileName, $arrayData, $objTopColumns,$objBottomColumns,$arrayTopRemark = null,$arrayButtomRemark = null)
    {
        $this->strFileName = $strFileName;
        $this->arrayData = $arrayData;
        $this->objTopColumns = $objTopColumns;
        $this->objButtonColumns = $objBottomColumns;
        
        $this->curRowIndex = 1;
        $this->arrayTopRemark = $arrayTopRemark;
        $this->arrayButtomRemark = $arrayButtomRemark;
        $this->iDataRowHeight = 0;
    }
    
    /**
     * 数据行高
    */
    public function SetDataRowHeight($iDataRowHeight)
    {
        $this->iDataRowHeight = $iDataRowHeight;
    }
    
    /**
     * @functional 导出Excel
    */
    public function Export($strSaveFilePath="")
    {
        $iRecordCount = count($this->arrayData);        
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);

        $objExcel = new PHPExcel();
        $objActSheet = $objExcel->getActiveSheet();   
        
        $this->WriteTopRemark($objActSheet);
        $tableTopRowIndex = $this->curRowIndex;   
        //画表头
        $this->WriteColumns($objActSheet);
        //填写数据
        $this->WriteData($objActSheet);
        $tableButtonRowIndex = $this->curRowIndex; 
        $objActSheet->getStyle('A'.$tableTopRowIndex.':'.$this->GetExcelIndexTitle($this->objButtonColumns->ColumnCount()-1)."".$tableButtonRowIndex)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $this->curRowIndex++; 
        $this->WriteButtonRemark($objActSheet);  
        
        if(empty($strSaveFilePath))
        {
            //输出到浏览器
            header("Content-type: text/html;charset=utf-8");
            header("Content-type: text/csv");
            header('Content-Disposition: attachment;filename="'.iconv("utf-8", "gb2312//IGNORE", $this->strFileName).'.xls"');
            header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
            header('Expires:0');
            header('Pragma:public');
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
            $objWriter->save('php://output');
        }
        else
        {
            $strSaveFilePath = str_replace("\\","/",$strSaveFilePath);
            if(substr($strSaveFilePath,-1,1)!="/")
                $strSaveFilePath .= "/" ;
                
            $strSaveFilePath .= $this->strFileName;
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
            $objWriter->save(iconv("utf-8", "gb2312//IGNORE", $strSaveFilePath).'.xls');
        }
    }
    
    protected function WriteTopRemark(&$objActSheet)
    {
        $this->WriteRemark($objActSheet,$this->arrayTopRemark);
    }
    
    protected function WriteButtonRemark(&$objActSheet)
    {
        $this->WriteRemark($objActSheet,$this->arrayButtomRemark);
    }
    
    protected function WriteRemark(&$objActSheet,&$arrayRemark)
    {
        if($arrayRemark == null)
            return ;
        
        $iRowCount = count($arrayRemark);
        if($iRowCount == 0)
            return ;
            
        $iExcelRowIndex = 0;
        for($i = 0;$i<$iRowCount;$i++)
        {
            $iExcelRowIndex = $this->curRowIndex + $i;
            $arrayRow = &$arrayRemark[$i];
            $cellCount = count($arrayRow);
            for($c = 0;$c<$cellCount;$c++)
            {
                $objExcelCell = &$arrayRow[$c];
                $objCurStyle = $objActSheet->getStyle($objExcelCell->strColIndex.''.$iExcelRowIndex);
                if($objExcelCell->iCrossCols > 1)
                {
                    $objActSheet->mergeCells($objExcelCell->strColIndex."".$iExcelRowIndex.':'.
                        $this->GetExcelIndexTitle(ord($objExcelCell->strColIndex)-ord("A")+$objExcelCell->iCrossCols-1)."".$iExcelRowIndex);
                }
                
                if($objExcelCell->iHeight > 0)
                {
                    $objActSheet->getRowDimension($iExcelRowIndex)->setRowHeight($objExcelCell->iHeight);
                    $objCurStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objCurStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objCurStyle->getAlignment()->setWrapText(true);
                }    
                                        
                $this->FormatStyle($objCurStyle,$objExcelCell->objDataType);                
                
                if($objExcelCell->bBold == true)
                    $objCurStyle->getFont()->setBold(true);
                    
                if($objExcelCell->objDataType == ExcelDataTypes::Img)
                {
                    $objExcelCell->cellData = iconv("utf-8", "gb2312//IGNORE", $objExcelCell->cellData);
                    if(is_file($objExcelCell->cellData))
                    {
                        $imgeSize = getimagesize($objExcelCell->cellData);
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setName('');
                        $objDrawing->setDescription('');
                        $objDrawing->setPath($objExcelCell->cellData);
                        //$objDrawing->setHeight($imgeSize[0]);
                        //$objDrawing->setWidth(120);
                        $objDrawing->setCoordinates($objExcelCell->strColIndex.''.$iExcelRowIndex);
                        $objDrawing->setWorksheet($objActSheet);
                        $objActSheet->getRowDimension($iExcelRowIndex)->setRowHeight(ceil($imgeSize[0]/1.8));
                    }
                    
                }
                else
                    $objActSheet->setCellValue($objExcelCell->strColIndex.''.$iExcelRowIndex, $objExcelCell->cellData); 
            }
        }
        
        $this->curRowIndex += $iRowCount;
    }
    
    protected function WriteColumns(&$objActSheet)
    {
        $objActSheet->setTitle($this->strFileName);
        
        $buttonColCount = $this->objButtonColumns->ColumnCount();
        $arrayBottomStartRow = array();
        for ($i = 0; $i < $buttonColCount; $i++)
            array_push($arrayBottomStartRow,$this->curRowIndex);
                
        //上表头
        if($this->objTopColumns != null)
        {            
            $colCount = $this->objTopColumns->ColumnCount();
            $objCurStyle = $objActSheet->getStyle("A".$this->curRowIndex.":".$this->GetExcelIndexTitle($buttonColCount-1)."".$this->curRowIndex+1);
            $objStyle = $objCurStyle->getAlignment();  
            $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objStyle->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            for($iColIndex=0;$iColIndex<$colCount;$iColIndex++)
            {
                $objCurColumn = $this->objTopColumns->Column($iColIndex);
                $strColIndexName = $this->GetExcelIndexTitle($objCurColumn->iStartColumn);
                $objActSheet->setCellValue($strColIndexName.''.$this->curRowIndex, $objCurColumn->strColumnText);
                if($objCurColumn->iCrossCols > 1)
                    $objActSheet->mergeCells($strColIndexName."".$this->curRowIndex.':'.$this->GetExcelIndexTitle($objCurColumn->iStartColumn+$objCurColumn->iCrossCols-1)."".$this->curRowIndex);
                
                for($i=0;$i<$objCurColumn->iCrossCols;$i++)
                {
                    $arrayBottomStartRow[$objCurColumn->iStartColumn+$i] = $this->curRowIndex + 1;
                }
            } 
            
            
            for ($i = 0; $i < $buttonColCount; $i++)
            {
                if($arrayBottomStartRow[$i] == $this->curRowIndex)
                {
                    $strColIndexName = $this->GetExcelIndexTitle($i);
                    $objActSheet->mergeCells($strColIndexName."".$this->curRowIndex.':'.$strColIndexName."".($this->curRowIndex+1));
                }
            }
                  
        }
        else
        {
            $objCurStyle = $objActSheet->getStyle("A".$this->curRowIndex.":".$this->GetExcelIndexTitle($buttonColCount-1)."".$this->curRowIndex);
            $objStyle = $objCurStyle->getAlignment();  
            $objStyle->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);            
        }
        
        //下表头 
        $arrayData = &$this->arrayData;
        $iRecordCount = count($arrayData); 
        
        for($iColIndex=0;$iColIndex<$buttonColCount;$iColIndex++)
        {
            $strColIndexName = $this->GetExcelIndexTitle($iColIndex);
            $objCurColumn = $this->objButtonColumns->Column($iColIndex);
            
            $objActSheet->setCellValue($strColIndexName.''.$arrayBottomStartRow[$iColIndex], $objCurColumn->strHeaderText); 
            $objActSheet->getColumnDimension($strColIndexName)->setWidth($objCurColumn->iColWidth);
            $objCurStyle = $objActSheet->getStyle($strColIndexName."".$arrayBottomStartRow[$iColIndex].":".$strColIndexName."".($iRecordCount+$arrayBottomStartRow[$iColIndex]));
            
            $this->FormatStyle($objCurStyle,$objCurColumn->objColumnDataType);
            if($objCurColumn->bSetWrapText == true)
            {
                $objStyle = $objCurStyle->getAlignment();
                $objStyle->setWrapText(true);
            }
            
            if($objCurColumn->objColumnDataType == ExcelDataTypes::Date)
            {
                for ($i = 0; $i < $iRecordCount; $i++)
                { 
                    $dateTime = $arrayData[$i][$objCurColumn->strArrayIndexName];
                    if(Utility::is_time($dateTime))
                        $arrayData[$i][$objCurColumn->strArrayIndexName] = Utility::getShortDate($dateTime);
                }
            }
        }
        
        //设置填充颜色  
        $objStyle = $objActSheet->getStyle('A'.$this->curRowIndex.':'.$this->GetExcelIndexTitle($buttonColCount-1).''.(($this->objTopColumns != null)?$this->curRowIndex+1:$this->curRowIndex ));
        $objStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objStyle->getFill()->getStartColor()->setARGB('FFC5D9F1');
        $objStyle->getFont()->setBold(true);
        
        if($this->objTopColumns != null)
            $this->curRowIndex += 2; 
        else
            $this->curRowIndex++;//下表头的那一行
    }
    
    /**
     * @functional 格式化成对应数据的样式
     * @param $objCurStyle 当前区域的样式
     * @param $objDataType 此列数据类型
    */
    protected function FormatStyle(&$objCurStyle,$objDataType)
    {
        //设置对齐方式
        $objStyle = $objCurStyle->getAlignment();
        if($objDataType == ExcelDataTypes::Double || $objDataType == ExcelDataTypes::Int)
            $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);           
        else
            $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
        
        //设置数据格式
        switch($objDataType)     
        {
            case ExcelDataTypes::Double:
            case ExcelDataTypes::Int: 
                $objStyle = $objCurStyle->getNumberFormat();
                if($objDataType == ExcelDataTypes::Int)
                    $objStyle->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                else
                    $objStyle->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            break;
            case ExcelDataTypes::Date:
                $objStyle = $objCurStyle->getNumberFormat();
                $objStyle->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
            break;                
            case ExcelDataTypes::DateTime:
            break;
        } 
    }
        
    
    /**
     * @functional 写数据
    */
    protected function WriteData(&$objActSheet)
    {
        $arrayData = &$this->arrayData;
        $iRecordCount = count($arrayData); 
        $colCount = $this->objButtonColumns->ColumnCount();
        $rowIndex = $this->curRowIndex;   
        if($this->iDataRowHeight > 0)
        {
            for ($i = 0; $i < $iRecordCount; $i++)
            {
                $rowIndex = $i + $this->curRowIndex;  
                $objActSheet->getRowDimension($rowIndex)->setRowHeight($this->iDataRowHeight);
            }
        }        
            
        for($iColIndex=0;$iColIndex<$colCount;$iColIndex++)
        {
            $strColIndexName = $this->GetExcelIndexTitle($iColIndex);
            $strArrayIndexName = $this->objButtonColumns->Column($iColIndex)->strArrayIndexName;
            for ($i = 0; $i < $iRecordCount; $i++)
            {
                $rowIndex = $i + $this->curRowIndex;  
                $objActSheet->setCellValue($strColIndexName."".$rowIndex, $arrayData[$i][$strArrayIndexName]);
            }
        }
        $this->curRowIndex = $rowIndex;
    }
}