<?php defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

switch ($_SERVER['SERVER_NAME']) {
    case 'www.incensebatti.com':
    case 'incensebatti.com':
    case 'https://www.incensebatti.com':
    case 'https://incensebatti.com':
        $db['default'] = array(
            'dsn'   => '',
            'hostname' => 'localhost',
            'username' => 'carefajd_cft',
            'password' => '(+TF?d.wOluY',
            'database' => 'carefajd_cft',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => (ENVIRONMENT !== 'production'),
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        break;
    case 'www.demo.denseteklearning.com':
    case 'demo.denseteklearning.com':
    case 'https://www.demo.denseteklearning.com':
    case 'https://demo.denseteklearning.com':
        $db['default'] = array(
            'dsn'   => '',
            'hostname' => 'localhost',
            'username' => 'denseeqq_demo',
            'password' => 'demo@321',
            'database' => 'denseeqq_incensebatti',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => (ENVIRONMENT !== 'production'),
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        break;
    
    default:
        $db['default'] = array(
            'dsn'   => '',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'incensebatti',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => (ENVIRONMENT !== 'production'),
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        break;
}