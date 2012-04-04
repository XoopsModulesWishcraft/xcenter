#
# Table structure for table xcenter_blocks
#
#Create Table

CREATE TABLE xcenter_blocks (                   
	`blockid` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,  
	`created` INT(12) DEFAULT '0',                       
	`uid` INT(12) DEFAULT '0',                           
	PRIMARY KEY (`blockid`)                              
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

#
# Table structure for table xcenter_categories
#
#Create Table

CREATE TABLE xcenter_categories (               
	`catid` INT(8) NOT NULL AUTO_INCREMENT,              
	`parent_id` INT(8) NOT NULL DEFAULT '0',             
	`rssenabled` TINYINT(2) DEFAULT '0',                 
	PRIMARY KEY (`catid`),                               
	KEY `AccessIndex` (`catid`,`parent_id`)              
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

#
# Table structure for table xcenter_xcenter
#
#Create Table

CREATE TABLE xcenter_xcenter (                              
	`storyid` INT(8) NOT NULL AUTO_INCREMENT,                                  
	`parent_id` INT(8) NOT NULL DEFAULT '0',                                   
	`blockid` INT(8) UNSIGNED NOT NULL DEFAULT '0',                            
	`catid` INT(8) UNSIGNED NOT NULL DEFAULT '0',                              
	`weight` INT(8) UNSIGNED NOT NULL DEFAULT '1',  
	`uid` INT(12) UNSIGNED NOT NULL DEFAULT '0',                               
	`visible` TINYINT(1) NOT NULL DEFAULT '0',                                 
	`homepage` TINYINT(1) NOT NULL DEFAULT '0',                                
	`nohtml` TINYINT(1) NOT NULL DEFAULT '0',                                  
	`nosmiley` TINYINT(1) NOT NULL DEFAULT '0',                                
	`nobreaks` TINYINT(1) NOT NULL DEFAULT '0',                                
	`nocomments` TINYINT(1) NOT NULL DEFAULT '0',                              
	`link` TINYINT(1) NOT NULL DEFAULT '0',                                    
	`address` VARCHAR(255) DEFAULT NULL,                                       
	`submenu` TINYINT(1) NOT NULL DEFAULT '0',                                 
	`date` INT(8) DEFAULT '0',                                                 
	`assoc_module` INT(8) UNSIGNED DEFAULT NULL,                               
	`tags` VARCHAR(255) DEFAULT NULL,                                          
	`publish` INT(12) DEFAULT '0',                                             
	`publish_storyid` INT(8) DEFAULT '0',                                      
	`expire` INT(12) DEFAULT '0',                                              
	`expire_storyid` INT(8) DEFAULT '0',                                       
	`password` VARCHAR(32) DEFAULT NULL,                                       
	PRIMARY KEY (`storyid`),                                                   
	KEY `AccessIndex` (`parent_id`,`blockid`,`catid`),                         
	KEY `UserIndex` (`storyid`,`uid`),                                         
	KEY `TimingIndex` (`publish`,`publish_storyid`,`expire`,`expire_storyid`)  
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

#
# Table structure for table xcenter_text
#
#Create Table

CREATE TABLE xcenter_text (                      
	`xcenterid` INT(8) NOT NULL AUTO_INCREMENT,                            
	`storyid` INT(8) NOT NULL DEFAULT '0',                                 
	`catid` INT(8) DEFAULT '0',                                            
	`blockid` INT(8) DEFAULT '0',                                          
	`type` ENUM('xcenter','category','block') NOT NULL DEFAULT 'xcenter',  
	`language` VARCHAR(64) NOT NULL DEFAULT 'english',                     
	`title` VARCHAR(255) DEFAULT '',                                       
	`ptitle` VARCHAR(255) DEFAULT NULL,                                    
	`text` LONGTEXT,                                                       
	`keywords` MEDIUMTEXT,                                                 
	`page_description` MEDIUMTEXT,                                         
	`rss` LONGTEXT,                                                        
	PRIMARY KEY (`xcenterid`),                                             
	KEY `AccessIndex` (`storyid`,`catid`,`blockid`,`type`)                 
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

