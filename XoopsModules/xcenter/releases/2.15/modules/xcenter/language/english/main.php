<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


	include_once('modinfo.php');

	// Options & Messages
	define('_XTR_AD_PAGE','Content Page');
	define('_XTR_AD_CATEGORY','Category');
	define('_XTR_AD_PARENT','Parent Node');
	define('_XTR_AD_SUBMENUS','Submenu');
	define('_XTR_AD_HOMEPAGE','Homepage');
	define('_XTR_AD_ACTIONS','Actions');
	define('_XTR_AD_WEIGHT','Weight');
	define('_XTR_AD_RSSENABLED','RSS Enabled');
	define('_XTR_AD_TITLE','Block Description');
	define('_XTR_AD_CREATED','Created');
	define('_XTR_AD_MADEBY','Last Edited By');
	define('_XTR_NONE','(none)');
	define('_XTR_MSG_XCENTERSAVED','Content Saved!');
	define('_XTR_NOPERMISSIONS','No Permissions to View Page or Content');
	define('_XTR_NOTVISIBLE','View Page not permitted this page is not currently visible!');
	define('_XTR_PAGETITLESEP',' : ');
	define('_XTR_NOSTORY','No story/content specified!');
	define('_XTR_CRUMBSEP','>');
	define('_XTR_WRITTENBY','Written by:&nbsp;');
	define('_XTR_MSG_SECURITYTOKEN','passkey Security Token needs to be refreshed - please refresh the screen!');
	define('_XTR_AD_CONFIRM_DELETE','Are you sure you wish to delete the page <strong>%s</strong>');
	define('_XTR_AD_MSG_DELETE','Content Deleted Successfully!');
	define('_XTR_AD_CONFIRM_COPY','Are you sure you wish to copy the page <strong>%s</strong>');
	define('_XTR_AD_MSG_COPY','Xcenter Coping Successfully - %s subsets copied!');
	define('_XTR_NEEDCATEGORIES','Need to have categories loaded!');
	define('_XTR_MSG_CATEGORYSAVED','Category saved successfully');
	define('_XTR_MSG_CATEGORYNOTSAVED','The category did not save successfully');
	define('_XTR_MSG_BLOCKSAVED','Block saved successfully');
	define('_XTR_MSG_BLOCKNOTSAVED','The block did not save successfully');
	define('_XTR_XCENTEREXPIRED','Xcenter has passed it expiry date!');
	define('_XTR_TOBEPUBLISHED','Xcenter has to reach it publishing date!');
	
	// PAssWord form
	define('_XTR_MF_ENTERPASSWORD','Enter the password for the content!');
	define('_XTR_MF_PASSWORD','Content password');
	define('_XTR_MF_PASSWORD_DESC','');
	
	// PRINTING
	define('_XTR_PRINTERFRIENDLY','Printer Friendly');
	define('_XTR_URLFORSTORY','Direct URL:');
	define('_XTR_THISCOMESFROM','This Comes From:');
	
	//PDF
	define('_XTR_PDF_AUTHOR','Author');
	define('_XTR_PDF_DATE','Published');
	define('_XTR_POSTEDBY','Posted By');
	define('_XTR_POSTEDON','Posted On');
	define('_XTR_PAGE','Generated %s, Page %s');
	
	// EDIT BLOCK FORM
	define('_XTR_AD_NEWBLOCK','Create New Block');
	define('_XTR_AD_EDITBLOCK','Edit The Block');
	define('_XTR_AD_OPENDESCRIPTION','Reference');
	define('_XTR_AD_OPENDESCRIPTION_DESC','This is what you refer the block too');
	define('_XTR_AD_BLOCKHTML','BLOCK Code');
	define('_XTR_AD_BLOCKHTML_DESC','HTML/XCODE/TEXT Code for inhertitable');
	
	// EDIT CATEGORY FORM
	define('_XTR_AD_NEWCATEGORY','New Category');
	define('_XTR_AD_EDITCATEGORY','Edit Category');
	define('_XTR_AD_CAT_MENUTITLE','Menu Title');
	define('_XTR_AD_CAT_RSSENABLED','RSS Enabled');
	define('_XTR_AD_CAT_OPTIONS','Options');
	define('_XTR_AD_CAT_LANGUAGE','Category Language');
	define('_XTR_AD_CAT_LANGUAGE_DESC','');
	define('_XTR_AD_CAT_CATEGORYPARENT','Category Parent Node');
	define('_XTR_AD_CAT_KEYWORDS','Meta Keywords');
	define('_XTR_AD_CAT_PAGEDESCRIPTION','Meta Page Description');
	define('_XTR_AD_CAT_RSSDESCRIPTION','RSS Items Description');
	define('_XTR_AD_CAT_TEXT','Category Caption');
	
	// EDIT XCENTER FORM
	define('_XTR_AD_EDITXCENTER','Edit Multilingual Content Page');
	define('_XTR_AD_NEWXCENTER','New Multilingual Content Page');
	define('_XTR_AD_LANGUAGE','Page Language');
	define('_XTR_AD_MENUTITLE','Menu Title');
	define('_XTR_AD_PAGETITLE','Page Title');
	define('_XTR_AD_INHERITBLOCK','Inherited Block');
	define('_XTR_AD_KEYWORDS','Meta Keywords');
	define('_XTR_AD_PAGEDESCRIPTION','Meta Page Description');
	define('_XTR_AD_TEMPLATES','Rss & Content Template');
	define('_XTR_AD_RSS','RSS Item');
	define('_XTR_AD_TEXT','Item Content');
	define('_XTR_AD_URL','URL');
	define('_XTR_AD_PASSWORD','Page Password');
	define('_XTR_AD_PASSWORD_CONFIRM','Confirm:');
	define('_XTR_AD_OPTIONS','Options');
	define('_XTR_AD_URLADDRESS','URL:');
	define('_XTR_AD_REDIRECTLINK','Redirect Link on Load');		
	define('_XTR_AD_PUBLISH','Published or Redirect');
	define('_XTR_AD_EXPIRE','Expired then Redirect');
	define('_XTR_AD_SET','Save Setting Now?');
	define('_XTR_AD_PUBlISHDATETIME','Published from:');
	define('_XTR_AD_EXPIREDATETIME','Expires on:');
	define('_XTR_AD_REDIRECTPAGE','or Redirect to page:');
	define('_XTR_AD_VISIBLE','Visible');
	define('_XTR_AD_NOHTML','No Html');
	define('_XTR_AD_NOSMILEY','No Smilies');		
	define('_XTR_AD_NOBREAKS','No Line Feed');
	define('_XTR_AD_NOCOMMENTS','No Comments');		
	define('_XTR_AD_SUBMENU','Sub Menu Items');
	define('_XTR_AD_TITLE_DESC','Appears in menus for page!');
	define('_XTR_AD_PAGETITLE_DESC','Appears as heading of page!');
	define('_XTR_AD_PARENTPAGE_DESC','Parent Page');
	define('_XTR_AD_CATEGORY_DESC','Categorisation for page');
	define('_XTR_AD_INHERITBLOCK_DESC','Inherited block for page');
	define('_XTR_AD_KEYWORDS_DESC','These are the page keywords');
	define('_XTR_AD_PAGEDESCRIPTION_DESC','Description of page in Search Engines');
	define('_XTR_AD_TEMPLATE_DESC','Predefined Templates');
	define('_XTR_AD_RSS_DESC','RSS Document to appear in category rss feed!');
	define('_XTR_AD_TEXT_DESC','Xcenter that appears in the page under ID');
	define('_XTR_AD_URL_DESC','URL for redirection!');
	define('_XTR_AD_PASSWORD_DESC','Page password protection');
	define('_XTR_AD_TAGS_DESC','Tags/Keyphrases for page!');
	define('_XTR_AD_PUBLISH_DESC','Page will only appear and publish after this date!');
	define('_XTR_AD_EXPIRE_DESC','Page will only publish until this time and date!');
	define('_XTR_AD_LANGUAGE_DESC','Select the language for this page!');
	define('_XTR_AD_CAT_PAGETITLE','Category Page Title');
	define('_XTR_AD_PUBLISHED','Published');
	
	define('_XTR_AD_ADDPAGE_TITLEA','Content Page');
	define('_XTR_AD_ADDPAGE_TITLEB','New Page');
	define('_XTR_AD_CATEGORY_TITLEA','Category');
	define('_XTR_AD_CATEGORY_TITLEB','New Category');
	define('_XTR_AD_BLOCK_TITLEA','Block');
	define('_XTR_AD_BLOCK_TITLEB','New Block');
	define('_XTR_AM_MANAGE_TITLEA','Manage Content');
	
?>