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
	foreach ($obj_xcenter as $xcntr)
	{
		$ii++;
		$tray[$ii] = new XoopsFormElementTray($xcntr->getVar('title'),'&nbsp;|&nbsp;');
	
		$category[$ii] = new XoopsFormSelect(_C_POSITION, "parent_id[$ii]", $xcntr->getVar('parent_id'));
		$category[$ii]->addOptionArray(parents_menus(0,'',''));
		$weight[$ii] = new XoopsFormText(_C_WEIGHT, "weight[$ii]", 2, 3, $xcntr->getVar('weight'));	
		$visible[$ii] = new XoopsFormCheckBox(_C_VISIBLE, "visible[$ii]", $xcntr->getVar('visible'));
		$visible[$ii]->addOption(1, _C_YES);
		$homepage[$ii] = new XoopsFormCheckBox(_C_HOMEPAGE, "homepage[$ii]", $xcntr->getVar('homepage'));
		$homepage[$ii]->addOption(1, _C_YES);
		$nocomments[$ii] = new XoopsFormCheckBox(_C_NOCOMMENT, "nocomments[$ii]", $xcntr->getVar('nocomments'));
		$nocomments[$ii]->addOption(1, _C_YES);
		$submenu[$ii] = new XoopsFormCheckBox(_C_SUBMENU, "submenu[$ii]", $xcntr->getVar('submenu'));
		$submenu[$ii]->addOption(1, _C_YES);		
		$center_id[$ii] = new XoopsFormHidden("xcenter_id[$ii]", $xcntr->getVar('center_id'));
		$label_txt = "<a href='".XOOPS_URL."/modules/"._CXM_DIR_NAME."/admin/index.php?center_id=".$xcntr->getVar('center_id')."&op=delete'>Delete</a>&nbsp;|&nbsp;";
		$label_txt .= "<a href='".XOOPS_URL."/modules/"._CXM_DIR_NAME."/admin/index.php?center_id=".$xcntr->getVar('center_id')."&op=edit'>Edit</a>&nbsp|&nbsp;";
		$label_txt .= "<a href='".XOOPS_URL."/modules/"._CXM_DIR_NAME."/admin/index.php?center_id=".$xcntr->getVar('center_id')."&op=tracking'>Tracking</a>";
		$label[$ii] = new XoopsFormLabel("", $label_txt);
	
		$tray[$ii]->addElement($category[$ii]);
		$tray[$ii]->addElement($weight[$ii]);		
		$tray[$ii]->addElement($visible[$ii]);
		$tray[$ii]->addElement($homepage[$ii]);
		$tray[$ii]->addElement($nocomments[$ii]);
		$tray[$ii]->addElement($submenu[$ii]);
		$tray[$ii]->addElement($label[$ii]);
		$tray[$ii]->addElement($center_id[$ii]);
		$form->addElement($tray[$ii]);	
	}

	$form->addElement(new XoopsFormHidden('total', $ii));	
	$form->addElement(new XoopsFormHidden('op', $op));
	$form->addElement(new XoopsFormHidden('formaction', 'submit_'.$op));
	
	$submit = new XoopsFormButton("", "submit", _SUBMIT, "submit");
	$form->addElement($submit);
	 
?>
