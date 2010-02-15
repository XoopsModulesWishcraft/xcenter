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

	if ($xcenter->isNew())
	{
		$categoria_select = new XoopsFormSelect(_C_POSITION, "parent_id", 0);
	} else {
		$categoria_select = new XoopsFormSelect(_C_POSITION, "parent_id", $xcenter->getVar('parent_id'));
	}
	$categoria_select->addOptionArray(parents_menus(0,'',''));
	$form->addElement($categoria_select);
	// Search os menus na tabela:
	
	$text_box = new XoopsFormText(_C_LINKNAME, "title", 50, 30, $xcenter->getVar('title'));
	$form->addElement($text_box);
	
	$url_box = new XoopsFormText(_C_EXTURL, "address", 50, 255, $xcenter->getVar('address'));
	$form->addElement($url_box);

	$visible_checkbox = new XoopsFormCheckBox(_C_VISIBLE, 'visible', $xcenter->getVar('visible'));
	  $visible_checkbox->addOption(1, _C_YES);
	$form->addElement($visible_checkbox);

	$submenu_checkbox = new XoopsFormCheckBox(_C_SUBMENU, 'submenu', $xcenter->getVar('submenu'));
	  $submenu_checkbox->addOption(1, _C_YES);
	$form->addElement($submenu_checkbox);

	$form->addElement(new XoopsFormTextArea(_C_SUMMARY, 'summary', $xcenter->getVar('summary'), 6, 35, 560));
	$form->addElement(new XoopsFormTextArea(_C_KEYWORDS, 'keywords', $xcenter->getVar('keywords'), 6, 35, 2000));
		
	if (class_exists('XoopsFormEditor')&&$xoopsModuleConfig["cont_wysiwyg"]!=0) {
		$form->addElement(new XoopsFormSelectEditor($form, "edit_type", $_REQUEST['edit_type'], $xcenter->getVar('nohtml')));
		$editor_configs = array();
		$editor_configs["name"] ="text";
		$editor_configs["value"] = $xcenter->getVar('text');
		$editor_configs["rows"] = empty($xoopsModuleConfig["editor_rows"])? 35 : $xoopsModuleConfig["editor_rows"];
		$editor_configs["cols"] = empty($xoopsModuleConfig["editor_cols"])? 60 : $xoopsModuleConfig["editor_cols"];
		$editor_configs["width"] = empty($xoopsModuleConfig["editor_width"])? "100%" : $xoopsModuleConfig["editor_width"];
		$editor_configs["height"] = empty($xoopsModuleConfig["editor_height"])? "400px" : $xoopsModuleConfig["editor_height"];
		$form->addElement(new XoopsFormEditor(_C_CONTENT, $_REQUEST['edit_type'], $editor_configs, $xcenter->getVar('nohtml'), $onfailure=null));
	} else {
		$form->addElement(new XoopsFormDhtmlTextArea(_C_CONTENT, 'text', $xcenter->getVar('text'), 37, 35));
	}
	
	$view_perm = $xcenter_handler->getPermittedCenters($xcenter);
	if (!empty($view_perm))
	{
		$form->addElement(new XoopsFormSelectGroup(_C_GROUP_VIEW, 'group_view', true, $view_perm, 4, true));
	} else {
		if ($op="submit")
		{
			$xoopsModuleConfig['default_access_view'] = array_merge($xoopsModuleConfig['default_access_view'], array(3));
			$form->addElement(new XoopsFormSelectGroup(_C_GROUP_VIEW, 'group_view', true, $xoopsModuleConfig['default_access_view'], 4, true));
		} else {
			$form->addElement(new XoopsFormSelectGroup(_C_GROUP_VIEW, 'group_view', true, false, 4, true));
		}
	}
	
	$edit_perm = $xcenter_handler->getPermittedCenters($xcenter, "edit");
	if (!empty($edit_perm))
	{
		$form->addElement(new XoopsFormSelectGroup(_C_GROUP_EDIT, 'group_edit', true, $edit_perm, 4, true));
	} else {
		if ($op="submit")
			$form->addElement(new XoopsFormSelectGroup(_C_GROUP_EDIT, 'group_edit', true, $xoopsModuleConfig['default_access_edit'], 4, true));
		else
			$form->addElement(new XoopsFormSelectGroup(_C_GROUP_EDIT, 'group_edit', true, false, 4, true));
	}
	
	$delete_perm = $xcenter_handler->getPermittedCenters($xcenter, "delete");
	if (!empty($delete_perm))
	{
		$form->addElement(new XoopsFormSelectGroup(_C_GROUP_DELETE, 'group_delete', false, $delete_perm, 4, true));
	} else {
		if ($op="submit")
			$form->addElement(new XoopsFormSelectGroup(_C_GROUP_DELETE, 'group_delete', false, $xoopsModuleConfig['default_access_delete'], 4, true));	
		else
			$form->addElement(new XoopsFormSelectGroup(_C_GROUP_DELETE, 'group_delete', false, false, 4, true));	
		}
	
	$option_tray = new XoopsFormElementTray(_OPTIONS,'<br />');
	
	$anonymous_checkbox = new XoopsFormCheckBox('', 'anonymous', $xcenter->getVar('anonymous'));
	$anonymous_checkbox->addOption(1, "&nbsp;"._C_ANONYMOUS);
	$option_tray->addElement($anonymous_checkbox);
	
	$nohtml_checkbox = new XoopsFormCheckBox('', 'nohtml', $xcenter->getVar('nohtml'));
	$nohtml_checkbox->addOption(1, "&nbsp;"._DISABLEHTML);
	$option_tray->addElement($nohtml_checkbox);
	
	$smiley_checkbox = new XoopsFormCheckBox('', 'nosmiley', $xcenter->getVar('nosmiley'));
	$smiley_checkbox->addOption(1, "&nbsp;"._DISABLESMILEY);
	$option_tray->addElement($smiley_checkbox);
	
	$breaks_checkbox = new XoopsFormCheckBox('', 'nobreaks', $xcenter->getVar('nobreaks'));
	$breaks_checkbox->addOption(1, "&nbsp;"._C_DISABLEBREAKS);
	$option_tray->addElement($breaks_checkbox);
	
	$comments_checkbox = new XoopsFormCheckBox('', 'nocomments', $xcenter->getVar('nocomments'));
	$comments_checkbox->addOption(1, "&nbsp;"._C_DISABLECOM);
	$option_tray->addElement($comments_checkbox);
	  
    $return_checkbox = new XoopsFormCheckBox('', 'return', $return);
	$return_checkbox->addOption(1, "&nbsp;"._C_RETURN);
	$option_tray->addElement($return_checkbox);
	$form->addElement($option_tray);

	$form->addElement(new XoopsFormHidden('op', $xcenter->getVar('op')));
	$form->addElement(new XoopsFormHidden('center_id', $xcenter->getVar('center_id')));
	
	$form->addElement(new XoopsFormHidden('formaction', 'submit_'.$op));
	
	$submit = new XoopsFormButton("", "submit", _SUBMIT, "submit");
	$form->addElement($submit);
	 
?>
