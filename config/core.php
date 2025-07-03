<?php

require_once(__DIR__ . '/config.php');

header('Content-Type: text/html; charset=utf-8');

if (ENV === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

