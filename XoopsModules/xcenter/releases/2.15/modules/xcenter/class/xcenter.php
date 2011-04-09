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
class XcenterXcenter extends XoopsObject
{

    function XcenterXcenter($id = null)
    {
        $this->initVar('storyid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('parent_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('blockid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('catid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('weight', XOBJ_DTYPE_INT, 1, false);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('visible', XOBJ_DTYPE_INT, true, false);
		$this->initVar('homepage', XOBJ_DTYPE_INT, false, false);
        $this->initVar('nohtml', XOBJ_DTYPE_INT, false, false);
        $this->initVar('nosmiley', XOBJ_DTYPE_INT, false, false);		
		$this->initVar('nobreaks', XOBJ_DTYPE_INT, false, false);
		$this->initVar('nocomments', XOBJ_DTYPE_INT, false, false);
        $this->initVar('link', XOBJ_DTYPE_INT, false, false);
		$this->initVar('address', XOBJ_DTYPE_TXTBOX, 'http://', false, 255);
        $this->initVar('submenu', XOBJ_DTYPE_INT, false, false);
		$this->initVar('date', XOBJ_DTYPE_INT, null, false);
		$this->initVar('assoc_module', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tags', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('publish', XOBJ_DTYPE_INT, null, false);
		$this->initVar('publish_storyid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('expire', XOBJ_DTYPE_INT, null, false);
		$this->initVar('expire_storyid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('password', XOBJ_DTYPE_TXTBOX, null, false, 32);
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
class XcenterXcenterHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, _XTR_TABLE_XCENTER, 'XcenterXcenter', "storyid");
    }

	function createnew() 
	{
		$ret = array();
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$ret['text'] = $text_handler->create();
		$ret['xcenter'] = $this->create();
		return $ret;
	}
	
	function getContent($storyid = 0, $language = '')
	{
		$ret = array();
		if (empty($language)) {
			$language = $GLOBALS['xoopsConfig']['language'];
		}
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
		$criteria->add(new Criteria('language', $language));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));
		if ($texts = $text_handler->getObjects($criteria)) {
			$ret['text'] = $texts[0];
			$ret['xcenter'] = $this->get($storyid);
			$ret['perms']['hasEdit'] = xcenter_checkperm(_XTR_URL_OP_EDIT, _XTR_URL_FCT_XCENTER, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
			$ret['perms']['hasCopy'] = xcenter_checkperm(_XTR_URL_OP_COPY, _XTR_URL_FCT_XCENTER, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
			$ret['perms']['hasDelete'] = xcenter_checkperm(_XTR_URL_OP_DELETE, _XTR_URL_FCT_XCENTER, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
			return $ret;
		}

		$ret["text"] = $text_handler->create();
		$ret["text"]->setVar('language', $language);
		$ret['xcenter'] = $this->get($storyid);	
		$ret['perms']['hasEdit'] = xcenter_checkperm(_XTR_URL_OP_EDIT, _XTR_URL_FCT_XCENTER, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
		$ret['perms']['hasCopy'] = xcenter_checkperm(_XTR_URL_OP_COPY, _XTR_URL_FCT_XCENTER, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
		$ret['perms']['hasDelete'] = xcenter_checkperm(_XTR_URL_OP_DELETE, _XTR_URL_FCT_XCENTER, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);

		return $ret;
	}
	
	function getHompage($language = '')
	{
		$ret = array();

		if (empty($language))
			$language = $GLOBALS['xoopsConfig']['language'];
			
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria_a = new Criteria('homepage', true);
		$criteria_b = new CriteriaCompo(new Criteria('language', $language));
		$criteria_b->add(new Criteria('type', 'xcenter'));
		if ($xcenter = $this->getObjects($criteria_a)) {
			$criteria_b->add(new Criteria('storyid', $xcenter[0]->getVar('storyid')));
			if ($texts = $text_handler->getObjects($criteria_b))
				$ret['text'] = $texts[0];
			$ret['xcenter'] = $xcenter[0];
			return $ret;
		} else
			return $this->createnew();
	}
}

?>