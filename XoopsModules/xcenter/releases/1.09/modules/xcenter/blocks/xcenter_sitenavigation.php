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

function site_block_nav() {

    global $xoopsDB, $xoopsModule, $xoopsTpl, $HTTP_GET_VARS;
	global $xoopsUser,$xoopsModule,$xoopsDB;
    $menuModule = array();
    $module_handler =& xoops_gethandler('module');
    $criteria = new CriteriaCompo(new Criteria('hasmain', 1));
    $criteria->add(new Criteria('isactive', 1));
    $criteria->add(new Criteria('weight', 0, '>'));
    $modules =& $module_handler->getObjects($criteria, true);
    $moduleperm_handler =& xoops_gethandler('groupperm');
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $read_allowed =& $moduleperm_handler->getItemIds('module_read', $groups);
    foreach (array_keys($modules) as $i) {
        if (in_array($i, $read_allowed)) {
            $menuModule[$i]['text'] = $modules[$i]->getVar('name');
            $menuModule[$i]['url'] = XOOPS_URL."/modules/".$modules[$i]->getVar('dirname')."/";
			$menuModule[$i]['priority'] = $modules[$i]->getVar('weight');
			$menuModule[$i]['id'] = $modules[$i]->getVar('id');
			$menuModule[$i]['type'] = "module";
            $sublinks =& $modules[$i]->subLink();
            if ((count($sublinks) > 0) && (!empty($xoopsModule)) && ($i == $xoopsModule->getVar('mid'))) {
                foreach($sublinks as $sublink){
                    $menuModule[$i]['sublinks'][] = array('text' => $sublink['name'], 'url' => XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$sublink['url']);
                }
            } else {
                $menuModule[$i]['sublinks'] = array();
            }
        }
    }
	
	$block = array();
	$myts =& MyTextSanitizer::getInstance();
	global $j,$currentParent;
	if($xoopsModule && ($xoopsModule->name() == _CXM_XCENTER_PREFIX || $xoopsModule->dirname() == _CXM_XCENTER_PREFIX)){
	  	$result = $xoopsDB->query("SELECT CASE parent_id WHEN 0 THEN center_id ELSE parent_id END 'sortorder' FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." WHERE visible='1' AND center_id=".$HTTP_GET_VARS['id']);
		list($currentParent) = $xoopsDB->fetchRow($result);
	}
	
	$result = $xoopsDB->query("SELECT child.link, child.center_id, child.weight, child.title, child.visible, child.parent_id, child.address,CASE parent.parent_id WHEN 0 THEN parent.weight ELSE child.weight END 'menu_block', CASE child.parent_id WHEN 0 THEN child.center_id ELSE child.parent_id END 'menu_id'FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." child LEFT JOIN ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." parent ON child.parent_id = parent.center_id WHERE child.visible='1' ORDER BY menu_block, menu_id, parent_id, weight");

	
	$menu = array();
	while($tcontent = $xoopsDB->fetchArray($result)) {
	  if ($tcontent['parent_id'] == 0){
	  	if ($tcontent['address'] && $tcontent['link'] != 1){
			$contentURL = $tcontent['address'];
		}else{
			$contentURL = XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$tcontent['center_id'];
		}
		$menu[] = array('text' => $myts->makeTboxData4Show($tcontent['title']), 'url' => $contentURL, 'priority' => $tcontent['menu_block'], 'id' => $tcontent['center_id'], 'type' => _CXM_XCENTER_PREFIX);
		$j = count($menu);
	  }elseif ($tcontent['parent_id'] == $currentParent){
		if ($tcontent['address'] && $tcontent['link'] != 1){
			$contentURL = $tcontent['address'];
		}else{
			$contentURL = XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$tcontent['center_id'];
		}
		$menu[$j-1]['sublinks'][] = array('text' => $myts->makeTboxData4Show($tcontent['title']), 'url' => $contentURL);
	  }
	}
	
	$block = array_merge($menuModule, $menu);
	
	foreach ($block as $key => $row) {
   		$priority[$key]  = $row['priority'];
	}

	array_multisort($priority, SORT_ASC, $block);
	
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
		$block[] = array('text' => '<font color="#FF9933">Add main menu item</font>', 'url' => XOOPS_URL."/modules/"._CXM_DIR_NAME."/admin/index.php?op=submit&center_id=0&return=1");
	}
	
	return $block;
}

?>