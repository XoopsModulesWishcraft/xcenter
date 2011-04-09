<?php
// $Id: newbb.php,v 1.1 2005/04/07 09:23:42 gij Exp $
// FILE		::	newbb.php
// AUTHOR	::	Ryuji AMANO <info@ryus.co.jp>
// WEB		::	Ryu's Planning <http://ryus.co.jp/>

// NewBBversion/newbb2 plugin: D.J., http://xoops.org.cn

function b_sitemap_xcenter(){
    global $sitemap_configs;
    $sitemap = array();

	// Get All Forums with access permission
	$xcenter_handler =& xoops_getmodulehandler('xcenter', 'xcenter');
	$xcenters = $xcenter_handler->getObjects(NULL, true);
	
	$gperm_handler =& xoops_gethandler('groupperm');
	$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
	$module_handler =& xoops_gethandler('module');
	$xoModule = $module_handler->getByDirname(_BRC_DIRNAME);
	$modid = $xoModule->getVar('mid');
	
	foreach ($xcenters as $storyid => $xcenter) {

		if ($gperm_handler->checkRight(_BRC_PERM_MODE_VIEW._BRC_PERM_TYPE_CONTENT,$storyid,$groups, $modid) && 
			$gperm_handler->checkRight(_BRC_PERM_MODE_VIEW._BRC_PERM_TYPE_CATEGORY,$xcenter->getVar('catid'),$groups, $modid)) {		
			$text = $xcenter_handler->getContent($storyid);
			$pages[$storyid] = array(
					'id' => $storyid,
					'cid' => $xcenter->getVar('catid'),
					'url' => "index.php?storyid=".$storyid,
					'title' => $text['text']->getVar('title'));
		}

	}

	if(count($pages)>0) 
	foreach ( $pages as $id=>$page ) {
		$sitemap['parent'][$id] = $page;
		unset($pages);
	}

	return $sitemap;
}
?>