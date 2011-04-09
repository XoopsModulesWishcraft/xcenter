<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

include "../../mainfile.php";
header( "HTTP/1.1 301 Moved Permanently" );  header('Location: '.XOOPS_URL.str_replace('xcenter','tag',$_SERVER['PHP_SELF']));
?>