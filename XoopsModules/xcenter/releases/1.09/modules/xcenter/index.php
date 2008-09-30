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

$title = isset($HTTP_GET_VARS['title']) ? ($HTTP_GET_VARS['title']) : '';
$center_id = isset($HTTP_GET_VARS['id']) ? intval($HTTP_GET_VARS['id']) : 0;

if (!function_exists('xoops_sef'))
{
	function xoops_sef($datab, $char ='-')
	{
		$replacement_chars = array();
		$accepted = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","m","o","p","q",
				 "r","s","t","u","v","w","x","y","z","0","9","8","7","6","5","4","3","2","1");
		for($i=0;$i<256;$i++){
			if (!in_array(strtolower(chr($i)),$accepted))
				$replacement_chars[] = chr($i);
		}
		$return_data = (str_replace($replacement_chars,$char,$datab));
		return($return_data);
	}
}

global $xoopsModule, $xoopsDB, $xoopsUser;

$config_handler =& xoops_gethandler('config');
$module = $xoopsModule->getByDirName(_CXM_XCENTER_PREFIX);

$config_handler =& xoops_gethandler('config');
$criteria = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
$configs =& $config_handler->getConfigs($criteria);
foreach(array_keys($configs) as $i){
	$xoopsModulesConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
}

$xcenter_handler =& xoops_getmodulehandler(_CXM_XCENTER_PREFIX, _CXM_XCENTER_PREFIX);

if ($xoopsModulesConfig['cont_htaccess']!=0)
{
	if (!empty($title)&&$center_id==0){
		$title = xoops_sef($title,'_');
		$sql = "SELECT b.center_id FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." b WHERE b.title like '$title'";
		$ret = $xoopsDB->query($sql);
		$rt = $xoopsDB->fetchArray($ret);
		$center_id = $rt['center_id'];
	}
}

if ($center_id!=0)
{
	$xcenter = &$xcenter_handler->get($center_id);
} else {
	$criteria = new Criteria('homepage', 1);
	$xctr = &$xcenter_handler->getObjects($criteria);
	$xcenter = $xctr[0];
}

if (!$xcenter)
	redirect_header(XOOPS_URL."/index.php",1,'There is current no content here!');

$perm = $xcenter_handler->getSingleCenterPermission($xcenter->getVar('center_id'));

if ($xcenter->getVar('anonymous')==0||$xoopsUser)
{
	if (!$perm) {
		redirect_header(XOOPS_URL."/index.php",1,_NOPERM);
	}
}


if ($center_id != 0) {
  
} else {
	if ($xoopsModulesConfig['cont_htaccess']!=0)
	{
		if (empty($_REQUEST['title']))
		{
			header("Location: ".XOOPS_URL."/".$xoopsModulesConfig['htaccess_basepath']."/".xoops_sef($xcenter->getVar('title'))."/$center_id");
			exit;
		}
	}
}

include_once XOOPS_ROOT_PATH.'/header.php';
	
      if ($xcenter->getVar('link') == 1) {
		// include external content
		
		$file_content = file_get_contents($xcenter->getVar('address'));
		
		if (strlen($file_content)>0){
		  $xoopsOption['template_main'] = 'xcenter_index.html';		

		  $xoopsTpl->assign('xoops_pagetitle', $xcenter->getVar('title').' : '._CXM_XCENTER_NAME);
		  if (strlen($xcenter->getVar('summary'))!=0)
			  $xoopsTpl->assign('xoops_meta_description', $xcenter->getVar('title').' : '._CXM_XCENTER_NAME.' : '.$xcenter->getVar('summary'));
			  
		  $xoopsTpl->assign('title', $xcenter->getVar('title'));
		  $xoopsTpl->assign('content', $file_content);
		  $xoopsTpl->assign('nocomments', $xcenter->getVar('nocomments'));
		  $xoopsTpl->assign('mail_link', 'mailto:?subject='.sprintf(_C_INTARTIGO,$xoopsConfig['sitename']).'&amp;body='.sprintf(_C_INTARTFOUND, $xoopsConfig['sitename'].'\n\n'.$xcenter->getVar('summary')).' : \n\n '.XOOPS_URL.'/modules/'._CXM_DIR_NAME.'index.php?center_id='.$xcenter->getVar('center_id'));
		  $xoopsTpl->assign('lang_printerpage', _C_PRINTERFRIENDLY);
		  $xoopsTpl->assign('lang_sendstory', _C_SENDSTORY);
		  $xoopsTpl->assign('id', $xcenter->getVar('center_id'));
    	}
		else{
			redirect_header("index.php",1,_C_FILENOTFOUND);
		}
	  }
	  else {
        // tiny content
		$xoopsOption['template_main'] = 'xcenter_index.html';

	    if ($xcenter->getVar('nohtml') == 1) { $html = 0; } else { $html = 1; }
		if ($xcenter->getVar('nosmiley') == 1) { $smiley = 0; } else { $smiley = 1; }
		if ($xcenter->getVar('nobreaks') == 1) { $breaks = 0; } else { $breaks = 1; }

		$myts =& MyTextSanitizer::getInstance();
	    $text=$myts->displayTarea($xcenter->getVar('text'), $html, $smiley, 1, 1, $breaks);

		$xoopsTpl->assign('xoops_pagetitle', $xcenter->getVar('title').' : Content');
		$xoopsTpl->assign('title', $xcenter->getVar('title'));
		$xoopsTpl->assign('mod_url_path', _CXM_DIR_NAME);
		$xoopsTpl->assign('content', $text);
  	    $xoopsTpl->assign('nocomments', $xcenter->getVar('nocomments'));
		$xoopsTpl->assign('edit', $xcenter_handler->getSingleCenterPermission($xcenter->getVar('center_id'),"edit"));
		global $xoopsUser, $xoopsModule;
		if ($xoopsUser) {
			if ($xoopsUser->isAdmin($xoopsModule->mid()))
			{
				$xoopsTpl->assign('edit_url', XOOPS_URL."/modules/"._CXM_DIR_NAME."/admin/index.php?op=edit&center_id=".$xcenter->getVar('center_id'));	
			} else {
				$xoopsTpl->assign('edit_url', XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?op=edit&center_id=".$xcenter->getVar('center_id'));	
			}
		} else {
			$xoopsTpl->assign('edit_url', XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?op=edit&center_id=".$xcenter->getVar('center_id'));	
		}
        $xoopsTpl->assign('mail_link', 'mailto:?subject='.sprintf(_C_INTARTIGO,$xoopsConfig['sitename']).'&amp;body='.sprintf(_C_INTARTFOUND, $xoopsConfig['sitename']." : ".$xcenter->getVar('summary'))." : ".XOOPS_URL.'/modules/'._CXM_DIR_NAME.'/index.php?center_id='.$xcenter->getVar('center_id'));
		$xoopsTpl->assign('lang_printerpage', _C_PRINTERFRIENDLY);
		$xoopsTpl->assign('lang_sendstory', _C_SENDSTORY);
		$xoopsTpl->assign('id', $xcenter->getVar('center_id'));
	  }

include XOOPS_ROOT_PATH.'/include/comment_view.php';
include_once XOOPS_ROOT_PATH.'/footer.php';
?>
