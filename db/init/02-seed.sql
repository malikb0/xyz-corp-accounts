-- ------------------------------------------------------------------
-- Synthetic test data for local development ONLY.
-- Contains no real client information.
--
-- Login users (one per role, plus the two legacy per-account rules):
--   admin      / admin123       role: admin
--   accountant / accountant123  role: standard
--   addoper    / add123         role: addoper
--   owner      / owner123       role: ronlyowner
--   hr         / hr123          role: hronly
--   asst1      / asst1123       role: account_assistant
--   asst2      / asst2123       role: account_assistant
-- Passwords are stored as unsalted MD5 to match the application's
-- original authentication code.
-- ------------------------------------------------------------------

SET NAMES utf8;

INSERT INTO `tb_sf_login`
    (`sf_id`, `sf_name`, `sf_email`, `sf_password`, `role`, `db_user`, `acnt_id`)
VALUES
    (1, 'admin',      'admin@example.test',      MD5('admin123'),      'admin',      'default', 1),
    (2, 'accountant', 'accountant@example.test', MD5('accountant123'), 'standard',   'default', 2),
    (3, 'addoper',    'addoper@example.test',    MD5('add123'),        'addoper',    'default', 3),
    (4, 'owner',      'owner@example.test',      MD5('owner123'),      'ronlyowner', 'default', 4),
    (5, 'hruser',     'hruser@example.test',     MD5('hr123'),         'hronly',     'default', 5),
    (6, 'asst1',   'asst1@example.test',      MD5('asst1123'),      'account_assistant', 'default', 6),
    (7, 'asst2',   'asst2@example.test',      MD5('asst2123'),      'account_assistant', 'default', 7);

INSERT INTO `tb_accounts`
    (`account_id`, `account_name`, `address1`, `address2`, `address3`, `address4`,
     `arabic_name`, `arabic_address`, `phones`, `fax`, `contact_person`,
     `contact_person_phone`, `account_type`, `bank_details`, `vat_reg_no`, `account_balance`)
VALUES
    (1, 'Cash In Hand', 'Head Office', '', '', '', '', '', '', '', '', '', 'cash_inhand', '', '', 1000.0000),
    (2, 'Office Expenses', 'Head Office', '', '', '', '', '', '', '', '', '', 'expense', '', '', -250.0000);
