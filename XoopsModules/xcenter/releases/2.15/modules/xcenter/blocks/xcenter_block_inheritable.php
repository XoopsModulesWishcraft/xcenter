<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

	include_once ($GLOBALS['xoops']->path('/modules/xcenter/include/formselectblocks.php'));
	
	function xcenter_block_inheritable_show($options) {
		$xcenter_handler =& xoops_getmodulehandler('xcenter', 'xcenter');
		$block_handler =& xoops_getmodulehandler('block', 'xcenter');
		$xcenter = $xcenter_handler->get(intval($_GET['storyid']));
		if (is_object($xcenter))
			if ($xcenter->getVar('blockid')==0&&$options[0]==0)
				return false;
			elseif ($xcenter->getVar('blockid')!=0)
				$block = $block_handler->getBlock($xcenter->getVar('blockid'), $GLOBALS['xoopsConfig']['language']);
			elseif ($options[0]!=0)
				$block = $block_handler->getBlock($options[0], $GLOBALS['xoopsConfig']['language']);
			else
				return false;
		elseif ($options[0]!=0)
			$block = $block_handler->getBlock($options[0], $GLOBALS['xoopsConfig']['language']);
		else
			return false;
		
		$myts =& MyTextSanitizer::getInstance();
		return array('html' =>  $myts->displayTarea(clear_unicodeslashes($block['text']->getVar('text')), true, true, true, true, false));
	}
	
	if (!function_exists('clear_unicodeslashes')){
		function clear_unicodeslashes($text) {
			$text = str_replace(array("\\'"), "'", $text);
			$text = str_replace(array("\\\\\\'"), "'", $text);
			$text = str_replace(array('\\"'), '"', $text);
			return $text;
		}
	}


	function xcenter_block_inheritable_edit($options) {
		$blockform = new XoopsFormSelectBlocks('', 'options[0]', $options[0]);
		return "Default Block: ".$blockform->render();

	}
?>