<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

function xoops_module_pre_install_xcenter(&$module) {
	xoops_load('cache');	
	return (XoopsCache::delete('editorlist'))?true:true;
}

?>