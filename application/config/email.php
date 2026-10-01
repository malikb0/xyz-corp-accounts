<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| EMAIL SETTINGS (environment-driven)
| -------------------------------------------------------------------
| SMTP credentials are read from the environment so that no secrets
| are stored in the repository. Set MAIL_* in `.env` if email is used.
*/

$config = array(
	'protocol'  => getenv('MAIL_PROTOCOL') ?: '', // 'mail', 'sendmail', or 'smtp'
	'smtp_host' => getenv('MAIL_SMTP_HOST') ?: '',
	'smtp_port' => getenv('MAIL_SMTP_PORT') ?: '',
	'smtp_user' => getenv('MAIL_SMTP_USER') ?: '',
	'smtp_pass' => getenv('MAIL_SMTP_PASS') ?: '',
);
