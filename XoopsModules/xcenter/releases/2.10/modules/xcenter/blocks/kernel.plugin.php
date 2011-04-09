<?php


	function xoops_kernel_block_plugin_xcenter()
	{
		return intval($_GET['storyid']);
	}

	function xoops_kernel_block_list_plugin_xcenter()
	{
		$xcenter_handler =& xoops_getmodulehandler('xcenter', 'xcenter');
		$xcenters = $xcenter_handler->getObjects(NULL, true);
		foreach($xcenters as $storyid => $xcenter) {
			$data = $xcenter_handler->getContent($storyid);
			$ret[$storyid] = $data['text']->getVar('title').' - '.$data['text']->getVar('ptitle');
		}
		return $ret;
	}

?>