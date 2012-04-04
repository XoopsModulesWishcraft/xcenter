<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


include 'header.php';

$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);

if ( empty($storyid) &&$xcenter_handler->getCount(new Criteria('storyid', $storyid))==0) {
	redirect_header(XOOPS_URL._XTR_PATH_MODULE_ROOT,2,_XTR_NOSTORY);
}

if ($xcenter = $xcenter_handler->getContent(intval($storyid))) {
	
	if (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_XCENTER,$xcenter['xcenter']->getVar('storyid'),$groups, $modid))
		redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
	elseif (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_CATEGORY,$xcenter['xcenter']->getVar('catid'),$groups, $modid)
			&& $GLOBALS['xoopsModuleConfig']['security'] != _XTR_SECURITY_BASIC )
		redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
	else {
	
		if ($GLOBALS['xoopsModuleConfig']['htaccess'])
		if (strpos($_SERVER['REQUEST_URI'], 'odules/')>0) {
			$category = $category_handler->getCategory($xcenter['xcenter']->getVar('catid'));
			if ($category['text']->getVar('title')!='') {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.xoops_sef($category['text']->getVar('title')).'/print,'.$storyid.$GLOBALS['xoopsModuleConfig']['endofurl']);
			} else {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/print,'.$storyid.$GLOBALS['xoopsModuleConfig']['endofurl']);
			}
			exit(0);
		}

		if ($xcenter['xcenter']->getVar('publish')>time()&&$xcenter['xcenter']->getVar('publish')!=0) {
			if ($xcenter['xcenter']->getVar('publish_storyid')>0)
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/?storyid='.$xcenter['xcenter']->getVar('publish_storyid'), 10, _XTR_TOBEPUBLISHED);
			else
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/', 10, _XTR_TOBEPUBLISHED);
			exit(0);
		} elseif ($xcenter['xcenter']->getVar('expire')<time()&&$xcenter['xcenter']->getVar('expire')!=0) {
			if ($xcenter['xcenter']->getVar('expire_storyid')>0)
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/?storyid='.$xcenter['xcenter']->getVar('expire_storyid'), 10, _XTR_XCENTEREXPIRED);
			else
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/', 10, _XTR_XCENTEREXPIRED);
			exit(0);
		} elseif (strlen($xcenter['xcenter']->getVar('password'))==32) {
			if (!isset($_COOKIE['xcenter_password']))
				$_COOKIE['xcenter_password'] = array();
			if ($_COOKIE['xcenter_password'][md5(sha1(XOOPS_LICENSE_KEY).$storyid)]==false)
				if (md5($_POST['password'])!=$xcenter['xcenter']->getVar('password')) {
					include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_HEADER);
					$xoopsOption['template_main'] = _XTR_TEMPLATE_INDEX_PASSWORD;
					$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', xcenter_getPageTitle($xcenter['xcenter']->getVar('storyid')));
					$GLOBALS['xoTheme']->addMeta( 'meta', 'keywords', xcenter_getMetaKeywords($xcenter['xcenter']->getVar('storyid')));
					$GLOBALS['xoTheme']->addMeta( 'meta', 'description', xcenter_getMetaDescription($xcenter['xcenter']->getVar('storyid')));
					$GLOBALS['xoopsTpl']->assign('xoXcenter', array_merge($xcenter['xcenter']->toArray(), $xcenter['text']->toArray(), $xcenter['perms']));	            
					$GLOBALS['xoopsTpl']->assign('form', xcenter_passwordform($xcenter['xcenter']->getVar('storyid')));
					include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FOOTER);
					exit(0);
				} else {
					$_COOKIE['xcenter_password'][md5(sha1(XOOPS_LICENSE_KEY).$storyid)]=true;
				}
			else 
				$_COOKIE['xcenter_password'][md5(sha1(XOOPS_LICENSE_KEY).$storyid)]=true;
			
		
		}		

	
		echo '<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">';
		echo '<html>';
		echo '<head>';
		echo '	<meta http-equiv="Xcenter-Type" xcenter="text/html; charset=UTF-8"/>';
		echo '	<title>'.xcenter_getPageTitle($xcenter['xcenter']->getVar('storyid'))._XTR_PAGETITLESEP.$GLOBALS['xoopsConfig']['sitename']._XTR_PAGETITLESEP._XTR_PRINTERFRIENDLY.'</title>';
		echo '	<meta name="AUTHOR" xcenter="'.$GLOBALS['xoopsConfig']['sitename'].'"/>';
		echo '	<meta name="COPYRIGHT" xcenter="Copyright (c) 2005'.$GLOBALS['xoopsConfig']['sitename'].'"/>';
		echo '	<meta name="DESCRIPTION" xcenter="'.$GLOBALS['xoopsConfig']['slogan'].'"/>';
		echo '	<meta name="GENERATOR" xcenter="'.XOOPS_VERSION.'"/>';
		echo '	<link rel="stylesheet" type="text/css" media="screen" href="'.XOOPS_URL.'/modules/xcenter/templates/css/print.css" />';
		echo '</head>';		
		echo '<body bgcolor="#FFFFFF" text="#000000" topmargin="10" style="font:12px arial, helvetica, san serif;" onLoad="window.print()">';
		echo '	<table border="0" width="640" cellpadding="10" cellspacing="1" style="border: 1px solid #000000;" align="center">';
		echo '		<tr>';
		echo '			<td align="left">';
		echo '				<strong>'.clear_unicodeslashes($xcenter['text']->getVar('ptitle')).'</strong></td>';
		echo '		</tr>';
		echo '		<tr valign="top">';
		echo '			<td style="padding-top:0px;">';
		
		$nohtml = ($xcenter['xcenter']->getVar('nohtml'))?0:1;
		$nosmiley = ($xcenter['xcenter']->getVar('nosmiley'))?0:1;
		$nobreaks = ($xcenter['xcenter']->getVar('nobreaks'))?0:1;
		
		echo $myts->displayTarea(clear_unicodeslashes($xcenter['text']->getVar('text')), $nohtml, $nosmiley, 1, 1, $nobreaks);
			   
		echo '</td>';
		echo '		</tr>';
		echo '	</table>';
		echo '	<table border="0" width="640" cellpadding="10" cellspacing="1" align="center"><tr><td>';
		printf(_XTR_THISCOMESFROM,$GLOBALS['xoopsConfig']['sitename']);
		echo '<br /><a href="'.XOOPS_URL.'/">'.XOOPS_URL.'</a><br /><br />'._XTR_URLFORSTORY.'<br /><a href="'.XOOPS_URL.'/modules/'.$GLOBALS['xoopsModule']->dirname().'/index.php?id='.$storyid.'">'.XOOPS_URL.'/modules/'.$GLOBALS['xoopsModule']->dirname().'/index.php?storyid='.$storyid.'</a>';
		echo '</td></tr></table></body>';
		echo '</html>';
	
	}
}	


?>
