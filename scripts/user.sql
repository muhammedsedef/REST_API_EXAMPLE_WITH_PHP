-- engr372.users definition

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(155) NOT NULL,
  `last_name` varchar(155) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `user_type_id` int(11) NOT NULL DEFAULT 2,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `is_active` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;


INSERT INTO engr372.users (first_name,last_name,email,password,user_type_id,created_date,is_active) VALUES
	 ('Muhammet','Sedef','muhammetsedef34@gmail.com','$2y$10$aTCWmVE18Iu5bCukw0La2uDiAldex3NWepuP5LfhcijEbpfI/Ogya',2,'2021-12-11',0),
	 ('Test','User','muhammetsedef134@gmail.com','$2y$10$l43DetuuuPdHgHmv13BomeOCE8d7/EijljPP.EGYnXeUDJdi9A7aK',2,'2021-12-12',0),
	 ('Muhammed','Sedef','muhammetsedef3412@gmail.com','$2y$10$8gwU61cCq.4avwLF8zI4t.OtJMEQqa8iOWGzSAqQNhRgW3b5Qhy1e',2,'2021-12-12',0),
	 ('New','User','new_user@gmail.com','$2y$10$kVFYtCqDimikSGRyp6lS4e14QoQ3BxJaoQncn.33NDaa79CdgMsBq',2,'2021-12-12',0);