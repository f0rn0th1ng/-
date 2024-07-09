

DROP TABLE IF EXISTS `info`;
CREATE TABLE `info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '图书编号',
  `title` varchar(60) NOT NULL COMMENT '书名',
  `content` varchar(60) NOT NULL COMMENT '简介',
  `author` varchar(60) NOT NULL COMMENT '作者',
  `country` varchar(60) NOT NULL COMMENT '国家',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '入库时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;


INSERT INTO `info` VALUES (1,'图书标题1','图书简介1','作者1','国家1','2022-06-09 09:07:58'),(2,'图书标题2','图书简介2','作者2','国家2','2022-06-09 09:07:58'),(3,'图书标题3','图书简介3','作者3','国家3','2022-07-01 06:51:04');
