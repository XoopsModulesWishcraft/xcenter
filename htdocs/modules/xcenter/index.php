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

$xoopsOption['template_main'] = _XTR_TEMPLATE_INDEX;
include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_HEADER);

$GLOBALS['xoopsTpl']->assign('passkey', xcenter_passkey());
if ($GLOBALS['xoopsModuleConfig']['force_jquery']) $GLOBALS['xoTheme']->addScript(XOOPS_URL._XTR_PATH_JS_JQUERY);
if ($GLOBALS['xoopsModuleConfig']['json']) $GLOBALS['xoTheme']->addScript( XOOPS_URL._XTR_PATH_JS_CORE );
$GLOBALS['xoTheme']->addStylesheet( XOOPS_URL._XTR_PATH_CSS_INDEX );

$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);

if (!empty($storyid)&&$xcenter_handler->getCount(new Criteria('storyid', $storyid))!=0) {
	if ($xcenter = $xcenter_handler->getContent($storyid)) {

		if (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_XCENTER,$xcenter['xcenter']->getVar('storyid'),$groups, $modid))
			redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
		elseif ( !$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_CATEGORY,$xcenter['xcenter']->getVar('catid'),$groups, $modid)
				&& $GLOBALS['xoopsModuleConfig']['security'] != _XTR_SECURITY_BASIC )
			redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
		else {
			
			if ($GLOBALS['xoopsModuleConfig']['htaccess'])
				if (strpos($_SERVER['REQUEST_URI'], 'odules/')>0) {
					$category_handler =& xoops_getmodulehandler(_XTR_CLASS_CATEGORY, _XTR_DIRNAME);
					$category = $category_handler->getCategory($xcenter['xcenter']->getVar('catid'));
					if ($category['text']->getVar('title')!='') {
						header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.xoops_sef($category['text']->getVar('title')).'/'.xoops_sef($xcenter['text']->getVar('ptitle')).'/'.$xcenter['xcenter']->getVar('storyid').','.$xcenter['xcenter']->getVar('catid').$GLOBALS['xoopsModuleConfig']['endofurl']);
					} else {
						header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.xoops_sef($xcenter['text']->getVar('ptitle')).'/'.$xcenter['xcenter']->getVar('storyid').','.$xcenter['xcenter']->getVar('catid').$GLOBALS['xoopsModuleConfig']['endofurl']);
					}
					exit(0);
				}
			
			if ($xcenter['xcenter']->getVar('link')==1&&$xcenter['xcenter']->getVar('address')!='http://') {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.$xcenter['xcenter']->getVar('address'));
				exit(0);
			}
			
			if ($xcenter['xcenter']->getVar('storyid')>0&&$xcenter['xcenter']->getVar('visible')==1) {
				
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
				
				$member_handler =& xoops_gethandler('member');
				$author = $member_handler->getUser($xcenter['xcenter']->getVar('uid'));
				$GLOBALS['xoopsTpl']->assign('xoAuthor', $author->toArray());
				$GLOBALS['xoopsTpl']->assign('xoPubdate', date(_SHORTDATESTRING, $xcenter['xcenter']->getVar('date')));
				$GLOBALS['xoopsTpl']->assign('xoXcenter', array_merge($xcenter['xcenter']->toArray(), $xcenter['text']->toArray(), $xcenter['perms']));
				$GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
				$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);			
				$GLOBALS['xoopsTpl']->assign('breadcrumb', xcenter_getBreadCrumb($xcenter['xcenter']->getVar('storyid')));
				$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', xcenter_getPageTitle($xcenter['xcenter']->getVar('storyid')));
				$GLOBALS['xoTheme']->addMeta( 'meta', 'keywords', xcenter_getMetaKeywords($xcenter['xcenter']->getVar('storyid')));
				$GLOBALS['xoTheme']->addMeta( 'meta', 'description', xcenter_getMetaDescription($xcenter['xcenter']->getVar('storyid')));
	
				$nohtml = ($xcenter['xcenter']->getVar('nohtml'))?0:1;
				$nosmiley = ($xcenter['xcenter']->getVar('nosmiley'))?0:1;
				$nobreaks = ($xcenter['xcenter']->getVar('nobreaks'))?0:1;
	
				$GLOBALS['xoopsTpl']->assign('catid', $xcenter['xcenter']->getVar('catid'));
				$GLOBALS['xoopsTpl']->assign('xcenter_pagetitle', $xcenter['text']->getVar('ptitle'));
				$GLOBALS['xoopsTpl']->assign('xcenter_text', $myts->displayTarea(clear_unicodeslashes($xcenter['text']->getVar('text')), $nohtml, $nosmiley, 1, 1, $nobreaks));
	
				if (file_exists($GLOBALS['xoops']->path("/modules/tag/include/tagbar.php"))) {
					include_once XOOPS_ROOT_PATH."/modules/tag/include/tagbar.php";
					$GLOBALS['xoopsTpl']->assign('tagbar', tagBar($xcenter['xcenter']->getVar('storyid'), $catid = 0));
				}
			} else {
				redirect_header(XOOPS_URL, 10, _XTR_NOTVISIBLE);
			}
		}
	}
} else {
	if ($xcenter = $xcenter_handler->getHompage()) {

		if (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_XCENTER,$xcenter['xcenter']->getVar('storyid'),$groups, $modid))
			redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
		elseif (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_CATEGORY,$xcenter['xcenter']->getVar('catid'),$groups, $modid)
				&& $GLOBALS['xoopsModuleConfig']['security'] != _XTR_SECURITY_BASIC )
			redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
		else {

			if ($xcenter['xcenter']->getVar('link')==1&&$xcenter['xcenter']->getVar('address')!='http://') {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.$xcenter['xcenter']->getVar('address'));
				exit(0);
			}

			if ($xcenter['xcenter']->getVar('storyid')>0) {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/modules/xcenter/?storyid='.$xcenter['xcenter']->getVar('storyid'));
				exit(0);
			}
		}
	}
}
include $GLOBALS['xoops']->path('/include/comment_view.php');
include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FOOTER);
?>