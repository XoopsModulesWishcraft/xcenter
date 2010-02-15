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
global $xoopsDB;

error_reporting(E_ALL);

$form_label = '<table width="100%" border="0" align="left">';
if (!center_id)
{
$form_label = '  <tr>
    <td width="7%" align="right">Article:</td>
    <td width="93%" align="left"><label>
      <select name="center_id" id="center_id" onchange=\'location.href="'.XOOPS_URL.'/modules/'._CXM_DIR_NAME.'/admin/index.php?center_id='.$id.'&op='.$op.'&mod_id='.$mod_id.'&center_id="+this.options[this.selectedIndex].value\'>';
$form .= '       <option selected value="0">----------------------------</option>';
$sql = "SELECT center_id, title FROM ".$xoopsDB->prefix(_CXM_DIR_NAME)."";
$ret = $xoopsDB->query($sql);
while ($row = $xoopsDB->fetchArray($ret))
{
	if ($row['center_id'] == $center_id)
	{
		$form .= '       <option selected value="'.$row['center_id'].'">'.$row['title'].'</option>';
	} else {
		$form .= '       <option value="'.$row['center_id'].'">'.$row['title'].'</option>';
	}
}

$form .= '      </select>
    </label></td>
  </tr>';
}
$form_label .= '  <tr>
    <td align="right">Module:</td>
    <td><label>
      <select name="mod_id" id="mod_id" onchange=\'location.href="'.XOOPS_URL.'/modules/'._CXM_DIR_NAME.'/admin/index.php?center_id='.$id.'&op='.$op.'&center_id='.$center_id.'&mod_id="+this.options[this.selectedIndex].value\'>';
$form_label .= '       <option selected value="0">----------------------------</option>';	  

$module_handler =& xoops_gethandler('module');
$criteria = new CriteriaCompo(new Criteria('hasmain', 1));
$criteria->add(new Criteria('weight', 0, '>'));
$criteria->add(new Criteria('isactive', 1));
$modules =& $module_handler->getObjects($criteria, true);
foreach (array_keys($modules) as $i) {
	if ($modules[$i]->getVar('mid') == $mod_id)
	{
		$form_label .= '       <option selected value="'.$modules[$i]->getVar('mid').'">'.$modules[$i]->getVar('name').'</option>';
		if (!$xml)
		{
			$xml = sprintf("%s%sxml version=\"1.0\" encoding=\"utf-8\"%s%s
<xcenter_ct version=\"1.10\">
	<version>1.10</version>
	<module>".$modules[$i]->getVar('dirname')."</module>
	<module_ver>".$modules[$i]->getVar('version')."</module_ver>
	<!-- XML Block Content follows here -->
	
	<!-- XML Block Content ends -->
<xcenter_ct>","<","?","?",">");
		}
	} else {
		$form_label .= '       <option value="'.$modules[$i]->getVar('mid').'">'.$modules[$i]->getVar('name').'</option>';
	}

}

$form_label .= '      </select>
    </label></td>
  </tr>
  <tr>
    <td align="right" valign="top">Summary:</td>
    <td valign="top"><label>
      <textarea name="summary" id="summary" cols="65" rows="5">'.$summary.'</textarea>
    </label></td>
  </tr>
  <tr>
    <td align="right" valign="top">XML:</td>
    <td valign="top"><label>
      <textarea name="xml" id="xml" cols="65" rows="20">'.$xml.'</textarea>
    </label></td>
  </tr>
</table>';

	$form->addElement(new XoopsFormLabel(_C_ADMINTITLE, "<strong>".$xcenter->getVar('title')."</strong>"));
	$form->addElement(new XoopsFormLabel(_C_KEYWORDS, "<em>".$xcenter->getVar('keywords')."</em>"));
	$form->addElement(new XoopsFormLabel(_C_XMLLABEL, $form_label));
	
	$example = "Document Standards : <a target='_blank' href='".XOOPS_URL.'/modules/'._CXM_DIR_NAME.'/admin/xcenter_xml_spec_1.10.xml'."'>1.10</a>&nbsp;|&nbsp;<a target='_blank' href='".XOOPS_URL.'/modules/'._CXM_DIR_NAME.'/admin/xcenter_xml_spec_1.11.xml'."'>1.11</a>";
	
	$form->addElement(new XoopsFormLabel(_C_XMLEXAMPLE, $example));
	
	if ($id=='')
		$id = '0';
		
	$form->addElement(new XoopsFormHidden('formaction', 'submit_'.$op));
	$form->addElement(new XoopsFormHidden('center_id', $center_id));
	$form->addElement(new XoopsFormHidden('id', $id));
	$form->addElement(new XoopsFormHidden('op', $op));		
	
	$submit = new XoopsFormButton("", "submit", _SUBMIT, "submit");
	$form->addElement($submit);
?>