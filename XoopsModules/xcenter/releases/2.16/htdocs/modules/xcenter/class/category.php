<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/



if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class XcenterCategory extends XoopsObject
{

    function XcenterCategory($id = null)
    {
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('parent_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('rssenabled', XOBJ_DTYPE_INT, false, false);
	}
}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class XcenterCategoryHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, _XTR_TABLE_CATEGORY, 'XcenterCategory', "catid", "title");
    }

	function createnew() 
	{
		$ret = array();
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$ret['text'] = $text_handler->create();
		$ret['cat'] = $this->create();
		return $ret;
	}
	
	function getCategory($catid = 0, $language = '')
	{
		$ret = array();
		if (empty($language)) {
			$language = $GLOBALS['xoopsConfig']['language'];
		}
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('catid', $catid));
		$criteria->add(new Criteria('language', $language));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));
		if ($texts = $text_handler->getObjects($criteria)) {
			$ret['text'] = $texts[0];
			$ret['cat'] = $this->get($catid);
			return $ret;
		}

		$ret["text"] = $text_handler->create();
		$ret["text"]->setVar('language', $language);
		$ret['cat'] = $this->get($catid);	
		return $ret;
	}
	
}

?>