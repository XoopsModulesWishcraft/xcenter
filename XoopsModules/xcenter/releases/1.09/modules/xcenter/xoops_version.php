<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 xoops.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Simon Roberts (aka wishcraft)                                     //
// Site: http://www.chronolabs.org.au                                        //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

$modversion['name']		    = _CXM_XCENTER_NAME;
$modversion['version']		= 1.09;
$modversion['author']       = 'Simon Roberts (aka wishcraft)';
$modversion['description']	= _CXM_XCENTER_DESC;
$modversion['credits']		= "The XOOPS Project";
$modversion['license']		= "GNU see LICENSE";
$modversion['help']		    = "";
$modversion['official']		= 0;
$modversion['image']		= "images/logo.gif";
$modversion['dirname']		= _CXM_DIR_NAME;

$modversion['releasedate'] = "Mon: 29 Sept 2008";
$modversion['status'] = "Final";
$modversion['author'] = "Chronolabs International";
$modversion['teammembers'] = "Wishcraft";
$modversion['help'] = "xcenter.html";
$modversion['license'] = "GNU";
$modversion['official'] = 1;

$modversion['author_realname'] = "Simon Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.org.au";
$modversion['author_website_name'] = "Chronolabs Australia";
$modversion['author_email'] = "simon@chronolabs.co.uk";
$modversion['demo_site_url'] = "Chronolabs International";
$modversion['demo_site_name'] = "http://www.chronolabs.org.au/modules/xcenter/";
$modversion['support_site_url'] = "http://www.chronolabs.org.au/modules/newbb/viewforum.php?forum=22";
$modversion['support_site_name'] = "x-Center";
$modversion['submit_bug'] = "http://www.chronolabs.org.au/modules/newbb/viewforum.php?forum=22";
$modversion['submit_feature'] = "http://www.chronolabs.org.au/modules/newbb/viewforum.php?forum=22";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0]	= "xcenter";
$modversion['tables'][1]	= "xcenter_mblocks";

// Backend RSS Feed
// Please note **** Module Developers ****
// this will be a new clause in module installations.
$modversion['hasRss'] = 1;
$modversion['rss_func'][0] = "xcenter_backend_rss";
$modversion['rss_file'][0] = "include/rss.php";

// Backend Sitemap Feed
// Please note **** Module Developers **** 
// this will be a new clause in module installations.
$modversion['hasSitemap'] = 1;
$modversion['sitemap_func'][0] = "xcenter_sitemap";
$modversion['sitemap_file'][0] = "include/sitemap.php";

// Admin things
$modversion['hasAdmin']		= 1;
$modversion['adminindex']	= "admin/index.php";
$modversion['adminmenu']	= "admin/menu.php";

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "content_search";

// Menu
$modversion['hasMain'] = 1;
global $xoopsDB;

// Submenu Items

$result = $xoopsDB->query("SELECT center_id, title, homepage, submenu FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." WHERE homepage='0' AND submenu='1' order by `weight`");
$i = 1;

while (list($center_id, $title) = $xoopsDB->fetchRow($result))
{
	$modversion['sub'][$i]['name'] = $title;
	$modversion['sub'][$i]['url'] = "index.php?center_id=".$center_id."";
	$i++;
} 

// Smarty
$modversion['use_smarty'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'xcenter_index.html';
$modversion['templates'][1]['description'] = _CXM_TEMP_NAME1;
$modversion['templates'][2]['file'] = 'xcenter_mblock.html';
$modversion['templates'][2]['description'] = _CXM_TEMP_NAME1;

// Blocks
$modversion['blocks'][1]['file'] = "xcenter_navigation.php";
$modversion['blocks'][1]['name'] = _CXM_C_BNAME1;
$modversion['blocks'][1]['description'] = _CXM_C_BNAME1_DESC;
$modversion['blocks'][1]['show_func'] = "content_block_nav";
$modversion['blocks'][1]['template'] = 'xcenter_nav_block.html';

$modversion['blocks'][2]['file'] = "xcenter_sitenavigation.php";
$modversion['blocks'][2]['name'] = _CXM_C_BNAME2;
$modversion['blocks'][2]['description'] = _CXM_C_BNAME2_DESC;
$modversion['blocks'][2]['show_func'] = "site_block_nav";
$modversion['blocks'][2]['template'] = 'xcenter_site_nav_block.html';

$modversion['blocks'][3]['file'] = "xcenter_dhtml_sitenavigation.php";
$modversion['blocks'][3]['name'] = _CXM_C_BNAME3;
$modversion['blocks'][3]['description'] = _CXM_C_BNAME3_DESC;
$modversion['blocks'][3]['show_func'] = "site_block_dhtml_nav";
$modversion['blocks'][3]['template'] = 'xcenter_dhtml_site_nav_block.html';

$modversion['blocks'][4]['file'] = "xcenter_xml_block.php";
$modversion['blocks'][4]['name'] = _CXM_C_BNAME4;
$modversion['blocks'][4]['description'] = _CXM_C_BNAME4_DESC;
$modversion['blocks'][4]['show_func'] = "xml_block_xcenter_show";
$modversion['blocks'][4]['edit_func'] = "xml_block_xcenter_edit";
$modversion['blocks'][4]['template'] = 'xcenter_xml_block.html';


// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'center_id';
$modversion['comments']['pageName'] = 'index.php';

$modversion['config'][1]['name'] = 'cont_wysiwyg';
$modversion['config'][1]['title'] = '_CXM_WYSIWYG';
$modversion['config'][1]['description'] = '_CXM_WYSIWYG_DESC';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 1;

$modversion['config'][2]['name'] = 'cont_multi';
$modversion['config'][2]['title'] = '_CXM_MULTI';
$modversion['config'][2]['description'] = '_CXM_MULTI_DESC';
$modversion['config'][2]['formtype'] = 'yesno';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 0;

$modversion['config'][3]['name'] = 'cont_htaccess';
$modversion['config'][3]['title'] = '_CXM_HTACCESS';
$modversion['config'][3]['description'] = '_CXM_HTACCESS_DESC';
$modversion['config'][3]['formtype'] = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 0;

$modversion['config'][4]['name'] = 'htaccess_basepath';
$modversion['config'][4]['title'] = '_CXM_BASEPATH_HTACCESS';
$modversion['config'][4]['description'] = '_CXM_BASEPATH_HTACCESS_DESC';
$modversion['config'][4]['formtype'] = 'text';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = 'centre';

$modversion['config'][5]['name'] = 'default_access_view';
$modversion['config'][5]['title'] = '_CXM_DEFAULT_ACCESS_VIEW';
$modversion['config'][5]['description'] = '_CXM_DEFAULT_ACCESS_VIEWDESC';
$modversion['config'][5]['formtype'] = 'group_multi';
$modversion['config'][5]['valuetype'] = 'array';
$modversion['config'][5]['default'] = "1|2|3";

$modversion['config'][6]['name'] = 'default_access_edit';
$modversion['config'][6]['title'] = '_CXM_DEFAULT_ACCESS_EDIT';
$modversion['config'][6]['description'] = '_CXM_DEFAULT_ACCESS_EDITDESC';
$modversion['config'][6]['formtype'] = 'group_multi';
$modversion['config'][6]['valuetype'] = 'array';
$modversion['config'][6]['default'] = "1|2|3";

$modversion['config'][7]['name'] = 'default_access_delete';
$modversion['config'][7]['title'] = '_CXM_DEFAULT_ACCESS_DELETE';
$modversion['config'][7]['description'] = '_CXM_DEFAULT_ACCESS_DELETEDESC';
$modversion['config'][7]['formtype'] = 'group_multi';
$modversion['config'][7]['valuetype'] = 'array';
$modversion['config'][7]['default'] = "1|2|3";
/*
$modversion['config'][8]['name'] = 'noset_keyword_length';
$modversion['config'][8]['title'] = '_CXM_KEYWORD_LENGTH';
$modversion['config'][8]['description'] = '_CXM_KEYWORD_LENGTHDESC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 7;
$modversion['config'][8]['options'] = array("5 chars to word" => 5, "6 chars to word" => 6, "7 chars to word" => 7, "8 chars to word" => 8, "9 chars to word" => 9, "10 chars to word" => 10, "11 chars to word" => 11, "12 chars to word" => 12, "13 chars to word" => 13, "14 chars to word" => 14, "15 chars to word" => 15, "16 chars to word" => 16, "17 chars to word" => 17);
*/

?>
