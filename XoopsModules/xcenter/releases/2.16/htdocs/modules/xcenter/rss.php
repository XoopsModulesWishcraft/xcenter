<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/


include("header.php");

$catid = intval($_GET['catid']);

if ($GLOBALS['xoopsModuleConfig']['htaccess'])
	if (strpos($_SERVER['REQUEST_URI'], 'odules/')>0) {
		$category_handler =& xoops_getmodulehandler(_XTR_CLASS_CATEGORY, _XTR_DIRNAME);
		$category = $category_handler->getCategory($catid);
		if ($category['text']->getVar('title')!='') {
			header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.xoops_sef($category['text']->getVar('title')).'/feed,'.$catid.$GLOBALS['xoopsModuleConfig']['endofurl_rss']);
		} else {
			header( "HTTP/1.1 301 Moved Permanently" ); header('Location: '.XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/feed,'.$catid.$GLOBALS['xoopsModuleConfig']['endofurl_rss']);
		}
		exit(0);
	}


function rss_data($catid, $language)
{
	$myts =& MyTextSanitizer::getInstance();
	$rss=array();
	$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
	$category_handler =& xoops_getmodulehandler(_XTR_CLASS_CATEGORY, _XTR_DIRNAME);
	$criteria = new CriteriaCompo(new Criteria('catid', $catid), "AND");
	$criteria->setSort('weight');
	$xcenters = $xcenter_handler->getObjects($criteria, true);
	$category = array();
    foreach($xcenters as $storyid => $xcenter)
    {
		$txcenter = $xcenter_handler->getContent($storyid, $language);
		$tcategory = $category_handler->getCategory($xcenter->getVar('catid'));
		$download = array();
		$download['title'] = strip_tags($myts->displayTarea(clear_unicodeslashes($txcenter["text"]->getVar('ptitle')), 0, 0, 1));
		$download['description'] = htmlspecialchars($myts->displayTarea(clear_unicodeslashes($txcenter["text"]->getVar('rss')), 1, 1, 1));		
		$download['url'] = XOOPS_URL.'/modules/xcenter/?id='.$storyid.'&catid='.$xcenter->getVar('catid');
		$download['dossier_url'] = XOOPS_URL.'/modules/xcenter/?id='.$storyid.'&catid='.$xcenter->getVar('catid');
		$download['date'] = date('D, d-m-y H:i:s e', $xcenter->getVar('date'));
		$download['category'] = $tcategory['text']->getVar('ptitle');			
		$category[] = ucfirst($download['category']);
		$rss['item'][$storyid] = $download;
       
    }
	$rss['category'] = array_unique($category);
    return $rss;
}

$myts = &MyTextSanitizer::getInstance();
	
$rssfeed_data = rss_data($catid, $language);

header("content-type: text/xml; charset="._CHARSET);  
?><?php echo '<?xml version="1.0" encoding="iso-8859-1"?>'.chr(10).chr(13); ?>
<rss version="2.0"> 

<channel>

<?php if (!isset($_REQUEST['ms'])) { ?> 
 <description><?php echo (htmlspecialchars($xoopsConfig['slogan'])).' '.htmlspecialchars(implode(', ',$rssfeed_data['category']));?></description>
 <lastBuildDate><?php echo date('D, d-m-y H:i:s e',time());?></lastBuildDate>
 <docs>http://backend.userland.com/rss/</docs>
 <generator><?php echo (htmlspecialchars($xoopsConfig['sitename']));?></generator>
 <category><?php echo implode(', ',$rssfeed_data['category']); ?></category>
 <managingEditor><?php echo $xoopsConfig['adminmail'];?></managingEditor>
 <webMaster><?php echo $xoopsConfig['adminmail'];?></webMaster>
<?php } ?>
 <language>en</language>
<?php if (!isset($_REQUEST['ms'])) { ?> 
 <image>
      <title><?php echo (htmlspecialchars($xoopsConfig['sitename']));?></title>
      <url><?php echo XOOPS_URL; ?>/images/logo.png</url>
      <link><?php echo XOOPS_URL; ?>/</link>
  </image>
 <title>RSS Feed | <?php echo htmlspecialchars($xoopsConfig['sitename']).' | '.ucfirst($rssfeed_data['category'][0]);?> </title> 
 <link><?php echo XOOPS_URL; ?></link>
<?php } ?> 
<?php

foreach ($rssfeed_data['item'] as $item) {
?>
 <item>
 <title><?php echo htmlspecialchars(($item['title']));?></title> 
 <link><?php echo htmlspecialchars($item['url']); ?></link>
 <description><?php echo $item['description']; ?></description> 
<?php if (!isset($_REQUEST['ms'])) { ?>
 <guid><?php echo htmlspecialchars($item['dossier_url']); ?></guid> 
 <category><?php echo $item['category']; ?></category> 
<?php } ?>
 <pubDate><?php echo $item['date'];?></pubDate>
 </item>
<?php

/*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

}?>
 </channel>
 </rss>
