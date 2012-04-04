<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


$i=0;

$modversion['name']		    = _XTR_MODULENAME;
$modversion['version']		= _XTR_VERSION;
$modversion['author']       = _XTR_AUTHOR;
$modversion['description']	= _XTR_DESCRIPTION;
$modversion['credits']		= _XTR_OWNER;
$modversion['license']		= _XTR_LICENSE;
$modversion['official']		= _XTR_OFFICIAL;
$modversion['image']		= _XTR_LOGOIMAGE;
$modversion['dirname']		= _XTR_DIRNAME;

$modversion['website'] 		= 'www.chronolabs.coop';

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

$modversion['release_info'] = "Stable 2012/03/04";
$modversion['release_file'] = XOOPS_URL."/modules/xcentre/docs/changelog.txt";
$modversion['release_date'] = "2012/03/04";

$modversion['author_realname'] = "Simon Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.coop";
$modversion['author_website_name'] = "Chronolabs Cooperative";
$modversion['author_email'] = "simon@chronolabs.coop";
$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "";
$modversion['support_site_name'] = "";
$modversion['submit_bug'] = "";
$modversion['submit_feature'] = "";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = _XTR_SQLFILE_MYSQL;

// Tables created by sql file (without prefix!)
$modversion['tables'][0]	=  _XTR_TABLE_XCENTER;
$modversion['tables'][1]	=  _XTR_TABLE_CATEGORY;
$modversion['tables'][2]	=  _XTR_TABLE_TEXT;
$modversion['tables'][3]	=  _XTR_TABLE_BLOCK;

// Admin things
$modversion['hasAdmin']		= _XTR_HASADMIN;
$modversion['adminindex']	= _XTR_ADMIN_INDEX;
$modversion['adminmenu']	= _XTR_ADMIN_MENU;
$modversion['system_menu'] 	= _XTR_SYSTEM_MENU;
// Search
$modversion['hasSearch'] 	= _XTR_HASSEARCH;
$modversion['search']['file'] = _XTR_SEARCH_FILE;
$modversion['search']['func'] = _XTR_SEARCH_FUNCTION;

// Comments
$modversion['hasComments'] = _XTR_HASCOMMENT;
$modversion['comments']['itemName'] = _XTR_COMMENT_ITEM;
$modversion['comments']['pageName'] = _XTR_COMMENT_PAGE;

// Menu
$modversion['onInstall'] = _XTR_INSTALL;
$modversion['onUpdate'] = _XTR_UPDATE;

// Menu
$modversion['hasMain'] = _XTR_HASMAIN;

// Smarty
$modversion['use_smarty'] = _XTR_USESMARTY;

// Templates
$i=1;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_BREADCRUMB;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_BREADCRUMB_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_CPANEL_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_CPANEL_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_CPANEL_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_CPANEL_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_CPANEL_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_CPANEL_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_CPANEL_JSON_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_CPANEL_JSON_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_JSON_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_JSON_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_JSON_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_JSON_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_MANAGE;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_MANAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _XTR_TEMPLATE_INDEX_PASSWORD;
$modversion['templates'][$i]['description'] = _XTR_TEMPLATE_INDEX_PASSWORD_DESC;


// Submenu Items
$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
$criteria = new CriteriaCompo(new Criteria('homepage', false));
$criteria->add(new Criteria('submenu', true));
$criteria->add(new Criteria('parent_id', 0));
$criteria->add(new Criteria('visible', 1));

$criteria_publish = new CriteriaCompo(new Criteria('publish', time(), '<'), "OR");
$criteria_publish->add(new Criteria('publish', 0), 'OR');
$criteria_expire = new CriteriaCompo(new Criteria('expire', time(), '>'), "OR");
$criteria_expire->add(new Criteria('expire', 0), 'OR');

$criteria->add($criteria_publish);
$criteria->add($criteria_expire);

$xcenters = $xcenter_handler->getObjects($criteria, true);

$gperm_handler =& xoops_gethandler('groupperm');
$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
$module_handler =& xoops_gethandler('module');
if ( $xoModule = $module_handler->getByDirname('xcenter') ) {
	$modid = $xoModule->getVar('mid');
	
	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_XCENTER,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_ADD_XCENTER_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_XCENTER;
		$i++;	
	}

	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_CATEGORY,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_ADD_CATEGORY_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_CATEGORY;
		$i++;	
	}

	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_BLOCK,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_ADD_BLOCK_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_BLOCKS;
		$i++;	
	}
	
	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_XCENTER,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_MANAGE_XCENTER_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_XCENTER;
		$i++;	
	}

	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_CATEGORY,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_MANAGE_CATEGORY_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_CATEGORIES;
		$i++;	
	}
	
	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_BLOCK,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_MANAGE_BLOCK_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_BLOCKS;
		$i++;	
	}

	if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_PERMISSIONS,$groups, $modid)) {
		$modversion['sub'][$i]['name'] = _XTR_PERM_TEMPLATE_PERMISSIONS_DESC;
		$modversion['sub'][$i]['url'] = "manage.php?op="._XTR_URL_OP_PERMISSIONS;
		$i++;	
	}
	
	foreach($xcenters as $storyid => $xcenter)
	{
		if ($gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_XCENTER,$xcenter->getVar('storyid'),$groups, $modid) &&
			$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_CATEGORY,$xcenter->getVar('catid'),$groups, $modid)) {
			$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
			$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
			if ($texts = $text_handler->getObjects($criteria)) {
				$modversion['sub'][$i]['name'] = $texts[0]->getVar('title');
				$modversion['sub'][$i]['url'] = "index.php?storyid=".$storyid."";
				$i++;
			}
		}
	} 
}

// Blocks

$modversion["blocks"][1]    = array(
    "file"            => "xcenter_block_tag.php",
    "name"            => "Module Tag Cloud",
    "description"     => "Show tag cloud",
    "show_func"       => "xcenter_tag_block_cloud_show",
    "edit_func"       => "xcenter_tag_block_cloud_edit",
    "options"         => "100|0|150|80",
    "template"        => "xcenter_tag_block_cloud.html",
    );
	
$modversion["blocks"][2]    = array(
    "file"            => "xcenter_block_tag.php",
    "name"            => "Module Top Tags",
    "description"     => "Show top tags",
    "show_func"       => "xcenter_tag_block_top_show",
    "edit_func"       => "xcenter_tag_block_top_edit",
    "options"         => "50|30|c",
    "template"        => "xcenter_tag_block_top.html",
    );

$modversion["blocks"][3]    = array(
    "file"            => "xcenter_block_subitems.php",
    "name"            => "Subitems Menu for Xcenter",
    "description"     => "Subitems Menu for Xcenter",
    "show_func"       => "xcenter_block_subitems_show",
    "edit_func"       => "xcenter_block_subitems_edit",
    "options"         => "",
    "template"        => "xcenter_block_subitems.html",
    );

$modversion["blocks"][4]    = array(
    "file"            => "xcenter_block_menu.php",
    "name"            => "Menu for Xcenter",
    "description"     => "Menu for Xcenter",
    "show_func"       => "xcenter_block_menu_show",
    "edit_func"       => "xcenter_block_menu_edit",
    "options"         => "",
    "template"        => "xcenter_block_menu.html",
    );

$modversion["blocks"][5]    = array(
    "file"            => "xcenter_block_inheritable.php",
    "name"            => "Inheritable Block for Xcenter",
    "description"     => "Inheritable Block for Xcenter",
    "show_func"       => "xcenter_block_inheritable_show",
    "edit_func"       => "xcenter_block_inheritable_edit",
    "options"         => "",
    "template"        => "xcenter_block_inheritable.html",
    );
	
$modversion["blocks"][6]    = array(
    "file"            => "xcenter_block_sections.php",
    "name"            => "Section Block for Xcenter",
    "description"     => "Section Block for Xcenter",
    "show_func"       => "xcenter_block_sections_show",
    "edit_func"       => "xcenter_block_sections_edit",
    "options"         => "",
    "template"        => "xcenter_block_sections.html",
    );
	
	
$i=1;
xoops_load('XoopsEditorHandler');
$editor_handler = XoopsEditorHandler::getInstance();
foreach ($editor_handler->getList(false) as $id => $val)
	$options[$val] = $id;
	
$i++;
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = "_XTR_EDITORS";
$modversion['config'][$i]['description'] = "_XTR_EDITORS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tinymce';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'json';
$modversion['config'][$i]['title'] = "_XTR_USEJSON";
$modversion['config'][$i]['description'] = "_XTR_USEJSON_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'rss';
$modversion['config'][$i]['title'] = "_XTR_RSSICON";
$modversion['config'][$i]['description'] = "_XTR_RSSICON_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'print';
$modversion['config'][$i]['title'] = "_XTR_PRINTICON";
$modversion['config'][$i]['description'] = "_XTR_PRINTICON_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'share';
$modversion['config'][$i]['title'] = "_XTR_ADDTHIS";
$modversion['config'][$i]['description'] = "_XTR_ADDTHISICON_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'sharecode';
$modversion['config'][$i]['title'] = "_XTR_ADDTHISCODE";
$modversion['config'][$i]['description'] = "_XTR_ADDTHISCODE_DESC";
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xoops" class="addthis_button_compact">Share</a>
<span class="addthis_separator">|</span>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_myspace"></a>
<a class="addthis_button_google"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_email"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xoops"></script>
<!-- AddThis Button END -->
';

$i++;
$modversion['config'][$i]['name'] = 'pdf';
$modversion['config'][$i]['title'] = "_XTR_PDFICON";
$modversion['config'][$i]['description'] = "_XTR_PDFICON_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'writtenby';
$modversion['config'][$i]['title'] = "_XTR_WRITENBY";
$modversion['config'][$i]['description'] = "_XTR_WRITENBY_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'breadcrumb';
$modversion['config'][$i]['title'] = "_XTR_BREADCRUMB";
$modversion['config'][$i]['description'] = "_XTR_BREADCRUMB_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_XTR_HTACCESS";
$modversion['config'][$i]['description'] = "_XTR_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_XTR_BASEURL";
$modversion['config'][$i]['description'] = "_XTR_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'xcenter';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_XTR_ENDOFURL";
$modversion['config'][$i]['description'] = "_XTR_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_rss';
$modversion['config'][$i]['title'] = "_XTR_ENDOFURLRSS";
$modversion['config'][$i]['description'] = "_XTR_ENDOFURLRSS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.rss';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_pdf';
$modversion['config'][$i]['title'] = "_XTR_ENDOFURLPDF";
$modversion['config'][$i]['description'] = "_XTR_ENDOFURLPDF_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.pdf';

$i++;
$modversion['config'][$i]['name'] = 'force_jquery';
$modversion['config'][$i]['title'] = "_XTR_FORCEJQUERY";
$modversion['config'][$i]['description'] = "_XTR_FORCEJQUERY_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'force_cpanel_jquery';
$modversion['config'][$i]['title'] = "_XTR_FORCECPANELJQUERY";
$modversion['config'][$i]['description'] = "_XTR_FORCECPANELJQUERY_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'security';
$modversion['config'][$i]['title'] = "_XTR_SECURITY";
$modversion['config'][$i]['description'] = "_XTR_SECURITY_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _XTR_SECURITY_BASIC;
$modversion['config'][$i]['options'] = array(_XTR_SECURITY_BASIC_DESC => _XTR_SECURITY_BASIC,
											 _XTR_SECURITY_INTERMEDIATE_DESC => _XTR_SECURITY_INTERMEDIATE,
											 _XTR_SECURITY_ADVANCED_DESC => _XTR_SECURITY_ADVANCED);

$i++;
$modversion['config'][$i]['name'] = 'multilingual';
$modversion['config'][$i]['title'] = "_XTR_MUlTILINGUAL";
$modversion['config'][$i]['description'] = "_XTR_MUlTILINGUAL_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'tags';
$modversion['config'][$i]['title'] = "_XTR_SUPPORTTAGS";
$modversion['config'][$i]['description'] = "_XTR_SUPPORTTAGS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

?>
