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

if (!class_exists('XML2Array'))
{
	class XML2Array {
	
		public function parse($xml) {
			return $this->convert(simplexml_load_string($xml));
		}

		public function parse_file($xml_file) {
			return $this->convert(simplexml_load_file($xml_file));
		}
	
		function convert($xml) {
			$return = array();
			if ($xml instanceof SimpleXMLElement) {
				$children = $xml->children();
				$return = null;
			}
	
			foreach ($children as $element => $value) {
				if ($value instanceof SimpleXMLElement) {
					$values = (array)$value->children();
	
					if (count($values) > 0) {
						if (is_array($return[$element])) {
							//hook
							foreach ($return[$element] as $k=>$v) {
								if (!is_int($k)) {
									$return[$element][0][$k] = $v;
									unset($return[$element][$k]);
								}
							}
							$return[$element][] = $this->convert($value);
						} else {
							$return[$element] = $this->convert($value);
						}
					} else {
						if (!isset($return[$element])) {
							$return[$element] = (string)$value;
						} else {
							if (!is_array($return[$element])) {
								$return[$element] = array($return[$element], (string)$value);
							} else {
								$return[$element][] = (string)$value;
							}
						}
					}
				}
			}
	
			if (is_array($return)) {
				return $return;
			} else {
				return false;
			}
		}
	}
}
?>