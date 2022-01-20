CREATE TABLE `xla_users` (
  `emp_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `personal_email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `office_number` varchar(15) NOT NULL,
  `personal_number` varchar(15) NOT NULL,
  `picture_attachment` varchar(100) NOT NULL,
  `sys_name` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `key` varchar(256) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xla_users`
--

INSERT INTO `xla_users` (`emp_id`, `full_name`, `designation`, `personal_email`, `password`, `office_number`, `personal_number`, `picture_attachment`, `sys_name`, `account_name`, `location`, `key`, `created_at`) VALUES
(1, 'Test', 'Developer', 'demo@gmail.com', '$2a$12$mDgMkYzCC8GX9PtErMxGZuxbAEQVQxcrk7Y8.Kl0eECqExaB0WSB6', '100', '9898989898', 's', 'aa', 'afa', 'India', 'asfasf', '2022-01-20 11:30:00');
