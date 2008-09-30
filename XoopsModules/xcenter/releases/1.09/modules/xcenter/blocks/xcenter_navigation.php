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
// ------------------------------------------------------------------------- //
// Author: Simon Roberts (aka wishcraft)                                     //
// Site: http://www.chronolabs.org.au                                        //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

function content_block_nav() {

        global $xoopsDB, $xoopsModule, $xoopsTpl, $HTTP_GET_VARS, $xoopsUser;
		
        $block = array();
		$myts =& MyTextSanitizer::getInstance();
		if($xoopsModule && ($xoopsModule->name() == _CXM_XCENTER_PREFIX || $xoopsModule->dirname() == _CXM_XCENTER_PREFIX)){
		  	$result = $xoopsDB->query("SELECT CASE parent_id WHEN 0 THEN center_id ELSE parent_id END 'sortorder' FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." WHERE visible='1' AND center_id=".$HTTP_GET_VARS['id']);
			list($currentParent) = $xoopsDB->fetchRow($result);
		}else{
			$currentParent = '';
		}
		
		$result = $xoopsDB->query("SELECT child.link, child.center_id, child.weight, child.title, child.visible, child.parent_id, child.address,CASE parent.parent_id WHEN 0 THEN parent.weight ELSE child.weight END 'menu_block', CASE child.parent_id WHEN 0 THEN child.center_id ELSE child.parent_id END 'menu_id'FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." child LEFT JOIN ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." parent ON child.parent_id = parent.center_id WHERE child.visible='1' ORDER BY menu_block, menu_id, parent_id, weight");

		while($tcontent = $xoopsDB->fetchArray($result)) {
		  $link = array();
		  if ($tcontent['address'] && $tcontent['link'] != 1){
			$contentURL = $tcontent['address'];
		  }else{
			$contentURL = XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$tcontent['center_id'];
		  }
		  $link['id'] = $tcontent['center_id'];
		  $link['title'] = $myts->makeTboxData4Show($tcontent['title']);
		  $link['parent'] = $tcontent['parent_id'];
		  $link['currentParent'] = $currentParent;
		  $link['currentPage'] = $HTTP_GET_VARS['id'];
		  $link['address'] = $contentURL;
		  
		  $block['links'][] = $link;
		}
		if($xoopsModule){
			$module_id = $xoopsModule->getVar('mid');
		} else {
			$sql = "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname=_CXM_DIR_NAME";
			$result = $xoopsDB->query($sql);
			list($module_id) = $xoopsDB->fetchArray($result);
		}	
		
		$gperm_handler =& xoops_gethandler('groupperm'); 
		if ($xoopsUser) {
			$groups = $xoopsUser->getGroups();
		} else {
			$groups = XOOPS_GROUP_ANONYMOUS;
		} 
	
		if ($gperm_handler->checkRight("module_admin", $module_id, $groups, 1)) {
			 $block['links'][] = array('title' => '<font color="#FF9933">Add main menu item</font>', 'address' => XOOPS_URL."/modules/"._CXM_DIR_NAME."/admin/index.php?op=submit&center_id=0&return=1", 'parent' => 0, 'currentParent' => $currentParent, 'currentPage' => $HTTP_GET_VARS['id']);
		}
        return $block;
}

?>