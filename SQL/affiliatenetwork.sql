
-- 
-- Table structure for table `admin_pay`
-- 

CREATE TABLE `admin_pay` (
  `pay_id` bigint(20) NOT NULL auto_increment,
  `pay_amount` double NOT NULL default '0',
  PRIMARY KEY  (`pay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `admin_pay`
-- 

INSERT INTO `admin_pay` VALUES (1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `affil_heap_sessionid`
-- 

CREATE TABLE `affil_heap_sessionid` (
  `heap_id` bigint(20) NOT NULL default '0',
  `heap_name` varchar(250) NOT NULL,
  `heap_regdate` date NOT NULL default '0000-00-00',
  `heap_approved` bigint(20) NOT NULL default '0',
  `heap_pending` bigint(20) NOT NULL default '0',
  `heap_paid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`heap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `affil_heap_sessionid`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `affiliate_pay`
-- 

CREATE TABLE `affiliate_pay` (
  `pay_id` bigint(20) NOT NULL auto_increment,
  `pay_affiliateid` bigint(20) NOT NULL default '0',
  `pay_amount` double NOT NULL default '0',
  PRIMARY KEY  (`pay_id`)
)   ;

-- 
-- Dumping data for table `affiliate_pay`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `merchant_pay`
-- 

CREATE TABLE `merchant_pay` (
  `pay_id` bigint(20) NOT NULL auto_increment,
  `pay_merchantid` bigint(20) NOT NULL default '0',
  `pay_amount` double NOT NULL default '0',
  PRIMARY KEY  (`pay_id`)
) ;

-- 
-- Dumping data for table `merchant_pay`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_addmoney`
-- 

CREATE TABLE `partners_addmoney` (
  `addmoney_id` bigint(20) NOT NULL auto_increment,
  `addmoney_merchantid` bigint(20) NOT NULL default '0',
  `addmoney_amount` double NOT NULL default '0',
  `addmoney_status` enum('approved','waiting','suspend','empty','NP') NOT NULL default 'approved',
  `addmoney_paytype` varchar(255) NOT NULL,
  `addmoney_date` date NOT NULL default '0000-00-00',
  `addmoney_mode` enum('register','addmoney','upgrade') NOT NULL default 'register',
  PRIMARY KEY  (`addmoney_id`)
)  ;

-- 
-- Dumping data for table `partners_addmoney`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_adjustment`
-- 

CREATE TABLE `partners_adjustment` (
  `adjust_id` bigint(20) NOT NULL auto_increment,
  `adjust_memberid` bigint(20) NOT NULL default '0',
  `adjust_action` enum('deduct','add','paidmail','withdraw','deposit','programFee','register') NOT NULL default 'deduct',
  `adjust_flag` enum('a','m') NOT NULL default 'a',
  `adjust_amount` double NOT NULL default '0',
  `adjust_date` date NOT NULL default '0000-00-00',
  `adjust_no` int(11) NOT NULL default '0',
  PRIMARY KEY  (`adjust_id`)
)  ;

-- 
-- Dumping data for table `partners_adjustment`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_admin`
-- 

CREATE TABLE `partners_admin` (
  `admin_login` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `admin_mailamnt` double NOT NULL default '0',
  `admin_mailheader` varchar(250) NOT NULL,
  `admin_mailfooter` varchar(250) NOT NULL,
  `admin_ip` varchar(16) default NULL,
  `admin_lastLogin` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`admin_login`),
  KEY `admin_ip` (`admin_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `partners_admin`
-- 

INSERT INTO `partners_admin` VALUES ('admin', 'admin@alstrasoft.com', 'admin', 22, 'Dates::', 'Affiliate Network Pro', '192.168.0.34', '2009-08-28 17:34:57');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_adminlinks`
-- 

CREATE TABLE `partners_adminlinks` (
  `adminlinks_id` bigint(20) NOT NULL auto_increment,
  `adminlinks_title` varchar(250) NOT NULL,
  `adminlinks_parentid` bigint(20) NOT NULL,
  `adminlinks_userid` longtext NOT NULL,
  PRIMARY KEY  (`adminlinks_id`)
)  ;

-- 
-- Dumping data for table `partners_adminlinks`
-- 

INSERT INTO `partners_adminlinks` VALUES (1, 'Merchants', 0, '');
INSERT INTO `partners_adminlinks` VALUES (2, 'Affiliates', 0, '');
INSERT INTO `partners_adminlinks` VALUES (3, 'Programs', 0, '');
INSERT INTO `partners_adminlinks` VALUES (4, 'Payments', 0, '');
INSERT INTO `partners_adminlinks` VALUES (5, 'Reports', 0, '');
INSERT INTO `partners_adminlinks` VALUES (6, 'Options', 0, '');
INSERT INTO `partners_adminlinks` VALUES (7, 'PGM Status', 0, '');
INSERT INTO `partners_adminlinks` VALUES (8, 'Adjust Money', 1, '');
INSERT INTO `partners_adminlinks` VALUES (9, 'Approve Merchants', 1, '');
INSERT INTO `partners_adminlinks` VALUES (10, 'Reject Merchant', 1, '');
INSERT INTO `partners_adminlinks` VALUES (11, 'Remove Merchant', 1, '');
INSERT INTO `partners_adminlinks` VALUES (12, 'Change Password of Merchant', 1, '');
INSERT INTO `partners_adminlinks` VALUES (13, 'Activate/Inactivate Invoice Status', 1, '');
INSERT INTO `partners_adminlinks` VALUES (14, 'Adjust Money', 2, '');
INSERT INTO `partners_adminlinks` VALUES (15, 'Approve Affiliate', 2, '');
INSERT INTO `partners_adminlinks` VALUES (16, 'Reject Affiliate', 2, '');
INSERT INTO `partners_adminlinks` VALUES (17, 'Remove Affiliate', 2, '');
INSERT INTO `partners_adminlinks` VALUES (18, 'Change Password of Affiliate', 2, '');
INSERT INTO `partners_adminlinks` VALUES (19, 'Approve/Reject Programs', 3, '');
INSERT INTO `partners_adminlinks` VALUES (20, 'Change Product Status', 3, '');
INSERT INTO `partners_adminlinks` VALUES (21, 'Approve/Reject Links', 3, '');
INSERT INTO `partners_adminlinks` VALUES (22, 'Edit Program Fee', 3, '');
INSERT INTO `partners_adminlinks` VALUES (23, 'Edit Second Tire Commission', 3, '');
INSERT INTO `partners_adminlinks` VALUES (24, 'Manage Affiliate Requests', 4, '');
INSERT INTO `partners_adminlinks` VALUES (25, 'Manage Merchant Requests', 4, '');
INSERT INTO `partners_adminlinks` VALUES (26, 'Manage Reverse Sales', 4, '');
INSERT INTO `partners_adminlinks` VALUES (27, 'Manage Reverse Recurring Sales', 4, '');
INSERT INTO `partners_adminlinks` VALUES (28, 'Manage Invoices', 4, '');
INSERT INTO `partners_adminlinks` VALUES (29, 'Administrator Settings', 6, '');
INSERT INTO `partners_adminlinks` VALUES (30, 'Gateways', 6, '');
INSERT INTO `partners_adminlinks` VALUES (31, 'Set Payments', 6, '');
INSERT INTO `partners_adminlinks` VALUES (32, 'Affiliates Generic Terms & Conditions', 6, '');
INSERT INTO `partners_adminlinks` VALUES (33, 'Merchant Generic Terms & Conditions', 6, '');
INSERT INTO `partners_adminlinks` VALUES (34, 'Add or Remove Category', 6, '');
INSERT INTO `partners_adminlinks` VALUES (35, 'Email Setup', 6, '');
INSERT INTO `partners_adminlinks` VALUES (36, 'Events Enabled For Merchants', 6, '');
INSERT INTO `partners_adminlinks` VALUES (37, 'Admin Mail', 6, '');
INSERT INTO `partners_adminlinks` VALUES (38, 'Bulk Mail', 6, '');
INSERT INTO `partners_adminlinks` VALUES (39, 'Languages', 6, '');
INSERT INTO `partners_adminlinks` VALUES (40, 'Currencies', 6, '');
INSERT INTO `partners_adminlinks` VALUES (41, 'IP-Country DB', 6, '');
INSERT INTO `partners_adminlinks` VALUES (42, 'Back up', 6, '');
INSERT INTO `partners_adminlinks` VALUES (43, 'Fraud Settings', 6, '');
INSERT INTO `partners_adminlinks` VALUES (53, 'Transaction', 2, '');
INSERT INTO `partners_adminlinks` VALUES (52, 'Affiliate Login', 2, '');
INSERT INTO `partners_adminlinks` VALUES (51, 'Suspend Affiliate', 2, '');
INSERT INTO `partners_adminlinks` VALUES (50, 'Payment History', 2, '');
INSERT INTO `partners_adminlinks` VALUES (49, 'Merchant Login', 1, '');
INSERT INTO `partners_adminlinks` VALUES (48, 'Change PGM Approval', 1, '');
INSERT INTO `partners_adminlinks` VALUES (47, 'Suspend Merchant', 1, '');
INSERT INTO `partners_adminlinks` VALUES (46, 'Transaction', 1, '');
INSERT INTO `partners_adminlinks` VALUES (45, 'Payment History', 1, '');
INSERT INTO `partners_adminlinks` VALUES (54, 'View Affiliate Requests', 4, '');
INSERT INTO `partners_adminlinks` VALUES (55, 'View Merchant Requests', 4, '');
INSERT INTO `partners_adminlinks` VALUES (56, 'View Reverse Sales', 4, '');
INSERT INTO `partners_adminlinks` VALUES (57, 'View Reverse Recurring Sales', 4, '');
INSERT INTO `partners_adminlinks` VALUES (58, 'View Invoices', 4, '');
INSERT INTO `partners_adminlinks` VALUES (59, 'Daily', 5, '');
INSERT INTO `partners_adminlinks` VALUES (60, 'For Period', 5, '');
INSERT INTO `partners_adminlinks` VALUES (61, 'Transaction', 5, '');
INSERT INTO `partners_adminlinks` VALUES (62, 'Link', 5, '');
INSERT INTO `partners_adminlinks` VALUES (63, 'Referer', 5, '');
INSERT INTO `partners_adminlinks` VALUES (64, 'Products', 5, '');
INSERT INTO `partners_adminlinks` VALUES (65, 'Recurring Commission', 5, '');
INSERT INTO `partners_adminlinks` VALUES (66, 'Graphs', 5, '');
INSERT INTO `partners_adminlinks` VALUES (67, 'Payment History', 0, '');
INSERT INTO `partners_adminlinks` VALUES (68, 'Affiliate Group Management', 6, '2');
INSERT INTO `partners_adminlinks` VALUES (69, 'Set Commission Group', 2, '');
INSERT INTO `partners_adminlinks` VALUES (71, 'Referral Commission', 5, '');
INSERT INTO `partners_adminlinks` VALUES (70, 'Affiliate Refferals', 5, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_adminmail`
-- 

CREATE TABLE `partners_adminmail` (
  `adminmail_id` bigint(20) NOT NULL auto_increment,
  `adminmail_eventname` varchar(100) NOT NULL default '0',
  `adminmail_from` varchar(100) default NULL,
  `adminmail_subject` varchar(100) default NULL,
  `adminmail_message` text,
  `adminmail_header` text,
  `adminmail_footer` text,
  PRIMARY KEY  (`adminmail_id`),
  UNIQUE KEY `adminmail_eventname` (`adminmail_eventname`)
)  ;

-- 
-- Dumping data for table `partners_adminmail`
-- 

INSERT INTO `partners_adminmail` VALUES (1, 'Approve Affiliate', 'admin@alstrasoft.com', 'Approve''s Affiliate', '<p><b>Hello [aff_firstname] [aff_lastname],</b></p>\r\n\r\n<p>Your account has been Approved</p>\r\n\r\nPlease login using ur email [aff_email] <br/>\r\nANd you password  [aff_password]', '<title>Affiliate Account Approved</title>', 'Thank U [aff_firstname]');
INSERT INTO `partners_adminmail` VALUES (2, 'Suspend Merchant', 'Admin@gg.gg', 'suspending', 's', 'header', 'f');
INSERT INTO `partners_adminmail` VALUES (3, 'Remove Merchant', 'admin@alstrasoft.com', 'Merchant Removal', 'Your Account has been Removed', 'hello [mer_firstname] [mer_lastname]', 'test footer');
INSERT INTO `partners_adminmail` VALUES (4, 'Change Affiliate Password', '[from]', 'Affiliate Password Changed', '<p>Your Password is changed on [today]</p>\r\n<p>Username is : [aff_email]</p>\r\n<p>Password is : [aff_password]</p>\r\n<p>Your url is : [aff_loginlink]</p>', 'Hello [aff_firstname] [aff_lastname],', 'Thank U [aff_firstname]');
INSERT INTO `partners_adminmail` VALUES (5, 'Approve Merchant', 'admin@alstrasoft.com', 'Merchant Approved', 'Your Merchant Account is Approved', 'Hello [mer_firstname] [mer_lastname]', 'test footer');
INSERT INTO `partners_adminmail` VALUES (6, 'Affiliate Registration', '[from]', 'Registered Successfully as Affiliate', '<p>We are happy to inform you that your company [aff_company] is registered as Affiliate</p>\r\n<p>You can login as Affiliate to ANP using : </p>\r\n<p>Username : [aff_email]</p>\r\n<p>Password  : [aff_password]</p>\r\n<p>from [today] onwards</p>', 'Hello Affiliate [aff_firstname] [aff_lastname],', 'Thank U [aff_firstname]');
INSERT INTO `partners_adminmail` VALUES (7, 'Suspend Affiliate', 'admin@alstrasoft.com', 'Your Account Suspended', '<p>Hello [aff_firstname]	 </p>\r\n<p> Your affiliate account in anp is suspended. <br> For more details contact\r\nsupport@alstrasoft.com\r\n</p>', '<title>Affiliate Account Suspended</title>', 'Thank U Affiliate');
INSERT INTO `partners_adminmail` VALUES (8, 'Approve Transaction', 'mer@alstrasoft.com', 'Transaction Approved', 'Your Recurring Trn has been Approved', 'Your Trn has been Approved', 'Thank U affiliate');
INSERT INTO `partners_adminmail` VALUES (9, 'Reject Transaction', 'mer@alstrasoft.com', 'Transaction Rejected', 'Your  Trn has been Rejected', 'Your Trn has been Rejected', 'Thank U affiliate');
INSERT INTO `partners_adminmail` VALUES (10, 'Reverse Transaction', '[from]', 'Transaction Reversed', 'Your Reverse request for the Transaction is Reversed.  Please check your accounts.\r\n\r\n<p>Reversed Amount : [commission]</p>\r\n<p>Program is : [program]</p>\r\n<p>Trans type is: [type]	</p>\r\n<p>Trans Date is : [date]</p>', 'Hello merchant [mer_firstname] [mer_lastname],', 'Thank U Merchant [mer_company],');
INSERT INTO `partners_adminmail` VALUES (11, 'Approve AffiliateProgram', '[from]', 'Affiliate Program Approved', '<p>Your Program [program]  has been Approved by the Merchant [mer_firstname] [mer_lastname] </p>\r\n<p>on the date [today]	</p>\r\n<p>Aff Comp is  [aff_company]	</p>\r\n<p>aff email is  [aff_email] </p>\r\n<p>aff passwrd is    [aff_password]</p>\r\n<p>aff url is   [aff_loginlink]	</p>\r\n<p>Mer Comp is  [mer_company]	</p>\r\n<p>Meremail is  [mer_email] </p>\r\n<p>Mer passwrd is    [mer_password]</p>\r\n<p>Mer url is   [mer_loginlink]	</p>', 'Hello [aff_firstname] [aff_lastname],', 'Thank U [aff_firstname]');
INSERT INTO `partners_adminmail` VALUES (12, 'Change Merchant Password', '[from]', 'Merchant Password Changed', '<p>Your Password is changed on [today]</p>\r\n<p>Username is : [mer_email]	</p>\r\n<p>Password is : [mer_password]</p>\r\n<p>Your url is : [mer_loginlink]</p>', 'Hello [mer_firstname] [mer_lastname],', 'Thnak U [mer_firstname]');
INSERT INTO `partners_adminmail` VALUES (13, 'Affiliate Remember Password', '[from]', 'Password Reminder', '<p>Your password is : [aff_password]</p>\r\n<p>Your username is : [aff_email]</p>', 'Hello Affiliate [aff_company]	,', 'Thank you aff [aff_firstname]');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_adminusers`
-- 

CREATE TABLE `partners_adminusers` (
  `adminusers_id` bigint(20) NOT NULL auto_increment,
  `adminusers_login` varchar(100) default NULL,
  `adminusers_email` varchar(100) default NULL,
  `adminusers_password` varchar(100) default NULL,
  `adminusers_ip` varchar(16) default NULL,
  `adminusers_lastLogin` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`adminusers_id`)
)   ;

-- 
-- Dumping data for table `partners_adminusers`
-- 

INSERT INTO `partners_adminusers` VALUES (1, 'admin', 'admin@alstrasoft.com', 'admin', '192.168.0.34', '2009-08-28 17:34:57');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_affiliate`
-- 

CREATE TABLE `partners_affiliate` (
  `affiliate_id` bigint(20) NOT NULL auto_increment,
  `affiliate_firstname` varchar(100) NOT NULL,
  `affiliate_lastname` varchar(100) NOT NULL,
  `affiliate_company` varchar(100) NOT NULL,
  `affiliate_address` text NOT NULL,
  `affiliate_city` varchar(100) NOT NULL,
  `affiliate_country` varchar(100) NOT NULL,
  `affiliate_url` varchar(100) NOT NULL,
  `affiliate_category` varchar(40) NOT NULL,
  `affiliate_status` enum('approved','waiting','suspend') NOT NULL default 'approved',
  `affiliate_date` date NOT NULL default '0000-00-00',
  `affiliate_parentid` bigint(20) default '0',
  `affiliate_fax` varchar(100) default NULL,
  `affiliate_phone` varchar(100) default NULL,
  `affiliate_state` varchar(255) NOT NULL,
  `affiliate_timezone` varchar(255) NOT NULL,
  `affiliate_zipcode` varchar(255) NOT NULL,
  `affiliate_taxId` varchar(255) NOT NULL,
  `affiliate_currency` varchar(100) NOT NULL default 'Dollar',
  `affiliate_group` bigint(20) default '1',
  PRIMARY KEY  (`affiliate_id`)
)  ;

-- 
-- Dumping data for table `partners_affiliate`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_affiliategroup`
-- 

CREATE TABLE `partners_affiliategroup` (
  `affiliategroup_id` bigint(20) NOT NULL auto_increment,
  `affiliategroup_title` varchar(250) NOT NULL,
  `affiliategroup_levels` int(11) NOT NULL,
  PRIMARY KEY  (`affiliategroup_id`)
)  ;

-- 
-- Dumping data for table `partners_affiliategroup`
-- 

INSERT INTO `partners_affiliategroup` VALUES (1, 'First', 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_affiliategroup_commission`
-- 

CREATE TABLE `partners_affiliategroup_commission` (
  `commission_id` bigint(20) NOT NULL auto_increment,
  `commission_groupid` bigint(20) NOT NULL,
  `commission_level` int(11) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `commission_type` enum('flatrate','percentage') NOT NULL default 'flatrate',
  PRIMARY KEY  (`commission_id`)
)   ;

-- 
-- Dumping data for table `partners_affiliategroup_commission`
-- 

INSERT INTO `partners_affiliategroup_commission` VALUES (1, 1, 1, 10.00, 'flatrate');
INSERT INTO `partners_affiliategroup_commission` VALUES (2, 1, 2, 5.00, 'percentage');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_bankinfo`
-- 

CREATE TABLE `partners_bankinfo` (
  `bankinfo_id` bigint(20) NOT NULL auto_increment,
  `bankinfo_affiliateid` bigint(20) NOT NULL default '0',
  `bankinfo_modeofpay` varchar(100) NOT NULL,
  `bankinfo_paypalemail` varchar(255) NOT NULL,
  `bankinfo_stormemail` varchar(255) NOT NULL,
  `bankinfo_payeename` varchar(255) NOT NULL,
  `bankinfo_acno` varchar(255) NOT NULL,
  `bankinfo_checkoutid` varchar(255) NOT NULL,
  `bankinfo_productid` varchar(255) NOT NULL,
  `bankinfo_version` varchar(255) NOT NULL,
  `bankinfo_delimdata` varchar(255) NOT NULL,
  `bankinfo_relayresponse` varchar(255) NOT NULL,
  `bankinfo_login` varchar(255) NOT NULL,
  `bankinfo_trankey` varchar(255) NOT NULL,
  `bankinfo_cctype` varchar(255) NOT NULL,
  `bankinfo_moneyemail` varchar(255) NOT NULL,
  `bankinfo_neteller_email` varchar(255) NOT NULL,
  `bankinfo_neteller_accnt` varchar(255) NOT NULL,
  `bankinfo_checkpayee` varchar(255) NOT NULL,
  `bankinfo_checkcurr` varchar(255) NOT NULL,
  `bankinfo_wire_AccountName` varchar(255) NOT NULL,
  `bankinfo_wire_AccountNumber` varchar(255) NOT NULL,
  `bankinfo_wire_BankName` varchar(255) NOT NULL,
  `bankinfo_wire_BankAddress` varchar(255) NOT NULL,
  `bankinfo_wire_BankCity` varchar(255) NOT NULL,
  `bankinfo_wire_BankState` varchar(255) NOT NULL,
  `bankinfo_wire_BankZip` varchar(255) NOT NULL,
  `bankinfo_wire_BankCountry` varchar(255) NOT NULL,
  `bankinfo_wire_BankAddressNumber` varchar(255) NOT NULL,
  `bankinfo_wire_Nominate` varchar(255) NOT NULL,
  PRIMARY KEY  (`bankinfo_id`)
)  ;

-- 
-- Dumping data for table `partners_bankinfo`
-- 
 -- --------------------------------------------------------

-- 
-- Table structure for table `partners_banner`
-- 

CREATE TABLE `partners_banner` (
  `banner_id` bigint(20) NOT NULL auto_increment,
  `banner_programid` bigint(20) NOT NULL default '0',
  `banner_url` varchar(100) NOT NULL,
  `banner_name` varchar(100) NOT NULL,
  `banner_status` enum('active','inactive') NOT NULL default 'inactive',
  `banner_height` int(11) NOT NULL default '0',
  `banner_width` int(11) NOT NULL default '0',
  PRIMARY KEY  (`banner_id`)
)  ;

-- 
-- Dumping data for table `partners_banner`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_category`
-- 

CREATE TABLE `partners_category` (
  `cat_id` bigint(10) NOT NULL auto_increment,
  `cat_name` varchar(50) NOT NULL default 'zone',
  PRIMARY KEY  (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`)
)   ;

-- 
-- Dumping data for table `partners_category`
-- 

INSERT INTO `partners_category` VALUES (1, 'software');
INSERT INTO `partners_category` VALUES (4, 'Logistics');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_checkout`
-- 

CREATE TABLE `partners_checkout` (
  `checkout_id` bigint(20) NOT NULL auto_increment,
  `checkout_user_id` bigint(20) NOT NULL default '0',
  `checkout_email` varchar(200) NOT NULL,
  `checkout_itemname` varchar(150) NOT NULL,
  `checkout_itemnumber` varchar(150) NOT NULL,
  PRIMARY KEY  (`checkout_id`)
)  ;

-- 
-- Dumping data for table `partners_checkout`
-- 

INSERT INTO `partners_checkout` VALUES (1, 0, 'checkout@alstrasoft.com', '005', '002');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_country`
-- 

CREATE TABLE `partners_country` (
  `country_no` int(20) NOT NULL default '0',
  `country_name` varchar(100) NOT NULL,
  PRIMARY KEY  (`country_no`)
) ;

-- 
-- Dumping data for table `partners_country`
-- 

INSERT INTO `partners_country` VALUES (1, 'United States of America');
INSERT INTO `partners_country` VALUES (2, 'Canada');
INSERT INTO `partners_country` VALUES (3, 'United Kingdom');
INSERT INTO `partners_country` VALUES (4, 'Afghanistan');
INSERT INTO `partners_country` VALUES (5, 'Albania');
INSERT INTO `partners_country` VALUES (6, 'Algeria');
INSERT INTO `partners_country` VALUES (7, 'Amer.Virgin Is.');
INSERT INTO `partners_country` VALUES (8, 'Andorra');
INSERT INTO `partners_country` VALUES (9, 'Angola');
INSERT INTO `partners_country` VALUES (10, 'Anguilla');
INSERT INTO `partners_country` VALUES (11, 'Antarctica');
INSERT INTO `partners_country` VALUES (12, 'Antigua/Barbads');
INSERT INTO `partners_country` VALUES (13, 'Argentina');
INSERT INTO `partners_country` VALUES (14, 'Armenia');
INSERT INTO `partners_country` VALUES (15, 'Aruba');
INSERT INTO `partners_country` VALUES (16, 'Australia');
INSERT INTO `partners_country` VALUES (17, 'Austria');
INSERT INTO `partners_country` VALUES (18, 'Azerbaijan');
INSERT INTO `partners_country` VALUES (19, 'Bahamas');
INSERT INTO `partners_country` VALUES (20, 'Bahrain');
INSERT INTO `partners_country` VALUES (21, 'Bangladesh');
INSERT INTO `partners_country` VALUES (22, 'Barbados');
INSERT INTO `partners_country` VALUES (23, 'Belarus');
INSERT INTO `partners_country` VALUES (24, 'Belgium');
INSERT INTO `partners_country` VALUES (25, 'Belize');
INSERT INTO `partners_country` VALUES (26, 'Benin');
INSERT INTO `partners_country` VALUES (27, 'Bermuda');
INSERT INTO `partners_country` VALUES (28, 'Bhutan');
INSERT INTO `partners_country` VALUES (29, 'Bolivia');
INSERT INTO `partners_country` VALUES (30, 'Bosnia-Herz.');
INSERT INTO `partners_country` VALUES (31, 'Botswana');
INSERT INTO `partners_country` VALUES (32, 'Bouvet Island');
INSERT INTO `partners_country` VALUES (33, 'Brazil');
INSERT INTO `partners_country` VALUES (34, 'Brit.Ind.Oc.Ter');
INSERT INTO `partners_country` VALUES (35, 'Brit.Virgin Is.');
INSERT INTO `partners_country` VALUES (36, 'Brunei');
INSERT INTO `partners_country` VALUES (37, 'Bulgaria');
INSERT INTO `partners_country` VALUES (38, 'Burkina-Faso');
INSERT INTO `partners_country` VALUES (39, 'Burundi');
INSERT INTO `partners_country` VALUES (40, 'Cambodia');
INSERT INTO `partners_country` VALUES (41, 'Cameroon');
INSERT INTO `partners_country` VALUES (42, 'Cape Verde');
INSERT INTO `partners_country` VALUES (43, 'Cayman Islands');
INSERT INTO `partners_country` VALUES (44, 'Central Afr.Rep');
INSERT INTO `partners_country` VALUES (45, 'Chad');
INSERT INTO `partners_country` VALUES (46, 'Channel Islands');
INSERT INTO `partners_country` VALUES (47, 'Chile');
INSERT INTO `partners_country` VALUES (48, 'China');
INSERT INTO `partners_country` VALUES (49, 'Christmas Islnd');
INSERT INTO `partners_country` VALUES (50, 'Coconut Islands');
INSERT INTO `partners_country` VALUES (51, 'Colombia');
INSERT INTO `partners_country` VALUES (52, 'Comoro');
INSERT INTO `partners_country` VALUES (53, 'Congo');
INSERT INTO `partners_country` VALUES (54, 'Cook Islands');
INSERT INTO `partners_country` VALUES (55, 'Costa Rica');
INSERT INTO `partners_country` VALUES (56, 'Croatia');
INSERT INTO `partners_country` VALUES (57, 'Cuba');
INSERT INTO `partners_country` VALUES (58, 'Cyprus');
INSERT INTO `partners_country` VALUES (59, 'Czech Republic');
INSERT INTO `partners_country` VALUES (60, 'Denmark');
INSERT INTO `partners_country` VALUES (61, 'Djibouti');
INSERT INTO `partners_country` VALUES (62, 'Dominica');
INSERT INTO `partners_country` VALUES (63, 'Dominican Rep.');
INSERT INTO `partners_country` VALUES (64, 'Ecuador');
INSERT INTO `partners_country` VALUES (65, 'Egypt');
INSERT INTO `partners_country` VALUES (66, 'El Salvador');
INSERT INTO `partners_country` VALUES (67, 'Equatorial Guin');
INSERT INTO `partners_country` VALUES (68, 'Eritrea');
INSERT INTO `partners_country` VALUES (69, 'Estonia');
INSERT INTO `partners_country` VALUES (70, 'Ethiopia');
INSERT INTO `partners_country` VALUES (71, 'Faeroe Islands');
INSERT INTO `partners_country` VALUES (72, 'Falkland Islnds');
INSERT INTO `partners_country` VALUES (73, 'Fiji');
INSERT INTO `partners_country` VALUES (74, 'Finland');
INSERT INTO `partners_country` VALUES (75, 'France');
INSERT INTO `partners_country` VALUES (76, 'Frenc.Polynesia');
INSERT INTO `partners_country` VALUES (77, 'French Guinea');
INSERT INTO `partners_country` VALUES (78, 'Gabon');
INSERT INTO `partners_country` VALUES (79, 'Gambia');
INSERT INTO `partners_country` VALUES (80, 'Georgia');
INSERT INTO `partners_country` VALUES (81, 'Germany');
INSERT INTO `partners_country` VALUES (82, 'Ghana');
INSERT INTO `partners_country` VALUES (83, 'Gibraltar');
INSERT INTO `partners_country` VALUES (84, 'Greece');
INSERT INTO `partners_country` VALUES (85, 'Greenland');
INSERT INTO `partners_country` VALUES (86, 'Grenada');
INSERT INTO `partners_country` VALUES (87, 'Guadeloupe');
INSERT INTO `partners_country` VALUES (88, 'Guam');
INSERT INTO `partners_country` VALUES (89, 'Guatemala');
INSERT INTO `partners_country` VALUES (90, 'Guinea');
INSERT INTO `partners_country` VALUES (91, 'Guinea-Bissau');
INSERT INTO `partners_country` VALUES (92, 'Guyana');
INSERT INTO `partners_country` VALUES (93, 'Haiti');
INSERT INTO `partners_country` VALUES (94, 'Heard/McDon.Isl');
INSERT INTO `partners_country` VALUES (95, 'Honduras');
INSERT INTO `partners_country` VALUES (96, 'Hong Kong');
INSERT INTO `partners_country` VALUES (97, 'Hungary');
INSERT INTO `partners_country` VALUES (98, 'Iceland');
INSERT INTO `partners_country` VALUES (99, 'India');
INSERT INTO `partners_country` VALUES (100, 'Indonesia');
INSERT INTO `partners_country` VALUES (101, 'Iran');
INSERT INTO `partners_country` VALUES (102, 'Iraq');
INSERT INTO `partners_country` VALUES (103, 'Ireland');
INSERT INTO `partners_country` VALUES (104, 'Israel');
INSERT INTO `partners_country` VALUES (105, 'Italy');
INSERT INTO `partners_country` VALUES (106, 'Ivory Coast');
INSERT INTO `partners_country` VALUES (107, 'Jamaica');
INSERT INTO `partners_country` VALUES (108, 'Japan');
INSERT INTO `partners_country` VALUES (109, 'Jordan');
INSERT INTO `partners_country` VALUES (110, 'Kazakhstan');
INSERT INTO `partners_country` VALUES (111, 'Kenya');
INSERT INTO `partners_country` VALUES (112, 'Kirghistan');
INSERT INTO `partners_country` VALUES (113, 'Kiribati');
INSERT INTO `partners_country` VALUES (114, 'Kuwait');
INSERT INTO `partners_country` VALUES (115, 'Laos');
INSERT INTO `partners_country` VALUES (116, 'Latvia');
INSERT INTO `partners_country` VALUES (117, 'Lebanon');
INSERT INTO `partners_country` VALUES (118, 'Lesotho');
INSERT INTO `partners_country` VALUES (119, 'Liberia');
INSERT INTO `partners_country` VALUES (120, 'Libya');
INSERT INTO `partners_country` VALUES (121, 'Liechtenstein');
INSERT INTO `partners_country` VALUES (122, 'Lithuania');
INSERT INTO `partners_country` VALUES (123, 'Luxembourg');
INSERT INTO `partners_country` VALUES (124, 'Macau');
INSERT INTO `partners_country` VALUES (125, 'Macedonia');
INSERT INTO `partners_country` VALUES (126, 'Madagascar');
INSERT INTO `partners_country` VALUES (127, 'Malawi');
INSERT INTO `partners_country` VALUES (128, 'Malaysia');
INSERT INTO `partners_country` VALUES (129, 'Maldives');
INSERT INTO `partners_country` VALUES (130, 'Mali');
INSERT INTO `partners_country` VALUES (131, 'Malta');
INSERT INTO `partners_country` VALUES (132, 'Marshall Islnds');
INSERT INTO `partners_country` VALUES (133, 'Martinique');
INSERT INTO `partners_country` VALUES (134, 'Mauritania');
INSERT INTO `partners_country` VALUES (135, 'Mauritius');
INSERT INTO `partners_country` VALUES (136, 'Mayotte');
INSERT INTO `partners_country` VALUES (137, 'Mexico');
INSERT INTO `partners_country` VALUES (138, 'Micronesia');
INSERT INTO `partners_country` VALUES (139, 'Minor Outl.Isl.');
INSERT INTO `partners_country` VALUES (140, 'Moldavia');
INSERT INTO `partners_country` VALUES (141, 'Monaco');
INSERT INTO `partners_country` VALUES (142, 'Mongolia');
INSERT INTO `partners_country` VALUES (143, 'Montserrat');
INSERT INTO `partners_country` VALUES (144, 'Morocco');
INSERT INTO `partners_country` VALUES (145, 'Mozambique');
INSERT INTO `partners_country` VALUES (146, 'Myanmar');
INSERT INTO `partners_country` VALUES (147, 'N.Mariana Islnd');
INSERT INTO `partners_country` VALUES (148, 'Namibia');
INSERT INTO `partners_country` VALUES (149, 'Nauru');
INSERT INTO `partners_country` VALUES (150, 'Nepal');
INSERT INTO `partners_country` VALUES (151, 'Netherland Antilles');
INSERT INTO `partners_country` VALUES (152, 'Netherlands');
INSERT INTO `partners_country` VALUES (153, 'New Caledonia');
INSERT INTO `partners_country` VALUES (154, 'New Zealand');
INSERT INTO `partners_country` VALUES (155, 'Nicaragua');
INSERT INTO `partners_country` VALUES (156, 'Niger');
INSERT INTO `partners_country` VALUES (157, 'Nigeria');
INSERT INTO `partners_country` VALUES (158, 'Niue Islands');
INSERT INTO `partners_country` VALUES (159, 'Norfolk Island');
INSERT INTO `partners_country` VALUES (160, 'North Korea');
INSERT INTO `partners_country` VALUES (161, 'Norway');
INSERT INTO `partners_country` VALUES (162, 'Oman');
INSERT INTO `partners_country` VALUES (163, 'Pakistan');
INSERT INTO `partners_country` VALUES (164, 'Palau');
INSERT INTO `partners_country` VALUES (165, 'Panama');
INSERT INTO `partners_country` VALUES (166, 'Papua New Guinea');
INSERT INTO `partners_country` VALUES (167, 'Paraguay');
INSERT INTO `partners_country` VALUES (168, 'Peru');
INSERT INTO `partners_country` VALUES (169, 'Philippines');
INSERT INTO `partners_country` VALUES (170, 'Pitcairn Islnds');
INSERT INTO `partners_country` VALUES (171, 'Poland');
INSERT INTO `partners_country` VALUES (172, 'Portugal');
INSERT INTO `partners_country` VALUES (173, 'Puerto Rico');
INSERT INTO `partners_country` VALUES (174, 'Qatar');
INSERT INTO `partners_country` VALUES (175, 'Reunion');
INSERT INTO `partners_country` VALUES (176, 'Romania');
INSERT INTO `partners_country` VALUES (177, 'Russian Fed.');
INSERT INTO `partners_country` VALUES (178, 'Rwanda');
INSERT INTO `partners_country` VALUES (179, 'S.Tome,Principe');
INSERT INTO `partners_country` VALUES (180, 'Samoa,American');
INSERT INTO `partners_country` VALUES (181, 'San Marino');
INSERT INTO `partners_country` VALUES (182, 'Saudi Arabia');
INSERT INTO `partners_country` VALUES (183, 'Senegal');
INSERT INTO `partners_country` VALUES (184, 'Seychelles');
INSERT INTO `partners_country` VALUES (185, 'Sierra Leone');
INSERT INTO `partners_country` VALUES (186, 'Singapore');
INSERT INTO `partners_country` VALUES (187, 'Slovakia');
INSERT INTO `partners_country` VALUES (188, 'Slovenia');
INSERT INTO `partners_country` VALUES (189, 'Solomon Islands');
INSERT INTO `partners_country` VALUES (190, 'Somalia');
INSERT INTO `partners_country` VALUES (191, 'South Africa');
INSERT INTO `partners_country` VALUES (192, 'South Korea');
INSERT INTO `partners_country` VALUES (193, 'Spain');
INSERT INTO `partners_country` VALUES (194, 'Sri Lanka');
INSERT INTO `partners_country` VALUES (195, 'St. Helena');
INSERT INTO `partners_country` VALUES (196, 'St. Lucia');
INSERT INTO `partners_country` VALUES (197, 'St. Vincent');
INSERT INTO `partners_country` VALUES (198, 'St.Kitts, Nevis');
INSERT INTO `partners_country` VALUES (199, 'St.Pier,Miquel.');
INSERT INTO `partners_country` VALUES (200, 'Sth Sandwich Is');
INSERT INTO `partners_country` VALUES (201, 'Sudan');
INSERT INTO `partners_country` VALUES (202, 'Suriname');
INSERT INTO `partners_country` VALUES (203, 'Svalbard');
INSERT INTO `partners_country` VALUES (204, 'Swaziland');
INSERT INTO `partners_country` VALUES (205, 'Sweden');
INSERT INTO `partners_country` VALUES (206, 'Switzerland');
INSERT INTO `partners_country` VALUES (207, 'Syria');
INSERT INTO `partners_country` VALUES (208, 'Tadzhikistan');
INSERT INTO `partners_country` VALUES (209, 'Taiwan');
INSERT INTO `partners_country` VALUES (210, 'Tanzania');
INSERT INTO `partners_country` VALUES (211, 'Thailand');
INSERT INTO `partners_country` VALUES (212, 'Togo');
INSERT INTO `partners_country` VALUES (213, 'Tokelau Islands');
INSERT INTO `partners_country` VALUES (214, 'Tonga');
INSERT INTO `partners_country` VALUES (215, 'Trinidad,Tobago');
INSERT INTO `partners_country` VALUES (216, 'Tunisia');
INSERT INTO `partners_country` VALUES (217, 'Turkey');
INSERT INTO `partners_country` VALUES (218, 'Turkmenistan');
INSERT INTO `partners_country` VALUES (219, 'Turks &amp;Caicos');
INSERT INTO `partners_country` VALUES (220, 'Tuvalu');
INSERT INTO `partners_country` VALUES (221, 'Uganda');
INSERT INTO `partners_country` VALUES (222, 'Ukraine');
INSERT INTO `partners_country` VALUES (223, 'Uruguay');
INSERT INTO `partners_country` VALUES (224, 'Utd.Arab.Emir.');
INSERT INTO `partners_country` VALUES (225, 'Uzbekistan');
INSERT INTO `partners_country` VALUES (226, 'Vanuatu');
INSERT INTO `partners_country` VALUES (227, 'Vatican City');
INSERT INTO `partners_country` VALUES (228, 'Venezuela');
INSERT INTO `partners_country` VALUES (229, 'Vietnam');
INSERT INTO `partners_country` VALUES (230, 'Wallis,Futuna');
INSERT INTO `partners_country` VALUES (231, 'West Sahara');
INSERT INTO `partners_country` VALUES (232, 'Western Samoa');
INSERT INTO `partners_country` VALUES (233, 'Yemen');
INSERT INTO `partners_country` VALUES (234, 'Yugoslavia');
INSERT INTO `partners_country` VALUES (235, 'Zaire');
INSERT INTO `partners_country` VALUES (236, 'Zambia');
INSERT INTO `partners_country` VALUES (237, 'Zimbabwe');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_countryFlag`
-- 

CREATE TABLE `partners_countryFlag` (
  `ip_from` bigint(11) default NULL,
  `ip_to` bigint(11) default NULL,
  `country_code2` char(2) default NULL,
  `country_code3` char(3) default NULL,
  `country_name` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `partners_countryFlag`
-- 

INSERT INTO `partners_countryFlag` VALUES (33996344, 33996351, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (94585424, 94585439, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (100663296, 121195295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (121195296, 121195327, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (121195328, 134217727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (134217728, 152305663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (152305664, 152338431, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (152338432, 167772159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (184549376, 205500987, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (205500988, 205500991, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (205500992, 205502667, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (205502668, 214858655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (214858656, 214858671, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (214858672, 218103807, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (218103808, 226293055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (226293056, 226293119, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (226293120, 234881023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (251658240, 260976639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (260976640, 260980735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (260980736, 264482815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (264482816, 264486911, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (264486912, 264495103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (264495104, 264503295, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (264503296, 264617983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (264617984, 264667135, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (264667136, 264699903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (264699904, 264716287, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (264716288, 264798207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (264798208, 264802303, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (264802304, 264994815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (264994816, 265023487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (265023488, 265027583, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (265027584, 265052159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (265052160, 265277439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (265277440, 265289727, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (265289728, 268435455, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (268435456, 289011535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (289011536, 289011543, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (289011544, 301989887, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (301989888, 323243895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (323243896, 323243903, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (323243904, 332132119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (332132120, 332132127, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (332132128, 335544319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (335544320, 355993887, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (355993888, 355993895, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (355993896, 368674047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (368674048, 368674303, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (368674304, 369098751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (369098752, 385875967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (386665696, 386665727, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (386666240, 386666367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (393849728, 393849735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (404226048, 404750335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (404815872, 404877311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (404881408, 404979711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (405274624, 405295103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (405340160, 405364735, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (405405696, 405536767, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (405536768, 406351871, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (406355968, 406384639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (406388736, 406454271, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (406454272, 406790143, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (406847488, 407400447, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (407437312, 407564287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (407633920, 408420351, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (408420352, 408494079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (408551424, 408977407, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409010176, 409178111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409206784, 409468927, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (409468928, 409509887, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409534464, 409550847, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409567232, 409587711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409600000, 409636863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409665536, 409731071, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (409731072, 409825279, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (409993216, 410058751, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (410124288, 410189823, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (410255360, 410468351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (410517504, 410599423, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (410648576, 410669055, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (410714112, 410804223, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (410845184, 410877951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (410910720, 411025407, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (411041792, 411164671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (411172864, 411303935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (411303936, 411369471, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (411566080, 411639807, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (411697152, 411717631, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (411762688, 411770879, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (411828224, 411852799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (411893760, 411959295, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (411959296, 412033023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412090368, 412106751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412155904, 412221439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412221440, 412229631, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (412286976, 412377087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412418048, 412426239, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412483584, 412549119, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (412549120, 412614655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412614656, 412647423, 'CL', 'CHL', 'CHILE');
INSERT INTO `partners_countryFlag` VALUES (412680192, 412696575, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (412696576, 412700671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412704768, 412708863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412712960, 412827647, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (412876800, 413007871, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (413007872, 413847551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (413859840, 413900799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (413925376, 413954047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (413990912, 414031871, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (414056448, 414187519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (414711808, 415236095, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (415236096, 415301631, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (415301632, 415703039, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (415711232, 415760383, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (415760384, 416022527, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (416022528, 416059391, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416088064, 416161791, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416169984, 416186367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416186368, 416202751, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (416219136, 416235519, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (416251904, 416546815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416546816, 416559103, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (416612352, 416628735, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416645120, 416653311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416677888, 416743423, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (416743424, 416759807, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (416808960, 417202175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417202176, 417267711, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (417267712, 417288191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417300480, 417316863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417333248, 417341439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417366016, 417390591, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (417398784, 417406975, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417431552, 417456127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417464320, 417529855, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (417529856, 417538047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417595392, 417619967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417660928, 417742847, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417775616, 417783807, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (417792000, 417800191, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (417800192, 417804287, 'BS', 'BHS', 'BAHAMAS');
INSERT INTO `partners_countryFlag` VALUES (417824768, 417841151, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417857536, 417923071, 'AR', 'ARG', 'ARGENTINA');
INSERT INTO `partners_countryFlag` VALUES (417923072, 417947647, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417947648, 417955839, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (417955840, 417968127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (417988608, 418062335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418086912, 418103295, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (418119680, 418127871, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418136064, 418267135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418283520, 418287615, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418316288, 418324479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418332672, 418643967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418643968, 418664447, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (418676736, 418693119, 'BS', 'BHS', 'BAHAMAS');
INSERT INTO `partners_countryFlag` VALUES (418693120, 418705407, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (418709504, 418729983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418775040, 418824191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (418840576, 418906111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (419430400, 436207615, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (436207616, 452984831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (469762048, 520093695, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (536870912, 553648127, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (553648128, 603979775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (637534208, 654311423, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (671088640, 687865855, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (721420288, 738197503, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (738197504, 771751935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (788529152, 805306367, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (805306368, 822083583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (854253646, 854253679, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (855638016, 872415231, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (872415232, 889192447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (889192448, 905969663, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (905969664, 956301311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (956301312, 973078527, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1023410176, 1023672319, 'IN', 'IND', 'INDIA');
INSERT INTO `partners_countryFlag` VALUES (1023672320, 1023688703, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1023688704, 1023692799, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1023705088, 1023717375, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1023737856, 1023770623, 'ID', 'IDN', 'INDONESIA');
INSERT INTO `partners_countryFlag` VALUES (1023787008, 1023791103, 'ID', 'IDN', 'INDONESIA');
INSERT INTO `partners_countryFlag` VALUES (1023803392, 1023852543, 'MY', 'MYS', 'MALAYSIA');
INSERT INTO `partners_countryFlag` VALUES (1023868928, 1023885311, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1023934464, 1023942655, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1023959040, 1023967231, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1023967232, 1023975423, 'IN', 'IND', 'INDIA');
INSERT INTO `partners_countryFlag` VALUES (1023983616, 1023999999, 'SG', 'SGP', 'SINGAPORE');
INSERT INTO `partners_countryFlag` VALUES (1024000000, 1024032767, 'PH', 'PHL', 'PHILIPPINES');
INSERT INTO `partners_countryFlag` VALUES (1024032768, 1024065535, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1024065536, 1024131071, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1024131072, 1024163839, 'IN', 'IND', 'INDIA');
INSERT INTO `partners_countryFlag` VALUES (1024188416, 1024196607, 'TH', 'THA', 'THAILAND');
INSERT INTO `partners_countryFlag` VALUES (1024262144, 1024327679, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1024344064, 1024352255, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1024376832, 1024393215, 'PH', 'PHL', 'PHILIPPINES');
INSERT INTO `partners_countryFlag` VALUES (1024393216, 1024458751, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1024458752, 1024491519, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1024491520, 1024557055, 'IN', 'IND', 'INDIA');
INSERT INTO `partners_countryFlag` VALUES (1024589824, 1024655359, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1024655360, 1024671743, 'TH', 'THA', 'THAILAND');
INSERT INTO `partners_countryFlag` VALUES (1024688128, 1024720895, 'TH', 'THA', 'THAILAND');
INSERT INTO `partners_countryFlag` VALUES (1024720896, 1024786431, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1024786432, 1024933887, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1024983040, 1025216511, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1025245184, 1025261567, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1025310720, 1025343487, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1025376256, 1025507327, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1025507328, 1026293759, 'KR', 'KOR', 'KOREA REPUBLIC OF');
INSERT INTO `partners_countryFlag` VALUES (1026555904, 1027080191, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1027080192, 1027866623, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1027866624, 1027997695, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1027997696, 1028128767, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1028128768, 1029046271, 'KR', 'KOR', 'KOREA REPUBLIC OF');
INSERT INTO `partners_countryFlag` VALUES (1029046272, 1029111807, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1029177344, 1029242879, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1029439488, 1029570559, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1029570560, 1029636095, 'ID', 'IDN', 'INDONESIA');
INSERT INTO `partners_countryFlag` VALUES (1029636096, 1029668863, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1029693440, 1029697535, 'IN', 'IND', 'INDIA');
INSERT INTO `partners_countryFlag` VALUES (1029701632, 1030750207, 'KR', 'KOR', 'KOREA REPUBLIC OF');
INSERT INTO `partners_countryFlag` VALUES (1030750208, 1031798783, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1031798784, 1033982787, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1033982788, 1033982788, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1033982789, 1034001207, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1034001208, 1034001215, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1034001216, 1034420223, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1034420224, 1035993087, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1035993088, 1037565951, 'JP', 'JPN', 'JAPAN');
INSERT INTO `partners_countryFlag` VALUES (1037565952, 1038614527, 'TW', 'TWN', 'TAIWAN');
INSERT INTO `partners_countryFlag` VALUES (1038614528, 1039007743, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1039007744, 1039073279, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1039138816, 1039400959, 'CN', 'CHN', 'CHINA');
INSERT INTO `partners_countryFlag` VALUES (1039663104, 1040187391, 'KR', 'KOR', 'KOREA REPUBLIC OF');
INSERT INTO `partners_countryFlag` VALUES (1040187392, 1040252927, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1040252928, 1040318463, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1040318464, 1040383999, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1040384000, 1040392191, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1040392192, 1040394495, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040394496, 1040400383, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1040400384, 1040416767, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040416768, 1040424959, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1040424960, 1040433151, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1040433152, 1040449535, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040449536, 1040457727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040457728, 1040465919, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1040465920, 1040466943, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040466944, 1040466959, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1040466960, 1040466975, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040466976, 1040467071, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467072, 1040467087, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040467088, 1040467103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467104, 1040467135, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040467136, 1040467183, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467184, 1040467327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467328, 1040467711, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467712, 1040467727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040467728, 1040467743, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040467744, 1040467775, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467776, 1040467871, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040467872, 1040467935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467936, 1040467951, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040467952, 1040467967, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040467968, 1040468255, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040468256, 1040468287, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040468288, 1040468351, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040468352, 1040468383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040468384, 1040468479, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040468480, 1040468543, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040468544, 1040468735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040468736, 1040468991, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040468992, 1040469007, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040469008, 1040469023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040469024, 1040469927, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040469928, 1040469967, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040469968, 1040469999, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040470000, 1040470007, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1040470008, 1040470015, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040470016, 1040470463, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040470464, 1040470783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040470784, 1040471039, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040471040, 1040471295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040471296, 1040471423, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040471424, 1040471487, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040471488, 1040471551, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040471552, 1040471743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040471744, 1040471775, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040471776, 1040471807, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040471808, 1040473343, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040473344, 1040473599, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040473600, 1040474111, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040474112, 1040482303, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1040482304, 1040515071, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1040515072, 1040547839, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1040547840, 1040580607, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1040580608, 1040646143, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040646144, 1040711679, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040711680, 1040719871, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1040719872, 1040728063, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040728064, 1040736255, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1040736256, 1040744447, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040744448, 1040777215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1040777216, 1040842751, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1040842752, 1040973823, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1040973824, 1040982015, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1040982016, 1040990207, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1040990208, 1040998399, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1040998400, 1041006591, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1041006592, 1041039359, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1041039360, 1041051647, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041051648, 1041051839, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1041051840, 1041052159, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041052160, 1041052175, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1041052176, 1041053695, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041053696, 1041055231, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041055232, 1041056511, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041056512, 1041057279, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041057280, 1041057535, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041057536, 1041057791, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041057792, 1041058559, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041058560, 1041060863, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041060864, 1041072127, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041072128, 1041080319, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041080320, 1041088511, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1041088512, 1041096703, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1041096704, 1041235967, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1041235968, 1041244159, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1041244160, 1041252351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1041252352, 1041252863, 'TJ', 'TJK', 'TAJIKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1041252864, 1041268735, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1041268736, 1041301503, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1041301504, 1041301535, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041301536, 1041301551, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041301552, 1041301567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041301568, 1041301599, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041301600, 1041301615, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041301616, 1041301887, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041301888, 1041301919, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041301920, 1041301951, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041301952, 1041301983, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041301984, 1041302015, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041302016, 1041302271, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041302272, 1041302287, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041302288, 1041302303, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041302304, 1041302319, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041302320, 1041302527, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041302528, 1041302783, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041302784, 1041305855, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041305856, 1041305871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041305872, 1041305887, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041305888, 1041305983, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041305984, 1041306031, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306032, 1041306079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041306080, 1041306111, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306112, 1041306399, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306400, 1041306575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041306576, 1041306591, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306592, 1041306607, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306608, 1041306671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041306672, 1041306751, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306752, 1041306815, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041306816, 1041306863, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041306864, 1041306879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041306880, 1041307135, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041307136, 1041307519, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041307520, 1041307551, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041307552, 1041307599, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041307600, 1041307775, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041307776, 1041307839, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041307840, 1041307855, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041307856, 1041307871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041307872, 1041308031, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041308032, 1041308063, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041308064, 1041308287, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041308288, 1041308303, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041308304, 1041308351, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041308352, 1041308367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041308368, 1041308415, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041308416, 1041308671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041308672, 1041308927, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041308928, 1041309055, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041309056, 1041309087, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041309088, 1041309183, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041309184, 1041309967, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041309968, 1041309983, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041309984, 1041310031, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041310032, 1041310047, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041310048, 1041310079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041310080, 1041310511, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041310512, 1041310527, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041310528, 1041310591, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041310592, 1041310623, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041310624, 1041310687, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041310688, 1041310719, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041310720, 1041334271, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041334272, 1041334527, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041334528, 1041334719, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041334720, 1041334751, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041334752, 1041334767, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041334768, 1041334783, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041334784, 1041335039, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041335040, 1041335295, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041335296, 1041335391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041335392, 1041335407, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041335408, 1041335519, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041335520, 1041335807, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041335808, 1041335839, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041335840, 1041335871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041335872, 1041335887, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041335888, 1041335903, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041335904, 1041336031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041336032, 1041336063, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041336064, 1041336127, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041336128, 1041336143, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041336144, 1041336159, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041336160, 1041336175, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041336176, 1041336191, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041336192, 1041336207, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041336208, 1041336223, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041336224, 1041336255, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041336256, 1041336287, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041336288, 1041336319, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041336320, 1041337343, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041337344, 1041337807, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041337808, 1041337855, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041337856, 1041337887, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041337888, 1041337903, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041337904, 1041337919, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041337920, 1041337935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041337936, 1041337999, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338000, 1041338015, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041338016, 1041338031, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338032, 1041338111, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041338112, 1041338335, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338336, 1041338623, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338624, 1041338671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041338672, 1041338687, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338688, 1041338703, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041338704, 1041338751, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338752, 1041338815, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041338816, 1041338831, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338832, 1041338863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041338864, 1041338879, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041338880, 1041339071, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339072, 1041339087, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339088, 1041339119, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339120, 1041339135, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339136, 1041339151, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339152, 1041339167, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339168, 1041339263, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339264, 1041339343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339344, 1041339359, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339360, 1041339391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339392, 1041339407, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339408, 1041339487, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339488, 1041339519, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339520, 1041339535, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339536, 1041339551, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339552, 1041339647, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339648, 1041339663, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339664, 1041339711, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339712, 1041339743, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339744, 1041339759, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339760, 1041339807, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339808, 1041339823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339824, 1041339839, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339840, 1041339871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339872, 1041339903, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339904, 1041339967, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041339968, 1041339983, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041339984, 1041339999, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340000, 1041340031, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340032, 1041340127, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340128, 1041340159, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340160, 1041340191, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340192, 1041340239, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340240, 1041340255, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340256, 1041340287, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340288, 1041340303, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340304, 1041340335, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340336, 1041340367, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340368, 1041340383, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340384, 1041340415, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340416, 1041340607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340608, 1041340639, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340640, 1041340863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340864, 1041340895, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340896, 1041340959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041340960, 1041340991, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041340992, 1041341023, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341024, 1041341087, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341088, 1041341103, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341104, 1041341151, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341152, 1041341183, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341184, 1041341199, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341200, 1041341215, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341216, 1041341231, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341232, 1041341343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341344, 1041341391, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341392, 1041341439, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341440, 1041341759, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341760, 1041341791, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341792, 1041341807, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341808, 1041341823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341824, 1041341855, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341856, 1041341903, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341904, 1041341919, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041341920, 1041341935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041341936, 1041342031, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342032, 1041342047, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342048, 1041342143, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041342144, 1041342175, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342176, 1041342335, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041342336, 1041342367, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342368, 1041342511, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041342512, 1041342527, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342528, 1041342543, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342544, 1041342575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041342576, 1041342591, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342592, 1041342607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041342608, 1041342623, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342624, 1041342655, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342656, 1041342671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041342672, 1041342975, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041342976, 1041343023, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041343024, 1041343039, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041343040, 1041343199, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041343200, 1041343215, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041343216, 1041343231, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041343232, 1041343743, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041343744, 1041343999, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344000, 1041344079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344080, 1041344095, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344096, 1041344159, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344160, 1041344189, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344190, 1041344511, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344512, 1041344527, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344528, 1041344639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344640, 1041344671, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344672, 1041344783, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344784, 1041344799, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344800, 1041344879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344880, 1041344895, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344896, 1041344959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041344960, 1041344991, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041344992, 1041345007, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041345008, 1041345023, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041345024, 1041345279, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041345280, 1041345535, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041345536, 1041345695, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041345696, 1041345727, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041345728, 1041345767, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041345768, 1041345775, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041345776, 1041346199, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041346200, 1041346207, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041346208, 1041346215, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041346216, 1041346223, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041346224, 1041346247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041346248, 1041346255, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041346256, 1041346263, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041346264, 1041346303, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041346304, 1041347391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041347392, 1041358047, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041358048, 1041358079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041358080, 1041362943, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041362944, 1041362959, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041362960, 1041362975, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041362976, 1041363007, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041363008, 1041363023, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041363024, 1041363055, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041363056, 1041363143, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041363144, 1041363167, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041363168, 1041363455, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041363456, 1041363711, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041363712, 1041363775, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041363776, 1041363839, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041363840, 1041363903, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041363904, 1041363967, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041363968, 1041364479, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041364480, 1041364495, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041364496, 1041364575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041364576, 1041364583, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041364584, 1041364591, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041364592, 1041364607, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041364608, 1041364735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041364736, 1041364991, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041364992, 1041365023, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041365024, 1041365039, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041365040, 1041365055, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041365056, 1041365079, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041365080, 1041365183, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041365184, 1041365199, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041365200, 1041365247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041365248, 1041365503, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041365504, 1041365743, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041365744, 1041366015, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041366016, 1041367039, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1041367040, 1041498111, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041498112, 1041563647, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1041563648, 1041596415, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1041596416, 1041629183, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1041629184, 1041694719, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1041694720, 1041760255, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1041760256, 1041768447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1041768448, 1041776639, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1041776640, 1041784831, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1041784832, 1041793023, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1041793024, 1041825791, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041825792, 1041842175, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1041842176, 1041891327, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1041891328, 1042022399, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042022400, 1042087935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042087936, 1042120703, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1042120704, 1042121727, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042121728, 1042121983, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042121984, 1042122135, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122136, 1042122175, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122176, 1042122203, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122204, 1042122207, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122208, 1042122495, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122496, 1042122751, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122752, 1042122775, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122776, 1042122783, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122784, 1042122847, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122848, 1042122851, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122852, 1042122859, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122860, 1042122863, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122864, 1042122903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122904, 1042122911, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122912, 1042122943, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042122944, 1042122947, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042122948, 1042123007, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042123008, 1042123135, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042123136, 1042123167, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042123168, 1042123199, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042123200, 1042123263, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042123264, 1042123327, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042123328, 1042123775, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042123776, 1042129151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042129152, 1042129407, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042129408, 1042129411, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042129412, 1042129415, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042129416, 1042129431, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042129432, 1042129439, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042129440, 1042129471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042129472, 1042129919, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042129920, 1042129927, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042129928, 1042129951, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042129952, 1042129983, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042129984, 1042130175, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042130176, 1042130191, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042130192, 1042130431, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042130432, 1042130943, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042130944, 1042151455, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042151456, 1042151551, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042151552, 1042151647, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042151648, 1042152831, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042152832, 1042152879, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042152880, 1042153471, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042153472, 1042219007, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042219008, 1042284543, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042284544, 1042292735, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1042292736, 1042292991, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042292992, 1042293247, 'YU', 'YUG', 'YUGOSLAVIA');
INSERT INTO `partners_countryFlag` VALUES (1042293248, 1042293503, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042293504, 1042293759, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042293760, 1042296575, 'GE', 'GEO', 'GEORGIA');
INSERT INTO `partners_countryFlag` VALUES (1042296576, 1042296831, 'BY', 'BLR', 'BELARUS');
INSERT INTO `partners_countryFlag` VALUES (1042296832, 1042297087, 'AZ', 'AZE', 'AZERBAIJAN');
INSERT INTO `partners_countryFlag` VALUES (1042297088, 1042297215, 'KW', 'KWT', 'KUWAIT');
INSERT INTO `partners_countryFlag` VALUES (1042297216, 1042297343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042297344, 1042297599, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042297600, 1042297855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042297856, 1042298111, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1042298112, 1042298239, 'YU', 'YUG', 'YUGOSLAVIA');
INSERT INTO `partners_countryFlag` VALUES (1042298240, 1042298367, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1042298368, 1042298623, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042298624, 1042298879, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1042298880, 1042299135, 'AZ', 'AZE', 'AZERBAIJAN');
INSERT INTO `partners_countryFlag` VALUES (1042299136, 1042299903, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042299904, 1042300159, 'AZ', 'AZE', 'AZERBAIJAN');
INSERT INTO `partners_countryFlag` VALUES (1042300160, 1042300175, 'BY', 'BLR', 'BELARUS');
INSERT INTO `partners_countryFlag` VALUES (1042300176, 1042300223, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042300224, 1042300255, 'AM', 'ARM', 'ARMENIA');
INSERT INTO `partners_countryFlag` VALUES (1042300256, 1042300287, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1042300288, 1042300415, 'LB', 'LBN', 'LEBANON');
INSERT INTO `partners_countryFlag` VALUES (1042300416, 1042300479, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042300480, 1042300543, 'BA', 'BIH', 'BOSNIA AND HERZEGOVINA');
INSERT INTO `partners_countryFlag` VALUES (1042300544, 1042300607, 'KW', 'KWT', 'KUWAIT');
INSERT INTO `partners_countryFlag` VALUES (1042300608, 1042300639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042300640, 1042300647, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1042300648, 1042300655, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042300656, 1042300671, 'LB', 'LBN', 'LEBANON');
INSERT INTO `partners_countryFlag` VALUES (1042300672, 1042300863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042300864, 1042300895, 'LB', 'LBN', 'LEBANON');
INSERT INTO `partners_countryFlag` VALUES (1042300896, 1042300903, 'MD', 'MDA', 'REPUBLIC OF MOLDOVA');
INSERT INTO `partners_countryFlag` VALUES (1042300904, 1042300911, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1042300912, 1042300919, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042300920, 1042300927, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1042300928, 1042317311, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042317312, 1042350079, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1042350080, 1042415615, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1042415616, 1042546687, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1042546688, 1042677759, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1042677760, 1042743295, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1042743296, 1042808831, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1042808832, 1042817023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042817024, 1042825215, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1042825216, 1042829303, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042829304, 1042829311, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1042829312, 1042830335, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042830336, 1042831743, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042831744, 1042831792, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042831793, 1042831807, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042831808, 1042832255, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832256, 1042832287, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832288, 1042832303, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832304, 1042832311, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042832312, 1042832351, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832352, 1042832375, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832376, 1042832447, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832448, 1042832511, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042832512, 1042833407, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1042833408, 1042841599, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042841600, 1042874367, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1042874368, 1042881535, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042881536, 1042882047, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042882048, 1042883071, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042883072, 1042883583, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042883584, 1042883839, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042883840, 1042884607, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042884608, 1042886655, 'NA', 'NAM', 'NAMIBIA');
INSERT INTO `partners_countryFlag` VALUES (1042886656, 1042887327, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042887328, 1042887359, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042887360, 1042887423, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042887424, 1042888191, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042888192, 1042889727, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042889728, 1042890751, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042890752, 1042890783, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042890784, 1042890879, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042890880, 1042891775, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042891776, 1042892287, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1042892288, 1042894847, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042894848, 1042896895, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1042896896, 1042897407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042897408, 1042900479, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042900480, 1042900735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1042900736, 1042939903, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1042939904, 1043070975, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1043070976, 1043079167, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1043079168, 1043087359, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1043087360, 1043095551, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043095552, 1043103743, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1043103744, 1043120127, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1043120128, 1043136511, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1043136512, 1043202047, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1043202048, 1043333119, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1043333120, 1043341311, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1043341312, 1043349503, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1043349504, 1043357695, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043357696, 1043365887, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1043365888, 1043398655, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1043398656, 1043464191, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043464192, 1043464447, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1043464448, 1043465215, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1043465216, 1043529727, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043529728, 1043595263, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043595264, 1043600639, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043600640, 1043600895, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1043600896, 1043601151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043601152, 1043601647, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043601648, 1043601663, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043601664, 1043601791, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043601792, 1043602175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043602176, 1043602271, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043602272, 1043602315, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043602316, 1043602331, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043602332, 1043602391, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043602392, 1043602399, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1043602400, 1043602943, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043602944, 1043603455, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043603456, 1043603711, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1043603712, 1043607679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043607680, 1043607715, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1043607716, 1043607719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043607720, 1043607807, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043607808, 1043609215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609216, 1043609279, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609280, 1043609343, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1043609344, 1043609375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609376, 1043609391, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609392, 1043609407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609408, 1043609439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609440, 1043609459, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609460, 1043609463, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609464, 1043609471, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1043609472, 1043609519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609520, 1043609567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043609568, 1043610111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043610112, 1043613439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043613440, 1043614207, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043614208, 1043615231, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043615232, 1043615487, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1043615488, 1043616767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043616768, 1043617535, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043617536, 1043617791, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1043617792, 1043619327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043619328, 1043619839, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043619840, 1043620095, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1043620096, 1043620607, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043620608, 1043621055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043621056, 1043621503, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043621504, 1043621567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043621568, 1043621631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043621632, 1043621887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043621888, 1043622655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043622656, 1043623215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043623216, 1043623231, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043623232, 1043623295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043623296, 1043623679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043623680, 1043623935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043623936, 1043624447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043624448, 1043624703, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1043624704, 1043626239, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043626240, 1043627007, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043627008, 1043627519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043627520, 1043633663, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043633664, 1043633919, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1043633920, 1043637759, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043637760, 1043639039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043639040, 1043639807, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043639808, 1043640879, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043640880, 1043641043, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043641044, 1043641055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043641056, 1043665151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043665152, 1043665663, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043665664, 1043667583, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043667584, 1043667647, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1043667648, 1043667711, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043667712, 1043668991, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043668992, 1043677183, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043677184, 1043692543, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043692544, 1043693127, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043693128, 1043693183, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043693184, 1043693567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043693568, 1043695103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043695104, 1043695679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043695680, 1043697151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043697152, 1043699783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043699784, 1043699799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043699800, 1043699983, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043699984, 1043700039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700040, 1043700055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700056, 1043700095, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700096, 1043700103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700104, 1043700447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700448, 1043700503, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700504, 1043700607, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043700608, 1043701247, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043701248, 1043701895, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043701896, 1043702015, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043702016, 1043702335, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043702336, 1043703295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043703296, 1043703935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043703936, 1043705343, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043705344, 1043707391, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043707392, 1043708415, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043708416, 1043709439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043709440, 1043711483, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043711484, 1043712191, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043712192, 1043712287, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043712288, 1043712767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043712768, 1043713407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043713408, 1043713447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043713448, 1043713535, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043713536, 1043717119, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043717120, 1043718207, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043718208, 1043718399, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043718400, 1043718527, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1043718528, 1043718783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043718784, 1043718815, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1043718816, 1043719295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043719296, 1043719423, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043719424, 1043719679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043719680, 1043720255, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043720256, 1043720943, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043720944, 1043720991, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043720992, 1043721087, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043721088, 1043722495, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043722496, 1043723007, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043723008, 1043723775, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043723776, 1043724311, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043724312, 1043724799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043724800, 1043791871, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043791872, 1043791923, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043791924, 1043792127, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043792128, 1043793919, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043793920, 1043794047, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043794048, 1043794175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043794176, 1043797247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043797248, 1043798015, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043798016, 1043799039, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043799040, 1043799167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043799168, 1043799295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043799296, 1043800063, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043800064, 1043800191, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043800192, 1043800319, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043800320, 1043812467, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043812468, 1043812479, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043812480, 1043812607, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043812608, 1043816535, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043816536, 1043816575, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043816576, 1043816703, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043816704, 1043824639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043824640, 1043832831, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043832832, 1043842303, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043842304, 1043843327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043843328, 1043857407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1043857408, 1043890175, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1043890176, 1043893247, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1043893248, 1043894015, 'CM', 'CMR', 'CAMEROON');
INSERT INTO `partners_countryFlag` VALUES (1043894016, 1043896319, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1043896320, 1043897343, 'GH', 'GHA', 'GHANA');
INSERT INTO `partners_countryFlag` VALUES (1043897344, 1043897855, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043897856, 1043898367, 'ZW', 'ZWE', 'ZIMBABWE');
INSERT INTO `partners_countryFlag` VALUES (1043898368, 1043898879, 'CD', 'COD', 'THE DEMOCRATIC REPUBLIC OF THE CONGO');
INSERT INTO `partners_countryFlag` VALUES (1043898880, 1043899647, 'MG', 'MDG', 'MADAGASCAR');
INSERT INTO `partners_countryFlag` VALUES (1043899648, 1043900159, 'GH', 'GHA', 'GHANA');
INSERT INTO `partners_countryFlag` VALUES (1043900160, 1043900415, 'MG', 'MDG', 'MADAGASCAR');
INSERT INTO `partners_countryFlag` VALUES (1043900416, 1043900927, 'ZW', 'ZWE', 'ZIMBABWE');
INSERT INTO `partners_countryFlag` VALUES (1043901696, 1043901951, 'BJ', 'BEN', 'BENIN');
INSERT INTO `partners_countryFlag` VALUES (1043901952, 1043904511, 'RW', 'RWA', 'RWANDA');
INSERT INTO `partners_countryFlag` VALUES (1043904512, 1043905023, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043905024, 1043905279, 'TG', 'TGO', 'TOGO');
INSERT INTO `partners_countryFlag` VALUES (1043905280, 1043905535, 'GH', 'GHA', 'GHANA');
INSERT INTO `partners_countryFlag` VALUES (1043905536, 1043906559, 'TG', 'TGO', 'TOGO');
INSERT INTO `partners_countryFlag` VALUES (1043906560, 1043907583, 'MZ', 'MOZ', 'MOZAMBIQUE');
INSERT INTO `partners_countryFlag` VALUES (1043907584, 1043908607, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1043908608, 1043909119, 'MZ', 'MOZ', 'MOZAMBIQUE');
INSERT INTO `partners_countryFlag` VALUES (1043909120, 1043909631, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1043909632, 1043909887, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043909888, 1043910143, 'GH', 'GHA', 'GHANA');
INSERT INTO `partners_countryFlag` VALUES (1043910144, 1043910655, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1043910656, 1043911679, 'GN', 'GIN', 'GUINEA');
INSERT INTO `partners_countryFlag` VALUES (1043911680, 1043912447, 'CM', 'CMR', 'CAMEROON');
INSERT INTO `partners_countryFlag` VALUES (1043912448, 1043912703, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043912704, 1043913215, 'ZM', 'ZMB', 'ZAMBIA');
INSERT INTO `partners_countryFlag` VALUES (1043913216, 1043914751, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043914752, 1043916799, 'MZ', 'MOZ', 'MOZAMBIQUE');
INSERT INTO `partners_countryFlag` VALUES (1043916800, 1043917055, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1043917056, 1043917311, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043917312, 1043917567, 'CM', 'CMR', 'CAMEROON');
INSERT INTO `partners_countryFlag` VALUES (1043917568, 1043918079, 'NG', 'NGA', 'NIGERIA');
INSERT INTO `partners_countryFlag` VALUES (1043918080, 1043918335, 'SN', 'SEN', 'SENEGAL');
INSERT INTO `partners_countryFlag` VALUES (1043918336, 1043918847, 'AO', 'AGO', 'ANGOLA');
INSERT INTO `partners_countryFlag` VALUES (1043918848, 1043919871, 'MG', 'MDG', 'MADAGASCAR');
INSERT INTO `partners_countryFlag` VALUES (1043919872, 1043921151, 'NG', 'NGA', 'NIGERIA');
INSERT INTO `partners_countryFlag` VALUES (1043921152, 1043921407, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1043921408, 1043921663, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1043921664, 1043921919, 'GH', 'GHA', 'GHANA');
INSERT INTO `partners_countryFlag` VALUES (1043921920, 1043922943, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1043922944, 1043988479, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1043988480, 1043999199, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1043999200, 1043999207, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1043999208, 1043999999, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044000000, 1044000127, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044000128, 1044003187, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044003188, 1044003355, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044003356, 1044003359, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044003360, 1044003839, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044003840, 1044004303, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044004304, 1044008191, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044008192, 1044008223, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044008224, 1044008247, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044008248, 1044009727, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044009728, 1044012031, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044012032, 1044012159, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044012160, 1044012175, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044012176, 1044012199, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044012200, 1044012239, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044012240, 1044012543, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044012544, 1044013055, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044013056, 1044013135, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044013136, 1044013143, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044013144, 1044013543, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044013544, 1044014111, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044014112, 1044014119, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044014120, 1044015535, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044015536, 1044017151, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044017152, 1044017663, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044017664, 1044018175, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044018176, 1044019199, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019200, 1044019319, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019320, 1044019323, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019324, 1044019355, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019356, 1044019383, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019384, 1044019387, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019388, 1044019695, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019696, 1044019699, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044019700, 1044020223, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044020224, 1044020255, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044020256, 1044020311, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044020312, 1044020415, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044020416, 1044020559, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044020560, 1044020735, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044020736, 1044021887, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044021888, 1044022351, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044022352, 1044022527, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044022528, 1044023295, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044023296, 1044023359, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044023360, 1044023551, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044023552, 1044024831, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044024832, 1044025215, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044025216, 1044025855, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044025856, 1044027263, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044027264, 1044028927, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044028928, 1044029439, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029440, 1044029466, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029467, 1044029470, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029471, 1044029481, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029482, 1044029496, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029497, 1044029510, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029511, 1044029540, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029541, 1044029560, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029561, 1044029568, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029569, 1044029580, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029581, 1044029588, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029589, 1044029611, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029612, 1044029629, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029630, 1044029648, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029649, 1044029660, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029661, 1044029672, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029673, 1044029678, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029679, 1044029687, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044029688, 1044031360, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031361, 1044031364, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031365, 1044031497, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031498, 1044031536, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031537, 1044031567, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031568, 1044031569, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031570, 1044031581, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031582, 1044031600, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031601, 1044031630, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031631, 1044031644, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031645, 1044031652, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031653, 1044031655, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031656, 1044031677, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031678, 1044031688, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031689, 1044031699, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031700, 1044031704, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031705, 1044031710, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031711, 1044031712, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031713, 1044031715, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031716, 1044031935, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044031936, 1044032159, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044032160, 1044033175, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044033176, 1044033935, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044033936, 1044034367, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044034368, 1044035023, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044035024, 1044036864, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036865, 1044036891, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036892, 1044036900, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036901, 1044036928, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036929, 1044036943, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036944, 1044036950, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036951, 1044036958, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036959, 1044036971, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036972, 1044036977, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036978, 1044036991, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044036992, 1044037022, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037023, 1044037025, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037026, 1044037027, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037028, 1044037038, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037039, 1044037043, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037044, 1044037051, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037052, 1044037057, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037058, 1044037063, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037064, 1044037066, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037067, 1044037071, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037072, 1044037092, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037093, 1044037100, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037101, 1044037102, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037103, 1044037107, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037108, 1044037110, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037111, 1044037199, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044037200, 1044040703, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044040704, 1044045311, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044045312, 1044045887, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044045888, 1044046847, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044046848, 1044051971, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044051972, 1044053503, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044053504, 1044059935, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044059936, 1044060063, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044060064, 1044062031, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062032, 1044062111, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062112, 1044062199, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062200, 1044062383, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062384, 1044062511, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062512, 1044062543, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062544, 1044062583, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062584, 1044062655, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062656, 1044062687, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044062688, 1044068991, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044068992, 1044070399, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044070400, 1044076927, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044076928, 1044078591, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044078592, 1044093183, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044093184, 1044103295, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044103296, 1044106239, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044106240, 1044106495, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044106496, 1044107263, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044107264, 1044117503, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044117504, 1044117551, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044117552, 1044117631, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044117632, 1044119551, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044119552, 1044135935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044135936, 1044152319, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044152320, 1044185087, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1044185088, 1044193279, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1044193280, 1044201471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044201472, 1044217855, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1044217856, 1044226047, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1044226048, 1044234239, 'OM', 'OMN', 'OMAN');
INSERT INTO `partners_countryFlag` VALUES (1044234240, 1044250623, 'DZ', 'DZA', 'ALGERIA');
INSERT INTO `partners_countryFlag` VALUES (1044250624, 1044251391, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044251648, 1044252415, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044252928, 1044253439, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044253696, 1044254463, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044254976, 1044255487, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044256000, 1044256511, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044256768, 1044257535, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044257792, 1044258559, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044259072, 1044259583, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044260096, 1044261631, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044262144, 1044262399, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044263168, 1044263423, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044264192, 1044264447, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044265216, 1044265471, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044265984, 1044266751, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044267520, 1044269567, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044270080, 1044271615, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044272128, 1044272383, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044272896, 1044273151, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044273408, 1044273663, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044273920, 1044274175, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044283392, 1044316159, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1044316160, 1044381695, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1044381696, 1044389887, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1044389888, 1044398079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044398080, 1044414463, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1044414464, 1044447231, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044447232, 1044451583, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044451584, 1044451839, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044451840, 1044451863, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044451864, 1044452007, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044452008, 1044452319, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044452320, 1044452671, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044452672, 1044453151, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044453152, 1044453183, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044453184, 1044453263, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044453264, 1044453983, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044453984, 1044454399, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454400, 1044454415, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044454416, 1044454423, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454424, 1044454427, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044454428, 1044454447, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454448, 1044454455, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454456, 1044454463, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454464, 1044454495, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044454496, 1044454511, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454512, 1044454559, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044454560, 1044454583, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044454584, 1044455423, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044455424, 1044463615, 'EE', 'EST', 'ESTONIA');
INSERT INTO `partners_countryFlag` VALUES (1044463616, 1044479999, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044480000, 1044488191, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1044488192, 1044496383, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1044496384, 1044512767, 'EE', 'EST', 'ESTONIA');
INSERT INTO `partners_countryFlag` VALUES (1044512768, 1044545535, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1044545536, 1044578303, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044578304, 1044652031, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044652032, 1044660223, 'LY', 'LBY', 'LIBYAN ARAB JAMAHIRIYA');
INSERT INTO `partners_countryFlag` VALUES (1044660224, 1044668415, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1044668416, 1044676607, 'JO', 'JOR', 'JORDAN');
INSERT INTO `partners_countryFlag` VALUES (1044676608, 1044684799, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1044684800, 1044692991, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1044692992, 1044693503, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1044693504, 1044694015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044694016, 1044694783, 'GE', 'GEO', 'GEORGIA');
INSERT INTO `partners_countryFlag` VALUES (1044694784, 1044695039, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1044695040, 1044695807, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044695808, 1044698111, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1044698112, 1044698879, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044698880, 1044699135, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1044699136, 1044699903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044699904, 1044700159, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1044700160, 1044700927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044700928, 1044701183, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1044701184, 1044709375, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1044709376, 1044717567, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1044717568, 1044742143, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044742144, 1044750335, 'KW', 'KWT', 'KUWAIT');
INSERT INTO `partners_countryFlag` VALUES (1044750336, 1044758527, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044758528, 1044774911, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044774912, 1044840447, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1044840448, 1044905983, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1044905984, 1044908031, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044908032, 1044909055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044909056, 1044909567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044909568, 1044910335, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044910336, 1044910847, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044910848, 1044913951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044913952, 1044913983, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044913984, 1044914047, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044914048, 1044914175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044914176, 1044916735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044916736, 1044917247, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044917248, 1044917279, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044917280, 1044917295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044917296, 1044917311, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044917312, 1044917343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044917344, 1044917359, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044917360, 1044917503, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044917504, 1044917759, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044917760, 1044917823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044917824, 1044918271, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044918272, 1044918287, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044918288, 1044920319, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044920320, 1044922367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1044922368, 1044930559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1044930560, 1044938751, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1044938752, 1044955135, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1044955136, 1044963327, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1044963328, 1044971519, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1044971520, 1044979711, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1044979712, 1044987903, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1044987904, 1045004287, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1045004288, 1045004543, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045004544, 1045004551, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1045004552, 1045004671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045004672, 1045004751, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1045004752, 1045004919, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045004920, 1045006599, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045006600, 1045012479, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045012480, 1045020671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045020672, 1045037055, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1045037056, 1045135359, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1045135360, 1045138447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045138448, 1045138463, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1045138464, 1045166079, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045166080, 1045167103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045167104, 1045167359, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045167360, 1045168127, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045168128, 1045233663, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1045233664, 1045241855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045241856, 1045250047, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1045250048, 1045266431, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045266432, 1045274623, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045274624, 1045282815, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1045282816, 1045299199, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045299200, 1045302271, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045307392, 1045315583, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045315584, 1045319679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045323776, 1045364735, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1045364736, 1045430271, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1045430272, 1045436911, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045436912, 1045436919, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045436920, 1045437159, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437160, 1045437327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437328, 1045437343, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437344, 1045437355, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437356, 1045437567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437568, 1045437595, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437596, 1045437647, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437648, 1045437803, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437804, 1045437887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437888, 1045437947, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437948, 1045437975, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045437976, 1045438011, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045438012, 1045438143, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045438144, 1045438159, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045438160, 1045438279, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045438280, 1045438451, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045438452, 1045438487, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045438488, 1045443072, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045443073, 1045443328, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045443329, 1045446655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045446656, 1045446911, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045446912, 1045447167, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447168, 1045447237, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045447238, 1045447239, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447240, 1045447247, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045447248, 1045447263, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447264, 1045447399, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045447400, 1045447415, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447416, 1045447431, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045447432, 1045447447, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447448, 1045447471, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045447472, 1045447487, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447488, 1045447519, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045447520, 1045447679, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045447680, 1045448111, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045448112, 1045448127, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448128, 1045448159, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045448160, 1045448191, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448192, 1045448239, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045448240, 1045448263, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448264, 1045448271, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045448272, 1045448279, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448280, 1045448447, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045448448, 1045448639, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448640, 1045448703, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448704, 1045448767, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045448768, 1045448831, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045448832, 1045450239, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1045450240, 1045450751, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045450752, 1045451775, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045451776, 1045452111, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045452112, 1045452127, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045452128, 1045452175, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045452176, 1045452255, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045452256, 1045452543, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045452544, 1045452799, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045452800, 1045454847, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045454848, 1045460735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045460736, 1045460991, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1045460992, 1045461503, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1045461504, 1045461631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045461632, 1045462015, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1045462016, 1045463039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045463040, 1045471231, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1045471232, 1045479423, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1045479424, 1045487615, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1045487616, 1045495807, 'LT', 'LTU', 'LITHUANIA');
INSERT INTO `partners_countryFlag` VALUES (1045495808, 1045692415, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1045692416, 1045700607, 'LV', 'LVA', 'LATVIA');
INSERT INTO `partners_countryFlag` VALUES (1045700608, 1045708799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1045708800, 1045716991, 'LB', 'LBN', 'LEBANON');
INSERT INTO `partners_countryFlag` VALUES (1045716992, 1045725183, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1045725184, 1045733375, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1045733376, 1045741567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045741568, 1045749759, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1045749760, 1045757951, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1045757952, 1045790719, 'LV', 'LVA', 'LATVIA');
INSERT INTO `partners_countryFlag` VALUES (1045790720, 1045798911, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1045798912, 1045807103, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1045807104, 1045823487, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1045823488, 1045889023, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1045889024, 1045921791, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1045921792, 1045954559, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1045954560, 1045987327, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1045987328, 1046020095, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1046020096, 1046028287, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1046028288, 1046036479, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1046036480, 1046052863, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1046052864, 1046061055, 'GI', 'GIB', 'GIBRALTAR');
INSERT INTO `partners_countryFlag` VALUES (1046061056, 1046069247, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046069248, 1046085631, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1046085632, 1046151167, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1046151168, 1046216703, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046216704, 1046282239, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1046282240, 1046290431, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1046290432, 1046315007, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1046315008, 1046315519, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1046315520, 1046316031, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046316032, 1046316543, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046316544, 1046317055, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1046317056, 1046317567, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1046317568, 1046318079, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1046318080, 1046318591, 'SZ', 'SWZ', 'SWAZILAND');
INSERT INTO `partners_countryFlag` VALUES (1046318592, 1046319103, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1046319104, 1046323199, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1046323200, 1046331383, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1046331384, 1046331391, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1046331392, 1046331903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046331904, 1046332159, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1046332160, 1046332415, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1046332416, 1046333439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046333440, 1046334207, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046334208, 1046336255, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046336256, 1046338559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046338560, 1046339071, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046339072, 1046339583, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046339584, 1046340095, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1046340096, 1046340863, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1046340864, 1046341119, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046341120, 1046341631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046341632, 1046341887, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1046341888, 1046345327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046345328, 1046346751, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046346752, 1046347775, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046347776, 1046349839, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046349840, 1046349847, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1046349848, 1046349967, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046349968, 1046350847, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046350848, 1046351871, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046351872, 1046352479, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046352480, 1046352511, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046352512, 1046352767, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046352768, 1046352863, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046352864, 1046352895, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046352896, 1046354943, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046354944, 1046356479, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046356480, 1046356991, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046356992, 1046357247, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046357248, 1046358015, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046358016, 1046358271, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046358272, 1046359039, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046359040, 1046360319, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046360320, 1046361583, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046361584, 1046361855, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046361856, 1046363199, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363200, 1046363279, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363280, 1046363447, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363448, 1046363463, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363464, 1046363519, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363520, 1046363543, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363544, 1046363599, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363600, 1046363647, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363648, 1046363815, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363816, 1046363831, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363832, 1046363855, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363856, 1046363967, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363968, 1046363991, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046363992, 1046364159, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046364160, 1046366279, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046366280, 1046366319, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046366320, 1046366367, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046366368, 1046366463, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046366464, 1046367231, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046367232, 1046367271, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046367272, 1046367599, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046367600, 1046368287, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368288, 1046368303, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368304, 1046368319, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368320, 1046368335, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368336, 1046368551, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368552, 1046368575, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368576, 1046368639, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046368640, 1046369279, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046369280, 1046372351, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046372352, 1046372607, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046372608, 1046373439, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046373440, 1046373631, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046373632, 1046374399, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046374400, 1046374543, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046374544, 1046374655, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046374656, 1046375167, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046375168, 1046375679, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046375680, 1046376063, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046376064, 1046377535, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046377536, 1046377775, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046377776, 1046377871, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046377872, 1046377903, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046377904, 1046377935, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046377936, 1046377975, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046377976, 1046379007, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046379008, 1046379319, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046379320, 1046379391, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046379392, 1046379455, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046379456, 1046380159, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380160, 1046380183, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380184, 1046380211, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380212, 1046380463, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380464, 1046380703, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380704, 1046380751, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380752, 1046380799, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046380800, 1046381583, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046381584, 1046381631, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046381632, 1046382087, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382088, 1046382135, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382136, 1046382151, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382152, 1046382183, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382184, 1046382199, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382200, 1046382223, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382224, 1046382271, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382272, 1046382287, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382288, 1046382335, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382336, 1046382599, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382600, 1046382663, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382664, 1046382679, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382680, 1046382695, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382696, 1046382711, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382712, 1046382759, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382760, 1046382847, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046382848, 1046383375, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383376, 1046383391, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383392, 1046383423, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383424, 1046383439, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383440, 1046383479, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383480, 1046383583, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383584, 1046383599, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383600, 1046383623, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383624, 1046383647, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383648, 1046383687, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383688, 1046383727, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383728, 1046383743, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383744, 1046383791, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383792, 1046383815, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383816, 1046383839, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383840, 1046383895, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383896, 1046383919, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383920, 1046383959, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383960, 1046383975, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046383976, 1046384015, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046384016, 1046384039, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046384040, 1046384799, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046384800, 1046384895, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046384896, 1046385687, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385688, 1046385703, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385704, 1046385727, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385728, 1046385743, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385744, 1046385759, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385760, 1046385799, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385800, 1046385919, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385920, 1046385943, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385944, 1046385967, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385968, 1046385983, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046385984, 1046386023, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046386024, 1046386071, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046386072, 1046386095, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046386096, 1046386111, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046386112, 1046386143, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046386144, 1046386175, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046386176, 1046388223, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046388224, 1046388735, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046388736, 1046397951, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046397952, 1046405119, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046405120, 1046406655, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046406656, 1046407103, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046407104, 1046413311, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046413312, 1046446079, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1046446080, 1046544383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1046544384, 1046560767, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046560768, 1046585343, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1046585344, 1046609919, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1046609920, 1046675455, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046675456, 1046708223, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1046708224, 1046740991, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1046740992, 1046757375, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1046757376, 1046765567, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046765568, 1046773759, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1046773760, 1046781951, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1046781952, 1046790143, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1046790144, 1046798335, 'KW', 'KWT', 'KUWAIT');
INSERT INTO `partners_countryFlag` VALUES (1046798336, 1046806527, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1046806528, 1046814719, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046814720, 1046822911, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1046822912, 1046847487, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1046847488, 1046855679, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1046855680, 1046872063, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1046872064, 1046872831, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046872832, 1046872855, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1046872856, 1046872863, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046872864, 1046872887, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1046872888, 1046872903, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046872904, 1046872975, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046872976, 1046873087, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046873088, 1046878719, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046878720, 1046879327, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879328, 1046879503, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879504, 1046879567, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879568, 1046879591, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1046879592, 1046879743, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879744, 1046879775, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879776, 1046879839, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879840, 1046879879, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879880, 1046879895, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046879896, 1046880143, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046880144, 1046880255, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046880256, 1046880631, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046880632, 1046881151, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046881152, 1046881223, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046881224, 1046881279, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046881280, 1046904831, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1046904832, 1046937599, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1046937600, 1047003135, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1047003136, 1047068671, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047068672, 1047076863, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1047076864, 1047085055, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047085056, 1047101439, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1047101440, 1047109631, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047109632, 1047117823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1047117824, 1047134207, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1047134208, 1047199743, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1047199744, 1047265279, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1047265280, 1047273471, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1047273472, 1047281663, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1047281664, 1047289855, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1047289856, 1047298047, 'YU', 'YUG', 'YUGOSLAVIA');
INSERT INTO `partners_countryFlag` VALUES (1047298048, 1047306239, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1047306240, 1047314431, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1047314432, 1047322623, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047322624, 1047330815, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1047330816, 1047339007, 'KZ', 'KAZ', 'KAZAKHSTAN');
INSERT INTO `partners_countryFlag` VALUES (1047339008, 1047347199, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047347200, 1047371775, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047371776, 1047379967, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047379968, 1047396351, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1047396352, 1047461887, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1047461888, 1047494655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047494656, 1047527423, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1047527424, 1047535615, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1047535616, 1047551999, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047552000, 1047560191, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047560192, 1047568383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047568384, 1047568895, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1047568896, 1047570943, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1047570944, 1047571455, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1047571456, 1047573503, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1047573504, 1047576575, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1047576576, 1047584767, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1047584768, 1047592959, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1047592960, 1047601151, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1047601152, 1047625727, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047625728, 1047633919, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1047633920, 1047642111, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1047642112, 1047658495, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1047658496, 1047724031, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1047724032, 1047789311, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1047789312, 1047789375, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047789376, 1047789567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1047789568, 1047797215, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047797216, 1047797247, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1047797248, 1047797375, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047797376, 1047797759, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047797760, 1047806031, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047806032, 1047806047, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1047806048, 1047806135, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047806136, 1047806143, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047806144, 1047806479, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047806480, 1047806559, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047806560, 1047807071, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047807072, 1047807183, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047807184, 1047807227, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047807228, 1047807599, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047807600, 1047807631, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047807632, 1047807743, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047807744, 1047807999, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808000, 1047808263, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808264, 1047808279, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808280, 1047808319, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808320, 1047808415, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808416, 1047808479, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808480, 1047808511, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808512, 1047808655, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808656, 1047808767, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047808768, 1047809727, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047809728, 1047810303, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047810304, 1047810559, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047810560, 1047810591, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047810592, 1047810687, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047810688, 1047810947, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047810948, 1047810975, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047810976, 1047810999, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047811000, 1047811012, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047811013, 1047811016, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047811017, 1047811055, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047811056, 1047811303, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047811304, 1047811327, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047811328, 1047813447, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813448, 1047813579, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813580, 1047813615, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813616, 1047813619, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813620, 1047813621, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813622, 1047813623, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813624, 1047813627, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047813628, 1047822335, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1047822336, 1047838719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047838720, 1047846911, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1047846912, 1047855103, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047855104, 1047863295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1047863296, 1047871487, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1047871488, 1047887871, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047887872, 1047920639, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1047920640, 1047986175, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1047986176, 1047997439, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047997440, 1047997503, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1047997504, 1047997695, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047997696, 1047998207, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1047998208, 1048002647, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048002648, 1048002679, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048002680, 1048003327, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048003328, 1048004063, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048004064, 1048006911, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048006912, 1048011847, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048011848, 1048012423, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048012424, 1048012447, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048012448, 1048015535, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048015536, 1048015599, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048015600, 1048015615, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048015616, 1048020479, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048020480, 1048020527, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048020528, 1048020783, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048020784, 1048020943, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048020944, 1048021007, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048021008, 1048021247, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048021248, 1048021503, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048021504, 1048021759, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048021760, 1048035327, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048035328, 1048051711, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048051712, 1048117247, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1048117248, 1048125439, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048125440, 1048133631, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1048133632, 1048158207, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1048158208, 1048166399, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1048166400, 1048182783, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1048182784, 1048313855, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1048313856, 1048379391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048379392, 1048510463, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048510464, 1048575999, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1048576000, 1048584191, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048584192, 1048592383, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1048592384, 1048600575, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1048600576, 1048608767, 'EE', 'EST', 'ESTONIA');
INSERT INTO `partners_countryFlag` VALUES (1048608768, 1048616959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048616960, 1048621055, 'KE', 'KEN', 'KENYA');
INSERT INTO `partners_countryFlag` VALUES (1048621056, 1048625151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048625152, 1048633343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048633344, 1048641535, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1048641536, 1048649727, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1048649728, 1048657919, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1048657920, 1048674303, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048674304, 1048682495, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1048682496, 1048690687, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1048690688, 1048707071, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1048707072, 1048772607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1048772608, 1048838143, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1048838144, 1048839999, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840000, 1048840015, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1048840016, 1048840031, 'KZ', 'KAZ', 'KAZAKHSTAN');
INSERT INTO `partners_countryFlag` VALUES (1048840032, 1048840063, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1048840064, 1048840095, 'TJ', 'TJK', 'TAJIKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1048840096, 1048840111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840112, 1048840119, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1048840120, 1048840127, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840128, 1048840159, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1048840160, 1048840383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840384, 1048840546, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840547, 1048840559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840560, 1048840703, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840704, 1048840799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840800, 1048840935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048840936, 1048841471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048841472, 1048842623, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048842624, 1048842879, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048842880, 1048843199, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048843200, 1048843239, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048843240, 1048843279, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048843280, 1048844543, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048844544, 1048844872, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048844873, 1048845039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048845040, 1048845231, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048845232, 1048845375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048845376, 1048845471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048845472, 1048845567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048845568, 1048845727, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048845728, 1048846351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048846352, 1048846975, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048846976, 1048847775, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048847776, 1048847919, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048847920, 1048848423, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048848424, 1048848911, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048848912, 1048849151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048849152, 1048849215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048849216, 1048850303, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048850304, 1048851743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048851744, 1048851967, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048851968, 1048852143, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852144, 1048852175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852176, 1048852223, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852224, 1048852479, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852480, 1048852543, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852544, 1048852559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852560, 1048852903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048852904, 1048853759, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048853760, 1048854143, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854144, 1048854527, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854528, 1048854567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854568, 1048854631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854632, 1048854719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854720, 1048854815, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854816, 1048854928, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854929, 1048854959, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048854960, 1048855026, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048855027, 1048855039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048855040, 1048855903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048855904, 1048856063, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048856064, 1048856591, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048856592, 1048856639, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048856640, 1048856719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048856720, 1048857103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857104, 1048857343, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857344, 1048857363, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857364, 1048857371, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857372, 1048857479, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857480, 1048857631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857632, 1048857727, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048857728, 1048858415, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048858416, 1048858559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048858560, 1048858687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048858688, 1048858876, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048858877, 1048858879, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048858880, 1048858959, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048858960, 1048859247, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048859248, 1048859903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048859904, 1048860735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048860736, 1048860943, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048860944, 1048861027, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048861028, 1048861439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048861440, 1048861839, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048861840, 1048862207, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048862208, 1048862231, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048862232, 1048862327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048862328, 1048862335, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048862336, 1048863039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048863040, 1048863744, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048863745, 1048864199, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048864200, 1048864767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048864768, 1048865599, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048865600, 1048865671, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048865672, 1048865702, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048865703, 1048865743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048865744, 1048866655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048866656, 1048867583, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048867584, 1048867711, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048867712, 1048868095, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868096, 1048868223, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868224, 1048868295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868296, 1048868348, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868349, 1048868351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868352, 1048868415, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868416, 1048868927, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048868928, 1048869114, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048869115, 1048869375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048869376, 1048870653, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048870654, 1048871679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048871680, 1048871935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048871936, 1048872447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048872448, 1048873215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048873216, 1048874505, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048874506, 1048874639, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048874640, 1048874719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048874720, 1048874767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048874768, 1048875263, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048875264, 1048877399, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048877400, 1048877471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048877472, 1048877565, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048877566, 1048877827, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048877828, 1048877839, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048877840, 1048879623, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048879624, 1048880951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048880952, 1048911871, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1048911872, 1048920063, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1048920064, 1048944639, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1048944640, 1048952831, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1048952832, 1048969215, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1048969216, 1049034751, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049034752, 1049067519, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1049067520, 1049100287, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1049100288, 1049165823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049165824, 1049231359, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049231360, 1049296895, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049296896, 1049362431, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1049362432, 1049370623, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049370624, 1049378815, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049378816, 1049395199, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1049395200, 1049411583, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049411584, 1049419775, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049419776, 1049427967, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1049427968, 1049436159, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1049436160, 1049444351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049444352, 1049460735, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1049460736, 1049468927, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049468928, 1049477119, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049477120, 1049493503, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1049493504, 1049518079, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049518080, 1049518095, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049518096, 1049519103, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049519104, 1049520127, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049520128, 1049521663, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049521664, 1049522159, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049522160, 1049522175, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049522176, 1049522199, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049522200, 1049524223, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049524224, 1049524319, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049524320, 1049524991, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049524992, 1049525087, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049525088, 1049525375, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049525376, 1049525979, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049525980, 1049526199, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049526200, 1049542655, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049542656, 1049546751, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049546752, 1049547007, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049547008, 1049547775, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049547776, 1049547935, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049547936, 1049548799, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049548800, 1049549015, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049549016, 1049549183, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049549184, 1049549311, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049549312, 1049549439, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049549440, 1049549823, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049549824, 1049550847, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049550848, 1049551071, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049551072, 1049551183, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049551184, 1049551899, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049551900, 1049551931, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049551932, 1049552127, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049552128, 1049553175, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049553176, 1049553663, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049553664, 1049554943, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049554944, 1049556927, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049556928, 1049559039, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049559040, 1049650111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049650112, 1049650175, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049650176, 1049652223, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049652224, 1049653095, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049653096, 1049653103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1049653104, 1049654127, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049654128, 1049658111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049658112, 1049658367, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049658368, 1049661199, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049661200, 1049661247, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049661248, 1049661471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049661472, 1049661487, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049661488, 1049661519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049661520, 1049661535, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049661536, 1049664287, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049664288, 1049664351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049664352, 1049664383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049664384, 1049665687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049665688, 1049665695, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049665696, 1049665759, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049665760, 1049666047, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049666048, 1049666367, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049666368, 1049668223, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049668224, 1049668575, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049668576, 1049669407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049669408, 1049669471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049669472, 1049669567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049669568, 1049670655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049670656, 1049670751, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049670752, 1049670791, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049670792, 1049670847, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049670848, 1049670895, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049670896, 1049671423, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049671424, 1049675263, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049675264, 1049676799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049676800, 1049676887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049676888, 1049677055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049677056, 1049677631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049677632, 1049677663, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049677664, 1049677951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049677952, 1049677999, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049678000, 1049678079, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049678080, 1049678623, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049678624, 1049690111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049690112, 1049698303, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049698304, 1049699071, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049699072, 1049700351, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049700352, 1049700479, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049700480, 1049700607, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049700608, 1049700863, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049700864, 1049701887, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049701888, 1049702015, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049702016, 1049702207, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049702208, 1049702399, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049702400, 1049706495, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049706496, 1049707007, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049707008, 1049707519, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049707520, 1049707775, 'DZ', 'DZA', 'ALGERIA');
INSERT INTO `partners_countryFlag` VALUES (1049707776, 1049708543, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049708544, 1049711359, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1049711360, 1049711615, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1049711616, 1049712127, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1049712128, 1049712383, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1049712384, 1049712583, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1049712584, 1049712639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049712640, 1049712895, 'KG', 'KGZ', 'KYRGYZSTAN');
INSERT INTO `partners_countryFlag` VALUES (1049712896, 1049713023, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1049713024, 1049713087, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049713088, 1049713151, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1049713152, 1049713663, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1049713664, 1049713919, 'YU', 'YUG', 'YUGOSLAVIA');
INSERT INTO `partners_countryFlag` VALUES (1049713920, 1049714175, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049714176, 1049714687, 'LB', 'LBN', 'LEBANON');
INSERT INTO `partners_countryFlag` VALUES (1049714688, 1049716735, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1049716736, 1049717759, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1049717760, 1049722879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049722880, 1049731071, 'IS', 'ISL', 'ICELAND');
INSERT INTO `partners_countryFlag` VALUES (1049731072, 1049739263, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049739264, 1049755647, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049755648, 1049769271, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049769272, 1049769279, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049769280, 1049769311, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049769312, 1049769503, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049769504, 1049769567, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049769568, 1049769727, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049769728, 1049770039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770040, 1049770239, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770240, 1049770303, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770304, 1049770335, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770336, 1049770399, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770400, 1049770407, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1049770408, 1049770415, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049770416, 1049770447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770448, 1049770495, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049770496, 1049771519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049771520, 1049771783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049771784, 1049771839, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049771840, 1049771967, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049771968, 1049772671, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049772672, 1049772703, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049772704, 1049772735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049772736, 1049772799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049772800, 1049772863, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1049772864, 1049772927, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049772928, 1049773055, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1049773056, 1049773311, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049773312, 1049774271, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049774272, 1049774367, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049774368, 1049774495, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049774496, 1049774527, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049774528, 1049774847, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049774848, 1049775039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775040, 1049775063, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775064, 1049775103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775104, 1049775127, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775128, 1049775879, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775880, 1049775911, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775912, 1049775935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049775936, 1049776047, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049776048, 1049776055, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049776056, 1049776063, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049776064, 1049776079, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1049776080, 1049776119, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049776120, 1049776255, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049776256, 1049776319, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1049776320, 1049776831, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049776832, 1049776839, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049776840, 1049777023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777024, 1049777087, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049777088, 1049777151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777152, 1049777191, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777192, 1049777199, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049777200, 1049777407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777408, 1049777791, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777792, 1049777927, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049777928, 1049777951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777952, 1049777959, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1049777960, 1049777967, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049777968, 1049778079, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778080, 1049778087, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049778088, 1049778103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778104, 1049778111, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049778112, 1049778143, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1049778144, 1049778175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778176, 1049778367, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778368, 1049778439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778440, 1049778455, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049778456, 1049778495, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778496, 1049778523, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1049778524, 1049778531, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049778532, 1049778559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778560, 1049778687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778688, 1049778951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778952, 1049778967, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1049778968, 1049778991, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049778992, 1049778999, 'CR', 'CRI', 'COSTA RICA');
INSERT INTO `partners_countryFlag` VALUES (1049779000, 1049779031, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049779032, 1049779167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049779168, 1049779431, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049779432, 1049779969, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049779970, 1049780094, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049780095, 1049780095, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049780096, 1049780159, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049780160, 1049780991, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049780992, 1049781247, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049781248, 1049782271, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049782272, 1049782655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049782656, 1049782663, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049782664, 1049782666, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049782667, 1049782667, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1049782668, 1049782671, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049782672, 1049782743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049782744, 1049782751, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1049782752, 1049783039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049783040, 1049783255, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049783256, 1049783743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049783744, 1049784575, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049784576, 1049789951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049789952, 1049790095, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049790096, 1049790463, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049790464, 1049791055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049791056, 1049791103, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049791104, 1049791167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049791168, 1049791487, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049791488, 1049791535, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049791536, 1049791575, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049791576, 1049804799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049804800, 1049806847, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049806848, 1049810175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049810176, 1049819135, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049819136, 1049821183, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1049821184, 1049886719, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1049886720, 1049894911, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049894912, 1049903103, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1049903104, 1049911295, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1049911296, 1049919487, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049919488, 1049927679, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1049927680, 1049935871, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1049935872, 1049944063, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1049944064, 1049952255, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1049952256, 1049960447, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1049960448, 1049968639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1049968640, 1049985023, 'SA', 'SAU', 'SAUDI ARABIA');
INSERT INTO `partners_countryFlag` VALUES (1049985024, 1050017791, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1050017792, 1050083327, 'KW', 'KWT', 'KUWAIT');
INSERT INTO `partners_countryFlag` VALUES (1050083328, 1050148863, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050148864, 1050157055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050157056, 1050165247, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1050165248, 1050173439, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1050173440, 1050189823, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1050189824, 1050198015, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050198016, 1050206207, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1050206208, 1050214399, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1050214400, 1050320231, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050320232, 1050320239, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1050320240, 1050324279, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050324280, 1050324487, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050324488, 1050326015, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050326016, 1050326111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050326112, 1050326175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050326176, 1050326231, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050326232, 1050330111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050330112, 1050332735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050332736, 1050332887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050332888, 1050333399, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050333400, 1050333759, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050333760, 1050333887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050333888, 1050333999, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050334000, 1050335351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050335352, 1050336607, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050336608, 1050337631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050337632, 1050337743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050337744, 1050340383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050340384, 1050340519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050340520, 1050342151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050342152, 1050343887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050343888, 1050344631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050344632, 1050345087, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050345088, 1050664911, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050664912, 1050664919, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1050664920, 1050666631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050666632, 1050667271, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050667272, 1050668167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050668168, 1050668511, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050668512, 1050669823, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050669824, 1050670727, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050670728, 1050672279, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050672280, 1050672319, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050672320, 1050672639, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050672640, 1050672687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050672688, 1050673151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050673152, 1050789643, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050789644, 1050789655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1050789656, 1050789664, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050789665, 1050789727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050789728, 1050789983, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050789984, 1050790239, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050790240, 1050790399, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050790400, 1050790687, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050790688, 1050790976, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050790977, 1050791007, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050791008, 1050791071, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050791072, 1050791871, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050791872, 1050792063, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792064, 1050792223, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792224, 1050792239, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792240, 1050792287, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792288, 1050792335, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792336, 1050792359, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792360, 1050792831, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050792832, 1050793220, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793221, 1050793231, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793232, 1050793280, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793281, 1050793291, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793292, 1050793294, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793295, 1050793298, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793299, 1050793312, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793313, 1050793344, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793345, 1050793346, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793347, 1050793362, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793363, 1050793383, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793384, 1050793389, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793390, 1050793479, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793480, 1050793527, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793528, 1050793543, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793544, 1050793583, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793584, 1050793615, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793616, 1050793727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793728, 1050793783, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793784, 1050793975, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050793976, 1050794239, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050794240, 1050794303, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050794304, 1050794399, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050794400, 1050794447, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050794448, 1050795647, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050795648, 1050796031, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050796032, 1050796191, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050796192, 1050796823, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050796824, 1050796855, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050796856, 1050796975, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050796976, 1050797007, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797008, 1050797079, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797080, 1050797215, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797216, 1050797351, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797352, 1050797439, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797440, 1050797503, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797504, 1050797567, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797568, 1050797823, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797824, 1050797919, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050797920, 1050797999, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798000, 1050798071, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798072, 1050798127, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798128, 1050798207, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798208, 1050798336, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798337, 1050798342, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798343, 1050798352, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798353, 1050798356, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798357, 1050798367, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798368, 1050798376, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798377, 1050798387, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798388, 1050798395, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798396, 1050798397, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798398, 1050798407, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798408, 1050798418, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798419, 1050798440, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798441, 1050798442, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798443, 1050798446, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798447, 1050798455, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798456, 1050798459, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798460, 1050798461, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798462, 1050798463, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798464, 1050798480, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798481, 1050798484, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798485, 1050798489, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798490, 1050798493, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798494, 1050798498, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798499, 1050798509, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798510, 1050798514, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798515, 1050798524, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798525, 1050798526, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798527, 1050798529, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798530, 1050798539, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798540, 1050798549, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798550, 1050798552, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798553, 1050798555, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798556, 1050798557, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798558, 1050798560, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798561, 1050798567, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798568, 1050798571, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798572, 1050798580, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798581, 1050798587, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798588, 1050798591, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050798592, 1050799551, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799552, 1050799655, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799656, 1050799735, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799736, 1050799751, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799752, 1050799799, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799800, 1050799815, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799816, 1050799831, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799832, 1050799855, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050799856, 1050799999, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800000, 1050800079, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800080, 1050800127, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800128, 1050800175, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800176, 1050800207, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800208, 1050800255, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800256, 1050800831, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050800832, 1050801087, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801088, 1050801159, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801160, 1050801183, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801184, 1050801375, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801376, 1050801471, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801472, 1050801599, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801600, 1050801791, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801792, 1050801855, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050801856, 1050802239, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050802240, 1050802623, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050802624, 1050802687, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050802688, 1050802783, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050802784, 1050802879, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050802880, 1050803263, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050803264, 1050803615, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050803616, 1050804127, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050804128, 1050804223, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1050804224, 1050869759, 'MK', 'MKD', 'THE FORMER YUGOSLAV REPUBLIC OF MACEDONIA');
INSERT INTO `partners_countryFlag` VALUES (1050869760, 1050935295, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1050935296, 1050935551, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050935552, 1050937087, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050937088, 1050937599, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050937600, 1050937855, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050937856, 1050940415, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050940416, 1050940431, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050940432, 1050940440, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050940441, 1050940671, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050940672, 1050940799, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050940800, 1050940927, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050940928, 1050941183, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050941184, 1050942975, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050942976, 1050943487, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050943488, 1050945535, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050945536, 1050946047, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050946048, 1050948351, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050948352, 1050948863, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050948864, 1050950655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050950656, 1050951423, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1050951424, 1050968063, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1050968064, 1050968319, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1050969856, 1050970367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1050984448, 1050984703, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1050984736, 1050984767, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1050984832, 1050984959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051000576, 1051000831, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051000832, 1051009023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1051009024, 1051017215, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1051017216, 1051033599, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051033600, 1051049983, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1051049984, 1051066367, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1051066368, 1051084287, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051084288, 1051084799, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051084800, 1051097087, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051097088, 1051099135, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051099136, 1051100527, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051100528, 1051101183, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051101184, 1051101687, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051101688, 1051101727, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051101728, 1051102159, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051102160, 1051102207, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051102208, 1051102703, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051102704, 1051103231, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051103232, 1051103239, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051103240, 1051107335, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051107336, 1051107359, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051107360, 1051107407, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051107408, 1051107839, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051107840, 1051115519, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051115520, 1051125255, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051125256, 1051125759, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051125760, 1051131903, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051131904, 1051197439, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1051197440, 1051213823, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1051213824, 1051230207, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1051230208, 1051238399, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1051238400, 1051246591, 'GE', 'GEO', 'GEORGIA');
INSERT INTO `partners_countryFlag` VALUES (1051246592, 1051254783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1051254784, 1051262975, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1051262976, 1051271167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1051271168, 1051279359, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1051279360, 1051295743, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1051295744, 1051303935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051303936, 1051312127, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1051312128, 1051328511, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1051328512, 1051460095, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051460096, 1051460351, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1051460352, 1051460639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051460640, 1051460647, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1051460648, 1051461631, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051461632, 1051465727, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051465728, 1051470711, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051470712, 1051479071, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051479072, 1051479167, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051479168, 1051484383, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051484384, 1051485247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051485248, 1051485315, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051485316, 1051486271, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486272, 1051486287, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486288, 1051486375, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486376, 1051486431, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486432, 1051486539, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486540, 1051486571, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486572, 1051486847, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051486848, 1051487223, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487224, 1051487311, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487312, 1051487583, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487584, 1051487599, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487600, 1051487611, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487612, 1051487647, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487648, 1051487675, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487676, 1051487723, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487724, 1051487871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051487872, 1051490871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051490872, 1051491455, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051491456, 1051493591, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051493592, 1051494191, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051494192, 1051494391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051494392, 1051495135, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051495136, 1051495327, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051495328, 1051495407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051495408, 1051495759, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051495760, 1051496959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051496960, 1051500563, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051500564, 1051500695, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051500696, 1051500707, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051500708, 1051500715, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051500716, 1051500731, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051500732, 1051501091, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051501092, 1051501155, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051501156, 1051501247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051501248, 1051501407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051501408, 1051501471, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051501472, 1051501503, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051501504, 1051506943, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051506944, 1051512191, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051512192, 1051512871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051512872, 1051514879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051514880, 1051515955, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051515956, 1051516115, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516116, 1051516211, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516212, 1051516275, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516276, 1051516343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516344, 1051516371, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516372, 1051516403, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516404, 1051516447, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516448, 1051516467, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516468, 1051516499, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516500, 1051516531, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516532, 1051516623, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516624, 1051516879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051516880, 1051525119, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051525120, 1051533311, 'MT', 'MLT', 'MALTA');
INSERT INTO `partners_countryFlag` VALUES (1051533312, 1051541503, 'NG', 'NGA', 'NIGERIA');
INSERT INTO `partners_countryFlag` VALUES (1051541504, 1051557887, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051557888, 1051566079, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051566080, 1051574271, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1051574272, 1051578363, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051578364, 1051578367, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1051578368, 1051579647, 'SZ', 'SWZ', 'SWAZILAND');
INSERT INTO `partners_countryFlag` VALUES (1051579648, 1051579775, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051579776, 1051580223, 'SZ', 'SWZ', 'SWAZILAND');
INSERT INTO `partners_countryFlag` VALUES (1051580224, 1051580255, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051580256, 1051580415, 'SZ', 'SWZ', 'SWAZILAND');
INSERT INTO `partners_countryFlag` VALUES (1051580416, 1051589631, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051589632, 1051590655, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1051590656, 1051721727, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1051721728, 1051729919, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1051729920, 1051738111, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1051738112, 1051754495, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1051754496, 1051762687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1051762688, 1051770879, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1051770880, 1051779071, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051779072, 1051787263, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1051787264, 1051795455, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1051795456, 1051803647, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1051803648, 1051820031, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1051820032, 1051852799, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1051852800, 1051918335, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051918336, 1051918847, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1051918848, 1051919359, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051919360, 1051926527, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1051926528, 1051951103, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051951104, 1051951615, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051951616, 1051951871, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051951872, 1051952127, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051952128, 1051952383, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051952384, 1051952895, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051952896, 1051953151, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051953152, 1051953663, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051953664, 1051953919, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051953920, 1051954175, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051954176, 1051954943, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051954944, 1051956735, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051956736, 1051957503, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051957504, 1051959039, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051959040, 1051959295, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051959296, 1051960575, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051960576, 1051960831, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051960832, 1051961087, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051961088, 1051962367, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051962368, 1051962623, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051962624, 1051962879, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051962880, 1051963135, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051963136, 1051963647, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051963648, 1051964159, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051964160, 1051964415, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051964416, 1051966207, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051966208, 1051966463, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051966464, 1051966719, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051966720, 1051967231, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051967232, 1051967487, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1051967488, 1051983871, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1051983872, 1052049407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052049408, 1052057599, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1052057600, 1052065791, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1052065792, 1052082175, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052082176, 1052090367, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052090368, 1052098559, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1052098560, 1052114943, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052114944, 1052180479, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052180480, 1052213247, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1052213248, 1052246015, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1052246016, 1052247039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052247040, 1052247295, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052247296, 1052247359, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052247360, 1052247391, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052247392, 1052247407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052247408, 1052247415, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052247416, 1052247423, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052247424, 1052247551, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052247552, 1052248095, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052248096, 1052248127, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052248128, 1052248135, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052248136, 1052248143, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052248144, 1052248151, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052248160, 1052249375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052249376, 1052249407, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052249408, 1052249471, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052249472, 1052249503, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052249504, 1052250655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052250656, 1052250687, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052250688, 1052250719, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1052250720, 1052250735, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052250736, 1052250751, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052250752, 1052252863, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052252864, 1052252879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052252880, 1052252895, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052252896, 1052252927, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052252928, 1052254207, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052254208, 1052255255, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052255256, 1052255263, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052255264, 1052255871, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052255872, 1052255935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052255936, 1052257279, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052257280, 1052257543, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052257552, 1052257591, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052257600, 1052257663, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052257792, 1052258047, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052258304, 1052260623, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052260624, 1052260631, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052260632, 1052260639, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052260640, 1052260735, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052260736, 1052260863, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052260864, 1052260895, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1052260896, 1052261055, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052261056, 1052261119, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052261120, 1052262399, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052262400, 1052263423, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052263424, 1052263935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052263936, 1052264447, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052264448, 1052264639, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052264640, 1052264703, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052264704, 1052265471, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052265472, 1052265519, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052265520, 1052265535, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052265536, 1052265599, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052265600, 1052265687, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052265696, 1052266495, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052266496, 1052268543, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052268544, 1052268607, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052268608, 1052268671, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052268672, 1052268703, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052268704, 1052268719, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052268720, 1052268735, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052268736, 1052268799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052268800, 1052270591, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052270592, 1052271871, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052271872, 1052272127, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052272128, 1052272543, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052272544, 1052272575, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052272576, 1052272639, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052272640, 1052274175, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052274176, 1052274687, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052274688, 1052274943, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052274944, 1052275199, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052275200, 1052275711, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052275712, 1052276735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052276736, 1052277207, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052277216, 1052278207, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052278208, 1052278271, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052278272, 1052278783, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052278784, 1052278823, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052278824, 1052278831, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052278832, 1052278847, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052278848, 1052278863, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052278864, 1052278879, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052278880, 1052286975, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052286976, 1052287487, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052287488, 1052288255, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052288288, 1052288295, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1052288296, 1052288303, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052288304, 1052288319, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052288384, 1052288511, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052288512, 1052288711, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052288768, 1052289023, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052289024, 1052289151, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052289152, 1052289183, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052289184, 1052289215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052289216, 1052289279, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052289536, 1052290047, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052290048, 1052290063, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052290064, 1052290303, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052290304, 1052290399, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052290400, 1052290431, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052290432, 1052290559, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052290560, 1052290575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052290576, 1052290591, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052290592, 1052290639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052290640, 1052290655, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052290656, 1052290687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052290688, 1052290815, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052290816, 1052290831, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052290832, 1052291327, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052291328, 1052291583, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052291584, 1052291679, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1052291680, 1052291687, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1052291688, 1052291695, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052291696, 1052291711, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052291712, 1052292095, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052292096, 1052303359, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052303360, 1052307455, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052307456, 1052309247, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052309248, 1052309503, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052309504, 1052310527, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052310528, 1052310783, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052310784, 1052311039, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052311040, 1052311551, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052311552, 1052311615, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052311616, 1052311679, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052311680, 1052311871, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052311872, 1052311895, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052311896, 1052311903, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052311904, 1052311935, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052311936, 1052311967, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052311968, 1052311999, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052312000, 1052312063, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052312064, 1052312767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052312768, 1052312831, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052312832, 1052312895, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052312896, 1052312903, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052312904, 1052312911, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052312912, 1052312927, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052312928, 1052313087, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052313088, 1052314751, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052314752, 1052314815, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052314816, 1052314823, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052314824, 1052314831, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052314832, 1052314847, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052314848, 1052315071, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052315072, 1052315103, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052315104, 1052315135, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052315136, 1052315551, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052315552, 1052315583, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052315584, 1052315647, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052315648, 1052316319, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052316320, 1052316335, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052316336, 1052316767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052316768, 1052316799, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052316800, 1052317599, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052317600, 1052317607, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052317608, 1052317615, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052317616, 1052317631, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052317632, 1052317663, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052317664, 1052318047, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052318048, 1052318079, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052318080, 1052318207, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052318208, 1052319743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052319744, 1052320079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052320080, 1052320087, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1052320088, 1052320095, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052320096, 1052320127, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052320128, 1052320255, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052320256, 1052322239, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052322240, 1052322303, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052322304, 1052323871, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052323872, 1052323903, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052323904, 1052324927, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052324928, 1052324943, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052324944, 1052324959, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052324960, 1052324991, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052324992, 1052325191, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052325192, 1052325199, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052325200, 1052325215, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052325216, 1052325247, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052325248, 1052325311, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052325312, 1052325375, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052325376, 1052325567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052325568, 1052325631, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052325632, 1052327935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052327936, 1052328223, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052328224, 1052328255, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052328256, 1052328319, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052328320, 1052328447, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052328448, 1052328639, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052328640, 1052328671, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052328672, 1052328703, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052328704, 1052329983, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052330240, 1052331167, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052331168, 1052331183, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052331184, 1052331199, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052331200, 1052331263, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052331392, 1052331615, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052331616, 1052331647, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052331648, 1052331711, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052331712, 1052331743, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052331744, 1052332031, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052332032, 1052333103, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052333104, 1052333119, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052333120, 1052333183, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052333184, 1052333311, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052333312, 1052334751, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052334752, 1052334759, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052334760, 1052334767, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052334768, 1052334815, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052334816, 1052334847, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052334848, 1052335423, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052335424, 1052335455, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052335456, 1052335519, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052335520, 1052335535, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052335536, 1052335551, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052335552, 1052335615, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052335616, 1052336127, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052336128, 1052336255, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052336256, 1052336383, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052336384, 1052337343, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052337344, 1052337375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052337376, 1052337759, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052337760, 1052337887, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052337888, 1052337903, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052337904, 1052337911, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052337912, 1052337919, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052337920, 1052340111, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052340112, 1052340127, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052340128, 1052340135, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052340136, 1052340223, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052340224, 1052340527, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052340528, 1052340543, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052340544, 1052340575, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052340576, 1052340607, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052340608, 1052340671, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1052340672, 1052340703, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052340704, 1052340719, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052340720, 1052340735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052340736, 1052340767, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052340768, 1052340799, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052340800, 1052340863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052340864, 1052342271, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052342272, 1052342303, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052342304, 1052342335, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052342336, 1052342463, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052342464, 1052342471, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052342472, 1052342479, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052342480, 1052342495, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052342496, 1052342527, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052342528, 1052343647, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052343648, 1052343655, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052343656, 1052343663, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052343664, 1052343679, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052343680, 1052344319, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052344320, 1052344863, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052344864, 1052344895, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052344896, 1052344959, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052344960, 1052345087, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052345088, 1052345135, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052345136, 1052345151, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052345152, 1052345247, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052345248, 1052345279, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052345280, 1052345343, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052345344, 1052345503, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052345504, 1052345535, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052345536, 1052345551, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052345552, 1052345567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052345568, 1052345631, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052345632, 1052345663, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052345664, 1052345695, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1052345696, 1052345727, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1052345728, 1052345855, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052345856, 1052346903, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052346904, 1052346911, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052346912, 1052346943, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052346944, 1052347007, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052347008, 1052347135, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052347136, 1052347391, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052347392, 1052348415, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052348416, 1052348799, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052348800, 1052348831, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052348832, 1052348863, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052348864, 1052348879, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052348880, 1052348895, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052348896, 1052348927, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052348928, 1052349119, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052349120, 1052349151, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052349152, 1052349343, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052349344, 1052349375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052349376, 1052349407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052349408, 1052349439, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052349440, 1052352559, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052352560, 1052352591, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052352592, 1052352607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052352640, 1052352703, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052352704, 1052352767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052352768, 1052352927, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052352928, 1052352959, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052352960, 1052352991, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052352992, 1052353023, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052353024, 1052353279, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052353280, 1052354111, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052354112, 1052354175, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1052354176, 1052354559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052354560, 1052356607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052356608, 1052356703, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052356704, 1052356735, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052356736, 1052356799, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1052356800, 1052356863, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052356864, 1052358479, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052358480, 1052358495, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052358496, 1052358511, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052358512, 1052358527, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052358528, 1052358655, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052358656, 1052359839, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052359840, 1052359871, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052359872, 1052359935, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052359936, 1052360735, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052360736, 1052360743, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052360744, 1052360767, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052360768, 1052360783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052360784, 1052360831, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052360832, 1052360959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052360960, 1052360991, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052360992, 1052361023, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052361024, 1052361039, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052361040, 1052361055, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052361056, 1052361087, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052361088, 1052361151, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052361152, 1052361215, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052361216, 1052361471, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052361472, 1052361647, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052361648, 1052361655, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052361656, 1052361663, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052361664, 1052361695, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052361696, 1052361727, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052361728, 1052361919, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052361920, 1052361951, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052361952, 1052361967, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052361968, 1052361983, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052361984, 1052362239, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052362240, 1052362751, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052362752, 1052362783, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052362784, 1052362815, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052362816, 1052362879, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052362880, 1052363039, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052363072, 1052363135, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052363136, 1052363263, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052363264, 1052364543, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052364544, 1052364671, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052364672, 1052364687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052364688, 1052364695, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052364696, 1052364703, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052364704, 1052364799, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052364800, 1052366207, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052366208, 1052366271, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052366272, 1052366335, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052366336, 1052366655, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052366656, 1052366719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052366720, 1052367871, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052367872, 1052368895, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052368896, 1052369023, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052369024, 1052369039, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052369040, 1052369055, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052369056, 1052369087, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052369088, 1052369151, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052369152, 1052369407, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052369408, 1052369663, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1052369664, 1052369855, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1052369920, 1052370175, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052370176, 1052370431, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052370432, 1052370559, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052370560, 1052370623, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052370624, 1052370687, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052370688, 1052370943, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052370944, 1052372255, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052372256, 1052372287, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052372288, 1052372351, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1052372352, 1052374015, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052374016, 1052375039, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052375040, 1052375711, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052375712, 1052375807, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052375808, 1052376831, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052376832, 1052377087, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052377088, 1052377535, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052377536, 1052377599, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052377600, 1052377743, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052377744, 1052377759, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052377760, 1052377791, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052377792, 1052377855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052377856, 1052377871, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052377872, 1052377887, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052377888, 1052377951, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052377952, 1052377983, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052377984, 1052378047, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052378048, 1052378079, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052378080, 1052378111, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052378112, 1052378983, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052378984, 1052378991, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052378992, 1052379031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052379032, 1052379039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052379040, 1052379103, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052379104, 1052379135, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052379136, 1052379791, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052379792, 1052379799, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052379800, 1052379807, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052379808, 1052379839, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052379840, 1052379903, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052379904, 1052380063, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052380064, 1052380127, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052380128, 1052380159, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052380160, 1052382623, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052382656, 1052382719, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052382720, 1052382975, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052382976, 1052383999, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052384000, 1052384255, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052384256, 1052385615, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052385616, 1052385631, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052385632, 1052385695, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052385696, 1052385791, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052385792, 1052388863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052388864, 1052389119, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052389120, 1052390431, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052390432, 1052390447, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052390448, 1052390455, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052390456, 1052390463, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052390464, 1052393471, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052393472, 1052393599, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052393600, 1052393695, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052393696, 1052394271, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052394272, 1052394303, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052394304, 1052394367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052394368, 1052395263, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052395264, 1052395679, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052395680, 1052395743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052395744, 1052395775, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052395776, 1052396031, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052396032, 1052396543, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052396544, 1052396607, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052396608, 1052396671, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052396672, 1052396799, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052396800, 1052396863, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1052396864, 1052396927, 'RO', 'ROM', 'ROMANIA');
INSERT INTO `partners_countryFlag` VALUES (1052396928, 1052397439, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1052397568, 1052399039, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052399040, 1052399103, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052399104, 1052399903, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052399904, 1052399919, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052399920, 1052399927, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052399928, 1052399935, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052399936, 1052399999, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052400000, 1052400127, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052400128, 1052401151, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052401152, 1052401279, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052401280, 1052401311, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052401312, 1052401343, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052401344, 1052401407, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052401408, 1052401599, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052401600, 1052401631, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052401632, 1052401663, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1052401664, 1052402047, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052402048, 1052402175, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052402176, 1052402271, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052402272, 1052402303, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052402304, 1052402367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052402368, 1052403359, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052403360, 1052403391, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052403392, 1052403407, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052403408, 1052403415, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052403416, 1052403423, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052403424, 1052403455, 'RO', 'ROM', 'ROMANIA');
INSERT INTO `partners_countryFlag` VALUES (1052403456, 1052403727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052403728, 1052403743, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052403744, 1052403775, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052403776, 1052403839, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052403840, 1052403967, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052403968, 1052404383, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052404384, 1052404399, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052404400, 1052404447, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052404448, 1052404479, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052404480, 1052404767, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052404768, 1052404783, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052404784, 1052404799, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052404800, 1052404863, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052404864, 1052404991, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052404992, 1052405759, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052405760, 1052407519, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052407520, 1052407535, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052407536, 1052407551, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052407552, 1052407839, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052407840, 1052407871, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052407872, 1052407887, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052407888, 1052407903, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052407904, 1052407935, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052407936, 1052408159, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052408160, 1052408383, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052408384, 1052408447, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052408448, 1052408511, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052408512, 1052408575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052408576, 1052408831, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052408832, 1052409855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052409856, 1052409863, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052409864, 1052409871, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052409872, 1052409951, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052409952, 1052409983, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052409984, 1052410047, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052410048, 1052410111, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052410112, 1052412343, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052412344, 1052412351, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052412352, 1052412415, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052412416, 1052412831, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052412832, 1052412863, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052412864, 1052413951, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052413952, 1052414335, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1052414464, 1052414975, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052414976, 1052415999, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052416000, 1052416575, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052416576, 1052416639, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052416640, 1052416671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052416672, 1052416703, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052416704, 1052416735, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052416736, 1052416767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052416768, 1052417071, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052417072, 1052417087, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052417088, 1052417119, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052417120, 1052417151, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052417152, 1052417279, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052417280, 1052417359, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052417368, 1052417535, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052417536, 1052418047, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052418048, 1052419583, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052419584, 1052420031, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052420064, 1052420095, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052420096, 1052420735, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052420736, 1052420767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052420768, 1052420783, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052420784, 1052420799, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052420800, 1052420863, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052420864, 1052422143, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052422144, 1052422847, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052422848, 1052422863, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052422864, 1052422879, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052422880, 1052423199, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052423200, 1052423231, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052423232, 1052423295, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052423296, 1052423327, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052423360, 1052423423, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052423424, 1052423967, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052424000, 1052424799, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052424800, 1052424815, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052424816, 1052424823, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052424824, 1052424831, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052424832, 1052424959, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052424960, 1052425151, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052425152, 1052425215, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052425216, 1052426239, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052426240, 1052426319, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1052426328, 1052426495, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1052427264, 1052427839, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052427840, 1052427855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052427856, 1052427871, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052427872, 1052427903, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052427904, 1052427967, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052427968, 1052428031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052428032, 1052428287, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052428288, 1052428479, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052428480, 1052428543, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052428544, 1052429407, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052429408, 1052429439, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052429440, 1052429567, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052429568, 1052429759, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052429760, 1052429823, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052429824, 1052430335, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052430336, 1052430407, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052430408, 1052430415, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052430416, 1052430431, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052430432, 1052430463, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052430464, 1052430527, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052430528, 1052430591, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052430592, 1052433407, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052433408, 1052433719, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052433720, 1052433727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052433728, 1052433919, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052433920, 1052434431, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052434432, 1052434751, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052434752, 1052434783, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052434784, 1052435455, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052435456, 1052435647, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052435680, 1052436479, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052436480, 1052437023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052437024, 1052437055, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052437056, 1052437119, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052437120, 1052437135, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052437136, 1052437151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052437152, 1052437183, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052437184, 1052437247, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052437248, 1052437759, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052437760, 1052438015, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052438016, 1052438527, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052438528, 1052439551, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052439552, 1052440575, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052440576, 1052441343, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052441600, 1052442623, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052442624, 1052443647, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052445696, 1052446719, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052446720, 1052447487, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1052447744, 1052447871, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1052448256, 1052450815, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052450816, 1052451711, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052451840, 1052452351, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052452352, 1052452799, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052452808, 1052452815, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052452992, 1052452999, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1052453120, 1052453375, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052453376, 1052453887, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052453888, 1052454911, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052456960, 1052457983, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052457984, 1052458367, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052458496, 1052458847, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052458880, 1052460031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052460032, 1052460127, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052460544, 1052460799, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1052461056, 1052461295, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052461296, 1052461311, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052461312, 1052463103, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052463104, 1052463615, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052463616, 1052464639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052464640, 1052464927, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052465152, 1052465175, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052465184, 1052465223, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052465232, 1052465279, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052465408, 1052465663, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052466176, 1052466431, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052466432, 1052468223, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052468224, 1052469247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052469248, 1052470271, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052470272, 1052470783, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1052470784, 1052471007, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052471040, 1052471295, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052471296, 1052475231, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052475240, 1052475391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052475392, 1052476383, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052476416, 1052479487, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052479488, 1052483583, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052483584, 1052483999, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052484032, 1052485279, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052485312, 1052485631, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052485632, 1052486655, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052486912, 1052487167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052487680, 1052488703, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1052488704, 1052489727, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052489728, 1052490239, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052490240, 1052490751, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1052490752, 1052491775, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1052491776, 1052494335, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052494336, 1052494591, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052494592, 1052495095, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052495104, 1052495439, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052495616, 1052495871, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052495872, 1052495879, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1052496128, 1052496383, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052496896, 1052497919, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052497920, 1052498431, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1052498432, 1052498463, 'RO', 'ROM', 'ROMANIA');
INSERT INTO `partners_countryFlag` VALUES (1052498944, 1052499967, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052499968, 1052500191, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052500208, 1052500223, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1052500480, 1052500687, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052500736, 1052500991, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052500992, 1052501023, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1052501120, 1052501247, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1052502016, 1052502783, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052502816, 1052502847, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1052503040, 1052504319, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052504320, 1052504351, 'BY', 'BLR', 'BELARUS');
INSERT INTO `partners_countryFlag` VALUES (1052504384, 1052573695, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052573696, 1052639231, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052639232, 1052684575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052684576, 1052684607, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1052684608, 1052685247, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052685248, 1052686031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052686032, 1052686367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052686368, 1052686463, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052686464, 1052686591, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052686592, 1052686783, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052686784, 1052686887, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052686888, 1052687471, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052687472, 1052688639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052688640, 1052689407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052689408, 1052689431, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052689432, 1052690175, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052690176, 1052704767, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052704768, 1052770303, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052770304, 1052771327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052771328, 1052771391, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1052771392, 1052771455, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052771456, 1052772959, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052772960, 1052773023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052773024, 1052773631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052773632, 1052775167, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052775168, 1052775727, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052775728, 1052775767, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052775768, 1052775791, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052775792, 1052775903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052775904, 1052777215, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052777216, 1052778495, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052778496, 1052786687, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052786688, 1052795327, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052795328, 1052795331, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1052795332, 1052795359, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052795360, 1052795371, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052795372, 1052795903, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052795904, 1052795967, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052795968, 1052796959, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052796960, 1052796975, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052796976, 1052798079, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052798080, 1052798111, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052798112, 1052798207, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052798208, 1052798335, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052798336, 1052798975, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052798976, 1052799231, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052799232, 1052799455, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052799456, 1052801535, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052801536, 1052801655, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052801656, 1052802047, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802048, 1052802151, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802152, 1052802383, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802384, 1052802447, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802448, 1052802479, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802480, 1052802559, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802560, 1052802799, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052802800, 1052803071, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1052803072, 1052811263, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052811264, 1052819455, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1052819456, 1052827647, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1052827648, 1052835839, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1052835840, 1052844031, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1052844032, 1052852223, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052852224, 1052868607, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1052868608, 1052876799, 'YU', 'YUG', 'YUGOSLAVIA');
INSERT INTO `partners_countryFlag` VALUES (1052876800, 1052884991, 'NG', 'NGA', 'NIGERIA');
INSERT INTO `partners_countryFlag` VALUES (1052884992, 1052901375, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1052901376, 1053032447, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053032448, 1053097983, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1053097984, 1053106175, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1053106176, 1053114367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1053114368, 1053130751, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1053130752, 1053138943, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053138944, 1053147135, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053147136, 1053163519, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1053163520, 1053294591, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1053294592, 1053295487, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1053295616, 1053296639, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1053296640, 1053297055, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1053297072, 1053297407, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1053297664, 1053297759, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1053298176, 1053299199, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1053300736, 1053300991, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1053300992, 1053301343, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053301376, 1053301759, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053305088, 1053305951, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1053306112, 1053306367, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1053308928, 1053309023, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053309184, 1053309951, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053311232, 1053311359, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1053312000, 1053312511, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1053315072, 1053317119, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1053317120, 1053317375, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053317376, 1053317631, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1053318144, 1053318655, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1053318656, 1053318935, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053318944, 1053319031, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053319040, 1053319167, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053319424, 1053320319, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1053326848, 1053327103, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053327104, 1053327359, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1053327616, 1053329023, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053329152, 1053329279, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053329408, 1053329471, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1053330432, 1053330687, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1053331456, 1053331591, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053331600, 1053331647, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053331712, 1053331839, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053332224, 1053332351, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053332992, 1053334015, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1053334016, 1053334143, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1053334272, 1053334527, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1053334528, 1053334783, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1053335552, 1053336703, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053336832, 1053337183, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053337344, 1053337599, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053337600, 1053337615, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1053338112, 1053338623, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053338624, 1053338983, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1053338992, 1053339623, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1053339632, 1053339647, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1053339648, 1053340159, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1053340160, 1053340415, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053340672, 1053341183, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1053343744, 1053344255, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1053344512, 1053344767, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1053345280, 1053345375, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1053345408, 1053345471, 'PK', 'PAK', 'PAKISTAN');
INSERT INTO `partners_countryFlag` VALUES (1053345536, 1053345575, 'SI', 'SVN', 'SLOVENIA');
INSERT INTO `partners_countryFlag` VALUES (1053345792, 1053346815, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1053346816, 1053348607, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053348640, 1053348671, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1053348736, 1053348863, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1053349120, 1053349887, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053349888, 1053350399, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1053350400, 1053350527, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1053352192, 1053352447, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1053360128, 1053368319, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1053368320, 1053376511, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1053376512, 1053392895, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1053392896, 1053401087, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053401088, 1053409279, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1053409280, 1053425663, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1053425664, 1053556735, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1053556736, 1053564927, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1053564928, 1053573119, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1053573120, 1053581311, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053581312, 1053589503, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1053589504, 1053597695, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1053605888, 1053614079, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1053622272, 1053630463, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1053638656, 1053655039, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1053655040, 1053663231, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1053663232, 1053671423, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1053671424, 1053687807, 'LV', 'LVA', 'LATVIA');
INSERT INTO `partners_countryFlag` VALUES (1053687808, 1053753343, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1053753344, 1053818879, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1053818880, 1053884415, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1053884416, 1053892607, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1053900800, 1053917183, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1053917184, 1053925375, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1053925376, 1053933567, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1053933568, 1053949951, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1053949952, 1053984415, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984416, 1053984447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1053984448, 1053984463, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984464, 1053984591, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984592, 1053984671, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984672, 1053984735, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984736, 1053984767, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984768, 1053984895, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053984896, 1053985039, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985040, 1053985135, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985136, 1053985175, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985176, 1053985263, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985264, 1053985551, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985552, 1053985631, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985632, 1053985727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985728, 1053985759, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053985760, 1053986047, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053986048, 1053986127, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053986128, 1053986159, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053986160, 1053986207, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053986208, 1053986815, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053986816, 1053986879, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053986880, 1053987583, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053987584, 1053987775, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053987776, 1053987839, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053987840, 1053988351, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053988352, 1053988399, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053988400, 1053988439, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053988440, 1053988575, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053988576, 1053989439, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989440, 1053989567, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989568, 1053989599, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989600, 1053989631, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989632, 1053989903, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989904, 1053989935, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989936, 1053989983, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053989984, 1053990143, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053990144, 1053990463, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053990464, 1053990535, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053990536, 1053990567, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053990568, 1053990911, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053990912, 1053991423, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053991424, 1053991615, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053991616, 1053991679, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053991680, 1053991775, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053991776, 1053991839, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053991840, 1053991935, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053991936, 1053992175, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053992176, 1053992959, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053992960, 1053992983, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053992984, 1053993071, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053993072, 1053993215, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053993216, 1053993727, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053993728, 1053993855, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053993856, 1053993919, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053993920, 1053994495, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053994496, 1053994623, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053994624, 1053994688, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053994689, 1053994743, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053994744, 1053994895, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053994896, 1053995007, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053995008, 1053995199, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053995200, 1053995263, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053995264, 1053998847, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053998848, 1053998912, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053998913, 1053999039, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1053999040, 1054003199, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054003200, 1054004991, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054004992, 1054007807, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054007808, 1054009087, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054009088, 1054015487, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054015488, 1054089215, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1054089216, 1054097407, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1054097408, 1054100575, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054100576, 1054100607, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1054100608, 1054101343, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054101344, 1054101375, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1054101376, 1054101631, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054101632, 1054102207, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054102208, 1054102271, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054102272, 1054105599, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054105600, 1054113791, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054113792, 1054121983, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054130176, 1054138367, 'LT', 'LTU', 'LITHUANIA');
INSERT INTO `partners_countryFlag` VALUES (1054146560, 1054154751, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1054162944, 1054179327, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1054179328, 1054187519, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054187520, 1054195711, 'BG', 'BGR', 'BULGARIA');
INSERT INTO `partners_countryFlag` VALUES (1054195712, 1054212095, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1054212096, 1054277631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054277632, 1054343167, 'KW', 'KWT', 'KUWAIT');
INSERT INTO `partners_countryFlag` VALUES (1054343168, 1054351359, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054351360, 1054359551, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1054359552, 1054367743, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054367744, 1054375935, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1054375936, 1054380287, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054380288, 1054380303, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1054380304, 1054380543, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054380544, 1054381311, 'GI', 'GIB', 'GIBRALTAR');
INSERT INTO `partners_countryFlag` VALUES (1054381312, 1054381567, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1054381568, 1054381823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054381824, 1054381855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054381856, 1054382079, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054382080, 1054382335, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054382336, 1054382591, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1054382592, 1054384127, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054392320, 1054400511, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054408704, 1054416895, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1054425088, 1054441471, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1054441472, 1054449663, 'AZ', 'AZE', 'AZERBAIJAN');
INSERT INTO `partners_countryFlag` VALUES (1054449664, 1054457855, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1054457856, 1054474239, 'RO', 'ROM', 'ROMANIA');
INSERT INTO `partners_countryFlag` VALUES (1054474240, 1054539775, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1054539776, 1054605311, 'IL', 'ISR', 'ISRAEL');
INSERT INTO `partners_countryFlag` VALUES (1054605312, 1054613503, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054613504, 1054629887, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1054629888, 1054638079, 'IR', 'IRN', 'ISLAMIC REPUBLIC OF IRAN');
INSERT INTO `partners_countryFlag` VALUES (1054638080, 1054646271, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1054654464, 1054662655, 'MK', 'MKD', 'THE FORMER YUGOSLAV REPUBLIC OF MACEDONIA');
INSERT INTO `partners_countryFlag` VALUES (1054670848, 1054671103, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054671104, 1054672319, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054672320, 1054672335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1054672336, 1054672479, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054672480, 1054672575, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054672576, 1054672607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054672608, 1054672655, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054672656, 1054672695, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054672696, 1054672823, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054672824, 1054673087, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054673088, 1054673407, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054673408, 1054673535, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054673536, 1054673727, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054673728, 1054674079, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054674080, 1054674175, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054674176, 1054674439, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054674440, 1054674455, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054674456, 1054674503, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054674504, 1054675711, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054675712, 1054678783, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054678784, 1054679039, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1054687232, 1054703615, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1054703616, 1054719999, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1054720000, 1054736383, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054736384, 1054737407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054737408, 1054752703, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054752704, 1054834687, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1054834688, 1054835199, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054835200, 1054863615, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1054863616, 1054864128, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1054864129, 1054864383, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1054864384, 1054864895, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054864896, 1054865407, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1054865408, 1054865920, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1054865921, 1054866943, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1054866944, 1054867199, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054867200, 1054867455, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1054867456, 1054949519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054949520, 1054949527, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1054949528, 1054949807, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054949808, 1054949815, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1054949816, 1054951983, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054951984, 1054952319, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054952320, 1054952391, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054952392, 1054953087, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054953088, 1054958335, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054958336, 1054959151, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054959152, 1054959487, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054959488, 1054960423, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054960424, 1054961631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054961632, 1054963327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054963328, 1054963415, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054963416, 1054963607, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054963608, 1054967295, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054967296, 1054967311, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054967312, 1054969039, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054969040, 1054970639, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054970640, 1054970735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054970736, 1054970807, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054970808, 1054971199, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054971200, 1054973543, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054973544, 1054973551, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1054973552, 1054973575, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054973576, 1054973591, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054973592, 1054977439, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054977440, 1054978071, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054978072, 1054978559, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054978560, 1054978743, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054978744, 1054979519, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054979520, 1054981375, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1054981376, 1055129599, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1055196160, 1055197823, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1055197920, 1055198463, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1055198976, 1055199103, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1055199360, 1055199375, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1055199464, 1055199487, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1055200416, 1055200423, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055203328, 1055203359, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055203392, 1055203455, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055203840, 1055204095, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055204608, 1055205375, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055205632, 1055205887, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055206656, 1055207423, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055207680, 1055210239, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055210496, 1055210751, 'SK', 'SVK', 'SLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055211264, 1055211519, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055212044, 1055212179, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055212184, 1055212247, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055212352, 1055212415, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055212544, 1055212799, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055213056, 1055213319, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055213328, 1055213359, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055213368, 1055213455, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055213472, 1055213567, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055213824, 1055214239, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055214272, 1055214847, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055215360, 1055215999, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055216032, 1055216383, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055216896, 1055217663, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218208, 1055218239, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218272, 1055218299, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218352, 1055218383, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218392, 1055218399, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218432, 1055218447, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218464, 1055218471, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055218480, 1055219711, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1055219968, 1055219975, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055220224, 1055220287, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055220352, 1055220399, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055220736, 1055221247, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055221504, 1055221631, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1055221760, 1055222015, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055222528, 1055223807, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055223808, 1055223839, 'LU', 'LUX', 'LUXEMBOURG');
INSERT INTO `partners_countryFlag` VALUES (1055223872, 1055223999, 'LU', 'LUX', 'LUXEMBOURG');
INSERT INTO `partners_countryFlag` VALUES (1055224064, 1055224463, 'LU', 'LUX', 'LUXEMBOURG');
INSERT INTO `partners_countryFlag` VALUES (1055224576, 1055224607, 'LU', 'LUX', 'LUXEMBOURG');
INSERT INTO `partners_countryFlag` VALUES (1055224832, 1055224911, 'LU', 'LUX', 'LUXEMBOURG');
INSERT INTO `partners_countryFlag` VALUES (1055226112, 1055226175, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055226192, 1055226207, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055226240, 1055226255, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055226264, 1055226271, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055226368, 1055226399, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055227904, 1055228159, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1055228416, 1055229183, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1055232000, 1055232255, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055232512, 1055233535, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055233792, 1055234047, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055234064, 1055234079, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055234080, 1055234127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1055234560, 1055235071, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055240192, 1055240703, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1055241984, 1055242239, 'GR', 'GRC', 'GREECE');
INSERT INTO `partners_countryFlag` VALUES (1055245312, 1055246591, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055247360, 1055247615, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1055252736, 1055252991, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055256448, 1055256463, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1055260672, 1055326207, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1055326208, 1055334399, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1055342592, 1055358975, 'RO', 'ROM', 'ROMANIA');
INSERT INTO `partners_countryFlag` VALUES (1055358976, 1055367167, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1055375360, 1055391743, 'OM', 'OMN', 'OMAN');
INSERT INTO `partners_countryFlag` VALUES (1055391744, 1055424511, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1055424512, 1055457279, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1055457280, 1055465471, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1055473664, 1055490047, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1055490048, 1055522815, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1055522816, 1055588351, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055588352, 1055653887, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1055653888, 1055784959, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1055784960, 1055850495, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1055850496, 1055916031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1055916032, 1055924223, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1055924224, 1055932415, 'LY', 'LBY', 'LIBYAN ARAB JAMAHIRIYA');
INSERT INTO `partners_countryFlag` VALUES (1055932416, 1055940607, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1055940608, 1055948799, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1055948800, 1055956991, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1055965184, 1055973375, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1055981568, 1055989759, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1055997952, 1056014335, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1056014336, 1056022527, 'EG', 'EGY', 'EGYPT');
INSERT INTO `partners_countryFlag` VALUES (1056022528, 1056030719, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056030720, 1056047103, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1056047104, 1056178175, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1056178176, 1056194559, 'UA', 'UKR', 'UKRAINE');
INSERT INTO `partners_countryFlag` VALUES (1056194560, 1056210943, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1056210944, 1056219135, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1056219136, 1056227327, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056227328, 1056243711, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1056243712, 1056251903, 'MC', 'MCO', 'MONACO');
INSERT INTO `partners_countryFlag` VALUES (1056260096, 1056276479, 'CS', 'CZE', 'CZECHOSLOVAKIA');
INSERT INTO `partners_countryFlag` VALUES (1056276480, 1056374783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1056374784, 1056440319, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1056440320, 1056473087, 'TR', 'TUR', 'TURKEY');
INSERT INTO `partners_countryFlag` VALUES (1056473088, 1056505087, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1056505088, 1056505103, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1056505104, 1056505343, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1056505344, 1056505599, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1056505600, 1056505855, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1056505856, 1056514047, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1056522240, 1056538623, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1056538624, 1056546815, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1056546816, 1056555007, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1056555008, 1056571391, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056571392, 1056669695, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1056669696, 1056702463, 'MA', 'MAR', 'MOROCCO');
INSERT INTO `partners_countryFlag` VALUES (1056702464, 1056767999, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056768000, 1056874559, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056874560, 1056874567, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056874568, 1056874575, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056874576, 1056874583, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056874584, 1056874591, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056874592, 1056874687, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056874688, 1056874863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056874864, 1056874879, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056874880, 1056874975, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056874976, 1056875119, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056875120, 1056875135, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056875136, 1056875151, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056875152, 1056875167, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056875168, 1056875263, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056875264, 1056875327, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056875328, 1056875615, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056875616, 1056875623, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056875624, 1056875631, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056875632, 1056875639, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056875640, 1056875647, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056875648, 1056875679, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056875680, 1056876031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056876032, 1056876055, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056876056, 1056876063, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056876064, 1056876095, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056876096, 1056876191, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056876192, 1056876223, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1056876224, 1056876759, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056876760, 1056877055, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056877056, 1056877375, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056877376, 1056877503, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056877504, 1056877823, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056877824, 1056878591, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056878592, 1056879103, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056879104, 1056879167, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056879168, 1056879359, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056879360, 1056882047, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056882048, 1056882175, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056882176, 1056882943, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056882944, 1056883295, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056883296, 1056883375, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056883376, 1056883679, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056883680, 1056883919, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056883920, 1056884495, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056884496, 1056885487, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056885488, 1056886271, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056886272, 1056886879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056886880, 1056887263, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056887264, 1056889855, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056889856, 1056890175, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056890176, 1056890367, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056890368, 1056890943, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056890944, 1056890984, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056890985, 1056890991, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056890992, 1056891551, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056891552, 1056891783, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056891784, 1056892927, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056892928, 1056894463, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056894464, 1056896091, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056896092, 1056896607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056896608, 1056896671, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056896672, 1056899071, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056899072, 1056964607, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1056964608, 1063895039, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1063895040, 1063899135, 'KR', 'KOR', 'KOREA REPUBLIC OF');
INSERT INTO `partners_countryFlag` VALUES (1063899136, 1065353215, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1065353216, 1065713663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1065746432, 1065779199, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1065877504, 1066008575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1066008576, 1066139647, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1066139648, 1072922623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1072922624, 1072955391, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1072955392, 1073037311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073053696, 1073070079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073086464, 1073090559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073094656, 1073098751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073102848, 1073115135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073119232, 1073147903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073152000, 1073164287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073168384, 1073172479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073176576, 1073180671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073184768, 1073188863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073192960, 1073205247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073209344, 1073291263, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073299456, 1073311743, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073315840, 1073373183, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073373184, 1073377279, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1073381376, 1073381631, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1073381632, 1073382399, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1073382400, 1073397759, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073397760, 1073405951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1073414144, 1074020351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074020352, 1074028543, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1074028544, 1074118655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074118656, 1074135039, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1074135040, 1074147327, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074151424, 1074163711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074167808, 1074233343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074233344, 1074241535, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1074241536, 1074262015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074262016, 1074266111, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1074266112, 1074290687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074298880, 1074388991, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074397184, 1074728959, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074733056, 1074737151, 'AU', 'AUS', 'AUSTRALIA');
INSERT INTO `partners_countryFlag` VALUES (1074741248, 1074745343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074749440, 1074753535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074757632, 1074761727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074765824, 1074778111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074782208, 1074806783, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074819072, 1074823167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074839552, 1074872319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074880512, 1074884607, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074909184, 1074921471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074925568, 1074937855, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074946048, 1074950143, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074962432, 1074966527, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1074978816, 1074982911, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1074987008, 1075011583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075019776, 1075048447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075052544, 1075245055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075249152, 1075392511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075396608, 1075400703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075404800, 1075408895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075412992, 1075417087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075421184, 1075425279, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1075429376, 1075433471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075437568, 1075441663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075445760, 1075478527, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075478528, 1075494911, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1075494912, 1075523583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075527680, 1075556351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075560448, 1075576831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075576832, 1075576839, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075576840, 1075577067, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075577068, 1075577071, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1075577072, 1075577855, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075577856, 1075578111, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1075578112, 1075578623, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075578624, 1075578879, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1075578880, 1075579083, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075579084, 1075579087, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1075579088, 1075579127, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075579128, 1075579135, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1075579136, 1075581263, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075581264, 1075581311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075581312, 1075581495, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075581496, 1075581499, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075581500, 1075583503, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075583504, 1075583519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075583520, 1075583935, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075583936, 1075583967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075583968, 1075584079, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075584080, 1075584095, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075584096, 1075584767, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1075584768, 1075585023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075585024, 1075609599, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075609600, 1075613695, 'TT', 'TTO', 'TRINIDAD AND TOBAGO');
INSERT INTO `partners_countryFlag` VALUES (1075613696, 1075724287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075732480, 1075769343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075773440, 1075789823, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075806208, 1075834879, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1075838976, 1076080639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076084736, 1076088831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076092928, 1076338687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076338688, 1076346879, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1076346880, 1076359167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076363264, 1076387839, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076387840, 1076391935, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1076396032, 1076400127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076404224, 1076408319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076412416, 1076416511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076420608, 1076424703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076428800, 1076543487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076543488, 1076559871, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1076559872, 1076981759, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1076985856, 1077080063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077084160, 1077432319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077436416, 1077444607, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077444608, 1077448703, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1077452800, 1077469183, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077469184, 1077477375, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1077477376, 1077506047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077506048, 1077510143, 'LS', 'LSO', 'LESOTHO');
INSERT INTO `partners_countryFlag` VALUES (1077510144, 1077514239, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077518336, 1077538815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077542912, 1077555199, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077559296, 1077571583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077575680, 1077604351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077608448, 1077624831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077641216, 1077657599, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1077657600, 1077854207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077870592, 1077932031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1077936128, 1078079487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078083584, 1078095871, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078099968, 1078128639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078132736, 1078235135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078239232, 1078251519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078255616, 1078280191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078280192, 1078288383, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1078288384, 1078358015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078362112, 1078407167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078411264, 1078423551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078427648, 1078448127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078452224, 1078456319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078460416, 1078489087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078493184, 1078497279, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078501376, 1078505471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078509568, 1078513663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078517760, 1078521855, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1078525952, 1078583295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078591488, 1078837247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078845440, 1078849535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078853632, 1078931455, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078935552, 1078947839, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078951936, 1078964223, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078968320, 1078980607, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1078984704, 1079226367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079230464, 1079242751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079246848, 1079275519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079279616, 1079320575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079328768, 1079377919, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079377920, 1079443455, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1079443456, 1079476223, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079476224, 1079508991, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1079508992, 1079549951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079574528, 1079611391, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079615488, 1079627775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079631872, 1079635967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079640064, 1079668735, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079672832, 1079676927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079681024, 1079693311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079697408, 1079816191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079836672, 1079861247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1079902208, 1080999935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1080999936, 1081016319, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1081016320, 1081135103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081139200, 1081143295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081147392, 1081192447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081196544, 1081208831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081212928, 1081278463, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1081278464, 1081479167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081483264, 1081487359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081491456, 1081495551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081499648, 1081503743, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081507840, 1081516031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081524224, 1081528319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081532416, 1081544703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081548800, 1081552895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081556992, 1081561087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081565184, 1081573375, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1081573376, 1081585663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081589760, 1081774079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1081802752, 1082048511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082064896, 1082089471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082097664, 1082630143, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082638336, 1082646527, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082654720, 1082679295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082687488, 1082699775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082703872, 1082875903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082884096, 1082908671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082916864, 1082941439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1082982400, 1083011071, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1083047936, 1083064319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083080704, 1083162623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083179008, 1083359231, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083375616, 1083387903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083392000, 1083404287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083408384, 1083416575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083424768, 1083428863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083432960, 1083437055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083437056, 1083441151, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1083441152, 1083654143, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083670528, 1083686911, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1083703296, 1085435903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085456384, 1085464575, 'PR', 'PRI', 'PUERTO RICO');
INSERT INTO `partners_countryFlag` VALUES (1085472768, 1085505535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085538304, 1085603839, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1085865984, 1085894655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085898752, 1085911039, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085915136, 1085923327, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085931520, 1085951999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085956096, 1085960191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085964288, 1085976575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085980672, 1085984767, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085988864, 1085997055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1085997056, 1086013439, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1086029824, 1086291967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086324736, 1086918655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086922752, 1086926847, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1086930944, 1086935039, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086939136, 1086943231, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086947328, 1086951423, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086955520, 1086971903, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1086971904, 1086975999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086980096, 1086984191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086988288, 1086992383, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1086996480, 1087000575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087004672, 1087016959, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087021056, 1087025151, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087029248, 1087033343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087037440, 1087041535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087045632, 1087070207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087078400, 1087082495, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087094784, 1087332351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087340544, 1087348735, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087356928, 1087365119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1087373312, 1088684031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1088684032, 1088946175, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1088946176, 1089052671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089060864, 1089134591, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089142784, 1089146879, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089150976, 1089163263, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089167360, 1089171455, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1089175552, 1089179647, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089183744, 1089191935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089191936, 1089200127, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1089200128, 1089277951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089282048, 1089294335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089298432, 1089302527, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089339392, 1089343487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089347584, 1089351679, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089355776, 1089384447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089388544, 1089392639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089396736, 1089454079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089470464, 1089892351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089896448, 1089904639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089912832, 1089921023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089929216, 1089961983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089961984, 1089970175, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1089970176, 1089974271, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089978368, 1089986559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1089994752, 1090183167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090191360, 1090203647, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090207744, 1090220031, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1090224128, 1090236415, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090240512, 1090244607, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090248704, 1090326527, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090330624, 1090338815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090347008, 1090355199, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090371584, 1090375679, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090379776, 1090387967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090387968, 1090396159, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1090396160, 1090408447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090412544, 1090424831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090428928, 1090433023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090437120, 1090445311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090445312, 1090453503, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1090453504, 1090482175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090486272, 1090494463, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1090502656, 1090514943, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091567616, 1091682303, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091698688, 1091723263, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091731456, 1091756031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091764224, 1091788799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091796992, 1091801087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091813376, 1091821567, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1091829760, 1092034559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1092042752, 1092046847, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1092050944, 1092067327, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1092075520, 1092083711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1092091904, 1092911103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1092943872, 1092993023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1093009408, 1093017599, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1093025792, 1093033983, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1093042176, 1093050367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1093058560, 1093066751, 'PR', 'PRI', 'PUERTO RICO');
INSERT INTO `partners_countryFlag` VALUES (1093074944, 1093091327, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1093091328, 1093099519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1093107712, 1093140479, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1093140480, 1093664767, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1093664768, 1093840895, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1093926912, 1094467583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1094483968, 1094524927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1094533120, 1094541311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1094549504, 1094565887, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1094565888, 1094574079, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1094582272, 1094680575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1094713344, 1095401471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1095434240, 1095450623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1095499776, 1095663615, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1095696384, 1095729151, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1095761920, 1096228863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1096237056, 1096278015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1096286208, 1096548351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1096548352, 1096810495, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1096810496, 1096884223, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097072640, 1097727999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097728000, 1097732095, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1097736192, 1097740287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097744384, 1097748479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097752576, 1097756671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097760768, 1097764863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097768960, 1097773055, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1097777152, 1097801727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097809920, 1097818111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097826304, 1097830399, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1097859072, 1101987839, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1102053376, 1102389247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1102577664, 1107165183, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107296256, 1107693567, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107697664, 1107701759, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107705856, 1107726335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107730432, 1107734527, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107738624, 1107742719, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107755008, 1107783679, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107787776, 1107804159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107812352, 1107820543, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1107820544, 1107853311, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1107853312, 1108029439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108033536, 1108037631, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1108041728, 1108045823, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108049920, 1108054015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108058112, 1108066303, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1108066304, 1108070399, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108074496, 1108078591, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108082688, 1108312063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108344832, 1108430847, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108434944, 1108439039, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108443136, 1108459519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108475904, 1108488191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108492288, 1108500479, 'ZA', 'ZAF', 'SOUTH AFRICA');
INSERT INTO `partners_countryFlag` VALUES (1108508672, 1108516863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108541440, 1108860927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1108869120, 1109254143, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109262336, 1109516287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109524480, 1109590015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109590016, 1109594111, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1109594112, 1109618687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109622784, 1109680127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109680128, 1109684223, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1109688320, 1109696511, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1109696512, 1109700607, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109704704, 1109708799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109712896, 1109733375, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109737472, 1109741567, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109745664, 1109749759, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109753856, 1109811199, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109819392, 1109852159, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1109852160, 1109893119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1109917696, 1110036479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110048768, 1110081535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110114304, 1110126591, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110130688, 1110142975, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110147072, 1110220799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110228992, 1110237183, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110245376, 1110302719, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110310912, 1110376447, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1110376448, 1110540287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110573056, 1110650879, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110654976, 1110663167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110663168, 1110671359, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1110671360, 1110675455, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110679552, 1110683647, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110687744, 1110695935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110704128, 1110851583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110867968, 1110917119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1110966272, 1111191551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111195648, 1111212031, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1111212032, 1111228415, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111228416, 1111244799, 'AR', 'ARG', 'ARGENTINA');
INSERT INTO `partners_countryFlag` VALUES (1111244800, 1111252991, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111261184, 1111285759, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111293952, 1111437311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111441408, 1111465983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111474176, 1111482367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111490560, 1111515135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1111556096, 1111998463, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1112014848, 1112399871, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1112408064, 1112424447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1112473600, 1112498175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1112506368, 1112514559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1112539136, 1112817663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1112834048, 1113210879, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113227264, 1113468927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113473024, 1113481215, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113489408, 1113513983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113522176, 1113591807, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113595904, 1113616383, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113620480, 1113657343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113657344, 1113661439, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1113661440, 1113665535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113669632, 1113677823, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113677824, 1113681919, 'CH', 'CHE', 'SWITZERLAND');
INSERT INTO `partners_countryFlag` VALUES (1113686016, 1113690111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113702400, 1113743359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113784320, 1113985023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1113989120, 1113993215, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1113997312, 1114001407, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1114005504, 1114009599, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114013696, 1114017791, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114021888, 1114034175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114038272, 1114042367, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1114046464, 1114050559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114054656, 1114062847, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1114062848, 1114066943, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114071040, 1114075135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114079232, 1114095615, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114095616, 1114099711, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1114103808, 1114443775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114447872, 1114451967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114456064, 1114492927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114497024, 1114505215, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114505216, 1114550271, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1114550272, 1114562559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114570752, 1114599423, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114603520, 1114681343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114685440, 1114689535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114693632, 1114697727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114701824, 1114714111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114718208, 1114726399, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114734592, 1114775551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114783744, 1114812415, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114816512, 1114857471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114865664, 1114886143, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114914816, 1114923007, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114963968, 1114972159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114980352, 1114988543, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1114996736, 1115004927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115013120, 1115037695, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115045888, 1115058175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115062272, 1115086847, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115095040, 1115107327, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115111424, 1115123711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115127808, 1115131903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115136000, 1115144191, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1115144192, 1115156479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115160576, 1115688959, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115693056, 1115697151, 'CO', 'COL', 'COLOMBIA');
INSERT INTO `partners_countryFlag` VALUES (1115701248, 1115705343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115709440, 1115721727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115725824, 1115738111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115742208, 1115746303, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115750400, 1115762687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115766784, 1115783167, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115783168, 1115791359, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1115791360, 1115795455, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115799552, 1115815935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1115815936, 1115938815, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1115947008, 1115979775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116012544, 1116037119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116045312, 1116061695, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116078080, 1116151807, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116160000, 1116168191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116168192, 1116172287, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1116176384, 1116897279, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116897280, 1116901375, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1116905472, 1116909567, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116913664, 1116917759, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116921856, 1116925951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116930048, 1116987391, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1116995584, 1117011967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117028352, 1117282303, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117290496, 1117298687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117306880, 1117376511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117388800, 1117413375, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117421568, 1117499391, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117519872, 1117683711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117683712, 1117687807, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1117691904, 1117695999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117716480, 1117728767, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117732864, 1117741055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117749248, 1117814783, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117847552, 1117859839, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117880320, 1117978623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117978624, 1117986815, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1117986816, 1117990911, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1117995008, 1117999103, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1118003200, 1118007295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118011392, 1118027775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118027776, 1118031871, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1118035968, 1118121983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118126080, 1118138367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118142464, 1118150655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118158848, 1118167039, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1118175232, 1118441471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118445568, 1118457855, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118461952, 1118466047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118470144, 1118474239, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118478336, 1118482431, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118486528, 1118490623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118494720, 1118552063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118568448, 1118584831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118601216, 1118609407, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118633984, 1118666751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118699520, 1118781439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118797824, 1118818303, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118830592, 1118949375, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118961664, 1118978047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1118994432, 1119006719, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119027200, 1119072255, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119092736, 1119096831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119100928, 1119105023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119109120, 1119113215, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1119117312, 1119145983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119150080, 1119162367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119166464, 1119186943, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119191040, 1119195135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119199232, 1119211519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119215616, 1119248383, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119256576, 1119272959, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119289344, 1119354879, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1119354880, 1119391743, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119420416, 1119424511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119428608, 1119432703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119436800, 1119440895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119440896, 1119444991, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1119444992, 1119449087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119453184, 1119465471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119477760, 1119498239, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119502336, 1119510527, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1119510528, 1119514623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119518720, 1119522815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119526912, 1119555583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119559680, 1119563775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119567872, 1119571967, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1119576064, 1119580159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119584256, 1119596543, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1119600640, 1120026623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120141312, 1120149503, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120157696, 1120202751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120206848, 1120272383, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120272384, 1120321535, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120337920, 1120350207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120354304, 1120370687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120370688, 1120387071, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120387072, 1120395263, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120403456, 1120481279, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120485376, 1120509951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120518144, 1120534527, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120534528, 1120604159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120616448, 1120636927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120641024, 1120653311, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120657408, 1120661503, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120665600, 1120759807, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120763904, 1120772095, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120780288, 1120788479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120796672, 1120808959, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120813056, 1120817151, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120821248, 1120825343, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120829440, 1120841727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120845824, 1120849919, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120854016, 1120858111, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120862208, 1120874495, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120878592, 1120886783, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120886784, 1120894975, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120894976, 1120899071, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120903168, 1120907263, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120911360, 1120919551, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1120919552, 1120940031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120944128, 1120956415, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120960512, 1120968703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1120976896, 1121005567, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121009664, 1121021951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121026048, 1121038335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121042432, 1121054719, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121058816, 1121124351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121189888, 1121193983, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121198080, 1121202175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121206272, 1121218559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121222656, 1121234943, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121239040, 1121247231, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121247232, 1121251327, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1121255424, 1121300479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121304576, 1121308671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121320960, 1121488895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121501184, 1121513471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121517568, 1121619967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121624064, 1121628159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121632256, 1121636351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121640448, 1121660927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121665024, 1121677311, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121681408, 1121734655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121738752, 1121751039, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121755136, 1121759231, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121763328, 1121767423, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121771520, 1121775615, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121779712, 1121878015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121878016, 1121910783, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1121910784, 1121943551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1121976320, 1122050047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122107392, 1122115583, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122123776, 1122136063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122140160, 1122148351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122156544, 1122242559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122246656, 1122267135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122271232, 1122299903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122304000, 1122320959, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122320960, 1122320995, 'PT', 'PRT', 'PORTUGAL');
INSERT INTO `partners_countryFlag` VALUES (1122320996, 1122369535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122369536, 1122390015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122402304, 1122410495, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122418688, 1122430975, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122435072, 1122447359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122451456, 1122455551, 'CO', 'COL', 'COLOMBIA');
INSERT INTO `partners_countryFlag` VALUES (1122459648, 1122471935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122476032, 1122480127, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122484224, 1122496511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122500608, 1122516991, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122533376, 1122545663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122549760, 1122553855, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122557952, 1122562047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122566144, 1122615295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122631680, 1122635775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122639872, 1122643967, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122648064, 1122652159, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122656256, 1122660351, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122664448, 1122668543, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122672640, 1122676735, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122680832, 1122693119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122697216, 1122713599, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1122762752, 1123041279, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123057664, 1123074047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123090432, 1123098623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123106816, 1123115007, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123123200, 1123127295, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1123139584, 1123160063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123164160, 1123168255, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123172352, 1123176447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123180544, 1123184639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123188736, 1123201023, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123205120, 1123209215, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123213312, 1123270655, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123287040, 1123315711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123319808, 1123323903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123336192, 1123352575, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1123352576, 1123393535, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123418112, 1123450879, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123483648, 1123581951, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123680256, 1123745791, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123811328, 1123823615, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123827712, 1123831807, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123835904, 1123839999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123844096, 1123848191, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123852288, 1123872767, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123876864, 1123909631, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123942400, 1123950591, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123958784, 1123966975, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123975168, 1123983359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1123991552, 1123999743, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1124007936, 1124057087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1124073472, 1125031935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1125122048, 1125253119, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1125384192, 1125449727, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1125646336, 1126891519, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1127219200, 1127350271, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1128005632, 1128017919, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1128267776, 1128529919, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1128529920, 1128726527, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1128792064, 1129054207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1129316352, 1130692607, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1130889216, 1131151359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1131413504, 1132593151, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1133510656, 1133838335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1134034944, 1134166015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1134559232, 1135214591, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1136517008, 1136517023, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1136517040, 1136517055, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1136656384, 1142751231, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1142947840, 1146028031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1146093568, 1146879999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1147142144, 1148780543, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1149239296, 1150156799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1150287872, 1150550015, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1150812160, 1151565823, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1151598592, 1152270335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1152385024, 1152450559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1152909312, 1153171455, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1153433600, 1153630207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1153957888, 1154035711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1154482176, 1154940927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1155530752, 1155596287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157627904, 1157718015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157726208, 1157734399, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157742592, 1157750783, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157758976, 1157763071, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157767168, 1157771263, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157775360, 1157804031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157808128, 1157812223, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157816320, 1157902335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157906432, 1157910527, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157914624, 1157918719, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157922816, 1157931007, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157931008, 1157935103, 'BS', 'BHS', 'BAHAMAS');
INSERT INTO `partners_countryFlag` VALUES (1157939200, 1157943295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157947392, 1157951487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157955584, 1157963775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157971968, 1157976063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1157988352, 1157996543, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158004736, 1158012927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158021120, 1158037503, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158053888, 1158070271, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158086656, 1158090751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158094848, 1158098943, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158103040, 1158107135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158111232, 1158115327, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158119424, 1158131711, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158135808, 1158139903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158144000, 1158148095, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158152192, 1158168575, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158184960, 1158193151, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158217728, 1158225919, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158234112, 1158242303, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158250496, 1158258687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158266880, 1158287359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158291456, 1158295551, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158299648, 1158303743, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158307840, 1158311935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158316032, 1158320127, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1158324224, 1158328319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158332416, 1158336511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158340608, 1158344703, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1158381568, 1158447103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158479872, 1158512639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158545408, 1158594559, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158610944, 1158619135, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158676480, 1158709247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158742016, 1158758399, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158774784, 1158791167, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1158807552, 1158823935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158840320, 1158856703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158873088, 1158881279, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158905856, 1158914047, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158938624, 1158946815, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1158971392, 1158987775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159004160, 1159090175, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159102464, 1159151615, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159200768, 1159204863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159208960, 1159213055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159217152, 1159221247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159225344, 1159229439, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159233536, 1159237631, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159241728, 1159245823, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159249920, 1159254015, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159258112, 1159262207, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159266304, 1159282687, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159331840, 1159340031, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159348224, 1159356415, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1159364608, 1159372799, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159380992, 1159385087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159397376, 1159401471, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159405568, 1159409663, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159413760, 1159417855, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159421952, 1159426047, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1159430144, 1159434239, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159438336, 1159442431, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159446528, 1159450623, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159454720, 1159471103, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159479296, 1159487487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159495680, 1159503871, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159512064, 1159520255, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1159528448, 1159544831, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159593984, 1159626751, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159659520, 1159679999, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159725056, 1159823359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159856128, 1159888895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159921664, 1159991295, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1159995392, 1159999487, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160003584, 1160011775, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160011776, 1160015871, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1160019968, 1160024063, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160028160, 1160032255, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160036352, 1160040447, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160044544, 1160048639, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160052736, 1160060927, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160118272, 1160122367, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160151040, 1160159231, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160183808, 1160187903, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160192000, 1160196095, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160200192, 1160204287, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160208384, 1160212479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160216576, 1160220671, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160224768, 1160228863, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160232960, 1160237055, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160241152, 1160245247, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160249344, 1160282111, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160314880, 1160318975, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160323072, 1160335359, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160339456, 1160351743, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160355840, 1160359935, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160364032, 1160368127, 'CA', 'CAN', 'CANADA');
INSERT INTO `partners_countryFlag` VALUES (1160372224, 1160376319, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160380416, 1160384511, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160388608, 1160392703, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160396800, 1160400895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160404992, 1160409087, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1160445952, 1160462335, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1166016512, 1166032895, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1166540800, 1166868479, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1342177280, 1342627839, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342627840, 1342627903, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1342627904, 1342627935, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342627936, 1342627999, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1342628000, 1342628015, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342628016, 1342628023, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1342628024, 1342628031, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342628032, 1342628111, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1342628112, 1342628159, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342628160, 1342628175, 'IE', 'IRL', 'IRELAND');
INSERT INTO `partners_countryFlag` VALUES (1342628176, 1342628223, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342628224, 1342628863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342628864, 1342701567, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1342701568, 1343217663, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343217664, 1343218687, 'MU', 'MUS', 'MAURITIUS');
INSERT INTO `partners_countryFlag` VALUES (1343218688, 1343219711, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343219712, 1343220479, 'HK', 'HKG', 'HONG KONG');
INSERT INTO `partners_countryFlag` VALUES (1343220480, 1343220607, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343220608, 1343220735, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1343220736, 1343220863, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1343220864, 1343221247, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343221248, 1343221503, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343221504, 1343221759, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1343221760, 1343222175, 'LB', 'LBN', 'LEBANON');
INSERT INTO `partners_countryFlag` VALUES (1343222176, 1343222271, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343222288, 1343222527, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343222528, 1343222579, 'TD', 'TCD', 'CHAD');
INSERT INTO `partners_countryFlag` VALUES (1343222580, 1343223039, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343223040, 1343223404, 'MG', 'MDG', 'MADAGASCAR');
INSERT INTO `partners_countryFlag` VALUES (1343223405, 1343223427, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343223428, 1343223429, 'MG', 'MDG', 'MADAGASCAR');
INSERT INTO `partners_countryFlag` VALUES (1343223430, 1343223807, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343223808, 1343223919, 'MG', 'MDG', 'MADAGASCAR');
INSERT INTO `partners_countryFlag` VALUES (1343223920, 1343224063, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343224064, 1343224303, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1343224304, 1343224575, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343224576, 1343225855, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1343225856, 1343750143, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1343750144, 1344798719, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1344798720, 1345323007, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1345323008, 1345847295, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1345847296, 1345978367, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1345978368, 1346109439, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1346109440, 1346240511, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1346240512, 1346371583, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1346371584, 1346375679, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1346379776, 1346383871, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1346387968, 1346392063, 'HU', 'HUN', 'HUNGARY');
INSERT INTO `partners_countryFlag` VALUES (1346396160, 1346400255, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1346404352, 1346405007, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405008, 1346405023, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346405024, 1346405215, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405216, 1346405375, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405376, 1346405407, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405408, 1346405439, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405440, 1346405463, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405464, 1346405499, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405500, 1346405631, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405632, 1346405887, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405888, 1346405951, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346405952, 1346406139, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346406140, 1346406655, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346406656, 1346407679, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346407680, 1346408431, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346408432, 1346408447, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346412544, 1346416639, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346420736, 1346424831, 'NO', 'NOR', 'NORWAY');
INSERT INTO `partners_countryFlag` VALUES (1346428928, 1346431103, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1346431104, 1346431119, 'MA', 'MAR', 'MOROCCO');
INSERT INTO `partners_countryFlag` VALUES (1346431120, 1346431743, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1346431744, 1346431999, 'KZ', 'KAZ', 'KAZAKHSTAN');
INSERT INTO `partners_countryFlag` VALUES (1346432000, 1346433023, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1346437120, 1346439167, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1346439168, 1346440447, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1346440448, 1346441215, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1346445312, 1346449407, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346453504, 1346457599, 'BA', 'BIH', 'BOSNIA AND HERZEGOVINA');
INSERT INTO `partners_countryFlag` VALUES (1346461696, 1346469887, 'NL', 'NLD', 'NETHERLANDS');
INSERT INTO `partners_countryFlag` VALUES (1346469888, 1346473983, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1346478080, 1346482175, 'BA', 'BIH', 'BOSNIA AND HERZEGOVINA');
INSERT INTO `partners_countryFlag` VALUES (1346486272, 1346490367, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1346494464, 1346498559, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1346502656, 1346510847, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346510848, 1346514943, 'AT', 'AUT', 'AUSTRIA');
INSERT INTO `partners_countryFlag` VALUES (1346519040, 1346527231, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1346527232, 1346531327, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346535424, 1346539519, 'BE', 'BEL', 'BELGIUM');
INSERT INTO `partners_countryFlag` VALUES (1346543616, 1346547711, 'FI', 'FIN', 'FINLAND');
INSERT INTO `partners_countryFlag` VALUES (1346551808, 1346555903, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346560000, 1346564095, 'LI', 'LIE', 'LIECHTENSTEIN');
INSERT INTO `partners_countryFlag` VALUES (1346568192, 1346572287, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346576384, 1346580479, 'DK', 'DNK', 'DENMARK');
INSERT INTO `partners_countryFlag` VALUES (1346584576, 1346587391, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1346592768, 1346596863, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1346600960, 1346605055, 'DZ', 'DZA', 'ALGERIA');
INSERT INTO `partners_countryFlag` VALUES (1346609152, 1346617343, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1346617344, 1346621439, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1346625536, 1346629631, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346633728, 1346637823, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1346641920, 1346646015, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346650112, 1346654207, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1346658304, 1346662399, 'SE', 'SWE', 'SWEDEN');
INSERT INTO `partners_countryFlag` VALUES (1346666496, 1346670591, 'ES', 'ESP', 'SPAIN');
INSERT INTO `partners_countryFlag` VALUES (1346674688, 1346678783, 'DE', 'DEU', 'GERMANY');
INSERT INTO `partners_countryFlag` VALUES (1346682880, 1346686975, 'IT', 'ITA', 'ITALY');
INSERT INTO `partners_countryFlag` VALUES (1346691072, 1346695167, 'PL', 'POL', 'POLAND');
INSERT INTO `partners_countryFlag` VALUES (1346695168, 1346699263, 'RU', 'RUS', 'RUSSIAN FEDERATION');
INSERT INTO `partners_countryFlag` VALUES (1346699264, 1346700223, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346700224, 1346700239, 'FR', 'FRA', 'FRANCE');
INSERT INTO `partners_countryFlag` VALUES (1346700240, 1346700255, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (1346700256, 1346700479, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346700480, 1346700511, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346700512, 1346700543, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346700544, 1346700799, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346700800, 1346701023, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346701024, 1346701311, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346701312, 1346701375, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (1346701376, 1346701503, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (33996344, 33996351, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (33996344, 33996351, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (33996344, 33996351, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (33996344, 33996351, 'GB', 'GBR', 'UNITED KINGDOM');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');
INSERT INTO `partners_countryFlag` VALUES (50331648, 83886079, 'US', 'USA', 'UNITED STATES');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_creditcard`
-- 

CREATE TABLE `partners_creditcard` (
  `cc_id` bigint(20) NOT NULL auto_increment,
  `cc_version` varchar(20) NOT NULL,
  `cc_delimdata` enum('True','False') NOT NULL default 'True',
  `cc_relayresponse` enum('True','False') NOT NULL default 'True',
  `cc_login` varchar(30) NOT NULL,
  `cc_trankey` varchar(30) NOT NULL,
  `cc_type` enum('AUTH_CAPTURE','AUTH_ONLY','CAPTURE_ONLY','CREDIT','VOID','PRIOR_AUTH_CAPTURE') NOT NULL default 'AUTH_CAPTURE',
  PRIMARY KEY  (`cc_id`)
)  ;

-- 
-- Dumping data for table `partners_creditcard`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_crm`
-- 

CREATE TABLE `partners_crm` (
  `crm_id` bigint(20) NOT NULL auto_increment,
  `crm_merchantid` bigint(20) NOT NULL default '0',
  `crm_affiliateid` bigint(20) NOT NULL default '0',
  `crm_catid` varchar(255) NOT NULL default '0',
  `crm_date` date NOT NULL default '0000-00-00',
  `crm_flag` enum('high','low','medium') NOT NULL default 'high',
  `crm_subject` varchar(255) NOT NULL,
  `crm_note` varchar(255) NOT NULL,
  `crm_status` enum('show','hide') NOT NULL default 'show',
  `crm_type` varchar(255) NOT NULL,
  `crm_crdate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`crm_id`)
)  ;

-- 
-- Dumping data for table `partners_crm`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_currency`
-- 

CREATE TABLE `partners_currency` (
  `currency_id` bigint(20) NOT NULL auto_increment,
  `currency_caption` varchar(255) NOT NULL,
  `currency_symbol` text NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  PRIMARY KEY  (`currency_id`)
)   ;

-- 
-- Dumping data for table `partners_currency`
-- 

INSERT INTO `partners_currency` VALUES (1, 'Dollar', '$', 'USD');
INSERT INTO `partners_currency` VALUES (5, 'Pound', '&pound;', 'GBP');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_currency_relation`
-- 

CREATE TABLE `partners_currency_relation` (
  `relation_id` bigint(20) NOT NULL auto_increment,
  `relation_currency_code` varchar(10) NOT NULL,
  `relation_value` double NOT NULL,
  `relation_date` date NOT NULL,
  PRIMARY KEY  (`relation_id`)
) ;

-- 
-- Dumping data for table `partners_currency_relation`
-- 

INSERT INTO `partners_currency_relation` VALUES (1, 'USD', 1, 0x323030352d30312d3139);
INSERT INTO `partners_currency_relation` VALUES (2, 'GBP', 0.52, 0x323030352d30352d3035);

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_egold`
-- 

CREATE TABLE `partners_egold` (
  `egold_id` bigint(20) NOT NULL auto_increment,
  `egold_accno` varchar(200) NOT NULL,
  `egold_payeename` varchar(60) NOT NULL,
  `egold_user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`egold_id`)
)  ;

-- 
-- Dumping data for table `partners_egold`
-- 

INSERT INTO `partners_egold` VALUES (1, '1', '1', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_event`
-- 

CREATE TABLE `partners_event` (
  `event_name` varchar(100) NOT NULL,
  `event_status` enum('yes','no') NOT NULL default 'yes',
  `event_flag` enum('m','a') NOT NULL default 'a',
  `event_type` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`event_name`)
)  ;

-- 
-- Dumping data for table `partners_event`
-- 

INSERT INTO `partners_event` VALUES ('Remove Affiliate', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Remove Merchant', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Reject Affiliate', 'no', 'm', '1');
INSERT INTO `partners_event` VALUES ('Approve Affiliate', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Approve Merchant', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Approve AffiliateProgram', 'no', 'a', '0');
INSERT INTO `partners_event` VALUES ('Approve Transaction', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Reject Transaction', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Reverse Transaction', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Suspend Affiliate', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Suspend Merchant', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Suspend AffiliateProgram', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Reject AffiliateProgram', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Change Affiliate Password', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Affiliate Registration', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('MailAffiliate', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('MailMerchant', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Affiliate Remember Password', 'yes', 'm', '1');
INSERT INTO `partners_event` VALUES ('Merchant Registration', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Merchant Remember Password', 'yes', 'a', '0');
INSERT INTO `partners_event` VALUES ('Change Merchant Password', 'yes', 'a', '0');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_fee`
-- 

CREATE TABLE `partners_fee` (
  `adjust_id` bigint(20) NOT NULL auto_increment,
  `adjust_memberid` bigint(20) NOT NULL default '0',
  `adjust_action` enum('programFee','register') NOT NULL default 'programFee',
  `adjust_flag` enum('closed','pending') NOT NULL default 'closed',
  `adjust_amount` double NOT NULL default '0',
  `adjust_date` date NOT NULL default '0000-00-00',
  `adjust_no` int(11) NOT NULL default '0',
  PRIMARY KEY  (`adjust_id`)
) ;

-- 
-- Dumping data for table `partners_fee`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_firstlevel`
-- 

CREATE TABLE `partners_firstlevel` (
  `firstlevel_id` bigint(20) NOT NULL auto_increment,
  `firstlevel_programid` bigint(20) NOT NULL default '0',
  `firstlevel_clickrate` float default '0',
  `firstlevel_leadrate` float default '0',
  `firstlevel_salerate` float default '0',
  `firstlevel_saletype` enum('%','$') NOT NULL default '%',
  `firstlevel_impressionrate` float NOT NULL default '0',
  `firstlevel_unitimpression` int(11) NOT NULL default '1000',
  `firstlevel_recur_sale` enum('0','1') NOT NULL default '0',
  `firstlevel_recur_percentage` int(11) NOT NULL,
  `firstlevel_recur_period` int(11) NOT NULL,
  `firstlevel_admin_impr` float NOT NULL default '0',
  `firstlevel_admin_click` float NOT NULL default '0',
  `firstlevel_admin_clicktype` enum('%','$') NOT NULL default '%',
  `firstlevel_admin_lead` float NOT NULL default '0',
  `firstlevel_admin_leadtype` enum('%','$') NOT NULL default '%',
  `firstlevel_admin_sale` float NOT NULL default '0',
  `firstlevel_admin_saletype` enum('%','$') NOT NULL default '%',
  `firstlevel_admin_default` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`firstlevel_id`)
)   ;

-- 
-- Dumping data for table `partners_firstlevel`
-- 
 -- --------------------------------------------------------

-- 
-- Table structure for table `partners_flash`
-- 

CREATE TABLE `partners_flash` (
  `flash_id` bigint(20) NOT NULL auto_increment,
  `flash_programid` bigint(20) NOT NULL default '0',
  `flash_url` varchar(100) NOT NULL,
  `flash_swf` varchar(200) NOT NULL,
  `flash_width` varchar(50) NOT NULL,
  `flash_height` varchar(50) NOT NULL,
  `flash_status` enum('active','inactive') NOT NULL default 'inactive',
  PRIMARY KEY  (`flash_id`)
)  ;

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_group`
-- 

CREATE TABLE `partners_group` (
  `group_id` bigint(20) NOT NULL auto_increment,
  `group_saletype` enum('%','$') NOT NULL default '%',
  `group_programid` bigint(20) NOT NULL default '0',
  `group_clickrate` float NOT NULL default '0',
  `group_salerate` float NOT NULL default '0',
  `group_leadrate` float NOT NULL default '0',
  `group_name` varchar(100) NOT NULL,
  `group_merchantid` bigint(20) NOT NULL default '0',
  `group_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`group_id`)
)  ;

-- 
-- Dumping data for table `partners_group`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_html`
-- 

CREATE TABLE `partners_html` (
  `html_id` bigint(20) NOT NULL auto_increment,
  `html_programid` bigint(20) NOT NULL default '0',
  `html_text` text NOT NULL,
  `html_status` enum('active','inactive') NOT NULL default 'inactive',
  PRIMARY KEY  (`html_id`)
)   ;

-- 
-- Dumping data for table `partners_html`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_impression`
-- 

CREATE TABLE `partners_impression` (
  `imp_id` bigint(20) NOT NULL auto_increment,
  `imp_programid` bigint(20) NOT NULL default '0',
  `imp_merchantid` bigint(20) NOT NULL default '0',
  `imp_affiliateid` bigint(20) NOT NULL default '0',
  `imp_linkid` varchar(20) NOT NULL default '0',
  `imp_date` date NOT NULL default '0000-00-00',
  `imp_referer` varchar(255) NOT NULL,
  `imp_subid` varchar(50) default NULL,
  PRIMARY KEY  (`imp_id`)
)  ;

-- 
-- Dumping data for table `partners_impression`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_impression_daily`
-- 

CREATE TABLE `partners_impression_daily` (
  `imp_id` bigint(20) NOT NULL auto_increment,
  `imp_programid` bigint(20) NOT NULL,
  `imp_merchantid` bigint(20) NOT NULL,
  `imp_affiliateid` bigint(20) NOT NULL,
  `imp_linkid` varchar(20) NOT NULL,
  `imp_date` date NOT NULL,
  `imp_subid` varchar(50) NOT NULL,
  `imp_count` int(11) NOT NULL,
  `imp_pending` int(11) NOT NULL,
  PRIMARY KEY  (`imp_id`)
)  ;

-- 
-- Dumping data for table `partners_impression_daily`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_invoice`
-- 

CREATE TABLE `partners_invoice` (
  `invoice_id` bigint(20) NOT NULL auto_increment,
  `invoice_merchantid` bigint(20) NOT NULL default '0',
  `invoice_monthyear` varchar(20) NOT NULL,
  `invoice_amount` double NOT NULL default '0',
  `invoice_paidstatus` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`invoice_id`)
)  ;

-- 
-- Dumping data for table `partners_invoice`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_invoiceStat`
-- 

CREATE TABLE `partners_invoiceStat` (
  `invoice_id` bigint(20) NOT NULL auto_increment,
  `invoice_merchantid` bigint(20) NOT NULL default '0',
  `invoice_date` date NOT NULL default '0000-00-00',
  `invoice_status` enum('active','inactive') NOT NULL default 'active',
  PRIMARY KEY  (`invoice_id`)
) ;

-- 
-- Dumping data for table `partners_invoiceStat`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_ipblocking`
-- 

CREATE TABLE `partners_ipblocking` (
  `ipblocking_id` bigint(20) NOT NULL auto_increment,
  `ipblocking_ipaddress` varchar(200) NOT NULL,
  `ipblocking_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ipblocking_affiliateid` bigint(20) NOT NULL default '0',
  `ipblocking_merchantid` bigint(20) NOT NULL default '0',
  `ipblocking_programid` bigint(20) NOT NULL default '0',
  `ipblocking_joinpgmid` bigint(20) NOT NULL default '0',
  `ipblocking_linkid` varchar(20) NOT NULL default '0',
  `ipblocking_click` double NOT NULL default '0',
  `ipblocking_lead` double NOT NULL default '0',
  `ipblocking_sale` double NOT NULL default '0',
  `ipblocking_saletype` enum('%','$') NOT NULL default '%',
  `ipblocking_statusid` bigint(20) NOT NULL default '0',
  `ipblocking_randNo` varchar(100) NOT NULL,
  PRIMARY KEY  (`ipblocking_id`)
)   ;

-- 
-- Dumping data for table `partners_ipblocking`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_joinpgm`
-- 

CREATE TABLE `partners_joinpgm` (
  `joinpgm_id` bigint(20) NOT NULL auto_increment,
  `joinpgm_programid` bigint(20) NOT NULL default '0',
  `joinpgm_merchantid` varchar(100) default NULL,
  `joinpgm_affiliateid` bigint(20) NOT NULL default '0',
  `joinpgm_date` date NOT NULL default '0000-00-00',
  `joinpgm_status` enum('approved','waiting','suspend') NOT NULL default 'approved',
  `joinpgm_group` varchar(100) default '0',
  PRIMARY KEY  (`joinpgm_id`)
)   ;

-- 
-- Dumping data for table `partners_joinpgm`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_languages`
-- 

CREATE TABLE `partners_languages` (
  `languages_id` bigint(20) NOT NULL auto_increment,
  `languages_name` varchar(250) NOT NULL,
  `languages_status` enum('active','inactive') NOT NULL default 'active',
  PRIMARY KEY  (`languages_id`)
)  ;

-- 
-- Dumping data for table `partners_languages`
-- 

INSERT INTO `partners_languages` VALUES (1, 'English', 'active');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_login`
-- 

CREATE TABLE `partners_login` (
  `login_email` varchar(100) NOT NULL,
  `login_password` varchar(100) NOT NULL,
  `login_flag` enum('a','m') NOT NULL default 'a',
  `login_id` bigint(20) NOT NULL default '0',
  `login_retry_limit` int(11) NOT NULL default '0',
  `login_next_login` datetime NOT NULL default '2006-06-20 10:10:10',
  PRIMARY KEY  (`login_email`)
)  ;

-- 
-- Dumping data for table `partners_login`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_merchant`
-- 

CREATE TABLE `partners_merchant` (
  `merchant_id` bigint(20) NOT NULL auto_increment,
  `merchant_firstname` varchar(100) NOT NULL,
  `merchant_lastname` varchar(100) NOT NULL,
  `merchant_company` varchar(100) NOT NULL,
  `merchant_address` text NOT NULL,
  `merchant_city` varchar(100) NOT NULL,
  `merchant_country` varchar(100) NOT NULL,
  `merchant_phone` varchar(100) NOT NULL,
  `merchant_url` varchar(100) NOT NULL,
  `merchant_category` varchar(40) NOT NULL,
  `merchant_status` enum('approved','waiting','suspend','empty','NP') NOT NULL default 'approved',
  `merchant_date` date NOT NULL default '0000-00-00',
  `merchant_fax` varchar(100) NOT NULL,
  `merchant_type` varchar(200) NOT NULL default 'normal',
  `merchant_randNo` varchar(100) NOT NULL,
  `merchant_pgmapproval` enum('manual','automatic') NOT NULL default 'manual',
  `merchant_currency` text NOT NULL,
  `merchant_state` varchar(255) NOT NULL,
  `merchant_zip` varchar(255) NOT NULL,
  `merchant_taxId` varchar(255) NOT NULL,
  `merchant_orderId` varchar(255) NOT NULL,
  `merchant_saleAmt` varchar(255) NOT NULL,
  `merchant_isInvoice` enum('Yes','No') NOT NULL default 'No',
  `merchant_invoiceStatus` enum('active','inactive') NOT NULL default 'inactive',
  `merchant_headercode` longtext,
  `merchant_footercode` longtext,
  PRIMARY KEY  (`merchant_id`)
)  ;

-- 
-- Dumping data for table `partners_merchant`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_mermail`
-- 

CREATE TABLE `partners_mermail` (
  `mermail_id` bigint(20) NOT NULL auto_increment,
  `mermail_eventname` varchar(100) NOT NULL default '0',
  `mermail_from` varchar(100) default NULL,
  `mermail_subject` varchar(100) default NULL,
  `mermail_message` text,
  `mermail_header` text,
  `mermail_footer` text,
  `mermail_merchantid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`mermail_id`),
  UNIQUE KEY `mermail_eventname` (`mermail_eventname`)
)  ;

-- 
-- Dumping data for table `partners_mermail`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_payment`
-- 

CREATE TABLE `partners_payment` (
  `pay_id` double NOT NULL auto_increment,
  `pay_memberid` bigint(20) NOT NULL default '0',
  `pay_amount` double NOT NULL default '0',
  `pay_flag` enum('1','2','3') NOT NULL default '1',
  `pay_transaction` varchar(40) NOT NULL,
  `pay_submemberid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`pay_id`)
)   ;

-- 
-- Dumping data for table `partners_payment`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_paymentgateway`
-- 

CREATE TABLE `partners_paymentgateway` (
  `pay_id` bigint(20) NOT NULL auto_increment,
  `pay_name` varchar(40) NOT NULL,
  `pay_status` enum('Active','Inactive') NOT NULL default 'Active',
  `pay_flag` enum('b','a') NOT NULL default 'b',
  PRIMARY KEY  (`pay_id`)
)   ;

-- 
-- Dumping data for table `partners_paymentgateway`
-- 

INSERT INTO `partners_paymentgateway` VALUES (1, 'Paypal', 'Active', 'b');
INSERT INTO `partners_paymentgateway` VALUES (2, 'Authorize.net', 'Active', 'b');
INSERT INTO `partners_paymentgateway` VALUES (3, 'Stormpay', 'Active', 'b');
INSERT INTO `partners_paymentgateway` VALUES (5, 'E-Gold', 'Active', 'b');
INSERT INTO `partners_paymentgateway` VALUES (7, 'CheckByMail', 'Active', 'a');
INSERT INTO `partners_paymentgateway` VALUES (8, 'WireTransfer', 'Active', 'a');
INSERT INTO `partners_paymentgateway` VALUES (10, 'WorldPay', 'Active', 'b');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_paypal`
-- 

CREATE TABLE `partners_paypal` (
  `paypal_id` bigint(20) NOT NULL auto_increment,
  `paypal_user_id` bigint(20) NOT NULL default '0',
  `paypal_email` varchar(200) NOT NULL,
  `paypal_itemname` varchar(150) NOT NULL,
  `paypal_itemnumber` varchar(150) NOT NULL,
  PRIMARY KEY  (`paypal_id`)
)  ;

-- 
-- Dumping data for table `partners_paypal`
-- 

INSERT INTO `partners_paypal` VALUES (1, 0, 'support@alstrasoft.com', '005', '002');

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_pgmstatus`
-- 

CREATE TABLE `partners_pgmstatus` (
  `pgmstatus_id` bigint(20) NOT NULL auto_increment,
  `pgmstatus_programid` bigint(20) NOT NULL default '0',
  `pgmstatus_clickapproval` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_leadapproval` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_saleapproval` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_mailaffiliate` enum('yes','no') NOT NULL default 'yes',
  `pgmstatus_mailmerchant` enum('yes','no') NOT NULL default 'yes',
  `pgmstatus_affiliateapproval` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_clickmail` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_leadmail` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_salemail` enum('manual','automatic') NOT NULL default 'manual',
  `pgmstatus_impressionapproval` enum('automatic','manual') NOT NULL default 'manual',
  `pgmstatus_impressionmail` enum('automatic','manual') NOT NULL default 'manual',
  PRIMARY KEY  (`pgmstatus_id`)
)   ;

-- 
-- Dumping data for table `partners_pgmstatus`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_popup`
-- 

CREATE TABLE `partners_popup` (
  `popup_id` bigint(20) NOT NULL auto_increment,
  `popup_programid` bigint(20) NOT NULL default '0',
  `popup_url` varchar(100) NOT NULL,
  `popup_type` enum('popup','underpopup') NOT NULL default 'popup',
  `popup_width` int(10) NOT NULL default '0',
  `popup_height` int(10) NOT NULL default '0',
  `popup_scrollbar` enum('yes','no') NOT NULL default 'yes',
  `popup_status` enum('active','inactive') NOT NULL default 'inactive',
  PRIMARY KEY  (`popup_id`)
)   ;

-- 
-- Dumping data for table `partners_popup`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_product`
-- 

CREATE TABLE `partners_product` (
  `prd_id` bigint(20) NOT NULL auto_increment,
  `prd_programid` bigint(20) NOT NULL default '0',
  `prd_number` text NOT NULL,
  `prd_product` varchar(255) NOT NULL,
  `prd_desc` blob NOT NULL,
  `prd_image` varchar(255) NOT NULL,
  `prd_url` varchar(255) NOT NULL,
  `prd_uploadid` bigint(20) NOT NULL default '0',
  `prd_status` enum('Active','Inactive') NOT NULL default 'Active',
  `prd_price` text NOT NULL,
  `prd_catid` text NOT NULL,
  `prd_catname` varchar(255) NOT NULL,
  PRIMARY KEY  (`prd_id`)
)   ;

-- 
-- Dumping data for table `partners_product`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_program`
-- 

CREATE TABLE `partners_program` (
  `program_id` bigint(20) NOT NULL auto_increment,
  `program_merchantid` bigint(20) NOT NULL default '0',
  `program_url` varchar(100) NOT NULL,
  `program_description` text NOT NULL,
  `program_ipblocking` int(11) NOT NULL default '1',
  `program_cookie` varchar(100) NOT NULL,
  `program_date` date NOT NULL default '0000-00-00',
  `program_status` enum('active','inactive') NOT NULL default 'active',
  `program_fee` double NOT NULL default '0',
  `program_type` enum('0','1','2') NOT NULL default '0',
  `program_value` varchar(255) NOT NULL,
  `program_countries` text,
  `program_geotargeting_click` enum('1','0') NOT NULL default '0',
  `program_geotargeting_lead` enum('1','0') NOT NULL default '0',
  `program_geotargeting_sale` enum('1','0') NOT NULL default '0',
  `program_geotargeting_impression` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`program_id`)
)   ;

-- 
-- Dumping data for table `partners_program`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_rawtrans`
-- 

CREATE TABLE `partners_rawtrans` (
  `trans_id` bigint(20) NOT NULL auto_increment,
  `trans_programid` bigint(20) NOT NULL default '0',
  `trans_merchantid` bigint(20) NOT NULL default '0',
  `trans_affiliateid` bigint(20) NOT NULL default '0',
  `trans_linkid` varchar(20) NOT NULL default '0',
  `trans_date` date NOT NULL default '0000-00-00',
  `trans_referer` varchar(255) NOT NULL,
  `trans_type` enum('click','impression') NOT NULL default 'click',
  `trans_subid` varchar(50) default NULL,
  PRIMARY KEY  (`trans_id`)
)   ;

-- 
-- Dumping data for table `partners_rawtrans`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_rawtrans_daily`
-- 

CREATE TABLE `partners_rawtrans_daily` (
  `transdaily_id` bigint(20) NOT NULL auto_increment,
  `transdaily_programid` bigint(20) NOT NULL default '0',
  `transdaily_merchantid` bigint(20) NOT NULL default '0',
  `transdaily_affiliateid` bigint(20) NOT NULL default '0',
  `transdaily_linkid` varchar(255) NOT NULL,
  `transdaily_date` date NOT NULL default '0000-00-00',
  `transdaily_click` bigint(20) NOT NULL default '0',
  `transdaily_impression` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`transdaily_id`)
)  ;

-- 
-- Dumping data for table `partners_rawtrans_daily`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_rcode`
-- 

CREATE TABLE `partners_rcode` (
  `rcode_id` bigint(20) NOT NULL auto_increment,
  `rcode_bannerid` varchar(255) NOT NULL default '0',
  PRIMARY KEY  (`rcode_id`)
)   ;

-- 
-- Dumping data for table `partners_rcode`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_recur`
-- 

CREATE TABLE `partners_recur` (
  `recur_id` bigint(20) NOT NULL auto_increment,
  `recur_transactionid` bigint(20) NOT NULL,
  `recur_affiliateid` bigint(20) NOT NULL,
  `recur_totalcommission` float NOT NULL,
  `recur_percentage` int(11) NOT NULL,
  `recur_period` int(11) NOT NULL,
  `recur_balanceamt` float NOT NULL,
  `recur_lastpaid` date NOT NULL,
  `recur_status` enum('Active','Rejected') NOT NULL default 'Active',
  `recur_total_subsalecommission` float NOT NULL,
  `recur_balance_subsaleamt` float NOT NULL,
  PRIMARY KEY  (`recur_id`)
)   ;

-- 
-- Dumping data for table `partners_recur`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_recurpayments`
-- 

CREATE TABLE `partners_recurpayments` (
  `recurpayments_id` bigint(20) NOT NULL auto_increment,
  `recurpayments_recurid` bigint(20) NOT NULL,
  `recurpayments_date` date NOT NULL,
  `recurpayments_amount` float NOT NULL,
  `recurpayments_status` enum('pending','approved','reversed','reverserequest') NOT NULL,
  `recurpayments_subsaleamount` float NOT NULL,
  PRIMARY KEY  (`recurpayments_id`)
)   ;

-- 
-- Dumping data for table `partners_recurpayments`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_request`
-- 

CREATE TABLE `partners_request` (
  `request_id` bigint(20) NOT NULL auto_increment,
  `request_affiliateid` bigint(20) NOT NULL default '0',
  `request_date` date NOT NULL default '0000-00-00',
  `request_amount` float NOT NULL default '0',
  `request_status` enum('active','inactive') NOT NULL default 'active',
  PRIMARY KEY  (`request_id`)
)   ;

-- 
-- Dumping data for table `partners_request`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_rotator`
-- 

CREATE TABLE `partners_rotator` (
  `rotator_id` bigint(20) NOT NULL auto_increment,
  `rotator_catid` bigint(20) NOT NULL default '0',
  `rotator_affilid` bigint(20) NOT NULL default '0',
  `rotator_banner` text,
  `rotator_flash` text,
  `rotator_text` text,
  `rotator_html` text,
  `rotator_popup` text,
  PRIMARY KEY  (`rotator_id`)
)  ;

-- 
-- Dumping data for table `partners_rotator`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_rotatorsta`
-- 

CREATE TABLE `partners_rotatorsta` (
  `rotatorsta_id` bigint(20) NOT NULL auto_increment,
  `rotatorsta_roid` bigint(20) NOT NULL default '0',
  `rotatorsta_merid` bigint(20) NOT NULL default '0',
  `rotatorsta_status` enum('approved','waiting','suspend') NOT NULL default 'waiting',
  PRIMARY KEY  (`rotatorsta_id`)
)   ;

-- 
-- Dumping data for table `partners_rotatorsta`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_secondlevel`
-- 

CREATE TABLE `partners_secondlevel` (
  `secondlevel_id` bigint(20) NOT NULL auto_increment,
  `secondlevel_programid` bigint(20) NOT NULL default '0',
  `secondlevel_clickrate` float default '0',
  `secondlevel_leadrate` float default '0',
  `secondlevel_salerate` varchar(50) default NULL,
  `secondlevel_saletype` enum('%','$') NOT NULL default '%',
  PRIMARY KEY  (`secondlevel_id`)
)   ;

-- 
-- Dumping data for table `partners_secondlevel`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_stormpay`
-- 

CREATE TABLE `partners_stormpay` (
  `storm_id` bigint(20) NOT NULL auto_increment,
  `storm_email` varchar(250) NOT NULL,
  `storm_user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`storm_id`)
)   ;

-- 
-- Dumping data for table `partners_stormpay`
-- 

INSERT INTO `partners_stormpay` VALUES (1, 'support@alstrasoft.com', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_sub_id`
-- 

CREATE TABLE `partners_sub_id` (
  `sub_id` bigint(20) NOT NULL auto_increment,
  `sub_affiliateid` bigint(20) NOT NULL default '0',
  `sub_subid` varchar(50) NOT NULL,
  PRIMARY KEY  (`sub_id`)
)  ;

-- 
-- Dumping data for table `partners_sub_id`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_temp`
-- 

CREATE TABLE `partners_temp` (
  `temp_id` bigint(20) NOT NULL auto_increment,
  `temp_affiliateid` bigint(20) NOT NULL default '0',
  `temp_date` date NOT NULL default '0000-00-00',
  `temp_amount` double NOT NULL default '0',
  `temp_transaction` varchar(255) NOT NULL,
  PRIMARY KEY  (`temp_id`)
)  ;

-- 
-- Dumping data for table `partners_temp`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_text`
-- 

CREATE TABLE `partners_text` (
  `text_id` bigint(20) NOT NULL auto_increment,
  `text_programid` bigint(20) NOT NULL default '0',
  `text_text` varchar(200) NOT NULL,
  `text_url` varchar(100) NOT NULL,
  `text_description` text NOT NULL,
  `text_status` enum('active','inactive') NOT NULL default 'inactive',
  `text_image` longtext NOT NULL,
  PRIMARY KEY  (`text_id`)
)  ;

-- 
-- Dumping data for table `partners_text`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_text_old`
-- 

CREATE TABLE `partners_text_old` (
  `text_id` bigint(20) NOT NULL auto_increment,
  `text_programid` bigint(20) NOT NULL default '0',
  `text_text` varchar(200) NOT NULL,
  `text_url` varchar(100) NOT NULL,
  `text_description` text NOT NULL,
  `text_status` enum('active','inactive') NOT NULL default 'inactive',
  PRIMARY KEY  (`text_id`)
)  ;

-- 
-- Dumping data for table `partners_text_old`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `partners_track_revenue`
-- 

CREATE TABLE `partners_track_revenue` (
  `revenue_id` bigint(20) NOT NULL auto_increment,
  `revenue_trans_type` enum('sale','lead') NOT NULL default 'sale',
  `revenue_amount` float NOT NULL default '0',
  `revenue_date` date NOT NULL default '0000-00-00',
  `revenue_transaction_id` bigint(20) NOT NULL default '0',
  `revenue_merchantid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`revenue_id`)
)  ;

-- 
-- Dumping data for table `partners_track_revenue`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_trans_rates`
-- 

CREATE TABLE `partners_trans_rates` (
  `trans_id` bigint(20) NOT NULL default '0',
  `trans_rate` float NOT NULL default '0',
  `trans_unit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`trans_id`)
)  ;

-- 
-- Dumping data for table `partners_trans_rates`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_transaction`
-- 

CREATE TABLE `partners_transaction` (
  `transaction_id` bigint(20) NOT NULL auto_increment,
  `transaction_joinpgmid` bigint(20) NOT NULL default '0',
  `transaction_type` enum('click','lead','sale','impression') default 'click',
  `transaction_status` enum('pending','approved','reversed','reverserequest') NOT NULL default 'pending',
  `transaction_dateoftransaction` date NOT NULL default '0000-00-00',
  `transaction_amttobepaid` double NOT NULL default '0',
  `transaction_dateofpayment` date NOT NULL default '0000-00-00',
  `transaction_amountpaid` double default NULL,
  `transaction_subsale` double NOT NULL default '0',
  `transaction_parentid` bigint(20) NOT NULL default '0',
  `transaction_flag` tinyint(4) NOT NULL default '0',
  `transaction_linkid` varchar(20) NOT NULL default '0',
  `transaction_admin_amount` double NOT NULL default '0',
  `transaction_adminpaydate` date NOT NULL default '0000-00-00',
  `transaction_subsaledate` date NOT NULL default '0000-00-00',
  `transaction_reversedate` date NOT NULL default '0000-00-00',
  `transaction_reverseamount` double NOT NULL default '0',
  `transaction_adminpaid` double NOT NULL default '0',
  `transaction_subsalepaid` double NOT NULL default '0',
  `transaction_referer` varchar(255) NOT NULL,
  `transaction_orderid` varchar(255) NOT NULL,
  `transaction_ip` varchar(255) NOT NULL,
  `transaction_country` varchar(255) NOT NULL,
  `transaction_subid` varchar(50) NOT NULL,
  `transaction_transactiontime` datetime NOT NULL default '2006-06-20 10:10:10',
  `transaction_recur` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`transaction_id`)
)   ;

-- 
-- Dumping data for table `partners_transaction`
-- 

 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_transaction_subsale`
-- 

CREATE TABLE `partners_transaction_subsale` (
  `subsale_id` bigint(20) NOT NULL auto_increment,
  `subsale_transactionid` bigint(20) NOT NULL,
  `subsale_date` date NOT NULL default '0000-00-00',
  `subsale_affiliateid` bigint(20) NOT NULL,
  `subsale_childaffiliateid` bigint(20) NOT NULL,
  `subsale_level` int(11) NOT NULL,
  `subsale_amount` double NOT NULL,
  PRIMARY KEY  (`subsale_id`)
)  ;

-- 
-- Dumping data for table `partners_transaction_subsale`
-- 
 
-- --------------------------------------------------------

-- 
-- Table structure for table `partners_upload`
-- 

CREATE TABLE `partners_upload` (
  `upload_id` bigint(20) NOT NULL auto_increment,
  `upload_programid` bigint(20) NOT NULL default '0',
  `upload_status` enum('Active','Inactive','deleted') NOT NULL default 'Active',
  `upload_filename` varchar(255) NOT NULL,
  `upload_actualfile` varchar(255) NOT NULL,
  PRIMARY KEY  (`upload_id`)
)   ;

-- 
-- Dumping data for table `partners_upload`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `partners_worldpay`
-- 

CREATE TABLE `partners_worldpay` (
  `worldpay_id` bigint(20) NOT NULL auto_increment,
  `worldpay_accno` varchar(255) NOT NULL,
  `worldpay_status` varchar(255) NOT NULL,
  PRIMARY KEY  (`worldpay_id`)
)  ;

-- 
-- Dumping data for table `partners_worldpay`
-- 

INSERT INTO `partners_worldpay` VALUES (1, '38290', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `random_gen`
-- 

CREATE TABLE `random_gen` (
  `rand_genid` bigint(20) NOT NULL auto_increment,
  `rand_genpwd` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`rand_genid`)
)   ;

-- 
-- Dumping data for table `random_gen`
-- 


# Multiple Commission Structure
#*****************************************

ALTER TABLE `partners_program` RENAME `partners_program_old` ;

# ~~~~~~~~~~~~~~~~~~~~~~~~~

CREATE TABLE `partners_program` (
  `program_id` bigint(20) NOT NULL auto_increment,
  `program_merchantid` bigint(20) NOT NULL default '0',
  `program_url` varchar(100) NOT NULL,
  `program_description` text NOT NULL,
  `program_date` date NOT NULL default '0000-00-00',
  `program_status` enum('active','inactive') NOT NULL default 'active',
  `program_fee` double NOT NULL default '0',
  `program_type` enum('0','1','2') NOT NULL default '0',
  `program_value` varchar(255) NOT NULL,
  `program_impressionrate` float NOT NULL default '0',
  `program_unitimpression` int(11) NOT NULL default '1000',
  `program_clickrate` float NOT NULL default '0',
  `program_geotargeting_impression` enum('1','0') NOT NULL default '0',
  `program_geotargeting_click` enum('1','0') NOT NULL default '0',
  `program_clickapproval` enum('manual','automatic') NOT NULL default 'manual',
  `program_impressionapproval` enum('manual','automatic') NOT NULL default 'manual',
  `program_clickmail` enum('manual','automatic') NOT NULL default 'manual',
  `program_impressionmail` enum('manual','automatic') NOT NULL default 'manual',
  `program_ipblocking` int(11) default '1',
  `program_cookie` varchar(100) NOT NULL,
  `program_countries` text NOT NULL,
  `program_mailaffiliate` enum('yes','no') NOT NULL default 'yes',
  `program_mailmerchant` enum('yes','no') NOT NULL default 'yes',
  `program_affiliateapproval` enum('manual','automatic') NOT NULL default 'manual',
  `program_admin_impr` float default '0',
  `program_admin_click` float default '0',
  `program_admin_clicktype` enum('%','$') NOT NULL default '%',
  `program_admin_lead` float default '0',
  `program_admin_leadtype` enum('%','$') NOT NULL default '%',
  `program_admin_sale` float default '0',
  `program_admin_saletype` enum('%','$') NOT NULL default '%',
  `program_admin_default` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`program_id`)
) ;

# ~~~~~~~~~~~~~~~~~~~~~~~~~


CREATE TABLE `partners_pgm_commission` (
  `commission_id` bigint(20) NOT NULL auto_increment,
  `commission_programid` bigint(20) NOT NULL,
  `commission_lead_from` bigint(20) NOT NULL,
  `commission_lead_to` bigint(20) NOT NULL,
  `commission_leadrate` float NOT NULL default '0',
  `commission_geotargeting_lead` enum('1','0') NOT NULL default '0',
  `commission_leadapproval` enum('manual','automatic') NOT NULL default 'manual',
  `commission_leadmail` enum('manual','automatic') NOT NULL default 'manual',
  `commission_sale_from` bigint(20) NOT NULL,
  `commission_sale_to` bigint(20) NOT NULL,
  `commission_salerate` float NOT NULL default '0',
  `commission_saletype` enum('%','$') NOT NULL default '%',
  `commission_geotargeting_sale` enum('1','0') NOT NULL default '0',
  `commission_saleapproval` enum('manual','automatic') NOT NULL default 'manual',
  `commission_salemail` enum('manual','automatic') NOT NULL default 'manual',
  `commission_recur_sale` enum('0','1') NOT NULL default '0',
  `commission_recur_percentage` int(11) NOT NULL,
  `commission_recur_period` int(11) NOT NULL,
  PRIMARY KEY  (`commission_id`)
) ;

# ~~~~~~~~~~~~~~~~~~~~~~~~~

# Set commission for affiliates

ALTER TABLE `partners_joinpgm` ADD `joinpgm_commissionid` BIGINT DEFAULT '0' NOT NULL ;
# ~~~~~~~~~~~~~~~~~~~~~~~~~


# To get the number of sales and leads made by affiliates for programs

ALTER TABLE `partners_joinpgm` ADD `joinpgm_lead_count` BIGINT DEFAULT '0' NOT NULL ,
ADD `joinpgm_sale_count` BIGINT DEFAULT '0' NOT NULL ;

# ~~~~~~~~~~~~~~~~~~~~~~~~~


 