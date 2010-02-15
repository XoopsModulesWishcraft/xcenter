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

	require ('xml2array.php');
	
	if (!class_exists('xcenter_ct_xml'))
	{
		class xcenter_ct_xml
		{
			
			var $xml;
			var $xml_array;
			var $sql;
			var $sql_data;
			
			function xcenter_ct_xml($xml)
			{
				return $this->set_xml($xml);
			}
			
			function set_xml($xml)
			{
				@$this->xml = $xml;
				if (strlen($xml))
				{
					$xmlphrs = new XML2Array();
					@$this->xml_array = $xmlphrs->parse($xml);
				}			
				return $this->xml_array;
			}
			
			function set_data($sql_data)
			{
				if (!is_array($sql_data))
					@$this->sql_data = array_unique(explode(",",$sql_data));
				else
					@$this->sql_data = $sql_data;
			}
			
			function get_block($doctype = "ct")
			{
				global $xoopsDB;
				$func = "block_items_".$doctype;
				$xml = $this->xml_array;							
				$xml = $xml['block'];
					
				if (isset($xml['version']))
					$func .= "_".str_replace(".","_",$xml['version']);
				
//				echo "<pre>Execute : $func </br>$xml</pre>";	
				
				$sql = $this->get("xcenter", $doctype, "sql" , "database");
				$result = $xoopsDB->query($sql);
				
				if ($xoopsDB->getRowsNum($result))
					return $this->$func($result,$xml);
			}
			
			
			function get($enscape = "xcenter", $doctype = "ct", $type = "sql" , $base_ele = "database")
			{
				$xml = $this->xml_array;
	
				if (isset($xml["$enscape_$doctype"]))
					$xml = $xml["$enscape_$doctype"];
				
				if (strlen($xml['version']))
				{
					$func = sprintf("get_%s_%s_%s",$type,$doctype,str_replace(".","_",$xml['version']));
					return $this->$func("$enscape_$doctype", $base_ele);
			
				}
			}
			
			private function get_sql_ct_1_10($document, $element)
			{
				$xml = $this->xml_array;

				if (isset($xml[$document]))
					$xml = $xml[$document];
				if (isset($xml[$element]))
					$xml = $xml[$element];
								
				$sql = array();
				
				global $xoopsDB;
				
				foreach ($xml as $bsl => $ele)
				{
					switch ($bsl)
					{
						case "tables":
							foreach ($ele as $details => $table)
							{
								if ($table['alias'])
									$sql[$bsl][$table['alias']] = $xoopsDB->prefix($table['name'])." as ".$table['alias'];
								else
									$sql[$bsl][$table['name']] = $xoopsDB->prefix($table['name']);
							}
							break;
							
						case "joins":
							foreach ($ele as $joins => $join)
							{
						
								foreach ($join['ons'] as $ons => $on)
								{
									if (strlen($sql[$bsl][$join['alias']]['on'])&&strlen($on['next_on']))
									{
										$sql[$bsl][$join['alias']]['on'] .= " ".$on['next_on']. " ";
										$on['next_on'] = "";									
									}
									foreach ($on['field'] as $field_key => $field)
									{
										if ($field['alias'])
										{
											if (strlen($on['condition']))
												$sql[$bsl][$join['alias']]['on'] .= " ".$field['alias'].".".$field['field']." ".$on['condition'];
											else
												$sql[$bsl][$join['alias']]['on'] .= " ".$field['alias'].".".$field['field'];

											$on['condition']='';
											
										} else {
											if (strlen($on['condition']))
												$sql[$bsl][$join['alias']]['on'] .= " ".$field['field']." ".$on['condition'];
											else
												$sql[$bsl][$join['alias']]['on'] .= " ".$field['field'];

											$on['condition']='';											
										}
									}
								}

								if (sizeof($join['tables']['table'])>1)
								{
									foreach ($join['tables']['table'] as $tables => $table)
									{
										if ($table['alias'])
											$tbl = $xoopsDB->prefix($table['name'])." as ".$table['alias'];
										else
											$tbl = $xoopsDB->prefix($table['name']);												
											
										if ($table['alias']&&!$sql[$bsl][$join['alias']]['table'])
											$sql[$bsl][$join['alias']]['table'] = $tbl." ";
										else
											$sql[$bsl][$join['alias']]['table'] .= $join['type']." ".$tbl." ";
									}
								} else {
									$table = $join['tables']['table'];
									if ($table['alias'])
										$tbl = $xoopsDB->prefix($table['name'])." as ".$table['alias'];
									else
										$tbl = $xoopsDB->prefix($table['name']);												
									$sql[$bsl][$join['alias']]['table'] .= $join['type']." ".$tbl." ";
								}
								if (isset($join['prev_join']['alias']))
								{
									$sql[$bsl]['order'][] = $join['prev_join']['alias'];
								} else {
									$sql[$bsl]['order'][] = sizeof($sql[$bsl]['order'])+1;
								}
							}

							break;
							
						case "fields":

							foreach ($ele as $fields => $field)
							{		
								foreach($field as $k => $v)		
									$sql[$bsl][] = $v;
							}
							
							break;

						case "orders":
							$i=0;
							$clause = "";
							foreach ($ele as $orders => $order)
							{
								$ii++;
								if ($order['alias'])
									$clause = $order['alias'].".".$order['name'];
								else 
									$clause = $order['name'];
	
								if ($order['order'])
									$clause .= ' '.$order['order'];
								
								if ($ii<sizeof($ele)&&sizeof($ele)>1)
									$clause .= ", ";
							}
							
							$sql[$bsl] = $clause;
							break;
							
						case "limit":
							$sql[$bsl] = $ele;
							break;
						
						case "having":
						case "where":
							$clause = "";
							foreach ($ele as $fields => $field)
							{

								if ($field['alias'])
									$clause = $field['alias'].".".$field['name'];
								else 
									$clause = $field['name'];
									
								if (stristr($field['condition'],"{keyword_array}"))
								{
									$clause .= " ".str_replace("{keyword_array}","'".implode("','",$this->sql_data)."'",$field['condition']);
								} elseif (stristr($field['condition'],"{keyword_segment}")) {
									$i=0;
									foreach($this->sql_data as $k => $keyword)
									{
										$ii++;
										$clause .= " ".str_replace("{keyword_segment}","'".$keyword."'",$field['condition']);
										if ($ii<sizeof($this->sql_data)&&sizeof($this->sql_data)>1)
											$clause .= ' '.$field['totality'].' ';
									}						
								}
							}
						$sql[$bsl] = $clause;
						break;
					}
					
				}
				
				$str_sql = "SELECT ".implode(', ',$sql['fields'])." FROM ";
				if (sizeof($sql['joins']))
				{
					foreach ($sql['joins']['order'] as $k => $dat)
					{
						$str_sql .= $sql['joins'][$dat]['table']." on ".$sql['joins'][$dat]['on'];
					}
				} else {
					$str_sql .= "`".implode('`, `',$sql['tables'])."`";
				}
				if ($sql['where'])
					$str_sql .= " WHERE ".$sql['where'];
					
				if ($sql['orders'])
					$str_sql .= " ORDER BY ".$sql['orders'];

				if ($sql['having'])
					$str_sql .= " HAVING ".$sql['having'];

				if ($sql['limit'])
					$str_sql .= " LIMIT ".$sql['limit'];

//				print_r($sql);
				
				return $str_sql;
			}
			
			private function get_sql_ct_1_11($document, $element)
			{
				$xml = $this->xml_array;

				if (isset($xml[$document]))
					$xml = $xml[$document];
				if (isset($xml[$element]))
					$xml = $xml[$element];
				
				return str_replace("{keyword_array}","'".implode("','",$this->sql_data)."'",$xml['sql']);
				
			}
			
			private function block_items_ct($recset, $xml)
			{
				return $this->block_items_ct_1_02($recset, $xml);
			}
			
			private function block_items_ct_1_02($recset, $xml)
			{
				global $xoopsDB;
				$myts =& MyTextSanitizer::getInstance();

				$items = array();
				switch (strtolower($xml['type']))
				{

					case "textual":
						while ($row = $xoopsDB->fetchArray($recset))
						{
							$ii++;
							$items[$ii]['uri'] = str_replace('{XOOPS_URL}',XOOPS_URL,$xml['link']);
							foreach ($xml['component'] as $com => $node)
							{
								switch ($node['type'])
								{
									case "image":
										$items[$ii][$node['type']] = "<img src='".str_replace('{XOOPS_URL}',XOOPS_URL,$node['src'])."'";
										if (sizeof($node['optional'])>0)
											foreach($node['optional'] as $element => $value)
												$items[$ii][$node['type']] .= " $element='$value'";

										$items[$ii][$node['type']] .= ">";
										
										foreach($node['fields'] as $k => $field)
										{
											$items[$ii][$node['type']] = str_replace("{".$field."}",$row[$field],$items[$ii][$node['type']]);
										}
										break;
									default:	
										$items[$ii][$node['type']] = $myts->displayTarea($row[$node['field']], 1, 1, 1, 1, 0);							$items[$ii]['uri'] = str_replace("{".$node['field']."}",$row[$node['field']],$items[$ii]['uri']);
								}
							}
						}
						
						break;
					case "image":
						while ($row = $xoopsDB->fetchArray($recset))
						{
							$ii++;
							$items[$ii]['uri'] = $xml['link'];
							$items[$ii]['src'] = "<img src='".str_replace('{XOOPS_URL}',XOOPS_URL,$xml['src'])."'";
							if (sizeof($node['optional'])>0)
								foreach($node['optional'] as $element => $value)
									$items[$ii]['src'] .= " $element='$value'";

							foreach ($xml['component'] as $com => $node)
							{

								$items[$ii]['uri'] = str_replace("{".$node['field']."}",$row[$node['field']],$items[$ii]['uri']);
								$items[$ii]['src'] = str_replace("{".$node['field']."}",$row[$node['field']],$items[$ii]['src']);
							}
						}
					
					break;	
						
				}					
				$result = array("type" => strtolower($xml['type']), "items" => $items);
				return $result;
			}
		}
	}
?>