<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 xoops.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Simon Roberts (aka wishcraft)                                     //
// Site: http://www.chronolabs.org.au                                        //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

//if( !defined('XCENTER_ROOT_PATH') ){ exit(); }

class mblockResource extends XoopsObject {
	function mblockResource(){
		$this->XoopsObject();
		$this->initVar("id", XOBJ_DTYPE_INT);
		$this->initVar("center_id", XOBJ_DTYPE_INT);
		$this->initVar("mod_id", XOBJ_DTYPE_INT);
		$this->initVar("summary", XOBJ_DTYPE_TXTBOX, '', true, 560);
		$this->initVar("xml", XOBJ_DTYPE_TXTBOX);
		$this->initVar("bid", XOBJ_DTYPE_INT);		
	}
}

class xcentermblockHandler extends XoopsObjectHandler {
	var $db;
	var $db_table;
	var $perm_name = 'xcentre_mblock_';
	var $obj_class = 'mblockResource';

	function xcentermblockHandler(&$db){
		if (!isset($db)&&!empty($db))
		{
			$this->db =& $db;
		} else {
			global $xoopsDB;
			$this->db =& $xoopsDB;
		}
		$this->db_table = $this->db->prefix(sprintf("%s_mblocks",_CXM_XCENTER_PREFIX));
		$this->perm_handler =& xoops_gethandler('groupperm');
	}
	
	function &getInstance(&$db){
		static $instance;
		if( !isset($instance) ){
			$instance = new xcentermblockHandler($db);
		}
		return $instance;
	}
	function &create(){
		return new $this->obj_class();
	}

	function &get($id, $fields='*'){
		$id = intval($id);
		if( $id > 0 ){
			$sql = 'SELECT '.$fields.' FROM '.$this->db_table.' WHERE id='.$id;
		} else {
			return false;
		}
		if( !$result = $this->db->query($sql) ){
			return false;
		}
		$numrows = $this->db->getRowsNum($result);
		if( $numrows == 1 ){
			$mBlock = new $this->obj_class();
			$mBlock->assignVars($this->db->fetchArray($result));
			return $mBlock;
		}
		return false;
	}

	function insert(&$mBlock, $force = false){
        if( strtolower(get_class($mBlock)) != strtolower($this->obj_class)){
            return false;
        }
        if( !$mBlock->isDirty() ){
            return true;
        }
        if( !$mBlock->cleanVars() ){
            return false;
        }
		foreach( $mBlock->cleanVars as $k=>$v ){
			${$k} = $v;
		}
		$myts =& MyTextSanitizer::getInstance();
		if( $mBlock->isNew() || empty($id) ){
			$id = $this->db->genId($this->db_table."_xct_mblocks_id_seq");
			$sql = sprintf("INSERT INTO %s (
				id, center_id, mod_id, summary, xml, bid
				) VALUES (
				%u, %s, %s, %s, %s, %s
				)",
				$this->db_table,
				$id,
				$this->db->quoteString($center_id),
				$this->db->quoteString($mod_id),
				$this->db->quoteString($myts->addslashes($summary)),
				$this->db->quoteString($myts->addslashes($xml)),
				$this->db->quoteString($bid)								
			);
		}else{
			$sql = sprintf("UPDATE %s SET
				center_id = %s,
				mod_id = %s,
				summary = %s,
				xml = %s,
				bid = %s WHERE id = %s",
				$this->db_table,
				$this->db->quoteString($center_id),
				$this->db->quoteString($mod_id),
				$this->db->quoteString($myts->addslashes($summary)),
				$this->db->quoteString($myts->addslashes($xml)),
				$this->db->quoteString($bid),				
				$this->db->quoteString($id)
			);
		}
		
		if( false != $force ){
            $result = $this->db->queryF($sql);
        }else{
            $result = $this->db->query($sql);
        }
		if( !$result ){
			$mBlock->setErrors("Could not store data in the database.<br />".$this->db->error().' ('.$this->db->errno().')<br />'.$sql);
			return false;
		}
		if( empty($id) ){
			$id = $this->db->getInsertId();
		}
        $mBlock->assignVar('id', $id);
		return $id;
	}
	
	function delete(&$mBlock, $force = false){
		if( strtolower(get_class($mBlock)) != strtolower($this->obj_class) ){
			return false;
		}
		$sql = "DELETE FROM ".$this->db_table." WHERE id=".$mBlock->getVar("id")."";
        if( false != $force ){
            $result = $this->db->queryF($sql);
        }else{
            $result = $this->db->query($sql);
        }
		return true;
	}

	function &getObjects($criteria = null, $fields='*', $id_as_key = false){
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT '.$fields.' FROM '.$this->db_table;
		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
			$sql .= ' '.$criteria->renderWhere();
			if( $criteria->getSort() != '' ){
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if( !$result )
			return false;
		while( $myrow = $this->db->fetchArray($result) ){
			$mBlocks = new $this->obj_class();
			$mBlocks->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $mBlocks;
			}else{
				$ret[$myrow['id']] =& $mBlocks;
			}
			unset($mBlocks);
		}
		return count($ret) > 0 ? $ret : false;
	}
	
    function getCount($criteria = null){
		$sql = 'SELECT COUNT(*) FROM '.$this->db_table;
		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
			$sql .= ' '.$criteria->renderWhere();
		}
		$result = $this->db->query($sql);
		if( !$result ){
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}
    
    function deleteAll($criteria = null){
		$sql = 'DELETE FROM '.$this->db_table;
		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
			$sql .= ' '.$criteria->renderWhere();
		}
		if( !$result = $this->db->query($sql) ){
			return false;
		}
		return true;
	}
	
	function deleteCenterPermissions($id, $mode = "view"){
		global $xoopsModule;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('gperm_itemid', $id)); 
		$criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid')));
		$criteria->add(new Criteria('gperm_name', $this->perm_name.$mode)); 
		if( $old_perms =& $this->perm_handler->getObjects($criteria) ){
			foreach( $old_perms as $p ){
				$this->perm_handler->delete($p);
			}
		}
		return true;
	}
	
	function insertCenterPermissions($id, $group_ids, $mode = "view"){
		global $xoopsModule;
		foreach( $group_ids as $id ){
			$perm =& $this->perm_handler->create();
			$perm->setVar('gperm_name', $this->perm_name.$mode);
			$perm->setVar('gperm_itemid', $id);
			$perm->setVar('gperm_groupid', $id);
			$perm->setVar('gperm_modid', $xoopsModule->getVar('mid'));
			$this->perm_handler->insert($perm);
			$ii++;
		}
		return "Permission ".$this->perm_name.$mode." set $ii times for "._C_ADMINTITLE." Record ID ".$id;
	}
	
	function &getPermittedCenters($mBlocks, $mode = "view"){
		global $xoopsUser, $xoopsModule;
		$ret=false;
		if (isset($mBlocks))
		{
			$ret = array();
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('gperm_itemid', $mBlocks->getVar('center_id'), '='), 'AND');
			$criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='), 'AND');
			$criteria->add(new Criteria('gperm_name', $this->perm_name.$mode, '='), 'AND');						

			$gtObjperm = $this->perm_handler->getObjects($criteria);
			$groups=array();
			
			foreach ($gtObjperm as $v)
			{
				$ret[] = $v->getVar('gperm_groupid');
			}	
			return $ret;
			
		} else {
			$ret = array();
			$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : 3;
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('Center_order', 1, '>='), 'OR');
			$criteria->setSort('Center_order');
			$criteria->setOrder('ASC');
			if( $mBlocks =& $this->getObjects($criteria, 'home_list') ){
				$ret = array();
				foreach( $mBlocks as $f ){
					if( false != $this->perm_handler->checkRight($this->perm_name.$mode, $f->getVar('center_id'), $groups, $xoopsModule->getVar('mid')) ){
						$ret[] = $f;
						unset($f);
					}
				}
			}
		}
		return ret;
	}
	
	function getSingleCenterPermission($id, $mode = "view"){
		global $xoopsUser, $xoopsModule;
		$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : 3;
		if( false != $this->perm_handler->checkRight($this->perm_name.$mode, $id, $groups, $xoopsModule->getVar('mid')) ){
			return true;
		}
		return false;
	}
	
}

?>