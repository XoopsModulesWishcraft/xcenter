#
# Table structure for table `xcenter`
#
#Create Table
CREATE TABLE xcenter (
  center_id int(16) NOT NULL auto_increment,
  parent_id int(16) NOT NULL default '0',
  weight int(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  summary varchar(560) NOT NULL default '',
  keywords varchar(2000) NOT NULL default '',
  text text default NULL,
  visible tinyint(1) NOT NULL default '0',
  homepage tinyint(1) NOT NULL default '0',
  nohtml tinyint(1) NOT NULL default '0',
  nosmiley tinyint(1) NOT NULL default '0',
  nobreaks tinyint(1) NOT NULL default '0',
  nocomments tinyint(1) NOT NULL default '0',
  anonymous tinyint(1) NOT NULL default '1',
  link tinyint(1) NOT NULL default '0',
  address varchar(255) default NULL,
  submenu tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (center_id, weight, title(20))
) TYPE=MyISAM;

#
# Table structure for table `xcenter_mblocks`
#
#Create Table
CREATE TABLE xcenter_mblocks (
  id int(16) NOT NULL auto_increment,
  center_id int(16) NOT NULL default '0',
  mod_id int(8) NOT NULL default '0',
  bid int(8) unsigned NOT NULL default '0',
  summary varchar(560) NOT NULL default '',
  xml text default NULL,
  PRIMARY KEY  (id),
  KEY sid (center_id, mod_id)
) TYPE=MyISAM;