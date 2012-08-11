<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


	require "../../../include/cp_header.php";
	
	require_once (dirname(dirname(dirname(dirname(__FILE__)))).'/include/cp_header.php');
	
	if (!defined('_CHARSET'))
		define("_CHARSET","UTF-8");
	if (!defined('_CHARSET_ISO'))
		define("_CHARSET_ISO","ISO-8859-1");
		
	$GLOBALS['myts'] = MyTextSanitizer::getInstance();
	
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_FUNCTIONS));
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_FORMOBJECTS));
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_FORMS));
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_TEMPLATE));
	
	$myts =& MyTextSanitizer::getInstance();
	
	$op = (isset($_REQUEST['op']))?strtolower($_REQUEST['op']):'dashboard';
	$fct = (isset($_REQUEST['fct']))?strtolower($_REQUEST['fct']):'';	
	$storyid = (isset($_REQUEST['storyid']))?intval($_REQUEST['storyid']):0;
	$xcenterid = (isset($_REQUEST['xcenterid']))?intval($_REQUEST['xcenterid']):0;
	$catid = (isset($_REQUEST['catid']))?intval($_REQUEST['catid']):0;
	$blockid = (isset($_REQUEST['blockid']))?intval($_REQUEST['blockid']):0;
	$passkey = (isset($_REQUEST['passkey']))?strtolower($_REQUEST['passkey']):'';	
	$mode = (isset($_REQUEST['mode']))?strtolower($_REQUEST['mode']):_XTR_PERM_MODE_VIEW;	
	$language = (isset($_REQUEST['language']))?($_REQUEST['language']):$GLOBALS['xoopsConfig']['language'];
	
	$module_handler =& xoops_gethandler('module');
	$criteria = new CriteriaCompo(new Criteria('dirname', 'xlanguage'));
	$criteria->add(new Criteria('isactive', true));
	if ($module_handler->getCount($criteria)>0)
		$GLOBALS['multilingual']=true;
	else
		$GLOBALS['multilingual']=false;
	
	$GLOBALS['contentTpl'] = new XoopsTpl();
		
	$module_handler = xoops_gethandler('module');
	$config_handler = xoops_gethandler('config');
	$GLOBALS['xcenterModule'] = $module_handler->getByDirname('xcenter');
	$GLOBALS['xcenterModuleConfig'] = $config_handler->getConfigList($GLOBALS['xcenterModule']->getVar('mid')); 
		
	xoops_load('pagenav');	
	xoops_load('xoopslists');
	xoops_load('xoopsformloader');
	
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopsmailer.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopstree.php');
	
	if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
	        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
	        //return true;
	    }else{
	        echo xcenter_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
	        //return false;
	    }
	$GLOBALS['xcenterImageIcon'] = XOOPS_URL .'/'. $GLOBALS['xcenterModule']->getInfo('icons16');
	$GLOBALS['xcenterImageAdmin'] = XOOPS_URL .'/'. $GLOBALS['xcenterModule']->getInfo('icons32');
	
	if ($GLOBALS['xoopsUser']) {
	    $moduleperm_handler =& xoops_gethandler('groupperm');
	    if (!$moduleperm_handler->checkRight('module_admin', $GLOBALS['xcenterModule']->getVar( 'mid' ), $GLOBALS['xoopsUser']->getGroups())) {
	        redirect_header(XOOPS_URL, 1, _NOPERM);
	        exit();
	    }
	} else {
	    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
	    exit();
	}
	
	if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
		include_once(XOOPS_ROOT_PATH."/class/template.php");
		$GLOBALS['xoopsTpl'] = new XoopsTpl();
	}
	
	$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['xcenterImageIcon']);
	$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['xcenterImageAdmin']);
	
	
?>