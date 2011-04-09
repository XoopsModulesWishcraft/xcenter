<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORMLOADER);

include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_LANGUAGES);
include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_CATEGORIES);
include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_PAGES);
include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_BLOCKS);
include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_HTMLTEMPLATES);

if (file_exists($GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_TAG)) && $GLOBALS['xoopsModuleConfig']['tags'])
	include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FORM_TAG);

xoops_load('pagenav');

?>