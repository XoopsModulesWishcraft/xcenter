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
include '../../mainfile.php';

if ( file_exists("language/".$xoopsConfig['language']."/modinfo.php") ) {
	include("language/".$xoopsConfig['language']."/modinfo.php");
} else {
	include("language/english/modinfo.php");
}

$id = isset($HTTP_GET_VARS['id']) ? intval($HTTP_GET_VARS['id']) : 0;
if ( empty($id) ) {
	redirect_header("index.php");
}

$xcenter_handler =& xoops_getmodulehandler(_CXM_XCENTER_PREFIX, _CXM_XCENTER_PREFIX);
$xcenter = &$xcenter_handler->get($id);

$perm = $xcenter_handler->getSingleCenterPermission($xcenter->getVar('center_id'));

if ($xcenter->getVar('anonymous')==0||$xoopsUser)
{
	if (!$perm) {
		redirect_header(XOOPS_URL."/index.php",1,_NOPERM);
	}
}

  global $xoopsConfig, $xoopsModule;
	
   echo '<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">';
   echo '<html>';
   echo '<head>';
   echo '	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>';
   echo '	<title>'.$xoopsConfig['sitename'].'</title>';
   echo '	<meta name="AUTHOR" content="'.$xoopsConfig['sitename'].'"/>';
   echo '	<meta name="COPYRIGHT" content="Copyright (c) 2005'.$xoopsConfig['sitename'].'"/>';
   echo '	<meta name="DESCRIPTION" content="'.$xoopsConfig['slogan'].'"/>';
   echo '	<meta name="GENERATOR" content="'.XOOPS_VERSION.'"/>';
   echo '</head>';
   echo '<body bgcolor="#FFFFFF" text="#000000" topmargin="10" style="font:12px arial, helvetica, san serif;" onLoad="window.print()">';
   echo '	<table border="0" width="640" cellpadding="10" cellspacing="1" style="border: 1px solid #000000;" align="center">';
   echo '		<tr>';
   echo '			<td align="left"><img src="'.XOOPS_URL.'/images/logo.gif" border="0" alt=""/><br/><br/>';
   echo '				<strong>'.$xcenter->getVar('title').'</strong></td>';
   echo '		</tr>';
   echo '		<tr valign="top">';
   echo '			<td style="padding-top:0px;">';
   
   if ($xcenter->getVar('link') == 1) {
		// include external content
		
		$file_content = file_get_contents($xcenter->getVar('address'));
		
		if (strlen($file_content)>0){
			echo $file_content	;	  
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
	    echo $myts->displayTarea($xcenter->getVar('text'), $html, $smiley, 1, 1, $breaks);
	}
   
   echo '</td>';
   echo '		</tr>';
   echo '	</table>';
   echo '	<table border="0" width="640" cellpadding="10" cellspacing="1" align="center"><tr><td>';
   printf(_C_THISCOMESFROM,$xoopsConfig['sitename']);
   echo '<br /><a href="'.XOOPS_URL.'/">'.XOOPS_URL.'</a><br /><br />'._C_URLFORSTORY.'<br /><a href="'.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/index.php?center_id='.$id.'">'.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/index.php?center_id='.$id.'</a>';
   echo '</td></tr></table></body>';
   echo '</html>';
	

?>
