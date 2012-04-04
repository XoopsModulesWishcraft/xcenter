<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

function xoops_module_update_xcenter(&$module) {
	
	if ($module->getVar('version')<=213) {
				
		$text_handler =& xoops_getmodulehandler('text', 'xcenter');
		
		$texts = $text_handler->getObjects(NULL, false);
		
		foreach($texts as $xcenterid => $text) {
			$text->setVar('title', urldecode($text->getVar('title')));
			$text->setVar('ptitle', urldecode($text->getVar('ptitle')));
			$text->setVar('text', urldecode($text->getVar('text')));
			$text->setVar('rss', urldecode($text->getVar('rss')));
			$text->setVar('keywords', urldecode($text->getVar('keywords')));
			$text->setVar('page_description', urldecode($text->getVar('page_description')));
			$text_handler->insert($text);	
		}
	
	}
	return true;
	
}

?>