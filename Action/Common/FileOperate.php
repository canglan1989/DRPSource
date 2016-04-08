<?php

/**
 * FileOperate
 * 
 * 文件操作类
 * 
 * @package 
 * @author maxinjian
 */
class FileOperate
{

    public function __construct()
    {

    }

    /**
     * 创建多重目录文件夹,目录存在时跳过
     * 
     * @param string $dir  目录 'a/1/2/3' 
     * @return boolean 成功返回true 失败有提示  
     */
    public function createFolder($dir)
    {
        $dir = $this->formatFolder($dir);
        $dirs = explode('/',$dir);
        $temp = '';
        for ($i = 0; $i < count($dirs); $i++)
        {
            if ($dirs[$i] == "")
            {
                continue;
            }

            if (substr($dir,0,1) == '/')
            {
                $temp .= '/' . $dirs[$i] . '/';
            }
            else
            {
                $temp .= $dirs[$i] . '/';
            }
            if (!is_dir($temp))
            {
                if (!@mkdir($temp)) $this->errMsg("创建文件夹 $temp 失败！");
                // 改变目录权限 为0777
                if (!@chmod($temp,0777)) $this->errMsg("设置文件夹权限 $temp 失败！");
            }
        }
        return true;
    }

    /**
     * 创建多重目录文件夹,目录存在时跳过
     * 
     * @param string $dir  目录 'a/1/2/3' 
     * @return boolean 成功返回true 失败有提示  
     */
    public function createFolderWithPath($dir,$rootPath)
    {
        $dir = $this->formatFolder($dir);
        $dirs = explode('/',$dir);
        $temp = '';
        for ($i = 0; $i < count($dirs); $i++)
        {
            $temp .= $dirs[$i] . '/';
            if (!is_dir($rootPath . $temp))
            {
                //echo $temp;
                if (!@mkdir($rootPath . $temp)) $this->errMsg("创建文件夹 $temp 失败！");
                // 改变目录权限 为0777
                if (!@chmod($rootPath . $temp,0777)) $this->errMsg("设置文件夹权限 $temp 失败！");
            }
        }
        return true;
    }


    /**
     * 删除文件夹下所有文件和目录 
     * 
     * @param string $dir   目录
     * @param $notice 是否输出错误 true 是
     * @return boolean 成功返回true 失败返回false 参数错误时有提示
     */
    public function delFolder($dir,$notice = false)
    {
        $dir = $this->formatFolder($dir);
        //exit($dir);
        $dir = mb_convert_encoding($dir,'UTF-8','gbk');
        if (!is_dir($dir))
        {
            if ($notice) $this->errMsg("$dir 不是目录或目录不存在！");
            else  return;
        }
        //如果目录不可读，则返回
        if (!is_readable($dir))
        {
            if ($notice) $this->errMsg("目录 $dir 不可读！");
            else  return;
        }
        //打开目录
        $dirHandle = opendir($dir);
        //当目录不空时，删除目录里的文件
        while (false !== ($file = readdir($dirHandle)))
        {
            //过滤掉表示当前目录的"."和表示父目录的".."
            if ($file == '.' || $file == '..')
            {
                continue;
            }
            //为子目录，则递归调用本函数
            if (is_dir($dir . '/' . $file))
            {
                $this->delFolder($dir . '/' . $file,$notice);
            }
            else
            {
                //为文件直接删除
                $this->delFile($dir . '/' . $file,$notice);
            }
        }
        closedir($dirHandle);
        return rmdir($dir);
    }

    public function ClearFolder($dir)
    {
        $dir = $this->formatFolder($dir);
        //print_r($dir);
        if (!is_dir($dir))
        {
            $this->errMsg("$dir 不是目录或目录不存在！");
        }
        
        //如果目录不可读，则返回
        if (!is_readable($dir))
        {
            $this->errMsg("目录 $dir 不可读！");
        }
        
        $notice = false;
        //打开目录
        $dirHandle = opendir($dir);
        //当目录不空时，删除目录里的文件
        while (false !== ($file = readdir($dirHandle)))
        {
            //过滤掉表示当前目录的"."和表示父目录的".."
            if ($file == '.' || $file == '..')
            {
                continue;
            }
            //为子目录，则递归调用本函数
            if (is_dir($dir . '/' . $file))
            {
                $this->delFolder($dir . '/' . $file,$notice);
            }
            else
            {
                //为文件直接删除
                $this->delFile($dir . '/' . $file,$notice);
            }
        }
        
        closedir($dirHandle);
        return ;
    }

    /**
     * 复制文件夹下面的内容到指定目录，
     * 注意：不复制文件夹本身，只复制文件夹下面的内容
     * 
     * @param string $sourceDir 源目录
     * @param string $destDir 目标目录，不存在时，创建它
     * @param bool $overWrite 是否覆盖文件
     * @return boolean 成功返回true   参数错误时有提示 
     */
    public function copyFolder($sourceDir,$destDir,$overWrite = true)
    {
        $sourceDir = $this->formatFolder($sourceDir);
        $destDir = $this->formatFolder($destDir);
        if (!is_dir($sourceDir))
        {
            $this->errMsg('第一个参数不是目录');
            //return false;
        }
        if (!is_dir($destDir))
        {
            $this->createFolder($destDir);
        }

        $dirHandle = opendir($sourceDir);
        while (false !== ($file = readdir($dirHandle)))
        {
            if ($file == '.' || $file == '..')
            {
                continue;
            }
            if (is_dir($sourceDir . '/' . $file))
            {
                $this->copyFolder($sourceDir . '/' . $file,$destDir . '/' . $file,$overWrite);
            }
            else
            {
                $this->copyFile($sourceDir . '/' . $file,$destDir . '/' . $file,$overWrite);
            }
        }
        closedir($dirHandle);
        return true;
    }


    /**
     * 移动文件夹
     * 
     * @param string $souceDir 源目录
     * @param string $destDir 目标目录，不存在时，创建它
     * @param bool $overWrite 目标存在时，是否覆盖
     * @return boolean 成功返回true 失败返回false
     */
    public function moveFolder($sourceDir,$destDir,$overWrite = true)
    {
        $sourceDir = $this->formatFolder($sourceDir);
        $destDir = $this->formatFolder($destDir);
        if (!is_dir($sourceDir)) $this->errMsg('源目录不存在！');
        $folderName = substr($sourceDir,strrpos($sourceDir,'/'));
        $isCopy = $this->copyFolder($sourceDir,$destDir . $folderName,$overWrite);
        $isDel = $this->delFolder($sourceDir);
        if ($isCopy && $isDel) return true;
        else  return false;
    }


    /**
     * 浏览目录信息，以二维数组返回, 排序方式  主排序：先文件夹，再文件 次排序:按参数$sortType来排序
     * 
     * @param string $dir 目录
     * @param string $sortOrder 次排序字段 可以按所有文件信息的键值排序，如atime,ctime,size等等 
     * @param string $sortType  次排序类型 默认按修改时间由大到小
     * @return array 二维数组 array('filename'=>array(),'filename2'=>array()) 
     */
    public function browseFolder($dir,$sortOrder = 'mtime',$sortType = 'desc')
    {
        //如给出的目录不存在或者不是一个有效的目录，则返回
        if (!is_dir($dir))
        {
            $this->errMsg('不是有效的目录');
        }
        $dir = $this->formatFolder($dir);

        $dirHandle = opendir($dir);
        $folderInfo = array();
        while (false !== ($file = readdir($dirHandle)))
        {
            if ($file == '.' || $file == '..')
            {
                continue;
            }
            //文件信息
            $arrInfo = $this->getInfo($dir . '/' . $file);
            $folderInfo[$dir . '/' . $file] = $arrInfo;
            //取所有文件类型及自定义键
            $allOrder1[] = $arrInfo['type']; //主排序，文件类型 file or dir
            $allOrder2[] = $arrInfo[$sortOrder]; //次排序
        }
        closedir($dirHandle);

        if ($sortType = 'desc') $theType = SORT_DESC;
        else  $theType = SORT_ASC;

        array_multisort($allOrder1,SORT_ASC,SORT_REGULAR,$allOrder2,$theType,SORT_REGULAR,$folderInfo);

        return $folderInfo;

    }


    /**
     * 创建文件
     * 
     * @param string $filename 文件名
     * @param boolean $overwrite  是否覆盖
     * @return boolean 成功返回true 失败时提示
     */
    public function createFile($filename,$overwrite = true)
    {
        if (is_file($filename) && $overwrite == false)
        {
            return true;
        }
        if (!$handle = fopen($filename,'w'))
        {
            $this->errMsg("不能创建文件 $filename ！");
        }
        return true;
    }


    /**
     * 删除文件
     *
     * @param  string $filename
     * @param $notice 是否输出错误 true 是
     * @return boolean 删除成功返回true 删除失败返回false 文件不存在时提示信息
     */
    public function delFile($filename,$notice = false)
    {
        //$filename = mb_convert_encoding($filename,'UTF-8','gbk');
        $filename = $this->formatFolder($filename);
        
        /*print_r($filename."---1");*/
        if (!is_file($filename))
        {
        //print_r($filename."---2");
            if ($notice) 
                $this->errMsg('所要删除的文件不存在');
            else  
                return;
        }
        
        /**/
        if (is_readable($filename))
        {
            $objunlink =  unlink($filename);
            //print_r($filename."---".$objunlink);
            return $objunlink;
        }
        else
        {
            if ($notice) $this->errMsg('文件 $filename 不可读');
            else  return;
        }
        /*
            $objunlink = unlink($filename);
            //print_r($filename."---".$objunlink);
        return $objunlink;//unlink($filename);*/
    }

    /**
     * 复制文件，
     * 
     * @param string $souceFile 源文件
     * @param string $destFile 目标文件 
     * @param bool $overWrite 是否覆盖
     * @return 复制成功，原文件存在不覆盖和复制成功时返回true 复制失败时返回false 参数错误时提示信息
     */
    public function copyFile($souceFile,$destFile,$overWrite = true)
    {
        $souceFile = $this->formatFolder($souceFile);
        $destFile = $this->formatFolder($destFile);
        if (!is_file($souceFile))
        {
            $this->errMsg('第一个参数须为文件');
        }
        if ($overWrite == true)
        {
            return copy($souceFile,$destFile);
        }
        return true;
    }

    /**
     * 读取文件内容
     * 
     * @param string $filename 
     * @return string 文件内容
     */
    public function readFile($filename)
    {
        //if (!is_file($filename))
        //$this->errMsg('文件不存在！');
        return file_get_contents($filename);
    }

    /**
     * 写文件内容，文件的原有内容会被覆盖，文件不存在时自动创建
     * 
     * @param string $filename
     * @return void 返回添加的字符串长度
     */
    public function writeFile($filename,$content = '',$turn = true)
    {
        if ($turn) return file_put_contents($filename,stripcslashes($content));
        else  return file_put_contents($filename,$content);
    }

    /**
     * 写文件,文件不存在时，创建
     * 
     * @param string $filename
     * @param string $content 文件内容
     * @param string $mode 
     * @return 成功返回true 失败有提示信息
     */
    public function writeFileMode($filename,$content = '',$mode = 'a')
    {
        // 首先我们要确定文件存在并且可写。
        if (!is_writable($filename))
        {
            $this->errMsg("文件 $filename 不可写");
        }
        if (!$handle = fopen($filename,$mode))
        {
            $this->errMsg("不能打开文件 $filename");
        }
        // 将$content写入到打开的文件中。
        if (fwrite($handle,$content) === false)
        {
            $this->errMsg("不能写入到文件 $filename");
        }
        fclose($handle);
        return true;
    }

    
    /**
     * @function 保存文件
     * @param $path 文件保存路径
     * @return 返回0  失败
     */
    public function WriteFileTo($path,$fileName,$content)
    {        
        $mPath = "";
        if($this->createFolder($path) == true)
            $mPath = $this->formatFolder($path);
            
        $mFp = fopen($mPath . "/" . $fileName,'w');        
        if($mFp)
        {   
            if(fwrite($mFp,$content) != 0)
            {
                $objclose = fclose($mFp);
                chmod($mPath . "/" . $fileName,0777);
                return $objclose;
            }
        }
            
        return 0;
    }
    
    /**
     * 重命名文件夹或文件 ,
     * 操作文件时，如果原文件和新文件路径不同，即为移动文件
     * 
     * @param string $oldname 原文件名
     * @param string $newname 新文件名
     * @return boolean 成功返回true 失败返回false
     */
    public function renameItem($oldname,$newname)
    {
        if (!file_exists($oldname))
        {
            $this->errMsg('不是有效的目录');
        }
        if (is_dir($newname))
        {
            $this->errMsg('新目录已存在，请更换');
        }
        else
        {
            return rename($oldname,$newname);
        }
    }

    /**
     * 格式化目录路径，统一删除末尾的"/"
     * 
     * @param string $dir
     * @return
     */
    public function formatFolder($dir)
    {
        $dir = str_replace("\\","/",$dir);
        $dir = str_replace("//","/",$dir);
        //如果给定路径末尾包含"/",先将其删除
        if (substr($dir,strlen($dir)-1,1) == "/")
        {
            $dir = substr($dir,0,strlen($dir)-1);
        }
        return $dir;
    }

    /**
     * 取文件名，含后缀
     * 
     * @param string $dir 目录
     * @return string 文件名
     */
    public function getFileName($dir)
    {
        $dir = $this->formatFolder($dir);
        if (substr($dir,0,1) == '/') $dir = substr($dir,1);
        $startIndex = strrpos($dir,'/');
        if ($startIndex == false) return $dir; //不包含/时
        return substr($dir,$startIndex + 1);
    }

    /**
     * 取文件或文件夹信息，以数组形式返回
     * 
     * @param string $path 路径
     * @return array  array('key'=>'value','key'=>'value'....)
     */
    public function getInfo($path)
    {
        if (!file_exists($path)) $this->errMsg("文件或目录 $filename 不存在！");

        //路径信息
        $arrTemp = pathinfo($path);

        $arrTemp2 = stat($path);
        $arr['atime'] = $arrTemp2['atime'];
        $arr['mtime'] = $arrTemp2['mtime'];
        $arr['ctime'] = $arrTemp2['ctime'];
        $arr['size'] = filesize($path);
        $arr['type'] = filetype($path);
        $arr['realpath'] = realpath($path);

        //连接数组,使它具体所有文件信息
        return array_merge($arrTemp,$arr);
    }


    /**
     * 显示错误信息
     * 
     * @param string $msg
     * @return void
     */
    public function errMsg($msg)
    {
        die($msg);
    }

    public function __destruct()
    {

    }

}

?>