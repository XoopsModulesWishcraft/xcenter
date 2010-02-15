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


function xml_block_xcenter_show($options)
{	
	error_reporting(0);
	
    global $xoopsDB, $xoopsModule, $xoopsUser;
	$sql = "SELECT id, center_id, mod_id, summary, xml, bid FROM ".$xoopsDB->prefix("xcenter_mblocks");
	
	if ($options[0]!=0)
		$sql_a = "center_id = '".$options[0]."'";
		
	if ($options[1]!=0)
		$sql_b = "mod_id = '".$options[1]."'";	

	if (strlen($sql_a)>0&&strlen($sql_b)>0)
		$sql_c = $sql." WHERE ".$sql_a." AND ".$sql_b;
	elseif (strlen($sql_b)>0)
		$sql_c = $sql." WHERE ".$sql_b;
	elseif (strlen($sql_a)>0)
		$sql_c = $sql." WHERE ".$sql_a;
		
	if (strlen($sql_c)>0)
		$result = $xoopsDB->query($sql_c);
			
	if ($xoopsDB->getRowsNum($result))
		list($id, $center_id, $mod_id, $summary, $xml, $bid) = $xoopsDB->fetchRow($result);

	include(XOOPS_ROOT_PATH.'/modules/xcenter/class/xcenter_ct_xml_pharse.php');
	
	$xmlp = new xcenter_ct_xml($xml);	
	
	$sql =  "SELECT keywords FROM ".$xoopsDB->prefix("xcenter")." WHERE center_id = '$center_id'";
	$result = $xoopsDB->query($sql);
			
	if ($xoopsDB->getRowsNum($result))
		list($keywords) = $xoopsDB->fetchRow($result);
		
	if (strlen($keywords)>0)
	{
		$keywords = str_replace(", ",",",$keywords);
		$keywords = str_replace(" ,",",",$keywords);
		$keywords = str_replace(" ",",",$keywords);
		$keys = (explode(",",$keywords));
		$xmlp->set_data($keys);
	}
	
	$bitm = $xmlp->get_block("ct");
	
	$bitems = $bitm['items'];
	$block = array();
	$block['type'] = $bitm['type'];
	
	for ($ii=0;$ii<$options[2];$ii++)
		if (isset($bitems[$ii])&&!empty($bitems[$ii]))
			$block['items'][] = $bitems[$ii];
	
	return $block;	
} 

function xml_block_xcenter_edit($options)
{
	error_reporting(0);
	
    global $xoopsDB, $xoopsModule, $xoopsUser;

	/*
	$mblock_handler =& xoops_getmodulehandler('mblock', 'xcenter');
		
	if ($_REQUEST['center_id']!=0)
		$center_id = $_REQUEST['center_id'];
	else
		$center_id = $options[0];
		
	if ($_REQUEST['mod_id']!=0)
		$mod_id = $_REQUEST['mod_id'];
	else
		$mod_id = $options[1];		
		
	$criteria = new CriteriaCompo(new Criteria('center_id', $center_id));
	$criteria->add(new Criteria('mod_id', $mod_id));

	$mblocks =& $mblock_handler->getObjects($criteria);
	*/
	
	$sql = "SELECT id, center_id, mod_id, summary, xml, bid FROM ".$xoopsDB->prefix("xcenter_mblocks");
	
	if ($_REQUEST['center_id']!=0)
		$sql_a = "center_id = '".$_REQUEST['center_id']."'";
	elseif ($options[0]!=0)
		$sql_a = "center_id = '".$options[0]."'";
		
	if ($_REQUEST['mod_id']!=0)
		$sql_b = "mod_id = '".$_REQUEST['mod_id']."'";
	elseif ($options[1]!=0)
		$sql_b = "mod_id = '".$options[1]."'";	

	if (strlen($sql_a)>0&&strlen($sql_b)>0)
		$sql_c = $sql." WHERE ".$sql_a." AND ".$sql_b;
	elseif (strlen($sql_b)>0)
		$sql_c = $sql." WHERE ".$sql_b;
	elseif (strlen($sql_a)>0)
		$sql_c = $sql." WHERE ".$sql_a;
		
	if (strlen($sql_c)>0)
		$result = $xoopsDB->query($sql_c);
			
	if ($xoopsDB->getRowsNum($result))
	{
		
		list($id, $center_id, $mod_id, $summary, $xml, $bid) = $xoopsDB->fetchRow($result);
		
	} else {
		$summary = "Not Set";
		$xml = "<!-- Not Set -->";
	}
		
$form = '<table width="100%" border="0" align="left">
  <tr>
    <td width="7%" align="right">Article:</td>
    <td width="93%" align="left"><label>
      <select name="options[0]" id="options[0]" onchange=\'location.href="'.XOOPS_URL.'/modules/system/admin.php?fct='.$_REQUEST['fct'].'&op='.$_REQUEST['op'].'&bid='.$_REQUEST['bid'].'&mod_id='.$_REQUEST['mod_id'].'&center_id="+this.options[this.selectedIndex].value\'>';
$form .= '       <option selected value="0">----------------------------</option>';
$sql = "SELECT center_id, title FROM ".$xoopsDB->prefix('xcenter')."";
$ret = $xoopsDB->query($sql);
while ($row = $xoopsDB->fetchArray($ret))
{
	if ($row['center_id'] == $_REQUEST['center_id']||$options[0] == $row['center_id'])
	{
		$form .= '       <option selected value="'.$row['center_id'].'">'.$row['title'].'</option>';
	} else {
		$form .= '       <option value="'.$row['center_id'].'">'.$row['title'].'</option>';
	}
}
$form .= '      </select>
    </label></td>
  </tr>
  <tr>
    <td align="right">Module:</td>
    <td><label>
      <select name="options[1]" id="options[1]" onchange=\'location.href="'.XOOPS_URL.'/modules/system/admin.php?fct='.$_REQUEST['fct'].'&op='.$_REQUEST['op'].'&bid='.$_REQUEST['bid'].'&center_id='.$_REQUEST['center_id'].'&mod_id="+this.options[this.selectedIndex].value\'>';
$form .= '       <option selected value="0">----------------------------</option>';	  
$module_handler =& xoops_gethandler('module');
$criteria = new CriteriaCompo(new Criteria('hasmain', 1));
$criteria->add(new Criteria('weight', 0, '>'));
$criteria->add(new Criteria('isactive', 1));
$modules =& $module_handler->getObjects($criteria, true);
foreach (array_keys($modules) as $i) {
	if ($modules[$i]->getVar('mid') == $_REQUEST['mod_id']||$options[1] == $modules[$i]->getVar('mid'))
	{
		$form .= '       <option selected value="'.$modules[$i]->getVar('mid').'">'.$modules[$i]->getVar('name').'</option>';
	} else {
		$form .= '       <option value="'.$modules[$i]->getVar('mid').'">'.$modules[$i]->getVar('name').'</option>';
	}

}
$items = !isset($options[2])?4:$options[2];
$form .= '      </select>
    </label></td>
  </tr>
  <tr>
    <td align="right" valign="top">Number of Items:</td>
    <td valign="top"><label>
      <input name="options[2]" id="options[2]" type="input" value="'.$items.'">
    </label></td>
  </tr>
  <tr>
    <td align="right" valign="top">Summary:</td>
    <td valign="top"><label>
      <textarea disabled name="options[3]" id="options[3]" cols="65" rows="5">'.$summary.'</textarea>
    </label></td>
  </tr>
  <tr>
    <td align="right" valign="top">XML:<br></td>
    <td valign="top"><label>
      <textarea disabled name="options[4]" id="options[4]" cols="65" rows="20">'.$xml.'</textarea>
	  <input type="hidden" id="bid" name="bid" value="'.$_REQUEST['bid'].'">
    </label></td>
  </tr>';
  
if (isset($options[3]))
$form .= '  <tr>
    <td align="right" valign="top">Summary:<br/><em>(Currently Set)</em></td>
    <td valign="top"><label>
      <textarea disabled name="set_summary" id="set_summary" cols="65" rows="5">'.$options[3].'</textarea>
    </label></td>
  </tr>';
  
if (isset($options[4]))
$form .= '  <tr>
    <td align="right" valign="top">XML:<br/><em>(Currently Set)</em></td>
    <td valign="top"><label>
      <textarea disabled name="set_xml" id="set_xml" cols="65" rows="5">'.$options[4].'</textarea>
    </label></td>
  </tr>';
  
$form .= '</table>';

    return $form;
} 

?>