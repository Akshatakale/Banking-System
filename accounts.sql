-- To create accounts table;
CREATE TABLE `accounts` (
  `name` varchar(255) NOT NULL,
  `acc_no` bigint(11) NOT NULL,
  `balance` bigint(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,     
  `gender` varchar(255) NOT NULL,
  `acc_type` varchar(255) NOT NULL,
  `IFSC` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP NOT NULL
);
-- Add primary key acc_no;
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_no`);

-- Auto increment account no;
ALTER TABLE `accounts`
  MODIFY `acc_no` bigint(11) NOT NULL AUTO_INCREMENT;
COMMIT;

-- To create Transaction Table;
CREATE TABLE `accounts`(
  `sender_acc_no` bigint(11) NOT NULL,
  `receiver_acc_no` bigint(11) NOT NULL,
  `amount` bigint(11) NOT NULL,
  `sender_balance` bigint(11) NOT NULL,
  `receiver_balance` bigint(11) NOT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP NOT NULL
)
