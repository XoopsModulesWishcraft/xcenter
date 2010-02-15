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

include "../../mainfile.php";

if ( file_exists("language/".$xoopsConfig['language']."/modinfo.php") ) {
	include("language/".$xoopsConfig['language']."/modinfo.php");
} else {
	include("language/english/modinfo.php");
}
//include_once XOOPS_ROOT_PATH.'/header.php';
tmpsite_block_dhtml_nav();
//include XOOPS_ROOT_PATH.'/include/comment_view.php';
//include_once XOOPS_ROOT_PATH.'/footer.php';
function tmpsite_block_dhtml_nav() {
	global $xoopsDB, $xoopsModule, $xoopsTpl, $HTTP_GET_VARS, $xoopsUser, $xoopsConfig;
	//Modules
	$menuModule = array();
	$module_handler =& xoops_gethandler('module');
	$criteria = new CriteriaCompo(new Criteria('hasmain', 1));
	$criteria->add(new Criteria('weight', 0, '>'));
	$criteria->add(new Criteria('isactive', 1));
	$modules =& $module_handler->getObjects($criteria, true);
	$moduleperm_handler =& xoops_gethandler('groupperm');
	$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$read_allowed =& $moduleperm_handler->getItemIds('module_read', $groups);
	foreach (array_keys($modules) as $i) {
		if (in_array($i, $read_allowed)) {
			$menuModule[$i]['title'] = $modules[$i]->getVar('name');
			$menuModule[$i]['url'] = XOOPS_URL."/modules/".$modules[$i]->getVar('dirname')."/";
			$menuModule[$i]['priority'] = $modules[$i]->getVar('weight');
			$menuModule[$i]['id'] = $modules[$i]->getVar('id');
			$menuModule[$i]['type'] = "module";
			$sublinks =& $modules[$i]->subLink();
			if (count($sublinks) > 0) {
				foreach($sublinks as $sublink){
					$menuModule[$i]['sublinks'][] = array('title' => $sublink['name'], 'url' => XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$sublink['url']);
				}
			} else {
				$menuModule[$i]['sublinks'] = array();
			}
		}
	}
	
	//xcenter
	$result = $xoopsDB->query("SELECT *, weight AS priority, _CXM_XCENTER_PREFIX AS type FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX));
	$contentItems = array();
	while($tcontent = $xoopsDB->fetchArray($result)) {
		$contentItems[] = $tcontent;
	}
	
	$menu = array_merge($menuModule, return_children($contentItems, 0));
	
	foreach ($menu as $key => $row) {
		$priority[$key]  = $row['priority'];
	}
	
	array_multisort($priority, SORT_ASC, $menu);
	$block = array();
	$block['ct_depth'] = 1;
	$block['ct_menu'] = print_menu($menu, $contentItems, 0, $block['ct_depth']);
	
	$block['cssul1'] = "div#menu ul ul";
	for ($depth = 1; $depth < $block['ct_depth'] - 1; $depth++){
		$block['cssul1'] .=", div#menu ul li:hover".str_repeat(" ul", $depth + 1);
	}
	
	$block['cssul2'] = "div#menu ul li:hover ul";
	for ($depth = 1; $depth < $block['ct_depth'] - 1; $depth++){
		$block['cssul2'] .=", div#menu ".str_repeat(" ul", $depth + 1)." li:hover ul";
	}

	return $block;
}

function return_children($items, $parent_id){
	$myItems = array();
	foreach ($items as $item) {
		if ($item['parent_id'] == $parent_id){
			$myItems[] = $item;
		}
	}
	return $myItems;
}

function print_menu($menuItems, &$fullList, $level, &$depth){
	if ($level + 1 > $depth) {
		$depth = $level + 1;
	}
	if ($level == 0){
		$MyList .= "<ul>";
	}
	foreach ($menuItems as $menuItem) {
		if($menuItem['type'] == _CXM_XCENTER_PREFIX){
			if ($menuItem['address'] && $menuItem['link'] != 1){
				$contentURL = $menuItem['address'];
			}else{
				$contentURL = XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$menuItem['center_id'];
			}
		}else{
			$contentURL = $menuItem['url'];
		}
		
		$MyList .= "\n\t<li><a class=\"menuMain\" href=\"".$contentURL."\">".$menuItem['title']."</a>";
		
		if ($menuItem['type'] == _CXM_XCENTER_PREFIX) {
			if (return_children($fullList, $menuItem['center_id'])){
				$MyList .= "<ul>".print_menu(return_children($fullList, $menuItem['center_id']), $fullList, $level + 1, $depth)."</ul>";
			}
		} else {
			if ($menuItem['sublinks']){
				$MyList .= "<ul>\n";
				foreach ($menuItem['sublinks'] as $sublink){
					$MyList .= "<li><a class=\"menuMain\" href=\"".$sublink['url']."\">".$sublink['title']."</a></li>\n";
				}
				$MyList .= "</ul>\n";
			}
		}
		
		$MyList .= "</li>\n";
	}
	if ($level == 0){
		$MyList .= "</ul>";
	}
	return $MyList;
}
?>
