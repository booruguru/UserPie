--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(225) NOT NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`) VALUES
(1, 'Standard User');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `userpie_sessions` (
`session_start` int(11) NOT NULL,
`session_data` text NOT NULL,
`session_id` varchar(255) NOT NULL,
PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(150) NOT NULL,
  `username_clean` varchar(150) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activationtoken` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `LostpasswordRequest` int(1) NOT NULL default '0',
  `active` int(1) NOT NULL,
  `group_id` int(11) NOT NULL,
  `sign_up_date` int(11) NOT NULL,
  `last_sign_in` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--