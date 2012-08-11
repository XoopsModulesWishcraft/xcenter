<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


	// XOOPS VERSION
	
	// DO NOT CHANGE - HEADER INFORMATION
	define('_XTR_MODULENAME','Content Module');
	define('_XTR_VERSION', 2.16);
	define('_XTR_AUTHOR','Written by Simon Roberts aka. Wishcraft');
	define('_XTR_OWNER','Chronolabs');
	define('_XTR_CONTACT','All inquiries regarding the module can be sent to simon@chronolabs.coop');
	define('_XTR_DESCRIPTION','Advanced Multilingual Content Module');
	define('_XTR_LICENSE','GPL 2.0 - See /docs/LICENCE');
	define('_XTR_OFFICIAL', true);
	define('_XTR_LOGOIMAGE','images/xcenter_slogo.png');
	define('_XTR_DIRNAME','xcenter');
	define('_XTR_SQLFILE_MYSQL','sql/mysql.sql');

	// MAINTENANCE ACtioNS
	define('_XTR_INSTALL','include/install.php');
	define('_XTR_UNINSTALL','include/uninstall.php');
	define('_XTR_UPDATE','include/update.php');		
	
	// MENUs
	define('_XTR_XCENTER_ADMENU1','Manage Content');
	define('_XTR_XCENTER_ADMENU2','Add Content');
	define('_XTR_XCENTER_ADMENU3','Manage Categories');
	define('_XTR_XCENTER_ADMENU4','Add Category');
	define('_XTR_XCENTER_ADMENU5','Manage Inheritable Blocks');
	define('_XTR_XCENTER_ADMENU6','Add Inheritable Block');	
	define('_XTR_XCENTER_ADMENU7','Permissions');

	// MENU ICONS?IMAGES
	define('_XTR_XCENTER_ADMENU1_ICON','images/manage.xcenter.png');
	define('_XTR_XCENTER_ADMENU2_ICON','images/add.xcenter.png');
	define('_XTR_XCENTER_ADMENU3_ICON','images/manage.categories.png');
	define('_XTR_XCENTER_ADMENU4_ICON','images/add.category.png');
	define('_XTR_XCENTER_ADMENU5_ICON','images/manage.inheritable.blocks.png');
	define('_XTR_XCENTER_ADMENU6_ICON','images/add.inheritable.block.png');	
	define('_XTR_XCENTER_ADMENU7_ICON','images/permissions.png');

	//MYSQL TABLES WITHOUT PREFIX // DO NOT CHANGE
	define('_XTR_TABLE_XCENTER','xcenter_xcenter');
	define('_XTR_TABLE_CATEGORY','xcenter_categories');
	define('_XTR_TABLE_TEXT','xcenter_text');
	define('_XTR_TABLE_BLOCK','xcenter_blocks');

	//SEARCH SETTINGS // DO NOT CHANGE
	define('_XTR_HASSEARCH', false);
	define('_XTR_SEARCH_FILE','include/search.inc.php');
	define('_XTR_SEARCH_FUNCTION','xcenter_search');
	
	//COMMENT SETTINGS // DO NOT CHANGE
	define('_XTR_HASCOMMENT', true);
	define('_XTR_COMMENT_ITEM','storyid');
	define('_XTR_COMMENT_PAGE','index.php');
	
	//MAIN PAGES SETTING // DO NOT CHANGE
	define('_XTR_HASMAIN', true);
	define('_XTR_USESMARTY', true);
	
	//TEMPLATE SETTINGS // DO NOT CHANGE
	define('_XTR_TEMPLATE_INDEX','xcenter_index.html');
	define('_XTR_TEMPLATE_INDEX_DESC','Index File for Xcenter');
	define('_XTR_TEMPLATE_BREADCRUMB','xcenter_breadcrumb.html');
	define('_XTR_TEMPLATE_BREADCRUMB_DESC','Breadcrumb for Index File for Xcenter');
	define('_XTR_TEMPLATE_CPANEL_ADDEDITPAGE','xcenter_cpanel_addeditpage.html');
	define('_XTR_TEMPLATE_CPANEL_ADDEDITPAGE_DESC','Xcenter Cpanel Edit From for Xcenter');
	define('_XTR_TEMPLATE_CPANEL_ADDEDITCATEGORY','xcenter_cpanel_addeditcategory.html');
	define('_XTR_TEMPLATE_CPANEL_ADDEDITCATEGORY_DESC','Xcenter Cpanel Edit From for Category');
	define('_XTR_TEMPLATE_CPANEL_ADDEDITBLOCK','xcenter_cpanel_addeditblock.html');
	define('_XTR_TEMPLATE_CPANEL_ADDEDITBLOCK_DESC','Xcenter Cpanel Edit From for block');	
	define('_XTR_TEMPLATE_INDEX_ADDEDITPAGE','xcenter_index_addeditpage.html');
	define('_XTR_TEMPLATE_INDEX_ADDEDITPAGE_DESC','Xcenter Index Edit From for Xcenter');
	define('_XTR_TEMPLATE_INDEX_ADDEDITCATEGORY','xcenter_index_addeditcategory.html');
	define('_XTR_TEMPLATE_INDEX_ADDEDITCATEGORY_DESC','Xcenter Index Edit From for Category');
	define('_XTR_TEMPLATE_INDEX_ADDEDITBLOCK','xcenter_index_addeditblock.html');
	define('_XTR_TEMPLATE_INDEX_ADDEDITBLOCK_DESC','Xcenter Cpanel Edit From for block');
	define('_XTR_TEMPLATE_CPANEL_JSON_ADDEDITPAGE','xcenter_cpanel_json_addeditpage.html');
	define('_XTR_TEMPLATE_CPANEL_JSON_ADDEDITPAGE_DESC','Xcenter Cpanel Edit From for Xcenter for json');
	define('_XTR_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY','xcenter_cpanel_json_addeditcategory.html');
	define('_XTR_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY_DESC','Xcenter Cpanel Edit From for Category for json');
	define('_XTR_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK','xcenter_cpanel_json_addeditblock.html');
	define('_XTR_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK_DESC','Xcenter Cpanel Edit From for block for json');	
	define('_XTR_TEMPLATE_INDEX_JSON_ADDEDITPAGE','xcenter_index_json_addeditpage.html');
	define('_XTR_TEMPLATE_INDEX_JSON_ADDEDITPAGE_DESC','Xcenter Index Edit From for Xcenter for json');
	define('_XTR_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY','xcenter_index_json_addeditcategory.html');
	define('_XTR_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY_DESC','Xcenter Index Edit From for Category for json');
	define('_XTR_TEMPLATE_INDEX_JSON_ADDEDITBLOCK','xcenter_index_json_addeditblock.html');
	define('_XTR_TEMPLATE_INDEX_JSON_ADDEDITBLOCK_DESC','Xcenter Cpanel Edit From for block for json');		
	define('_XTR_TEMPLATE_INDEX_MANAGE','xcenter_index_manage.html');
	define('_XTR_TEMPLATE_INDEX_MANAGE_DESC','Xcenter Manager Template - Displays lists');	
	define('_XTR_TEMPLATE_INDEX_PASSWORD','xcenter_index_password.html');
	define('_XTR_TEMPLATE_INDEX_PASSWORD_DESC','Xcenter Password Prompt Template');	
	
	//CLASS NAMES // DO NOT CHANGE
	define('_XTR_CLASS_XCENTER','xcenter');
	define('_XTR_CLASS_CATEGORY','category');
	define('_XTR_CLASS_TEXT','text');
	define('_XTR_CLASS_BLOCK','block');
	define('_XTR_CLASS_XLANGUAGE_EXT','xlanguage_ext');
	
	//FUNCTIOnAL PAGE OpERATORs -- DO NOT CHANGE
	define('_XTR_URL_OP_SAVE','save');
	define('_XTR_URL_OP_EDIT','edit');
	define('_XTR_URL_OP_ADD','add');
	define('_XTR_URL_OP_DELETE','delete');
	define('_XTR_URL_OP_COPY','copy');
	define('_XTR_URL_OP_MANAGE','manage');
	define('_XTR_URL_OP_PERMISSIONS','permissions');
	define('_XTR_URL_FORM_XCENTER','xcenter');
	define('_XTR_URL_FORM_CATEGORY','category');
	define('_XTR_URL_FORM_BLOCK','block');
	define('_XTR_URL_FCT_CATEGORIES','categories');
	define('_XTR_URL_FCT_XCENTER','xcenter');
	define('_XTR_URL_FCT_CATEGORY','category');
	define('_XTR_URL_FCT_BLOCK','block');
	define('_XTR_URL_FCT_BLOCKS','blocks');
	define('_XTR_URL_FCT_PAGES','pages');
	define('_XTR_URL_FCT_TEMPLATE','template');
	
	//ENUMERATORS // DO NOT CHANGE
	define('_XTR_ENUM_TYPE_BLOCK','block');
	define('_XTR_ENUM_TYPE_CATEGORY','category');
	define('_XTR_ENUM_TYPE_XCENTER','xcenter');
	
	// PATHs // DO NOT CHANGE
	define('_XTR_PATH_PHP_GROUPPERMS','/class/xoopsform/grouppermform.php');
	define('_XTR_PATH_PHP_TEMPLATE','/class/template.php');
	define('_XTR_PATH_PHP_FORMLOADER','/class/xoopsformloader.php');
	define('_XTR_PATH_PHP_FORM_TAG','/modules/tag/include/formtag.php');
	define('_XTR_PATH_PHP_HEADER','/header.php');
	define('_XTR_PATH_PHP_FOOTER','/footer.php');
	define('_XTR_PATH_PHP_COMMENTVIEW','/include/comment_view.php');
	define('_XTR_PATH_MODULE_ROOT','/modules/'._XTR_DIRNAME.'/index.php');
	define('_XTR_PATH_PHP_FPDF','/modules/'._XTR_DIRNAME.'/include/fpdf/fpdf.inc.php');
	define('_XTR_PATH_PHP_JSON','/modules/'._XTR_DIRNAME.'/include/JSON.php');
	define('_XTR_PATH_PREDEFINED_HTML','/modules/'._XTR_DIRNAME.'/templates/predefined/xcenter/');
	define('_XTR_PATH_PREDEFINED_RSS','/modules/'._XTR_DIRNAME.'/templates/predefined/rss/');
	define('_XTR_PATH_CSS_INDEX','/modules/'._XTR_DIRNAME.'/templates/css/xcenter.css');
	define('_XTR_PATH_CSS_PRINT','/modules/'._XTR_DIRNAME.'/templates/css/print.css');	
	define('_XTR_PATH_JS_CORE','/modules/'._XTR_DIRNAME.'/templates/js/core.js');
	define('_XTR_PATH_JS_JQUERY','/browse.php?Frameworks/jquery/jquery.js');
	define('_XTR_PATH_PHP_FUNCTIONS','/modules/'._XTR_DIRNAME.'/include/functions.php');
	define('_XTR_PATH_PHP_FORMOBJECTS','/modules/'._XTR_DIRNAME.'/include/formobjects.xcenter.php');
	define('_XTR_PATH_PHP_FORMS','/modules/'._XTR_DIRNAME.'/include/forms.xcenter.php');
	define('_XTR_PATH_PHP_FORM_LANGUAGES','/modules/'._XTR_DIRNAME.'/include/formselectlanguages.php');
	define('_XTR_PATH_PHP_FORM_CATEGORIES','/modules/'._XTR_DIRNAME.'/include/formselectcategories.php');
	define('_XTR_PATH_PHP_FORM_PAGES','/modules/'._XTR_DIRNAME.'/include/formselectpages.php');
	define('_XTR_PATH_PHP_FORM_BLOCKS','/modules/'._XTR_DIRNAME.'/include/formselectblocks.php');
	define('_XTR_PATH_PHP_FORM_HTMLTEMPLATES','/modules/'._XTR_DIRNAME.'/include/formselecttemplates.php');
	
	// PERMiSSION OPTIONS // DO NOT CHANGE
	define('_XTR_PERM_VIEW_CATEGORY','Categories Viewing Permissions');
	define('_XTR_PERM_VIEW_XCENTER','Content Viewing Permissions');
	define('_XTR_PERM_VIEW_BLOCK','Block Viewing Permissions');
	define('_XTR_PERM_EDIT_CATEGORY','Categories Edit Permissions');
	define('_XTR_PERM_EDIT_XCENTER','Content Edit Permissions');
	define('_XTR_PERM_EDIT_BLOCK','Block Edit Permissions');
	define('_XTR_PERM_ADD_CATEGORY','Categories Adding Permissions');
	define('_XTR_PERM_ADD_XCENTER','Content Adding Permissions');
	define('_XTR_PERM_ADD_BLOCK','Block Adding Permissions');
	define('_XTR_PERM_DEFAULT_TEMPLATE','Default Permissions');

	// PERMISSION TYPES & MODES // DO NOT CHANGE
	define('_XTR_PERM_MODE_VIEW','view');
	define('_XTR_PERM_MODE_EDIT','edit');
	define('_XTR_PERM_MODE_ADD','add');
	define('_XTR_PERM_MODE_COPY','copy');
	define('_XTR_PERM_MODE_DELETE','delete');
	define('_XTR_PERM_MODE_ALL','all');
	define('_XTR_PERM_TYPE_CATEGORY','_category');
	define('_XTR_PERM_TYPE_XCENTER','_xcenter');
	define('_XTR_PERM_TYPE_BLOCK','_block');
	define('_XTR_PERM_TYPE_TEMPLATE','_default');
	
	// PERMISSION TEMPLATES // DO NOT CHANGE
	define('_XTR_PERM_TEMPLATE_ADD_XCENTER', 1);
	define('_XTR_PERM_TEMPLATE_ADD_CATEGORY', 2);
	define('_XTR_PERM_TEMPLATE_ADD_BLOCK', 3);
	define('_XTR_PERM_TEMPLATE_EDIT_XCENTER', 4);
	define('_XTR_PERM_TEMPLATE_EDIT_CATEGORY', 5);
	define('_XTR_PERM_TEMPLATE_EDIT_BLOCK', 6);
	define('_XTR_PERM_TEMPLATE_VIEW_XCENTER', 7);
	define('_XTR_PERM_TEMPLATE_VIEW_CATEGORY', 8);
	define('_XTR_PERM_TEMPLATE_VIEW_BLOCK', 9);
	define('_XTR_PERM_TEMPLATE_COPY_XCENTER', 10);
	define('_XTR_PERM_TEMPLATE_COPY_CATEGORY', 11);
	define('_XTR_PERM_TEMPLATE_COPY_BLOCK', 12);
	define('_XTR_PERM_TEMPLATE_DELETE_XCENTER', 13);
	define('_XTR_PERM_TEMPLATE_DELETE_CATEGORY', 14);
	define('_XTR_PERM_TEMPLATE_DELETE_BLOCK', 15);
	define('_XTR_PERM_TEMPLATE_PERMISSIONS', 16);
	define('_XTR_PERM_TEMPLATE_MANAGE_XCENTER', 17);
	define('_XTR_PERM_TEMPLATE_MANAGE_CATEGORY', 18);
	define('_XTR_PERM_TEMPLATE_MANAGE_BLOCK', 19);
	
	// PERMISSION TEMPLATES desCRIPTIons
	define('_XTR_PERM_TEMPLATE_ADD_XCENTER_DESC','Add Content'); 
	define('_XTR_PERM_TEMPLATE_ADD_CATEGORY_DESC','Add Category');
	define('_XTR_PERM_TEMPLATE_ADD_BLOCK_DESC','Add Block');
	define('_XTR_PERM_TEMPLATE_EDIT_XCENTER_DESC','Edit Content');
	define('_XTR_PERM_TEMPLATE_EDIT_CATEGORY_DESC','Category Edit');
	define('_XTR_PERM_TEMPLATE_EDIT_BLOCK_DESC','Edit Blocks');
	define('_XTR_PERM_TEMPLATE_VIEW_XCENTER_DESC','View Content');
	define('_XTR_PERM_TEMPLATE_VIEW_CATEGORY_DESC','View Category');
	define('_XTR_PERM_TEMPLATE_VIEW_BLOCK_DESC','View Block');
	define('_XTR_PERM_TEMPLATE_COPY_XCENTER_DESC','Copy Content');
	define('_XTR_PERM_TEMPLATE_COPY_CATEGORY_DESC','Copy Category');
	define('_XTR_PERM_TEMPLATE_COPY_BLOCK_DESC','Copy Block');
	define('_XTR_PERM_TEMPLATE_DELETE_XCENTER_DESC','Delete Content');
	define('_XTR_PERM_TEMPLATE_DELETE_CATEGORY_DESC','Delete Category');
	define('_XTR_PERM_TEMPLATE_DELETE_BLOCK_DESC','Delete Block');
	define('_XTR_PERM_TEMPLATE_PERMISSIONS_DESC','Access & Change Permissions');
	define('_XTR_PERM_TEMPLATE_MANAGE_XCENTER_DESC','Manage Content');
	define('_XTR_PERM_TEMPLATE_MANAGE_CATEGORY_DESC','Manage Categories');
	define('_XTR_PERM_TEMPLATE_MANAGE_BLOCK_DESC','Manage Blocks');
	
	//PERMISSIOn TITLES
	define('_XTR_PERMISSIONS_CATEGORY','Permissions for Categories');
	define('_XTR_PERMISSIONS_XCENTER','Permissions for Content');
	define('_XTR_PERMISSIONS_BLOCKS','Permissions for Blocks');
	define('_XTR_PERMISSIONS_DEFAULT','Permissions Defaults');
	
	// LANGUAGE DESCRIPTIONS
	define('_XTR_USEJSON','Use Secure JSON for forms?');
	define('_XTR_USEJSON_DESC','Enabling this option will use JQuery and Secure JSON method for loading forms, not all editors work with this!');
	define('_XTR_WRITENBY','Display Written By');
	define('_XTR_WRITENBY_DESC','This displays the author of the article/content.');
	define('_XTR_SECURITY','Security Type');
	define('_XTR_SECURITY_DESC','Type of security complexity you wish to use!');
	define('_XTR_MUlTILINGUAL','Multilinguage Documents');
	define('_XTR_SUPPORTTAGS','Support Tagging');
	define('_XTR_SUPPORTTAGS_DESC','Support Tag (2.3 or later)<br/><a href="http://sourceforge.net/projects/xoops/files/XOOPS%20Module%20Repository/XOOPS%20tag%202.30%20RC/">Download Tag Module</a>');
	define('_XTR_MUlTILINGUAL_DESC','Allows for multiple languages per page to be specified');
	define('_XTR_XCENTER_NAME','Lingual Content');
	define('_XTR_XCENTER_DIRNAME','xcenter');
	define('_XTR_EDITORS','Editor!');
	define('_XTR_EDITORS_DESC','Editor to use for text editing!');
	define('_XTR_RSSICON','Enable RSS Icon');
	define('_XTR_RSSICON_DESC','Enables RSS Access');	
	define('_XTR_PRINTICON','Enable Print Icon');
	define('_XTR_PRINTICON_DESC','Enables Printing');	
	define('_XTR_ADDTHIS','Enable Social Bookmarks');
	define('_XTR_ADDTHISICON_DESC','Enables Social Bookmarking');	
	define('_XTR_ADDTHISCODE','Social Bookmark Code');
	define('_XTR_ADDTHISCODE_DESC','Code for the sharing bookmark <a href="http://www.addthis.com">Get it here</a>');	
	define('_XTR_PDFICON','Enable PDF?');
	define('_XTR_PDFICON_DESC','Enables the PDF Functions');	
	define('_XTR_BREADCRUMB','Enable Breadcrumb?');
	define('_XTR_BREADCRUMB_DESC','Enabled the Bread Crumb');	
	define('_XTR_HTACCESS','Enabled HTACCESS SEO');
	define('_XTR_HTACCESS_DESC','This enables SEO');
	define('_XTR_BASEURL','Base URL for SEO');
	define('_XTR_BASEURL_DESC','Base URL for SEO');
	define('_XTR_ENDOFURL','End of URL');
	define('_XTR_ENDOFURL_DESC','File Extension to HTML Files');
	define('_XTR_ENDOFURLRSS','End of URL');
	define('_XTR_ENDOFURLRSS_DESC','File Extension to RSS Pages');
	define('_XTR_ENDOFURLPDF','End of URL');
	define('_XTR_ENDOFURLPDF_DESC','File Extension to Adobe Acrobat (PDF) Files');
	define('_XTR_FORCECPANELJQUERY','Force JQuery on Control Panel');
	define('_XTR_FORCECPANELJQUERY_DESC','Forces the installed runtime copy of JQuery!');
	define('_XTR_FORCEJQUERY','Force JQuery on Content Pages');
	define('_XTR_FORCEJQUERY_DESC','Forces the installed runtime copy of JQuery!');

	//SECURITY TYPES
	define('_XTR_SECURITY_BASIC','Basic');
	define('_XTR_SECURITY_INTERMEDIATE','Intermediate');
	define('_XTR_SECURITY_ADVANCED','Advanced');
	define('_XTR_SECURITY_BASIC_DESC','Basic Permissions');
	define('_XTR_SECURITY_INTERMEDIATE_DESC','Intermediate Permissions');
	define('_XTR_SECURITY_ADVANCED_DESC','Advanced Permissions');
	
	// Version 2.16
	//FUNCTIOnAL PAGE OpERATORs -- DO NOT CHANGE
	define('_XTR_URL_OP_DASHBOARD','dashboard');
	define('_XTR_URL_OP_ABOUT','about');
	
	//ADMINISTRATION SETTINGS // DO NOT CHANGE
	define('_XTR_HASADMIN', true);
	define('_XTR_ADMIN_INDEX','admin/index.php?op='._XTR_URL_OP_DASHBOARD);
	define('_XTR_ADMIN_MENU','admin/menu.php');
	define('_XTR_SYSTEM_MENU', true);

	// MENUs
	define('_XTR_XCENTER_ADMENU0','Dashboard');
	define('_XTR_XCENTER_ADMENU8','About XCentre');
	
	// MENU ICONS?IMAGES
	define('_XTR_XCENTER_ADMENU0_ICON','../../Frameworks/moduleclasses/icons/32/home.png');
	define('_XTR_XCENTER_ADMENU8_ICON','../../Frameworks/moduleclasses/icons/32/about.png');
		
?>