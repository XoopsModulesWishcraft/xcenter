<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


function xcenter_search($queryarray, $andor, $limit, $offset, $userid){

  if ( file_exists(XOOPS_ROOT_PATH."/modules/xcenter/language/".$GLOBALS['xoopsConfig']['language']."/modinfo.php") ) {
    include(XOOPS_ROOT_PATH."/modules/xcenter/language/".$GLOBALS['xoopsConfig']['language']."/modinfo.php");
  } elseif ( file_exists(XOOPS_ROOT_PATH."/modules/xcenter/language/english/modinfo.php") ) {
    include(XOOPS_ROOT_PATH."/modules/xcenter/language/english/modinfo.php");
  }
  
  if ($userid>0)
		$sql = "SELECT a.storyid, a.title, a.text, b.uid FROM ".$GLOBALS['xoopsDB']->prefix(_XTR_TABLE_TEXT)." a inner join  FROM ".$GLOBALS['xoopsDB']->prefix(_XTR_TABLE_XCENTER)." b ON a.storyid = b.storyid WHERE b.visible='1' AND b.uid=".$userid;
  else 
	  	$sql = "SELECT a.storyid, a.title, a.text, b.uid FROM ".$GLOBALS['xoopsDB']->prefix(_XTR_TABLE_TEXT)." a inner join  FROM ".$GLOBALS['xoopsDB']->prefix(_XTR_TABLE_XCENTER)." b ON a.storyid = b.storyid WHERE b.visible='1'";

  // because count() returns 1 even if a supplied variable
  // is not an array, we must check if $querryarray is really an array
  if ( is_array($queryarray) && $count = count($queryarray) ) {
    $sql .= " AND ((a.text LIKE '%".xoops_convert_encode($queryarray[0])."%' OR a.title LIKE '%".xoops_convert_encode($queryarray[0])."%')";
    for($i=1;$i<$count;$i++){
      $sql .= " $andor ";
      $sql .= "(a.text LIKE '%$".xoops_convert_encode($queryarray[$i])."%' OR a.title LIKE '%".xoops_convert_encode($queryarray[$i])."%')";
    }
    $sql .= ")";
  }
  
  $sql .= " ORDER BY b.date ASC";
  $result = $GLOBALS['xoopsDB']->query($sql,$limit,$offset);
  $ret = array();
  $i = 0;
  
  while($myrow = $GLOBALS['xoopsDB']->fetchArray($result)){
    $ret[$i]['image'] = "";
    $ret[$i]['link'] = "index.php?storyid=".$myrow['storyid'];
    $ret[$i]['title'] = xoops_convert_decode($myrow['title']);
	$ret[$i]['text'] = xoops_convert_decode($myrow['text']);
	$ret[$i]['uid'] = $myrow['uid'];
    $i++;
  }
  
  return $ret;
}
?>
