<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：文件上传模块
 * 创建人：wzx
 * 添加时间：2011-8-29 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once 'FileOperate.php';
/**
 * 上传文件形式枚举
 */
class UploadFileType{
    const ImageAndFile = 0;
    const Image = 1;
    const File = 2;
}

class UploadFile
{
    public function __construct()
    {
    }
     
    public function Index()
    {
    }
    
    /**
     * 获取文件类型
     * @param type $arrType
     * @return type 
     */
    private static function getTypeAndExt($iType){
        switch($iType){
            case 0:return array(
                'type'=> array_merge(self::$_ImageType , self::$_FileType),
                'ext'=>  array_merge(self::$_ImageExt , self::$_FileExt)
            );
            case 1:return array(
                'type'=>self::$_ImageType,
                'ext'=>self::$_ImageExt
            );
            case 2:return array(
                'type'=>  self::$_FileType,
                'ext'=>self::$_FileExt
            );
            default : return false;
        }
    }
    
    /**
     * 图片类 文件类型
     * @var type 
     */
    public static $_ImageType = array(
        'image/png', 'image/gif', 'image/jpeg', 'image/bmp', 'image/pjpeg', 'image/x-png'
    );
    
    /**
     * 文件类 文件类型
     * @var type 
     */
    public static  $_FileType = array(
        'application/x-xls','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/ms-excel','text/plain',//excel
            'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.openxmlformats-officedocument.wordprocessingml.document',//word
            'application/pdf','>application/octet-stream',          //PDF
            'application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation'         //PPT
            //RAR
    );
    
    /**
     * 图片类 后缀名
     * @var type 
     */
    public static $_ImageExt = array(
        'bmp','jpg', 'jpeg', 'bmp', 'png', 'gif'
    );
    
    /**
     * 文件类 后缀名
     * @var type 
     */
    public static $_FileExt = array(
        'xls','xlsx','docx','doc','pdf','ppt','pptx','rar','zip','csv'
    );

    public static function VerifyExt($FilePath,$arrExt){
        $arrTemp = explode('.', $FilePath);
        $strExt = array_pop($arrTemp);
        if(!in_array(strtolower($strExt), $arrExt)){
            die("文件的格式受限制");
        }
    }
    
    
    /**
     * @functional 上传JPG文件
    */
    public static function UploadJPGImg($filePath,$uploadPath,&$strFileName,$fileMaxSize = 3145728) //3M
    {       
        $strFileName = "";//成功后返回的文件名
        if($filePath == "" || $uploadPath == "")
            return "未找到相应文件！";
            
        if (!is_dir($uploadPath))//目录是否存在
        {
            mkdir($uploadPath, 0777);
        }
        
        $upfile = $_FILES["$filePath"];
        $fileType = $upfile["type"];
        
        if($fileType != "image/jpeg" && $fileType != "image/pjpeg" && $fileType != "image/bmp"
            && $fileType != "image/png" && $fileType != "image/x-png")
        {
            return "文件格式不正确！";
        }     
        
        $size = $upfile["size"];
        
        if($size > $fileMaxSize)
        {
            return "文件大小超过限制！"; 
        }
                           
        if (is_uploaded_file($_FILES["$filePath"]['tmp_name']))
        {
            $fileName = $upfile["name"];
            if(strstr($fileName,".") != false)
            {                
                $fileName = explode(".",$fileName);
                $fileExt = $fileName[count($fileName)-1];
                $fileExt = trim($fileExt);
                $fileExt = strtolower($fileExt);
                $fileName = md5("drp_".date('YmdHis').mt_rand(1,99999)).".".$fileExt;//$fileName[0]."_".$time.".".$fileName[1];
            }
            else
            {
                $fileName = md5("drp_".date('YmdHis').mt_rand(1,99999));
            }
            
            $error = $upfile['error'];
            if($error > 0)
            {
                return "".$error;
            }
            else
            {
                if(!move_uploaded_file($upfile["tmp_name"],iconv("UTF-8","gb2312",$uploadPath.$fileName)))
                    return "文件上传出错";
                    
        	    $strFileName = $fileName;
                return "";
            }
        }
        
        return "未找到相应文件！";
    }
    
      /**
     *文件下载
     * @param type $fileurl 
     */
    public static function downloadFile($fileurl,$newname=''){
        $arr = explode('/', $fileurl);
        
        $fLength = count($arr);
        $fileurl = "";
        for($i = 0;$i<$fLength-1;$i++)
        {
            if($arr[$i] != "")
                $fileurl .= $arr[$i]."/";
        }
        
        $fileurl .= $arr[$fLength-1];
        
        if(empty ($newname)){
            $filename = end($arr);
        }else{
            $filename= $newname;
        }
        
        $arrImgExt = array_merge(self::$_ImageExt , self::$_FileExt);        
        self::VerifyExt($fileurl,$arrImgExt);
        
        $content = file_get_contents($fileurl);
        if($content==false){
            exit(array('success'=>false,'msg'=>'文件找不到'));
        }
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-Disposition:attachment;filename=".mb_convert_encoding($filename,'gbk','utf8'));
        echo $content;
        exit;
    }
    
    /**
     * 上传文件
     * @param type $iInputFileID 上传DOM元素name
     * @param type $iType 上传类型（文件，图片，both）
     * @param type $dir 存储的地址
     * @param type $maxFileSize  最大上传文件大小(单位:MB)
     */
    public static function FileUpload($iInputFileID,$iType = UploadFileType::Image,$dir='FrontFile/upload/',$maxFileSize = 3)
    {
        $arrTypeList = self::getTypeAndExt($iType);
        
        if(!$arrTypeList){
            Utility::Msg("文件类型指定出错");
        }
        
        $arrImgType = $arrTypeList['type'];
        $arrImgExt = $arrTypeList['ext'];
        
        $upfile = $_FILES[$iInputFileID];
        $name = $upfile['name'];
        $type = $upfile['type'];
        $size = $upfile['size'];
        $error = $upfile['error'];
        
        if($error > 0)
        {
            switch($error) 
            {
                case 1:
                    Utility::Msg('上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值');
                break;
                case 2:
                    Utility::Msg('上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值');
                break;
                case 3:
                    Utility::Msg('文件只有部分被上传');
                break;
                case 4:
                    Utility::Msg('没有文件被上传');
                break;
            } 
        }
        
        if ($size == 0)
        {
            Utility::Msg('请选择要上传的文件！');
        }
        if (!in_array($type, $arrImgType))
        {
            Utility::Msg("上传的文件格式不正确!");
        }
        
        if ($size > $maxFileSize * 1024 * 1024)//3M
        {
            Utility::Msg("上传的文件大小超过限制！");
        }
        
        $tempArr = explode(".", $name);
        $fileExt = array_pop($tempArr);
        $fileExt = trim($fileExt);
        $fileExt = strtolower($fileExt);
        
        if(!in_array($fileExt, $arrImgExt)){
            Utility::Msg("上传的文件后缀名不正确!");
        }
        
        if (!file_exists($dir))
        {
            $objFileOperate = new FileOperate();
            $objFileOperate->createFolder($dir);
        }
        
        if (is_uploaded_file($_FILES[$iInputFileID]['tmp_name']))
        {
            if ($error > 0)
            {
                Utility::Msg("文件上传失败！请重新上传！");
            }
            else
            {
                $newName = md5("drp_".date('YmdHis') . mt_rand(1000, 9999)) . "." . $fileExt;
                $tmp_name = $upfile["tmp_name"];
                if(!move_uploaded_file($tmp_name, $dir . $newName))
                {
                    Utility::Msg("复制文件失败，请重新上传");
                }
                
                Utility::Msg($newName, true);
            }
        }
    
    }
}
?>