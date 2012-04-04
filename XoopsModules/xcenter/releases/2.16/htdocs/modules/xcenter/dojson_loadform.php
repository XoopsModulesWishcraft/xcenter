<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

include ('header.php');
$GLOBALS['xoopsLogger']->activated = false;
include ($GLOBALS['xoops']->path(_XTR_PATH_PHP_JSON));

$json = new services_JSON();

$values = array();
$submit = true;
if ($passkey!=xcenter_passkey())
{
	ob_start();
	xoops_error(_XTR_MSG_SECURITYTOKEN);
	$msg = ob_get_xcenters();
	ob_end_clean();
}

	switch($form){
	case _XTR_URL_FORM_XCENTER:
		if (!$msg)
			$values['innerhtml']['forms'] = xcenter_addxcenter($storyid, $_GET['language']);
		else
			$values['innerhtml']['forms'] = $msg;
		break;
	case _XTR_URL_FORM_CATEGORY:
		if (!$msg)
			$values['innerhtml']['forms'] = xcenter_addcategory($catid, $_GET['language']);
		else
			$values['innerhtml']['forms'] = $msg;
		break;		
	case _XTR_URL_FORM_BLOCK:
		if (!$msg)
			$values['innerhtml']['forms'] = xcenter_addblock($blockid, $_GET['language']);
		else
			$values['innerhtml']['forms'] = $msg;
		break;				
	}

print $json->encode($values);
?>