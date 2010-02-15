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
//  ------------------------------------------------------------------------ //
// Author: Simon Roberts (aka wishcraft)                                     //
// Site: http://www.chronolabs.org.au                                        //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
include_once "admin_header.php";
error_reporting(0);

if (isset($HTTP_GET_VARS)) {
    foreach ($HTTP_GET_VARS as $k => $v) {
      $$k = $v;
    }
  }

  if (isset($HTTP_POST_VARS)) {
    foreach ($HTTP_POST_VARS as $k => $v) {
      $$k = $v;
    }
  }

$xcenter_handler =& xoops_getmodulehandler(_CXM_XCENTER_PREFIX, _CXM_XCENTER_PREFIX);

if ($center_id!=0)
{
	$xcenter = &$xcenter_handler->get($center_id);
} else {
	$xcenter = &$xcenter_handler->create();
}

  function subcategories($category_id) {
	global $xoopsDB;
    $child_category_query = $xoopsDB->query("select count(*) as count from " . $xoopsDB->prefix(_CXM_XCENTER_PREFIX) . " where parent_id = '" . (int)$category_id . "'");
    $child_category = $xoopsDB->fetchArray($child_category_query);

    if ($child_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }
  
  function cat_principal($category_id) {
	global $xoopsDB;
    $child_category_query = $xoopsDB->query("select count(*) as count from " . $xoopsDB->prefix(_CXM_XCENTER_PREFIX) . " where center_id = '" . (int)$category_id . "' and parent_id='0'");
    $child_category = $xoopsDB->fetchArray($child_category_query);

    if ($child_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

  function parents_menus($current_parent,$menustr,$catstr,$level) {
	global $xoopsDB;
	$mnuas[0] = _C_MAINMENU;
	$haschildren = 0; 
	$cat_principal = 0;
	$category_query_catmenu = $xoopsDB->query("select center_id, parent_id, title from ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." where parent_id = " . $current_parent . " order by weight, center_id");
	while ($category = $xoopsDB->fetchArray($category_query_catmenu))  {
	
		$haschildren=subcategories($category['center_id']);
		$category['title'] = str_repeat("->", $level).$category['title'];	
		
		if ($haschildren) {
			$menu_tmp = $category['title'];
			$cat_tmp = $category['center_id'];
			$mnuas[$category['center_id']] = $menu_tmp;
			$mnuas2 = parents_menus($category['center_id'],'','', $level + 1);
			foreach ($mnuas2 as $k => $v) {
				$mnuas[$k] = "&nbsp;&nbsp;&nbsp;  ".$v;	
			}
		} else {
			$mnuas[$category['center_id']] = $category['title'];  
		}
	}
	return $mnuas;
  }  
  
  function checkBrowser() {
    global $HTTP_SERVER_VARS;
    $browser = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
    if (eregi("MSIE[^;]*",$browser,$msie)) {
      if (eregi("[0-9]+\.[0-9]+",$msie[0],$version)) {
        if ((float)$version[0]>=5.5) {
          if (!eregi("opera",$browser)) {
            return true;
          }
        }
      }
    }
    return false;
  }

// ------------------------------------------------------------------------- //
// Switch Statement for the different operations                             //
// ------------------------------------------------------------------------- //
$xoopsDB =& Database::getInstance();

$form = new XoopsThemeForm($heading, "op", xoops_getenv('PHP_SELF')."?op=$op");
$form->setExtra('enctype="multipart/form-data"');

switch ($formaction)
{
	case "submit_order":
		for ( $j = 1; $j <= $HTTP_POST_VARS['total']; $j++) {
			if ($HTTP_POST_VARS['type'.$j] == "module"){
				if ( !$result = $xoopsDB->query("UPDATE ".$xoopsDB->prefix('modules')." SET weight = '".$HTTP_POST_VARS['priority'.$j]."' WHERE mid = '".$HTTP_POST_VARS['id'.$j]."'") ) {
					echo _C_ERRORINSERT;
				}
				//echo "UPDATE ".$xoopsDB->prefix('modules')." SET weight = '".$HTTP_POST_VARS['priority'.$j]."' WHERE mid = '".$HTTP_POST_VARS['id'.$j]."'<br>\n";
			} elseif ($HTTP_POST_VARS['type'.$j] == _CXM_XCENTER_PREFIX) {
				if ( !$result = $xoopsDB->query("UPDATE ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." SET weight = '".$HTTP_POST_VARS['priority'.$j]."' WHERE center_id = '".$HTTP_POST_VARS['id'.$j]."'") ) {
					echo _C_ERRORINSERT;
				}
				//echo "UPDATE ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." SET weight = '".$HTTP_POST_VARS['priority'.$j]."' WHERE center_id = '".$HTTP_POST_VARS['id'.$j]."'<br>\n";
			}
		}
		redirect_header("index.php?op=order",2,_C_DBUPDATED);
		exit;
		
	case "submit_edit":
	case "submit_submit":
		error_reporting(0);
		$xcenter->setVar('center_id',$center_id);
		$xcenter->setVar('parent_id',$parent_id);
		$xcenter->setVar('weight',$weight);
		$xcenter->setVar('title',$title);
		$xcenter->setVar('summary',$summary);
		$breaks = array("<br />", "<br/>", "<br>");
		$xcenter->setVar('text',str_replace($breaks,"\n",$text));
		$xcenter->setVar('visible',$visible);
		if ($xcenter_handler->getCount()<2)
		{
			$xcenter->setVar('homepage',1);
		} else {
			$xcenter->setVar('homepage',$homepage);
		}
	
		$xcenter->setVar('keywords',$keywords);		

		$nohtml = !$nohtml?0:1;
		$nosmiley = !$nosmiley?0:1;
		$nobreaks = !$nobreaks?0:1;
		$nocomments = !$nocomments?0:1;
		$anonymous = !$anonymous?0:1;
		
		$xcenter->setVar('anonymous',$anonymous);
		$xcenter->setVar('nohtml',$nohtml);
		$xcenter->setVar('nosmiley',$nosmiley);
		$xcenter->setVar('nobreaks',$nobreaks);
		$xcenter->setVar('nocomments',$nocomments);
		$xcenter->setVar('address',$address);
		$xcenter->setVar('submenu',$submenu);		
		
		$file_content = file_get_contents($xcenter->getVar('address'));
		if (strlen($file_content)>0&&$xcenter->getVar('address')!="http://")
		{
			$xcenter->setVar('link','1');		
		} else {
			$xcenter->setVar('link','0');		
		}
		$xcenter_handler->insert($xcenter, true);
		
		$xcenter_handler->deleteCenterPermissions($xcenter->getVar('center_id'), 'view');
		$xcenter_handler->deleteCenterPermissions($xcenter->getVar('center_id'), 'edit');
		$xcenter_handler->deleteCenterPermissions($xcenter->getVar('center_id'), 'delete');

		$perm .= $xcenter_handler->insertCenterPermissions($xcenter->getVar('center_id'), $group_view, 'view');
		$perm .= "<br />".$xcenter_handler->insertCenterPermissions($xcenter->getVar('center_id'), $group_edit, 'edit');
		$perm .= "<br />".$xcenter_handler->insertCenterPermissions($xcenter->getVar('center_id'), $group_delete, 'delete');
		
		if ($return == 1) {
			redirect_header(XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?center_id=".$xcenter->getVar('center_id'),2,_C_DBUPDATED."<br />".$perm);
			exit;
		}else{
			redirect_header("index.php?op=show",2,_C_DBUPDATED."<br />".$perm);
			exit;
		}
	
		redirect_header("index.php",2,_C_DBUPDATED);
		exit;
		break;

	case "submit_show":
		error_reporting(0);
		
		for ($y=1; $y==$total; $y++)
		{
			$xcenter = &$xcenter_handler->get($xcenter_id[$y]);
			if ($center_id[$y]!=$parent_id[$y])
				$xcenter->setVar('parent_id',$parent_id[$y]);
				
			$xcenter->setVar('weight',!$weight[$y]?0:1);
			$xcenter->setVar('visible',!$visible[$y]?0:1);
			$xcenter->setVar('homepage',!$homepage[$y]?0:1);
			$xcenter->setVar('nocomments',!$nocomments[$y]?0:1);
			$xcenter->setVar('submenu',!$submenu[$y]?0:1);	
			$xcenter_handler->insert($xcenter, true);
		}
		redirect_header("index.php?op=show",2,_C_DBUPDATED);
		exit;
		break;
	
	case "submit_tracking":
	
		$mblock_handler =& xoops_getmodulehandler('mblock', _CXM_XCENTER_PREFIX);
		if ($id!=0&&!empty($id))
		{
			$mblock = &$mblock_handler->get($id);
		} else {
			$mblock = &$mblock_handler->create();
		}	
	
		$mblock->setVar('id',$id);
		$mblock->setVar('center_id',$center_id);		
		$mblock->setVar('mod_id',$mod_id);
		$mblock->setVar('summary',$summary);
		$mblock->setVar('xml',$xml);
		$mblock->setVar('bid',$bid);

		$mblock_handler->insert($mblock, true);

		redirect_header("index.php?op=show",2,_C_DBUPDATED);
		exit;
		break;
	
}



switch ($op) {
case "show":
	global $xoopsDB;
    xoops_cp_header();

	$criteria = new Criteria("1", 1);
	$criteria->setSort("parent_id, weight");
	
	$obj_xcenter = $xcenter_handler->getObjects($criteria); 
		
	echo "<h3>"._C_ADMINTITLE."</h3>";

	if (isset($obj_xcenter))
	{
		
		require('../include/form.show.inc.php');
		$form->display();
		
	} else {
		redirect_header(XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?op=submit",2,_C_NEEDSUBMIT);
	}

	xoops_cp_footer();
	break;

case "tracking":
	global $xoopsDB;
	error_reporting(E_ALL);
	
	$mblock_handler =& xoops_getmodulehandler('mblock', _CXM_XCENTER_PREFIX);
	
	if ($id!=0)
	{
		$mblock = &$mblock_handler->get($id);
	} else {
		
		$criteria = new CriteriaCompo(new Criteria('center_id', $center_id));
		$criteria->add(new Criteria('mod_id', $mod_id));

		$mblocks =& $mblock_handler->getObjects($criteria);
		
		if (isset($mblocks[0]))
		{
			$id = $mblocks[0]->getVar('id');
			$center_id = $mblocks[0]->getVar('center_id');		
			$mod_id = $mblocks[0]->getVar('mod_id');
			$summary= $mblocks[0]->getVar('summary');
			$xml = str_replace(array("<br>","<br/>","<br />"),"\n",$mblocks[0]->getVar('xml'));
			$bid = $mblocks[0]->getVar('bid');

		}
		else
		{
			$mblock = &$xcenter_handler->create();			
			if ($_GET['mod_id'])
				$mod_id = $_GET['mod_id'];			
		}
	}

	xoops_cp_header();		
	
	echo "<h3>"._C_ADMINTITLE."</h3>";

		
	require('../include/form.tracker.inc.php');
	$form->display();
	
	xoops_cp_footer();
	break;

case "order":
	global $xoopsDB;


	xoops_cp_header();		

	echo "<h3>"._C_ADMINTITLE."</h3>";
	
	require('../include/form.order.inc.php');
	$form->display();
	
	xoops_cp_footer();
	break;
	
case "submit":
	global $xoopsDB;


	xoops_cp_header();		
	

	echo "<h3>"._C_ADMINTITLE."</h3>";
	if (isset($xcenter))
	{
	
		require('../include/form.inc.php');
		$form->display();
		
	} else {
		redirect_header(XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?op=submit",2,_C_NEEDSUBMIT);
	}
	
	xoops_cp_footer();
	break;

case "edit":
	global $xoopsDB;
	xoops_cp_header();

	echo "<h3>"._C_ADMINTITLE." - Edit - ".$xcenter->getVar('title')."</h3>";
	echo "<span>".$xcenter->getVar('summary')."</span>";
	
	if (isset($xcenter))
	{
		$perm = $xcenter_handler->getSingleCenterPermission($xcenter->getVar('center_id'), 'edit');
		if (!$perm) {
			redirect_header("index.php?op=show",1,_NOPERM);
		}

		require('../include/form.inc.php');
		$form->display();
		
	} else {
		redirect_header(XOOPS_URL."/modules/"._CXM_DIR_NAME."/index.php?op=submit",2,_C_NEEDSUBMIT);
	}
	
	xoops_cp_footer();
	break;

case "upload":

	$uploadpath=XOOPS_ROOT_PATH."/uploads/".$xoopsModulesConfig['uploadpath']."/";
	$source=$_FILES[fileupload][tmp_name];
	$fileupload_name=$_FILES[fileupload][name];
	if ( ($source != 'none') && ($source != '' )) {
	  $dest=$uploadpath.$fileupload_name;
	  if(file_exists($uploadpath.$fileupload_name)) {
	    redirect_header("index.php",2,_C_ERRORUPL);
	  } else {
	    if (copy($source, $dest)) {
	      redirect_header("index.php",2,_C_UPLOADED);
	    } else {
		  redirect_header("index.php",2,_C_ERRORUPL);
	    }
	  unlink ($source);
	  }
	}

	break;

case "delete":

	$perm = $xcenter_handler->getSingleCenterPermission($xcenter->getVar('center_id'), 'delete');
	if (!$perm) {
		redirect_header("index.php?op=show",1,_NOPERM);
	}

	xoops_cp_header();
	xoops_confirm(array('id' => intval($xcenter->getVar('center_id')), 'op' => 'deleteit'), 'index.php', _C_RUSUREDEL, _YES);
	xoops_cp_footer();
	break;

case "deleteit":
	global $xoopsDB;

	$perm = $xcenter_handler->getSingleCenterPermission($xcenter->getVar('center_id'), 'delete');
	if (!$perm) {
		redirect_header("index.php?op=show",1,_NOPERM);
	}

    $result=$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix(_CXM_XCENTER_PREFIX)." WHERE center_id=".intval($xcenter->getVar('center_id')));
	xoops_comment_delete($xoopsModule->getVar('mid'), $xcenter->getVar('center_id'));
	redirect_header("index.php?op=show",1,_C_DBUPDATED);
	break;

default:
	xoops_cp_header();
    echo "<h4>"._C_ADMINTITLE."</h4><table width='100%' border='0' cellspacing='1' class='outer'>";
	echo "<tr><td class='odd'> - <b><a href='index.php?op=submit'>"._C_MD_ADMENU1."</a></b>";
	echo "<br /><br />";
	echo " - <b><a href='index.php?op=nlink'>"._C_MD_ADMENU2."</a></b>";
	echo "<br /><br />";
	echo " - <b><a href='index.php?op=show'>"._C_MD_ADMENU3."</a></b>";
	echo "<br /><br />";
	echo " - <b><a href='order_menu.php'>"._C_MD_ADMENU4."</a></b>";
	echo "<br /><br />";
	echo " - <b><a href='migrate.php'>"._C_MD_ADMENU4."</a></b>";
	echo "<br /><br />";
	echo "- <b><a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid') ."'>"._PREFERENCES."</a></b></td></tr></table>";

	xoops_cp_footer();
	break;
}
?>
