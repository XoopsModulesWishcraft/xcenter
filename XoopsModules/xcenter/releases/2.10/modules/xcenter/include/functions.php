<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


	function xcenter_getpostinglocal() {
		if (strpos($_SERVER['PHP_SELF'], '/admin/index.php')==0)
			return '/manage.php';
		else
			return '/admin/index.php';
	}
	
	
	function xcenter_checkperm($op, $fct, $storyid, $catid, $blockid, $securitymode) {

		$gperm_handler =& xoops_gethandler('groupperm');
		$config_handler =& xoops_gethandler('config');
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
		$module_handler =& xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname('xcenter');
		$modid = $xoModule->getVar('mid');
		$xoConfig = $config_handler->getConfigList($modid, 0);
		if (strlen($securitymode)==0)
			$securitymode = $xoConfig['security'];
		
		switch ($op){
		case _XTR_URL_OP_SAVE:
			switch($securitymode)  {
			default:
			case _XTR_SECURITY_BASIC:
				return true;
				break;
			case _XTR_SECURITY_INTERMEDIATE:
			case _XTR_SECURITY_ADVANCED:
				switch ($fct) {
				case _XTR_URL_FCT_PAGES;
					foreach($catid as $id => $val)
						if (!$gperm_handler->checkRight(_XTR_PERM_MODE_ADD._XTR_PERM_TYPE_CATEGORY,$val,$groups, $modid))
							return false;
					return true;
					break;
				case _XTR_URL_FCT_XCENTER:
					if ($storyid==0) 
						return $gperm_handler->checkRight(_XTR_PERM_MODE_ADD._XTR_PERM_TYPE_XCENTER,$catid,$groups, $modid);
					else
						return true;
					break;		
				}
				break;
			}
		case _XTR_URL_OP_EDIT:
			switch($securitymode)  {
			case _XTR_SECURITY_BASIC:
			case _XTR_SECURITY_INTERMEDIATE:
				switch ($fct) {
				case _XTR_URL_FCT_XCENTER:
					return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_XCENTER,$groups, $modid);
					break;		
				case _XTR_URL_FCT_CATEGORY:
				case _XTR_URL_FCT_CATEGORIES:
					return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_CATEGORY,$groups, $modid);
					break;		
				case _XTR_URL_FCT_BLOCK:
				case _XTR_URL_FCT_BLOCKS:
					return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_BLOCK,$groups, $modid);
					break;															
				}
				break;
			case _XTR_SECURITY_ADVANCED:
				switch ($fct) {
				case _XTR_URL_FCT_XCENTER:
					if (!$gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_XCENTER,$groups, $modid))
						return false;
					return $gperm_handler->checkRight(_XTR_PERM_MODE_EDIT._XTR_PERM_TYPE_XCENTER,$storyid,$groups, $modid);
					break;		
				case _XTR_URL_FCT_CATEGORY:
				case _XTR_URL_FCT_CATEGORIES:
					if (!$gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_CATEGORY,$groups, $modid))
						return false;
					return $gperm_handler->checkRight(_XTR_PERM_MODE_EDIT._XTR_PERM_TYPE_CATEGORY,$catid,$groups, $modid);
					break;		
				case _XTR_URL_FCT_BLOCK:
				case _XTR_URL_FCT_BLOCKS:
					if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_BLOCK,$groups, $modid))
						return false;
					return $gperm_handler->checkRight(_XTR_PERM_MODE_EDIT._XTR_PERM_TYPE_BLOCK,$blockid,$groups, $modid);
					break;															
				}
				break;
			}
		case _XTR_URL_OP_ADD:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCK:
			case _XTR_URL_FCT_BLOCKS:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_DELETE:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_DELETE_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_DELETE_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCK:
			case _XTR_URL_FCT_BLOCKS:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_DELETE_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_COPY:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_COPY_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_COPY_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCK:
			case _XTR_URL_FCT_BLOCKS:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_COPY_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_MANAGE:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCKS:
			case _XTR_URL_FCT_BLOCK:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_PERMISSIONS:
			return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_PERMISSIONS,$groups, $modid);
			break;
		}
			
	}
	
	function loadUserMenu($currentoption, $breadcrumb = "")
	{
		$adminmenu = array();

		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_XCENTER]['title'] = _XTR_XCENTER_ADMENU1;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_XCENTER]['link']  = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_XCENTER;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_XCENTER]['title'] = _XTR_XCENTER_ADMENU2;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_XCENTER]['link']  = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_XCENTER;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_CATEGORY]['title'] = _XTR_XCENTER_ADMENU3;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_CATEGORY]['link']  = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_CATEGORIES;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_CATEGORY]['title'] = _XTR_XCENTER_ADMENU4;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_CATEGORY]['link']  = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_CATEGORY;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_BLOCK]['title'] = _XTR_XCENTER_ADMENU5;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_BLOCK]['link']  = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_BLOCKS;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_BLOCK]['title'] = _XTR_XCENTER_ADMENU6;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_BLOCK]['link']  = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_BLOCKS;
		$adminmenu[_XTR_PERM_TEMPLATE_PERMISSIONS]['title'] = _XTR_XCENTER_ADMENU7;
		$adminmenu[_XTR_PERM_TEMPLATE_PERMISSIONS]['link']  = "manage.php?op="._XTR_URL_OP_PERMISSIONS."&fct="._XTR_URL_FCT_TEMPLATE.'&mode='._XTR_PERM_MODE_ALL;

		$breadcrumb = empty($breadcrumb) ? $adminmenu[$currentoption]["title"] : $breadcrumb;
		$module_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/";
		$image_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/images";
		
		$adminmenu_text ='
		<style type="text/css">
		<!--
		#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0;}
		#buttonbar { float:left; width:100%; background: #e7e7e7 url("'.$image_link.'/modadminbg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px;}
		#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url("'.$image_link.'/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url("'.$image_link.'/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar .current a { background-position:0 -150px; border-width:0; }
		#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }    
		//-->
		</style>
		<div id="buttontop">
		 <table style="width: 100%; padding: 0; " cellspacing="0">
			 <tr>
				 <td style="width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">
					 <a href="index.php">'.$GLOBALS["xoopsModule"]->getVar("name").'</a>
				 </td>
				 <td style="width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;">
					 <strong>'.$GLOBALS["xoopsModule"]->getVar("name").'</strong>&nbsp;'.$breadcrumb.'
				 </td>
			 </tr>
		 </table>
		</div>
		<div id="buttonbar">
		 <ul>
		';
		
		$gperm_handler =& xoops_gethandler('groupperm');
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
		$module_handler =& xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname(_XTR_DIRNAME);
		$modid = $xoModule->getVar('mid');
	
		foreach (array_keys($adminmenu) as $key) {
			$j++;
			if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,$key,$groups, $modid))
				$adminmenu_text .= (($currentoption == $j) ? '<li class="current">' : '<li>').'<a href="'.$module_link.$adminmenu[$key]["link"].'"><span>'.$adminmenu[$key]["title"].'</span></a></li>';
		}
		 $adminmenu_text .= '</ul>
		</div>
		<br style="clear:both;" />';
		
		return $adminmenu_text;
	}
		
	
	if (!function_exists('xoops_sef')) {
		function xoops_sef($datab, $char ='-')
		{
			$datab = urldecode(strtolower($datab));
			$datab = urlencode($datab);
			$datab = str_replace(urlencode('æ'),'ae',$datab);
			$datab = str_replace(urlencode('ø'),'oe',$datab);
			$datab = str_replace(urlencode('å'),'aa',$datab);
			$replacement_chars = array(' ', '|', '=', '\\', '+', '-', '_', '{', '}', ']', '[', '\'', '"', ';', ':', '?', '>', '<', '.', ',', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '`', '~', ' ', '', '¡', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '­', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿');
			$return_data = str_replace($replacement_chars,$char,urldecode($datab));
			#print $return_data."<BR><BR>";
			switch ($char) {
			default:
				return urldecode($return_data);
				break;
			case "-";
				return urlencode($return_data);
				break;
			}
		}
	}
	
	if (!function_exists('clear_unicodeslashes')){
		function clear_unicodeslashes($text) {
			$text = str_replace(array("\\'"), "'", $text);
			$text = str_replace(array("\\\\\\'"), "'", $text);
			$text = str_replace(array('\\"'), '"', $text);
			return $text;
		}
	}
	
	function xcenter_getBreadcrumb($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('parent_id')!=0)
			$children = xcenter_getChildrenTree(array(), $storyid);
		else
			$children = array(0 => $storyid);
		
		$crumb = array();
		$j = 0;
		foreach(array_reverse($children) as $storyid) {
			$j++;
			$crumb[$storyid]['title'] = xcenter_getField($storyid, 'title');
			$crumb[$storyid]['ptitle'] = xcenter_getField($storyid, 'ptitle');
			$crumb[$storyid]['url'] = XOOPS_URL.'/modules/xcenter/?storyid='.$storyid;
			if ($j==count($children))
				$crumb[$storyid]['last'] = true;
		}
		return $crumb;
	}

	function xcenter_getChildrenTree($children, $storyid=0)
	{
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('parent_id')!=0){
			$children[$storyid] = $storyid;
			$children = xcenter_getChildrenTree($children, $xcenter->getVar('parent_id'));
		} else
			$children[$storyid] = $storyid;
		return $children;	
	}


	function xcenter_passkey()
	{
		return md5(sha1(XOOPS_LICENSE_KEY).date('Ymd'));
	}
	
	function xcenter_getPageTitle($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('catid')>0) {
			return xcenter_getTitle($storyid)._XTR_PAGETITLESEP.xcenter_getCatTitle($xcenter->getVar('catid'));
		} else {
			return xcenter_getTitle($storyid);
		}
	}
	
	function xcenter_getMetaKeywords($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('catid')>0) {
			return xcenter_getField($storyid, 'keywords'). ', '. xcenter_getCatField($xcenter->getVar('catid'), 'keywords');
		} else {
			return xcenter_getField($storyid, 'keywords');
		}
	}

	function xcenter_getMetaDescription($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('catid')>0) {
			$catid = $xcenter->getVar('catid');
			$desc = xcenter_getField($storyid, 'page_description');
			if (empty($desc)) 
				return xcenter_getCatField($catid, 'page_description');
			else
				return $desc;
		} else {
			return xcenter_getField($storyid, 'page_description');
		}
	}
	
	function xcenter_getTitle($storyid) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));
		if ($texts = $text_handler->getObjects($criteria)){
			return $texts[0]->getVar('title');
		} else {
			$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));	
			if ($texts = $text_handler->getObjects($criteria)){
				return $texts[0]->getVar('title');
			} else {
				return _XTR_NOTITLESPECIFIED;
			}
		} 
	}
	
	function xcenter_getBlockTitle($blockid) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));
		if ($texts = $text_handler->getObjects($criteria)){
			return $texts[0]->getVar('title');
		} else {
			$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));	
			if ($texts = $text_handler->getObjects($criteria)){
				return $texts[0]->getVar('title');
			} else {
				return _XTR_NOTITLESPECIFIED;
			}
		} 
	}	
	
	function xcenter_getCatTitle($catid) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('catid', $catid));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));		
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		if ($texts = $text_handler->getObjects($criteria)){
			return $texts[0]->getVar('title');
		} else {
			$criteria = new CriteriaCompo(new Criteria('catid', $catid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));	
			if ($texts = $text_handler->getObjects($criteria)){
				return $texts[0]->getVar('title');
			} else {
				return _XTR_NOTCATITLESPECIFIED;
			}
		} 
	}

	function xcenter_getField($storyid, $field) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));
		if ($texts = $text_handler->getObjects($criteria)){
			return clear_unicodeslashes($texts[0]->getVar($field));
		} else {
			$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));	
			if ($texts = $text_handler->getObjects($criteria)){
				return clear_unicodeslashes($texts[0]->getVar($field));
			} else {
				return '';
			}
		} 
	}
	
	function xcenter_getCatField($catid, $field) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('catid', $catid));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));		
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		if ($texts = $text_handler->getObjects($criteria)){
			return clear_unicodeslashes($texts[0]->getVar($field));
		} else {
			$criteria = new CriteriaCompo(new Criteria('catid', $catid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));	
			if ($texts = $text_handler->getObjects($criteria)){
				return clear_unicodeslashes($texts[0]->getVar($field));
			} else {
				return '';
			}
		} 
	}

	function xcenter_getBlockField($blockid, $field) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));		
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		if ($texts = $text_handler->getObjects($criteria)){
			return clear_unicodeslashes($texts[0]->getVar($field));
		} else {
			$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));	
			if ($texts = $text_handler->getObjects($criteria)){
				return clear_unicodeslashes($texts[0]->getVar($field));
			} else {
				return '';
			}
		} 
	}

?>