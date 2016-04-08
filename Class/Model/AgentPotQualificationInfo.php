<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agent_pot_qualification的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:36:20
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * am_agent_pot_qualification表名及字段名 
 */
class T_AgentPotQualification
{
	/**
     * 表名 
     */
	const Name = "am_agent_pot_qualification";
	/**
     * 
     */
	const aid = "aid";
	/**
     * 
     */
	const agent_potential_id = "agent_potential_id";
	/**
     * 
     */
	const qualification_name = "qualification_name";
	/**
     * 
     */
	const file_path = "file_path";
	/**
     * 
     */
	const file_ext = "file_ext";
	/**
     * 
     */
	const qualification_type = "qualification_type";
	/**
     * 
     */
	const creat_user_ip = "creat_user_ip";
	/**
     * 
     */
	const create_time = "create_time";
		
	/**
     * 所有字段 
     */
	const AllFields = "`aid`,`agent_potential_id`,`qualification_name`,`file_path`,`file_ext`,`qualification_type`,`creat_user_ip`,`create_time`";
}

/**
 * am_agent_pot_qualification数据实体
 */
class AgentPotQualificationInfo
{
	/**
     * 
     */
	public $iAid = 0;
	/**
     * 
     */
	public $iAgentPotentialId = 0;
	/**
     * 
     */
	public $strQualificationName = '';
	/**
     * 
     */
	public $strFilePath = '';
	/**
     * 
     */
	public $strFileExt = '';
	/**
     * 
     */
	public $iQualificationType = 0;
	/**
     * 
     */
	public $strCreatUserIp = '';
	/**
     * 
     */
	public $iCreateTime = 0;

}

