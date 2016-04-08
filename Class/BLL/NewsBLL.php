<?php
/**
 * @functional 新闻表数据访问层
 * @author     liujunchen junchen168@live.cn
 * @date       2011-07-03
 * @copyright  盘石
*/
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/NewsInfo.php';

class NewsBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    //添加数据
    public function Insert(NewsInfo $objNewsInfo)
    {
        $sql = "INSERT INTO `news`(`news_title`,`news_author`,`news_remark`)VALUES('".$objNewsInfo->strNewsTitle."','".$objNewsInfo->strNewsAuthor."','".$objNewsInfo->strNewsRemark."')";        
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $this->objMysqlDB->lastInsertId();
    }
    //查询所有数据
    public function selectAll()
    {
        $sql = "SELECT * FROM `news`";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
}