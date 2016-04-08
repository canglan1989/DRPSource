<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_model_group的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-9 17:48:51
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ModelGroupInfo.php';
require_once __DIR__.'/../Model/ModelInfo.php';
require_once __DIR__.'/../Model/ModelRightInfo.php';
require_once __DIR__.'/ModelBLL.php';

class ModelGroupBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param ModelGroupInfo $objModelGroupInfo  ModelGroup实例
     * @return 
     */
	public function insert(ModelGroupInfo $objModelGroupInfo)
	{
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
		$sql = "INSERT INTO `sys_model_group`(`mgroup_no`,`mgroup_name`,`mgroup_code`,`mgroup_remark`,`sort_index`,`is_agent`,`product_type_ids`,`is_lock`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`)"
		." values('".$objModelGroupInfo->strMgroupNo."','".$objModelGroupInfo->strMgroupName."','".$objModelGroupInfo->strMgroupCode."','".$objModelGroupInfo->strMgroupRemark."',".$objModelGroupInfo->iSortIndex.",".$objModelGroupInfo->iIsAgent.",'".$objModelGroupInfo->strProductTypeIds."',".$objModelGroupInfo->iIsLock.",".$objModelGroupInfo->iIsDel.",".$objModelGroupInfo->iCreateUid.",now(),".$objModelGroupInfo->iUpdateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param ModelGroupInfo $objModelGroupInfo  ModelGroup实例
     * @return
     */
	public function updateByID(ModelGroupInfo $objModelGroupInfo)
	{
		$sql = "update `sys_model_group` set `mgroup_no`='".$objModelGroupInfo->strMgroupNo."',`mgroup_name`='".$objModelGroupInfo->strMgroupName."',`mgroup_code`='".$objModelGroupInfo->strMgroupCode."',`mgroup_remark`='".$objModelGroupInfo->strMgroupRemark."',`sort_index`=".$objModelGroupInfo->iSortIndex.",`is_agent`=".$objModelGroupInfo->iIsAgent.",`product_type_ids`='".$objModelGroupInfo->strProductTypeIds."',`is_lock`=".$objModelGroupInfo->iIsLock.",`is_del`=".$objModelGroupInfo->iIsDel.",`update_uid`=".$objModelGroupInfo->iUpdateUid.",`update_time`= now() where mgroup_id=".$objModelGroupInfo->iMgroupId;
        
        $iUpdateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($iUpdateCount > 0)
        {
            $objModelBLL = new ModelBLL();
            $objModelBLL->UpdateFullPath();//这里 包含 清除菜单的缓存 的方法
        }
        return $iUpdateCount;
	}
    
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
		$sql = "update `sys_model_group` set is_del=1,update_uid=".$userID.",update_time=now() where mgroup_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
	
	/**
     * @functional 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
				
	/**
     * @functional 返回TOP数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
	 * @param string $sGroup group  by 关键字的分组
	 * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_ModelGroup::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_model_group` ".$sWhere.$sGroup.$sOrder.$sLimit ;
                
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_model_group对象
	 * @param int $id 
     * @return sys_model_group对象
     */
	public function getModelByID($id)
	{
		$objModelGroupInfo = null;
		$arrayInfo = $this->select("*","mgroup_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objModelGroupInfo = new ModelGroupInfo();
			$objModelGroupInfo->iMgroupId = $arrayInfo[0]['mgroup_id'];
			$objModelGroupInfo->strMgroupNo = $arrayInfo[0]['mgroup_no'];
			$objModelGroupInfo->strMgroupName = $arrayInfo[0]['mgroup_name'];
			$objModelGroupInfo->strMgroupCode = $arrayInfo[0]['mgroup_code'];
			$objModelGroupInfo->strMgroupRemark = $arrayInfo[0]['mgroup_remark'];
			$objModelGroupInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objModelGroupInfo->iIsAgent = $arrayInfo[0]['is_agent'];
			$objModelGroupInfo->strProductTypeIds = $arrayInfo[0]['product_type_ids'];
			$objModelGroupInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objModelGroupInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objModelGroupInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objModelGroupInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objModelGroupInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objModelGroupInfo->strUpdateTime = $arrayInfo[0]['update_time'];
		
			settype($objModelGroupInfo->iMgroupId,"integer");
			settype($objModelGroupInfo->iSortIndex,"integer");
			settype($objModelGroupInfo->iIsAgent,"integer");			
			settype($objModelGroupInfo->iIsLock,"integer");
			settype($objModelGroupInfo->iIsDel,"integer");
			settype($objModelGroupInfo->iCreateUid,"integer");
			settype($objModelGroupInfo->iUpdateUid,"integer");            
		}
		
		return $objModelGroupInfo;
	}
	    
    
     /**
     * 取得根模块组
	 * @param int $iIsAgent 是否为前台模块 1 是 0否 
     */
    public function GetRootModelGroup($iIsAgent)
    {
       $objModelGroup = new ModelGroupBLL();
       $sWhere = "length(mgroup_no)=2 and is_agent=".$iIsAgent;
       return $objModelGroup->select(T_ModelGroup::mgroup_no.",".T_ModelGroup::mgroup_name,$sWhere,"sort_index");
    }
    
	/**
     * @function 模块列表
     */
    public function ModelList($sWhere)
    {
        if($sWhere != "")
            $sWhere = " and $sWhere";
            
        $sql = "select `mgroup_id`,`mgroup_no`,`mgroup_code`,`mgroup_name`,`mgroup_remark`,
        `is_agent`,`is_lock`,`sort_index`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`,rootModel 
        from(
            SELECT `mgroup_id`,`mgroup_no`,`mgroup_code`,`mgroup_name`,`mgroup_remark`,
            `is_agent`,`is_lock`,`sort_index`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`,
            if(length(mgroup_no)>2,0,1) as rootModel,if(length(mgroup_no)>2,
            concat(left(mgroup_no,2),`sort_index`),left(mgroup_no,2)) as rIndex FROM `sys_model_group` 
            where is_del=0 $sWhere 
        )t order by rIndex,mgroup_name";
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    }
    
	/**
     * @function 此菜单关联的签约产品
     * @param 模块字段里的 product_type_ids 数据
     */
    public function GetProductTypes($product_type_ids)
    {
        $sql = "SELECT `sys_product_type`.`aid`, `sys_product_type`.`product_type_name`,
          if('".$product_type_ids."' like concat('%,',`sys_product_type`.`aid`,',%'),1,0) as is_check 
        FROM
            `sys_product_type` where `sys_product_type`.`is_del`=0 order by `sort_index`";
           
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }    
    
        
    public function LockModel($id,$updateUid)
    {
        $sql = "update `sys_model_group` set `is_lock` = if(`is_lock`=1,0,1),`update_uid`=".$updateUid
        .", `update_time`=now() where `mgroup_id`=".$id;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    
    /**
     * @functional 权限数据同步
    */
    public function SynchronousGroup($updateUid)
    {        
        
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
        
        //从开发库里查出数据
        //取配置
        $arrSysConfig = unserialize(SYS_CONFIG);
        $objServerInfoDev = new MySqlServerInfo();
        $sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");
        if($sys_evn == 0)
            return 0;
            
        $DBCONFIG0 = $arrSysConfig["DBCONFIG0"];            
        $objServerInfoDev->strDBHost = $DBCONFIG0['DBHOST'];
        $objServerInfoDev->strDBPort = $DBCONFIG0['DBPORT'];
        $objServerInfoDev->strDBUser = $DBCONFIG0['DBUSER'];
        $objServerInfoDev->strDBPwd = $DBCONFIG0['DBPWD'];
        $objServerInfoDev->strDBName = $DBCONFIG0['DBNAME'];
        $objServerInfoDev->strDBCharset = $DBCONFIG0['DBCHARSET'];
        
        $objMysqlDevDB = new PDO("mysql:host=$objServerInfoDev->strDBHost;port=$objServerInfoDev->strDBPort;dbname=$objServerInfoDev->strDBName",
        $objServerInfoDev->strDBUser, $objServerInfoDev->strDBPwd, array(PDO::ATTR_PERSISTENT => false));

        $objMysqlDevDB->exec("SET NAMES $objServerInfoDev->strDBCharset"); //设置连接字符集
        
            
        //模块组
        $sql = "select ".T_ModelGroup::AllFields." from `sys_model_group` order by `mgroup_id`";
        $arrayDevData = $objMysqlDevDB->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $arrayDevLength = count($arrayDevData);
        $arrayLength = count($arrayData);
        $updateSql = "";
        $updateCount = 0;
        for($i =0;$i<$arrayDevLength;$i++)
        {
            if($arrayLength<=$i)
            {
                $updateSql .= "insert into sys_model_group( `mgroup_id`, `mgroup_no`,`mgroup_name`, `mgroup_code`,
                `mgroup_remark`, `sort_index`,`is_agent`, `product_type_ids`,`is_lock`, `is_del`,`create_uid`) values(".
                $arrayDevData[$i]["mgroup_id"].",'".$arrayDevData[$i]["mgroup_no"]."','".$arrayDevData[$i]["mgroup_name"]."'
                ,'".$arrayDevData[$i]["mgroup_code"]."','".$arrayDevData[$i]["mgroup_remark"]."',".$arrayDevData[$i]["sort_index"]."
                ,".$arrayDevData[$i]["is_agent"].",'".$arrayDevData[$i]["product_type_ids"]."',".$arrayDevData[$i]["is_lock"]."
                ,".$arrayDevData[$i]["is_del"].",".$updateUid.");";
                
                $updateCount++;
            }
            else
            {
                if($arrayDevData[$i]["mgroup_id"] != $arrayData[$i]["mgroup_id"] 
                || $arrayDevData[$i]["mgroup_no"] != $arrayData[$i]["mgroup_no"]
                || $arrayDevData[$i]["mgroup_name"] != $arrayData[$i]["mgroup_name"]
                || $arrayDevData[$i]["mgroup_code"] != $arrayData[$i]["mgroup_code"]
                || $arrayDevData[$i]["mgroup_remark"] != $arrayData[$i]["mgroup_remark"]
                || $arrayDevData[$i]["sort_index"] != $arrayData[$i]["sort_index"]
                || $arrayDevData[$i]["product_type_ids"] != $arrayData[$i]["product_type_ids"]
                || $arrayDevData[$i]["is_del"] != $arrayData[$i]["is_del"])
                {
                    $updateSql .= "update sys_model_group set `mgroup_id`=".$arrayDevData[$i]["mgroup_id"]
                    .", `mgroup_no`='".$arrayDevData[$i]["mgroup_no"]."',`mgroup_name`='".$arrayDevData[$i]["mgroup_name"]
                    ."', `mgroup_code`='".$arrayDevData[$i]["mgroup_code"]."',`mgroup_remark`='".$arrayDevData[$i]["mgroup_remark"]
                    ."', `sort_index`=".$arrayDevData[$i]["sort_index"].",`is_agent`=".$arrayDevData[$i]["is_agent"]
                    .", `product_type_ids`='".$arrayDevData[$i]["product_type_ids"]."',`is_lock`=".$arrayDevData[$i]["is_lock"]
                    .", `is_del`=".$arrayDevData[$i]["is_del"].",`update_uid`=".$updateUid." where mgroup_id=".$arrayData[$i]["mgroup_id"]." ;";
                    
                    $updateCount++;
                }
            }
            
            if($updateCount >= 20)
            {
                $this->objMysqlDB->executeNonQuery(false,$updateSql,null);
                $updateSql = "";
                $updateCount = 0;
            }
        }
        
        //print_r($arrayDevData);
        //print_r($updateSql);
        
        if($updateSql != "")
            $updateCount += $this->objMysqlDB->executeNonQuery(false,$updateSql,null);
          
        //模块
        $sql = "select ".T_Model::AllFields." from `sys_model` order by `model_id`";
        $arrayDevData = $objMysqlDevDB->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $arrayDevLength = count($arrayDevData);
        $arrayLength = count($arrayData);
        $updateSql = "";
        $updateCount = 0;
        for($i =0;$i<$arrayDevLength;$i++)
        {
            if($arrayLength<=$i)
            {
                $updateSql .= "insert into sys_model(`model_id`, `mgroup_id`, `model_code`,  `model_name`, `model_page`,
            `model_remark`, `show_name`,`model_path`, `sort_index`,`product_type_ids`, `is_agent`, `is_lock`, `is_menu`,  `is_del`, `create_uid`) values(".
                $arrayDevData[$i]["model_id"].",".$arrayDevData[$i]["mgroup_id"].",'".$arrayDevData[$i]["model_code"]."'
                ,'".$arrayDevData[$i]["model_name"]."','".$arrayDevData[$i]["model_page"]."','".$arrayDevData[$i]["model_remark"]."'
                ,'".$arrayDevData[$i]["show_name"]."','".$arrayDevData[$i]["model_path"]."',".$arrayDevData[$i]["sort_index"].",'".$arrayDevData[$i]["product_type_ids"]."',".$arrayDevData[$i]["is_agent"]."
                ,".$arrayDevData[$i]["is_lock"].",".$arrayDevData[$i]["is_menu"].",".$arrayDevData[$i]["is_del"].",".$updateUid.");";
                    $updateCount++;
            }
            else
            {
                if($arrayDevData[$i]["model_id"] != $arrayData[$i]["model_id"] 
                || $arrayDevData[$i]["mgroup_id"] != $arrayData[$i]["mgroup_id"]
                || $arrayDevData[$i]["model_code"] != $arrayData[$i]["model_code"]
                || $arrayDevData[$i]["model_name"] != $arrayData[$i]["model_name"]
                || $arrayDevData[$i]["model_page"] != $arrayData[$i]["model_page"]
                || $arrayDevData[$i]["model_remark"] != $arrayData[$i]["model_remark"]
                || $arrayDevData[$i]["show_name"] != $arrayData[$i]["show_name"]
                || $arrayDevData[$i]["sort_index"] != $arrayData[$i]["sort_index"]
                || $arrayDevData[$i]["product_type_ids"] != $arrayData[$i]["product_type_ids"]
                || $arrayDevData[$i]["is_menu"] != $arrayData[$i]["is_menu"]
                || $arrayDevData[$i]["is_del"] != $arrayData[$i]["is_del"])
                {
                    $updateSql .= "update sys_model set `model_id`=".$arrayDevData[$i]["model_id"]
                    .", `mgroup_id`=".$arrayDevData[$i]["mgroup_id"].", `model_code`='".$arrayDevData[$i]["model_code"]
                    ."',  `model_name`='".$arrayDevData[$i]["model_name"]."', `model_page`='".$arrayDevData[$i]["model_page"]."',
                    `model_remark`='".$arrayDevData[$i]["model_remark"]."', `show_name`='".$arrayDevData[$i]["show_name"]
                    ."',model_path= '".$arrayDevData[$i]["model_path"]."', `sort_index`=".$arrayDevData[$i]["sort_index"].",  `is_agent`=".$arrayDevData[$i]["is_agent"]
                    .", `product_type_ids`='".$arrayDevData[$i]["product_type_ids"]."', `is_lock`=".$arrayDevData[$i]["is_lock"].", `is_menu`=".$arrayDevData[$i]["is_menu"]."
                    ,  `is_del`=".$arrayDevData[$i]["is_del"].",`update_uid`=".$updateUid." where model_id=".$arrayData[$i]["model_id"]." ;";
                    $updateCount++;
                }
            }
            
            
            if($updateCount >= 20)
            {
                $this->objMysqlDB->executeNonQuery(false,$updateSql,null);
                $updateSql = "";
                $updateCount = 0;
            }
        }
        
        //print_r($arrayDevData);
        //print_r($updateSql);
        if($updateSql != "")
            $updateCount += $this->objMysqlDB->executeNonQuery(false,$updateSql,null);
          
        //模块权限
        $sql = "select ".T_ModelRight::AllFields." from `sys_model_right` order by `right_id`";
        $arrayDevData = $objMysqlDevDB->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $arrayDevLength = count($arrayDevData);
        $arrayLength = count($arrayData);
        $updateSql = "";
        $updateCount = 0;
        for($i =0;$i<$arrayDevLength;$i++)
        {
            if($arrayLength<=$i)
            {
                $updateSql .= "insert into sys_model_right(`right_id`, `model_id`,  `right_name`, `right_value`,  `right_remark`,
                 `is_lock`,  `is_del`, `create_uid`) values(".
                $arrayDevData[$i]["right_id"].",".$arrayDevData[$i]["model_id"].",'".$arrayDevData[$i]["right_name"]."'
                ,".$arrayDevData[$i]["right_value"].",'".$arrayDevData[$i]["right_remark"]."',
                ".$arrayDevData[$i]["is_lock"].",".$arrayDevData[$i]["is_del"].",".$updateUid.");";
                    $updateCount++;
            }
            else
            {
                if($arrayDevData[$i]["right_id"] != $arrayData[$i]["right_id"] 
                || $arrayDevData[$i]["model_id"] != $arrayData[$i]["model_id"]
                || $arrayDevData[$i]["right_name"] != $arrayData[$i]["right_name"]
                || $arrayDevData[$i]["right_value"] != $arrayData[$i]["right_value"]
                || $arrayDevData[$i]["right_remark"] != $arrayData[$i]["right_remark"]
                || $arrayDevData[$i]["is_del"] != $arrayData[$i]["is_del"])
                {
                    $updateSql .= "update sys_model_right set `right_id`=".$arrayDevData[$i]["right_id"].", `model_id`=".$arrayDevData[$i]["model_id"]."
                    ,  `right_name`='".$arrayDevData[$i]["right_name"]."', `right_value`=".$arrayDevData[$i]["right_value"]
                    .",  `right_remark`='".$arrayDevData[$i]["right_remark"]."',`is_lock`=".$arrayDevData[$i]["is_lock"].",  `is_del`=".$arrayDevData[$i]["is_del"].",`update_uid`=".$updateUid." where right_id=".$arrayData[$i]["right_id"]." ;";
                    $updateCount++;
                }
            }
                        
            if($updateCount >= 20)
            {
                $this->objMysqlDB->executeNonQuery(false,$updateSql,null);
                $updateSql = "";
                $updateCount = 0;
            }
        }
        //print_r($arrayDevData);
        //print_r($updateSql);
        if($updateSql != "")
            $updateCount += $this->objMysqlDB->executeNonQuery(false,$updateSql,null);
             /*   */
        //print_r($updateCount."++++++");
        $objMysqlDevDB = null;
        return 1;
    }
}
?>