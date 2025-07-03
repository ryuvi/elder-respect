<?php

// ENV
define('ENV', 'dev');

// DATABASE
define('DB_HOST', ENV === 'dev' ? 'db' : 'localhost');
define('DB_NAME', 'carroaki');
define('DB_USER', 'admin');
define('DB_PASS', 'admin');
define('DB_CHARSET', 'utf8mb4');

// PROJECT
define('SITE_NAME', 'dummy');
define('BASE_URL', '');
define('OG_IMAGE', BASE_URL . 'img/og-image.jpg');

// Configs
date_default_timezone_set('America/Sao_Paulo');

// mb_internal_encoding("UTF-8");
// mb_http_output("UTF-8");
// mb_regex_encoding("UTF-8");

setlocale(LC_ALL, 'pt_BR.UTF-8');

ini_set('default_charset', 'UTF-8');

