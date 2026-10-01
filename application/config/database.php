<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS (environment-driven)
| -------------------------------------------------------------------
| Credentials are read from the environment so that no secrets are
| stored in the repository. Copy `.env.example` to `.env` and set the
| values before starting the app (see docker-compose.yml).
|
|   DB_HOST, DB_PORT, DB_NAME          -> shared connection settings
|   DB_USER, DB_PASSWORD               -> fallback for every group
|   DB_<GROUP>_USER, DB_<GROUP>_PASSWORD -> per-group override
|
| The application keeps the original multi-tenant design: the login
| row carries a `db_user` value which is used to pick one of the
| connection groups below (each group can map to a separate MySQL
| account). For local testing all groups may point at one account by
| leaving the per-group variables unset.
*/

$active_group  = getenv('DB_ACTIVE_GROUP') ?: 'default';
$query_builder = TRUE;

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_port = getenv('DB_PORT') ?: '3306';
$db_name = getenv('DB_NAME') ?: 'xyz_corp_db';

$db_base = array(
	'dsn'        => '',
	'hostname'   => $db_host,
	'port'       => (int) $db_port,
	'username'   => getenv('DB_USER') ?: 'xyz_user',
	'password'   => getenv('DB_PASSWORD') ?: '',
	'database'   => $db_name,
	'dbdriver'   => 'mysqli',
	'dbprefix'   => '',
	'pconnect'   => FALSE,
	'db_debug'   => (ENVIRONMENT !== 'production'),
	'cache_on'   => FALSE,
	'cachedir'   => '',
	'char_set'   => 'utf8',
	'dbcollat'   => 'utf8_general_ci',
	'swap_pre'   => '',
	'encrypt'    => FALSE,
	'compress'   => FALSE,
	'stricton'   => FALSE,
	'failover'   => array(),
	'save_queries' => TRUE,
);

/* Connection-group name => environment-variable prefix. */
$db_groups = array(
	'default'   => 'DEFAULT',
	'appuser'   => 'APPUSER',
	'readonly'  => 'READONLY',
	'acctmgr'   => 'ACCTMGR',
	'appadmin'  => 'APPADMIN',
	'cruonly'   => 'CRUONLY',
);

foreach ($db_groups as $group => $prefix) {
	$db[$group] = $db_base;

	$group_host = getenv("DB_{$prefix}_HOST");
	$group_user = getenv("DB_{$prefix}_USER");
	$group_pass = getenv("DB_{$prefix}_PASSWORD");

	if ($group_host !== FALSE) {
		$db[$group]['hostname'] = $group_host;
	}
	if ($group_user !== FALSE) {
		$db[$group]['username'] = $group_user;
	}
	if ($group_pass !== FALSE) {
		$db[$group]['password'] = $group_pass;
	}
}
