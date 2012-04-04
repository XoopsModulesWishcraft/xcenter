<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

$adminmenu = array();
$i=1;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU0_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU0_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU0;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_DASHBOARD;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU1_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU1_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU1;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_XCENTER;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU2_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU2_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU2;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_XCENTER;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU3_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU3_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU3;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_CATEGORIES;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU4_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU4_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU4;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_CATEGORIES;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU5_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU5_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU5;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_BLOCKS;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU6_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU6_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU6;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_BLOCKS;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU7_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU7_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU7;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_PERMISSIONS."&fct="._XTR_URL_FCT_TEMPLATE.'&mode='._XTR_PERM_MODE_ALL;
$i++;
$adminmenu[$i]['icon'] = _XTR_XCENTER_ADMENU8_ICON;
$adminmenu[$i]['image'] = _XTR_XCENTER_ADMENU8_ICON;
$adminmenu[$i]['title'] = _XTR_XCENTER_ADMENU8;
$adminmenu[$i]['link']  = "admin/index.php?op="._XTR_URL_OP_ABOUT;

?>