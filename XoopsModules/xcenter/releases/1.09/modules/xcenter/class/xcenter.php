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

class xcenterResource extends XoopsObject {
	function xcenterResource(){
		$this->XoopsObject();
		$this->initVar("center_id", XOBJ_DTYPE_INT);
		$this->initVar("parent_id", XOBJ_DTYPE_INT, 'e', true, 1);
		$this->initVar("weight", XOBJ_DTYPE_INT, 1, false, 3);
		$this->initVar("title", XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar("summary", XOBJ_DTYPE_TXTBOX, '', true, 560);
		$this->initVar("keywords", XOBJ_DTYPE_TXTBOX, '', true, 2000);		
//		$this->initVar("text", XOBJ_DTYPE_TXTAREA);
		$this->initVar("text", XOBJ_DTYPE_TXTBOX);
		$this->initVar("visible", XOBJ_DTYPE_INT, 1, false, 3);
		$this->initVar("homepage", XOBJ_DTYPE_INT, 0, false, 3);
		$this->initVar("nohtml", XOBJ_DTYPE_INT, 0, false, 3);
		$this->initVar("nosmiley", XOBJ_DTYPE_INT, 0, false, 3);
		$this->initVar("nobreaks", XOBJ_DTYPE_INT, 0, false, 3);
		$this->initVar("nocomments", XOBJ_DTYPE_INT, 0, false, 3);
		$this->initVar("link", XOBJ_DTYPE_INT, 0, false, 3);
		$this->initVar("address", XOBJ_DTYPE_URL);
		$this->initVar("anonymous", XOBJ_DTYPE_INT, 1, false, 3);
		$this->initVar("submenu", XOBJ_DTYPE_INT, 0, false, 3);
	}
}

class xcenterxcenterHandler extends XoopsObjectHandler {
	var $db;
	var $db_table;
	var $perm_name = 'xcentre_';
	var $obj_class = 'xcenterResource';

	function xcenterxcenterHandler(&$db){
		if (!isset($db)&&!empty($db))
		{
			$this->db =& $db;
		} else {
			global $xoopsDB;
			$this->db =& $xoopsDB;
		}
		$this->db_table = $this->db->prefix(_CXM_XCENTER_PREFIX);
		$this->perm_handler =& xoops_gethandler('groupperm');
	}
	
	function &getInstance(&$db){
		static $instance;
		if( !isset($instance) ){
			$instance = new xcenterxcenterHandler($db);
		}
		return $instance;
	}
	function &create(){
		return new $this->obj_class();
	}

	function &get($id, $fields='*'){
		$id = intval($id);
		if( $id > 0 ){
			$sql = 'SELECT '.$fields.' FROM '.$this->db_table.' WHERE center_id='.$id;
		} else {
			$sql = 'SELECT '.$fields.' FROM '.$this->db_table.' WHERE homepage=1';
		}
		if( !$result = $this->db->query($sql) ){
			return false;
		}
		$numrows = $this->db->getRowsNum($result);
		if( $numrows == 1 ){
			$Center = new $this->obj_class();
			$Center->assignVars($this->db->fetchArray($result));
			return $Center;
		}
		return false;
	}

	function insert(&$Center, $force = false){
        if( strtolower(get_class($Center)) != strtolower($this->obj_class)){
            return false;
        }
        if( !$Center->isDirty() ){
            return true;
        }
        if( !$Center->cleanVars() ){
            return false;
        }
		foreach( $Center->cleanVars as $k=>$v ){
			${$k} = $v;
		}
		$myts =& MyTextSanitizer::getInstance();
		if( $Center->isNew() || empty($center_id) ){
			$center_id = $this->db->genId($this->db_table."_xcenter_id_seq");
			$sql = sprintf("INSERT INTO %s (
				center_id, parent_id, weight, title, summary, keywords, text, visible, homepage, nohtml, nosmiley, nobreaks, nocomments, link, address, anonymous, submenu 
				) VALUES (
				%u, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s
				)",
				$this->db_table,
				$center_id,
				$this->db->quoteString($parent_id),
				$this->db->quoteString($weight),
				$this->db->quoteString($myts->addslashes($title)),
				$this->db->quoteString($myts->addslashes($summary)),
				$this->db->quoteString($myts->addslashes($keywords)),				
				$this->db->quoteString($myts->addslashes($text)),
				$this->db->quoteString($visible),
				$this->db->quoteString($homepage),
				$this->db->quoteString($nohtml),
				$this->db->quoteString($nosmiley),
				$this->db->quoteString($nobreaks),
				$this->db->quoteString($nocomments),
				$this->db->quoteString($link),
				$this->db->quoteString($address),
				$this->db->quoteString($anonymous),
				$this->db->quoteString($submenu)								
			);
		}else{
			$sql = sprintf("UPDATE %s SET
				parent_id = %s,
				weight = %s,
				title = %s,
				summary = %s,
				keywords = %s,				
				text = %s,
				visible = %s,
				homepage = %s,
				nohtml = %s,
				nosmiley = %s,
				nobreaks = %s,
				nocomments = %s,				
				link = %s,
				address = %s,
				anonymous = %s,
				submenu = %s WHERE center_id = %s",
				$this->db_table,
				$this->db->quoteString($parent_id),
				$this->db->quoteString($weight),
				$this->db->quoteString($myts->addslashes($title)),
				$this->db->quoteString($myts->addslashes($summary)),
				$this->db->quoteString($myts->addslashes($keywords)),				
				$this->db->quoteString($myts->addslashes($text)),
				$this->db->quoteString($visible),
				$this->db->quoteString($homepage),
				$this->db->quoteString($nohtml),
				$this->db->quoteString($nosmiley),
				$this->db->quoteString($nobreaks),
				$this->db->quoteString($nocomments),
				$this->db->quoteString($link),
				$this->db->quoteString($address),
				$this->db->quoteString($anonymous),
				$this->db->quoteString($submenu),							
				$this->db->quoteString($center_id)
			);
		}
		
		if( false != $force ){
            $result = $this->db->queryF($sql);
        }else{
            $result = $this->db->query($sql);
        }
		if( !$result ){
			$Center->setErrors("Could not store data in the database.<br />".$this->db->error().' ('.$this->db->errno().')<br />'.$sql);
			return false;
		}
		if( empty($center_id) ){
			$center_id = $this->db->getInsertId();
		}
        $Center->assignVar('center_id', $center_id);
		return $center_id;
	}
	
	function delete(&$Center, $force = false){
		if( strtolower(get_class($Center)) != strtolower($this->obj_class) ){
			return false;
		}
		$sql = "DELETE FROM ".$this->db_table." WHERE center_id=".$Center->getVar("center_id")."";
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
		switch($fields){
			case 'elink':
				$fields = 'center_id,parent_id,title,summary,visible,nocomments,address,submenu';
			break;
		}
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
			$Centers = new $this->obj_class();
			$Centers->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $Centers;
			}else{
				$ret[$myrow['center_id']] =& $Centers;
			}
			unset($Centers);
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
	
	function deleteCenterPermissions($center_id, $mode = "view"){
		global $xoopsModule;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('gperm_itemid', $center_id)); 
		$criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid')));
		$criteria->add(new Criteria('gperm_name', $this->perm_name.$mode)); 
		if( $old_perms =& $this->perm_handler->getObjects($criteria) ){
			foreach( $old_perms as $p ){
				$this->perm_handler->delete($p);
			}
		}
		return true;
	}
	
	function insertCenterPermissions($center_id, $group_ids, $mode = "view"){
		global $xoopsModule;
		foreach( $group_ids as $id ){
			$perm =& $this->perm_handler->create();
			$perm->setVar('gperm_name', $this->perm_name.$mode);
			$perm->setVar('gperm_itemid', $center_id);
			$perm->setVar('gperm_groupid', $id);
			$perm->setVar('gperm_modid', $xoopsModule->getVar('mid'));
			$this->perm_handler->insert($perm);
			$ii++;
		}
		return "Permission ".$this->perm_name.$mode." set $ii times for "._C_ADMINTITLE." Record ID ".$center_id;
	}
	
	function &getPermittedCenters($Centers, $mode = "view"){
		global $xoopsUser, $xoopsModule;
		$ret=false;
		if (isset($Centers))
		{
			$ret = array();
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('gperm_itemid', $Centers->getVar('center_id'), '='), 'AND');
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
			if( $Centers =& $this->getObjects($criteria, 'home_list') ){
				$ret = array();
				foreach( $Centers as $f ){
					if( false != $this->perm_handler->checkRight($this->perm_name.$mode, $f->getVar('center_id'), $groups, $xoopsModule->getVar('mid')) ){
						$ret[] = $f;
						unset($f);
					}
				}
			}
		}
		return ret;
	}
	
	function getSingleCenterPermission($center_id, $mode = "view"){
		global $xoopsUser, $xoopsModule;
		$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : 3;
		if( false != $this->perm_handler->checkRight($this->perm_name.$mode, $center_id, $groups, $xoopsModule->getVar('mid')) ){
			return true;
		}
		return false;
	}
	
}

?>