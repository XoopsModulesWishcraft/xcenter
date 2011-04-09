<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


	require ('../../mainfile.php');

	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_FUNCTIONS));
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_FORMOBJECTS));
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_FORMS));
	require_once($GLOBALS['xoops']->path(_XTR_PATH_PHP_TEMPLATE));

	$myts =& MyTextSanitizer::getInstance();

	$gperm_handler =& xoops_gethandler('groupperm');
	$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
	$module_handler =& xoops_gethandler('module');
	$xoModule = $module_handler->getByDirname(_XTR_DIRNAME);
	$modid = $xoModule->getVar('mid');

	$op = (isset($_REQUEST['op']))?strtolower($_REQUEST['op']):'';
	$fct = (isset($_REQUEST['fct']))?strtolower($_REQUEST['fct']):'';	
	$storyid = (isset($_REQUEST['storyid']))?intval($_REQUEST['storyid']):0;
	$xcenterid = (isset($_REQUEST['xcenterid']))?intval($_REQUEST['xcenterid']):0;	
	$catid = (isset($_REQUEST['catid']))?intval($_REQUEST['catid']):0;	
	$blockid = (isset($_REQUEST['blockid']))?intval($_REQUEST['blockid']):0;	
	$form = (isset($_REQUEST['form']))?strtolower($_REQUEST['form']):'';
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
	
?>