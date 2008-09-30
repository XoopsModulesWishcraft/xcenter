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
	            $menuModule[$i]['url'] = XOOPS_URL."/modules/".$modules[$i]->getVar('dirname');
				$menuModule[$i]['priority'] = $modules[$i]->getVar('weight');
				
				echo $modules[$i]->getVar('id');
				$menuModule[$i]['id'] = $modules[$i]->getVar('mid');
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
		
		if($xoopsModule && ($xoopsModule->name() == _CXM_XCENTER_PREFIX || $xoopsModule->dirname() == _CXM_XCENTER_PREFIX)){
		  	$result = $xoopsDB->query("SELECT CASE parent_id WHEN 0 THEN center_id ELSE parent_id END 'sortorder' FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." WHERE visible='1' AND center_id=".$HTTP_GET_VARS['id']);
			list($currentParent) = $xoopsDB->fetchRow($result);
		}
		
		$result = $xoopsDB->query("SELECT child.center_id, child.weight, child.title, child.visible, child.parent_id, child.address,CASE parent.parent_id WHEN 0 THEN parent.weight ELSE child.weight END 'menu_block', CASE child.parent_id WHEN 0 THEN child.center_id ELSE child.parent_id END 'menu_id'FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." child LEFT JOIN ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." parent ON child.parent_id = parent.center_id WHERE child.visible='1' ORDER BY menu_block, menu_id, parent_id, weight");
	
		global $j;
		$menu = array();
		while($tcontent = $xoopsDB->fetchArray($result)) {
		  if ($tcontent['parent_id'] == 0){
			$menu[] = array('text' => $myts->makeTboxData4Show($tcontent['title']), 'url' => XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$tcontent['center_id'], 'priority' => $tcontent['menu_block'], 'id' => $tcontent['center_id'], 'type' => _CXM_XCENTER_PREFIX);
			$j = count($menu);
		  }else{//if ($tcontent['parent_id'] == $currentParent){
			$menu[$j-1]['sublinks'][] = array('text' => $myts->makeTboxData4Show($tcontent['title']), 'url' => XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$tcontent['center_id']);
		  }
		}
		
		$allmenus = array_merge($menuModule, $menu);
		
		foreach ($allmenus as $key => $row) {
	   		$priority[$key]  = $row['priority'];
		}
	
		array_multisort($priority, SORT_ASC, $allmenus);

		$i = 1;

		foreach($allmenus as $menuitem){
			$tray[$i] = new XoopsFormElementTray("<a href='".$menuitem['url']."'>".$menuitem['text']."</a>",'&nbsp;|&nbsp;');
			$id[$i] = new XoopsFormHidden("id".$i, $menuitem['id']);
			$type[$i] = new XoopsFormHidden("type".$i, $menuitem['type']);
			$weight[$i] = new XoopsFormText(_C_WEIGHT, "priority".$i, 2, 3, $menuitem['priority']);	
			$tray[$i]->addElement($id[$i]);
			$tray[$i]->addElement($type[$i]);		
			$tray[$i]->addElement($weight[$i]);
			$form->addElement($tray[$i]);
			$i++;
		}

	$form->addElement(new XoopsFormHidden('total', count($allmenus)));	
	$form->addElement(new XoopsFormHidden('op', $op));
	$form->addElement(new XoopsFormHidden('formaction', 'submit_'.$op));
	
	$submit = new XoopsFormButton("", "submit", _SUBMIT, "submit");
	$form->addElement($submit);
	 
?>
