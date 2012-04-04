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
class XcenterXlanguage_ext extends XoopsObject
{

    function XcenterXlanguage_ext($id = null)
    {
        $this->initVar('lang_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('weight', XOBJ_DTYPE_INT, null, false);
        $this->initVar('lang_name', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_desc', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_code', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_charset', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_image', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_base', XOBJ_DTYPE_TXTBOX, null, true, 255);

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
class XcenterXlanguage_extHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "xlanguage_ext", 'XcenterXlanguage_ext', "lang_id", "lang_name");
    }
}

?>