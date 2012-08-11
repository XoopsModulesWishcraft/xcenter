<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

error_reporting(0);
include_once 'header.php';

$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
$category_handler =& xoops_getmodulehandler(_XTR_CLASS_CATEGORY, _XTR_DIRNAME);
$xcenter = $xcenter_handler->getContent($storyid, $language);

if (empty($storyid)&&$xcenter_handler->getCount(new Criteria('storyid', $storyid))==0)  {
    redirect_header(XOOPS_URL._XTR_PATH_MODULE_ROOT,2,_XTR_NOSTORY);
    exit();
}

if (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_XCENTER,$xcenter['xcenter']->getVar('storyid'),$groups, $modid))
	redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
elseif (!$gperm_handler->checkRight(_XTR_PERM_MODE_VIEW._XTR_PERM_TYPE_CATEGORY,$xcenter['xcenter']->getVar('catid'),$groups, $modid)
		&& $GLOBALS['xoopsModuleConfig']['security'] != _XTR_SECURITY_BASIC )
	redirect_header(XOOPS_URL, 10, _XTR_NOPERMISSIONS);
else {


	if ($GLOBALS['xoopsModuleConfig']['htaccess'])
		if (strpos($_SERVER['REQUEST_URI'], 'odules/')>0) {
			$category = $category_handler->getCategory($catid);
			if ($category['text']->getVar('title')!='') {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.xoops_sef($category['text']->getVar('title')).'/pdf,'.$storyid.$GLOBALS['xoopsModuleConfig']['endofurl_pdf']);
			} else {
				header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/pdf,'.$storyid.$GLOBALS['xoopsModuleConfig']['endofurl_pdf']);
			}
			exit(0);
		}
		
		if ($xcenter['xcenter']->getVar('publish')>time()&&$xcenter['xcenter']->getVar('publish')!=0) {
			if ($xcenter['xcenter']->getVar('publish_storyid')>0)
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/?storyid='.$xcenter['xcenter']->getVar('publish_storyid'), 10, _XTR_TOBEPUBLISHED);
			else
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/', 10, _XTR_TOBEPUBLISHED);
			exit(0);
		} elseif ($xcenter['xcenter']->getVar('expire')<time()&&$xcenter['xcenter']->getVar('expire')!=0) {
			if ($xcenter['xcenter']->getVar('expire_storyid')>0)
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/?storyid='.$xcenter['xcenter']->getVar('expire_storyid'), 10, _XTR_XCENTEREXPIRED);
			else
				redirect_header(XOOPS_URL.'/modules/'._XTR_DIRNAME.'/', 10, _XTR_XCENTEREXPIRED);
			exit(0);
		} elseif (strlen($xcenter['xcenter']->getVar('password'))==32) {
			if (!isset($_COOKIE['xcenter_password']))
				$_COOKIE['xcenter_password'] = array();
			if ($_COOKIE['xcenter_password'][md5(sha1(XOOPS_LICENSE_KEY).$storyid)]==false)
				if (md5($_POST['password'])!=$xcenter['xcenter']->getVar('password')) {
					include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_HEADER);
					$xoopsOption['template_main'] = _XTR_TEMPLATE_INDEX_PASSWORD;
					$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', xcenter_getPageTitle($xcenter['xcenter']->getVar('storyid')));
					$GLOBALS['xoTheme']->addMeta( 'meta', 'keywords', xcenter_getMetaKeywords($xcenter['xcenter']->getVar('storyid')));
					$GLOBALS['xoTheme']->addMeta( 'meta', 'description', xcenter_getMetaDescription($xcenter['xcenter']->getVar('storyid')));
					$GLOBALS['xoopsTpl']->assign('xoXcenter', array_merge($xcenter['xcenter']->toArray(), $xcenter['text']->toArray(), $xcenter['perms']));	            
					$GLOBALS['xoopsTpl']->assign('form', xcenter_passwordform($xcenter['xcenter']->getVar('storyid')));
					include_once $GLOBALS['xoops']->path(_XTR_PATH_PHP_FOOTER);
					exit(0);
				} else {
					$_COOKIE['xcenter_password'][md5(sha1(XOOPS_LICENSE_KEY).$storyid)]=true;
				}
			else 
				$_COOKIE['xcenter_password'][md5(sha1(XOOPS_LICENSE_KEY).$storyid)]=true;
			
		
		}		


	$category = $category_handler->getCategory($xcenter['xcenter']->getVar('catid'), $language);
	
	$pdf_data['title'] = $xcenter['text']->getVar('ptitle');
	$pdf_data['subtitle'] = $category['text']->getVar('ptitle');
	
	$pdf_data['subsubtitle'] = '';
	$pdf_data['date'] = ': '.date(_DATESTRING, $xcenter['xcenter']->getVar('date'));
	$pdf_data['filename'] = preg_replace("/[^0-9a-z\-_\.]/i",'', $myts->htmlSpecialChars($pdf_data['title']).' - '.$pdf_data['subtitle']);
	$pdf_data['filename'] = 'test';
	
	$member_handler =& xoops_gethandler('member');
	$author = $member_handler->getUser($xcenter['xcenter']->getVar('uid'));
	if ($author->getVar('name'))
		$pdf_data['author'] = $author->getVar('name') . '('.$author->getVar('uname').')';
	else
		$pdf_data['author'] = $author->getVar('uname');

	$nohtml = ($xcenter['xcenter']->getVar('nohtml'))?0:1;
	$nosmiley = ($xcenter['xcenter']->getVar('nosmiley'))?0:1;
	$nobreaks = ($xcenter['xcenter']->getVar('nobreaks'))?0:1;
		
	$xcenter = $myts->undoHtmlSpecialChars($myts->displayTarea(clear_unicodeslashes($xcenter['text']->getVar('text')), $nohtml, $nosmiley, 1, 1, $nobreaks));

	$pdf_data['xcenter'] = $xcenter;
	
	define('PDF_CREATOR', $GLOBALS['xoopsConfig']['sitename']);
	define('PDF_AUTHOR', $pdf_data['author']);
	define('PDF_HEADER_TITLE', $pdf_data['title']);
	define('PDF_HEADER_STRING', $pdf_data['subtitle']);
	define('PDF_HEADER_LOGO', 'logo.png');
	define('K_PATH_IMAGES', XOOPS_ROOT_PATH.'/images/');
	
	require_once XOOPS_ROOT_PATH.'/Frameworks/tcpdf/tcpdf.php';
	
	$filename = XOOPS_ROOT_PATH.'/Frameworks/tcpdf/config/lang/'._LANGCODE.'.php';
	if(file_exists($filename)) {
		include_once $filename;
	} else {
		include_once XOOPS_ROOT_PATH.'/Frameworks/tcpdf/config/lang/en.php';
	}


	//DNPROSSI Added - xlanguage installed and active 
	$module_handler =& xoops_gethandler('module');
	$xlanguage = $module_handler->getByDirname('xlanguage');
	if ( is_object($xlanguage) && $xlanguage->getVar('isactive') == true ) 
	{ $xlang = true; } else { $xlang = false; }  	
	
	$xcenter = '';
	$xcenter .= '<b><i><u>'.$myts->undoHtmlSpecialChars($pdf_data['title']).'</u></i></b><br /><b>'.$myts->undoHtmlSpecialChars($pdf_data['subtitle']).'</b><br />'._POSTEDBY.' : '.$myts->undoHtmlSpecialChars($pdf_data['author']).'<br />'._XTR_POSTEDON.' '.$pdf_data['date'].'<br /><br /><br />';
	//$xcenter .= $myts->undoHtmlSpecialChars($article->hometext()) . '<br /><br /><br />' . $myts->undoHtmlSpecialChars($article->bodytext());
	//$xcenter = str_replace('[pagebreak]','<br />',$xcenter);
	$xcenter .= $myts->undoHtmlSpecialChars($pdf_data['xcenter']);

	//DNPROSSI Added - Get correct language and remove tags from text to be sent to PDF
	if ( $xlang == true ) { 
	   include_once XOOPS_ROOT_PATH.'/modules/xlanguage/include/functions.php';
	   $xcenter = xlanguage_ml($xcenter);
	}

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$doc_title = $myts->undoHtmlSpecialChars($pdf_data['title']);
	$doc_keywords = 'XOOPS';

	//DNPROSSI ADDED gbsn00lp chinese to tcpdf fonts dir
	if (_LANGCODE == "cn") { $pdf->SetFont('gbsn00lp', '', 10); } 

	// set document information
	$pdf->SetCreator($pdf_data['author']);
	$pdf->SetAuthor($pdf_data['author']);
	$pdf->SetTitle($pdf_data['title']);
	$pdf->SetSubject($pdf_data['subtitle']);
	$pdf->SetKeywords($doc_keywords);

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	//$pdf->SetHeaderData('', '', $firstLine, $secondLine);
	//$pdf->SetHeaderData('logo_example.png', '25', $firstLine, $secondLine);
	//UTF-8 char sample
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, '25', 'Éèéàùìò', $article->title());
	
	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->setImageScale(1); //set image scale factor
	
	//DNPROSSI ADDED FOR SCHINESE
	if (_LANGCODE == "cn") 
	{ 
		$pdf->setHeaderFont(Array('gbsn00lp', '', 10));
		$pdf->setFooterFont(Array('gbsn00lp', '', 10));
	}
	else 
	{
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	}	
	
	$pdf->setLanguageArray($l); //set language items
	
	//initialize document
	$pdf->AliasNbPages();
	
	// ***** For Testing Purposes
	/*$pdf->AddPage();
	
	// print a line using Cell()
	*$pdf->Cell(0, 10, K_PATH_URL. '  ---- Path Url', 1, 1, 'C');
	$pdf->Cell(0, 10, K_PATH_MAIN. '  ---- Path Main', 1, 1, 'C');
	$pdf->Cell(0, 10, K_PATH_FONTS. '  ---- Path Fonts', 1, 1, 'C');
	$pdf->Cell(0, 10, K_PATH_IMAGES. '  ---- Path Images', 1, 1, 'C');
	*/
	// ***** End Test
	
	$pdf->AddPage();
	$pdf->writeHTML($xcenter, true, 0);
	//Added for buffer error in TCPDF when using chinese charset
	  ob_end_clean();
	$pdf->Output();}
?>