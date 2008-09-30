<?


	function xcenter_sitemap($items)
	{
		global $xoopsDB, $xoopsModule;

		if ($items<1)
			$sql = "SELECT center_id FROM ".$xoopsDB->prefix('xcenter')." WHERE visible='1' ORDER by center_id ASC";
		else
			$sql = "SELECT center_id FROM ".$xoopsDB->prefix('xcenter')." WHERE visible='1' ORDER by center_id ASC limit 0,$items";

		$result = $xoopsDB->query($sql);
		$iurl = array();
		while ($row = $xoopsDB->fetchArray($result))
		{
			$it++;
			$iurl[$it]['loc'] = XOOPS_URL."/modules/xcenter/index.php?center_id=".$row['center_id'];
			$iurl[$it]['changefreq'] = 'daily'; // See Sitemap.org for all settings for this field.
			$iurl[$it]['lastmod'] = time(); // Last Modified Time
			$iurl[$it]['priority'] = '1'; // (from 0.1 to 1)
		}
	     
		return $iurl;
	}

?>