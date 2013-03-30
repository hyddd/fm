CREATE TABLE `accounts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ctime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `in_outs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `io_type` tinyint(1) NOT NULL, 
  `amount` decimal(8,4) NOT NULL,
  `amount_type` tinyint(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `ctime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;