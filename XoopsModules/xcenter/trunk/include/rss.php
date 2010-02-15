<?


	function xcenter_backend_rss($items)
	{
		global $xoopsDB, $xoopsModule;

		$module_handler =& xoops_gethandler('module');
		$module = $module_handler->getByDirName('xcenter');
		
		if ($items<1)
			$items=3;
				
		$sql = "SELECT center_id, title, summary FROM ".$xoopsDB->prefix('xcenter')." WHERE visible='1' ORDER by center_id ASC limit 0,$items";

		$result = $xoopsDB->query($sql);
		$ibuffer = array();
		while ($row = $xoopsDB->fetchArray($result))
		{
			$it++;
			$ibuffer[$it]['title'] = $row['title'];
			$ibuffer[$it]['link'] = XOOPS_URL."/modules/xcenter/index.php?center_id=".$row['center_id'];
			$ibuffer[$it]['guid'] = XOOPS_URL."/modules/xcenter/index.php?center_id=".$row['center_id'];
			$ibuffer[$it]['pubDate'] = time();
			$ibuffer[$it]['category'] = $module->getVar('name');
			$ibuffer[$it]['description'] = $row['summary'];
		}
	     
		return $ibuffer;
	}

?>